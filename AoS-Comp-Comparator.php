<?php 
$title = "Druchii.net - Age of Sigmar Comp Comparator";
$description = "Analytical tool for computing the performance of multiple troops or troops with multiple attack profiles.";
include "templates/header.php";

?>

<style>
span.unit_name{
	font-weight:bold;
}
span.unit_info{
	color:#666;
	font-size:smaller;
}
input[type=radio]:checked + label, input[type=radio]:checked > label{
	color: #2b2;
}

.table-header{
	background: #e8e8e8;
}

a.subtle{
	color: #d8d8d8;
}

a.subtle:hover{
	color: #ffffff;
	background: #333;
}

div.highlight{
	background:rgba(228, 255, 228, 1);
}

</style>
	

<div class="container" >
	<div class="page-header">
		<h1>Age of Sigmar Comp Comparator</h1>
		<p class="lead">
			Compare the point or unit values of warscrolls across various comp packs.
		</p>
	</div>

	<div class="alert alert-warning" role="alert">Warning! This tool is still under development and may show the occasional glitch. Feel free to report them and we'll try to fix them as soon as we can. You can contact us on the forum The tool also uses the old warscrolls, from the armybook compendiums.</div>

	
	<div id="comp-configurators" class="list-group">	
		
	
	
	
	</div>

	
	
	<h3>View settings</h3>
	
	
					
	
	
	<div class="row">
		<div class="col-xs-6 col-sm-3 text-right">Show as</div>
		<div class="col-xs-6 col-sm-6">
			<div class="btn-group">						
				<label for="display_points" class="btn btn-default btn-md">
					<input type="radio" name="display_mode" class="hidden" id="display_points" value="display_points" checked="checked"/>
					pts
				</label>						
				<label for="display_percentage" class="btn btn-default btn-md">
					<input type="radio" name="display_mode" class="hidden" id="display_percentage" value="display_percentage" />
					%
				</label>		
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-6 col-sm-3 text-right">Show difference as</div>
		<div class="col-xs-6 col-sm-6">
			<div class="btn-group">				
				<label for="display_diff_points" class="btn btn-default btn-md">
					<input type="radio" name="display_diff_mode" class="hidden" id="display_diff_points" value="display_diff_points" checked="checked"/>
					Exact
				</label>
				<label for="display_diff_percentage" class="btn btn-default btn-md">
					<input type="radio" name="display_diff_mode" class="hidden" id="display_diff_percentage" value="display_diff_percentage" />
					Relative
				</label> 				
			</div>
		</div>
		
	</div>
	
	<div class="row">
		<div class="col-xs-6 col-sm-3 text-right">Rescale to</div>
		<div class="col-xs-6 col-sm-3">	
			<label>
				<input type="radio" name="scale_mode" id="scale_none" value="scale_none"  checked="checked"/> Don't scale
			</label> <br/>
			<label>
				<input type="radio" name="scale_mode" id="scale_focus" value="scale_focus" /> Focused army
			</label> <br/>
			<label>
				<input type="radio" name="scale_mode" id="scale_custom" value="scale_custom"/> Custom scale	
			</label>
			<div class="input-group">
				<input type="text" name="custom_scale" id="custom_scale" class="form-control" value="2000">
				<span class="input-group-addon">Points</span>
			</div>
		</div>
	</div>			
	
	<h4>Filter</h4>
	<label for="filter_must">Must have:</label><br/>
	<input type="text" class="form-control" id="filter_must" /><br/>
	<label for="filter_mustnot">Can not have:</label><br/>
	<input type="text" class="form-control" id="filter_mustnot" /><br/>
	
	<h3>Comparison</h3>

	
	<div class="row">
		<div class="col-xs-12 col-sm-4">
			<div class="input-group">
				<select  class="form-control" id="comp-selector"></select>
				<span class="input-group-btn">
					<button class="btn btn-success" id="add-comp">Add Comp</button>
				</span>
			</div>
		</div>
	</div>
	<br/>
	<div id="scrolls" class="list-group">
		<div class="list-group-item">
			<div class="row" >
				<div class="col-xs-5 col-md-3">Units # Comps <br/>
					<input type="radio" name="comp_focus" class="hidden" id="no_focus" value="no_focus" checked="checked"/>
					<label for="no_focus"><span class="glyphicon glyphicon-eye-open"></span>	Remove focus</label><br/>
				</div>
				<div class="col-xs-7 col-md-9">
					<div class="row" id="comp_headers">
						
						
					</div>
				</div>
			</div>
		</div>
	
	</div>
	
	
	
