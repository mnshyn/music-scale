<?

	/*
	Note
	This class represents a musical note including its accidental.
	by Cromwel Pestano
	circa 04.30.2012
	*/

	require_once("accidental.php");

	class Note
	{
		private $note;		// Note value from A to G
		private $accidental;		// Natural, Sharp, Double Sharp, Flat or Double Flat

		// Constructor: takes a note and accidental.  Will throw a warning if no accidental given, but will defualt to natural.  Calls setNote($note, $accidental).

		function __construct($note, $accidental)
		{
			$this->setNote($note, $accidental);
		}

		// getNote(): get function for $note, including accidentals

		public function getNote()
		{
			return $this->note . $this->getAccidental();
		}

		// getNote(): get function for $note, with no accidentals

		public function getNoteWithoutAccidental()
		{
			return $this->note;
		}

		// setNote($note, $accidental): sets note and accidental values

		public function setNote($note, $accidental)
		{
			if($this->isNoteValid($note))
			{
				$this->note = $note;

				if(!isset($accidental))
				{
					$this->accidental = new Accidental("natural");
				}
				else
				{
					$this->accidental = new Accidental($accidental);
				}
			}
			else
			{
				throw new Exception("EXCEPTION: Invalid note given or accidental given with first argument; accidentals are given in the second argument");
			}
		}

		// getAccidental(): returns accidental in music notation form

		public function getAccidental()
		{
			return $this->accidental->getSymbol();
		}

		public function getSemitones()
		{
			return $this->accidental->getSemitones();
		}


		// makeSharp(): raises note a half step

		public function makeSharp()
		{
			$semitones = $this->accidental->getSemitones();

			if($semitones==3)
			{
				throw new Exception("EXCEPTION: ### is the maximum");
			}
			else
			{
				$this->accidental->setValue($semitones+1);
			}
		}

		// makeFlat(): drops note a half step

		public function makeFlat()
		{
			$semitones = $this->accidental->getSemitones();

			if($semitones==-3)
			{
				throw new Exception("EXCEPTION: bbb is the minimum");
			}
			else
			{
				$this->accidental->setValue($semitones-1);
			}
		}

		// makeNatural(): resets note to natural

		public function makeNatural()
		{
			$this->accidental->setValue("natural");
		}

		// isNoteValid(): checks note given for validity.  Returns TRUE if valid, returns FALSE if invalid.

		private function isNoteValid($note)
		{
			if(preg_match("/[A-Ga-g]/", $note)&&strlen($note)==1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		// __toString(): returns note with accidental as a string

		public function __toString()
		{
			return $this->getNote();
		}
	}

?>