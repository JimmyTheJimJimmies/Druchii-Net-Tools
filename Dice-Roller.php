<?php 
$title = "Druchii.net - Dice Roller";
$description = "Roll a few dice, he said.";
include "templates/header.php";



?>
<div class="container">

	<div class="page-header">
		<h1>Tabletop Dice Roller</h1>
		<p class="lead">
			Throw a couple of dice. Just to get the feel of them.
		</p>
	</div>
	
	<div class="row">
		<div class="col-xs-2 col-sm-3">
			<p class="text-center">
				Dice
			</p>
				<h4 id="dicecount" class="text-center">0</h4>
		</div>
		<div class="col-xs-10 col-sm-9">
			<div class="btn-group btn-group-justified" role="group" aria-label="...">
				<div class="btn-group" role="group">
					<button class="btn btn-default" id="dice1">
					<div class="row">
						<div class="col-xs-4 col-md-5 text-right">
							<svg class="dice-small" viewBox="0 0 100 100" ><use xlink:href="images/iconpack.svg#d1"></use></svg>
						</div>
						<div class="col-xs-8 col-md-7 text-left">	
							Add 1
						</div>
					</div>
					</button>
				</div>
				
				<div class="btn-group" role="group">
					<button class="btn btn-default" id="dice5">
					<div class="row">
						<div class="col-xs-4 col-md-5 text-right">
							<svg class="dice-small" viewBox="0 0 100 100" ><use xlink:href="images/iconpack.svg#fivedice"></use></svg>
						</div>
						<div class="col-xs-8 col-md-7 text-left">	
							Add 5
						</div>
					</div>
					</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-2 col-sm-3">
			<p class="text-center">
				Selected
			</p>
				<h4 id="selectcount" class="text-center">0</h4>
		</div>
		<div class="col-xs-10 col-sm-9">
			<div class="btn-group btn-group-justified" role="group" aria-label="...">
				
				<div class="btn-group" role="group">
				<button class="btn btn-default" id="discard">
					<div class="row">
						<div class="col-xs-4 col-md-5 text-right">
							<svg class="dice-small" viewBox="0 0 100 100"><use xlink:href="images/iconpack.svg#a0"></use></svg>
						</div>
						<div class="col-xs-8 col-md-7 text-left">	
							Discard <br class="hidden-md-up visible-xs-inline"/><span class="hide-has-selected"><strong>All</strong></span><span class="show-has-selected"><strong>Selected</strong></span>
						</div>
					</div>
				</button>
				</div>
				
				<div class="btn-group" role="group">
				<button class="btn btn-default" id="re-roll">
					<div class="row">
						<div class="col-xs-4 col-md-5 text-right">
						<svg class="dice-small" viewBox="0 0 100 100"><use xlink:href="images/iconpack.svg#rerolldice"></use></svg>
						</div>
						<div class="col-xs-8 col-md-7 text-left">	
							Re-roll <br class="hidden-md-up visible-xs-inline"/><span class="hide-has-selected"><strong>All</strong></span><span class="show-has-selected"><strong>Selected</strong></span>
						</div>
					</div>
				</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row hidden">
		<div class="col-xs-4 col-sm-3">
			<div class="btn-group btn-group-justified" role="group" aria-label="...">
				<div class="btn-group" role="group">
				<button class="btn btn-default pull-right" id="select_dice_none">
					<svg class="dice-small" viewBox="0 0 100 100"><use xlink:href="images/iconpack.svg#dnone"></use></svg>
				</button>
				</div>
			</div>
		</div>
		<div class="col-xs-4 col-sm-3">	
			<p class="text-center">Select</p>
		</div>
		
		<div class="col-xs-4 col-sm-3">
			<div class="btn-group btn-group-justified" role="group" aria-label="...">
				<div class="btn-group" role="group">
				<button class="btn btn-default pull-right" id="select_dice_all">
					<svg class="dice-small" viewBox="0 0 100 100"><use xlink:href="images/iconpack.svg#dall"></use></svg>
				</button>
				</div>
			</div>
		</div>
		
		<div class="col-xs-0 col-sm-3">
			<br/>
		</div>
	</div>
	<p>
	</p>
	
	<div class="row">
		<div class="col-xs-2 col-sm-3 text-center text-muted">
			Quick Select
		</div>
		<div class="col-xs-10 col-sm-6">
			<input type="checkbox" class="hidden" name="select_dice"  id="select_dice_1" value="1">
			<label class=" " for="select_dice_1" >
				<svg class="dice-small" viewBox="0 0 100 100"><use xlink:href="images/iconpack.svg#d1"></use></svg>
			</label>
			<input type="checkbox" class="hidden" name="select_dice"  id="select_dice_2" value="2">
			<label class=" "  for="select_dice_2" >
				<svg class="dice-small" viewBox="0 0 100 100"><use xlink:href="images/iconpack.svg#d2"></use></svg>
			</label>
			<input type="checkbox" class="hidden" name="select_dice" id="select_dice_3" value="3">
			<label class=" "  for="select_dice_3">
				<svg class="dice-small" viewBox="0 0 100 100"><use xlink:href="images/iconpack.svg#d3"></use></svg>
			</label>
			<input type="checkbox" class="hidden" name="select_dice"  id="select_dice_4" value="4">
			<label class=" "  for="select_dice_4">
				<svg class="dice-small" viewBox="0 0 100 100"><use xlink:href="images/iconpack.svg#d4"></use></svg>
			</label>
			<input type="checkbox" class="hidden" name="select_dice"  id="select_dice_5" value="5">
			<label class=" "  for="select_dice_5">
				<svg class="dice-small" viewBox="0 0 100 100"><use xlink:href="images/iconpack.svg#d5"></use></svg>
			</label>
			<input type="checkbox" class="hidden" name="select_dice"  id="select_dice_6" value="6">
			<label class=" "  for="select_dice_6">
				<svg class="dice-small" viewBox="0 0 100 100"><use xlink:href="images/iconpack.svg#d6"></use></svg>
			</label>
		</div>
		
	</div>
	<p>
	</p>
	
	<div class="panel panel-default">
	<div class="panel-body" id="results">


	</div>
	</div>

	
	
