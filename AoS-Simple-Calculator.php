<?php 
$title = "Druchii.net - Age of Sigmar Simple Calculator";
$description = "Analytical tool for computing the performance of troops in Age of Sigmar.";
include "templates/header.php";


$dice_exp = "(\d{0,2})((d3|d6|a)(\.(\d{1,2}))?)?";
$modifier_exp = "m[0-3]{3,4}";
$rules_exp = "r\w+(\.\w+)*";
$roll_exp = "r\:\d{3}:$dice_exp(\:$dice_exp)?(\:$modifier_exp)?(\:$rules_exp)?";
$query = (isset($_GET['q']) and preg_match("#^$roll_exp$#", $_GET['q']))? $_GET['q'] : 'r:335:10';

$format_exp = '([csirav]{1,6})';
$format = (isset($_GET['f']) and preg_match("#^$format_exp$#", $_GET['f']))? str_split($_GET['f'],1): array('i','s') ;

$style_number = (isset($_GET['s']) and preg_match("#^[0-4]$#", $_GET['s']))? $_GET['s']: 0 ;

$fullquery = "q=" . $query 
	. ((implode('',$format) == 'is')? '' : '&f=' . implode('',$format))
	. (($style_number == 0)? '' : "&s=$style_number");



$data = explode(':', $query);

$modifiers = "000";
$rules = array();
$damage = 1;
$i = 3;

if(isset($data[$i]) && preg_match("#^$dice_exp$#", $data[$i])) {
	$damage = $data[$i++];
}
if(isset($data[$i]) && preg_match("#^$modifier_exp$#", $data[$i])) {
	$modifiers = substr($data[$i++],1);
}
if(isset($data[$i]) && preg_match("#^$rules_exp$#", $data[$i])) {
	$rules = explode(".", substr($data[$i++],1)); 
}



function dicename($data) {
	switch($data) {
		case 0: return '#dnone';break;
		case 1: return '#dauto';break;
		default: return '#d'.$data;break;
	}
	return '#dnone';
}


?>


<div class="container">

	<div class="page-header">
		<h1>Age of Sigmar Simple Combat Calculator</h1>
		<p class="lead">
			Calculate the combat statistics for a model or unit with a simple attack profile. 
		</p>
	</div>
	<div class="alert alert-danger" role="alert">
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	All "Simple" calculators will phase be replaced by their multi-profile counterparts. <a href="#pagelinks">The page link</a> below, will bring you to the new calculator, with all settings preserved.
	</div>

	<div class="row">
	<div class="col-xs-4 col-sm-2">
		<h4>To hit</h4>
		<svg class="large-dice" viewBox="0 0 100 100">
			<use id="hitroll" xlink:href="images/iconpack.svg<?php echo dicename($data[1][0]);?>"></use>
		</svg>
		<br/>
		<button id="hitreroll" class="btn-reroll btn btn-md btn-default">No re-rolls</button>
	</div>
	<div class="col-xs-4 col-sm-2">
		<h4>Wound</h4>
		<svg class="large-dice" viewBox="0 0 100 100">
			<use id="woundroll" xlink:href="images/iconpack.svg<?php echo dicename($data[1][1]);?>"></use>
		</svg>
		<br/>
		<button id="woundreroll" class="btn-reroll btn btn-md btn-default">No re-rolls</button>
	</div>
	<div class="col-xs-4 col-sm-2">
		<h4>Save</h4>
		<svg class="large-dice" viewBox="0 0 100 100">
			<use id="saveroll" xlink:href="images/iconpack.svg<?php echo dicename($data[1][2]);?>"></use>
		</svg>
		<br/>
		<button type="button" id="savereroll" class="btn-reroll btn btn-md btn-default">No re-rolls</button>		
	</div>
	</div>	
	
	<div  class="row">
	<p></p>
	</div>	
	
	<div  class="row">
	<div class="col-xs-4 col-sm-2 form-group" id="damagegroup">
		<label class="control-label" for="damage"><h4>Damage</h4></label>
		<input type="text" class="form-control " name="damage" id="damage" value="<?php echo $damage;?>"  title="A number or dice exp like 10 or 2d3+1"/>
	</div>
	
	<div class="col-xs-4 col-sm-2 form-group" id="attemptsgroup">
		<label class="control-label" for="attempts"><h4>Attacks</h4></label>
		<input type="text" class="form-control " name="attempts" id="attempts" value="<?php echo $data[2];?>" title="A number or dice exp like 10 or 2d3+1"/>
	</div>
	
	<div class="col-xs-4 col-sm-2">
		<h4>&nbsp;</h4>
		<button class="btn btn-primary" id="calculate">Calculate!</button>
	</div>
	</div>
	
	<div  class="row">
	<p></p>
	</div>
	
	<div  class="row">
	<div class="col-xs-12 col-sm-6">
		<p><span class="label label-info">Tip:</span> Click the dice until they have the required roll values. For damage and attacks you can give any number below 100 but also dice based numbers like d6, 1d6+2, 2d3+2 or 2a+1.</p>
	</div>
	</div>

	<h2>Chance per damage done</h2>
	
	<div class="row">
	<div class="col-xs-12 graphcontainer">			
		<img id="resultGraph" src="graph.php?<?php echo $fullquery;?>" />		
	</div>
	</div>
	
	<div  class="row" style="height:20px">
	<p></p>
	</div>	
	
	<a name="pagelinks"></a>
	<div class="btn-toolbar" role="toolbar">
	<div class="btn-group">
		<a class="btn btn-primary" id="linkpage" target="_blank" title="Open this calculation in the new multiprofile calculator" href="AoS-Combat-Calculator.php?<?php echo $fullquery;?>"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span> Page</a>
		<a class="btn btn-default" id="linkimage" target="_blank" title="Open image in new window" href="graph.php?<?php echo $fullquery;?>"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> Image</a>
		<a class="btn btn-default" id="linkfullimage" target="_blank" title="Open image in new window" href="graph.php?<?php echo $fullquery;?>"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> Full Image</a>
	</div>
	</div>
	
	<div  class="row" style="height:20px">
	<p></p>
	</div>
	
	<div  class="row">
		<div class="col-xs-12 col-sm-6">
		<p><span class="label label-info">Note:</span> 
		The tool filters non-relevant outcomes. The &quot;full image&quot; offers all details, to compare two different results. </p>
		</div>
	</div>
	
