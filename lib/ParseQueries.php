<?php


$perc_exp = "(1|\d\.\d{1,10}|\d+\.\.\d+)";
$num_exp = "\d+";
$d_exp = "\d*(d[36]|a)(\.\d+)?";
$dice_exp = "(\d{0,2})((d3|d6|a)(\.(\d{1,2}))?)?";
$modifier_exp = "m[0-3]{3,4}";
$rules_exp = "r\w+(\.\w+)*";
$polynomial_exp = "p(\:$perc_exp)+\:$dice_exp";
$binomial_exp = "b\:$perc_exp\:$dice_exp(\:$dice_exp\:$num_exp)?";
$autowounds_exp = "a\:$perc_exp\:$dice_exp";


$roll_exp = "r\:\d{3}\:$dice_exp(\:$dice_exp)?(\:$modifier_exp)?(\:$rules_exp)?";
$roll8_exp = "r8\:\d{3,4}\:$dice_exp(\:$dice_exp\:\d{1,2})?(\:$modifier_exp)?(\:$rules_exp)?";
$roll9_exp = "r9\:\d{3,4}\:$dice_exp(\:$dice_exp\:\d{1,2})?(\:$modifier_exp)?(\:$rules_exp)?";

$attacker_stats = '\d(\.\d){1}';
$attacker_exp = "a\:$attacker_stats\:$dice_exp\:$dice_exp(\:$rules_exp)?";
$defender_stats = "\d(\.\d){4}";
$defender_exp = "d\:$defender_stats(\:$rules_exp)?";
$stats8_exp = "s8(\:$attacker_exp){1,10}\:$defender_exp";

$one_valid_exp = "($polynomial_exp|$binomial_exp|$roll_exp|$roll8_exp|$roll9_exp|$stats8_exp)";
$valid_chars="[0-9\.\:adrmbps]";
$one_valid_exp = "$valid_chars+";


$queries = (isset($_GET['q']) and preg_match("#^$one_valid_exp(;$one_valid_exp){0,20}$#", $_GET['q']))? explode(';', $_GET['q']) : array();

//print_r($queries);



$distributions = array();

class ContentMessage {
	private $type;
	private $message;
	
	public function __construct($type, $message) {
		$this->type = $type;
		$this->message = $message;		
	}
	public function getType() {
		return $this->type;
	}
	
	public function getMessage() {
		return $this->message;
	}
}

/**
 * 
 */
class ContentManager
{
	private $messages = array();
	
	public function __construct(){
	
	}	
	public function addMessage($type, $message) {
		$this->messages[] = new ContentMessage($type, $message);
	}
	public function getMessages() {
		return $this->messages;
	}
		
}
global $cm;
$cm = new ContentManager();