</div>


<div id="templates" style="display:none">
	<div class="dtUi-template" id="dice-roll" data-dtUi-code="dice_roll_id">
		<span id="{{dice_roll_id}}_panel">	
			<input type="checkbox" id="{{dice_roll_id}}_check" name="dice" class="hidden"/>
			<label for="{{dice_roll_id}}_check" >
				<svg class="large-dice" viewBox="0 0 100 100">
					<use id="{{dice_roll_id}}_dice" xlink:href="images/iconpack.svg#d4"></use>
				</svg>
			</label>
		</span>	
	</div>
</div>
<script src="js/dtUi.js"></script>
<script>
function rollD6(){
	return Math.round(Math.random() * 6 + 0.5);
}
function rollA(){
	return Math.abs(Math.round(Math.random()*6 + -0.5) * 2);
}

function DiceController(id, root, dice_code, roll_function) {
	this.roll = 4;
	this.code = dice_code;
	this.id = id;
	this.panel = document.getElementById(id+"_panel");
	this.dice_panel = document.getElementById(id+"_dice");
	this.checkbox = document.getElementById(id+"_check");
	this.default_class = this.panel.getAttribute("class");
	
	this.doRoll = function() {
		this.roll = ""+roll_function();
		this.dice_panel.setAttribute("xlink:href", root+"#"+this.code+this.roll);
		this.panel.setAttribute("class", this.default_class);
		this.checkbox.checked=false;
	}
	this.reRoll = function() {
		this.doRoll();
		this.panel.setAttribute("class", this.default_class + " rerolled");
		this.checkbox.checked=false;
	}
}

