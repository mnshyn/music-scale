<?php
	
	/*
	demo.php
	Quick demo to show how the scale classes are used.
	by Cromwel Pestano
	circa 05.02.2012
	*/

	include("scale.major.php");	
	include("scale.minor.php");

	$BMajorScale = new MajorScale("B");			// Create a "B Major" scale

?>
<!DOCTYPE html>
<html>
	<head>
		<title>music_scales demo</title>
	</head>
	<body>
		B natural:<br/>
		<?
			$B = new Note("B");
			echo $B;
		?>
		<br/><br/>
		Make it flat:<br/>
		<?
			$B->makeFlat();
			echo $B;
		?>
		<br/><br/>
		How many semitones from B Natural?<br/>
		<?
			echo $B->getSemitones();
		?>
		<br/><br/>
		B Major:<br/>
		<?php 
			echo $BMajorScale;	// print out all degrees of the B Major Scale
		?>
		<br/>
		Relative Minor of B Major:<br/>
		<?php
			echo $BMajorScale->getRelativeMinor(); // print out Relative Minor of B Major
		?>
		<br/><br/>
		4th of B Major:<br/>
		<?php
			echo $BMajorScale->getScaleDegree(4); // print out degree 4
		?>
		<br/><br/>
		5th of B Major:<br/>
		<?php
			echo $BMajorScale->getScaleDegree(5); // print out degree 5
		?>
		<br/><br/>
		7th of B Major:<br/>
		<?php
			echo $BMajorScale->getScaleDegree(7); // print out degree 7
		?>
		<br/><br/>
		G# Natural Minor Scale:<br/>
		<?
			$minor_tonic = $BMajorScale->getRelativeMinor();	// get tonic of relative minor

			$minor_tonic_split = $BMajorScale->splitNote($minor_tonic); // split Note object to get the letter and accidental

			$GSharpMinorScale = new MinorScale($minor_tonic_split[0], $minor_tonic_split[1]); // create minor scale

			echo $GSharpMinorScale;
		?>
		<br/>
		G# Harmonic Minor Scale:<br/>
		<?
			$GSharpMinorScale->makeHarmonic(); // convert scale to a harmonic minor

			echo $GSharpMinorScale;
		?>
		<br/>
		Transpose B Major by 5 Half Steps:<br/>
		<?
			$BMajorScale->transpose(5); // transpose B Major 5 half steps up (E Major)
			echo $BMajorScale;
		?>
		<br/>
		Get the new E Major scale as an array, then display:<br/>
		<?
			$EMajorScaleArray = $BMajorScale->getScale(); // Get the scale as an array of Notes. To correspond with actual scale degrees, the array starts at element 1, not 0.

			for($c=1; $c<=sizeOf($EMajorScaleArray); $c++)
			{
				echo "Scale Degree $c: " . $EMajorScaleArray[$c] . "<br/>";
			}
		?>
	</body>
</html>