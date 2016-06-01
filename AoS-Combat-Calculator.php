<?php 
$title = "Druchii.net - Age of Sigmar Combat Calculator";
$description = "Analytical tool for computing the performance of multiple troops or troops with multiple attack profiles.";
include "templates/header.php";
include "lib/ParseQueries.php";

if(sizeof($parameters) == 0) {
	$parameters[] = array(
		"query"=>"r:335:10",
		"type"=>"r",
		'hitroll'=>3,
		'woundroll'=>3,
		'saveroll'=>5,
		'attempts'=>10,
		'hitreroll'=> 0,
		'woundreroll'=> 0,
		'savereroll' => 0,
		'rules' => [],
		'damage' => 1
	);
				
}

$format_exp = '([csirav]{1,6})';
$format = (isset($_GET['f']) and preg_match("#^$format_exp$#", $_GET['f']))? str_split($_GET['f'],1): array('i','s') ;

$style_number = (isset($_GET['s']) and preg_match("#^[0-4]$#", $_GET['s']))? $_GET['s']: 0 ;


$query = "";

forEach($parameters as $parameter) {
	if(in_array($parameter['type'], ["a", "b", "r"])) {
		$query .= ";" . $parameter['query'];
	}
}
$query = substr($query,1);

$fullquery = "q=" . $query 
	. ((implode('',$format) == 'is')? '' : '&f=' . implode('',$format))
	. (($style_number == 0)? '' : "&s=$style_number");


?>


<div class="container" >

	<div class="page-header">
		<h1>Age of Sigmar Combat Calculator</h1>
		<p class="lead">
			Calculate the combat statistics for a combination of models, or models with multiple attack profiles.
		</p>
	</div>
	
	 
	<div id="calculators" class="list-group">
	
	
	</div>
				
			
	<div class="row">
		<div class="col-xs-6 col-sm-3">
			<button class="btn btn-primary" id="calculate">Calculate!</button>
		</div>
		<div class="col-xs-6 col-sm-9 text-right">
			Add profile
			<div class="btn-group">
				<button class="btn btn-default" id="addgenericcalculator">
					<svg class="dice-tiny" viewBox="0 0 100 100"><text x="15" y="75" font-size="60" fill="currentColor">&#37;</text></svg>
					Generic
				</button>
				<button class="btn btn-default" id="addaoscalculator">
					<svg class="dice-tiny" viewBox="0 0 100 100" ><use xlink:href="images/iconpack.svg#d8"></use></svg>
					 AoS
				</button>
				<button class="btn btn-default" id="addmortalwoundscalculator">
					<svg class="dice-tiny" viewBox="0 0 100 100" ><use xlink:href="images/iconpack.svg#dauto"></use></svg>
					 Mortal Wounds
				</button>
			</div>
		</div>
	</div>
	

	<h2>Chance per damage done</h2>
	
	
	<div class="graphcontainer">
			<img id="resultGraph" src="graph.php?<?php echo $fullquery;?>" />
	</div>
	
		
	<div class="btn-group">
		<a class="btn btn-default" id="linkpage" target="_blank" title="Open this calculation in new window" href="AoS-Combat-Calculator.php?<?php echo $fullquery;?>"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span> Page</a>
		<a class="btn btn-default" id="linkimage" target="_blank" title="Open image in new window" href="graph.php?<?php echo $fullquery;?>"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> Image</a>
		<a class="btn btn-default" id="linkfullimage" target="_blank" title="Open image in new window" href="graph.php?<?php echo $fullquery;?>&t=0"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> Full Image</a>
	</div>
	
	<div  class="row">
		<div class="col-xs-12 col-sm-4">
		<p><span class="label label-info">Note:</span> 
		The tool filters non-relevant outcomes. The &quot;full image&quot; offers all details, to compare two different results. </p>
		</div>
	</div>
	
	
	<?php include "templates/configure.php" ; ?>
	
	
</div>

	
	
	



<?php include "templates/templates.php" ; ?>


<script src="js/dtUi.js"></script>

<script>
var resultGraph = document.getElementById("resultGraph");
var linkpage = document.getElementById("linkpage");
var linkimage = document.getElementById("linkimage");
var linkfullimage = document.getElementById("linkfullimage");

var reportChecker = dtUi.makeCheckGroupController(document.getElementsByName('reporttype'));
var colourChecker = dtUi.makeCheckGroupController(document.getElementsByName('colourscheme'));


