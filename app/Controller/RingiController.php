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
    var $uses = array(
                        'Attribute',
                        'UserData',
						'PassBackData'
                     );

    public function beforeFilter() {
        parent::beforeFilter();
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
			//$attachmentname = $indiv_attachment['Attribute']['fname'];

			//array_push($auths[$i]['Attribute'],array('fname'=> $attachmentname));
						
			$authlevel = 0;
            $confirmlevel = 0;

            if($auth['Attribute']['auth1']==$username){
                $authlevel = 1;
            }
            if($auth['Attribute']['auth2']==$username){
                $authlevel = 2;
            }
            if($auth['Attribute']['auth3']==$username){
                $authlevel = 3;
            }
            if($auth['Attribute']['auth4']==$username){
                $authlevel = 4;
            }
            if($auth['Attribute']['auth5']==$username){
                $authlevel = 5;
            }
            if($auth['Attribute']['auth6']==$username){
                $authlevel = 6;
            }
            if($auth['Attribute']['auth7']==$username){
                $authlevel = 7;
            }
            array_push($list_apply, $authlevel);

            if($auth['Attribute']['date1'] == NULL && $auth['Attribute']['auth1']==$username){
                $confirmlevel = 1;
            }
            if($auth['Attribute']['date2'] == NULL && $userrole == 'mgr'){
                $confirmlevel = 2;
            }
            if($auth['Attribute']['date3'] == NULL && $userrole =='agm'){
                $confirmlevel = 3;
            }
            if($auth['Attribute']['date4'] == NULL && $userrole == 'gm'){
                $confirmlevel = 4;
            }
            if($auth['Attribute']['date5'] == NULL && $userrole =='hr'){
                $confirmlevel = 5;
            }
            if($auth['Attribute']['date6'] == NULL && $userrole=='pr'){
                $confirmlevel = 6;
            }
            if($auth['Attribute']['date7'] == NULL && $userrole=='admin' ){
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
		
    	$this->autoLayout = true;							//setting layout enabled
		
		//$ringino =$this->Attribute->getLastInsertID();
        //$this->set('ringino', $ringino);
        $this->set('username', $this->Auth->user('username'));

		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'ringidata';
		$someTable = 'attributes';
		
		// Connect to MySQL
		$link = mysql_connect($host, $username, $password);
		
		if (!$link) {
		    die('Could not connect: ' . mysql_error());
		}

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
			`created_at` timestamp,
			`updated_at` timestamp,
			`auth1` varchar(255),
			`auth2` varchar(255),
			`auth3` varchar(255),
			`auth4` varchar(255),
			`auth5` varchar(255),
			`auth6` varchar(255),
			`auth7` varchar(255),
			`date1` date,
			`date2` date,
			`date3` date,
			`date4` date,
			`date5` date,
			`date6` date,
			`date7` date,
			`attachmentname` varchar(255),
			`passbackflag` int,
			`rejectflag` int
			
		   ) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
		
		if (mysql_query($sql, $link)) {
			echo "<br>Table created successfully";
		} 
		else {
			echo '<br>Error creating table: ' . mysql_error();
		}

		//PHPExcel conversion from Excel to html, prepared for output
		$excelfile = "Ringi.xls";
		
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
			for ($j='A'; $j < $highestColumn; $j++) {
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
			$add_field = mysql_db_query($database,$order1);
		}
		
							
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
			
		$objWriter->setUseInlineCSS(true);
		
		$objWriter->save('/tmp/test.php');
		//creating a doc string.
		$doc = file_get_contents('/tmp/test.php');
				
		$formstart = '<form method="post" action="apply_check">';
		$formend = '</form>';
		
		$doc = "$formstart $doc" . '<div class="text-center"><button class="btn btn-success">Apply</button></div>' . "$formend";
		
		//if input:...is found
		while (preg_match('/input:.+:.+/', $doc, $matches) == 1) {	//strpos($doc, 'input:'.':') ==false
			
			//$doc = preg_replace('/input:(.+):.+/', '<textarea class="replacement" style="width: 100%; height: 100%; min-height:3em; box-sizing: border-box; resize: none; border:none;" id='. findcolname($doc) .' name='. findcolname($doc) .'></textarea>' , $doc);
			
			$temp = preg_split('/[:]/',$matches[0]);
			
			$doc = preg_replace('/input:(.+):.+/', '<textarea class="replacement" style="width: 100%; height: 100%; min-height:3em; box-sizing: border-box; resize: none; border:none;" id='. $temp[1] .' name='. $temp[1] .'></textarea>' , $doc, 1);
		}
		
			print_r("$doc");
			
			for ($i=0; $i <count($columnNames) ; $i++) { 
				print_r($columnNames[$i].'<br>');
			}
			
		
    }


   public function apply_check () {
        $this->modelClass = null;
        $this->set("header_for_layout","Application for RINGI");

		$host = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'ringidata';
		$someTable = 'attributes';

		// Connect to MySQL
		$link = mysql_connect($host, $username, $password);

		// Make Attributes the current database
		mysql_select_db($database, $link);
		$selectcols = "SELECT * FROM attributes";
		$tempcols = mysql_query($selectcols) or die(mysql_error());

		$attrnumbers = mysql_num_fields($tempcols);		//this has the number of columns!!!		

		$columnNames = array();

		for ($i=0; $i < $attrnumbers; $i++) { 
			$test = mysql_field_name($tempcols,$i);	
			array_push($columnNames, $test);
		}


		for ($i=20; $i < $attrnumbers; $i++) { 
			$column = $columnNames[$i];
			$Attribute['Attribute'][$column] = $this->data[$column];		
		}

		$Attribute['Attribute']['auth1'] = $this->Auth->user('username');
		$Attribute['Attribute']['date1'] = date("Y-m-d H:i:s"); 
		$Attribute['Attribute']['attachmentid'] = $this->Attribute->getLastInsertID();
		
		
		$this->Attribute->save($Attribute);

		//print_r($Attribute);

    }


    public function analise () {
        $this->autoLayout = false;
    }

    public function confirm () {

        $this->autoLayout = false;
        $idlist2=$this->data["idlist2"];
        $authedit = $this->Attribute->findById($idlist2);

        $attachmentid = $authedit['Attribute']['attachmentid'];
        $attachmentedit = $this->Attribute->findById($attachmentid);
 
        $applyid = $attachmentedit['Attribute']['applyid'];
        $applyedit = $this->Attribute->findById($applyid);

        $budgetid = $applyedit['Attribute']['budgetid'];
        $disposalid = $applyedit['Attribute']['disposalid'];
        $analysisid = $applyedit['Attribute']['analysisid'];
        $budgetedit = $this->Attribute->findById($budgetid);
        $disposaledit = $this->Attribute->findById($disposalid);
        $analysisedit = $this->Attribute->findById($analysisid);

        $this -> set("authedit", $authedit);
				$this -> set("idlist2", $idlist2);
        $this -> set("attachmentedit", $attachmentedit);
        $this -> set("applyedit", $applyedit);
        $this -> set("budgetid", $budgetid);
        $this -> set("budgetedit", $budgetedit);
        $this -> set("disposaledit", $disposaledit);
        $this -> set("analysisedit", $analysisedit);
    }

		public function pass_back_check () {
				$idlist2=$this->data["idlist2"];
      	$Attribute = $this->Attribute->findById($idlist2);
				$Attribute['Attribute']['passbackflag'] = TRUE;
				$this->Attribute->save($Attribute);
				
			  $username = $this->Auth->user('username');
				$userrole = $this->Auth->user('role');
				$authid=$this->data["idlist2"];
				$PassBackData['PassBackData']['username'] = $username;
				$PassBackData['PassBackData']['userrole'] = $userrole;
 				$PassBackData['PassBackData']['comments'] = $this->data["passback1"];
 				$PassBackData['PassBackData']['auth_id'] = $authid;
      	$this->PassBackData->save($PassBackData);
		}
		
		public function reject () {
				$idlist2=$this->data["idlist2"];
      	$Attribute = $this->Attribute->findById($idlist2);
				$Attribute['Attribute']['rejectflag'] = TRUE;
				$this->Attribute->save($Attribute);
				
		}

    public function confirm_check () {
				$idlist2=$this->data["idlist2"];
	    	$Attribute = $this->Attribute->findById($idlist2);
				$Attribute['Attribute']['passbackflag'] = FALSE;
				$this->Attribute->save($Attribute);
				
        $this->modelClass = null;
        $this->set("header_for_layout","Application for RINGI");
        $username = $this->Auth->user('username');
        $userrole = $this->Auth->user('role');
        $attachmentid=$this->data["attachmentid"];
        $this -> set("attachmentid", $attachmentid); 

        $authenticationedit = $this->Attribute->findById($attachmentid);
        $attachment =$authenticationedit['Attribute']['attachmentid']; 
        $attachmentedit=$this->Attribute->findById($attachment);
        $applyid = $attachmentedit['Attribute']['applyid'];
        $applyedit = $this->Attribute->findById($applyid);

        $budgetid = $applyedit['Attribute']['budgetid'];
        $disposalid = $applyedit['Attribute']['disposalid'];
        $analysisid = $applyedit['Attribute']['analysisid'];
        $budgetedit = $this->Attribute->findById($budgetid);
        $disposaledit = $this->Attribute->findById($disposalid);
        $analysisedit = $this->Attribute->findById($analysisid);

        //Set Up Analyisis Data
        $Attribute['Attribute']['id'] = $analysisid;
        if(array_key_exists('text20', $this->data)){$Attribute['Attribute']['comment'] = $this->data["text20"];}
        if(array_key_exists('text22', $this->data)){$Attribute['Attribute']['freview'] = $this->data["text22"];}
        if(array_key_exists('text23', $this->data)){$Attribute['Attribute']['fmanager'] = $this->data["text23"];}
        if(array_key_exists('text24', $this->data)){$Attribute['Attribute']['fdate'] = $this->data["text24"];}
        if(array_key_exists('text21', $this->data)){$Attribute['Attribute']['fdep'] = $this->data["text21"];}
        if(array_key_exists('text26', $this->data)){$Attribute['Attribute']['pcompare'] = $this->data["text26"];}
        if(array_key_exists('text27', $this->data)){$Attribute['Attribute']['pmanager'] = $this->data["text27"];}
        if(array_key_exists('text29', $this->data)){$Attribute['Attribute']['pdate'] = $this->data["text29"];}
        if(array_key_exists('text25', $this->data)){$Attribute['Attribute']['pdep'] = $this->data["text25"];}
        $this->Attribute->save($Attribute);

        //Set up Disposal Data
        $Attribute['Attribute']['id'] = $disposalid;
        if(array_key_exists('text40', $this->data)){$Attribute['Attribute']['current'] = $this->data["text40"];}
        if(array_key_exists('text41', $this->data)){$Attribute['Attribute']['after'] = $this->data["text41"];}
        $this->Attribute->save($Attribute);

        //Up date Apply Data
        $Attribute['Attribute']['id'] = $applyid; 
        if(array_key_exists('text34', $this->data)){$Attribute['Attribute']['assetcurrent'] = $this->data["text34"];}
        if(array_key_exists('text35', $this->data)){$Attribute['Attribute']['assetafter'] = $this->data["text35"];}
        if(array_key_exists('text36', $this->data)){$Attribute['Attribute']['expensecurrent'] = $this->data["text36"];}
        if(array_key_exists('text37', $this->data)){$Attribute['Attribute']['expenseafter'] = $this->data["text37"];}
        if(array_key_exists('text47', $this->data)){$Attribute['Attribute']['start'] = $this->data["text47"];}
        if(array_key_exists('text48', $this->data)){$Attribute['Attribute']['end'] = $this->data["text48"];}
        if(array_key_exists('text44', $this->data)){$Attribute['Attribute']['asset'] = $this->data["text44"];}
        if(array_key_exists('text45', $this->data)){$Attribute['Attribute']['expense'] = $this->data["text45"];}
        if(array_key_exists('text46', $this->data)){$Attribute['Attribute']['accountno'] = $this->data["text46"];}
        $this->Attribute->save($Attribute);

        //Set up Attachement Data
        $Attribute['Attribute']['id'] = $attachment;
        if(array_key_exists('text18', $this->data)){$Attribute['Attribute']['fname'] = $this->data["text18"];}
        if(array_key_exists('text19', $this->data)){$Attribute['Attribute']['fpurpose'] = $this->data["text19"];}
        if(array_key_exists('text51', $this->data)){$Attribute['Attribute']['name'] = $this->data["text51"];}
        if(array_key_exists('text53', $this->data)){$Attribute['Attribute']['dec'] = $this->data["text53"];}
        if(array_key_exists('text52', $this->data)){$Attribute['Attribute']['purpose'] = $this->data["text52"];}
        if(array_key_exists('text55', $this->data)){$Attribute['Attribute']['schedule'] = $this->data["text54"];}
        if(array_key_exists('text55', $this->data)){$Attribute['Attribute']['responsibility'] = $this->data["text55"];}
        if(array_key_exists('text50', $this->data)){$Attribute['Attribute']['dep'] = $this->data["text50"];}
        $this->Attribute->save($Attribute);

        //Set up Authentication Data
        $Attribute['Attribute']['id'] = $attachmentid;
        if(array_key_exists('text10', $this->data)){$Attribute['Attribute']['auth6'] = $this->data["text10"];}
        
        if($authenticationedit['Attribute']['date1'] == NULL && $auth['Attribute']['auth1']==$username){
            $Attribute['Attribute']['date1'] = date("Y-m-d H:i:s");
        }
        if($authenticationedit['Attribute']['date2'] == NULL && $userrole == 'mgr'){
            $Attribute['Attribute']['date2'] = date("Y-m-d H:i:s");
        }
        if($authenticationedit['Attribute']['date3'] == NULL && $userrole =='agm'){
            $Attribute['Attribute']['date3'] = date("Y-m-d H:i:s");
        }
        if($authenticationedit['Attribute']['date4'] == NULL && $userrole == 'gm'){
            $Attribute['Attribute']['date4'] = date("Y-m-d H:i:s");
        }
        if($authenticationedit['Attribute']['date5'] == NULL && $userrole =='hr'){
            $Attribute['Attribute']['date5'] = date("Y-m-d H:i:s");
        }
        if($authenticationedit['Attribute']['date6'] == NULL && $userrole=='pr'){
             $Attribute['Attribute']['date6'] = date("Y-m-d H:i:s"); 
        }
        if($authenticationedit['Attribute']['date7'] == NULL && $userrole=='admin' ){
             $Attribute['Attribute']['date7'] = date("Y-m-d H:i:s");
        }
        $this->Attribute->save($Attribute);
     }

}
