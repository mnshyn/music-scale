<!DOCTYPE html>
<html>
	<head>
		<title>music_scales demo in javascript</title>
		<script src='music_scale.js' type='text/javascript'></script>
	</head>
	<body>
		B natural:
		<div id='note'></div><br/>
		Make it flat:
		<div id='noteflatted'></div><br/>
		How many semitones from B Natural?
		<div id='semitones'></div><br/>
		B Major:
		<div id='majorscale'></div><br/>
		Relative Minor of B Major:
		<div id='relminor'></div><br/>
		4th of B Major:
		<div id='subdom'></div><br/>
		5th of B Major:
		<div id='dom'></div><br/>
		7th of B Major:
		<div id='leading'></div><br/>
		G# Natural Minor Scale:
		<div id='minorscale'></div><br/>
		G# Harmonic Minor Scale:
		<div id='hminorscale'></div><br/>
		Create a scale with the current scale (B Major) transposed up by 5 Half Steps (E Major):
		<div id='major_transposed'></div><br/>
		B Major scale is still intact:
		<div id='original_scale'></div><br/>
		You can completely change B Major to the transposed version as well without creating a new instance.<br/>
		<div id='change_original'></div><br/>
		Use negative numbers to transpose downward.
		<div id='change_back'></div><br/>
		Get the new E Major scale as an array, then display:
		<div id='as_an_array'></div><br/>
		<script>

			// create a B note object

			var note = new Note("B");

			document.getElementById("note").innerHTML = note.toString();

			// make the note flat, (Bb)

			note.makeFlat(); 

			document.getElementById("noteflatted").innerHTML = note.toString();

			// get the semitone distance from natural

			document.getElementById("semitones").innerHTML = note.getSemitones(); 

			var BMajorScale = new MajorScale("B"); // create a B Major Scale

			document.getElementById("majorscale").innerHTML = BMajorScale.toString();

			// get the relative minor, a.k.a. scale degree 6

			document.getElementById("relminor").innerHTML = BMajorScale.getRelativeMinor(); 

			document.getElementById("subdom").innerHTML = BMajorScale.getScaleDegree(4); 		// get the 4th
			document.getElementById("dom").innerHTML = BMajorScale.getScaleDegree(5); 			// get the 5th
			document.getElementById("leading").innerHTML = BMajorScale.getScaleDegree(7); 		// get the 7th

			var minor_tonic = BMajorScale.getRelativeMinor();

			// this splits the note and accidental into an array with two elements

			var minor_tonic_split = BMajorScale.splitNote(minor_tonic); 

			// create a minor scale with the two pieces	

			var GSharpMinorScale = new MinorScale(minor_tonic_split[0], minor_tonic_split[1]); 

			document.getElementById("minorscale").innerHTML = GSharpMinorScale.toString();

			// convert to a harmonic minor scale

			GSharpMinorScale.makeHarmonic();

			document.getElementById("hminorscale").innerHTML = GSharpMinorScale.toString();	

			// create a new scale object, based on a transposed version of the original scale

			var EMajorScale = BMajorScale.getTransposedScale(5);

			document.getElementById("major_transposed").innerHTML = EMajorScale.toString();	

			document.getElementById("original_scale").innerHTML = BMajorScale.toString();

			// transpose the original scale object up by 5 halfsteps

			BMajorScale.transpose(5);

			document.getElementById("change_original").innerHTML = BMajorScale.toString();

			// tranpose it back by going down 5 halfsteps

			BMajorScale.transpose(-5);

			document.getElementById("change_back").innerHTML = BMajorScale.toString();

			// get the scale as an array to manipulate

			EMajorScaleArray = EMajorScale.getScale();

			var o = "";

			for(c=1; c<EMajorScaleArray.length; c++)
			{
				o += "Scale Degree " + c + ": " + EMajorScaleArray[c] + "<br/>";
			}

			document.getElementById("as_an_array").innerHTML = o;

		</script>
	</body>
</html>