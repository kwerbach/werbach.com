<?php

class sqlHelper
{
		private $_dbConn;
		
		public function __construct(){ $this->init(); }
		
		/**
		 * Initializes database connection
		 */
		private function init(){
			$this->_dbConn = mysql_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD) 
				or die ("Could not connect to database server!!! "
						.mysql_error()
						);

			mysql_select_db(DB_NAME, $this->_dbConn) 
				or die ("Could not select the database!!! "
						.mysql_error()
						);
			
		}

	/** int safe_query ([string query])
	
	 This function will execute an SQL query against the currently open
	 MySQL database. If the global variable $queryDebug is not empty,
	 the query will be printed out before execution. If the execution fails,
	 the query and any error message from MySQL will be printed out, and
	 the function will return FALSE. Otherwise, it returns the MySQL
	 result set identifier.
	* @param string The SQL statement
	*/
	public function queryCmd($query)
	{

		$result = mysql_query($query)
			or die("ack! query failed: "
				."<li>errorno=".mysql_errno()
				."<li>error=".mysql_error()
				."<li>query=".$query
			);

		return $result;
	}

/** Get one piece of data
* @param $table
* @param $field_return The one piece of data that you want to get
* @param field_match The field to match on
* @param $match The value to find
* @param $sql If there is a SQL statent that will override the first 4 params
*/
public function getDatum($table, $field_return, $field_match, $match, $sql='')
{
	$sql	= ($sql != '') ? $sql : "SELECT $field_return FROM $table WHERE $field_match = $match";
	$rsObj 	= $this->queryCmd($sql . " LIMIT 1;");
	if($rsObj){
		$num = mysql_num_rows( $rsObj );
		if ($num == 1)
		{
			$rsRowArr = mysql_fetch_row( $rsObj );
			return $rsRowArr[0];		// return the defaults
		}
		else
		{
			return null;
		}
	}
}

/**
* Convert the given value to something that is safe for MySQL
* @param string The value to make safe for SQL
* @param string The data type of the value
* @return string
*/
public function toSQL($val='', $type='text')
{
		if($val != '')
		{
			$tempStr = trim($val);
			switch ($type) 
			{
				case 'number':
					 if(is_numeric($tempStr))
						{
							$repl		= array(',', '$');					// look for commas and dollar signs
							$return 	= str_replace($repl,'',$tempStr);		// ... and take them out
						}
						else
						{
							die(ERR_101 . ' (value entered --> ' . $tempStr . ')'); //$return = 'null';
						}
					break;
				case 'datetime':
					$result = preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{2,4}/",$tempStr);		// TODO: add optional time to AND '-', '.'  to regex
					if($result)
					{
						$return = (get_magic_quotes_gpc()) ? "'" . $this->toMysqlDate($tempStr) . "." : "'" . addslashes($this->toMysqlDate($tempStr)). "'";
					}
					else
					{
						die(ERR_102 . ' (value entered --> ' . $tempStr . ')'); //$return = 'null';
					}
					break;
				case 'noquotes':
					$return = (get_magic_quotes_gpc()) ? $tempStr : addslashes($tempStr);	// can be used for like
					break;		
				default:
					$return = (get_magic_quotes_gpc()) ? "'" . $tempStr . "." : "'" . addslashes($tempStr). "'";	// normal string
			}
		}
		else
		{
			$return = 'null';
		}

	return $return;
}



/** Convert mm/dd/yyyy hh:nn:ss to yyyy-mm-dd hh:nn:ss
* @param date
* @return string
*/

private function toMysqlDate($date='01/01/1900')
{
	$tempDate = explode(' ', trim($date));
	list($month, $day, $year) = split('[/.-]', $tempDate[0]);
	if (isset($tempDate[1]))
	{
		$tempTime = explode(':', $tempDate[1]);		// TODO: check to see that you have an hour and a minute
	} 
	$hour 	= (isset($tempTime[0])) ? str_pad($tempTime[1],2,'0') : '00'; 
	$minute	= (isset($tempTime[1])) ? $tempTime[1] : '00'; 
	$second	= (isset($tempTime[2])) ? $tempTime[2] : '00'; 	

	return "$year-" . 
				str_pad($month,2,'0',STR_PAD_LEFT)	. "-" .
				str_pad($day,2,'0',STR_PAD_LEFT)	. " " .
				"$hour:$minute:$second";
}