</div>

<div id="templates" style="display:none">


	
	<div class="dtUi-template" id="scroll_comp_panel" data-dtUi-code="scroll_comp_id">
		<div class="col-xs-offset-1 col-xs-5 col-md-offset-1 col-md-2" id="{{scroll_comp_id}}_panel">
				<span id="{{scroll_comp_id}}_points">5</span>
				<span id="{{scroll_comp_id}}_diff" class="pull-right text-warning">+16%</span>
		</div>
	</div>	
		
			
	<div class="dtUi-template" id="comp_header" data-dtUi-code="comp_head_id">
		<div class="col-xs-6 col-md-3"  id="{{comp_head_id}}_header">
			<button type="button" class="close pull-right" aria-label="Close" id="{{comp_head_id}}_remove"><span aria-hidden="true">&times;</span></button>
			<input type="radio" name="comp_focus" class="hidden" id="{{comp_head_id}}_focus" value="{{comp_head_id}}_focus"/>
			<label for="{{comp_head_id}}_focus">
				<span class="glyphicon glyphicon-eye-open"></span>
				<strong id="{{comp_head_id}}_title">Comp name</strong>
			</label><br/>
			
			<p>
				<label for="{{comp_head_id}}_army_size" class="text-muted">Army size</label>
				<div class="input-group">
					<input type="text" class="form-control" id="{{comp_head_id}}_army_size" value="100"/>
					<span class="input-group-btn">
						<button class="btn btn-default" id="{{comp_head_id}}_reset">Reset</button>
					</span>				
				</div>
			</p>
		</div>
	</div>
	
	
	<div class="dtUi-template" id="scroll_panel" data-dtUi-code="scroll_id">
		<div class="list-group-item"  id="{{scroll_id}}_panel">
			<div class="row" >
				<div class="col-xs-5 col-md-3">
					<p class="pull-right"><a class="subtle" id="{{scroll_id}}_normalize">&nbsp;<span class="glyphicon glyphicon-arrow-right"></span>&nbsp;</a></p>
					<p>
						<strong id="{{scroll_id}}_name"></strong><br/>
						<span id="{{scroll_id}}_info" class="text-muted"></span>
					</p>
				</div>		
				<div class="col-xs-7 col-md-9">
					<div class="row" id="{{scroll_id}}_comps">
					
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<script type="text/javascript" src="js/dtUi.js"></script>
<script type="text/javascript" src="js/dtCompData.js"></script>
<script type="text/javascript">


var aComp = {id:0, name:"Comp's Name Dude", default_size: 100, scroll_ids: [], scroll_values:[]};	
var aScroll = {id:0, name:"Dreadspears", models:10, wounds:10}	

function CompController(id, comp) {
	//header
	this.header = document.getElementById(id+'_header');
	this.focus = document.getElementById(id + "_focus");
	this.title = document.getElementById(id + "_title");
	this.army_size = document.getElementById(id + "_army_size");
	this.remove= document.getElementById(id+"_remove");
	this.reset= document.getElementById(id+"_reset");
	this.title.innerHTML = comp.name;
	this.army_size.value = comp.default_size;	
	
	this.comp = comp;
	this.scroll_comp_controllers = [];	
}
CompController.prototype.updateScrolls = function () {
	for(var i=0;i<this.scroll_comp_controllers.length;i++){
		this.scroll_comp_controllers[i].update();
	}
}



