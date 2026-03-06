<?php

class formHelper
{

		/** 
		* Gets data from a database and puts it into global varialbes to be used later when building the form fields
		* @param string Looks for the id field in the querystring
		* @return boolean
		*/
		public function populateForm($table='', $keyField='', $sql='')
		{
//			echo "key field ( $keyField )= '" . $_GET[$keyField] . "' & SQL = '" . $sql . "'<hr/>"; // TESTING
			if(!empty($_GET[$keyField]) || !empty($sql))  // As long as you have something for the SQL
			{ 			
				$sqlHelper = new sqlHelper;
				if ($sql != '')
				{
//					echo "SQL is not '':" . $sql;		// TESTING
					$rsObj = $sqlHelper->queryCmd($sql);
				}
				else
				{
//					echo "SQL is '':" . $sql;		// TESTING
					$rsObj = $sqlHelper->queryCmd("SELECT * FROM $table WHERE $keyField = " . $_GET[$keyField]);
				}							
				if($rsObj){
					while($rsRowArr = mysql_fetch_assoc($rsObj)){
							foreach($rsRowArr as $key => $value)
							{
								global $$key;
								$$key = $value;
//										echo $key . '=>' . $$key."<hr/>\n";  // TESTING
							}
					}
				}
			}
			if(!isset($$keyField))  // Init the keyfield variable so we don't get a PHP warning: Undefined variable: <varable name>
			{ 
				global $$keyField;
				$$keyField = ''; 
			} 

			return 1;
		}	

		
		/**
		 * render text field
		 * @param string $name Name of the form field & the id field
		 * @param string $size Default value of the form field
		 * @param int $tabIndexInt Sets the tabindex of a field
		 * @param mixed $value Length of the field
		 * @param array $extraArr  List of all extra form field attributes		 
		 * @param string $id Id of the field. If empty this will take the value from name
		 * @param int $maxlength Max length of the field
		 * @param string $class Css Class	 
		 */
 		 public function renderTextField($name, $size='20', $tabIndexInt=NULL, $extraArr='', $value='', $id='', $maxlength='', $class='formField')
		 {
		 	if ($id == '') { $id = $name; }
			$tabIndexStr = empty($tabIndexInt) ? "" : "tabindex=\"$tabIndexInt\" ";
			if ($value == '') { global $$name; $value = $$name; }
		 	if ($maxlength == '') { $maxlength = $size; }
		 	if(is_array($extraArr)) 
			{ 
				$extraStr = $this->parseExtra($extraArr);
			}
			else
			{ 
				$extraStr = '';
			}
		 
	$return = <<<EOQ
<input name="$name" type="text" id="$name" value="$value" size="$size" maxlength="$maxlength" class="$class" $tabIndexStr $extraStr/>
EOQ;
	echo $return;
		 }

		/**
		 * render text field with a date picker. This converts MySQL date to MM/DD/YYYY in the form field.
		 * @param string $name Name of the form field & the id field
		 * @param string $size Default value of the form field
		 * @param int $tabIndexInt Sets the tabindex of a field
		 * @param mixed $value Length of the field
		 * @param array $extraArr  List of all extra form field attributes		 
		 * @param string $id Id of the field. If empty this will take the value from name
		 * @param string $dataPrefix This prefix tells the database that a date is coming - used with sqlHelper Class
		 * @param int $maxlength Max length of the field
		 * @param string $class Css Class	 
		 */
 		 public function renderTextFieldDp($name, $tabIndexInt=NULL, $extraArr='', $size='10', $value='', $id='', $dataPrefix='d_', $maxlength='10', $class='formField')
		 {
		 	if ($id == '') { $id = $name; }
			$tabIndexStr = empty($tabIndexInt) ? "" : "tabindex=\"$tabIndexInt\" ";
			if ($value == '') { global $$name; $value = $$name; }
		 	if ($maxlength == '') { $maxlength = $size; }
		 	if(is_array($extraArr)) 
			{ 
				$extraStr = $this->parseExtra($extraArr);
			}
			else
			{ 
				$extraStr = '';
			}
			$dateValue = $this->fromMysqlDate($value);
		 
	$return = <<<EOQ
<input name="$dataPrefix$name" type="text" id="$dataPrefix$name" value="$dateValue" size="$size" maxlength="$maxlength" class="$class" $tabIndexStr $extraStr/>
<script type="text/javascript">
	$(function() {
		$('#$dataPrefix$name').datepicker({
			showButtonPanel: true
		});
	});			
</script>
EOQ;
	echo $return;
		 }

// string textarea_field([string name [, string value [, int cols [, int rows [, string wrap mode]]]]])

// This function returns an HTML textarea field. The default size is
// 50 columns and 10 rows, and the default wrap mode is 'soft', which means 
// no hard newline characters will be inserted after line breaks in what
// the user types into the field. The alternative wrap mode is 'hard',
// which means that hard newlines will be inserted.

