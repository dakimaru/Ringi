<?php
App::uses('AppController', 'Controller');
App::uses('AppHelper', 'Helper');
App::uses('Sanitize', 'Utility');

class RingiController extends AppController {	
	
	//Put All Model for this controller
    var $uses = array(  'Attribute',
                        'Name',
						'Ringihistory',
						'Ringiroute',
						'Route',
						'UserData');

    public function beforeFilter() {
        parent::beforeFilter();
    }

	public function openSQLconnection() {
		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'ringidata';
		
		$link=mysql_connect($host, $username, $password);
		$ret = mysql_select_db($database, $link);
		
		return $ret;
	}
	
	public function setup() {

		$setup_script_path=$_SERVER['DOCUMENT_ROOT']."/Ringi/app/Vendor/scripts";
		
		$success1 = '<h2 align="center">Setup has been completed. Thank you!</h2><br>';
	
		if (isset($success1)) {
			$this->set('success1',$success1);
		}
		
		$bar = exec("cd $setup_script_path ; sh createRingiTables.sh");
		$bar = exec("cd $setup_script_path ; sh importADToMySql.sh");

	}
			
    public function isAuthorized($user) {

    // Owner can edit and delete
        if (in_array($this->action, array('edit', 'delete'))) {
           //  $postId = $this->request->params['pass'][0];
        }
        return parent::isAuthorized($user);
    }

	public function password_change() {
		if (isset($_POST["newpass"])) {
			if ($_POST["newpass"]!=="" and $_POST["confirmpass"]!=="") {
				if ($_POST["newpass"]==$_POST["confirmpass"]) {
					$userDN = $this->Auth->user('DN');
					$newpassword=$_POST["newpass"];
					exec('cd ../Vendor/ ; sh resetPassword.sh "' .$userDN.'" '.$newpassword);
				}
				else {
					$this->Session->setFlash(__("Your passwords don't match!"));
				}
			}
			else {
				$this->Session->setFlash(__('Invalid entries'));
			}
		}
	}

	public function password_reset() {
	
		$database = 'ringidata';	
		$this->openSQLconnection();
		
		if ($this->request->is('post')) {
			//$username = $POST[];
			//$newpass = $POST[];
			
			
			if ($_POST["newpass"]!=="" && $_POST["selection"]!=="") {
				$user = $_POST["selection"];
				$sql="SELECT DN FROM users WHERE username='".$user."'";
				$query = mysql_query($sql);
				$userDN = mysql_fetch_assoc($query);
				
				$newpassword=$_POST["newpass"];
				exec('cd ../Vendor/ ; sh resetPassword.sh "' .$userDN['DN'].'" '.$newpassword);
				
				$this->Session->setFlash(__("The password of ".$_POST["selection"]." was updated successfully"));
				$this->redirect(array('controller' => 'Ringi', 'action' => 'main_menu'));	
				
			}
			else {
				$this->Session->setFlash(__('Please select an appropriate user and password!'));
			}
			
		}
	
		$sql = "SELECT username FROM users";
		$query = mysql_query($sql);
		
		$allusers = array();
		$num = mysql_num_rows($query);
		for($j=0; $j<$num; $j++){
			$row = mysql_fetch_assoc($query);
			$allusers[$j] = $row['username'];
			//print_r($row);
		}

		//print_r($allusers);
		
		$this->set('allusers',$allusers);
		
	}

	public function main_menu() {
	}
		
	public function upload_layout() {}
	
	public function preview() {

		//The following piece gets the most recently added file in directory /uploads/
		$path = $_SERVER['DOCUMENT_ROOT']."/Ringi/uploads/";
		$d = dir($path); 

		$latest_ctime = 0;
		$latest_filename = '';    

		//this part gets the uploaded file, and creates file upload."ext" in /uploads/
		if ($_POST["submit"] == "Upload" && $_FILES['file']['name']) { //**** User Clicked the Upload Button
			$info = pathinfo($_FILES['file']['name']);
			$ext = $info['extension'];
			if (preg_match("/xls/",$ext)) {
				//saving upload.xls
				move_uploaded_file( $_FILES["file"]["tmp_name"], $path."upload.xls");
				
				while ($entry = $d->read()) {
						$uploadxls=$entry;
						$uploadfilepath = "{$path}{$entry}";	//not in use but may be handy to have
					
					if (preg_match("/active.xls\b/",$entry)) {	// find the file that is called active.xls
						$activexls=$entry;
						$activefilepath = "{$path}{$entry}";	//not in use but may be handy to have
					}
				}
				
				if (isset($activexls)) {
					//Returns the column names of OLD sheet. Also saves upload.php. This file will later be overwritten.
					$oldColumns = $this->tempXLStoPHP($path.$activexls);
					//print_r ($oldColumns);
				}
				
				//Returns the column names of NEW sheet. Here we overwrite upload.xls and make it up to date!
				$latestColumns = $this->tempXLStoPHP($path.$uploadxls);
				//print_r ($latestColumns);
				
				if (isset($oldColumns)) {
					$diff1=array_diff($oldColumns, $latestColumns);
					$diff2=array_diff($latestColumns, $oldColumns);

					$this->set('diff1',$diff1);
					$this->set('diff2',$diff2);
				}
				
				
			}
			else {
				$this->Session->setFlash(__('Invalid file type! Please upload a file with the correct extension.'));
				$this->redirect(array('controller' => 'Ringi', 'action' => 'upload_layout'));				
			}
		}
		else {
			$this->Session->setFlash(__('Please choose a file to upload'));
			$this->redirect(array('controller' => 'Ringi', 'action' => 'upload_layout'));		
		}
	}

	
	public function tempXLStoPHP($excelfile) {
		
		$path = $_SERVER['DOCUMENT_ROOT']."/Ringi/uploads/";
		
		$this->openSQLconnection();

		$objPHPExcel = $this->XLmodify($excelfile);

		$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
		
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
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');

		$objWriter->setUseInlineCSS(true);

		$objWriter->save($path."upload.php");
		
		return $columnNames;
	}
	
