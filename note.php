<?

	class Note
	{
		const DOUBLE_FLAT = -2;
		const FLAT = -1;
		const NATURAL = 0;
		const SHARP = 1;
		const DOUBLE_SHARP = 2;

		private $note;
		private $accidental;

		function __construct($note, $accidental)
		{
			$this->note = $note;

			if(!isset($accidental))
			{
				$this->accidental = 0;
			}
			else
			{
				$this->accidental = $accidental;
			}
		}

		public function getNote()
		{
			return $this->note . $this->getAccidental();
		}

		public function setNote($note, $accidental)
		{
			$this->note = $note;
		}

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
				default:
				{
					$accidental = " natural";
				}
			}

			return $accidental;
		}

		public function setAccidental($accidental)
		{
			$this->accidental = $accidental;
		}

		public function makeSharp()
		{
			$this->accidental++;
		}

		public function makeFlat()
		{
			$this->accidental--;
		}

		public function makeNatural()
		{
			$this->accidental = 0;
		}

		public function __toString()
		{
			return $this->getNote();
		}
	}

?>