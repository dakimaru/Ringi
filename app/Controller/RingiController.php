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
        $this->Auth->allow('setup'); 
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
	
	public function Convertor($namecd, $nameType){
		$sql="SELECT name
				FROM names
				WHERE namecd = '$namecd'
					and nametype = '$nameType'";
		$query = mysql_query("$sql");
		$array = mysql_fetch_assoc($query);
		$name = $array['name'];
		return $name;
	}
	
	public function setup() {

		//print_r($scr_create_ringi_tables);
		$exec1 = $this->exec_in_vendorpath('CreateRingiTable', 	"2>&1");
		$exec2 = $this->exec_in_vendorpath('LoadUser',			"2>&1");
		echo "$exec1";
		echo "$exec2";
		if ( (!$exec1) && (!$exec2)) {
			echo "string";
			$success1 = '<h2 align="center">Setup has been completed. Thank you!</h2><br>';
			$this->set('success1',$success1);
		}
	}
			
    public function isAuthorized($user) {

    // Owner can edit and delete
        if (in_array($this->action, array('edit', 'delete'))) {
           //  $postId = $this->request->params['pass'][0];
        }
        return parent::isAuthorized($user);
    }

	public function main_menu() {
		$connection=$this->openSQLconnection();
		$username = $this->Auth->user('username');

		//Name, title, departement
		$sql="SELECT department, title, name FROM users WHERE username = '$username'";
		$query = mysql_query("$sql");
		$array = mysql_fetch_assoc($query);
		$this->set('name', $array['name']);
		$this->set('department', $array['department']);
		$this->set('title', $array['title']);
				
		//editing number
		$sql = "SELECT count(1) count
                        From attributes
                        where applicantid = '$username' ".
                        "and ringistatus = '001'";
		$editquery = mysql_query("SELECT count(1) count
			From attributes 
			where applicantid = '$username' ".
			"and ringistatus = '001'");
		$clean = mysql_fetch_assoc($editquery);
		$editcount=$clean['count'];

		//applications number
		$applicationquery = mysql_query("SELECT count(1)  count 
			From attributes 
			where applicantid = '$username' ".
			"and ringistatus not in ('001','005')");
		$clean = mysql_fetch_assoc($applicationquery);
		$applicationcount=$clean['count'];

		//accepted number
		$acceptednumber = mysql_query("SELECT count(1) count
			From attributes 
			where applicantid = '$username' ".
			"and ringistatus = '003'");
		$clean = mysql_fetch_assoc($acceptednumber);
		$acceptednumber=$clean['count'];

		//progress number
		$progressnumber = mysql_query("SELECT count(1) count
			From attributes 
			where applicantid = '$username' ".
			"and ringistatus = '002'");
		$clean = mysql_fetch_assoc($progressnumber);
		$progressnumber=$clean['count'];

		$this->set('editcount',$editcount);
		$this->set('applicationcount',$applicationcount);
		$this->set('acceptednumber',$acceptednumber);
		$this->set('progressnumber',$progressnumber);
		
		//routes
		$sql = "SELECT approverdept, approvertitle,approverid 
			From routes, users
			WHERE routes.department = users.department
			and routes.approveRouteType = '0'
			and routes.person is NULL
			and users.username = '$username'
			ORDER BY routes.approverlayer";
		$query = mysql_query("$sql");
		$approverCount = mysql_num_rows($query);
		for ($i = 0; $i < $approverCount; $i ++){
			$array = mysql_fetch_assoc($query);
			$approverId[$i] = $array['approverid'];
			$approverDept[$i] = $array['approverdept'];
			$approverTitle[$i] = $array['approvertitle'];
		}

		$this->set('approverCount', $approverCount);
		$this->set('approverId', $approverId);
		$this->set('approverDept', $approverDept);
		$this->set('approverTitle', $approverTitle);

		//Applications
		$sql="SELECT ringino, ringiname, project, purpose, applydate, applicantid, IFNull(asset,0)+IFNull(expense,0) application, IFNull(assetremain,0)+IFNull(expenseremain,0) remain, ringistatus
					From attributes
					where applicantid='$username'";
			
		$query = mysql_query($sql);
		$applicationCount = mysql_num_rows($query);
		$this->set('applicationCount', $applicationCount);
		if ($applicationCount > 0){
			for ($i = 0; $i < $applicationCount; $i ++){
				$array = mysql_fetch_assoc($query);
				$ringino[$i] = $array['ringino'];
				$ringiName[$i] = $array['ringiname'];
				$project[$i] = $array['project'];
				$purpose[$i] = $array['purpose'];
				$applyDate[$i] = $array['applydate'];
				$ringistatus[$i] = $array['ringistatus'];
				$ringistatusname[$i] = $this->Convertor($array['ringistatus'], 'RingiStatus');
				$application[$i] = $array['application'];
				$remain[$i] = $array['remain'];
				$buttonsql="SELECT ringiAction 
					From ringihistories 
				where (ringiNO, ringiseq) in ( select ringiNO, Max(ringiseq) 
				from ringihistories 
				where ringiNO = '$ringino[$i]'
				group by ringino)";

			$buttonquery = mysql_query($buttonsql);
			$array2 = mysql_fetch_assoc($buttonquery);

			$ringiaction[$i] = $array2['ringiAction'];
		}

		$this->set('ringiaction', $ringiaction);
		$this->set('ringino', $ringino);
		$this->set('ringiName', $ringiName);
		$this->set('project', $project);
		$this->set('purpose', $purpose);
		$this->set('applyDate', $applyDate);
		$this->set('ringiStatus', $ringistatus);
		$this->set('application', $application);
		$this->set('remain', $remain);
		$this->set('ringiStatusName', $ringistatusname);
	}

		/*
		$query1 = mysql_query("SELECT approverDept, approverTitle,approverID 
							From routes, users
							where routes.department = users.department
		    				and routes.approveRouteType = '0'
		    				and routes.person is NULL
		    				and users.username = '".$username."'");

		$array1 = array();
		while ($row = mysql_fetch_assoc($query1)) {
		    $array1[] = $row;
		}
		*/	
	}
		
	public function task() {
		$connection=$this->openSQLconnection();
		$username = $this->Auth->user('username');
		//$ringino = $this->data['ringino'];
		//Get current ringiseq from ringihistories
		//$sql="SELECT * from attributes where ringino='$ringino'";
		$sql="SELECT department, title, name FROM users WHERE username = '$username'";
		$query = mysql_query("$sql");
		$array = mysql_fetch_assoc($query);
		$this->set('name', $array['name']);
		$this->set('department', $array['department']);
		$this->set('title', $array['title']);
		$sql="SELECT count(1) count
			FROM attributes a, ringiroutes b
			WHERE a.ringino =  b.ringino
				and b.approverid = '$username'
				and a.ringistatus = '002'
				and (a.ringino,b.approverlayer)
			IN  (select ringino,min(approverlayer) approverlayer 
			        FROM ringiroutes 
			        WHERE approvedate is NULL  and approverlayer >0
				GROUP BY ringino)";
		$query = mysql_query("$sql");
		$array = mysql_fetch_assoc($query);
		$this->set('taskLeft', $array['count']);

		$sql = "SELECT approverdept, approvertitle,approverid 
			From routes, users
			WHERE routes.department = users.department
				and routes.approveRouteType = '0'
				and routes.person is NULL
				and users.username = '$username'
			ORDER BY routes.approverlayer";
		$query = mysql_query("$sql");
		$approverCount = mysql_num_rows($query);
		$this->set('approverCount', $approverCount);
		if ($approverCount > 0){
			for ($i = 0; $i < $approverCount; $i ++){
				$array = mysql_fetch_assoc($query);
				$approverId[$i] = $array['approverid'];
				$approverDept[$i] = $array['approverdept'];
				$approverTitle[$i] = $array['approvertitle'];
			}
			$this->set('approverId', $approverId);
			$this->set('approverDept', $approverDept);
			$this->set('approverTitle', $approverTitle);
		}
		$sql="SELECT a.ringino, a.ringiname, a.project, a.purpose, a.applydate, a.applicantid, IFNull(a.asset,0)+IFNull(a.expense,0) application, IFNull(a.assetremain,0)+IFNull(expenseremain,0) remain
			FROM attributes a, ringiroutes b
			WHERE a.ringino =  b.ringino 
				and b.approverid = '$username'
				and a.ringistatus = '002'
				and (a.ringino,b.approverlayer)
			IN  (select ringino,min(approverlayer) approverlayer 
                                FROM ringiroutes 
                                WHERE approvedate is NULL
					and approverlayer >0
				GROUP BY ringino)";
		$query = mysql_query("$sql");
		$applicationCount = mysql_num_rows($query);
		$this->set('applicationCount', $applicationCount);
		if ($applicationCount > 0){
			for ($i = 0; $i < $applicationCount; $i ++){
			$array = mysql_fetch_assoc($query);
			$ringiNo[$i] = $array['ringino'];
			$ringiName[$i] = $array['ringiname'];
			$project[$i] = $array['project'];
			$purpose[$i] = $array['purpose'];
			$applyDate[$i] = $array['applydate'];
			$applicantId[$i] = $array['applicantid'];
			$application[$i] = $array['application'];
			$remain[$i] = $array['remain'];
			}
			$this->set('ringiNo', $ringiNo);
			$this->set('ringiName', $ringiName);
			$this->set('project', $project);
			$this->set('purpose', $purpose);
			$this->set('applyDate', $applyDate);
			$this->set('applicantId', $applicantId);
			$this->set('application', $application);
			$this->set('remain', $remain);
		}
	}

	public function other() {
		$connection=$this->openSQLconnection();
		$username = $this->Auth->user('username');
		//$ringino = $this->data['ringino'];
		//Get current ringiseq from ringihistories
		//$sql="SELECT * from attributes where ringino='$ringino'";
		$sql="SELECT department, title, name FROM users WHERE username = '$username'";
		$query = mysql_query("$sql");
		$array = mysql_fetch_assoc($query);
		$this->set('name', $array['name']);
		$this->set('department', $array['department']);
		$this->set('title', $array['title']);

		$sql = "SELECT count(1) count
			FROM attributes,ringiroutes 
			WHERE ringiroutes.ringino = attributes.ringino 
				and ringiroutes.approverid = '$username'
				and attributes.ringistatus not in ('001', '005')
				and ringiroutes.approverlayer >0";
		$query = mysql_query("$sql");
		$array = mysql_fetch_assoc($query);
		$this->set('appCount', $array['count']);

		$sql = "SELECT count(1) count
			FROM attributes,ringiroutes 
			WHERE ringiroutes.ringino = attributes.ringino 
				and ringiroutes.approverid = '$username'
				and attributes.ringistatus = '003'";
		$query = mysql_query("$sql");
		$array = mysql_fetch_assoc($query);
		$this->set('accCount', $array['count']);			

		$sql = "SELECT count(1) count
			FROM attributes, ringiroutes 
			WHERE ringiroutes.ringino = attributes.ringino 
				and ringiroutes.approverid = '$username'
				and attributes.ringistatus = '002'";
		$query = mysql_query("$sql");
		$array = mysql_fetch_assoc($query);
		$this->set('inProCount', $array['count']);

		$sql = "SELECT approverdept, approvertitle,approverid 
			From routes, users
			WHERE routes.department = users.department
				and routes.approveRouteType = '0'
				and routes.person is NULL
				and users.username = '$username'
			ORDER BY routes.approverlayer";
		$query = mysql_query("$sql");
		$approverCount = mysql_num_rows($query);
		$this->set('approverCount', $approverCount);
		if ($approverCount > 0){
			for ($i = 0; $i < $approverCount; $i ++){
				$array = mysql_fetch_assoc($query);
				$approverId[$i] = $array['approverid'];
				$approverDept[$i] = $array['approverdept'];
				$approverTitle[$i] = $array['approvertitle'];
			}
			$this->set('approverId', $approverId);
			$this->set('approverDept', $approverDept);
			$this->set('approverTitle', $approverTitle);
		}

		$sql="SELECT a.ringino, a.ringiname, a.project, a.purpose, a.applydate, a.applicantid, IFNull(a.asset,0)+IFNull(a.expense,0) application, IFNull(a.assetremain,0)+IFNull(expenseremain,0) remain, a.ringistatus
			FROM attributes a, ringiroutes b
			WHERE a.ringino =  b.ringino 
				  and b.approverid = '$username'
				  and b.approverlayer >0
				  and (a.ringino,b.approverlayer)
			NOT IN  (SELECT ringino,min(approverlayer) approverlayer 
                                FROM ringiroutes 
                                WHERE approvedate is NULL
					AND approverlayer >0
	    		        Group by ringino)";
		$query = mysql_query("$sql");
		$applicationCount = mysql_num_rows($query);
		$this->set('applicationCount', $applicationCount);
		if ($applicationCount > 0){
			for ($i = 0; $i < $applicationCount; $i ++){
			$array = mysql_fetch_assoc($query);
			$ringiNo[$i] = $array['ringino'];
			$ringiName[$i] = $array['ringiname'];
			$project[$i] = $array['project'];
			$purpose[$i] = $array['purpose'];
			$applyDate[$i] = $array['applydate'];
			$applicantId[$i] = $array['applicantid'];
			$application[$i] = $array['application'];
			$remain[$i] = $array['remain'];
			$ringiStatus[$i] = $array['ringistatus'];
			$ringiStatusName[$i] =$this->Convertor($array['ringistatus'],'RingiStatus');
			}
			$this->set('ringiNo', $ringiNo);
			$this->set('ringiName', $ringiName);
			$this->set('project', $project);
			$this->set('purpose', $purpose);
			$this->set('applyDate', $applyDate);
			$this->set('applicantId', $applicantId);
			$this->set('application', $application);
			$this->set('remain', $remain);
			$this->set('ringiStatus', $ringiStatus);
			$this->set('ringiStatusName', $ringiStatusName);
		}
	}
	
	public function report(){
		$connection=$this->openSQLconnection();
		$sql = "SELECT A.year, A.department, A.linecd, A.project, A.accountno, A.purpose, A.month,sum(A.budget) budget, Sum(A.application) application 
			FROM (SELECT year,department, linecd,project,accountno,purpose,month,budget,0 application,benefit
				FROM budgets
				UNION ALL SELECT Year(applydate) year,assetdept department, linecd,project,assetaccountno accountno,purpose,month(applydate) month,0,asset application,Null benefit
					  FROM attributes where ringistatus = '003' and asset is not null 
					  UNION SELECT Year(applydate) year,expensedept department, linecd,project,expenseaccountno accountno,purpose,month(applydate) month,0,expense application,Null benefit
					  FROM attributes where ringistatus = '003' and expense is not null ) A
			GROUP BY A.year, A.department, A.linecd, A.project, A.accountno, A.purpose, A.month";
		$count = -1;
		$query = mysql_query("$sql");
		if ($query != NULL){
			$count = mysql_num_rows($query)/12;
		}
		$this->set('count', $count);
		if ($count > 0){
			for ($entry = 0; $entry < $count; $entry++){
				for ($month = 0 ; $month < 12; $month++){
					$array = mysql_fetch_assoc($query);
					$budget[$entry][$month] = $array['budget'];
					$application[$entry][$month] = $array['application'];
				}
				$year[$entry] = $array['year'];
				$department[$entry] = $array['department'];
				$linecd[$entry] = $array['linecd'];
				$project[$entry] = $array['project'];
				$accountno[$entry] = $array['accountno'];
				$purpose[$entry] = $array['purpose'];
			}
			$this->set('year', $year);
			$this->set('department', $department);
			$this->set('linecd', $linecd);
			$this->set('project', $project);
			$this->set('accountno', $accountno);
			$this->set('purpose', $purpose);
			$this->set('budget', $budget);
			$this->set('application', $application);
		}
	}
	
	public function upload_layout() {}
	
	public function preview() {
		$this->openSQLconnection();
		$query = mysql_query("SELECT count(1) count from attributes where ringistatus in ('001','002','005')");
		$array = mysql_fetch_assoc($query);
		
		if ($array['count'] > 0) {
			$this->Session->setFlash(__('There are several applications being in progress. The update will affect the current application display. Is that OK? '));
		}

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

	
	private function tempXLStoPHP($excelfile) {
		
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
	
	private function XLmodify($XLfile) {

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

	public function support() {}

	public function credit() {}
	
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
		$username = $this->Auth->user('username');
		$approvalFlow = $this->_genApproverFlowHtmlWithId($username, $ringino);
		$doc = $doc. $approvalFlow;

		$this->set('doc',$doc);
	}

	public function application_details() {
			$this->set('resourceflag',$this->data['resourceflag']);
			$connection=$this->openSQLconnection();
			//$username = $this->Auth->user('username');
			$ringino = $this->data['ringiNo'];
			//$ringino = $this->data['ringino'];
			//Get current ringiseq from ringihistories
			//$sql="SELECT * from attributes where ringino='$ringino'";
			$sql="SELECT A.ringino, A.ringiname, A.project, B.approverid, B.ringistatus, B.approvedate
				from attributes A, ringiroutes B
				where A.ringino= B.ringino and A.ringino = $ringino";
			$query = mysql_query("$sql");
			$count = -1;
			if ($query != NULL) {
				$count = mysql_num_rows($query);
			}
			
			$this->set('count', $count);
			if ($count > 0 ){
				for ($i = 0; $i < $count; $i ++){
					$array = mysql_fetch_assoc($query);
					$approverId[$i] = $array['approverid'];
					$ringiStatus[$i] = $array['ringistatus'];
					$ringiStatusName[$i] = $this->Convertor($array['ringistatus'],'RingiAction');
					$approveDate[$i] = $array['approvedate'];
				}
				$this->set('ringiNo', $array['ringino']);
				$this->set('ringiName', $array['ringiname']);
				$this->set('project', $array['project']);
				$this->set('approverId', $approverId);
				$this->set('ringiStatus', $ringiStatus);
				$this->set('ringiStatusName', $ringiStatusName);
				$this->set('approveDate', $approveDate);
			}

			$sql2 = "SELECT A.ringiseq,B.department,B.title,A.processerid,A.processdate,A.ringiaction,A.comment
				from ringihistories A,users B
				where A.processerid = B.username and A.ringino = $ringino order by A.ringiseq";
			$query2 = mysql_query("$sql2");
			$count2 = -1;
			if ($query2 != NULL) {
				$count2 = mysql_num_rows($query2);
			}
			$count2 = mysql_num_rows($query2);
			$this->set('count2', $count2);
			if ($count2 > 0){
				for ($i = 0; $i < $count2; $i ++){
					$array2 = mysql_fetch_assoc($query2);
					$ringiSeq[$i] = $array2['ringiseq'];
					$department[$i] = $array2['department'];
					$title[$i] = $array2['title'];
					$processerId[$i] = $array2['processerid'];
					$processDate[$i] = $array2['processdate'];
					$ringiAction[$i] = $array2['ringiaction'];
					$ringiActionName[$i] = $this->Convertor($array2['ringiaction'],'RingiAction');
					$comment[$i] = $array2['comment'];
				}
				$this->set('ringiSeq', $ringiSeq);
				$this->set('department', $department);
				$this->set('title', $title);
				$this->set('processerId', $processerId);
				$this->set('processDate', $processDate);
				$this->set('ringiAction', $ringiAction);
				$this->set('ringiActionName', $ringiActionName);
				$this->set('comment', $comment);
			}

		}

    public function getApproverFlowList($username){
        //echo "**getApproverFlowList, username = ". $username. "***";
        // get dept for user
        $query = "select * from users";
        $queryRes = mysql_query($query); 
        $users = array();
        while($tmp = mysql_fetch_assoc($queryRes)){
            $users[$tmp['username']] = $tmp;
			}

        //echo "getApproverFlowList,users=";
        //print_r($users);
        //echo "**";

        // get dept for user
        $department = null;
        //echo "***username =". $username. "***";
        if( array_key_exists($username, $users) ){
            //echo "***setting department***";
            $department = $users[$username]['department'];
        }
        if($department==null){
            return null;
        }
        
        $user = $users[$username];
        // get approver flow
        $query = "select * from routes where department='". $department. "' order by approverlayer ASC";
        //echo "**query in getting_flow: ";
        //echo $query;
        //echo "-- end**";
        $queryRes = mysql_query($query);
        $approvers = array();
        $appLayer = 0;

        // set myself
        $myself = array(    'MYDEPT'=>$user['department'], 
                            'MYTITLE'=>$user['title'],
                            'MYNAME'=>$user['name'],
                            'MYID'=>$user['username'] );
        $approvers[$appLayer] = $myself;

        // set approvers
        $appLayer ++;
        while($tmp = mysql_fetch_assoc($queryRes)){
            $approverId = $tmp['approverid'];
            $approver = array(
                            ('APPROVERDEPT'. '_'. $appLayer) =>$tmp['approverdept'],
                            ('APPROVERTITLE'. '_'. $appLayer) =>$tmp['approvertitle'],
                            ('APPROVERID'. '_'. $appLayer) =>$approverId,
                            ('APPROVERNAME'. '_'. $appLayer) =>$users[$approverId]['name'] );
            //echo "***fetching approver:";
            //print_r($approver);
            //echo "end***";
            $approvers[$appLayer++] = $approver;
        }
        if(count($approvers)==0){
            return null;
		}
        //echo "***approver returning:";
        //print_r($approvers);
        //echo "approver returning end***";

        return $approvers;
    }

    private function _genApproverFlowHtmlWithId($username, $ringiId) {
        return $this->_genApproverFlowHTML($username, $ringiId);
    }

    private function _genNonEditableApproverFlowHTML($existingRoute){

        // FIXME
        //array_push( $existingRoute, array(  'approverid'=>'yono', 'title'=>'Engineer' ) );

        $source_html_begin = '
            <table class="table table-bordered table-hover">
                    <tr class="success">
                        <td width="20%">No</td>
                        <td>Layer</td>
                        <td>Department</td>
                        <td>Title</td>
                        <td>Approver ID</td>
                    </tr>
                <tbody>
                    ';
        // <tr> <td>1</td> <td>MYNAME</td>         <td>MYDEPT        </td> <td>MYTITLE        </td> <td>MYID</td> </tr>

        $source_html_end = '
                </tbody>
            </table>
        ';

        $row = 1;
        $approverLines = "";

        //echo '**** _nonEditable begin: existingRoute =';
        //print_r($existingRoute);
        //echo '_nonEditable end****';
	$title = "dummyTitle";
	$id = "dummyId";
	$approverLines = "";
        //print_r($existingRoute);
        foreach( $existingRoute as $approver ){
        	//print_r($approver);
        	$query = "select * from users where username = '". $approver['approverid']. "'";
        	//print_r($query);
        	$queryRes = mysql_query($query); 
        	while($tmp = mysql_fetch_assoc($queryRes)){
		    $department = $tmp['department'];
		    $title = $tmp['title'];
		    $id = $tmp['username'];
		}
		$approverLayer = "Approver ". $row;
            	$approverLines = $approverLines.  "<tr> <td>". $row++. "</td> <td>". $approverLayer. "</td> <td>". $department. "</td> <td>". $title. "</td> <td>". $id. "</td> </tr>\n";
		//print_r($approverLines);
        }

        $msg =  $source_html_begin. $approverLines. $source_html_end;

        //echo 'approverFlow query='. $msg. '\n';

        return $msg;
    }

    private function _getRouteTables($ringino){
        $this->openSQLconnection();
        $sql="SELECT * from ringiroutes where ringino = ". $ringino. " order by approverlayer ASC";
        $queryRes = mysql_query($sql) or die(mysql_error());
        
        $arrayToAdd=array();
        while($tmp = mysql_fetch_assoc($queryRes)){
            array_push($arrayToAdd, $tmp);
        }

        return $arrayToAdd;
    }

    // mode=apply or edit
    private function _genApproverFlowHtml($username, $ringiId=null) {

        // generate HTML for options
        $source_html = '
            <table class="table table-bordered table-hover">
                    <tr class="success">
                        <td width="20%">No</td>
                        <td>Layer</td>
                        <td>Department</td>
                        <td>Title</td>
                        <td>Approver ID</td>
                    </tr>
                <tbody>
                    <tr> <td>1</td> <td>Applicant</td>         <td>MYDEPT        </td> <td>MYTITLE        </td> <td>MYID</td> </tr>
                    <tr> <td>2</td> <td>Approver 1</td> <td>APPROVERDEPT_1</td> <td>APPROVERTITLE_1</td> <td>APPROVERID_1</td> </tr>
                    <tr> <td>3</td> <td>Approver 2</td> <td>APPROVERDEPT_2</td> <td>APPROVERTITLE_2</td> <td>APPROVERID_2</td> </tr>
                    <tr> <td>4</td> <td>Approver 3</td> <td>APPROVERDEPT_3</td> <td>APPROVERTITLE_3</td> <td>APPROVERID_3</td> </tr>
                    <tr> <td>5</td> <td>Approver 4</td> <td>APPROVERDEPT_4</td> <td>APPROVERTITLE_4</td> <td>APPROVERID_4</td> </tr>
                </tbody>
            </table>
        ';

        $dom = new DOMDocument;
        $dom->loadHTML($source_html);

        $selectAttr = array( 'class'=>'span2' );

        $applicantElems = array('MYNAME', 'MYDEPT', 'MYTITLE', 'MYID');
        $approverElems  = array('APPROVERNAME');

        $existingRoute = null;
        if( $ringiId ){
            $existingRoute = $this->_getRouteTables($ringiId);
        }

        if( count($existingRoute) == 0 ){
            //echo "HTML gen: array is used\n";
            // all users appears on pulldown
            $queries = Array( 'APPROVERDEPT'  =>"select distinct department as approverdept from users",
                              'APPROVERTITLE' =>"select distinct title as approvertitle from users",
                              'APPROVERID'    =>"select distinct username as approverid from users", 
                         );
        }else{
            //echo "HTML gen: fixed format is used\n";
            $message = $this->_genNonEditableApproverFlowHTML($existingRoute);
            //echo "*** _genApproverFlowHtml() returning ". $message. "\n";
            return $message;
        }
            
        // returns 
        //echo "calling getApproverFlowList";
        $approverFlow = $this->getApproverFlowList($username);
        //echo "***approverFlow=";
        //print_r($approverFlow);
        //echo "approverFlow end***";

        $options = array();
        foreach ($queries as $colname=>$query){
            //echo $query;
            $queryRes = mysql_query($query);
            $arrayToAdd = array();
            array_push($arrayToAdd, "");
            while($tmp = mysql_fetch_assoc($queryRes)){
                array_push($arrayToAdd, $tmp[strtolower($colname)]);
            }
            $options[strtoupper($colname)] = $arrayToAdd;
        }

        foreach ($dom->getElementsByTagName('td') as $elem){
            $layer = 0;
            foreach( $approverFlow as $layer=>$approver ){
                // Create Applicant's UI
                if( $layer== 0 ){
                    foreach( $applicantElems as $elemKey ){
                        $regEx = '/'. $elemKey. '/';
                        // echo $regEx;
                        if( preg_match($regEx, $elem->textContent, $matched ) ){
                            // create TD as container
                            $td = $dom->createElement('td');
                            $td->nodeValue = $approver[$elemKey];
                            // replace DOM's TD with the container
                            $elem->parentNode->replaceChild($td, $elem);
                        }
                    }
                } else {
                    foreach( $approverElems as $elemKeyBase ){
                        $elemKey = $elemKeyBase. '_'. $layer; 
                        //echo "***approverRepl";
                        //print_r($approver[$elemKey]);
                        //echo "approverRepl***";
                        $regEx = '/'. $elemKey. '/';
                        // echo $regEx;
                        if( preg_match($regEx, $elem->textContent, $matched ) ){
                            // create TD as container
                            $td = $dom->createElement('td');
                            $td->nodeValue = $approver[$elemKey];
                            // replace DOM's TD with the container
                            $elem->parentNode->replaceChild($td, $elem);
                        }
                    }
                } 
                // Create Approver's UI
                foreach( $options as $pdKeyBase=>$pdOptions ){
                    $pdKey = $pdKeyBase. '_'. $layer;
                    $regEx = '/'. $pdKey. '/';
                    // echo $regEx;
                    if( preg_match($regEx, $elem->textContent, $matched ) ){
                        // echo $matched, "\n";
                        // set select
                        $pulldown = $dom->createElement('select');
                        foreach( $selectAttr as $attr=>$val ){
                            $pulldown->setAttribute($attr, $val);
                        }
                        $pulldown->setAttribute('name', $pdKey);
                        $pulldown->setAttribute('id', $pdKey);

                        // set option & default value
                        $selected = 1;
                        $selectedValue = "";
                        for($j=0; $j<count($pdOptions); $j++){
                            $option = $dom->createElement('option');
                            $option->setAttribute('value',$pdOptions[$j]);
                            if ($pdOptions[$j] == $approver[$pdKey] ){
                                $selected = $j;
                                $selectedValue = $pdOptions[$j];
                                $option->setAttribute('selected', 'selected');
                            }
                            $option->nodeValue = $pdOptions[$j];
                            $pulldown->appendChild($option);
                        }
                        //echo "selected=". $selected. "\n";
                        //$pulldown->setAttribute('selected', $selectedValue);

                        // create TD as container
                        $td = $dom->createElement('td');
                        $td->appendChild($pulldown);

                        // replace DOM's TD with the container
                        $elem->parentNode->replaceChild($td, $elem);
                    }
                }
            }
        }
        $optionsHTML = $dom->saveHTML();

	// TODO
        // FIXME remove additional user lists
        //$dom = new DOMDocument;
        //$dom->loadHTML($optionsHTML);
        //foreach ($dom->getElementsByTagName('td') as $elem){
        //    // remove extra rows
        //    $pdKey = 'APPROVER'. '[a-ZA-Z]+'. '_'. $i;
        //    $regEx = '/'. $pdKey. '/';
        //    echo $regEx;
        //    if( preg_match($regEx, $elem->textContent, $matched ) ){
        //        $row = $elem->parentNode;
        //        $table = $row->parentNode;
        //        $table->removeChild($row);
        //    }
        //}
        //$optionsHTML = $dom->saveHTML();

        return $optionsHTML;
    }	

    public function apply() {
        //echo "calling apply()";
		$connection=$this->openSQLconnection();
        //echo "***Auth Begin:";
        //print_r($this->Auth);
        //echo "Auth END:***";

        // FIXME
		$username = $this->Auth->user('username');

        $optionsHTML = $this->_genApproverFlowHtml($username);
        // $optionsHTML = $dom->saveHTML();
/*
        $dom = new DOMDocument;
        $dom->loadHTML($optionsHTML);
        foreach ($dom->getElementsByTagName('td') as $elem){
            // remove extra rows
            $pdKey = 'APPROVER'. '[a-ZA-Z]+'. '_'. $i;
            $regEx = '/'. $pdKey. '/';
            echo $regEx;
            if( preg_match($regEx, $elem->textContent, $matched ) ){
                $row = $elem->parentNode;
                $table = $row->parentNode;
                $table->removeChild($row);
            }
        }
        $optionsHTML = $dom->saveHTML();
*/

	
        // OUTPUT	
		$path = $_SERVER['DOCUMENT_ROOT']."/Ringi/uploads/";
		
		//creating a doc string.
		$doc = file_get_contents($path."active.php");
			
		$formstart = '<form name="applyForm" method="post" action="apply_check" onsubmit="return main()" enctype="multipart/form-data">';
	
		$doc = $formstart . $doc .
		'
			<div>
				<div class="text-center">
					<label for="file">Choose your attachments</label><br>
					<input type="file" name="file[]" style="line-height: 0; padding: 0px" multiple="multiple"><br><br>
					<button class="btn btn-success">Apply</button>
				</div>
			</div>
			

			<div id="routing">
        '.
        $optionsHTML.
		'    </div>
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

    private function _create_applicant($ringino){
        $username = $this->Auth->user('username');

        $row = array();
        $row['ringino']         = $ringino;
        $row['approverlayer']   = 0;
        $row['approverid']      = $username;
        $row['ringistatus']     = "001";
        $row['approvedate']     = date("Y-m-d H:i:s");
        $row['created_at']     	= date("Y-m-d H:i:s");

	return $row;
    }
	
    private function _saveRingiRoutes($ringino) {
	$this->openSQLconnection();
	$rowsToSave = array();

	// create applicant at apply
	// update updated_at when reapply
	$conditions = array( 	'Ringiroute.ringino' => $ringino,
				'Ringiroute.approverlayer' => 0 );
	if ($this->Ringiroute->hasAny($conditions) ){
		$updateColumn = array(  'Ringiroute.approvedate' => "'". date("Y-m-d H:i:s"). "'",
					'Ringiroute.ringistatus' => "'012'" );
        	$this->Ringiroute->UpdateAll($updateColumn, $conditions);
	    	return;
	}
	$applicant = $this->_create_applicant($ringino);
        array_push($rowsToSave, $applicant);

	// save approver
		$wfparam = Configure::read('workflow');
		for( $i=1; $i<=$wfparam['MaxLayer']; $i++ ){
            $keyToVerify = 'APPROVERID_'. $i;
            if( array_key_exists($keyToVerify, $this->data) ){
                $row = array();
                $row['ringino']         = $ringino;
                $row['approverlayer']   = $i;
                $row['approverid']      = $this->data[$keyToVerify];
                $row['created_at']      = date("Y-m-d H:i:s");
                array_push($rowsToSave, $row);
            }
        }

        $this->Ringiroute->saveAll($rowsToSave);
    }	
	

	public function apply_check () {
		require_once("../Config/uploads.ctp");
		
		//Deleted by tei 0730
		//$ringino = $this->data['ringino'];
		$username = $this->Auth->user('username');
		
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
		
		
		//Add by tei 0730 start
		//Get current ringino from attributes 
		$query = mysql_query("SELECT IFNULL(max(ringino),0) maxringino from attributes");
		$array = mysql_fetch_assoc($query);
		$ringino=$array['maxringino']+1;
		
		//storing non-excel items
		
		//attributes
		$Attribute['Attribute']['ringino'] = $ringino;
		//Add by tei 0730 end
		$Attribute['Attribute']['applicantid'] = $username;
		$Attribute['Attribute']['applydate'] = date("Y-m-d H:i:s");
		$Attribute['Attribute']['ringistatus'] = '002';
		$Attribute['Attribute']['creator_id'] = $username;
		$Attribute['Attribute']['created_at'] = date("Y-m-d H:i:s");
		$Attribute['Attribute']['updator_id'] = NULL;
		$Attribute['Attribute']['updated_at'] = NULL;
		$Attribute['Attribute']['activeflag'] = 1;
		$Attribute['Attribute']['deleteReason'] = NULL;
		
		//ringihistories
		
		$Ringihistory['Ringihistory']['ringino'] = $ringino;
		$Ringihistory['Ringihistory']['ringiseq'] = 1;
		$Ringihistory['Ringihistory']['approverlayer'] = 0;
		$Ringihistory['Ringihistory']['processerid'] = $username;
		$Ringihistory['Ringihistory']['processdate'] = date("Y-m-d H:i:s");
		$Ringihistory['Ringihistory']['ringiaction'] = '001';
		$Ringihistory['Ringihistory']['comment'] = NULL;
		$Ringihistory['Ringihistory']['creator_id'] = $username;
		$Ringihistory['Ringihistory']['created_at'] = date("Y-m-d H:i:s");
		$Ringihistory['Ringihistory']['updator_id'] = NULL;
		$Ringihistory['Ringihistory']['updated_at'] = NULL;
		
		// FIXME
		// save ringi routes - multiple table updates has to be atomic
		$this->_saveRingiRoutes($ringino);
		$this->Attribute->save($Attribute);
		$this->Ringihistory->save($Ringihistory);
		
		//Upload file
		$ringino=$Attribute['Attribute']['ringino'];
		$this->exec_in_vendorpath('CreateFolder', $folderpath, $ringino);
		
		if ($_FILES['file']['name']) {
			$count=0;
			foreach ($_FILES['file']['name'] as $filename) 
			{
				move_uploaded_file( $_FILES['file']['tmp_name'][$count], $folderpath.$ringino."/".$_FILES['file']['name'][$count]);
				$count++;
			}
		}
		//echo "<a href=file://".$folderpath.$ringino.">Link to Uploads</a>";
		$this->redirect(array('action' => 'main_menu'));
		
	}

	
	public function edit() {

		$ringino = $this->data['ringi_number'];
		$username = $this->Auth->user('username');
		$this->set('ringino',$ringino);
		$this->set('status',$this->Auth->user('status'));
		
        $this->openSQLconnection();


        // FIXME
        echo $ringino;
        $query = "SELECT * FROM ATTRIBUTES WHERE ringino = $ringino";
        $sql = mysql_query($query);
        $array = mysql_fetch_assoc($sql);

        $path = $_SERVER['DOCUMENT_ROOT']."/Ringi/uploads/";

        $styles = Array(
         'class'=>'replacement',
         'style'=>'width: 100%; height: 100%; min-height:3em; box-sizing: border-box; resize: none; border:none; background-color:white;'
        );

        //creating a doc string.
        $doc = file_get_contents($path."active.php");
        $dom = new DOMDocument;
        $dom->loadHTML($doc);

        foreach ($dom->getElementsByTagName('td') as $text){
            if( preg_match('/input:.+:.+/',$text->textContent, $matches) ){
                //print_r($text);

                $inputMatched = preg_split('/[:]/',$matches[0]);
                $id = $colname = $inputMatched[1];

                $valFromDB = $array[$colname];
                $element = $dom->createElement('textarea', $valFromDB);
                foreach ( $styles as $key=>$value ){
                    $element->setAttribute( $key, $value );
                }
                $element->setAttribute( 'id', $id );
                $element->setAttribute( 'name', $colname );
                if ($colname == 'ringino'){
                    $element->setAttribute( 'readonly', true);
                }

                $replace = $text->cloneNode();
                $replace->appendChild($element);

                $text->parentNode->replaceChild($replace, $text);
            }
        }
		$approvalFlow = $this->_genApproverFlowHtmlWithId($username, $ringino);
		
        $formstart = '<form name="applyForm" method="post" action="" onsubmit="" enctype="multipart/form-data">';

        $doc =  $formstart .
                $dom->saveHTML().
        '
            <div class="well">
                <div class="text-center">
                    <label for="file">Choose your attachments</label><br>
                    <input type="file" name="file[]" style="line-height: 0; padding: 0px" multiple="multiple"><br><br>
					<button class="btn btn-success" onclick="reapply()">Reapply</button>
					<button class="btn btn-success" onclick="delet()">Delete</button>

                </div>
            </div>
			
			<div id="routing">
        '.
        $approvalFlow.
		'    </div>
        </form>';

        $this->set('doc',$doc);

		
	}

 // add by Tei 2012/07/28 start
	public function reapply () {
		require_once("../Config/uploads.ctp");
		
		$ringino = $this->data['ringino'];
		$username = $this->Auth->user('username');
		
		//$database = 'ringidata';
		//$someTable = 'attributes';

		// Connect to MySQL
		$connection = $this->openSQLconnection();
		
		if (mysql_query("SELECT id FROM attributes WHERE id=1")) {
			$selectcols = "SELECT * FROM attributes WHERE id=1";
		}
		else {
			$selectcols = "SELECT * FROM attributes";
		}
				
		$tempcols = mysql_query($selectcols) or die(mysql_error());

		$attrnumbers = mysql_num_fields($tempcols);		//this has the number of columns!!!		

		$columnNames = array();

		// FIXME - 8 is hardcoded!!!! 
		for ($i=8; $i < $attrnumbers; $i++) { 
			$test = mysql_field_name($tempcols,$i);	
			array_push($columnNames, $test);
		}

		// FIXME - 8 is hardcoded!!!! 
		// attributes excel items save 
		for ($i=8; $i < $attrnumbers; $i++) {
			$column = $columnNames[$i-8];
			if (isset($this->data[$column])) {
				$Attribute['Attribute'][$column] = $this->data[$column];
			}
		}
		
		//Get current ringiseq from ringihistories 
		$query = mysql_query("SELECT max(ringiseq) maxringino 
		                        from ringihistories 
		                       where ringino = $ringino 
		                    group by ringino");
		$array = mysql_fetch_assoc($query);
		$ringiseq=$array['maxringino'];
		
		//storing non-excel items
		//attributes
		$Attribute['Attribute']['applicantid'] = $username;
		$Attribute['Attribute']['applydate'] = date("Y-m-d H:i:s");
		$Attribute['Attribute']['ringistatus'] = '002';
		$Attribute['Attribute']['creator_id'] = $username;
		$Attribute['Attribute']['created_at'] = date("Y-m-d H:i:s");
		$Attribute['Attribute']['updator_id'] = NULL;
		$Attribute['Attribute']['updated_at'] = NULL;
		$Attribute['Attribute']['activeflag'] = 1;
		$Attribute['Attribute']['deleteReason'] = NULL;
		
		//ringihistories
		
		$Ringihistory['Ringihistory']['ringino'] = $ringino;
		$Ringihistory['Ringihistory']['ringiseq'] = $ringiseq+1;
		$Ringihistory['Ringihistory']['approverlayer'] = 0;
		$Ringihistory['Ringihistory']['processerid'] = $username;
		$Ringihistory['Ringihistory']['processdate'] = date("Y-m-d H:i:s");
		$Ringihistory['Ringihistory']['ringiaction'] = '012';
		$Ringihistory['Ringihistory']['comment'] = NULL;
		$Ringihistory['Ringihistory']['creator_id'] = $username;
		$Ringihistory['Ringihistory']['created_at'] = date("Y-m-d H:i:s");
		$Ringihistory['Ringihistory']['updator_id'] = NULL;
		$Ringihistory['Ringihistory']['updated_at'] = NULL;
		
		// FIXME would be change to update and keep the old record with the same ringno and deleteflg/activeflg = '0'
		// clear old attributes record
		$sql1="DELETE from attributes where ringino = $ringino";
		
		// Run SQL query

		if ($connection) {
			$query = mysql_query($sql1) or die(mysql_error());
			$this->Attribute->save($Attribute);
			
			$this->_saveRingiRoutes($ringino);
			$this->Ringihistory->save($Ringihistory);
			
		} else {
			echo "Application reapply is failure when update the data into database";
		}

		//Upload file
		$ringino=$Attribute['Attribute']['ringino'];
		$this->exec_in_vendorpath('CreateFolder', $folderpath, $ringino);
		
		if ($_FILES['file']['name']) {
			$count=0;
			foreach ($_FILES['file']['name'] as $filename) 
	        {
				move_uploaded_file( $_FILES['file']['tmp_name'][$count], $folderpath.$ringino."/".$_FILES['file']['name'][$count]);
				$count++;
	        }
		}
		
		//echo "<a href=file://".$folderpath.$ringino.">Link to Uploads</a>";
		$this->redirect(array('action' => 'main_menu'));
		
 }

	public function delete () {
		// the system will ignore the modificaiton in the application from users when they choose delete
		$connection=$this->openSQLconnection();
		$username = $this->Auth->user('username');
		$ringino = $this->data['ringino'];
		//Get current ringiseq from ringihistories 
		$query = mysql_query("SELECT max(ringiseq) maxringino 
			from ringihistories 
			where ringino = $ringino 
		group by ringino");
	$array = mysql_fetch_assoc($query);
	$ringiseq=$array['maxringino'];

	$sql1="UPDATE attributes
		Set  ringistatus = '005',
	updator_id = '".$username."',
	updated_at = now()
		where ringino = $ringino";

	$Ringihistory['Ringihistory']['ringino'] = $this->data['ringino'];
	$Ringihistory['Ringihistory']['ringiseq'] = $ringiseq+1;
	$Ringihistory['Ringihistory']['approverlayer'] = 0;
	$Ringihistory['Ringihistory']['processerid'] = $this->Auth->user('username');
	$Ringihistory['Ringihistory']['processdate'] = date("Y-m-d H:i:s");
	$Ringihistory['Ringihistory']['ringiaction'] = '005';
	$Ringihistory['Ringihistory']['creator_id'] = $this->Auth->user('username');
	$Ringihistory['Ringihistory']['created_at'] = date("Y-m-d H:i:s");

	if ($connection) {
		$query = mysql_query($sql1) or die(mysql_error());
		$this->Ringihistory->save($Ringihistory);

	} else {
		echo "Application delete is failure when update the data into database";
	}
	
	//echo "<a href=file://".$folderpath.$ringino.">Link to Uploads</a>";
	$this->redirect(array('controller' => 'Ringi', 'action' => 'main_menu'));

	}

// add by Tei 2013/07/28 End	
	
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
		$this->redirect(array('action' => 'task'));
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
		$this->redirect(array('action' => 'task'));
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
		$this->redirect(array('action' => 'task'));
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
		$this->redirect(array('action' => 'task'));
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
		$this->redirect(array('action' => 'task'));

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
		$this->redirect(array('action' => 'other'));
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

		$sql2="DELETE from ringiroutes where ringino = $ringino";

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
		$this->redirect(array('action' => 'main_menu'));
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
			$this->redirect(array('action' => 'other'));
	
	}

	
	public function download(){
		$this->viewClass = 'Media';
		        // Download app/outside_webroot_dir/example.zip
		        $params = array(
		            'id'        => 'example.zip',
		            'name'      => 'example',
		            'download'  => true,
		            'extension' => 'zip',
		            'path'      => APP . 'outside_webroot_dir' . DS
		        );
		$this->set($params);
	}
	
}
