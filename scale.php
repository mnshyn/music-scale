<?

	/*
	Scale
	This is an abstract class for scales.  This class is to be extended for major scales, minor scales, etc.
	by Cromwel Pestano
	circa 05.01.2012
	*/

	require_once("note.php");		// for Note class and Accidental class

	abstract class Scale
	{
		// $degrees array contains the scale's note degrees. Element 0 is empty, and starts with 1 like actual musical notation.

		public $degrees;

		// following arrays are used to calculate note distances

		protected $note_values = array("C", "D", "E", "F", "G", "A", "B");

		protected $all_notes_sharp = array("C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B");
		protected $all_notes_flat = array("C", "Db", "D", "Eb", "E", "F", "Gb", "G", "Ab", "A", "Bb", "B");

		// if the requested scale is overly complex, the scale will be simplified and the flag will be set to TRUE

		protected $simplified_flag = false;

		// initializeScale($key, $accidental): Set first degree, and initialize to process the other degrees

		protected function initializeScale($key, $accidental, $intervals)
		{
			if(($accidental==2&&$key!="F"&&$key!="C")||($accidental==3&&($key=="F"||$key=="C")))
			{
				$simplified_key = $this->simplifyKey($key, $accidental);
				$key = $simplified_key[0];
				$accidental = $simplified_key[1];

			}

			switch($accidental)
			{
				case 2:case "#":
				{
					$accidental = "#";
					break;
				}
				case 3:case "b":
				{
					$accidental = "b";
					break;
				}
				case 1:default:
				{
					$accidental = "natural";
					break;
				}
			}

			$first_note = $this->createNote($key, $accidental);

			$this->insertNote($first_note, 1);


			if($this->degrees[1]->getSemitones()>=0&&($first_note!="F"))
			{
				$note_index = array_search($this->degrees[1]->getNote(), $this->all_notes_sharp);
				$notelist = 2;
			}
			else if($this->degrees[1]->getSemitones()<0||$first_note=="F")
			{
				$note_index = array_search($this->degrees[1]->getNote(), $this->all_notes_flat);
				$notelist = 3;
			}

			for($c=2; $c<=sizeOf($intervals)-1; $c++)
			{
				$new_note = $this->getNextNoteViaSemitones($note_index, $intervals[$c], $notelist);
				$note_index+=$intervals[$c];

				$this->insertNote($new_note, $c);
			}
		}

		// createNote($note, $accidental): Creates a note object with the given $note and $accidental

		protected function createNote($note, $accidental)
		{
			return new Note($note, $accidental);
		}

		// insertNote(Note $note, $index): Inserts a $note object into the scale degree given

		protected function insertNote(Note $note, $index)
		{
			$this->degrees[$index] = $note;
		}

		// getNextNoteViaSemitones($initial_index, $semitones, $notelist): Given the index of the first note, the amount of semitones to move forward, and which list, this returns the next $note object.

		protected function getNextNoteViaSemitones($initial_index, $semitones, $notelist)
		{
			$new_index = $initial_index + 2;

			if($new_index>=12)
			{
				$new_index-=12;
			}

			switch($notelist)
			{
				case 1:
				{
					$list = "note_values";
					break;
				}
				case 2:
				{
					$list = "all_notes_sharp";
					break;
				}
				case 3:
				{
					$list = "all_notes_flat";
					break;
				}
			}

			if(strlen($this->{$list}[$new_index])==1)
			{
				return $this->createNote($this->{$list}[$new_index], "natural");
			}
			else
			{
				$note_value = substr($this->{$list}[$new_index], 0, 1);
				$accidental_value = substr($this->{$list}[$new_index], 1, 1);

				return $this->createNote($note_value, $accidental_value);
			}
		}

		// calculateSemitonesBetween($note1, $note2): This returns the semitone distance between two notes

		protected function calculateSemitonesBetween($note1, $note2)
		{

			$note1_index = array_search($note1, $this->all_notes_sharp);
			$note2_index = array_search($note2, $this->all_notes_sharp);

			$distance = $note2_index - $note1_index;

			return $distance;		
		}

		// conformScale(): This will adjust the scale where each note value (C-B) is represented properly

		protected function conformScale()
		{
			for($c=1; $c<=sizeOf($this->degrees); $c++)
			{
				if($c==sizeOf($this->degrees))
				{
					$d = 1;
				}
				else
				{
					$d = $c + 1;
				}

				$note1 = $this->degrees[$c]->getNoteWithoutAccidental();
				$note2 = $this->degrees[$d]->getNoteWithoutAccidental();

				$note1_index = array_search($note1, $this->note_values);
				$note2_index = array_search($note2, $this->note_values);

				$distance = $note2_index - $note1_index;

				//echo $c . ": n1i($note1): " . $note1 . ", n2i:($note2): " . $note2 . ", distance:" . $distance . "<br/>";

				$semitone_adjustment = 0;

				if($distance!=1&&$distance!=-6&&$distance!=-4)
				{
					if($distance==0)
					{
						if($note2_index==6)
						{
							$new_note = $this->note_values[0];
						}
						else
						{
							$new_note = $this->note_values[$note2_index+1];
	
							$semitone_adjustment = $this->degrees[$d]->getSemitones();

							//echo "<br/>" . $this->degrees[$d] . ": " . $semitone_adjustment . "<br/>";
						}						
					}
					else
					{
						if($note2_index==0)
						{
							$new_note = $this->note_values[6];
						}
						else
						{
							$new_note = $this->note_values[$note2_index-1];
						}
					}

					$semitone_distance = $this->calculateSemitonesBetween($new_note, $note2) + $semitone_adjustment;

					//echo $c . ": " . $new_note . "," . $note2 . ", " . $semitone_distance . "->";

					if(abs($semitone_distance)>=11)
					{
						if($semitone_distance<0)
						{
							$semitone_distance = abs($semitone_distance) - 10;
						}
						else if($semitone_distance>0)
						{
							$semitone_distance = -($semitone_distance) + 10;
						}
					}

					$new_note_object = $this->createNote($new_note, "natural");
					$new_note_semitone_count = $new_note_object->getSemitones();

					while($new_note_semitone_count!=$semitone_distance)
					{
						// echo $new_note_semitone_count . ", " . $semitone_distance . "<br/>";

						if($new_note_semitone_count<$semitone_distance)
						{
							$new_note_object->makeSharp();
							$new_note_semitone_count = $new_note_object->getSemitones();
						}
						else if($new_note_semitone_count>$semitone_distance)
						{
							$new_note_object->makeFlat();
							$new_note_semitone_count = $new_note_object->getSemitones();
						}
					}

					$this->insertNote($new_note_object, $d);
				}
			}
		}

		// simplifyKey(): When given an overly complex key, an array giving the simplified key is returned.  If already simplified, the original key is returned.

		protected function simplifyKey($key, $accidental)
		{
			$simplified_key[0] = $key;
			$simplified_key[1] = $accidental;

			if($accidental==3)
			{
				$index = array_search($key, $this->note_values);

				if($key=="C")
				{
					$simplified_key[0] = "B";
					$simplified_key[1] = "";
				}
				else
				{
					$simplified_key[0] = "E";
					$simplified_key[1] = "";	
				}

				$this->simplified_flag = true;
			}
			else if($accidental==2)
			{
				switch($key)
				{
					case "B":
					{
						$simplified_key[0] = "C";
						$simplified_key[1] = "";
						break;
					}
					case "E":
					{
						$simplified_key[0] = "F";
						$simplified_key[1] = "";
						break;
					}
					default:
					{
						$index = array_search($key, $this->note_values);

						$simplified_key[0] = $this->note_values[$index+1];
						$simplified_key[1] = "b";
					}					
				}

				$this->simplified_flag = true;
			}

			return $simplified_key;
		}

		// getScale(): this returns the scale in an array

		public function getScale()
		{
			return $this->degrees;
		}

		// getScaleDegree($degree): this returns the appropriate note for that degree.  For example, the 7th of C Major { getScaleDegree(7) } will return B.

		public function getScaleDegree($degree)
		{
			return $this->degrees[$degree];
		}

		// splitNote(Note $note): returns an array with (0) the individual note value and (1) accidental

		public function splitNote(Note $note)
		{
			$note_info[0] = $note->getNoteWithoutAccidental();
			$note_info[1] = $note->getAccidental();

			return $note_info;
		}

		// __toString(): this prints out the scale for debugging purposes.

		function __toString()
		{
			$scale = "";

			if($this->simplified_flag==true)
			{
				echo "Scale was simplified.<br/>";
			}

			for($c=1; $c<=7; $c++)
			{
				$scale .= $c . ": " . $this->degrees[$c] . "<br/>";
			}

			return $scale;
		}

		// createScale($key, $accidental): this function is necessary for each subclass to create the scale based on its definition

		public abstract function createScale($key, $accidental);
	}
?>