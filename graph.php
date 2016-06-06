<?php


include('lib/GraphOutputBuilder.php');
include('lib/GraphOutputBuilderSvg.php');
include('lib/Polynomials.php');
include('lib/GameMechanics.php');
include('lib/GraphPlotter.php');
include('lib/ParseQueries.php');

global $cm, $parameters;


function parse_dice($input, $limit = 0)
{
	preg_match("#^(\d*)((d3|d6|a)(\.(\d+))?)?#", $input, $parts);
	$amount = ($parts[1] == "")? 1 : $parts[1];
	$fixed = (isset($parts[5]))? $parts[5] : 0;
	if(isset($parts[2])) {
		switch($parts[3]) {
			case 'd3': return dice_outcomes($amount, 3 ,$fixed, $limit);
			case 'd6': return dice_outcomes($amount, 6 ,$fixed, $limit);
			case 'a': return artillery_outcomes($amount, $fixed, $limit);
		}	
	}
	if($limit == 0) {
		return array($amount=>1);
	} else {
		return array(min($amount, $limit) => 1);
	}
}



function rolls_to_poly($rolls, $modifiers = '0000')
{
	$chance = 1;
	if($rolls[0]>6) {
		$chance *= roll_to_chance($rolls[0]);
	} else {
		$chance *= ($modifiers[0] == "3")? roll_chance(max(0,$rolls[0]-1), $rolls[0], 7) : roll_chance($modifiers[0], $rolls[0], 7);
	}
	$chance *= ($modifiers[1] == "3")? roll_chance(max(0,$rolls[1]-1), $rolls[1], 7) : roll_chance($modifiers[1], $rolls[1], 7);
	if($rolls[2] > 0) {
		$chance *= ($modifiers[2] == "3")? 1- roll_chance(max(0,$rolls[2]-1), $rolls[2], 7) : 1-roll_chance($modifiers[2], $rolls[2], 7);
	}
	if(isset($rolls[3]) && $rolls[3] >0) {
		$chance *= ($modifiers[3] == "3")? 1- roll_chance(max(0,$rolls[3]-1), $rolls[3], 7) : 1-roll_chance($modifiers[3], $rolls[3], 7);
	}	
	return array(
		0=> (1-$chance),
		1=> $chance
	);
}

function parse_aos_rolls($data) 
{

	$pwound = 1;
	// hit
	$pHit =  roll_interval($data['hitroll'], 7) ;
	$pReHit = roll_interval(0, ($data['hitreroll'] == 3)? $data['hitroll'] - 1 : min($data['hitreroll'], $data['hitroll']-1));
	$pHitTotal = $pHit * (1+$pReHit);
	$pWound = roll_interval($data['woundroll'], 7) ;
	$pReWound = roll_interval(0, ($data['woundreroll'] == 3)? $data['woundroll'] - 1 : min($data['woundreroll'], $data['woundroll']-1));
	$pWoundTotal =  $pWound * (1+$pReWound);
	$pSave = ($data['saveroll'] == 0)? 0 : roll_interval($data['saveroll'], 7);
	$pReSave = roll_interval(0, ($data['savereroll'] == 3)? $data['saveroll'] - 1 : min($data['savereroll'], $data['saveroll']-1));
	$pSaveTotal = $pSave * (1+$pReSave);
	
	
	$pSingleWound = $pHitTotal * $pWoundTotal * (1-$pSaveTotal);
	
	$attacks = parse_dice($data['attempts']);
	$damage = parse_dice($data['damage']);
	$rules = $data['rules'];
	
	$total = substitute_polynomial($attacks, substitute_polynomial(
		[0=> (1-$pSingleWound), 1=>$pSingleWound], $damage));
	return $total;
}