function ConfigController(form_controller) {
	this.form_controller = form_controller;
	this.display_modes = document.getElementsByName("display_mode");
	this.display_mode = "";
	this.display_class = this.display_modes[0].parentNode.getAttribute('class');
	
	this.display_diff_modes = document.getElementsByName("display_diff_mode");
	this.display_diff_mode = "";
	
	this.scale_none = document.getElementById("scale_none");
	this.scale_focus = document.getElementById("scale_focus");
	this.scale_custom = document.getElementById("scale_custom");
	this.scale = 0;
	this.custom_scale = document.getElementById("custom_scale");
	
	this.no_focus = document.getElementById("no_focus");
	
	this.focused_comp = 0;
		
	this.updateConfig = function() {
		for(var i=0; i<this.display_modes.length;i++) {
			if(this.display_modes[i].checked) {
				this.display_mode = this.display_modes[i].value;
				this.display_modes[i].parentNode.setAttribute('class', this.display_class+' active');
			} else {
				this.display_modes[i].parentNode.setAttribute('class', this.display_class);
			}
		}
		for(var i=0; i<this.display_diff_modes.length;i++) {
			if(this.display_diff_modes[i].checked) {
				this.display_diff_mode = this.display_diff_modes[i].value;
				this.display_diff_modes[i].parentNode.setAttribute('class', this.display_class+' active');
			}else {
				this.display_diff_modes[i].parentNode.setAttribute('class', this.display_class);
			}
		}	
		this.focused_comp = 0;
		for(var i=0; i<this.form_controller.comp_controllers.length;i++) {
			if(this.form_controller.comp_controllers[i].focus.checked) {
				this.focused_comp = this.form_controller.comp_controllers[i];
				break;
			}
		}
		this.scale = 0;
		if(this.scale_focus.checked && (this.focused_comp!=0)) {
			this.scale -= - this.focused_comp.army_size.value;
		} else if (this.scale_custom.checked) {
			this.scale -= - this.custom_scale.value;
		}
	};	
	this.addEventListener = function(callback) {
		for(var i=0; i<this.display_modes.length;i++) {
			this.display_modes[i].addEventListener("change", callback);
		}
		for(var i=0; i<this.display_diff_modes.length;i++) {
			this.display_diff_modes[i].addEventListener("change", callback);
		}
		this.no_focus.addEventListener("change", callback);
		this.scale_none.addEventListener("change", callback);
		this.scale_focus.addEventListener("change", callback);
		this.scale_custom.addEventListener("change", callback);
		this.custom_scale.addEventListener("change", callback);
	}
	this.updateConfig();
};



function ScrollController(id, scroll) {
	this.scroll = scroll;
	this.panel = document.getElementById(id + '_panel');
	this.comps = document.getElementById(id + '_comps');
	this.default_class = this.panel.getAttribute('class');
	this.hidden_class = this.default_class + " hidden";	
	this.normalize = document.getElementById(id + '_normalize');
	document.getElementById(id + '_name').innerHTML = scroll.name;
	document.getElementById(id + '_info').innerHTML = scroll.models + " models, " + scroll.wounds + " wounds.";
	this.filtered = false;

}

ScrollController.prototype.filter = function(haves, nothaves) {
	console.log(haves);
	for(var i=0; i<haves.length; i++) {
		if(this.scroll.keywords.indexOf(haves[i]) < 0){
			this.filtered  = true;
			this.panel.setAttribute('class', this.hidden_class);
			return true;
		}
	}
	console.log("nots");
	console.log(nothaves);
	for(var i=0; i<nothaves.length; i++){
		if(this.scroll.keywords.indexOf(nothaves[i]) >= 0){
			this.filtered  = true;
			this.panel.setAttribute('class', this.hidden_class);
			return true;
		}
	}
	this.filtered = false;
	this.panel.setAttribute('class', this.default_class);
	return this.filtered;		
}

function ScrollCompController(id, scroll_controller, comp_controller, config_controller) {
	this.scroll_controller = scroll_controller;
	this.comp_controller = comp_controller;
	this.config_controller = config_controller;

	this.panel = document.getElementById(id+"_panel");
	this.points = document.getElementById(id+"_points");
	this.diff = document.getElementById(id+"_diff");
	this.default_class = this.panel.getAttribute('class');
	
	this.base_points = 0;
	this.unit_index = comp_controller.comp.scroll_ids.indexOf(scroll_controller.scroll.id);
	if(this.unit_index >= 0) {
		this.base_points = comp_controller.comp.scroll_values[this.unit_index];
	}
}

ScrollCompController.prototype.focus = function(){
	this.panel.setAttribute('class', this.default_class + ' text-info');
}
ScrollCompController.prototype.blur = function(){
	this.panel.setAttribute('class', this.default_class)
}

ScrollCompController.prototype.formatPoints = function(points){
	if(!isFinite(points)) return "";
	return Math.round(points *10)/10 + " pts";
}

