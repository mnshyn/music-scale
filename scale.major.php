<?
	/*
	Major Scale
	This is a subclass of Scale.  This will create the appropriate Major Scale given the key.
	by Cromwel Pestano
	circa 05.01.2012
	*/

	include("scale.php");	// Scale Superclass

	class MajorScale extends Scale
	{
		// Constructor

		function __construct($key, $accidental)
		{
			$this->createScale($key, $accidental);
		}

		// createScale($key, $accidental): This function creates the appropriate scale

		public function createScale($key, $accidental)
		{
			$start_info = $this->initializeScale($key, $accidental);

			$note_index = $start_info[0];
			$notelist = $start_info[1];

			for($c=2; $c<=7; $c++)
			{
				switch($c)
				{
					case 2:case 4:case 5:case 6:case 7:																																
					{
						$new_note = $this->getNextNoteViaSemitones($note_index, 2, $notelist);
						$note_index+=2;

						$this->insertNote($new_note, $c);
						break;
					}
					case 3:
					{
						$new_note = $this->getNextNoteViaSemitones($note_index,	1, $notelist);
						$note_index+=1;

						$this->insertNote($new_note, $c);

						break;
					}
				}
			}

			$this->conformScale();
		}

		// getRelativeMinor(): This gives the key for this major scale's relative minor, a.k.a. degree 6.

		public function getRelativeMinor()
		{
			return $this->degrees[6];
		}
	}
?>