function DiceBagController(){
	this.dicecount_panel = document.getElementById('dicecount');
	this.selectcount_panel = document.getElementById('selectcount');
	
	this.discard = document.getElementById('discard');
	this.discard_class = this.discard.getAttribute('class');
	this.reroll = document.getElementById('re-roll');
	this.reroll_class = this.reroll.getAttribute('class');
	
	this.selectors = dtUi.makeCheckGroupController(document.getElementsByName("select_dice"));
	this.select_all = document.getElementById("select_dice_all");
	this.select_none = document.getElementById("select_dice_none");
	
	this.dice1 = document.getElementById('dice1');
	this.dice5 = document.getElementById('dice5');


	this.id_count = 0;
	this.result_panel = document.getElementById('results');
	this.dice_controllers = [];
	
	var self = this;
	this.getNewId = function () {
		return "dice" + ++this.id_count;
	}
	this.addD6 = function (){
		var id = this.getNewId();
		this.result_panel.insertAdjacentHTML('beforeend', dtUi.templateController.makeNewInstanceWithId('dice-roll', id));
		var controller = new DiceController(id, "images/iconpack.svg", "d", rollD6);
		this.dice_controllers.push(controller);
		controller.doRoll();
		controller.checkbox.addEventListener('change', function(){self.updateStats();});
	}	
	this.selectDice = function(values){
		for(var i=0; i<this.dice_controllers.length; i++) {
			if(values.indexOf(this.dice_controllers[i].roll)>=0) {
				this.dice_controllers[i].checkbox.checked = true;
			} else {
				this.dice_controllers[i].checkbox.checked = false;		
			}
		}
	}
	this.clearSelectedDice = function(){
		var i=0;
		while(i<this.dice_controllers.length) {
			if(this.dice_controllers[i].checkbox.checked) {
				this.result_panel.removeChild(this.dice_controllers[i].panel);
				this.dice_controllers.splice(i,1);
			} else{
				i++;
			}
		}
	}
	this.clearAllDice = function(){
		var i=0;
		this.dice_controllers = [];
		this.id_count = 0;
		this.result_panel.innerHTML = '';
	}	
	this.reRollSelectedDice = function(){
		for(var i=0; i<this.dice_controllers.length; i++){
			if(this.dice_controllers[i].checkbox.checked) {
				this.dice_controllers[i].reRoll();
			}
		}
	}
	this.rollAllDice = function(){
		for(var i=0; i<this.dice_controllers.length; i++){
			this.dice_controllers[i].doRoll();
		}
	}
	this.getSelectedDice = function(){
		return this.dice_controllers.filter(function(controller){return controller.checkbox.checked;});
	}
		
	this.updateStats = function(){
		var count = this.dice_controllers.length;
		var selected =  this.getSelectedDice().length;
		this.dicecount_panel.innerHTML = count;
		this.selectcount_panel.innerHTML = selected;
		if(selected > 0) {
			this.discard.setAttribute('class', this.discard_class + " has-selected");
			this.reroll.setAttribute('class', this.reroll_class + " has-selected");
		} else {
			this.discard.setAttribute('class', this.discard_class);
			this.reroll.setAttribute('class', this.reroll_class );			
		}	
	}
	
	this.selectors.addEventListener(function(){
		self.selectDice(self.selectors.getValues());
		self.updateStats();		
	});
	this.select_all.addEventListener("click", function() {
		self.selectors.setValues(["1","2","3","4","5","6"]);
		self.selectDice(["1","2","3","4","5","6"]);
		self.updateStats();		
	});
	this.select_none.addEventListener("click", function() {
		self.selectors.setValues([]);
		self.selectDice([]);
		self.updateStats();		
	});
	this.dice1.addEventListener('click', function(){
		self.addD6();
		self.selectDice(self.selectors.getValues());
		self.updateStats();		
	});
	this.dice5.addEventListener('click', function() {
		self.addD6();
		self.addD6();
		self.addD6();
		self.addD6();
		self.addD6();
		self.selectDice(self.selectors.getValues());
		self.updateStats();		
	});
	
	this.reroll.addEventListener('click', function(){
		if(self.getSelectedDice().length > 0) {
			self.reRollSelectedDice();
		} else {
			self.rollAllDice();
		}
		self.selectors.setValues([]);
		self.updateStats();		
	});
	this.discard.addEventListener('click', function(){
		if(self.getSelectedDice().length > 0) {
			self.clearSelectedDice();
		} else {
			self.clearAllDice();
		}
		self.selectors.setValues([]);
		self.updateStats();
	});


}




formcontroller = new DiceBagController();





	
</script>


<?php 
include "templates/footer.php" ;
?>