$parameters = array();
forEach($queries as $key=>$query) {
	$bits = explode(":", $query);
	$input['type'] = $bits[0];
	$input['query'] = $query;
	switch($bits[0]) {
		case 'p': 
			if(preg_match("#^$polynomial_exp$#", $query)) {
				$dice = array_pop($bits); 
				$input['dice'] =  $dice; 
				$input['p'] = array_slice($bits, 1);
				$parameters[$key] = $input;
			} else {
				$cm->addMessage('error', "Polynomial expression, #".($key+1)." was invalid and dropped.");
			}
			break;
		case "b":
			if(preg_match("#^$binomial_exp$#", $query)) {
				$input['pwound'] = $bits[1];
				$input['attempts'] = $bits[2];
				$input['damage'] = (isset($bits[3]))? $bits[3] : 1; 
				$input['wounds'] = (isset($bits[4]))? $bits[4] : 0; 
				$parameters[$key] = $input;
			} else {
				$cm->addMessage('error', "Generic expression, #".($key+1)." was invalid and dropped.");
			}
			break;
		case "a":
			if(preg_match("#^$autowounds_exp$#", $query)) {
				$input['poccur'] = $bits[1];
				$input['wounds'] = $bits[2];
				$parameters[$key] = $input;
			} else {
				$cm->addMessage('error', "Auto wounds expression, #".($key+1)." was invalid and dropped.");
			}
			break;
		case "r":		
			if(preg_match("#^$roll_exp$#", $query, $matches)) {
				//print_r($matches);
				$input['hitroll'] = $bits[1][0];
				$input['woundroll'] = $bits[1][1];
				$input['saveroll'] = $bits[1][2];
				$input['attempts'] = $bits[2];

				$input['hitreroll'] = 0;
				$input['woundreroll'] = 0;
				$input['savereroll'] = 0;
				$input['rules'] = [];
				$input['damage'] = 1;
				
				for($i=3;$i<sizeof($bits); $i++) {
					switch($bits[$i][0]) {
						case 'm':
							$input['hitreroll'] = $bits[$i][1]; 
							$input['woundreroll'] = $bits[$i][2]; 
							$input['savereroll'] = $bits[$i][3]; 
							break;
						case 'r':
							$input['rules'] = expode(".", $bits[$i]);
							break;
						default:
							$input['damage'] = $bits[$i]; 							
					}
				}
				$parameters[$key] = $input;
			} else {
				$cm->addMessage('error', "Age of Sigmar roll expression, #".($key+1)." was invalid and dropped.");
			}
			break;
		case "r8":
			if(preg_match("#^$roll8_exp$#", $query)) {
				$input['hitroll'] = $bits[1][0];
				$input['woundroll'] = $bits[1][1];
				$input['saveroll'] = $bits[1][2];
				$input['wardroll'] = (isset($bits[1][3]))? $bits[1][3] : 0;
				$input['attempts'] = $bits[2];
				$input['hitreroll'] = 0; 
				$input['woundreroll'] = 0; 
				$input['savereroll'] = 0; 
				$input['wardreroll'] =  0; 
				$input['multiwounds'] = 1; 
				$input['wounds'] = 0; 
				$input['rules'] = []; 
				for($i=3;$i<sizeof($bits); $i++) {
					switch(substr($bits[$i],0,1)) {
						case 'm': 
							$input['hitreroll'] = (isset($bits[$i][1]))? $bits[$i][1] : $bits['hitreroll']; 
							$input['woundreroll'] = (isset($bits[$i][2]))? $bits[$i][2] : $bits['woundreroll']; 
							$input['savereroll'] = (isset($bits[$i][3]))? $bits[$i][3] : $bits['savereroll']; 
							$input['wardreroll'] = (isset($bits[$i][4]))? $bits[$i][4] : $bits['wardreroll']; 
							break;
						case 'r': 
							$input['rules'] = explode(".", substr($bits[$i],1)); break;
						default: 
							if(isset($bits[$i+1])) {
								$input['multiwounds'] = $bits[$i]; 
								$input['wounds'] =  $bits[++$i];
							}
					}
				}
				$parameters[$key] = $input;
			} else {
				$cm->addMessage('error', "Warhammer roll expression, #".($key+1)." was invalid");
			}
			break;
		case "r9":
			if(preg_match("#^$roll9_exp$#", $query)) {
				$input['hitroll'] = $bits[1][0];
				$input['woundroll'] = $bits[1][1];
				$input['saveroll'] = $bits[1][2];
				$input['wardroll'] = (isset($bits[1][3]))? $bits[1][3] : 0;
				$input['attempts'] = $bits[2];
				
				$input['hitreroll'] = 0; 
				$input['woundreroll'] = 0; 
				$input['savereroll'] = 0; 
				$input['wardreroll'] =  0; 
				$input['multiwounds'] = 1; 
				$input['wounds'] = 0; 
				$input['rules'] = []; 

				for($i=3;$i<sizeof($bits); $i++) {
					switch(substr($bits[$i],0,1)) {
						case 'm': 
							$input['hitreroll'] = (isset($bits[$i][1]))? $bits[$i][1] : $bits['hitreroll']; 
							$input['woundreroll'] = (isset($bits[$i][2]))? $bits[$i][2] : $bits['woundreroll']; 
							$input['savereroll'] = (isset($bits[$i][3]))? $bits[$i][3] : $bits['savereroll']; 
							$input['wardreroll'] = (isset($bits[$i][4]))? $bits[$i][4] : $bits['wardreroll']; 
							break;
						case 'r': 
							$input['rules'] = explode(".", substr($bits[$i],1)); break;
						default: 
							if(isset($bits[$i+1])) {
								$input['multiwounds'] = $bits[$i]; 
								$input['wounds'] =  $bits[++$i];
							}
					}
				}
				$parameters[$key] = $input;
			} else {
				$cm->addMessage('error', "9th Age roll expression, #".($key+1)." was invalid");
			}
			break;
			
			
		case "s8":
			if(preg_match("#^$stats8_exp$#", $query)) {
				$i = 0;
				$input['attackers'] = [];
				while($bits[++$i] == 'a') {
					$att_stats = explode('.',$bits[++$i]);
					$attacker['ws'] = $att_stats[0];
					$attacker['s'] = $att_stats[1];
					$attacker['multiplewounds'] = $bits[++$i];
					$attacker['attacks'] = $bits[++$i];
					$attacker['rules'] = [];
					$input['attackers'][] = $attacker;
				}
				$def_stats = explode('.',$bits[++$i]);
				$defender['ws'] =  $def_stats[0];
				$defender['t'] =  $def_stats[1];
				$defender['as'] =  $def_stats[2];
				$defender['ward'] =  $def_stats[3];
				$defender['w'] =  $def_stats[4];
				$defender['rules'] = [];
				$input['defender'] = $defender;				
				$parameters[$key] = $input;
			} else {
				$cm->addMessage('error', "Warhammer Stats expression, #".($key+1)." was invalid");
			}
			break;
				
			
			
		default:
			$cm->addMessage('error', "Invalid form $key omitted.");
			break;			
	}
}


/*
print_r($parameters);
print_r($cm);
*/





?>