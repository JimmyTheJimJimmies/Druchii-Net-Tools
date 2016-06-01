<div id="templates" style="display:none">
	<div class="dtUi-template" id="generic-calculator" data-dtUi-code="generic_id">
		<div class="row list-group-item" id="{{generic_id}}">	
			<div class="col-xs-6 col-sm-2 form-group">
			<label class="control-label" for="{{generic_id}}_wound">Chance to Wound</label>
			<input type="text" class="form-control dtUi-validated" name="{{generic_id}}_wound" id="{{generic_id}}_wound" value="0.2"  title="A number, from 0 to 1"/>
			</div>
			
			<div class="col-xs-6 col-sm-2 form-group">
			<label class="control-label" for="{{generic_id}}_damage">Damage</label>
			<input type="text" class="form-control dtUi-validated" name="{{generic_id}}_damage" id="{{generic_id}}_damage" value="1"  title="A number or dice exp like 10 or 2d3+1"/>
			</div>
			
			<div class="col-xs-6 col-sm-2 form-group">
			<label class="control-label" for="{{generic_id}}_wounds">Wounds</label>
			<input type="text" class="form-control dtUi-validated" name="{{generic_id}}_wounds" id="{{generic_id}}_wounds" value="0"  title="A number, smaller than 100"/>
			</div>
			
			<div class="col-xs-6 col-sm-2 form-group">
			<label class="control-label" for="{{generic_id}}_attempts">Attacks</label>
			<input type="text" class="form-control dtUi-validated" name="{{generic_id}}_attempts" id="{{generic_id}}_attempts" value="10" title="A number or dice exp like 10 or 2d3+1"/>
			</div>
			<div class="col-xs-6 col-sm-2 form-group">
			</div>
			
			<div class="col-xs-6 col-sm-2 form-group text-right">
			<label class="control-label">&nbsp;</label><br/>
				<button class="btn btn-danger dtUi-remove" name="{{generic_id}}_remove" id="{{generic_id}}_remove" >Remove</button>
			</div>
		</div>
	</div>
	<div class="dtUi-template" id="autowounds-calculator" data-dtUi-code="autowounds_id">
		<div class="row list-group-item" id="{{autowounds_id}}">	
			<div class="col-xs-6 col-sm-2 form-group">
			<label class="control-label" for="{{autowounds_id}}_poccur">Chance on autowounds</label>
			<input type="text" class="form-control dtUi-validated" name="{{autowounds_id}}_poccur" id="{{autowounds_id}}_poccur" value="1.0"  title="A number, from 0 to 1"/>
			</div>
			
			<div class="col-xs-6 col-sm-2 form-group">
			<label class="control-label" for="{{autowounds_id}}_wounds">Number of autowounds</label>
			<input type="text" class="form-control dtUi-validated" name="{{autowounds_id}}_damage" id="{{autowounds_id}}_wounds" value="d3"  title="A number or dice exp like 10 or 2d3+1"/>
			</div>
			
			<div class="col-xs-6 col-sm-6 form-group">
			</div>
			
			<div class="col-xs-6 col-sm-2 form-group text-right">
			<label class="control-label">&nbsp;</label><br/>
				<button class="btn btn-danger dtUi-remove" name="{{autowounds_id}}_remove" id="{{autowounds_id}}_remove" >Remove</button>
			</div>
		</div>
	</div>
	<div class="dtUi-template" id="aos-calculator" data-dtUi-code="aos_id">
		<div class="row list-group-item" id="{{aos_id}}">	
			<div class="col-xs-4 col-sm-2">
			<label class="control-label">To hit</label><br/>
			<svg class="dice-large" viewBox="0 0 100 100">
				<use id="{{aos_id}}_hitroll" xlink:href="images/iconpack.svg#d4"></use>
			</svg>
			<br/>
			<button id="{{aos_id}}_hitreroll" class="btn-reroll btn btn-md btn-default">No re-rolls</button>
			</div>
			
			<div class="col-xs-4 col-sm-2">
			<label class="control-label">Wound</label><br/>
			<svg class="dice-large" viewBox="0 0 100 100">
				<use id="{{aos_id}}_woundroll" xlink:href="images/iconpack.svg#d4"></use>
			</svg>
			<br/>
			<button id="{{aos_id}}_woundreroll" class="btn-reroll btn btn-md btn-default">No re-rolls</button>
			</div>
			
			<div class="col-xs-4 col-sm-2">
			<label class="control-label">Save</label><br/>
			<svg class="dice-large" viewBox="0 0 100 100">
				<use id="{{aos_id}}_saveroll" xlink:href="images/iconpack.svg#d4"></use>
			</svg>
			<br/>
			<button id="{{aos_id}}_savereroll" class="btn-reroll btn btn-md btn-default">No re-rolls</button>
			</div>
			
			<div class="col-xs-8 col-sm-2">
				<div class="row">
					<div class="col-xs-6 col-sm-12 form-group">
					<label class="control-label" for="{{aos_id}}_damage">Damage</label><br/>
					<input type="text" class="form-control " name="{{aos_id}}_damage" id="{{aos_id}}_damage" value="1"  title="A number or dice exp like 10 or 2d3+1"/>
					</div>
					
					<div class="col-xs-6 col-sm-12 form-group">
					<label class="control-label" for="{{aos_id}}_attempts">Attacks</label><br/>
					<input type="text" class="form-control " name="{{aos_id}}_attempts" id="{{aos_id}}_attempts" value="10" title="A number or dice exp like 10 or 2d3+1"/>
					</div>			
				</div>
			</div>
			
			<div class="col-xs-6 col-sm-2 form-group">
			</div>
			<div class="col-xs-6 col-sm-2 form-group text-right">
			<label class="control-label">&nbsp;</label><br/>
				<button class="btn btn-danger" name="{{aos_id}}_remove" id="{{aos_id}}_remove" >Remove</button>

			</div>
			
		</div>
	</div>
	
	<div class="dtUi-template" id="ninthage-calculator"  data-dtUi-code="ninth_id">
		<div class="row list-group-item" id="{{ninth_id}}">	
			<div class="col-xs-6 col-sm-2">
			<label class="control-label">To hit</label><br/>
			<svg class="large-dice" viewBox="0 0 100 100">
				<use id="{{ninth_id}}_hitroll" xlink:href="images/iconpack.svg#d4"></use>
			</svg>
			<br/>
			<button id="{{ninth_id}}_hitreroll" class="btn-reroll btn btn-md btn-default">No re-rolls</button>		
			<br/>
			<input type="checkbox" id="{{ninth_id}}_poison" class="hidden" name="{{ninth_id}}_rule" value="1"/>
			<label for="{{ninth_id}}_poison" class="btn btn-default btn-reroll btn-md btn-activate">Poison</label>	
			</div>
			
			<div class="col-xs-6 col-sm-2">
			<label class="control-label">Wound</label><br/>
			<svg class="large-dice" viewBox="0 0 100 100">
				<use id="{{ninth_id}}_woundroll" xlink:href="images/iconpack.svg#d4"></use>
			</svg>
			<br/>
			<button id="{{ninth_id}}_woundreroll" class="btn-reroll btn btn-md btn-default">No re-rolls</button>		
			<br/>
			<input type="checkbox" id="{{ninth_id}}_lethalstrike" class="hidden" name="{{ninth_id}}_rule" value="2"/>
			<label for="{{ninth_id}}_lethalstrike" class="btn btn-default btn-reroll btn-md btn-activate">Lethal Strike</label>	
			</div>

			<div class="col-xs-6 col-sm-2">
			<label class="control-label">Save</label><br/>
			<svg class="large-dice" viewBox="0 0 100 100">
				<use id="{{ninth_id}}_saveroll" xlink:href="images/iconpack.svg#d4"></use>
			</svg>
			<br/>
			<button id="{{ninth_id}}_savereroll" class="btn-reroll btn btn-md btn-default">No re-rolls</button>		
			</div>
			
			<div class="col-xs-6 col-sm-2">
			<label class="control-label">Ward</label><br/>
			<svg class="large-dice" viewBox="0 0 100 100">
				<use id="{{ninth_id}}_wardroll" xlink:href="images/iconpack.svg#d4"></use>
			</svg>
			<br/>
			<button id="{{ninth_id}}_wardreroll" class="btn-reroll btn btn-md btn-default">No re-rolls</button>	
			<br/>
			<input type="checkbox" id="{{ninth_id}}_holyattacks" class="hidden"  name="{{ninth_id}}_rule" value="3" />
			<label for="{{ninth_id}}_holyattacks" class="btn btn-default btn-reroll btn-md btn-activate">Holy attacks</label>	
			</div>
			
			<div class="col-xs-12 col-sm-2">
				<div class="row">				
					<div class="col-xs-4 col-sm-12 form-group">
					<label class="control-label" for="{{ninth_id}}_multiwounds">Multiple wounds</label>
					<input type="text" class="form-control" name="{{ninth_id}}_multiwounds" id="{{ninth_id}}_multiwounds" value="1"  title="A number or dice exp like 10 or 2d3+1"/>
					</div>
					
					<div class="col-xs-4 col-sm-12 form-group">
					<label class="control-label" for="{{ninth_id}}_wounds">Target wounds</label>
					<input type="text" class="form-control " name="{{ninth_id}}_wounds" id="{{ninth_id}}_wounds" value="1"  title="A number, smaller than 100"/>
					</div>
					
					<div class="col-xs-4 col-sm-12 form-group">
					<label class="control-label" for="attempts">Attacks</label>
					<input type="text" class="form-control " name="{{ninth_id}}_attempts" id="{{ninth_id}}_attempts" value="10" title="A number or dice exp like 10 or 2d3+1"/>
					</div>
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-2 form-group text-right">
			<label class="control-label">&nbsp;</label><br/>
				<button class="btn btn-danger dtUi-remove" name="{{ninth_id}}_remove" id="{{ninth_id}}_remove" >Remove</button>
			</div>
		</div>
	</div>
	
	<div class="dtUi-template" id="wfb8th-calculator"  data-dtUi-code="wfb_id">
		<div class="row list-group-item" id="{{wfb_id}}">	
			<div class="col-xs-6 col-sm-2">
			<label class="control-label">To hit</label><br/>
			<svg class="large-dice" viewBox="0 0 100 100">
				<use id="{{wfb_id}}_hitroll" xlink:href="images/iconpack.svg#d4"></use>
			</svg>
			<br/>
			<button id="{{wfb_id}}_hitreroll" class="btn-reroll btn btn-md btn-default">No re-rolls</button>		
			<br/>
			<input type="checkbox" id="{{wfb_id}}_poison" class="hidden" name="{{wfb_id}}_rule" value="1"/>
			<label for="{{wfb_id}}_poison" class="btn btn-default btn-reroll btn-md btn-activate">Poison</label>	
			</div>
			
			<div class="col-xs-6 col-sm-2">
			<label class="control-label">Wound</label><br/>
			<svg class="large-dice" viewBox="0 0 100 100">
				<use id="{{wfb_id}}_woundroll" xlink:href="images/iconpack.svg#d4"></use>
			</svg>
			<br/>
			<button id="{{wfb_id}}_woundreroll" class="btn-reroll btn btn-md btn-default">No re-rolls</button>		
			<br/>
			<input type="checkbox" id="{{wfb_id}}_killingblow" class="hidden" name="{{wfb_id}}_rule" value="2"/>
			<label for="{{wfb_id}}_killingblow" class="btn btn-default btn-reroll btn-md btn-activate">Killing Blow</label>	
			</div>

			<div class="col-xs-6 col-sm-2">
			<label class="control-label">Save</label><br/>
			<svg class="large-dice" viewBox="0 0 100 100">
				<use id="{{wfb_id}}_saveroll" xlink:href="images/iconpack.svg#d4"></use>
			</svg>
			<br/>
			<button id="{{wfb_id}}_savereroll" class="btn-reroll btn btn-md btn-default">No re-rolls</button>		
			</div>
			
			<div class="col-xs-6 col-sm-2">
			<label class="control-label">Ward</label><br/>
			<svg class="large-dice" viewBox="0 0 100 100">
				<use id="{{wfb_id}}_wardroll" xlink:href="images/iconpack.svg#d4"></use>
			</svg>
			<br/>
			<button id="{{wfb_id}}_wardreroll" class="btn-reroll btn btn-md btn-default">No re-rolls</button>	
			<br/>
			<input type="checkbox" id="{{wfb_id}}_trickstershard" class="hidden"  name="{{wfb_id}}_rule" value="3" />
			<label for="{{wfb_id}}_trickstershard" class="btn btn-default btn-reroll btn-md btn-activate">Trickster Shard</label>	
			</div>
			
			<div class="col-xs-12 col-sm-2">
				<div class="row">				
					<div class="col-xs-4 col-sm-12 form-group">
					<label class="control-label" for="{{wfb_id}}_multiwounds">Multiple wounds</label>
					<input type="text" class="form-control" name="{{wfb_id}}_multiwounds" id="{{wfb_id}}_multiwounds" value="1"  title="A number or dice exp like 10 or 2d3+1"/>
					</div>
					
					<div class="col-xs-4 col-sm-12 form-group">
					<label class="control-label" for="{{wfb_id}}_wounds">Target wounds</label>
					<input type="text" class="form-control " name="{{wfb_id}}_wounds" id="{{wfb_id}}_wounds" value="1"  title="A number, smaller than 100"/>
					</div>
					
					<div class="col-xs-4 col-sm-12 form-group">
					<label class="control-label" for="attempts">Attacks</label>
					<input type="text" class="form-control " name="{{wfb_id}}_attempts" id="{{wfb_id}}_attempts" value="10" title="A number or dice exp like 10 or 2d3+1"/>
					</div>
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-2 form-group text-right">
			<label class="control-label">&nbsp;</label><br/>
				<button class="btn btn-danger dtUi-remove" name="{{wfb_id}}_remove" id="{{wfb_id}}_remove" >Remove</button>
			</div>
		</div>
	</div>
	
	
	<div class="dtUi-template" id="statswfb8th-calculator"  data-dtUi-code="statswfb_id">
		<div class="row list-group-item" id="{{statswfb_id}}">	
		
		
			<div class="col-xs-12">	
			<label>Attacker</label>
			</div>
			
			<div class="col-xs-6 col-sm-2">
			<label class="control-label" for="{{statswfb_id}}_attacker_ws">WS</label><br/>
			<input type="text" class="form-control" name="{{statswfb_id}}_attacker_ws" id="{{statswfb_id}}_attacker_ws" value="3"  title="A number from 0 to 10"/>
			</div>
			
			<div class="col-xs-6 col-sm-2">
			<label class="control-label" for="{{statswfb_id}}_attacker_s">Strength</label><br/>
			<input type="text" class="form-control" name="{{statswfb_id}}_attacker_s" id="{{statswfb_id}}_attacker_s" value="3"  title="A number from 0 to 10"/>
			</div>			
			
			<div class="col-xs-6 col-sm-2 form-group">
			<label class="control-label" for="{{statswfb_id}}_attacker_multiwounds">Multiple wounds</label>
			<input type="text" class="form-control" name="{{statswfb_id}}_attacker_multiwounds" id="{{statswfb_id}}_attacker_multiwounds" value="1"  title="A number or dice exp like 10 or 2d3+1"/>
			</div>		
			
			<div class="col-xs-6 col-sm-2 form-group">
			<label class="control-label" for="{{statswfb_id}}_attacker_attacks">Attacks</label>
			<input type="text" class="form-control " name="{{statswfb_id}}_attacker_attacks" id="{{statswfb_id}}_attacker_attacks" value="10" title="A number or dice exp like 10 or 2d3+1"/>
			</div>
			
			<div class="col-xs-6 col-sm-2 form-group">
			</div>
			
			<div class="col-xs-12 col-sm-2 form-group text-right">
			<label class="control-label">&nbsp;</label><br/>
				<button class="btn btn-danger dtUi-remove" name="{{statswfb_id}}_remove" id="{{statswfb_id}}_remove" >Remove</button>
			</div>
			
			
			<div class="col-xs-12 col-sm-12">
				<button class="btn btn-default btn-sm" type="button" data-toggle="collapse" data-target="#{{statswfb_id}}_special_rules" aria-expanded="false" aria-controls="{{statswfb_id}}_special_rules">
					Special Rules
				</button>
				
				<div class="row collapse" id="{{statswfb_id}}_special_rules">
					<div class="col-xs-6 col-sm-3">
						<label class="">On hit</label>
						<div class="list-group" >
							<input type="checkbox" class="hidden" name="{{statswfb_id}}_attacker_rule" id="{{statswfb_id}}_attacker_autohit" value="1"/>
							<label for="{{statswfb_id}}_attacker_autohit" class="list-group-item activate"><span class="glyphicon glyphicon-ok concealed" aria-hidden="true"></span> Auto hit</label>
							<input type="checkbox" class="hidden" name="{{statswfb_id}}_attacker_rule" id="{{statswfb_id}}_attacker_asf" value="2"/>
							<label for="{{statswfb_id}}_attacker_asf" class="list-group-item activate"><span class="glyphicon glyphicon-ok concealed" aria-hidden="true"></span> Always strike first</label>
							<input type="checkbox" class="hidden" name="{{statswfb_id}}_attacker_rule" id="{{statswfb_id}}_attacker_asl" value="3"/>
							<label for="{{statswfb_id}}_attacker_asl" class="list-group-item activate"><span class="glyphicon glyphicon-ok concealed" aria-hidden="true"></span> Always strike last</label>
							<input type="checkbox" class="hidden" name="{{statswfb_id}}_attacker_rule" id="{{statswfb_id}}_attacker_hatred" value="10"/>
							<label for="{{statswfb_id}}_attacker_hatred" class="list-group-item activate"><span class="glyphicon glyphicon-ok concealed" aria-hidden="true"></span> Hatred</label>
							<input type="checkbox" class="hidden" name="{{statswfb_id}}_attacker_rule" id="{{statswfb_id}}_attacker_poison" value="4"/>
							<label for="{{statswfb_id}}_attacker_poison" class="list-group-item activate"><span class="glyphicon glyphicon-ok concealed" aria-hidden="true"></span> Poison</label>
						</div>	
					</div>		
					<div class="col-xs-6 col-sm-3">
						<label class="">Wound roll</label>
						<div class="list-group" >
							<input type="checkbox" class="hidden" name="{{statswfb_id}}_attacker_rule" id="{{statswfb_id}}_auto_wound" value="5"/>
							<label for="{{statswfb_id}}_auto_wound" class="list-group-item activate"><span class="glyphicon glyphicon-ok concealed" aria-hidden="true"></span> Auto wound</label>
							<input type="checkbox" class="hidden" name="{{statswfb_id}}_attacker_rule" id="{{statswfb_id}}_murderous_prowess" value="6"/>
							<label for="{{statswfb_id}}_murderous_prowess" class="list-group-item activate"><span class="glyphicon glyphicon-ok concealed" aria-hidden="true"></span> Murderous Prowess</label>
							<input type="checkbox" class="hidden" name="{{statswfb_id}}_attacker_rule" id="{{statswfb_id}}_attacker_killingblow" value="7"/>
							<label for="{{statswfb_id}}_attacker_killingblow" class="list-group-item activate"><span class="glyphicon glyphicon-ok concealed" aria-hidden="true"></span> Killing Blow</label>
						</div>	
							<label>&nbsp;</label><br/>
							<label>&nbsp;</label><br/>
					</div>
					<div class="col-xs-6 col-sm-3">
						<label class="">Other1</label>
						<div class="list-group" >
							<input type="checkbox" class="hidden" name="{{statswfb_id}}_attacker_rule" id="{{statswfb_id}}_attacker_other_trickser_shard" value="8"/>
							<label for="{{statswfb_id}}_attacker_other_trickser_shard" class="list-group-item activate"><span class="glyphicon glyphicon-ok concealed" aria-hidden="true"></span> Other Trickster Shard</label>
							<input type="checkbox" class="hidden" name="{{statswfb_id}}_attacker_rule" id="{{statswfb_id}}_attacker_other_trickser_shard" value="8"/>
							<label for="{{statswfb_id}}_attacker_other_trickser_shard" class="list-group-item activate"><span class="glyphicon glyphicon-ok concealed" aria-hidden="true"></span> Other Trickster Shard</label>
							<input type="checkbox" class="hidden" name="{{statswfb_id}}_attacker_rule" id="{{statswfb_id}}_attacker_other_trickser_shard" value="8"/>
							<label for="{{statswfb_id}}_attacker_other_trickser_shard" class="list-group-item activate"><span class="glyphicon glyphicon-ok concealed" aria-hidden="true"></span> Other Trickster Shard</label>
						</div>	
					</div>		
					<div class="col-xs-6 col-sm-3">
						<label class="">Other2</label>
						<div class="list-group" >
							<input type="checkbox" class="hidden" name="{{statswfb_id}}_attacker_rule" id="{{statswfb_id}}_attacker_other_trickser_shard" value="8"/>
							<label for="{{statswfb_id}}_attacker_other_trickser_shard" class="list-group-item activate"><span class="glyphicon glyphicon-ok concealed" aria-hidden="true"></span> Other Trickster shard</label>
						</div>	
					</div>					
				</div>
			</div>
		
			
			
			<div class="col-xs-12">
			<label>Defender</label>
			</div>			
		
			<div class="col-xs-6 col-sm-2">
			<label class="control-label">WS</label><br/>
			<input type="text" class="form-control" name="{{statswfb_id}}_defender_ws" id="{{statswfb_id}}_defender_ws" value="3"  title="A number from 0 to 10"/>
			</div>
			
			<div class="col-xs-6 col-sm-2">
			<label class="control-label">Toughness</label><br/>
			<input type="text" class="form-control" name="{{statswfb_id}}_defender_t" id="{{statswfb_id}}_defender_t" value="3"  title="A number from 0 to 10"/>
			</div>
			
			<div class="col-xs-6 col-sm-2">
			<label class="control-label">Amour Save</label><br/>
			<input type="text" class="form-control" name="{{statswfb_id}}_defender_as" id="{{statswfb_id}}_defender_as" value="3"  title="A number from 0 to 10"/>
			</div>
			
			<div class="col-xs-6 col-sm-2">
			<label class="control-label">Ward Save</label><br/>
			<input type="text" class="form-control" name="{{statswfb_id}}_defender_ward" id="{{statswfb_id}}_defender_ward" value="3"  title="A number from 0 to 10"/>
			</div>
			
			<div class="col-xs-6 col-sm-2 form-group">
			<label class="control-label" for="{{statswfb_id}}_defender_w">Wounds</label>
			<input type="text" class="form-control " name="{{statswfb_id}}_defender_w" id="{{statswfb_id}}_defender_w" value="1"  title="A number, smaller than 100"/>
			</div>
			
				
			<div class="col-xs-12 col-sm-12">
				<button class="btn btn-default btn-sm">Special Rules</button>
			</div>
			
			
		</div>
	</div>
	
</div>