var makeFormController = function() {
	var inputControllers = [];
	var calculators = document.getElementById('calculators');
	var calculator_count = 0;		
	var query = "";
	var addgenericbutton = document.getElementById('addgenericcalculator');
	var addaosbutton = document.getElementById('addaoscalculator');
	var addmortalwoundsbutton = document.getElementById('addmortalwoundscalculator');
	
	var getNewId = function() {
		return "calc" + ++calculator_count; 
	}
		
	var addCalculator = function(type, values) {
		
		if(inputControllers.length > 20) {
			return false;
		}
		var id = getNewId();
		var controller;
		switch(type) {
			case 'aos':
				calculators.insertAdjacentHTML('beforeend', dtUi.templateController.makeNewInstanceWithId('aos-calculator', id));
				controller = dtUi.makeAosInputController(id);
				break;
			case 'generic':
				calculators.insertAdjacentHTML('beforeend', dtUi.templateController.makeNewInstanceWithId('generic-calculator', id));
				controller = dtUi.makeGenericInputController(id);
				break;
			case 'autowounds':
				calculators.insertAdjacentHTML('beforeend', dtUi.templateController.makeNewInstanceWithId('autowounds-calculator', id));
				controller = dtUi.makeAutowoundsInputController(id);
				break;
		}
		
		controller.setValues(values);
		inputControllers.push(controller);		
		if(inputControllers.length > 20) deactivateButtons();
		controller.getRemoveButton().addEventListener('click', function(evt) {
			var pos = inputControllers.indexOf(controller);
			inputControllers.splice(pos,1);
			calculators.removeChild(controller.getCalculator());
			if(inputControllers.length <= 20) activateButtons();
		});	
	}
	
	var activateButtons = function() {
		addgenericbutton.setAttribute('class', 'btn btn-default');	
		addaosbutton.setAttribute('class', 'btn btn-default');	
		addmortalwoundsbutton.setAttribute('class', 'btn btn-default');	
	}
	var deactivateButtons = function() {
		addgenericbutton.setAttribute('class', 'btn btn-disabled');
		addaosbutton.setAttribute('class', 'btn btn-disabled');
		addmortalwoundsbutton.setAttribute('class', 'btn btn-disabled');
	}
	
	var updateQuery = function() {
		query = "";
		for(var i=0;i<inputControllers.length;i++){
			query+= ";" + inputControllers[i].getQuery();
		}
		query = query.substr(1);
	}
	var getQuery = function(){
		return query;
	}
	var getCalculatorCount = function(){
		return inputControllers.length;
	}
	addgenericbutton.addEventListener('click', function() {addCalculator('generic', {pwound:0.25, damage:1, wounds:0, attempts:10});});
	addaosbutton.addEventListener('click', function() {addCalculator('aos', 
		{hitroll:4, woundroll:4, saveroll:5, hitreroll:0, woundreroll:0, savereroll:0, damage:1, attempts:10});});
	
		
	addmortalwoundsbutton.addEventListener('click', function() {addCalculator('autowounds', {poccur:1.0, wounds:'1d3'});});
	
	
	return {
		addCalculator:addCalculator,
		getNewId:getNewId,
		updateQuery:updateQuery,
		getQuery:getQuery,
		getCalculatorCount:getCalculatorCount
	}


}




var query =  "<?php echo $query;?>";
var config = "&f=<?php echo implode('',$format);?>";

var formController = makeFormController();


	


var updateImage = function() {	
	formController.updateQuery();
	query = formController.getQuery();
	config = ""
		+ (((reportChecker.getValues().join('') =="is") || (reportChecker.getValues().join('') =="")) ? "" : "&f="+reportChecker.getValues().join(''))
		+ ((colourChecker.getValues().join('') =="0")?  "" : "&s="+colourChecker.getValues().join(''));
	resultGraph.src = "graph.php?q="+query+config; 
	linkpage.setAttribute('href', 'AoS-Combat-Calculator.php?q=' + query+config);
	linkimage.setAttribute('href', 'graph.php?q=' + query+config);
	linkfullimage.setAttribute('href', 'graph.php?q=' + query+config + '&t=0');

}


document.getElementById("calculate").addEventListener("click", function(evt) {updateImage();});
reportChecker.addEventListener(updateImage);
colourChecker.addEventListener(updateImage);


<?php 
forEach($parameters as $input){ 
	switch($input['type']) {
		case "b": 
			echo "formController.addCalculator('generic', {pwound:".$input['pwound'].", damage:'".str_replace(".", "+", $input['damage'])."', wounds:".$input['wounds'].", attempts:'".str_replace(".", "+", $input['attempts'])."'});\r\n";
			break;
		case "r": 
			echo "formController.addCalculator('aos', {hitroll:".$input['hitroll'].", woundroll:".$input['woundroll'].", saveroll:".$input['saveroll'].", hitreroll:".$input['hitreroll'].", woundreroll:".$input['woundreroll'].", savereroll:".$input['savereroll'].", damage:'".str_replace(".", "+", $input['damage'])."', attempts:'".str_replace(".", "+", $input['attempts'])."'});\r\n";
			break;
		case "a": 
			echo "formController.addCalculator('autowounds', {poccur:".$input['poccur'].", wounds:'".str_replace(".", "+", $input['wounds'])."'});\r\n";
			break;
		default:
			break;
	}
}
?>
</script>


<?php 
include "templates/footer.php" ;
?>