function parse_8th_rolls($data) 
{
	$attacks = parse_dice($data['attempts']);
	$multiple_wounds =   parse_dice($data['multiwounds'], $data['wounds']);
	$pPoison = (in_array('1', $data['rules']) && ($data['hitroll'] < 7))? 1/6 : 0;
	$pHit = ($data['hitroll'] < 7) ? 
		roll_interval($data['hitroll'], ($pPoison > 0)? 6 : 7) 
		: 1/6 * roll_interval($data['hitroll'] - 3, 7);
	$pReHit = ($data['hitreroll'] == 0)? 0 : ($data['hitreroll'] == 3) ? roll_interval(1,$data['hitroll']) : roll_interval(0,$data['hitreroll']);
	$pPoison *= (1+$pReHit);
	$pHit *= (1+$pReHit);
	$pKillingBlow = (in_array('2',  $data['rules']))? 1/6 : 0;
	$pWound = roll_interval($data['woundroll'], ($pKillingBlow > 0)? 6 : 7) ;
	$pReWound = ($data['woundreroll'] == 0)? 0 : ($data['woundreroll'] == 3) ? roll_interval(1,$data['woundroll']) : roll_interval(0,$data['woundreroll']);
	$pKillingBlow *= (1+$pReWound);
	$pWound *= (1+$pReWound);
	$pSave = ($data['saveroll'] == 0)? 0 : roll_interval($data['saveroll'], 7);
	$pReSave = ($data['savereroll'] == 0)? 0 : ($data['savereroll'] == 3) ? roll_interval(1,$data['saveroll']) : roll_interval(0,$data['savereroll']);
	$pSave *= (1+$pReSave);
	$pWard = ($data['wardroll'] == 0)? 0 : roll_interval($data['wardroll'], 7);
	$pHolyAttacks = (in_array('3', $data['rules']))? $pWard : 0;
	$pReWard = ($data['wardreroll'] == 0)? 0 : ($data['wardreroll'] == 3) ? roll_interval(1,$data['wardroll']) : roll_interval(0,$data['wardreroll']);
	$pWard = ($pWard - $pHolyAttacks) + $pWard * ($pHolyAttacks + $pReWard);
	
	
	$pSingleWound = 
		($pPoison + $pHit * $pWound) * (1-$pSave) * (1-$pWard);
	$pKillingWound =  $pHit * $pKillingBlow * (1-$pWard);
	$pFail = 1 - $pSingleWound - $pKillingWound;
	$pWoundsPerAttack =  substitute_polynomial(array($pFail, $pSingleWound), $multiple_wounds);
	$pWoundsPerAttack[$data['wounds']]  = isset($pWoundsPerAttack[$data['wounds']])? $pWoundsPerAttack[$data['wounds']] + $pKillingWound : $pKillingWound;
	

	$total = substitute_polynomial($attacks, $pWoundsPerAttack);
	return $total;
}



function parse_9th_rolls($data) 
{
	$attacks = parse_dice($data['attempts']);
	$multiple_wounds =   parse_dice($data['multiwounds'], $data['wounds']);
	$pPoison = (in_array('1', $data['rules']) && ($data['hitroll'] < 7))? 1/6 : 0;
	$pHit = ($data['hitroll'] < 7) ? 
		roll_interval($data['hitroll'], ($pPoison > 0)? 6 : 7) 
		: 1/6 * roll_interval($data['hitroll'] - 3, 7);
	$pReHit = ($data['hitreroll'] == 0)? 0 : ($data['hitreroll'] == 3) ? roll_interval(1,$data['hitroll']) : roll_interval(0,$data['hitreroll']);
	$pPoison *= (1+$pReHit);
	$pHit *= (1+$pReHit);
	$pLethalStrike = (in_array('2',  $data['rules']))? 1/6 : 0;
	$pWound = roll_interval($data['woundroll'], ($pLethalStrike > 0)? 6 : 7) ;
	$pReWound = ($data['woundreroll'] == 0)? 0 : ($data['woundreroll'] == 3) ? roll_interval(1,$data['woundroll']) : roll_interval(0,$data['woundreroll']);
	$pLethalStrike *= (1+$pReWound);
	$pWound *= (1+$pReWound);
	$pSave = ($data['saveroll'] == 0)? 0 : roll_interval($data['saveroll'], 7);
	$pReSave = ($data['savereroll'] == 0)? 0 : ($data['savereroll'] == 3) ? roll_interval(1,$data['saveroll']) : roll_interval(0,$data['savereroll']);
	$pSave *= (1+$pReSave);
	$pWard = ($data['wardroll'] == 0)? 0 : roll_interval($data['wardroll'], 7);
	$pHolyAttacks = (in_array('3', $data['rules']))? $pWard : 0;
	$pReWard = ($data['wardreroll'] == 0)? 0 : ($data['wardreroll'] == 3) ? roll_interval(1,$data['wardroll']) : roll_interval(0,$data['wardreroll']);
	$pWard = ($pWard - $pHolyAttacks) + $pWard * ($pHolyAttacks + $pReWard);
	
	$pKill = 
		(($pPoison + $pHit * $pWound) * (1-$pSave) + $pHit * $pLethalStrike) * (1-$pWard);

	$total = substitute_polynomial($attacks, substitute_polynomial(array(1-$pKill, $pKill), $multiple_wounds));
	return $total;
}