	public function XLmodify($XLfile) {

		$this->openSQLconnection();

		$objPHPExcel = PHPExcel_IOFactory::load($XLfile);

		$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();

		$objPHPExcel->getActiveSheet()->getStyle("A1:$highestColumn$highestRow")->getAlignment()
		->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		//showing some possible processes that can be made
		for ($i=1; $i < $highestRow; $i++) { 
			for ($j='A'; $j < $highestColumn; $j++) {
				//eliminating spaces before and after 'input:'
				if ($objPHPExcel->getActiveSheet()->getCell("$j$i") == 'input: ' 
					or $objPHPExcel->getActiveSheet()->getCell("$j$i") == ' input') { 
					$objPHPExcel->getActiveSheet()->SetCellValue("$j$i", 'input:');
				}
			}		
		}
		return $objPHPExcel;
	}
	
	public function upload_confirmation() {
		
		$this->addNewColumns();
		
		$this->from_upload_layout();
	}
	
	public function addNewColumns(){
		
		$database = 'ringidata';
		
		$this->openSQLconnection();
		
		//The following piece gets the most recently added file in directory /uploads/
		$path = $_SERVER['DOCUMENT_ROOT']."/Ringi/uploads/";
		$d = dir($path); 

		$latest_ctime = 0;
		$latest_filename = '';    

		while ($entry = $d->read()) {
			if (preg_match("/upload.xls\b/",$entry)) {	// find the file that is called upload.xls
				$uploadxls=$entry;
				$uploadfilepath = "{$path}{$entry}";	//not in use but may be handy to have
			}
		}
		
		$objPHPExcel = $this->XLmodify($uploadfilepath);

		$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
		
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
		
		for ($i=0; $i < count($columnNames); $i++) { 
			if ($columnTypes[$i]=="string") {
				$columnTypes[$i]= "varchar(255)";
			}
			$query = "ALTER TABLE ATTRIBUTES ADD $columnNames[$i] $columnTypes[$i]";
			mysql_db_query($database,$query);
		}

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');

		$objWriter->setUseInlineCSS(true);

		$objWriter->save($path."upload.php");
	}
	
