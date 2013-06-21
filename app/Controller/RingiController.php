<?php
App::uses('AppController', 'Controller');
App::uses('AppHelper', 'Helper');
App::uses('Sanitize', 'Utility');

class RingiController extends AppController {	
			
    public function isAuthorized($user) {

    // Owner can edit and delete
        if (in_array($this->action, array('edit', 'delete'))) {
           //  $postId = $this->request->params['pass'][0];
        }
        return parent::isAuthorized($user);
    }   

    //Put All Model for this controller
    var $uses = array(  'Attribute',
                        'UserData',
						'PassBackData');

    public function beforeFilter() {
        parent::beforeFilter();
    }

	public function createRingiTable(){
		
		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'ringidata';
		$someTable = 'attributes';
		
		// Connect to MySQL
		$link = mysql_connect($host, $username, $password);

		// Make RingiData the current database
		$db_selected = mysql_select_db($database, $link);

		if (!$db_selected) {
		  // If we couldn't, then it either doesn't exist, or we can't see it. 
		$sql = "CREATE DATABASE $database";
		
			if (mysql_query($sql, $link)) {
				echo "<br>Database $database created successfully";
			} 
			else {
				echo '<br>Error creating database: ' . mysql_error();
			}
		}
		
		mysql_select_db($database, $link);	//pointing at the right database

		$sql = "CREATE TABLE IF NOT EXISTS $someTable (
			`id` int unsigned NOT NULL auto_increment PRIMARY KEY,
			`updated_at` timestamp,
			`created_at` timestamp NULL,
			`xxxxxauth1` varchar(255),
			`xxxxxauth2` varchar(255),
			`xxxxxauth3` varchar(255),
			`xxxxxauth4` varchar(255),
			`xxxxxauth5` varchar(255),
			`xxxxxauth6` varchar(255),
			`xxxxxauth7` varchar(255),
			`xxxxxdate1` date,
			`xxxxxdate2` date,
			`xxxxxdate3` date,
			`xxxxxdate4` date,
			`xxxxxdate5` date,
			`xxxxxdate6` date,
			`xxxxxdate7` date,
			`xxxxxpassbackflag` int,
			`xxxxxrejectflag` int,
			`xxxxxtitle` varchar(255),
			`xxxxxcomment` text
			
		   ) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
		