		 public function renderTextarea ($name="", $value="", $cols=50, $rows=5, $tabIndexInt=NULL,  $extraArr='', $id='', $class='formField', $wrap="soft")
{
		 	if ($id == '') { $id = $name; }
			$tabIndexStr = empty($tabIndexInt) ? "" : "tabindex=\"$tabIndexInt\" ";
		 	if(is_array($extraArr)) 
			{ 
				$extraStr = $this->parseExtra($extraArr);
			}
			else
			{ 
				$extraStr = '';
			}
	$return = <<<EOQ
<textarea name="$name" id="$id" cols="$cols" rows="$rows" wrap="$wrap" $tabIndexStr $extraStr>$value</textarea>
EOQ;
	echo $return;
}

// string password_field ([string name [, string value [, int size [, int maximum length]]]])

// This function returns an HTML password field. This is like a text field,
// but the value of the field is obscured (only stars or bullets are visible
// for each character).  The default size of the field is 10.  A starting
// value and maximum data length may be supplied.

		 public function password_field ($name="", $value="", $size=10, $maxlen="")
{
	$output = <<<EOQ
<input type="password" name="$name" value="$value" size="$size" maxlength="$maxlen" />
EOQ;
	return $output;
}

// string hidden_field ([string name [, string value]])

// This function returns an HTML hidden field. A value may be supplied.

		 public function renderHiddenField ($name='', $value='', $extraArr='', $id='')
{
		 	if ($id == '') { $id = $name; }
		 	if(is_array($extraArr)) 
			{ 
				$extraStr = $this->parseExtra($extraArr);
			}
			else
			{ 
				$extraStr = '';
			}
			$return = <<<EOQ
<input type="hidden" name="$name" value="$value" id="$id" $extraStr/>
EOQ;
	echo $return;
}

// string file_field ([string name])

// This function returns an HTML file field. These are used to specify
// files on the user's local hard drive, typically for uploading as
// part of the form. (See http://www.zend.com/manual/features.file-upload.php
// for more information about this subject.)

		 public function file_field ($name="")
		{
			$output = <<<EOQ
<input type="file" name="$name">
EOQ;
			return $output;
		}

// string submit_field ([string name [, string value]])

// This function returns an HTML submit field. The value of the field
// will be the string displayed by the button displayed by the user's
// browser. The default value is "Submit".

		 public function submit_field ($name='', $value='', $extraArr='', $id='')
{
		 	if ($id == '') { $id = $name; }
		 	if(is_array($extraArr)) 
			{ 
				$extraStr = $this->parseExtra($extraArr);
			}
			else
			{ 
				$extraStr = '';
			}
	if (empty($value)) { $value = "Submit"; }

	$output = <<<EOQ
<input type="submit" name="$name" id="$id" value="$value" $extraStr/>
EOQ;
	return $output;
}

// string image_field ([string name [, string src [, string value]]])

// This function returns an HTML image field. An image field works
// likes a submit field, except that the image specified by the URL
// given in the second argument is displayed instead of a button.

	public function image_field ($name="", $src="", $value="")
	{
		if (empty($value)) { $value = $name; }

	$output = <<<EOQ
<input type="image" name="$name" value="$value" src="$src">
EOQ;
		return $output;
	}

// string reset_field ([string name [, string value]])

// This function returns an HTML reset field. A reset field returns
// the current form to its original state.

		 public function reset_field ($name="reset", $value="Reset")
{
	$output = <<<EOQ
<input type="reset" name="$name" value="$value">
EOQ;
	return $output;
}

// string checkbox_field ([string name [, string value [, string label [, string match]]]])

// This function returns an HTML checkbox field. The optional third argument
// will be included immediately after the checkbox field, and the pair
// is included inside a HTML <nobr> tag - meaning that they will be
// displayed together on the same line.  If the value of the
// second or third argument matches that of the fourth argument,
// the checkbox will be 'checked' (i.e., flipped on).

