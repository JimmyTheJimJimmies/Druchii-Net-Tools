var dtUi = (function () {


var regExDice = /^\d{0,2}((d3|d6|a)(\+\d{1,2})?)?$/;
var regExPerc = /^[01](\.\d{1,6})?$/;
var regExSmallNum = /^\d{1,2}$/;

var makeDiceRollController = function(dice, root, links, values, initialvalue) {
	var valueIndex = Math.max(0,values.indexOf(initialvalue));
	var updateImage = function() {
		dice.setAttribute('xlink:href', root + links[valueIndex]);		
	}
	var diceUp = function(event) {
		if(event.altKey) {
			if(--valueIndex < 0 ) valueIndex = links.length-1;
		} else {
			if(++valueIndex >=  links.length) valueIndex = 0;
		}
		updateImage();
	}
	var getValue = function(){
		return values[valueIndex];
	}
	var setValue = function(value){
		valueIndex = Math.max(0,values.indexOf(value));
		updateImage();
	}
	dice.parentNode.addEventListener("click", diceUp);
	return {
		diceUp:diceUp,
		getValue:getValue,
		setValue:setValue
	}
}


var makeButtonRollController = function(button, labels, values, initialvalue, activatedclass) {
	var valueIndex = 0;
	var setIndex = function(newIndex){
		valueIndex = (newIndex >=  labels.length)? 0 : newIndex;
		button.innerHTML = labels[valueIndex];	
		if (valueIndex == 0) { 
				button.setAttribute('class', button.getAttribute('class').replace( ' ' + activatedclass , '' ));
		} else {
			if(button.getAttribute('class').search(activatedclass)<0) {
				button.setAttribute('class', button.getAttribute('class') + ' ' +activatedclass);
			}
		}
	}
	var getValue = function(){
		return values[valueIndex];
	}
	var setValue = function(value){
		setIndex(Math.max(0,values.indexOf(value)));
	}
	setValue(initialvalue);
	button.addEventListener("click", function(){setIndex(1+valueIndex);});
	return {
		getValue:getValue,
		setValue:setValue
	}
}


var addRegExpValidator = function(input, regEx, group) {
	var errorClass = ' has-error';
	var validate = function() {
		if(regEx.test(input.value)) {
			group.setAttribute('class', group.getAttribute('class').replace(errorClass,''));
		} else {
			if(group.getAttribute('class').search(errorClass)<0) {
				group.setAttribute('class', group.getAttribute('class') + errorClass);
			}
		}
	}
	input.addEventListener('input', validate);
	input.addEventListener('propertychange', validate);
}


var makeCheckGroupController = function(inputElements) {
	var values = [];
	var getValues = function() {
		return values;
	}
	var setValues = function(newValues) {
		for(var i=0; i< inputElements.length; i++) {
			if(newValues.indexOf(inputElements[i].value) >= 0) {
				inputElements[i].checked = true;
			} else{
				inputElements[i].checked = false;
			}
		}
		values = newValues;
	}
	var update = function() {
		values = [];
		for(var i=0; i<inputElements.length;i++) {
			if(inputElements[i].checked) {
				values.push(inputElements[i].value);
			}
		}
	}
	var addEventListener = function(callbackfunction) {
		for(var i=0; i<inputElements.length;i++) {
			inputElements[i].addEventListener('change', callbackfunction);
		}
	}
	addEventListener(update);
	return {
		getValues:getValues,
		setValues:setValues,
		addEventListener:addEventListener
	}
} 

var makeTemplateController = function(templates) {
	var makeNewInstanceWithId = function (name, id) {
		for(var i=0; i<templates.length; i++) {
			if(templates[i].getAttribute('id') == name) {
				var idReg = new RegExp("{{"+templates[i].getAttribute('data-dtUi-code')+"}}", "g");
				var str = templates[i].innerHTML;
				str = str.replace(idReg, id);
				return str;				
			}
		}
		return "";
	}
	return {
		makeNewInstanceWithId:makeNewInstanceWithId
	}
}

var templateController = makeTemplateController(document.getElementsByClassName('dtUi-template'));

var makeGenericInputController = function(id) {
	var calculator = document.getElementById(id);	
	var pwound = document.getElementById(id+"_wound");
	var damage = document.getElementById(id+"_damage");
	var attempts = document.getElementById(id+"_attempts");
	var wounds = document.getElementById(id+"_wounds");
	var remove = document.getElementById(id+"_remove");
	
	addRegExpValidator(pwound, regExPerc, pwound.parentNode);
	addRegExpValidator(damage, regExDice, damage.parentNode);
	addRegExpValidator(attempts, regExDice, attempts.parentNode);
	addRegExpValidator(wounds, regExSmallNum, wounds.parentNode);
	
	var getQuery = function() {
		return "b:" + pwound.value + ":" + attempts.value.replace('+','.') + ":" + damage.value.replace('+','.') + ":" + wounds.value;
	}
	var setValues = function(values) {
		pwound.value = ("pwound" in values)? values.pwound : pwound.value;
		damage.value = ("damage" in values)? values.damage : damage.value;
		attempts.value = ("attempts" in values)? values.attempts : attempts.value;
		wounds.value = ("wounds" in values)? values.wounds : wounds.value;
	}
	var getRemoveButton = function() {
		return remove;
	}
	var getCalculator = function() {
		return calculator;
	}	
	return {
		getQuery:getQuery,
		getRemoveButton:getRemoveButton,
		getCalculator:getCalculator,
		setValues:setValues
	}

}

var makeAutowoundsInputController = function(id) {
	var calculator = document.getElementById(id);	
	var poccur = document.getElementById(id+"_poccur");
	var wounds = document.getElementById(id+"_wounds");
	var remove = document.getElementById(id+"_remove");
	
	addRegExpValidator(poccur, regExPerc, poccur.parentNode);
	addRegExpValidator(wounds, regExDice, wounds.parentNode);
	
	var getQuery = function() {
		return "a:" + poccur.value + ":" + wounds.value.replace('+','.');
	}
	var setValues = function(values) {
		poccur.value = ("poccur" in values)? values.poccur : poccur.value;
		wounds.value = ("wounds" in values)? values.wounds : wounds.value;
	}
	var getRemoveButton = function() {
		return remove;
	}
	var getCalculator = function() {
		return calculator;
	}	
	return {
		getQuery:getQuery,
		getRemoveButton:getRemoveButton,
		getCalculator:getCalculator,
		setValues:setValues
	}

}


var makeAosInputController = function(id) {
	var calculator = document.getElementById(id+"");	
	var hitRoll = document.getElementById(id+"_hitroll");
	var woundRoll = document.getElementById(id+"_woundroll");
	var saveRoll = document.getElementById(id+"_saveroll");
	var hitReRoll = document.getElementById(id+"_hitreroll");
	var woundReRoll = document.getElementById(id+"_woundreroll");
	var saveReRoll = document.getElementById(id+"_savereroll");
	var damage = document.getElementById(id+"_damage");
	var attempts = document.getElementById(id+"_attempts");
	var remove = document.getElementById(id+"_remove");
	
	addRegExpValidator(damage, regExDice, damage.parentNode);
	addRegExpValidator(attempts, regExDice, attempts.parentNode);
			
	var hitReRoller = makeButtonRollController(hitReRoll, 
		["No re-rolls", "Re-roll 1", "Re-roll 1,2", "Re-roll fails"],
		[ 0, 1, 2, 3], 0, 'btn-activated');
	var woundReRoller = makeButtonRollController(woundReRoll,
		["No re-rolls", "Re-roll 1", "Re-roll 1,2", "Re-roll fails"],
		[ 0, 1, 2, 3], 0, 
		'btn-activated'	);
	var saveReRoller = makeButtonRollController(saveReRoll,
		["No re-rolls", "Re-roll 1", "Re-roll 1,2", "Re-roll fails"],
		[ 0, 1, 2, 3], 0, 
		'btn-activated'	);
	var hitRoller = makeDiceRollController(hitRoll, 'images/iconpack.svg', 
		["#dauto",	"#d2",	"#d3",	"#d4",	"#d5",	"#d6"],
		[1, 		2, 		3, 		4, 		5, 		6],
		4);
	var woundRoller = makeDiceRollController(woundRoll, 'images/iconpack.svg', 
		["#dauto",	"#d2",	"#d3",	"#d4",	"#d5",	"#d6"],
		[1, 		2, 		3, 		4, 		5, 		6],
		4);
	var saveRoller = makeDiceRollController(saveRoll, 'images/iconpack.svg', 
		["#dnone",	"#d2",	"#d3",	"#d4",	"#d5",	"#d6"],
		[0, 		2, 		3, 		4, 		5, 		6],
		4);
	
	var getQuery = function() {
		return "r:" + hitRoller.getValue() + woundRoller.getValue() + saveRoller.getValue() 
			+ ":" + attempts.value.replace('+','.') + ":" + damage.value.replace('+','.')
			+ ":m" + hitReRoller.getValue() + woundReRoller.getValue() + saveReRoller.getValue();
	}
	var setValues = function(values) {
		if ("hitroll" in values) hitRoller.setValue(values.hitroll);
		if ("woundroll" in values) woundRoller.setValue(values.woundroll);
		if ("saveroll" in values) saveRoller.setValue(values.saveroll);
		if ("hitreroll" in values) hitReRoller.setValue(values.hitreroll);
		if ("woundreroll" in values) woundReRoller.setValue(values.woundreroll);
		if ("savereroll" in values) saveReRoller.setValue(values.savereroll);
		damage.value = ("damage" in values)? values.damage : damage.value;
		attempts.value = ("attempts" in values)? values.attempts : attempts.value;	
	}
	var getRemoveButton = function() {
		return remove;
	}
	var getCalculator = function() {
		return calculator;
	}	
	return {
		getQuery:getQuery,
		getRemoveButton:getRemoveButton,
		getCalculator:getCalculator,
		setValues:setValues
	}

}

var make9thageInputController = function(id) {
	var calculator = document.getElementById(id+"");	
	var hitRoll = document.getElementById(id+"_hitroll");
	var woundRoll = document.getElementById(id+"_woundroll");
	var saveRoll = document.getElementById(id+"_saveroll");
	var wardRoll = document.getElementById(id+"_wardroll");

	var hitReRoll = document.getElementById(id+"_hitreroll");
	var woundReRoll = document.getElementById(id+"_woundreroll");
	var saveReRoll = document.getElementById(id+"_savereroll");
	var wardReRoll = document.getElementById(id+"_wardreroll");
	
	var multiwounds = document.getElementById(id+"_multiwounds");
	var wounds = document.getElementById(id+"_wounds");
	var attempts = document.getElementById(id+"_attempts");
	
	var remove = document.getElementById(id+"_remove");
	
	addRegExpValidator(multiwounds, regExDice, multiwounds.parentNode);
	addRegExpValidator(wounds, regExSmallNum, wounds.parentNode);
	addRegExpValidator(attempts, regExDice, attempts.parentNode);
			
	var hitRoller = makeDiceRollController(hitRoll, 'images/iconpack.svg', 
		["#dauto",	"#d2",	"#d3",	"#d4",	"#d5",	"#d6",	"#d7",	"#d8",	"#d9"],
		[1, 		2, 		3, 		4, 		5, 		6,	7,	8,	9],
		4);
	var woundRoller = makeDiceRollController(woundRoll, 'images/iconpack.svg', 
		["#dauto",	"#d2",	"#d3",	"#d4",	"#d5",	"#d6"],
		[1, 		2, 		3, 		4, 		5, 		6],
		4);
	var saveRoller = makeDiceRollController(saveRoll, 'images/iconpack.svg', 
		["#dnone",	"#d2",	"#d3",	"#d4",	"#d5",	"#d6"],
		[0, 		2, 		3, 		4, 		5, 		6],
		4);
	var wardRoller = makeDiceRollController(wardRoll, 'images/iconpack.svg', 
		["#dnone",	"#d2",	"#d3",	"#d4",	"#d5",	"#d6"],
		[0, 		2, 		3, 		4, 		5, 		6],
		4);		
	var hitReRoller = makeButtonRollController(hitReRoll, 
		["No re-rolls", "Re-roll 1", "Re-roll 1,2", "Re-roll fails"],
		[ 0, 1, 2, 3], 0, 'btn-activated');
	var woundReRoller = makeButtonRollController(woundReRoll,
		["No re-rolls", "Re-roll 1", "Re-roll 1,2", "Re-roll fails"],
		[ 0, 1, 2, 3], 0, 
		'btn-activated'	);
	var saveReRoller = makeButtonRollController(saveReRoll,
		["No re-rolls", "Re-roll 1", "Re-roll 1,2", "Re-roll fails"],
		[ 0, 1, 2, 3], 0, 
		'btn-activated'	);
	var wardReRoller = makeButtonRollController(wardReRoll,
		["No re-rolls", "Re-roll 1", "Re-roll 1,2", "Re-roll fails"],
		[ 0, 1, 2, 3], 0,
		'btn-activated'	);
		
	var ruleChecker = makeCheckGroupController(document.getElementsByName(id+'_rule'));
		
	var getQuery = function() {
		return "r9:" + hitRoller.getValue() + woundRoller.getValue() + saveRoller.getValue() + wardRoller.getValue() 
		+ ":" + attempts.value.replace('+','.') + ":" + multiwounds.value.replace('+','.') + ":" + wounds.value
		+ ":m" + hitReRoller.getValue() + woundReRoller.getValue() + saveReRoller.getValue() + wardReRoller.getValue()
		+ ((ruleChecker.getValues().length > 0)? ":r" + ruleChecker.getValues().join(".") : "");
	}
	var setValues = function(values) {
		if ("hitroll" in values) hitRoller.setValue(values.hitroll);
		if ("woundroll" in values) woundRoller.setValue(values.woundroll);
		if ("saveroll" in values) saveRoller.setValue(values.saveroll);
		if ("wardroll" in values) wardRoller.setValue(values.wardroll);		
		if ("hitreroll" in values) hitReRoller.setValue(values.hitreroll);
		if ("woundreroll" in values) woundReRoller.setValue(values.woundreroll);
		if ("savereroll" in values) saveReRoller.setValue(values.savereroll);
		if ("wardreroll" in values) wardReRoller.setValue(values.wardreroll);
		if ("rules" in values) ruleChecker.setValues(values.rules);
		multiwounds.value = ("multiwounds" in values)? values.multiwounds : multiwounds.value;
		wounds.value = ("wounds" in values)? values.wounds : wounds.value;
		attempts.value = ("attempts" in values)? values.attempts : attempts.value;	
	}
	var getRemoveButton = function() {
		return remove;
	}
	var getCalculator = function() {
		return calculator;
	}	
	return {
		getQuery:getQuery,
		getRemoveButton:getRemoveButton,
		getCalculator:getCalculator,
		setValues:setValues
	}

}

var makeWfb8thInputController = function(id) {
	var calculator = document.getElementById(id+"");	
	var hitRoll = document.getElementById(id+"_hitroll");
	var woundRoll = document.getElementById(id+"_woundroll");
	var saveRoll = document.getElementById(id+"_saveroll");
	var wardRoll = document.getElementById(id+"_wardroll");

	var hitReRoll = document.getElementById(id+"_hitreroll");
	var woundReRoll = document.getElementById(id+"_woundreroll");
	var saveReRoll = document.getElementById(id+"_savereroll");
	var wardReRoll = document.getElementById(id+"_wardreroll");
	
	var multiwounds = document.getElementById(id+"_multiwounds");
	var wounds = document.getElementById(id+"_wounds");
	var attempts = document.getElementById(id+"_attempts");
	
	var remove = document.getElementById(id+"_remove");
	
	addRegExpValidator(multiwounds, regExDice, multiwounds.parentNode);
	addRegExpValidator(wounds, regExSmallNum, wounds.parentNode);
	addRegExpValidator(attempts, regExDice, attempts.parentNode);
			
	var hitRoller = makeDiceRollController(hitRoll, 'images/iconpack.svg', 
		["#dauto",	"#d2",	"#d3",	"#d4",	"#d5",	"#d6",	"#d7",	"#d8",	"#d9"],
		[1, 		2, 		3, 		4, 		5, 		6,	7,	8,	9],
		4);
	var woundRoller = makeDiceRollController(woundRoll, 'images/iconpack.svg', 
		["#dauto",	"#d2",	"#d3",	"#d4",	"#d5",	"#d6"],
		[1, 		2, 		3, 		4, 		5, 		6],
		4);
	var saveRoller = makeDiceRollController(saveRoll, 'images/iconpack.svg', 
		["#dnone",	"#d2",	"#d3",	"#d4",	"#d5",	"#d6"],
		[0, 		2, 		3, 		4, 		5, 		6],
		4);
	var wardRoller = makeDiceRollController(wardRoll, 'images/iconpack.svg', 
		["#dnone",	"#d2",	"#d3",	"#d4",	"#d5",	"#d6"],
		[0, 		2, 		3, 		4, 		5, 		6],
		4);		
	var hitReRoller = makeButtonRollController(hitReRoll, 
		["No re-rolls", "Re-roll 1", "Re-roll 1,2", "Re-roll fails"],
		[ 0, 1, 2, 3], 0, 'btn-activated');
	var woundReRoller = makeButtonRollController(woundReRoll,
		["No re-rolls", "Re-roll 1", "Re-roll 1,2", "Re-roll fails"],
		[ 0, 1, 2, 3], 0, 
		'btn-activated'	);
	var saveReRoller = makeButtonRollController(saveReRoll,
		["No re-rolls", "Re-roll 1", "Re-roll 1,2", "Re-roll fails"],
		[ 0, 1, 2, 3], 0, 
		'btn-activated'	);
	var wardReRoller = makeButtonRollController(wardReRoll,
		["No re-rolls", "Re-roll 1", "Re-roll 1,2", "Re-roll fails"],
		[ 0, 1, 2, 3], 0,
		'btn-activated'	);
		
	var ruleChecker = makeCheckGroupController(document.getElementsByName(id+'_rule'));
		
	var getQuery = function() {
		return "r8:" + hitRoller.getValue() + woundRoller.getValue() + saveRoller.getValue() + wardRoller.getValue() 
		+ ":" + attempts.value.replace('+','.') + ":" + multiwounds.value.replace('+','.') + ":" + wounds.value
		+ ":m" + hitReRoller.getValue() + woundReRoller.getValue() + saveReRoller.getValue() + wardReRoller.getValue()
		+ ((ruleChecker.getValues().length > 0)? ":r" + ruleChecker.getValues().join(".") : "");
	}
	var setValues = function(values) {
		if ("hitroll" in values) hitRoller.setValue(values.hitroll);
		if ("woundroll" in values) woundRoller.setValue(values.woundroll);
		if ("saveroll" in values) saveRoller.setValue(values.saveroll);
		if ("wardroll" in values) wardRoller.setValue(values.wardroll);		
		if ("hitreroll" in values) hitReRoller.setValue(values.hitreroll);
		if ("woundreroll" in values) woundReRoller.setValue(values.woundreroll);
		if ("savereroll" in values) saveReRoller.setValue(values.savereroll);
		if ("wardreroll" in values) wardReRoller.setValue(values.wardreroll);
		if ("rules" in values) ruleChecker.setValues(values.rules);
		multiwounds.value = ("multiwounds" in values)? values.multiwounds : multiwounds.value;
		wounds.value = ("wounds" in values)? values.wounds : wounds.value;
		attempts.value = ("attempts" in values)? values.attempts : attempts.value;	
	}
	var getRemoveButton = function() {
		return remove;
	}
	var getCalculator = function() {
		return calculator;
	}	
	return {
		getQuery:getQuery,
		getRemoveButton:getRemoveButton,
		getCalculator:getCalculator,
		setValues:setValues
	}

}



var makeStatsWfb8thInputController = function(id) {
	var calculator = document.getElementById(id+"");	
	var remove = document.getElementById(id+"_remove");
	
	var attacker_ws = document.getElementById(id+"_attacker_ws");
	var attacker_s = document.getElementById(id+"_attacker_s");
	var attacker_multiwounds = document.getElementById(id+"_attacker_multiwounds");
	var attacker_attacks = document.getElementById(id+"_attacker_attacks");
	
	var defender_ws = document.getElementById(id+"_defender_ws");
	var defender_t = document.getElementById(id+"_defender_t");
	var defender_as = document.getElementById(id+"_defender_as");
	var defender_ward = document.getElementById(id+"_defender_ward");
	var defender_w = document.getElementById(id+"_defender_w");
	
	
	var getQuery = function() {
		return "s8:a:"
			+attacker_ws.value
			+"." +attacker_s.value
			+":" +attacker_multiwounds.value
			+":" +attacker_attacks.value
			+":d:"
			+defender_ws.value
			+"." +defender_t.value
			+"." +defender_as.value
			+"." +defender_ward.value
			+"." +defender_w.value;
	}
	var setValues = function(values) {
		
	}
	var getRemoveButton = function() {
		return remove;
	}
	var getCalculator = function() {
		return calculator;
	}	
	return {
		getQuery:getQuery,
		getRemoveButton:getRemoveButton,
		getCalculator:getCalculator,
		setValues:setValues
	}

}



return {
	makeDiceRollController:makeDiceRollController, 
	makeButtonRollController:makeButtonRollController, 
	addRegExpValidator:addRegExpValidator,
	regExDice:regExDice,
	regExPerc:regExPerc,
	regExSmallNum:regExSmallNum,
	templateController:templateController,
	makeCheckGroupController:makeCheckGroupController,
	makeGenericInputController:makeGenericInputController,
	make9thageInputController:make9thageInputController,
	makeWfb8thInputController:makeWfb8thInputController,
	makeAosInputController:makeAosInputController,
	makeStatsWfb8thInputController:makeStatsWfb8thInputController,
	makeAutowoundsInputController:makeAutowoundsInputController 
	
	
};
}()); 