<?php include "templates/configure.php" ; ?>
	
	
	
</div>

	
	



<script src="js/dtUi.js"></script>
<script>

var hitReRoller = dtUi.makeButtonRollController(document.getElementById('hitreroll'), 
	["No re-rolls", "Re-roll 1", "Re-roll 1,2", "Re-roll fails"],
	[ 0, 1, 2, 3],
	<?php echo $modifiers[0];?>, 
	'btn-activated'
	);
var woundReRoller = dtUi.makeButtonRollController(document.getElementById('woundreroll'),
	["No re-rolls", "Re-roll 1", "Re-roll 1,2", "Re-roll fails"],
	[ 0, 1, 2, 3],
	<?php echo $modifiers[1];?>, 
	'btn-activated'
	);
var saveReRoller = dtUi.makeButtonRollController(document.getElementById('savereroll'),
	["No re-rolls", "Re-roll 1", "Re-roll 1,2", "Re-roll fails"],
	[ 0, 1, 2, 3],
	<?php echo $modifiers[2];?>, 
	'btn-activated'
	);
var hitRoller = dtUi.makeDiceRollController(document.getElementById('hitroll'), 'images/iconpack.svg', 
	["#dauto",	"#d2",	"#d3",	"#d4",	"#d5",	"#d6"],
	[1, 		2, 		3, 		4, 		5, 		6],
	<?php echo $data[1][0]?>);
var woundRoller = dtUi.makeDiceRollController(document.getElementById('woundroll'), 'images/iconpack.svg', 
	["#dauto",	"#d2",	"#d3",	"#d4",	"#d5",	"#d6"],
	[1, 		2, 		3, 		4, 		5, 		6],
	<?php echo $data[1][1]?>);
var saveRoller = dtUi.makeDiceRollController(document.getElementById('saveroll'), 'images/iconpack.svg', 
	["#dnone",	"#d2",	"#d3",	"#d4",	"#d5",	"#d6"],
	[0, 		2, 		3, 		4, 		5, 		6],
	<?php echo $data[1][2]?>);

var damage = document.getElementById("damage");
var attempts = document.getElementById("attempts");
var resultGraph = document.getElementById("resultGraph");
var linkpage = document.getElementById("linkpage");
var linkimage = document.getElementById("linkimage");
var linkfullimage = document.getElementById("linkfullimage");



var reportChecker = dtUi.makeCheckGroupController(document.getElementsByName('reporttype'));
var colourChecker = dtUi.makeCheckGroupController(document.getElementsByName('colourscheme'));


dtUi.addRegExpValidator(damage, dtUi.regExDice, document.getElementById('damagegroup'));
dtUi.addRegExpValidator(attempts, dtUi.regExDice, document.getElementById('attemptsgroup'));

var query =  "<?php echo $query;?>";
var config = "&f=<?php echo implode('',$format);?>";


var updateImage = function() {
	query = "r:" + hitRoller.getValue() + woundRoller.getValue() + saveRoller.getValue() 
			+ ":" + attempts.value.replace('+','.') + ":" + damage.value.replace('+','.')
			+ ":m" + hitReRoller.getValue() + woundReRoller.getValue() + saveReRoller.getValue();
	
	config = ""
		+ (((reportChecker.getValues().join('') =="is") || (reportChecker.getValues().join('') =="")) ? "" : "&f="+reportChecker.getValues().join(''))
		+ ((colourChecker.getValues().join('') =="0")?  "" : "&s="+colourChecker.getValues().join(''));
	
	resultGraph.src = "graph.php?q="+query+config; 
	linkpage.setAttribute('href', 'AoS-Combat-Calculator.php?q=' + query+config);
	linkimage.setAttribute('href', 'graph.php?q=' + query+config);
	linkfullimage.setAttribute('href', 'graph.php?q=' + query +config+'&t=0');

}

document.getElementById("calculate").addEventListener("click", function(evt) {updateImage();});
reportChecker.addEventListener(updateImage);
colourChecker.addEventListener(updateImage);

	
</script>


<?php 
include "templates/footer.php" ;
?>