		if (mysql_query($sql, $link)) {
			echo "<br>Table created successfully";
		} 
		else {
			echo '<br>Error creating table: ' . mysql_error();
		}
	}

	public function XLStoHTML(){
			//PHPExcel conversion from Excel to html, prepared for output
		$excelfile = "Ringi.xls";
		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'ringidata';
		$someTable = 'attributes';

		// Connect to MySQL
		$link = mysql_connect($host, $username, $password);


		$objPHPExcel = PHPExcel_IOFactory::load($excelfile);

		$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();

		$objPHPExcel->getActiveSheet()->getStyle("A1:$highestColumn$highestRow")->getAlignment()
		->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


		for ($i=1; $i < $highestRow; $i++) { 
			for ($j='A'; $j < $highestColumn; $j++) {
				if ($objPHPExcel->getActiveSheet()->getCell("$j$i") == 'input: ' 
					or $objPHPExcel->getActiveSheet()->getCell("$j$i") == ' input') {
					$objPHPExcel->getActiveSheet()->SetCellValue("$j$i", 'input:');
				}
			}		
		}


		$columnNames = array();
		$columnTypes = array();

		for ($i=1; $i < $highestRow; $i++) { 
			for ($j='A'; $j <= $highestColumn; $j++) {
				$cellVal = $objPHPExcel->getActiveSheet()->getCell("$j$i");	//getting as a excel with all the formatting and colors
				$cellVal = PHPExcel_Shared_String::SanitizeUTF8($cellVal);	//sanitizing to only string value
				$exploded = explode(':',$cellVal);							//seperating at : creating an Array[0] => input, Array[1] => ...
				if ($exploded[0] == 'input') {								//if the identifier shows the string input
					$colName = $exploded[1];
					$colType = $exploded[2];

					array_push($columnNames, $colName);
					array_push($columnTypes, $colType);

				}
			}		
		}

		mysql_select_db($database, $link);
		for ($i=0; $i < count($columnNames); $i++) { 
			if ($columnTypes[$i]=="string") {
				$columnTypes[$i]= "varchar(255)";
			}
			$order1 = "ALTER TABLE $someTable ADD $columnNames[$i] $columnTypes[$i]";
			mysql_db_query($database,$order1);
		}


		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');

		$objWriter->setUseInlineCSS(true);

		$objWriter->save('/tmp/test.php');
	}
	
	public function initialization(){
		
		$this->createRingiTable();

		$this->XLStoHTML();
	}
	
	public function DuplicateMySQLRecord ($database, $table, $id_field, $id) {
	  // load the original record into an array  	
		$search = "SELECT * FROM $table WHERE $id_field=$id";
		$result = mysql_db_query($database, $search);
	  	$original_record = mysql_fetch_assoc($result);

	  // insert the new record and get the new auto_increment id
	  mysql_query("INSERT INTO {$table} (`{$id_field}`) VALUES (NULL)");
	  $newid = mysql_insert_id();

	  // generate the query to update the new record with the previous values
	  $query = "UPDATE {$table} SET ";
	  foreach ($original_record as $key => $value) {
	    if ($key != $id_field) {
	        $query .= $key.' = "'.str_replace('"','\"',$value).'", ';
	echo $query;
	    }
	  }
	  $query = substr($query,0,strlen($query)-2); # lop off the extra trailing comma
	  $query .= " WHERE {$id_field}={$newid}";
	  mysql_query($query);

	  // return the new id
	  return $newid;
	}
		
    public function index() {
		
		$this->modelClass = null;
        $username = $this->Auth->user('username');
        $userrole = $this->Auth->user('role');
        //Setting up so that variables auths and attachments can be used in view
        $auths = $this->Attribute->find('all');
				
		//$this->set('attachments',$attachments);
        $list_apply = array();
		$list_confirm = array();
		$list_passback = array();
		$list_reject = array();
		$indiv_attachment = array();
		$i=0;
				
        foreach($auths as $auth){
			//$indiv_attachment = $this->Attribute->findById($auth['Attribute']['attachmentid']);

						
			$authlevel = 0;
            $confirmlevel = 0;

            if($auth['Attribute']['xxxxxauth1']==$username){
                $authlevel = 1;
            }
            if($auth['Attribute']['xxxxxauth2']==$username){
                $authlevel = 2;
            }
            if($auth['Attribute']['xxxxxauth3']==$username){
                $authlevel = 3;
            }
            if($auth['Attribute']['xxxxxauth4']==$username){
                $authlevel = 4;
            }
            if($auth['Attribute']['xxxxxauth5']==$username){
                $authlevel = 5;
            }
            if($auth['Attribute']['xxxxxauth6']==$username){
                $authlevel = 6;
            }
            if($auth['Attribute']['xxxxxauth7']==$username){
                $authlevel = 7;
            }
            array_push($list_apply, $authlevel);

            if($auth['Attribute']['xxxxxdate1'] == NULL && $auth['Attribute']['xxxxxauth1']==$username){
                $confirmlevel = 1;
            }
            if($auth['Attribute']['xxxxxdate2'] == NULL && $userrole == 'mgr'){
                $confirmlevel = 2;
            }
            if($auth['Attribute']['xxxxxdate3'] == NULL && $userrole =='agm'){
                $confirmlevel = 3;
            }
            if($auth['Attribute']['xxxxxdate4'] == NULL && $userrole == 'gm'){
                $confirmlevel = 4;
            }
            if($auth['Attribute']['xxxxxdate5'] == NULL && $userrole =='hr'){
                $confirmlevel = 5;
            }
            if($auth['Attribute']['xxxxxdate6'] == NULL && $userrole=='pr'){
                $confirmlevel = 6;
            }
            if($auth['Attribute']['xxxxxdate7'] == NULL && $userrole=='admin' ){
                $confirmlevel = 7;
            }
            array_push($list_confirm, $confirmlevel);
						$i++;
        }
		
		$this->set('auths',$auths);
        $this->set('list_apply',$list_apply);
        $this->set('list_confirm',$list_confirm);
		$this->set('username',$username);
				
    }

	public function apply () {
	
	
		$this->set("header_for_layout","Application for RINGI");
        $this->set('username', $this->Auth->user('username'));
		$this->initialization();
		
		
		echo "<br>";
		echo "<br>";
		
		
		//$ringino =$this->Attribute->getLastInsertID();
        //$this->set('ringino', $ringino);
		
		//creating a doc string.
		$doc = file_get_contents('/tmp/test.php');
				
		$formstart = '<form method="post" action="apply_check">';
		$formend = '</form>';
		
		$doc = $formstart .
				'<div class="text-center">
					<textarea class="span6" style="resize: none; font-size:30px;" 
					placeholder = "Enter title of this application" wrap="off" rows="1"
					name="xxxxxtitle"></textarea>
				</div>
				<hr>'
				. $doc .
				'<div class="text-center"><button class="btn btn-success">Apply</button>'
				. $formend .
				'</div>';
		
		//if input:...is found
		while (preg_match('/input:.+:.+/', $doc, $matches) == 1) {	//strpos($doc, 'input:'.':') ==false
			
			//$doc = preg_replace('/input:(.+):.+/', '<textarea class="replacement" style="width: 100%; height: 100%; min-height:3em; box-sizing: border-box; resize: none; border:none;" id='. findcolname($doc) .' name='. findcolname($doc) .'></textarea>' , $doc);
			
			$temp = preg_split('/[:]/',$matches[0]);
			
			 $doc = preg_replace('/input:(.+):.+/', '<textarea class="replacement" style="width: 100%; height: 100%; min-height:3em; box-sizing: border-box; resize: none; border:none;" id='. $temp[1] .' name='. $temp[1] .'></textarea>' , $doc, 1);
			
		}
		
		print_r("$doc");
		
    }

   	public function apply_check () {
        $this->set("header_for_layout","Application for RINGI");
		$this->set('username', $this->Auth->user('username'));

		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'ringidata';
		$someTable = 'attributes';

		// Connect to MySQL
		$link = mysql_connect($host, $username, $password);

		// Make Attributes the current database
		mysql_select_db($database, $link);
		if (mysql_query("SELECT id FROM attributes WHERE id=1")) {
			$selectcols = "SELECT * FROM attributes WHERE id=1";
		}
		else {
			$selectcols = "SELECT * FROM attributes";
		}
		
		$tempcols = mysql_query($selectcols) or die(mysql_error());

		$attrnumbers = mysql_num_fields($tempcols);		//this has the number of columns!!!		

		$columnNames = array();

		for ($i=0; $i < $attrnumbers; $i++) { 
			$test = mysql_field_name($tempcols,$i);	
			array_push($columnNames, $test);
		}


		for ($i=21; $i < $attrnumbers; $i++) {
			$column = $columnNames[$i];
			$Attribute['Attribute'][$column] = $this->data[$column];		
		}
		
		$Attribute['Attribute']['xxxxxauth1'] = $this->Auth->user('username');
		$Attribute['Attribute']['xxxxxdate1'] = date("Y-m-d H:i:s"); 
		$Attribute['Attribute']['xxxxxtitle'] = $this->data['xxxxxtitle'];;
		
		$this->Attribute->save($Attribute);
		//print_r($this->Attribute->getLastInsertID());
		
		
		$latestid = mysql_query("SELECT MAX(id) FROM attributes");
		$querystring = mysql_fetch_assoc($latestid);
		$number = $querystring['MAX(id)'];
		$updatedtime = mysql_query("SELECT updated_at FROM attributes WHERE id="."$number");
		$updated_at = mysql_fetch_assoc($updatedtime);
		$updated_final = $updated_at['updated_at'];
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//if (mysql_query("SELECT created_at FROM attributes WHERE id=$latestid") == NULL) {
		//	mysql_query("UPDATE attributes SET created_at=$updated_final WHERE id=$latestid");
		//}
    }

    public function analise () {
        $this->autoLayout = true;
    }

    public function confirm () {
		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<br>";
		
		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'ringidata';
		$someTable = 'attributes';

		// Connect to MySQL
		$link = mysql_connect($host, $username, $password);

		$id = $this->data['idlist2'];
		$id_field = 'id';
		$table = 'attributes';
		
		//dublicate selected application data from database
		$newentryid = $this->DuplicateMySQLRecord($database, $table, $id_field, $id);
		
		//creating a doc string.
		$doc = file_get_contents('/tmp/test.php');
		
		$titlequery = mysql_db_query($database, "SELECT xxxxxtitle FROM attributes WHERE id=$newentryid");
		$title = mysql_fetch_assoc($titlequery);
		$formstart = '<form method="post" action="./confirm_check" name="confirm_check1">';
		$formend = '</form>';
				
		$doc = 	'<div style="padding-left: 1em;"><h1 class="text-center">' . "$title[xxxxxtitle]" . "</h1><hr>"
				. "$formstart $doc" . 
				'<div class="text-center">
					<hr>
					<br>
					<textarea class="span9" style="resize: none; font-size:20px;" 
					placeholder = "Enter comment here" rows="8" name="xxxxxcomment"></textarea>
				</div>'
				. '<div class="text-center">
					<button class="btn btn-success">Confirm</button>
				</div>'
				."$formend" . '</div>';

		//Code to input the database info.
		//if input:...is found in $doc, split it at ":" and get the column. Then do a query that gets the
		//value, and replace it in $doc 
		while (preg_match('/input:.+:.+/', $doc, $matches) == 1) {
			$temp = preg_split('/[:]/',$matches[0]);
			$query = mysql_db_query($database, "SELECT $temp[1] FROM attributes WHERE id=$id");
			$fix = mysql_fetch_assoc($query);
			$doc = preg_replace('/input:(.+):.+/', $fix[$temp[1]], $doc, 1);
		}
		
		//create dublicate row
		//
		print_r("$doc");
    }

   	public function confirm_check () {
		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'ringidata';
		$someTable = 'attributes';

		$Attribute['Attribute']['xxxxxauth2'] = $this->Auth->user('username');
		$Attribute['Attribute']['xxxxxdate2'] = date("Y-m-d H:i:s"); 
		$Attribute['Attribute']['xxxxxattachmentid'] = $this->data['idlist2'];
		$Attribute['Attribute']['xxxxxcomment'] = $this->data['xxxxxcomment'];
		
		// Connect to MySQL
		$link = mysql_connect($host, $username, $password);

		// Make Attributes the current database
		mysql_select_db($database, $link);
		
		$tempcols = mysql_query("SELECT * FROM attributes") or die(mysql_error());
		
		$this->Attribute->save($Attribute);
    }

	public function pass_back_check () {
			$idlist2=$this->data["idlist2"];
     	$Attribute = $this->Attribute->findById($idlist2);
			$Attribute['Attribute']['xxxxxpassbackflag'] = TRUE;
			$this->Attribute->save($Attribute);
			
		  $username = $this->Auth->user('username');
			$userrole = $this->Auth->user('role');
			$authid=$this->data["idlist2"];
			$PassBackData['PassBackData']['username'] = $username;
			$PassBackData['PassBackData']['userrole'] = $userrole;
				$PassBackData['PassBackData']['xxxxxcomments'] = $this->data["xxxxxpassback1"];
				$PassBackData['PassBackData']['xxxxxauth_id'] = $authid;
     	$this->PassBackData->save($PassBackData);
	}
	
	public function reject () {
			$idlist2=$this->data["idlist2"];
     	$Attribute = $this->Attribute->findById($idlist2);
			$Attribute['Attribute']['xxxxxrejectflag'] = TRUE;
			$this->Attribute->save($Attribute);
			
	}

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }


}