ScrollCompController.prototype.formatDiffPoints = function(points){
	if(!isFinite(points)) return "eh";
	return ((points >= 0)? "+" :"") + Math.round(points *10)/10 + " pts";
}

ScrollCompController.prototype.formatPercentage = function(percentage){
	if(!isFinite(percentage)) return "";
	return Math.round(percentage * 100 *10)/10 + "%";
}
ScrollCompController.prototype.formatDiffPercentage = function(percentage){
	if(!isFinite(percentage)) return "";
	return ((percentage >= 0)? "+" :"") + Math.round(percentage *100 *10)/10 + "%";
}

ScrollCompController.prototype.update = function() {
	var weight = this.base_points / this.comp_controller.army_size.value;
	var pts = (this.config_controller.scale == 0)? this.base_points : weight * this.config_controller.scale;
	switch(this.config_controller.display_mode) {
		case "display_points":
			this.points.innerHTML = this.formatPoints(pts);
			break;
		case "display_percentage":
			this.points.innerHTML = this.formatPercentage(weight);
			break;
	}
	if(this.config_controller.focused_comp == this.comp_controller) {
		this.focus();
		this.diff.innerHTML = "";
		return 0;
	} 
	this.blur();		
	if(this.config_controller.focused_comp == 0) {
		this.diff.innerHTML = "";
		return 0;
	}
	
	var comp_idx = this.config_controller.focused_comp.comp.scroll_ids.indexOf(this.scroll_controller.scroll.id);
	var comp_pts = this.config_controller.focused_comp.comp.scroll_values[comp_idx];
	var comp_weight = comp_pts / this.config_controller.focused_comp.army_size.value;
	comp_pts = (this.config_controller.scale == 0)? comp_pts : comp_weight * this.config_controller.scale;

	
	switch(this.config_controller.display_mode + " and " + this.config_controller.display_diff_mode) {		
		case "display_points and display_diff_points": 
			this.diff.innerHTML = this.formatDiffPoints(pts - comp_pts);
			break;
		case "display_percentage and display_diff_points": 				
			this.diff.innerHTML = this.formatDiffPercentage(weight - comp_weight);
			break;	
		case "display_points and display_diff_percentage": 
		case "display_percentage and display_diff_percentage": 
			this.diff.innerHTML = this.formatDiffPercentage((weight - comp_weight)/comp_weight);
			break;
		default:
			this.points.innerHTML = "error"
			this.diff.innerHTML = "";
			break;
	
	}
}



