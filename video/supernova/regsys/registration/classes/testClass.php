<?php
	class testClass{
		private $_dbConn;
		private $_color = 'red';		
		
		
		public function __construct($id){ $this->init($id); }
		
		private function init($id)
		{
			echo "hello world...";
			
			$this->_dbConn = mysql_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD);
			if($this->_dbConn){
				if(!mysql_select_db(DB_NAME, $this->_dbConn)){
					echo mysql_error();
				}
			}else{
				echo mysql_error();
			}
			
			$radioGroupStr = '';
			if($id != ''){
				$sqlStr = 'SELECT * FROM reg_conference WHERE conference_id = ' . $id;
			} else {
				$sqlStr = 'SELECT * FROM reg_conference';
			}
			$rsObj = mysql_query($sqlStr, $this->_dbConn);
			if($rsObj){
				$totalRowsNum = mysql_num_rows($rsObj);
				while($rsRowArr = mysql_fetch_assoc($rsObj)){
					$radioGroupStr .= $rsRowArr['working_name']."<hr/>\n";
				}
			}			
			echo $radioGroupStr;
			echo $this->_color;		
		}
	
	}
	
//$tester = new testClass(2);