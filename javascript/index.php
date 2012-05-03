<!DOCTYPE html>
<html>
	<head>
		<script src='music_scale.js' type='text/javascript'></script>
	</head>
	<body>
		Test Note:
		<div id='note'></div>
		<div id='notesharped'></div>
		<div id='noteflatted'></div>
		<script>

			var note = new Note("C");

			document.getElementById("note").innerHTML = note.toString();

			note.makeSharp();

			document.getElementById("notesharped").innerHTML = note.toString();

			note.makeFlat();
			note.makeFlat();

			document.getElementById("noteflatted").innerHTML = note.toString();

		</script>
	</body>
</html>