<?
	/*
	Major Scale
	This is a subclass of Scale.  This will create the appropriate Major Scale given the key.
	by Cromwel Pestano
	circa 05.01.2012
	*/

	require_once("scale.php");	// Scale Superclass

	class MajorScale extends Scale
	{
		// Constructor

		function __construct($key, $accidental)
		{
			parent::__construct();
			$this->createScale($key, $accidental);
		}

		// createScale($key, $accidental): This function creates the appropriate scale

		public function createScale($key, $accidental)
		{
			$intervals = array(0,0,2,1,2,2,2,2);
			$this->initializeScale($key, $accidental, $intervals);
			$this->conformScale();
		}

		// getRelativeMinor(): This gives the key for this major scale's relative minor, a.k.a. degree 6.

		public function getRelativeMinor()
		{
			return $this->degrees[6];
		}
	}
?>