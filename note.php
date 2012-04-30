<?

	/*
	Note
	This class represents a musical note including its accidental.
	by Cromwel Pestano
	circa 04.30.2012
	*/

	class Note
	{
		// Constants for the accidental

		const TRIPLE_FLAT = -3;
		const DOUBLE_FLAT = -2;
		const FLAT = -1;
		const NATURAL = 0;
		const SHARP = 1;
		const DOUBLE_SHARP = 2;
		const TRIPLE_SHARP = 3;

		private $note;		// Note value from A to G
		private $accidental;		// Natural, Sharp, Double Sharp, Flat or Double Flat

		// Constructor: takes a note and accidental.  Will throw a warning if no accidental given, but will defualt to natural.  Calls setNote($note, $accidental).

		function __construct($note, $accidental)
		{
			$this->setNote($note, $accidental);
		}

		// getNote(): get function for $note

		public function getNote()
		{
			return $this->note . $this->getAccidental();
		}

		// setNote($note, $accidental): sets note and accidental values

		public function setNote($note, $accidental)
		{
			if($this->isNoteValid($note))
			{
				$this->note = $note;

				if(!isset($accidental))
				{
					$this->accidental = 0;
				}
				else
				{
					switch($accidental)
					{
						case 3:case "triple sharp":case "###":
						{
							$accidental = 3;
							break;
						}
						case 2:case "double sharp":case "##":
						{
							$accidental = 2;
							break;
						}
						case 1:case "sharp":case "#":
						{
							$accidental = 1;
							break;
						}
						case -3:case "triple flat":case "bbb":
						{
							$accidental = -3;
							break;
						}
						case -2:case "double flat":case "bb":
						{
							$accidental = -2;
							break;
						}
						case -1:case "flat":case "b":
						{
							$accidental = -1;
							break;
						}
						case 0:case "natural":
						{
							$accidental = 0;
							break;
						}
						default:
						{
							throw new Exception("EXCEPTION: Invalid accidental given");
						}
					}

					$this->accidental = $accidental;
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
			$accidental = "";

			switch($this->accidental)
			{
				case self::SHARP:
				{
					$accidental = "#";
					break;
				}
				case self::DOUBLE_SHARP:
				{
					$accidental = "##";
					break;
				}
				case self::TRIPLE_SHARP:
				{
					$accidental = "###";
					break;
				}
				case self::FLAT:
				{
					$accidental = "b";
					break;
				}
				case self::DOUBLE_FLAT:
				{
					$accidental = "bb";
					break;
				}
				case self::TRIPLE_FLAT:
				{
					$accidental = "bbb";
					break;
				}			
				default:
				{
					$accidental = " natural";
				}
			}

			return $accidental;
		}

		// makeSharp(): raises note a half step

		public function makeSharp()
		{
			if($this->accidental==3)
			{
				throw new Exception("EXCEPTION: ### is the maximum");
			}
			else
			{
				$this->accidental++;
			}
		}

		// makeFlat(): drops note a half step

		public function makeFlat()
		{
			if($this->accidental==3)
			{
				throw new Exception("EXCEPTION: bbb is the minimum");
			}
			else
			{
				$this->accidental--;
			}
		}

		// makeNatural(): resets note to natural

		public function makeNatural()
		{
			$this->accidental = 0;
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