		 public function checkbox_field ($name="", $value="", $label="", $match="")
{
	$checked = ($value == $match || $label == $match) ? "checked" : "";
	$output = <<<EOQ
<nobr><input type="checkbox" name="$name" value="$value" $checked> $label</nobr>
EOQ;
	return $output;
}

// string radio_field ([string name [, string value [, string label [, string match]]]])

// This function returns an HTML radio button field. The optional third 
// argument will be included immediately after the radio button, and the pair
// is included inside a HTML <nobr> tag - meaning that they will be
// displayed together on the same line.  If the value of the
// second or third argument matches that of the fourth argument,
// the radio button will be 'checked' (i.e., flipped on).

public function renderRadio ($name="", $value="",  $label="", $match="", $tabIndexInt=NULL, $extraArr="", $id="")
{
	$checked = ($value == $match || $label == $match) ? "checked=\"checked\"" : "";
	if ($id == '') { $id = $name; }
	$tabIndexStr = empty($tabIndexInt) ? "" : "tabindex=\"$tabIndexInt\" ";
	if(is_array($extraArr)) 
	{ 
		$extraStr = $this->parseExtra($extraArr);
	}
	else
	{ 
		$extraStr = '';
	} 	
	$return = <<<EOQ
<nobr><input type="radio" name="$name" id="$id" value="$value" $checked $extraStr tabindex="$tabIndexStr"> $label</nobr>
EOQ;
	echo $return;
}


/**
* Creates a select field from the database
* @param string The query to return the data for the list
* @param string The database field that shows up as the value
* @param string The database field that shows up as the text
* @param string The value that should be select by default
*/
		public function renderSelectDb($name, $query, $value_field, $label_field='', $match='', $tabIndexInt=NULL, $id='', $extraArr=array(), $callToAction='Select...')
		{
		 	if ($id == '') { $id = $name; }
			if ($label_field == '') { $label_field = $value_field; }
			$tabIndexStr = empty($tabIndexInt) ? "" : "tabindex=\"$tabIndexInt\" ";			
			if(is_array($extraArr)) 
			{ 
				$extraStr = $this->parseExtra($extraArr);
			}
			else
			{ 
				$extraStr = '';
			}
			
			$open = "<select name=\"$name\" id=\"$id\" $tabIndexStr $extraStr>";
			$sqlHelper = new sqlHelper;
			$rsObj = $sqlHelper->queryCmd($query);
			if($rsObj)
			{
				$options = '<option value="">' . $callToAction . '</option>';
				while($rsRowArr = mysql_fetch_assoc($rsObj)){
					$selected = ($match == $rsRowArr[$value_field]) ? " selected=\"selected\"" : "";
					$options .= "\t<option value=\"$rsRowArr[$value_field]\"$selected>$rsRowArr[$label_field]</option>\n";
				}
			}
			$close = "</select>";
			mysql_free_result($rsObj);
			echo $open . $options . $close;
		}

/**
* Creates a select field from an arry
* @param $name string The name of the select list 
* @param $valueArr array Array of values
* @param $labelArr array Array of labels for values
* @param $match string The selected value
* @param $tabIndexInt string The value that should be select by default
* @param $id string 
* @param $extraArr array 
* @param $callToAction
*/
	public function renderSelect($name, $valueArr, $labelArr='', $match='', $tabIndexInt=NULL, $id='', $extraArr=array(), $callToAction='Select...')
	{
		if ($id == '') { $id = $name; }
		$tabIndexStr = empty($tabIndexInt) ? "" : "tabindex=\"$tabIndexInt\" ";	
		if(is_array($extraArr)) 
		{ 
			$extraStr = $this->parseExtra($extraArr);
		}
		else
		{ 
			$extraStr = '';
		}
		
		$options = '\t<option value="">' . $callToAction . '</option>';
		for	($i = 0; $i < count($valueArr); $i++)
		{
			$label	= (isset($labelArr[$i])) ?  $labelArr[$i] :	$valueArr[$i];
			$value	= $valueArr[$i];
			$selected = ($match == $valueArr[$i]) ? " selected=\"selected\"" : "";
			$options .= "\t<option value=\"$value\"$selected>$label</option>\n";
			
		}		

		$open 	= "<select name=\"$name\" id=\"$id\" $tabIndexStr $extraStr>\n";

		$close	= "</select>";
		
		echo $open.$options.$close;

	}

// string db_radio_field (string name, string table name, string value field, string label field, string sort field, [string match text], [string where clause])

// This function returns a list of HTML radio button fields, separated
// by a non-breaking space HTML entity (&nbsp;) and a newline, based
// on the values in the MySQL database table named by the second
// argument, as returned by the db_values_array() function (defined in 
// /book/functions/db.php).

	public function db_radio_field ($name="", $table="", $value_field="", $label_field="", $sort_field="", $match="", $where="")
	{
		$values = db_values_array($table, $value_field, $label_field
			, $sort_field, $where
		);
	
		$output = "";
		while (list($value, $label) = each($values))
		{
			$output .= radio_field($name, $value, $label, $match)
				."&nbsp;\n"
			;
		}
		return $output;
	}

/** Cycle thourg the array of field attributes
* @param array
* @return string
*/

	private function parseExtra($extraArr)
	{
		$return = '';
		foreach($extraArr as $key => $value)
		{
			$return .=	$key . '="' . $value . '" ';
		}
		return $return;
	}

/** Change MySQL date into mm/dd/yyy
* @param datetime
*/
private function fromMysqlDate($date)
{
	$result = preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}/",$date);	
	if ($result)
	{
		$tempDate = explode(' ', trim($date));
		list($year, $month, $day) = split('[-]', $tempDate[0]);
		$return = "$month/" . 
					str_pad($day,2,'0',STR_PAD_LEFT)	. "/" .
					str_pad($year,2,'0',STR_PAD_LEFT);
		
		if (isset($tempDate[1]))		// You've got time
		{
			$tempTime = explode(':', $tempDate[1]);
			$hour 	= (isset($tempTime[0])) ? str_pad($tempTime[1],2,'0') : '00'; 
			$minute	= (isset($tempTime[1])) ? $tempTime[1] : '00'; 
			$second	= (isset($tempTime[2])) ? $tempTime[2] : '00'; 	
			
			$return .= ' ' . "$hour:$minute:$second";	// append time to end of date
		} 
	}
	else
	{
		$return = '';
	}
	return $return;
}

}	