	public function from_upload_layout(){
		
		$path = $_SERVER['DOCUMENT_ROOT']."/Ringi/uploads/";
		
		$name_before_xls = $path."upload.xls";
		$name_after_xls = $path."active.xls";
		
		$name_before_php = $path."upload.php";
		$name_after_php = $path."active.php";
		
		if ($_POST["submit"] == "confirm" && file_exists($path."upload.xls")) { //**** User Clicked the Confirm Button
			rename($name_before_xls, $name_after_xls);		
		}
		
		if ($_POST["submit"] == "confirm" && file_exists($path."upload.php")) { //**** User Clicked the Confirm Button
			rename($name_before_php, $name_after_php);			
		}
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
			}
		}
		$query = substr($query,0,strlen($query)-2); # lop off the extra trailing comma
			$query .= " WHERE {$id_field}={$newid}";
		mysql_query($query);

		// return the new id
		return $newid;
	}
	
	public function change_privileges() {}
		
	public function overview() {
		//$this->index();
	}
		
	public function processed() {
		$this->index();
	}
		
	public function confirm_applications() {
		$this->index();
	}
		
	public function pending() {
		$this->index();
	}
		
	public function passed_back() {
		$this->index();
	}
	
	public function accepted() {
		$this->index();
	}

	public function rejected() {
		$this->index();
	}

	public function database_log() {
		$this->index();
	}

	public function support() {}

	public function credit() {}
				
    public function index() {
		
		$this->modelClass = null;
        //$username = $this->Auth->user('username');
        //$userrole = $this->Auth->user('title');
        //Setting up so that variables auths and attachments can be used in view
        //$auths = $this->Attribute->find('all');
				
		//$this->set('attachments',$attachments);
        $list_apply = array();
		$list_confirm = array();
		$list_passback = array();
		$list_reject = array();
		$indiv_attachment = array();

		$this->set('auths',$auths);
        $this->set('list_apply',$list_apply);
        $this->set('list_confirm',$list_confirm);
		$this->set('username',$username);
				
    }
	
	public function pattern3 () {
		if (isset($this->data['ringi_number'])) {
			$this->set('status',$this->data['status']);
			$this->set('ringino',$this->data['ringi_number']);
			$this->set('resourceflag',$this->data['resourceflag']);
			$ringino=$this->data['ringi_number'];
			$this->displayApplication($ringino);
		}
		else {
			$this->redirect(array('action' => 'main_menu'));
		}
	}

	public function displayApplication($ringino) {
		$this->openSQLconnection();
		$layoutpath = $_SERVER['DOCUMENT_ROOT']."/Ringi/uploads/";
		$doc = file_get_contents($layoutpath."active.php");
		
		while (preg_match('/input:.+:.+/', $doc, $matches) == 1) {
			$temp = preg_split('/[:]/',$matches[0]);
			$query = mysql_db_query('ringidata', "SELECT $temp[1] FROM attributes WHERE ringino=$ringino");
			$fix = mysql_fetch_assoc($query);
			$doc = preg_replace('/input:(.+):.+/', $fix[$temp[1]], $doc, 1);
		}
		$this->set('doc',$doc);
	}
	
    public function confirm () {
	
		$database = 'ringidata';
		$someTable = 'attributes';
		
		$path = $_SERVER['DOCUMENT_ROOT']."/Ringi/uploads/";
		
		// Connect to MySQL
		$this->openSQLconnection();

		$id = $this->data['idlist2'];
		$id_field = 'id';
		$table = 'attributes';
		
		//dublicate selected application data from database
		$newentryid = $this->DuplicateMySQLRecord($database, $table, $id_field, $id);
		
		//creating a doc string.
		$doc = file_get_contents($path."active.php");
		
		//$titlequery = mysql_db_query($database, "SELECT xxxxxtitle FROM attributes WHERE id=$newentryid");
		$title = mysql_fetch_assoc($titlequery);
		$attachmentid = $this->data['idlist2'];
		//$project_name = $title['xxxxxtitle'];
		
		$formstart = '<form method="post" action="./confirm_check" name="confirm_check1">';
		$formend = '</form>';

		//Code to input the database info.
		//if input:...is found in $doc, split it at ":" and get the column. Then do a query that gets the
		//value, and replace it in $doc 
		while (preg_match('/input:.+:.+/', $doc, $matches) == 1) {
			$temp = preg_split('/[:]/',$matches[0]);
			$query = mysql_db_query($database, "SELECT $temp[1] FROM attributes WHERE id=$id");
			$fix = mysql_fetch_assoc($query);
			$doc = preg_replace('/input:(.+):.+/', $fix[$temp[1]], $doc, 1);
		}
		
		$this->set('project_name',$project_name);
		$this->set('attachmentid',$attachmentid);
		$this->set('doc',$doc);

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
		mysql_connect($host, $username, $password);
		
		$tempcols = mysql_query("SELECT * FROM attributes") or die(mysql_error());
		
		$this->Attribute->save($Attribute);
		echo $this->data['idlist2'];	//contains the application id
    }

	public function pass_back_check () {
			$idlist2=$this->data["idlist2"];
     	$Attribute = $this->Attribute->findById($idlist2);
			$Attribute['Attribute']['xxxxxpassbackflag'] = TRUE;
			$this->Attribute->save($Attribute);
			
		  $username = $this->Auth->user('username');
			$userrole = $this->Auth->user('title');
			$authid=$this->data["idlist2"];
			$PassBackData['PassBackData']['username'] = $username;
			$PassBackData['PassBackData']['userrole'] = $userrole;
				$PassBackData['PassBackData']['xxxxxcomments'] = $this->data["xxxxxpassback1"];
				$PassBackData['PassBackData']['xxxxxauth_id'] = $authid;
     	$this->PassBackData->save($PassBackData);
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

	public function application_details() {	
	}
	
	
	public function apply() {

		$path = $_SERVER['DOCUMENT_ROOT']."/Ringi/uploads/";
		
		//creating a doc string.
		$doc = file_get_contents($path."active.php");
			
		$formstart = '<form name="applyForm" method="post" action="apply_check" onsubmit="return main()" enctype="multipart/form-data">';
	
		$doc = $formstart . $doc .
		'
			<div class="well">
				<div class="text-center">
					<label for="file">Choose your attachments</label><br>
					<input type="file" name="file[]" style="line-height: 0; padding: 0px" multiple="multiple"><br><br>
					<button class="btn btn-success">Apply</button>
				</div>
			</div>
		</form>';
	
		//if input:...is found
		while (preg_match('/input:.+:.+/', $doc, $matches) == 1) {	//strpos($doc, 'input:'.':') ==false
		
			//$doc = preg_replace('/input:(.+):.+/', '<textarea class="replacement" style="width: 100%; height: 100%; min-height:3em; box-sizing: border-box; resize: none; border:none;" id='. findcolname($doc) .' name='. findcolname($doc) .'></textarea>' , $doc);
		
			$temp = preg_split('/[:]/',$matches[0]);
		
			 $doc = preg_replace('/input:(.+):.+/', '<textarea class="replacement" style="width: 100%; height: 100%; min-height:3em; box-sizing: border-box; resize: none; border:none; background-color:white;" id='. $temp[1] .' name='. $temp[1] .'></textarea>' , $doc, 1);
		
		}
		
		//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			//if (isset($this->data['ringino'])) {
			//	$this->openSQLconnection();
			//	$ringino = $this->data['ringino'];
			//	$sql="SELECT count(1) from attributes where ringino = $ringino";
			//	$query = mysql_query($sql) or die(mysql_error());
			//	$ringiunique = mysql_fetch_assoc($query);
			//	$this->set('ringiunique',$ringiunique);
		//	}
	//	}

		$this->set('doc',$doc);
		
		return $doc;
	
    }

	public function apply_check () {
		require_once("../Config/uploads.ctp");
		
		//$database = 'ringidata';
		//$someTable = 'attributes';

		// Connect to MySQL
		$this->openSQLconnection();
		
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


		for ($i=1; $i < $attrnumbers; $i++) {
			$column = $columnNames[$i];
			if (isset($this->data[$column])) {
				$Attribute['Attribute'][$column] = $this->data[$column];
			}
		}
		
		
		//storing non-excel items
		
		//attributes
		$Attribute['Attribute']['applicantid'] = $this->Auth->user('username');
		$Attribute['Attribute']['applydate'] = date("Y-m-d H:i:s");
		$Attribute['Attribute']['ringistatus'] = '002';
		$Attribute['Attribute']['creator_id'] = $this->Auth->user('username');
		$Attribute['Attribute']['created_at'] = date("Y-m-d H:i:s");
		$Attribute['Attribute']['updator_id'] = NULL;
		$Attribute['Attribute']['updated_at'] = NULL;
		$Attribute['Attribute']['activeflag'] = 1;
		$Attribute['Attribute']['deleteReason'] = NULL;
		
		//ringihistories
		
		$Ringihistory['Ringihistory']['ringino'] = $this->data['ringino'];
		$Ringihistory['Ringihistory']['ringiseq'] = 1;
		$Ringihistory['Ringihistory']['approverlayer'] = 0;
		$Ringihistory['Ringihistory']['processerid'] = $this->Auth->user('username');
		$Ringihistory['Ringihistory']['processdate'] = date("Y-m-d H:i:s");
		$Ringihistory['Ringihistory']['ringiaction'] = '001';
		$Ringihistory['Ringihistory']['comment'] = NULL;
		$Ringihistory['Ringihistory']['creator_id'] = $this->Auth->user('username');
		$Ringihistory['Ringihistory']['created_at'] = date("Y-m-d H:i:s");
		$Ringihistory['Ringihistory']['updator_id'] = NULL;
		$Ringihistory['Ringihistory']['updated_at'] = NULL;
		
		
		$this->Attribute->save($Attribute);
		$this->Ringihistory->save($Ringihistory);
		
		//Upload file
		$ringino=$Attribute['Attribute']['ringino'];
		$cmd = "cd $vendorpath ; sh createFolder.sh $folderpath $ringino";
		exec($cmd);
		
		if ($_FILES['file']['name']) {
			$count=0;
			foreach ($_FILES['file']['name'] as $filename) 
	        {
				move_uploaded_file( $_FILES['file']['tmp_name'][$count], $folderpath.$ringino."/".$_FILES['file']['name'][$count]);
				$count++;
	        }
		}
		
		echo "<a href=file://".$folderpath.$ringino.">Link to Uploads</a>";
		
    }

	
	public function edit() {
		$doc = $this->apply();
		echo gettype($doc);
		
	}
	
	
	public function approve() {
		$connection=$this->openSQLconnection();
		$username = $this->Auth->user('username');
		$date = date("Y-m-d H:i:s");
		$ringino = $this->data['ringino'];
		//Get current ringiseq from ringihistories 
		$query = mysql_query("SELECT max(ringiseq) maxringino 
		                        from ringihistories 
		                       where ringino = $ringino 
		                    group by ringino");
		$array = mysql_fetch_assoc($query);
		$ringiseq=$array['maxringino'];
		
		//Get approverLayer from ringiroutes
		$query2 = mysql_query("SELECT approverLayer 
		  						from ringiroutes
							   where ringino = $ringino
		  						 and approverID = '".$username."'");
		$array2 = mysql_fetch_assoc($query2) or die("approverlayer get failure: ". mysql_error());
		$approverlayer=$array2['approverLayer'];

		$sql2="UPDATE ringiroutes
		    Set  approvedate= now(),
		         ringistatus = '002',
		         updator_id = '".$username."',
		         updated_at = now()
		  where ringino = $ringino and  approverid = '".$username."'";

    	$Ringihistory['Ringihistory']['ringino'] = $this->data['ringino'];
    	$Ringihistory['Ringihistory']['ringiseq'] = $ringiseq+1;
    	$Ringihistory['Ringihistory']['approverlayer'] = $approverlayer;
    	$Ringihistory['Ringihistory']['processerid'] = $this->Auth->user('username');
    	$Ringihistory['Ringihistory']['processdate'] = date("Y-m-d H:i:s");
    	$Ringihistory['Ringihistory']['ringiaction'] = '002';
    	$Ringihistory['Ringihistory']['comment'] = $this->data['comment'];
    	$Ringihistory['Ringihistory']['creator_id'] = $this->Auth->user('username');
    	$Ringihistory['Ringihistory']['created_at'] = date("Y-m-d H:i:s");
    	$Ringihistory['Ringihistory']['updator_id'] = NULL;
    	$Ringihistory['Ringihistory']['updated_at'] = NULL;
   
   
    	$this->Ringihistory->save($Ringihistory);

		if ($connection) {
			$query = mysql_query($sql2) or die(mysql_error());
		} else {
			echo "Approve is failure when update the data into database";
		}
	}
	
	public function accept() {	
		$connection=$this->openSQLconnection();
		$username = $this->Auth->user('username');
		$date = date("Y-m-d H:i:s");
		$ringino = $this->data['ringino'];
		//Get current ringiseq from ringihistories 
		$query = mysql_query("SELECT max(ringiseq) maxringino 
		                        from ringihistories 
		                       where ringino = $ringino 
		                    group by ringino");
		$array = mysql_fetch_assoc($query);
		$ringiseq=$array['maxringino'];
		
		//Get approverLayer from ringiroutes
		$query2 = mysql_query("SELECT approverLayer 
		  						from ringiroutes
							   where ringino = $ringino
		  						 and approverID = '".$username."'");
		$array2 = mysql_fetch_assoc($query2) or die("approverlayer get failure: ". mysql_error());
		$approverlayer=$array2['approverLayer'];
		

		$sql1="UPDATE attributes
		    Set  ringistatus = '003',
		           updator_id = '".$username."',
		           updated_at = now()
			where ringino = $ringino";

		$sql2="UPDATE ringiroutes
		    Set  approvedate= now(),
		         ringistatus = '003',
		         updator_id = '".$username."',
		         updated_at = now()
		  where ringino = $ringino and  approverid = '".$username."'";

    	$Ringihistory['Ringihistory']['ringino'] = $this->data['ringino'];
    	$Ringihistory['Ringihistory']['ringiseq'] = $ringiseq+1;
    	$Ringihistory['Ringihistory']['approverlayer'] = $approverlayer;
    	$Ringihistory['Ringihistory']['processerid'] = $this->Auth->user('username');
    	$Ringihistory['Ringihistory']['processdate'] = date("Y-m-d H:i:s");
    	$Ringihistory['Ringihistory']['ringiaction'] = '003';
    	$Ringihistory['Ringihistory']['comment'] = $this->data['comment'];
    	$Ringihistory['Ringihistory']['creator_id'] = $this->Auth->user('username');
    	$Ringihistory['Ringihistory']['created_at'] = date("Y-m-d H:i:s");
    	$Ringihistory['Ringihistory']['updator_id'] = NULL;
    	$Ringihistory['Ringihistory']['updated_at'] = NULL;
   
   
    	$this->Ringihistory->save($Ringihistory);

		if ($connection) {
			$query = mysql_query($sql1) or die(mysql_error());
			$query = mysql_query($sql2) or die(mysql_error());
		} else {
			echo "Accept is failure when update the data into database";
		}
	}
	
	public function reject() {	
		$connection=$this->openSQLconnection();
		$username = $this->Auth->user('username');
		$date = date("Y-m-d H:i:s");
		$ringino = $this->data['ringino'];
		//Get current ringiseq from ringihistories 
		$query = mysql_query("SELECT max(ringiseq) maxringino 
		                        from ringihistories 
		                       where ringino = $ringino 
		                    group by ringino");
		$array = mysql_fetch_assoc($query);
		$ringiseq=$array['maxringino'];
		
		//Get approverLayer from ringiroutes
		$query2 = mysql_query("SELECT approverLayer 
		  						from ringiroutes
							   where ringino = $ringino
		  						 and approverID = '".$username."'");
		$array2 = mysql_fetch_assoc($query2) or die("approverlayer get failure: ". mysql_error());
		$approverlayer=$array2['approverLayer'];
		

		$sql1="UPDATE attributes
		    Set  ringistatus = '004',
		           updator_id = '".$username."',
		           updated_at = now()
			where ringino = $ringino";

		$sql2="UPDATE ringiroutes
		    Set  approvedate= NOW(),
		         ringistatus = '004',
		         updator_id = '".$username."',
		         updated_at = now()
		  where ringino = $ringino and  approverid = '".$username."'";

    	$Ringihistory['Ringihistory']['ringino'] = $this->data['ringino'];
    	$Ringihistory['Ringihistory']['ringiseq'] = $ringiseq+1;
    	$Ringihistory['Ringihistory']['approverlayer'] = $approverlayer;
    	$Ringihistory['Ringihistory']['processerid'] = $this->Auth->user('username');
    	$Ringihistory['Ringihistory']['processdate'] = date("Y-m-d H:i:s");
    	$Ringihistory['Ringihistory']['ringiaction'] = '004';
    	$Ringihistory['Ringihistory']['comment'] = $this->data['comment'];
    	$Ringihistory['Ringihistory']['creator_id'] = $this->Auth->user('username');
    	$Ringihistory['Ringihistory']['created_at'] = date("Y-m-d H:i:s");
    	$Ringihistory['Ringihistory']['updator_id'] = NULL;
    	$Ringihistory['Ringihistory']['updated_at'] = NULL;
   
   
    	$this->Ringihistory->save($Ringihistory);

		if ($connection) {
			$query = mysql_query($sql1) or die(mysql_error());
			$query = mysql_query($sql2) or die(mysql_error());
		} else {
			echo "Reject is failure when update the data into database";
		}
	}
	
	public function hold() {	
		$connection=$this->openSQLconnection();
		$username = $this->Auth->user('username');
		$date = date("Y-m-d H:i:s");
		$ringino = $this->data['ringino'];
		//Get current ringiseq from ringihistories 
		$query = mysql_query("SELECT max(ringiseq) maxringino 
		                        from ringihistories 
		                       where ringino = $ringino 
		                    group by ringino");
		$array = mysql_fetch_assoc($query);
		$ringiseq=$array['maxringino'];
		
		//Get approverLayer from ringiroutes
		$query2 = mysql_query("SELECT approverLayer 
		  						from ringiroutes
							   where ringino = $ringino
		  						 and approverID = '".$username."'");
		$array2 = mysql_fetch_assoc($query2) or die("approverlayer get failure: ". mysql_error());
		$approverlayer=$array2['approverLayer'];
		

		$sql1="UPDATE attributes
		    Set  ringistatus = '006',
		           updator_id = '".$username."',
		           updated_at = now()
			where ringino = $ringino";

		$sql2="UPDATE ringiroutes
		    Set  approvedate= NOW(),
		         ringistatus = '006',
		         updator_id = '".$username."',
		         updated_at = now()
		  where ringino = $ringino and  approverid = '".$username."'";

    	$Ringihistory['Ringihistory']['ringino'] = $this->data['ringino'];
    	$Ringihistory['Ringihistory']['ringiseq'] = $ringiseq+1;
    	$Ringihistory['Ringihistory']['approverlayer'] = $approverlayer;
    	$Ringihistory['Ringihistory']['processerid'] = $this->Auth->user('username');
    	$Ringihistory['Ringihistory']['processdate'] = date("Y-m-d H:i:s");
    	$Ringihistory['Ringihistory']['ringiaction'] = '006';
    	$Ringihistory['Ringihistory']['comment'] = $this->data['comment'];
    	$Ringihistory['Ringihistory']['creator_id'] = $this->Auth->user('username');
    	$Ringihistory['Ringihistory']['created_at'] = date("Y-m-d H:i:s");
    	$Ringihistory['Ringihistory']['updator_id'] = NULL;
    	$Ringihistory['Ringihistory']['updated_at'] = NULL;
   
   
    	$this->Ringihistory->save($Ringihistory);

		if ($connection) {
			$query = mysql_query($sql1) or die(mysql_error());
			$query = mysql_query($sql2) or die(mysql_error());
		} else {
			echo "Hold is failure when update the data into database";
		}
	}
	
	public function passback() {	
		$connection=$this->openSQLconnection();
		$username = $this->Auth->user('username');
		$date = date("Y-m-d H:i:s");
		$ringino = $this->data['ringino'];
		//Get current ringiseq from ringihistories 
		$query = mysql_query("SELECT max(ringiseq) maxringino 
		                        from ringihistories 
		                       where ringino = $ringino 
		                    group by ringino");
		$array = mysql_fetch_assoc($query);
		$ringiseq=$array['maxringino'];
		
		//Get approverLayer from ringiroutes
		$query2 = mysql_query("SELECT approverLayer 
		  						from ringiroutes
							   where ringino = $ringino
		  						 and approverID = '".$username."'");
		$array2 = mysql_fetch_assoc($query2) or die("approverlayer get failure: ". mysql_error());
		$approverlayer=$array2['approverLayer'];
		echo "username:".$username." and approverlater: ".$approverlayer;
		
		//if layer=1, which means it passed back by first approver -> set back to editing 
		if ( $approverlayer == 1) {
			$sql1="UPDATE attributes
			    Set  ringistatus = '001',
			           updator_id = '".$username."',
			           updated_at = now()
				where ringino = $ringino";

			//clear the application history to let applicant reapply  
			$sql2="UPDATE ringiroutes
			    Set  approvedate= NULL,
			         ringistatus = NULL,
			         updator_id = '".$username."',
			         updated_at = now()
			  where ringino = $ringino and  approverLayer = 0 ";

	    	$Ringihistory['Ringihistory']['ringino'] = $this->data['ringino'];
	    	$Ringihistory['Ringihistory']['ringiseq'] = $ringiseq+1;
	    	$Ringihistory['Ringihistory']['approverlayer'] = $approverlayer;
	    	$Ringihistory['Ringihistory']['processerid'] = $this->Auth->user('username');
	    	$Ringihistory['Ringihistory']['processdate'] = date("Y-m-d H:i:s");
	    	$Ringihistory['Ringihistory']['ringiaction'] = '009';
	    	$Ringihistory['Ringihistory']['comment'] = $this->data['comment'];
	    	$Ringihistory['Ringihistory']['creator_id'] = $this->Auth->user('username');
	    	$Ringihistory['Ringihistory']['created_at'] = date("Y-m-d H:i:s");
	    	$Ringihistory['Ringihistory']['updator_id'] = NULL;
	    	$Ringihistory['Ringihistory']['updated_at'] = NULL;


	    	$this->Ringihistory->save($Ringihistory);

			if ($connection) {
				$query = mysql_query($sql1) or die(mysql_error());
				$query = mysql_query($sql2) or die(mysql_error());
			} else {
				echo "Passback by first approver is failure when update the data into database";
			}			
		} else  
		// if layer > 1, which means it passed by 2 and above approver -> set back to previous approver 
		{

			//clear the application history to let applicant reapply  
			$sql2="UPDATE ringiroutes
				     Set  approvedate= NULL,
				          ringistatus = NULL,
				          updator_id = '".$username."',
				          updated_at = now()
				    where ringino = $ringino and  approverLayer = $approverlayer - 1 ";

		    $Ringihistory['Ringihistory']['ringino'] = $this->data['ringino'];
		    $Ringihistory['Ringihistory']['ringiseq'] = $ringiseq+1;
		    $Ringihistory['Ringihistory']['approverlayer'] = $approverlayer;
		    $Ringihistory['Ringihistory']['processerid'] = $this->Auth->user('username');
		    $Ringihistory['Ringihistory']['processdate'] = date("Y-m-d H:i:s");
		    $Ringihistory['Ringihistory']['ringiaction'] = '010';
		    $Ringihistory['Ringihistory']['comment'] = $this->data['comment'];
		    $Ringihistory['Ringihistory']['creator_id'] = $this->Auth->user('username');
		    $Ringihistory['Ringihistory']['created_at'] = date("Y-m-d H:i:s");
		    $Ringihistory['Ringihistory']['updator_id'] = NULL;
		    $Ringihistory['Ringihistory']['updated_at'] = NULL;


		    $this->Ringihistory->save($Ringihistory);

			if ($connection) {
				$query = mysql_query($sql2) or die(mysql_error());
			} else {
				echo "Passback by higher approver is failure when update the data into database";
			}
		}

	}
	
	public function reopen() {
		$connection=$this->openSQLconnection();
		$username = $this->Auth->user('username');
		$date = date("Y-m-d H:i:s");
		$ringino = $this->data['ringino'];
		//Get current ringiseq from ringihistories 
		$query = mysql_query("SELECT max(ringiseq) maxringino 
		                        from ringihistories 
		                       where ringino = $ringino 
		                    group by ringino");
		$array = mysql_fetch_assoc($query);
		$ringiseq=$array['maxringino'];
		
		//Get approverLayer from ringiroutes
		$query2 = mysql_query("SELECT approverLayer 
		  						from ringiroutes
							   where ringino = $ringino
		  						 and approverID = '".$username."'");
		$array2 = mysql_fetch_assoc($query2) or die("approverlayer get failure: ". mysql_error());
		$approverlayer=$array2['approverLayer'];
		

		$sql1="UPDATE attributes
		    Set  ringistatus = '002',
		           updator_id = '".$username."',
		           updated_at = now()
			where ringino = $ringino";

		$sql2="UPDATE ringiroutes
		    Set  approvedate= NULL,
		         ringistatus = NULL,
		         updator_id = '".$username."',
		         updated_at = now()
		  where ringino = $ringino and  approverid = '".$username."'";

    	$Ringihistory['Ringihistory']['ringino'] = $this->data['ringino'];
    	$Ringihistory['Ringihistory']['ringiseq'] = $ringiseq+1;
    	$Ringihistory['Ringihistory']['approverlayer'] = $approverlayer;
    	$Ringihistory['Ringihistory']['processerid'] = $this->Auth->user('username');
    	$Ringihistory['Ringihistory']['processdate'] = date("Y-m-d H:i:s");
    	$Ringihistory['Ringihistory']['ringiaction'] = '011';
    	$Ringihistory['Ringihistory']['comment'] = $this->data['comment'];
    	$Ringihistory['Ringihistory']['creator_id'] = $this->Auth->user('username');
    	$Ringihistory['Ringihistory']['created_at'] = date("Y-m-d H:i:s");
    	$Ringihistory['Ringihistory']['updator_id'] = NULL;
    	$Ringihistory['Ringihistory']['updated_at'] = NULL;
   
   
    	$this->Ringihistory->save($Ringihistory);

		if ($connection) {
			$query = mysql_query($sql1) or die(mysql_error());
			$query = mysql_query($sql2) or die(mysql_error());
		} else {
			echo "Reopen is failure when update the data into database";
		}
	}
	
	public function cancel1() {
		$connection=$this->openSQLconnection();
		$username = $this->Auth->user('username');
		$date = date("Y-m-d H:i:s");
		$ringino = $this->data['ringino'];
		//Get current ringiseq from ringihistories 
		$query = mysql_query("SELECT max(ringiseq) maxringino 
		                        from ringihistories 
		                       where ringino = $ringino 
		                    group by ringino");
		$array = mysql_fetch_assoc($query);
		$ringiseq=$array['maxringino'];

		$sql1="UPDATE attributes
			Set  ringistatus = '001',
			updator_id = '".$username."',
			updated_at = now()
		where ringino = $ringino";

		$sql2="UPDATE ringiroutes
			Set  approvedate= Null,
			ringistatus = Null,
			updator_id = '".$username."',
			updated_at = now()
		where ringino = $ringino and  approverlayer = 0";

		$Ringihistory['Ringihistory']['ringino'] = $this->data['ringino'];
		$Ringihistory['Ringihistory']['ringiseq'] = $ringiseq+1;
		$Ringihistory['Ringihistory']['approverlayer'] = 0;
		$Ringihistory['Ringihistory']['processerid'] = $this->Auth->user('username');
		$Ringihistory['Ringihistory']['processdate'] = date("Y-m-d H:i:s");
		$Ringihistory['Ringihistory']['ringiaction'] = '007';
		$Ringihistory['Ringihistory']['comment'] = $this->data['comment'];
		$Ringihistory['Ringihistory']['creator_id'] = $this->Auth->user('username');
		$Ringihistory['Ringihistory']['created_at'] = date("Y-m-d H:i:s");
		$Ringihistory['Ringihistory']['updator_id'] = NULL;
		$Ringihistory['Ringihistory']['updated_at'] = NULL;
		
		$this->Ringihistory->save($Ringihistory);
		

		if ($connection) {
			$query = mysql_query($sql1) or die(mysql_error());
			$query = mysql_query($sql2) or die(mysql_error());
		} else {
			echo "Applicantion cancelation is failure when update the data into database";
		}
	}
	
	public function cancel2() {	
			$connection=$this->openSQLconnection();
			$username = $this->Auth->user('username');
			$date = date("Y-m-d H:i:s");
			$ringino = $this->data['ringino'];
			//Get current ringiseq from ringihistories 
			$query = mysql_query("SELECT max(ringiseq) maxringino 
			                        from ringihistories 
			                       where ringino = $ringino 
			                    group by ringino");
			$array = mysql_fetch_assoc($query);
			$ringiseq=$array['maxringino'];

			//Get approverLayer from ringiroutes
			$query2 = mysql_query("SELECT approverLayer 
			  						from ringiroutes
								   where ringino = $ringino
			  						 and approverID = '".$username."'");
		    $array2 = mysql_fetch_assoc($query2) or die("approverlayer get failure: ". mysql_error());
			$approverlayer=$array2['approverLayer'];


			$sql2="UPDATE ringiroutes
			          Set  approvedate= NULL,
			         	   ringistatus = NULL,
			               updator_id = '".$username."',
			               updated_at = now()
			         WHERE ringino = $ringino and  approverid = '".$username."'";

			$Ringihistory['Ringihistory']['ringino'] = $this->data['ringino'];
			$Ringihistory['Ringihistory']['ringiseq'] = $ringiseq+1;
			$Ringihistory['Ringihistory']['approverlayer'] = $approverlayer;
   	   		$Ringihistory['Ringihistory']['processerid'] = $this->Auth->user('username');
 	   		$Ringihistory['Ringihistory']['processdate'] = date("Y-m-d H:i:s");
 	   		$Ringihistory['Ringihistory']['ringiaction'] = '008';
 	   		$Ringihistory['Ringihistory']['comment'] = $this->data['comment'];
 	   		$Ringihistory['Ringihistory']['creator_id'] = $this->Auth->user('username');
 	   		$Ringihistory['Ringihistory']['created_at'] = date("Y-m-d H:i:s");
 	   		$Ringihistory['Ringihistory']['updator_id'] = NULL;
 	   		$Ringihistory['Ringihistory']['updated_at'] = NULL;

			$this->Ringihistory->save($Ringihistory);

			if ($connection) {
				$query = mysql_query($sql2) or die(mysql_error());
			} else {
				echo "Approver Cancel is failure when update the data into database";
			}
	
	}
	
	
}