function parse_8th_stats($data) 
{
	$total = [0=>1];
	forEach($data['attackers'] as $attacker) {
		$roll_hit = 4;
		if($attacker['ws'] > $data['defender']['ws']) {
			$roll_hit = 3;
		} else if(($attacker['ws']*2) < $data['defender']['ws']) {
			$roll_hit = 5;
		}
		$roll_wound = min(6,max(2,(4 + $attacker['s'] - $data['defender']['t'])));
		$roll_armour = min(7,max(2,($data['defender']['as'] + max(0, $attacker['s'] - 3))));
		$roll_ward = $data['defender']['ward'];
		
		$attacks = parse_dice($attacker['attacks']);
		$wound_per_attack =  parse_dice($attacker['multiplewounds'], $data['defender']['w']);
		
		$rules = array();
		
		$pPoison = (in_array('1', $rules) && ($rolls[0] < 7))? 1/6 : 0;
		$pHit = roll_interval($roll_hit, ($pPoison > 0)? 6 : 7);
		$pReHit = 0;
		$pPoison *= (1+$pReHit);
		$pHit *= (1+$pReHit);
		$pKillingBlow = (in_array('2', $rules))? 1/6 : 0;
		$pWound = roll_interval($roll_wound, ($pKillingBlow > 0)? 6 : 7);
		$pReWound = 0;
		
		$pKillingBlow *= (1+$pReWound);
		$pWound *= (1+$pReWound);
		$pSave = roll_interval($roll_armour, 7);
		$pReSave = 0;
		$pSave *= (1+$pReSave);
		$pWard = roll_interval($roll_ward, 7);
		$pTrickster = (in_array('3', $rules))? $pWard : 0;
		$pReWard = 0;
		$pWard = ($pWard - $pTrickster) + $pWard * ($pTrickster + $pReWard);
		
		$pSingleWound = 
			($pPoison + $pHit * $pWound) * (1-$pSave) * (1-$pWard);
		$pKillingWound =  $pHit * $pKillingBlow * (1-$pWard);
		$pFail = 1 - $pSingleWound - $pKillingWound;
		$pWoundsPerAttack =  substitute_polynomial(array($pFail, $pSingleWound), $wound_per_attack);
		$pWoundsPerAttack[$data['defender']['w']]  = isset($pWoundsPerAttack[$data['defender']['w']])? $pWoundsPerAttack[$data['defender']['w']] + $pKillingWound : $pKillingWound;
		$total = multiply_polynomials($total, substitute_polynomial($attacks, $pWoundsPerAttack));
	}
//	echo "Hit: ". $pHit . "\r\nWound:" . $pWound . "\r\nSave: ".$pSave."\r\nWard: ".$pWard;
	
	return $total;
}


forEach($parameters as $key=>$parameter) {
	switch($parameter['type']) {
		case 'p': 
			$distributions[] =  array(
				"source"=>"p", 
				"info"=>array(), 
				"distribution"=> substitute_polynomial(parse_dice($parameter['dice']), $parameter['p'])); 
			break;
		case 'b': 
			$distributions[] = array(
				"source"=>"b", 
				"info"=>array(), 
				"distribution"=> substitute_polynomial(
									parse_dice($parameter['attempts']), 
									substitute_polynomial(
										array(1-$parameter['pwound'], $parameter['pwound']), 
										parse_dice($parameter['damage'], $parameter['wounds'])))); 
			break;
		case 'a': 
			$distributions[] = array(
				"source"=>"a", 
				"info"=>array(), 
				"distribution"=> substitute_polynomial(
									array(1-$parameter['poccur'], $parameter['poccur']), 
									parse_dice($parameter['wounds']))); 
			break;
		case 'r': 
			$distributions[] = array(
				"source"=>"r", 
				"info"=>array(), 
				"distribution"=> parse_aos_rolls($parameter));
			break;
		case 'r8':
			$distributions[] = array(
				"source"=>"r8", 
				"info"=>array(), 
				"distribution"=>  parse_8th_rolls($parameter));
			break;
		case 'r9':
			$distributions[] = array(
				"source"=>"r9", 
				"info"=>array(), 
				"distribution"=>  parse_9th_rolls($parameter));
			break;
		case 's8':
			$distributions[] = array(
				"source"=>"s8", 
				"info"=>array(), 
				"distribution"=>  parse_8th_stats($parameter));
			break;
		default: break;
	}
}






$summary = array();

if(count($distributions) > 0) {
	$summary[0] = 1;
	forEach($distributions as $distribution) {
		$summary = multiply_polynomials($summary, $distribution["distribution"]);
	}
}

$form_exp = '([csirav]{1,6})';
$form = (isset($_GET['f']) and preg_match("#^$form_exp$#", $_GET['f']))? str_split($_GET['f'],1): array('i','s') ;

$threshold_exp = '\d(\.\d{1,5})?';
$threshold = (isset($_GET['t']) and preg_match("#^$threshold_exp$#", $_GET['t']))? $_GET['t'] : 0.008 ;


$style_number = (isset($_GET['s']) and preg_match("#^[0-4]$#", $_GET['s']))? $_GET['s']: 0 ;
$styles = array("default", "druchiinet", "furnace", "none", "9thage");
$style = $styles[$style_number];


/**
Styling 
c -> cumulative
s -> summary
r -> reduction
i -> individual scores
v -> variance
*/


$plotter = new GraphPlotter();
$builder = new GraphOutputBuilderSvg();
$builder->setStyle($style);
$plotter->setBuilder($builder);
$plotter->setResults($summary, $threshold);

forEach($form as $toPlot) {
	switch($toPlot) {
		case 'c': $plotter->plotCummulativeScores(); break;
		case 's': $plotter->plotSummary(false); break;
		case 'a': $plotter->plotSummary(true); break;
		case 'i': $plotter->plotScores(); break;
		case 'r': $plotter->plotReductionScores();break;
		case 'v': $plotter->plotVariance();break;
	}
}

forEach($cm->getMessages() as $message) {
	$plotter->plotMessage($message->getType(), $message->getType(), $message->getMessage());
}

$plotter->plotMessages();


header("Content-type: ".$builder->getContentType());

echo $builder->getContent();


?>


