<?
	/*
	Minor Scale
	This is a subclass of Scale.  This will create the appropriate Natural Minor Scale given the key with a method to change to Harmonic Minor
	by Cromwel Pestano
	circa 05.01.2012
	*/

	require_once("scale.php");	// Scale Superclass

	class MinorScale extends Scale
	{
		// Constants to define with type of minor scale

		const NATURAL = 1;
		const HARMONIC = 2;

		private $minor_type;

		// Constructor

		function __construct($key, $accidental)
		{		
			parent::__construct();
			$this->createScale($key, $accidental);
		}

		// createScale($key, $accidental): This function creates the appropriate scale

		public function createScale($key, $accidental)
		{
			$minor_type = self::NATURAL;

			$intervals = array(0,0,1,2,2,1,2,2);
			$this->initializeScale($key, $accidental, $intervals);
			$this->conformScale();
		}

		// getRelativeMajor(): This gives the key for this minor scale's relative major, a.k.a. degree 3.

		public function getRelativeMajor()
		{
			return $this->degrees[3];
		}

		// makeHarmonic(): Sharpens Degree 7 to create a harmonic minor scale

		public function makeHarmonic()
		{
			if($this->minor_type!=self::HARMONIC && $this->minor_type!=self::NATURAL)
			{
				$this->makeNatural();
			}
	
			$this->degrees[7]->makeSharp();
			$minor_type = self::HARMONIC;

			$this->conformScale();
		}

		// makeNatural(): Resets to a natural minor scale

		public function makeNatural()
		{
			$this->createScale($this->degrees[1]->getNoteWithoutAccidental(), $this->degrees[1]->getAccidental());

			$this->conformScale();
		}
	}
?>