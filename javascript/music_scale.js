/*
	music_scale
	Javascript version of music_scale
*/

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

	var semitones;	// number of semitones above or below natural note
	var symbol;		// symbol of accidental

	// setValue(accidental): this sets the semitone value of the accidental and assigns the corresponding symbol

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
			case 0:case "natural":case "":case undefined:
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

	// getSymbol(): gets the symbol of the accidental

	this.getSymbol = function(){

		return symbol;

	};

	// getSemitones(): gets the semitone value

	this.getSemitones = function(){

		return semitones;

	};

	// toString(): returns the symbol as a string

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
	var note;				// Note value from A to G
	var accidental;			// Natural, Sharp, Double Sharp, Flat or Double Flat

	// getNote(): get function for $note, including accidentals

	this.getNote = function(){

		return note + accidental.toString();

	};

	// getNoteWithoutAccidental(): get function for $note, with no accidentals

	this.getNoteWithoutAccidental = function(){

		return note;

	};

	// setNote(note, accidental): sets note and accidental values

	this.setNote = function(param_note, param_accidental){

		if(this.isNoteValid(param_note))
		{
			note = param_note;

			if(param_accidental=="")
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

	// getAccidental(): returns accidental in music notation form

	this.getAccidental = function(){

		return accidental.getSymbol();

	};

	// getAccidental(): returns semitone distance from natural

	this.getSemitones = function(){

		return accidental.getSemitones();

	};

	// makeSharp(): raises note a half step

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

	// makeFlat(): drops note a half step

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

	// makeNatural(): resets note to natural

	this.makeNatural = function(){

		accidental.setValue = "natural";

	}

	// isNoteValid(): checks note given for validity.  Returns TRUE if valid, returns FALSE if invalid.

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

	// toString(): returns note with accidental as a string

	this.toString = function(){

		return note + accidental.toString();
	}

	this.setNote(param_note, param_accidental);
}

/*
	Scale [JavaScript]
	This is a class for scales.  This class is to be extended for major scales, minor scales, etc.
	by Cromwel Pestano
	circa 05.03.2012
*/

function Scale()
{
	// degrees array contains the scale's note degrees. Element 0 is empty, and starts with 1 like actual musical notation.

	this.degrees = new Array();
	this.intervals = new Array();

	// following arrays are used to calculate note distances

	var note_values = new Array();
	var all_notes_sharp = new Array();
	var all_notes_flat = new Array();

	// if the requested scale is overly complex, the scale will be simplified and the flag will be set to TRUE

	var simplified_flag;
	this.scale_type = "";

	// initializeScale(key, accidental): Set first degree, and initialize to process the other degrees

	this.initializeScale = function(key, accidental, param_intervals, scale_flag){

		if(scale_flag!="major"&&scale_flag!="minor")
		{
			throw "EXCEPTION: No scale type given";
		}
		else
		{
			this.scale_type = scale_flag;
		}

		this.intervals = param_intervals;

		if((accidental==2&&key!="F"&&key!="C")||(accidental==3&&(key=="F"||key=="C")))
		{
			simplified_key = this.simplifyKey(key, accidental);
			key = simplified_key[0];
			accidental = simplified_key[1];
		}

		switch(accidental)
		{
			case 2:case "#":
			{
				accidental = "#";
				break;
			}
			case 3:case "b":
			{
				accidental = "b";
				break;
			}
			case 1:default:
			{
				accidental = "natural";
				break;
			}			
		}

		var first_note = this.createNote(key, accidental);

		this.insertNote(first_note, 1);

		if(this.degrees[1].getSemitones()>=0&&(first_note!="F"))
		{
			note_index = all_notes_sharp.indexOf(this.degrees[1].getNote());
			notelist = 2;
		}
		else if(this.degrees[1].getSemitones()<0||first_note=="F")
		{
			note_index = all_notes_flat.indexOf(this.degrees[1].getNote());
			notelist = 3;
		}

		for(c=2; c<=this.intervals.length-1; c++)
		{
			new_note = this.getNextNoteViaSemitones(note_index, this.intervals[c], notelist);

			note_index+=this.intervals[c];

			this.insertNote(new_note, c);
		}
	}

	// createNote(note, accidental): Creates a note object with the given note and accidental

	this.createNote = function(note, accidental){

		return new Note(note, accidental);

	}

	// insertNote(note_object, index): Inserts a note object into the scale degree given

	this.insertNote = function(note_object, index){

		this.degrees[index] = note_object;
	}

	// getNextNoteViaSemitones(initial_index, semitones, notelist): Given the index of the first note, the amount of semitones to move forward, and which list, this returns the next note object.

	this.getNextNoteViaSemitones = function(initial_index, semitones, notelist){

		var new_index = initial_index + 2;
		var list;

		if(new_index>=12)
		{
			new_index-=12;
		}

		switch(notelist)
		{
			case 1:
			{
				list = note_values;
				break;
			}
			case 2:
			{
				list = all_notes_sharp;
				break;
			}
			case 3:
			{
				list = all_notes_flat;
				break;
			}
		}

		var needed_note_list = list;
		var note_value;
		var accidental_value;

		if(needed_note_list[new_index].length==1)
		{
			return this.createNote(needed_note_list[new_index], "natural");
		}
		else
		{
			note_value = needed_note_list[new_index].substring(0, 1);
			accidental_value = needed_note_list[new_index].substring(1, 2);

			var testnote = this.createNote(note_value, accidental_value);

			return testnote;
		}
	}

	// calculateSemitonesBetween(note1, note2): This returns the semitone distance between two notes

	this.calculateSemitonesBetween = function(note1, note2){

		var note1_index = all_notes_sharp.indexOf(note1);
		var note2_index = all_notes_sharp.indexOf(note2);

		var distance = note2_index - note1_index;

		return distance;

	}

	// conformScale(): This will adjust the scale where each note value (C-B) is represented properly

	this.conformScale = function(){

		var d;

		for(c=1; c<this.degrees.length; c++)
		{
			if(c==this.degrees.length-1)
			{
				d = 1;
			}
			else
			{
				d = c + 1;
			}

			var note1 = this.degrees[c].getNoteWithoutAccidental();
			var note2 = this.degrees[d].getNoteWithoutAccidental();

			var note1_index = note_values.indexOf(note1);
			var note2_index = note_values.indexOf(note2);
		
			var distance = note2_index - note1_index;

			var semitone_adjustment = 0;

			var new_note;

			if(distance!=1&&distance!=-6&&distance!=-4)
			{
				if(distance==0)
				{
					if(note2_index==6)
					{
						new_note = note_values[0];
					}
					else
					{	new_note = note_values[note2_index+1];
						semitone_adjustment = this.degrees[d].getSemitones();
					}
				}
				else
				{
					if(note2_index==0)
					{
						new_note = note_values[6];
					}
					else
					{
						new_note = note_values[note2_index-1];
					}
				}

				semitone_distance = this.calculateSemitonesBetween(new_note, note2) + semitone_adjustment;

				

				if(Math.abs(semitone_distance)>=11)
				{
					if(semitone_distance<0)
					{
						semitone_distance = Math.abs(semitone_distance) - 10;
					}
					else if(semitone_distance>0)
					{
						semitone_distance = -(semitone_distance) + 10;
					}
				}

				var new_note_object = this.createNote(new_note, "natural");
				var new_note_semitone_count = new_note_object.getSemitones();

				while(new_note_semitone_count!=semitone_distance)
				{
					if(new_note_semitone_count<semitone_distance)
					{
						new_note_object.makeSharp();
						new_note_semitone_count = new_note_object.getSemitones();
					}
					else
					{
						new_note_object.makeFlat();
						new_note_semitone_count = new_note_object.getSemitones();
					}
				}

				this.insertNote(new_note_object, d);
			}
		}

	}

	// simplifyKey(): When given an overly complex key, an array giving the simplified key is returned.  If already simplified, the original key is returned.

	this.simplifyKey = function(key, accidental){

		var simplified_key = Array(key, accidental);

		var index;

		if(accidental==3||accidental=="b")
		{
			index = note_values.indexOf(key);

			if(key=="C")
			{
				simplified_key[0] = "B";
				simplified_key[1] = "";
			}
			else
			{
				simplified_key[0] = "E";
				simplified_key[1] = "";
			}

			simplified_flag = true;
		}
		else if(accidental==2||accidental=="#")
		{
			switch(key)
			{
				case "B":
				{
					simplified_key[0] = "C";
					simplified_key[1] = "";
					break;
				}
				case "E":
				{
					simplified_key[0] = "F";
					simplified_key[1] = "";
					break;
				}
				default:
				{
					index = note_values.indexOf(key);

					simplified_key[0] = note_values[index+1];
					simplified_key[1] = "b";
				}
			}

			simplified_flag = true;
		}

		return simplified_key;

	}

	// getScale(): this returns the scale in an array

	this.getScale = function(){

		return this.degrees;

	}

	// getScaleDegree(degree): this returns the appropriate note for that degree.  For example, the 7th of C Major { getScaleDegree(7) } will return B.

	this.getScaleDegree = function(degree){

		return this.degrees[degree];

	}

	// splitNote(note): returns an array with (0) the individual note value and (1) accidental

	this.splitNote = function(note_object){

		var note_info = Array(note_object.getNoteWithoutAccidental(), note_object.getAccidental());

		return note_info;

	}

	// transpose(half_steps): transposes scale by the given amount of half steps

	this.transpose = function(half_steps){

		if(!((parseFloat(half_steps) == parseInt(half_steps)) && !isNaN(half_steps)))
		{
			throw "EXCEPTION: parameter must be an integer.";
		} 

		var tonic = this.degrees[1].toString();

		tonic_index = all_notes_sharp.indexOf(tonic);

		new_index = tonic_index + half_steps;

		if(new_index>=12)
		{
			new_index -= 12;
		}
		else if(new_index<=0)
		{
			new_index += 12;
		}

		new_note = all_notes_sharp[new_index];

		this.degrees = [];

		if(new_note.length==1)
		{
			this.initializeScale(new_note, "natural", this.intervals, this.scale_type);
		}
		else
		{
			this.initializeScale(new_note.substring(0,1), new_note.substring(1,2), this.intervals, this.scale_type);
		}		

		this.conformScale();
	}

	// getTransposedScale(half_steps): creates a copy of the current scale, transposes by the given amount of half steps, then returns the scale object.

	this.getTransposedScale = function(half_steps){

		var new_scale = new Object();

		for(var prop in this){
	
			new_scale[prop] = this[prop];
		}

		new_scale.transpose(half_steps);

		return new_scale;
	}

	// toString(): this returns the scale as a string.

	this.toString = function(){

		var scale = "";

		if(simplified_flag==true)
		{
			scale = "Scale was simplified.<br/>";
		}

		for(c=1; c<=7; c++)
		{
			scale = scale + c + ": " + this.degrees[c] + "<br/>";
		}

		return scale;
	}

	note_values = new Array("C", "D", "E", "F", "G", "A", "B");
	all_notes_sharp = new Array("C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "B");
	all_notes_flat = new Array("C", "Db", "D", "Eb", "E", "F", "Gb", "G", "Ab", "A", "Bb", "B");
	simplified_flag = false;

}

/*
	Major Scale [JavaScript]
	This is a subclass of Scale.  This will create the appropriate Major Scale given the key.
	by Cromwel Pestano
	circa 05.04.2012
*/

MajorScale.prototype = new Scale();
MajorScale.prototype.constructor = MajorScale;
MajorScale.superclass = Scale.prototype;

function MajorScale(param_key, param_accidental){

	this.createScale(param_key, param_accidental);
}

// createScale($key, $accidental): This function creates the appropriate scale

MajorScale.prototype.createScale = function(key, accidental){

	intervals = Array(0,0,2,1,2,2,2,2);
	this.initializeScale(key, accidental, intervals, "major");
	this.conformScale();
}

// getRelativeMinor(): This gives the key for this major scale's relative minor, a.k.a. degree 6.

MajorScale.prototype.getRelativeMinor = function(){

	return this.getScaleDegree(6);
}

/*
	Minor Scale [JavaScript]
	This is a subclass of Scale.  This will create the appropriate Minor Scale given the key.
	by Cromwel Pestano
	circa 05.04.2012
*/

MinorScale.prototype = new Scale();
MinorScale.prototype.constructor = MajorScale;
MinorScale.superclass = Scale.prototype;

function MinorScale(param_key, param_accidental){

	this.minor_type = 1;
	this.createScale(param_key, param_accidental);
}

// createScale(key, accidental): This function creates the appropriate scale

MinorScale.prototype.createScale = function(key, accidental){

	intervals = Array(0,0,1,2,2,1,2,2);
	this.initializeScale(key, accidental, intervals, "minor");
	this.conformScale();
}

// getRelativeMajor(): This gives the key for this minor scale's relative major, a.k.a. degree 3.

MinorScale.prototype.getRelativeMajor = function(){

	return this.getScaleDegree(3);
}

// makeNatural(): Resets to a natural minor scale

MinorScale.prototype.makeNatural = function()
{
	this.createScale(this.degrees[1].getNoteWithoutAccidental(), this.degrees[1].getAccidental());

	this.conformScale();
}

// makeHarmonic(): Sharpens Degree 7 to create a harmonic minor scale

MinorScale.prototype.makeHarmonic = function()
{
	if(this.minor_type!=2 && this.minor_type!=1)
	{
		this.makeNatural();
	}

	this.degrees[7].makeSharp();
	this.minor_type = 2;

	this.conformScale();
}

// getTransposedScale(half_steps): override of the superclass function, that includes support for harmonic minor

MinorScale.prototype.getTransposedScale = function(half_steps)
{
	if(this.minor_type != 1)
	{
		this.makeNatural();
	}
			
	var new_scale = new Object();

	for(var prop in this){
	
		new_scale[prop] = this[prop];
	}

	new_scale.transpose(half_steps);

	if(this.minor_type == 2)
	{
		new_scale.makeHarmonic();
	}

	return new_scale;
}
