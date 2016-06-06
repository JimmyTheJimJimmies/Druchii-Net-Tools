	<div  class="row" style="height:20px">
		<button class="btn btn-default" type="button" data-toggle="collapse" data-target="#configuration" aria-expanded="false" aria-controls="configuration">
			<span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Configure report
		</button>

	</div>
	
	<div class="collapse" id="configuration">
	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<h3>Type of report</h3>			
			<p>Choose one or more. If no type is selected, it will default to individual outcomes and summary. </p>
		</div>
	
		<input type="checkbox" name="reporttype" id="checkindividual" value="i" class="hidden" <?php if(in_array('i', $format)) {echo 'checked="checked"';}?>/>
		<label for="checkindividual" class="list-group-item col-xs-6 col-sm-2 activate" id="reportindividual">
			<img class="reportbutton" src="graph.php?q=b:0.7:4&f=i&t=0.05"/>
			<p>Individual outcomes</p>
		</label>
		
		<input type="checkbox" name="reporttype" id="checksummary" value="s" class="hidden" <?php if(in_array('s', $format)) {echo 'checked="checked"';}?>/>			
		<label for="checksummary" class="list-group-item col-xs-6 col-sm-2 activate" id="reportsummary">
			<img  class="reportbutton" src="graph.php?q=b:0.3:4&f=s" />
			<p>Summary</p>
		</label>
		
		<input type="checkbox" name="reporttype" id="checkcumulative" value="c" class="hidden" <?php if(in_array('c', $format)) {echo 'checked="checked"';}?>/>
		<label for="checkcumulative" class="list-group-item col-xs-6 col-sm-2 activate" id="reportcumulative">
			<img  class="reportbutton" src="graph.php?q=p:0.4:0.4:3&f=c" />
			<p>Equal or less</p>
		</label>
	
		<input type="checkbox" name="reporttype" id="checkreductive" value="r" class="hidden" <?php if(in_array('r', $format)) {echo 'checked="checked"';}?>/>
		<label for="checkreductive" class="list-group-item col-xs-6 col-sm-2 activate" id="reportreductive">
			<img  class="reportbutton" src="graph.php?q=p:0.5:0.5:3&f=r" />
			<p>Equal or more</p>
		</label>
		
		<input type="checkbox" name="reporttype" id="checkvariance" value="v" class="hidden" <?php if(in_array('v', $format)) {echo 'checked="checked"';}?>/>
		<label for="checkvariance" class="list-group-item col-xs-6 col-sm-2 activate" id="reportvariance">
			<img  class="reportbutton" src="graph.php?q=b:0.5:3&f=v" />
			<p>Variance and deviation</p>
		</label>
		
		<div class="col-xs-12 col-sm-12">
			<h3>Colour scheme</h3>
		</div>
		
		<input type="radio" name="colourscheme" id="colourdefault" value="0" class="hidden" <?php if($style_number == 0) {echo 'checked="checked"';}?>/>
		<label for="colourdefault" class="list-group-item col-xs-6 col-sm-2 activate" id="reportcolourdefault">
			<img class="reportbutton" src="graph.php?q=b:0.6:5&f=is&t=0.02&s=0"/>
			<p>Default</p>
		</label>
		
		<input type="radio" name="colourscheme" id="colourdnet" value="1" class="hidden" <?php if($style_number == 1) {echo 'checked="checked"';}?>/>			
		<label for="colourdnet" class="list-group-item col-xs-6 col-sm-2 activate" id="reportcolourdnet">
			<img  class="reportbutton" src="graph.php?q=b:0.6:5&f=is&t=0.02&s=1" />
			<p>Druchii.net</p>
		</label>
		
		<input type="radio" name="colourscheme" id="colourwhite" value="2" class="hidden" <?php if($style_number == 2) {echo 'checked="checked"';}?>/>
		<label for="colourwhite" class="list-group-item col-xs-6 col-sm-2 activate" id="reportcolourwhite">
			<img  class="reportbutton" src="graph.php?q=b:0.6:5&f=is&t=0.02&s=2" />
			<p>Opaque</p>
		</label>

		<div class="col-xs-12 col-sm-8">
			<p>Colour schemes can be added on request. Please submit your request on <a href="http://www.druchii.net/viewforum.php?f=5">our suggestions board</a>.
		</div>
		
	</div>
	</div>
	</div>
	