<?php 
$title = "Druchii.net Toolbox";
$description = "Analytical tools for tabletop games.";
include "templates/header.php"; ?>

<div class="jumbotron">
	<div class="container">
        <h1>D.net's Toolbox</h1>
        <p>The home for our tools and crafts to hone our murderous prowess.</p>
	</div>
</div>


<div class="container">
	<h2>Combat calculators</h2>


	<div class="list-group">
	
		<a href="AoS-Combat-Calculator.php" class="list-group-item">
			<div class="media-left">
				<svg class="large-dice" viewBox="0 0 100 100"><use xlink:href="images/iconpack.svg#d8"></use></svg>
			</div>
			<div class="media-body">
				<h4 class="list-group-item-heading">Age of Sigmar - Combat Calculator</h4>
				<p class="list-group-item-text">Designed for AoS, this tool visually prints the detailed performance of a unit, multiple units, and/or units with multiple types of attacks.</p>
			</div>
		</a>
		
		<a href="9th-Combat-Calculator.php" class="list-group-item">
			<div class="media-left">
				<svg class="large-dice" viewBox="0 0 100 100"><use xlink:href="images/iconpack.svg#d9"></use></svg>
			</div>
			<div class="media-body">
				<h4 class="list-group-item-heading">9th Age - Combat Calculator</h4>
				<p class="list-group-item-text">Designed for the 9th Age, this tool visually prints the detailed performance of a unit, multiple units, and/or units with multiple types of attacks.</p>
			</div>
		</a>
		<a href="8th-Combat-Calculator.php" class="list-group-item">
			<div class="media-left">
				<svg class="large-dice" viewBox="0 0 100 100"><use xlink:href="images/iconpack.svg#d7"></use></svg>
			</div>
			<div class="media-body">
				<h4 class="list-group-item-heading">8th ed Warhammer - Combat Calculator</h4>
				<p class="list-group-item-text">Designed for classic Warhammer Fantasy Battles, this tool visually prints the detailed performance of a unit, multiple units, and/or units with multiple types of attacks.</p>
			</div>
		</a>	
		<a href="Generic-Combat-Calculator.php" class="list-group-item">
			<div class="media-left">
				<svg class="large-dice"><text x="15" y="65" font-size="60" fill="currentColor">&#37;</text></svg>
			</div>
			<div class="media-body">
				<h4 class="list-group-item-heading">Generic Combat Calculator</h4>
				<p class="list-group-item-text">The generic combat calculator calculates the performance of a unit, permitting mathematical input (chance to wound, number of attacks) or input forms from any supported game platform. This is used for testing, theoretical examination or features that are not yet supported.</p>
			</div>
		</a>	
		<a href="Dice-Roller.php" class="list-group-item">
			<div class="media-left">
				<svg class="large-dice" viewBox="0 0 100 100"><use xlink:href="images/iconpack.svg#d4"></use></svg>
			</div>
			<div class="media-body">
				<h4 class="list-group-item-heading">Dice Roller</h4>
				<p class="list-group-item-text">A simple tool to roll some dice, in case you forgot your dice bag. Tsk!</p>
			</div>
		</a>	
		<a href="AoS-Comp-Comparator.php" class="list-group-item">
			<div class="media-left">
				<svg class="large-dice" viewBox="0 0 100 100"><use xlink:href="images/iconpack.svg#hit"></use></svg>
			</div>
			<div class="media-body">
				<h4 class="list-group-item-heading">AoS Comp Comparator</h4>
				<p class="list-group-item-text">A tool to compare the point systems of different comp packs.</p>
			</div>
		</a>	
	</div>
	
	<h3>Legacy tools</h3>
	
			<p>The "Simple" calculators have been upgraded to a newer version, available above. Images and links generated with these old tools remain functional, though we recommend using only the newer version for the calculators.</p>
	
	<div class="row">
		<div class="col-xs-0 col-sm-2">
			
		</div>
		
		<div class="col-sm-8 col-xs-12">
		<div class="list-group ">
		</div>
		</div>
	</div>
	
	
	
	
	<div class="row">
	<div class="col-xs-12 col-md-4">
	<h2>Join the discussion!</h2>
		<ol>
			<li>Analyse your game's mechanics</li>
			<li>Check a unit's performance on the table</li>
			<li>Share and link your findings!</li>
		</ol>
		<p>Join <a href="http://www.druchii.net/index.php">the community's discussion</a>, whether it is 9th Age, Age of Sigmar or classic Warhammer! All tools have been designed with sharing options built-in. These features will be expanded upon in the future.
		</p>
	</div>
	
	<div class="col-xs-12 col-md-4">
	<h2>Request a feature.</h2>
	<p>
		Even we can miss a feature that turns a not-so-useful tool into the powertool you need. Whether it's a request for new colour scheme or a critical feature, we take requests on <a href="http://www.druchii.net/viewforum.php?f=5">our suggestions board</a>.
	</p>
	</div>
	
	<div class="col-xs-12 col-md-4">
	<h2>Get support.</h2>
	<p>
		Did one of our tools fail? Impossible! But in the unlikely event it did happen, we provide support for these tools through the <a href="http://www.druchii.net/viewforum.php?f=5">our Druchii.net suggestions board</a>.
	</p>
	</div>
	
	</div>
	
</div>

<?php 
include "templates/footer.php" ;
?>