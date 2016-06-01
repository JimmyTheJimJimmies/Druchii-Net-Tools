<?php 
$title = "Druchii.net - Generic Simple Calculator";
$description = "Analytical tool for computing the performance of troops based on a probability of success.";
include "templates/header.php";


$dice_exp = "(\d{0,2})((d3|d6|a)(\.(\d{1,2}))?)?";
$bin_exp = "b\:\d\.\d+:$dice_exp(\:$dice_exp\:\d{1,2})?";
$query = (isset($_GET['q']) and preg_match("#^$bin_exp$#", $_GET['q']))? $_GET['q'] : 'b:0.25:10:1:0';

$format_exp = '([csirav]{1,6})';
$format = (isset($_GET['f']) and preg_match("#^$format_exp$#", $_GET['f']))? str_split($_GET['f'],1): array('i','s') ;

$style_number = (isset($_GET['s']) and preg_match("#^[0-4]$#", $_GET['s']))? $_GET['s']: 0 ;

$fullquery = "q=" . $query 
	. ((implode('',$format) == 'is')? '' : '&f=' . implode('',$format))
	. (($style_number == 0)? '' : "&s=$style_number");




$bins = explode(':', $query);
if(! isset($bins[3])) {
	$bins[3] = 1;
}
if(! isset($bins[4])) {
	$bins[4] = 0;
}
if(!isset($bins[1][3])) {
	$bins[1][3] = 0;
}


?>


<div class="container">

	<div class="page-header">
		<h1>Generic, Simple Calculator</h1>
		<p class="lead">
			Calculate the combat statistics for a model or unit based on their chance to score a single success.
		</p>
	</div>
	
	<div class="alert alert-danger" role="alert">
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	All "Simple" calculators will phase be replaced by their multi-profile counterparts. <a href="#pagelinks">The page link</a> below, will bring you to the new calculator, with all settings preserved.
	</div>
	 
	<div  class="row">
	
	
		<div class="col-xs-6 col-sm-3 form-group" id="woundgroup">
		<label class="control-label" for="wound"><h4>Chance to Wound</h4></label>
		<input type="text" class="form-control " name="wound" id="wound" value="<?php echo $bins[1];?>"  title="A number, from 0 to 1"/>
		</div>
				
		<div class="col-xs-6 col-sm-3 form-group" id="damagegroup">
		<label class="control-label" for="damage"><h4>Damage</h4></label>
		<input type="text" class="form-control " name="damage" id="damage" value="<?php echo $bins[3];?>"  title="A number or dice exp like 10 or 2d3+1"/>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 col-sm-3 form-group" id="woundsgroup">
		<label class="control-label" for="wounds"><h4>Wounds</h4></label>
		<input type="text" class="form-control " name="wounds" id="wounds" value="<?php echo $bins[4];?>"  title="A number, smaller than 100"/>
		</div>
		
		<div class="col-xs-6 col-sm-3 form-group" id="attemptsgroup">
		<label class="control-label" for="attempts"><h4>Attacks</h4></label>
		<input type="text" class="form-control " name="attempts" id="attempts" value="<?php echo $bins[2];?>" title="A number or dice exp like 10 or 2d3+1"/>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 col-sm-3">
		<h4>&nbsp;</h4>
		<button class="btn btn-primary" id="calculate">Calculate!</button>
		</div>
	</div>
	<div class="row">
		
	</div>
	<div  class="row">
	<p></p>
	</div>
	
	<div  class="row">
		<div class="col-xs-12 col-sm-6">
			<p><span class="label label-info">Tip:</span> Give the chance for a single successful attack, ie: 0.3. Wounds is the wound cap for a single attack (most likely the target model's number of wounds), but you can enter 0 to have no wound cap. For damage and attacks you can give any number below 100 but also dice based numbers like d6, 1d6+2, 2d3+2 or 2a+1.</p>
		</div>
	</div>


	<h2>Chance per damage done</h2>
	
	
	<div class="row">
	<div class="col-xs-12 graphcontainer">
		
		<img id="resultGraph" src="graph.php?<?php echo $fullquery;?>" />
		<p></p>
	</div>
	</div>
	
	<div  class="row">
	<p></p>
	</div>
	
	
		
	<a name="pagelinks"></a>
	<div class="btn-toolbar" role="toolbar">
	<div class="btn-group">
		<a class="btn btn-primary" id="linkpage" target="_blank" title="Open this calculation in new window" href="Generic-Combat-Calculator.php?<?php echo $fullquery;?>"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span> Page</a>
		<a class="btn btn-default" id="linkimage" target="_blank" title="Open image in new window" href="graph.php?<?php echo $fullquery;?>"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> Image</a>
		<a class="btn btn-default" id="linkfullimage" target="_blank" title="Open image in new window" href="graph.php?<?php echo $fullquery;?>&t=0"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> Full Image</a>
	</div>
	</div>
	<div  class="row">
	<p></p>
	</div>
	
	<div  class="row">
		<div class="col-xs-12 col-sm-4">
		<p><span class="label label-info">Note:</span> 
		The tool filters non-relevant outcomes. The &quot;full image&quot; offers all details, to compare two different results. </p>
		</div>
	</div>
	
	
	<?php include "templates/configure.php" ; ?>
	
	
</div>

	
	
	
</div>


<script src="js/dtUi.js"></script>
<script>


var pwound = document.getElementById("wound");
var damage = document.getElementById("damage");
var attempts = document.getElementById("attempts");
var wounds = document.getElementById("wounds");
var resultGraph = document.getElementById("resultGraph");
var linkpage = document.getElementById("linkpage");
var linkimage = document.getElementById("linkimage");
var linkfullimage = document.getElementById("linkfullimage");


var reportChecker = dtUi.makeCheckGroupController(document.getElementsByName('reporttype'));
var colourChecker = dtUi.makeCheckGroupController(document.getElementsByName('colourscheme'));



dtUi.addRegExpValidator(damage, dtUi.regExDice, document.getElementById('damagegroup'));
dtUi.addRegExpValidator(attempts, dtUi.regExDice, document.getElementById('attemptsgroup'));
dtUi.addRegExpValidator(wounds, /^\d{0,2}$/, document.getElementById('woundsgroup'));
dtUi.addRegExpValidator(pwound, /^\d(\.\d+)?$/, document.getElementById('woundgroup'));

var query =  "<?php echo $query;?>";
var config = "&f=<?php echo implode('',$format);?>";

var updateImage = function() {
	query = "b:" + wound.value + ":" + attempts.value.replace('+','.') + ":" + damage.value.replace('+','.') + ":" + wounds.value;
	
	config = ""
		+ (((reportChecker.getValues().join('') =="is") || (reportChecker.getValues().join('') =="")) ? "" : "&f="+reportChecker.getValues().join(''))
		+ ((colourChecker.getValues().join('') =="0")?  "" : "&s="+colourChecker.getValues().join(''));

	
	resultGraph.src = "graph.php?q="+query+config; 
	linkpage.setAttribute('href', 'Generic-Combat-Calculator.php?q=' + query+config);
	linkimage.setAttribute('href', 'graph.php?q=' + query+config);
	linkfullimage.setAttribute('href', 'graph.php?q=' + query+config + '&t=0');

}

document.getElementById("calculate").addEventListener("click", function(evt) {updateImage();});
reportChecker.addEventListener(updateImage);
colourChecker.addEventListener(updateImage);

</script>


<?php 
include "templates/footer.php" ;
?>