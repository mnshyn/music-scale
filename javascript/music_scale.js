
/*
	Accidental [JavaScript]
	This class represents an accidental, including semitone value and symbol.
	by Cromwel Pestano
	circa 05.03.2012
*/

function Accidental(accidental)
{
	var TRIPLE_FLAT = -3;
	var DOUBLE_FLAT = -2;
	var FLAT = -1;
	var NATURAL = 0;
	var SHARP = 1;
	var DOUBLE_SHARP = 2;
	var TRIPLE_SHARP = 3;

	var semitones;
	var symbol;

	this.setValue = function(accidental){

		switch(accidental)
		{
			case 3:case "triple sharp":case "###":
			{
				semitones = 3;
				symbol = "###";
				break;
			}
			case 2:case "double sharp":case "##":
			{
				semitones = 2;
				symbol = "##";
				break;
			}
			case 1:case "sharp":case "#":
			{
				semitones = 1;
				symbol = "#";
				break;
			}
			case -3:case "triple flat":case "bbb":
			{
				semitones = -3;
				symbol = "bbb";
				break;
			}
			case -2:case "double flat":case "bb":
			{
				semitones = -2;
				symbol = "bb";
				break;
			}
			case -1:case "flat":case "b":
			{
				semitones = -1;
				symbol = "b";
				break;
			}
			case 0:case "natural":
			{
				semitones = 0;
				symbol = "";
				break;
			}
			default:
			{
				throw "EXCEPTION: Invalid accidental given";
			}		
		}

	};

	this.getSymbol = function(){

		return symbol;

	};

	this.getSemitones = function(){

		return semitones;

	};

	this.toString = function(){

		return symbol;

	}

	this.setValue(accidental);

}

/*
	Note [JavaScript]
	This class represents a musical note including its accidental.
	by Cromwel Pestano
	circa 05.03.2012
*/

function Note(param_note, param_accidental)
{
	var note;
	var accidental;

	this.getNote = function(){

		return note + accidental.toString();

	};

	this.getNoteWithoutAccidental = function(){

		return note;

	};

	this.setNote = function(param_note, param_accidental){

		if(this.isNoteValid(param_note))
		{
			note = param_note;

			if(param_accidental!="")
			{
				accidental = new Accidental("natural");
			}
			else
			{
				accidental = new Accidental(param_accidental);
			}
		}
		else
		{
			throw "EXCEPTION: Invalid note given or accidental given with first argument; accidentals are given in the second argument";
		}

	};

	this.getAccidental = function(){

		return accidental.getSymbol();

	};

	this.getSemitones = function(){

		return accidental.getSemitones();

	};

	this.makeSharp = function(){

		curr_semitones = accidental.getSemitones();

		if(curr_semitones == 3)
		{
			throw "EXCEPTION: ### is the maximum";
		}
		else
		{
			accidental.setValue(curr_semitones+1);
		}

	};

	this.makeFlat = function(){

		curr_semitones = accidental.getSemitones();

		if(curr_semitones == -3)
		{
			throw "EXCEPTION: bbb is the maximum";
		}
		else
		{
			accidental.setValue(curr_semitones-1);
		}

	};

	this.makeNatural = function(){

		accidental.setValue = "natural";

	}

	this.isNoteValid = function(param_note){

		var pattern = /[A-Ga-g]/

		if(pattern.test(param_note) == true && param_note.length==1)
		{
			return true;
		}
		else
		{
			return false;
		}
	};

	this.toString = function(){

		return note + accidental.toString();
	}

	this.setNote(param_note);
}