/**
* Cycle through and array of name/value pairs and make redy for SQL
* @param $tempArray array The value to make safe for SQL
* @return boolean
*/
public function arrToSql($tempArray)
{
	global $fieldArr, $valueArr;
	foreach($tempArray as $key => $value)
	{
//		echo substr($key, 0, 2) . "=>" . $value;		// TESTING
		substr($key, 0, 2);
			switch (substr($key, 0, 2)) 
			{
				case 'x_':
				case '__':
					// do nothing
					break;
				case 'd_':
					// mysql data
					array_push($fieldArr, substr($key, 2, strlen($key)));
					array_push($valueArr, $this->toSQL($value,'datetime'));
					break;
				case 'n_':
					// number
					array_push($fieldArr, substr($key, 2, strlen($key)));
					array_push($valueArr, $this->toSQL($value,'number'));
					break;	
    			default:
       				// string
					array_push($fieldArr, $key);
					array_push($valueArr, $this->toSQL($value,'text'));
			}				
	}
	
	return 1;
}


		/**
		 * Creates a sql insert query
		 * @param array column names
		 * @param array values matching column names to insert
		 * @param string table name to insert into
		 * @return boolean
		 */
		public function sqlInsert($colNamesArr, $valuesArr, $tableNameStr){
			if(	(is_array($colNamesArr) && count($colNamesArr)>0) && 
				(is_array($valuesArr) && count($valuesArr)>0) )
			{
				$sqlStr = '';
				$valuesStr = '';
				for($i=0;$i<count($colNamesArr);$i++){
					$value = $valuesArr[$i];
					$sqlStr .= $colNamesArr[$i].', ';
					$valuesStr .= $value.', ';
			}
				$sqlStr 	= trim($sqlStr,', ');		// Take off the last comma
				$valuesStr	= trim($valuesStr,', ');	// Take off the last comma				
//				echo 'INSERT INTO '.$tableNameStr.' ('. $sqlStr.') VALUES ('.$valuesStr.')';	// TESTING
				$this->queryCmd('INSERT INTO '.$tableNameStr.' ('. $sqlStr.') VALUES ('.$valuesStr.')');
				return mysql_insert_id();
			}
			else
			{
				return false;
			}
		}



		/**
		 * Creates a sql update query
		 * @param array column names
		 * @param array values matching column names to insert
		 * @param string table name to update
		 * @param string where clause to use
		 * @return boolean
		 */
		public function sqlUpdate($colNamesArr, $valuesArr, $tableNameStr, $whereClauseStr)
		{
			if(	(is_array($colNamesArr) && count($colNamesArr)>0) && 
				(is_array($valuesArr) && count($valuesArr)>0) )
			{
				$sqlStr = 'UPDATE '.$tableNameStr.' SET ';
				for($i=0;$i<count($colNamesArr);$i++){
						$value = $valuesArr[$i];
						$sqlStr .= $colNamesArr[$i].'='.$value.',';
			}

				$sqlStr = trim($sqlStr,',');		// Take off the last comma
//				echo $sqlStr.$whereClauseStr;		// TESTING
				return $this->queryCmd($sqlStr.$whereClauseStr);
			}
			else
			{
				return false;
			}
		}

	/** Build a where clause from an array.  If and arrays value is an array then use the IN or BETWEEN operators. Note: preficex are case sensitive.
	* @param array
	* @return string
	*/
	public function sqlWhereBuilder($whereArr)
		{

			$fieldArr		= array();
			$operatorArr	= array();
			$valueArr		= array();
			$tempSqlWhere 	= '';
			$return 		= '';
			if (is_array($whereArr))
			{
				foreach($whereArr as $key => $value)
				{
					if(!is_array($value))
					{
						$value = trim($value);
						substr($key, 0, 2);
						switch (substr($key, 0, 2)) 
						{
							case 'x_':
								// do nothing
								break;		
							case 'e_':
							case '__':
								// equals
									array_push($fieldArr, substr($key, 2, strlen($key)));
									array_push($operatorArr, '=');					
									array_push($valueArr, $this->toSQL($value,'text'));
									break;	
							case 'E_':
								// not equal
									array_push($fieldArr, substr($key, 2, strlen($key)));
									array_push($operatorArr, '!=');					
									array_push($valueArr, $this->toSQL($value,'text'));
									break;	
							case 'g_':
								// greater than
									array_push($fieldArr, substr($key, 2, strlen($key)));
									array_push($operatorArr, '>');					
									array_push($valueArr, $this->toSQL($value,'text'));						
								break;
							case 'G_':
								// equal to or greater than
									array_push($fieldArr, substr($key, 2, strlen($key)));
									array_push($operatorArr, '>=');					
									array_push($valueArr, $this->toSQL($value,'text'));						
								break;				
							case 'l_':
								// less than
									array_push($fieldArr, substr($key, 2, strlen($key)));
									array_push($operatorArr, '<');					
									array_push($valueArr, $this->toSQL($value,'text'));				
								break;
							case 'L_':
								// equal to or less than
									array_push($fieldArr, substr($key, 2, strlen($key)));
									array_push($operatorArr, '<=');					
									array_push($valueArr, $this->toSQL($value,'text'));				
								break;				
							default:
								// like
									array_push($fieldArr, $key);
									array_push($operatorArr, 'LIKE');
									array_push($valueArr, $this->toSQL($value . '%','text'));
								break;
						}
		
					}
					else  // Is array, use IN or BETWEEN
					{
						switch (substr($key, 0, 2)) 
						{
							case 'x_':
								// do nothing
								break;		
							case 'i_':
								// IN
									array_push($fieldArr, substr($key, 2, strlen($key)));							
									array_push($operatorArr, 'IN');	
									array_push($valueArr, " ('" . implode("',' ", $value) . "') ");					
									break;	
							case 'I_':
								// NOT IN
									array_push($fieldArr, substr($key, 2, strlen($key)));							
									array_push($operatorArr, 'NOT IN');	
									array_push($valueArr, " ('" . implode("',' ", $value) . "') ");				
									break;
							case 'b_':
								// BETWEEN DATES
									array_push($fieldArr, substr($key, 2, strlen($key)));							
									array_push($operatorArr, 'BETWEEN');	
									array_push($valueArr,  $this->toSQL($value[0], 'datetime') . " AND " . $this->toSQL($value[1], 'datetime'));													
									break;									
							default:
								// IN
									array_push($fieldArr, $key);							
									array_push($operatorArr, 'IN');	
									array_push($valueArr, " ('" . implode("',' ", $value) . "') ");				
									break;									
								
						}
					}
				}
			}
			for ($i = 0; $i < count($valueArr); $i++)
			{
				$tempSqlWhere .= $fieldArr[$i] . " ";
				$tempSqlWhere .= $operatorArr[$i] . " ";
				$tempSqlWhere .= $valueArr[$i] . " ";
				$tempSqlWhere .= "AND " . " ";
			}						
			
			if ($tempSqlWhere != '') 
			{ 
				$tempSqlWhere = " WHERE " . $tempSqlWhere;
				$tempSqlWhere = rtrim($tempSqlWhere, ' AND ');
				$tempSqlWhere = rtrim($tempSqlWhere, ' OR ');
			}
	
			return $tempSqlWhere;
		}

	/**
	* Build the order by statement from an associative array
	* @param array $orderArr
	* @return string $tempSqlOrder The order by clause
	*/
	public function sqlOrderBuilder($orderArr)
	{

			$fieldArr		= array();
			$directionArr	= array();
			$tempSqlOrder 	= '';
			$return 		= '';
			if (is_array($orderArr))
			{
				foreach($orderArr as $key => $value)
				{
					if (!empty($key))
					{
						$tempSqlOrder .= " $key $value, ";
					}
				}
				
			}
			
			if ($tempSqlOrder != '') 
			{ 
				$tempSqlOrder = " ORDER BY " . $tempSqlOrder;
				$tempSqlOrder = rtrim($tempSqlOrder);
				$tempSqlOrder = rtrim($tempSqlOrder, ',');
			}
	
			return $tempSqlOrder;						
	}
	
	/**
	* Build the order by statement from an associative array
	* @param array $limitArr
	* @return string $tempSqlOrder The order by clause
	*/
	public function sqlLimitBuilder($limitArr)
	{

			$tempSqlLimit 	= '';
			$return 		= '';
			if (is_array($limitArr))
			{
				$numRowsStr	= (isset($limitArr[0])) ? $limitArr[0] : '';
				$offsetStr	= (isset($limitArr[1])) ? $limitArr[1] . ',' : '';
				$tempSqlLimit = $offsetStr . $numRowsStr;
				
			}
			
			if ($tempSqlLimit != '') 
			{ 
				$tempSqlLimit = " LIMIT " . $tempSqlLimit;
				$tempSqlLimit = rtrim($tempSqlLimit);
				$tempSqlLimit = rtrim($tempSqlLimit, ',');
			}
	
			return $tempSqlLimit;						
	}				
}	