function FormController () {
	var self = this;
	this.scroll_controllers = [];
	this.comp_controllers = [];
	this.config_controller = new ConfigController(self);
	
	this.scrolls = document.getElementById('scrolls');
	this.comp_headers = document.getElementById('comp_headers');
	this.comp_configurations = document.getElementById('comp-configurators');

	this.filter_must_haves = document.getElementById('filter_must');
	this.filter_must_not_haves = document.getElementById('filter_mustnot');

	
	this.id_count=0;
	this.getNewId = function() {
		return "id_" + ++this.id_count;
	}
	
	this.normalizeForScroll = function(scroll_controller){
		if(this.config_controller.focused_comp == 0) return 0;
		var norm_size = this.config_controller.focused_comp.army_size.value;
		var norm_idx = this.config_controller.focused_comp.comp.scroll_ids.indexOf(scroll_controller.scroll.id);
		var norm_pts = this.config_controller.focused_comp.comp.scroll_values[norm_idx];
		
		if((norm_idx < 0) || (norm_pts ==0)||(norm_size ==0)) return 0;
		for(var i=0; i<this.comp_controllers.length;i++) {
			if(this.comp_controllers[i] != this.config_controller.focused_comp){
				var unit_idx = this.comp_controllers[i].comp.scroll_ids.indexOf(scroll_controller.scroll.id);
				var unit_pts = this.comp_controllers[i].comp.scroll_values[unit_idx];
				
				this.comp_controllers[i].army_size.value = Math.round(unit_pts / norm_pts * norm_size);
				this.comp_controllers[i].updateScrolls();
			}		
		}
		
	}
	
	this.addScroll = function(scroll) {
		var id = this.getNewId();
		this.scrolls.insertAdjacentHTML('beforeend', dtUi.templateController.makeNewInstanceWithId('scroll_panel', id));
		var scroll_controller = new ScrollController(id, scroll);
		this.scroll_controllers.push(scroll_controller);		
		for(var i=0; i<this.comp_controllers.length;i++) {
			var scroll_comp_id = this.getNewId();			
			this.scroll_controller.comps.insertAdjacentHTML('beforeend', dtUi.templateController.makeNewInstanceWithId('scroll_comp_panel', scroll_comp_id));
			var scroll_comp_controller = new ScrollCompController(scroll_comp_id, scroll_controller,comp_controllers[i], this.config_controller);
		}
		scroll_controller.normalize.addEventListener('click', function(){self.normalizeForScroll(scroll_controller);});
	}
	
	this.tokenize = function(input) {
		var tokens = input.split(",");
		var trimmed_tokens = tokens.map(function(el){return el.trim();});	
		return trimmed_tokens.filter(function(el){return el.length>0;})
	}
	
	this.applyFilter = function() {
		var must_haves = this.tokenize(this.filter_must_haves.value);
		var must_not_haves = this.tokenize(this.filter_must_not_haves.value);
		for(var i=0;i<this.scroll_controllers.length;i++){
			this.scroll_controllers[i].filter(must_haves, must_not_haves);
		}
	}
	
	
	this.addComp = function(comp) {
		var comp_id = this.getNewId();
		this.comp_headers.insertAdjacentHTML('beforeend', dtUi.templateController.makeNewInstanceWithId('comp_header', comp_id));
		var comp_controller =  new CompController(comp_id, comp );
		this.comp_controllers.push(comp_controller);	
		for(var i=0;i<this.scroll_controllers.length;i++){
			var scroll_comp_id = this.getNewId();			
			this.scroll_controllers[i].comps.insertAdjacentHTML('beforeend', dtUi.templateController.makeNewInstanceWithId('scroll_comp_panel', scroll_comp_id));
			comp_controller.scroll_comp_controllers.push(
					new ScrollCompController(scroll_comp_id, this.scroll_controllers[i],comp_controller, this.config_controller)
				);
		}
		comp_controller.focus.addEventListener('change' , function(evt){self.update();});
		comp_controller.army_size.addEventListener('change', function(evt){
				if(comp_controller.focus.checked) {
					self.update();
				} else {
					comp_controller.updateScrolls();
				}
			});
		comp_controller.reset.addEventListener('click', function(evt){
				comp_controller.army_size.value = comp_controller.comp.default_size;
				if(comp_controller.focus.checked){
					self.update();
				} else {
					comp_controller.updateScrolls();
				}
			});
		comp_controller.remove.addEventListener('click', function(evt) {self.removeComp(comp_controller);});
		comp_controller.updateScrolls();
	}
	
	this.removeComp = function(comp_controller){
		this.comp_controllers.splice(this.comp_controllers.indexOf(comp_controller),1);
		this.comp_headers.removeChild(comp_controller.header);
		for(var i=0;i<comp_controller.scroll_comp_controllers.length; i++){
			comp_controller.scroll_comp_controllers[i].panel.parentNode.removeChild(comp_controller.scroll_comp_controllers[i].panel);
		}
	
	}
	
	

	
	
	this.update = function() {
		this.config_controller.updateConfig();
		for(var i=0;i<this.comp_controllers.length;i++){
			this.comp_controllers[i].updateScrolls();
		}	
	}
	this.config_controller.updateConfig();
	this.config_controller.addEventListener(function(evt) {self.update();});
	this.filter_must_haves.addEventListener('change', function(){self.applyFilter();});
	this.filter_must_not_haves.addEventListener('change', function(){self.applyFilter();});
}

var formController = new FormController();


for(var i=0; i<scrolls.length; i++) {
	formController.addScroll(scrolls[i]);
}

var comp_selector = document.getElementById('comp-selector');
var add_comp = document.getElementById('add-comp');
for(var i=0; i<knownComps.length; i++) {
	comp_selector.insertAdjacentHTML('beforeend', '<option value="' + i + '">'+ knownComps[i].name + '</option>');	
}
add_comp.addEventListener('click', function() {
	formController.addComp(knownComps[comp_selector.value]);
});


</script>

<?php 
include "templates/footer.php" ;
?>