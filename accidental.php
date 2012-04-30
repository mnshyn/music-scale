<?php

	/*
	Accidental
	This class represents an accidental, including semitone value and symbol.
	by Cromwel Pestano
	circa 04.30.2012
	*/

	class Accidental
	{
		// semitone value constants

		const TRIPLE_FLAT = -3;
		const DOUBLE_FLAT = -2;
		const FLAT = -1;
		const NATURAL = 0;
		const SHARP = 1;
		const DOUBLE_SHARP = 2;
		const TRIPLE_SHARP = 3;

		private $semitones;		// number of semitones above or below natural note
		private $symbol;		// symbol of accidental

		// Constructor

		function __construct($accidental)
		{
			$this->setValue($accidental);
		}

		// setValue($accidental): this sets the semitone value of the accidental and assigns the corresponding symbol

		public function setValue($accidental)
		{
			switch($accidental)
			{
				case 3:case "triple sharp":case "###":
				{
					$this->semitones = 3;
					$this->symbol = "###";
					break;
				}
				case 2:case "double sharp":case "##":
				{
					$this->semitones = 2;
					$this->symbol = "##";
					break;
				}
				case 1:case "sharp":case "#":
				{
					$this->semitones = 1;
					$this->symbol = "#";
					break;
				}
				case -3:case "triple flat":case "bbb":
				{
					$this->semitones = -3;
					$this->symbol = "bbb";
					break;
				}
				case -2:case "double flat":case "bb":
				{
					$this->semitones = -2;
					$this->symbol = "bb";
					break;
				}
				case -1:case "flat":case "b":
				{
					$this->semitones = -1;
					$this->symbol = "b";
					break;
				}
				case 0:case "natural":
				{
					$this->semitones = 0;
					$this->symbol = " natural";
					break;
				}
				default:
				{
					throw new Exception("EXCEPTION: Invalid accidental given");
				}
			}
		}

		// getSymbol(): gets the symbol of the accidental

		public function getSymbol()
		{
			return $this->symbol;
		}

		// getSemitones(): gets the semitone value

		public function getSemitones()
		{
			return $this->semitones;
		}

	}

?>