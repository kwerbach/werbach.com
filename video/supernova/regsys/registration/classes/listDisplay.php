<?php
class listDisplay
{
		private $_dbConn;
		private $_myList = 'red';
		private $_sqlColumns = '*';
		private $_sqlTable;		
		private $_sqlWhere;
		private $_sqlOrder;
		private $_sqlLimit;
		private $_sqlStatement;
		private $_partial;
		
		public function __construct($listName, $whereArr, $orderArr, $limitArr){ $this->init($listName, $whereArr, $orderArr, $limitArr); }
		/**
		* Load a list
		* @param string $listName The name of the table or join to be querried
		* @param array $whereArr The array that holds the where clause
		* @param array $orderStr Order By clause; Field => Direction
		* @param array $limitArr An aray holding the limit and offset for the SQL statment
		* @todo split and check limitArr
		* @todo make orderStr an array
		*/
		private function init($listName, $whereArr, $orderArr, $limitArr)
		{
			$sqlHelper = new sqlHelper;
			$this->_myList		= $listName;
			$this->_sqlColumns	= '*';
			$this->_sqlTable	= 'reg__' . $listName;
			$this->_sqlWhere	= $sqlHelper->sqlWhereBuilder($whereArr);
			$this->_sqlOrder	= $sqlHelper->sqlOrderBuilder($orderArr);
			$this->_sqlLimit	= $sqlHelper->sqlLimitBuilder($limitArr);
			$this->_partial		= $listName;
					
			$this->_sqlStatement = "SELECT $this->_sqlColumns FROM $this->_sqlTable $this->_sqlWhere $this->_sqlOrder $this->_sqlLimit;";
//			echo $this->_sqlStatement;  // TESTING
			if ($listName != '-')
			{
				$this->getListData($this->_sqlStatement, $this->_partial);
			}

		}
		
		private function getListData($sqlStr, $partial)
		{
			
//			echo "<hr/>";
//			echo "<hr/>";
//			include "partials/$partial.php";
//			

			
			$listOutput = "";
			$sqlHelper 	= new sqlHelper;
			$rsObj = $sqlHelper->queryCmd($sqlStr);
			if($rsObj){
				while($rsRowArr = mysql_fetch_assoc($rsObj)){
					//$listOutput .= $rsRowArr['working_name']."<hr/>\n";
					$listOutput .= "<a href=\"forms/" . $partial . '.php?' . $partial . '_id='
						. $rsRowArr[$partial.'_id'] 
						. "\" title=\""
						. $rsRowArr[$partial.'_id']
						. "\" target=\"_mainContentFrame\""
						. ">" 
						. $rsRowArr['working_name'] 
						. "</a><hr/>\n";
				}
			}			
			echo $listOutput;
			
//			echo "<hr/>";
//			echo $sqlStr;
//			
			
		}

	}

?>