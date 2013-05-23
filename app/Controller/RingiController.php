<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class RingiController extends AppController {

    public function isAuthorized($user) {

    // Ower can edit and delete
        if (in_array($this->action, array('edit', 'delete'))) {
           //  $postId = $this->request->params['pass'][0];
        }
        return parent::isAuthorized($user);
    }   

    //Put All Model for this controller
    var $uses = array(
                        'AnalysisData',
                        'ApplyData',
                        'AttachmentData',
                        'AuthenticationData',
                        'BudgetData',
                        'DisposalData',
                        'UserData'
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
        //$this->layout = "Ringi";  //THIS CODE SETS LAYOUT FILE TO "Ringi"
        $username = $this->Auth->user('username');
        $userrole = $this->Auth->user('role');
        //
        $auths = $this->AuthenticationData->find('all');
        //
        
        $this->set('auths',$auths);
        $list_apply = array();
        $list_confirm = array();
        foreach($auths as $auth){
            $cflag = 0;
            $dflag = 0;
            if($auth['AuthenticationData']['auth1']==$username){
                $cflag = 1;
            }
            if($auth['AuthenticationData']['auth2']==$username){
                $cflag = 2;
            }
            if($auth['AuthenticationData']['auth3']==$username){
                $cflag = 3;
            }
            if($auth['AuthenticationData']['auth4']==$username){
                $cflag = 4;
            }
            if($auth['AuthenticationData']['auth5']==$username){
                $cflag = 5;
            }
            if($auth['AuthenticationData']['auth6']==$username){
                $cflag = 6;
            }
            if($auth['AuthenticationData']['auth7']==$username){
                $cflag = 7;
            }
            array_push($list_apply, $cflag);

            if($auth['AuthenticationData']['date1'] == NULL && $auth['AuthenticationData']['auth1']==$username){
                $dflag = 1;
            }
            if($auth['AuthenticationData']['date2'] == NULL && $userrole == 'mgr'){
                $dflag = 2;
            }
            if($auth['AuthenticationData']['date3'] == NULL && $userrole =='agm'){
                $dflag = 3;
            }
            if($auth['AuthenticationData']['date4'] == NULL && $userrole == 'gm'){
                $dflag = 4;
            }
            if($auth['AuthenticationData']['date5'] == NULL && $userrole =='hr'){
                $dflag = 5;
            }
            if($auth['AuthenticationData']['date6'] == NULL && $userrole=='pr'){
                $dflag = 6;
            }
            if($auth['AuthenticationData']['date7'] == NULL && $userrole=='admin' ){
                $dflag = 7;
            }
            array_push($list_confirm, $dflag);
        }
        $this->set('list_apply',$list_apply);
        $this->set('list_confirm',$list_confirm);
    }


    public function apply_check () {
        $this->modelClass = null;
        $this->set("header_for_layout","Application for RINGI");
				//Set Up Analyisis Data
        $AnalysisData['AnalysisData']['comment'] = $this->data["text20"];
        $AnalysisData['AnalysisData']['freview'] = $this->data["text22"];
        $AnalysisData['AnalysisData']['fmanager'] = $this->data["text23"];
        $AnalysisData['AnalysisData']['fdate'] = $this->data["text24"];
        $AnalysisData['AnalysisData']['fdep'] = $this->data["text21"];
        $AnalysisData['AnalysisData']['pcompare'] = $this->data["text26"];
        $AnalysisData['AnalysisData']['pmanager'] = $this->data["text27"];
        $AnalysisData['AnalysisData']['pdate'] = $this->data["text29"];
        $AnalysisData['AnalysisData']['pdep'] = $this->data["text25"];
        $this->AnalysisData->save($AnalysisData);

        //Set up Disposal Data
        $DisposalData['DisposalData']['current'] = $this->data["text40"];
        $DisposalData['DisposalData']['after'] = $this->data["text41"];
        $this->DisposalData->save($DisposalData);

        //Up date Apply Data
        $ApplyData['ApplyData']['budgetid'] = $this->data["budgetid2"];
        $ApplyData['ApplyData']['assetcurrent'] = $this->data["text34"];
        $ApplyData['ApplyData']['assetafter'] = $this->data["text35"];
        $ApplyData['ApplyData']['expensecurrent'] = $this->data["text36"];
        $ApplyData['ApplyData']['expenseafter'] = $this->data["text37"];
        $ApplyData['ApplyData']['start'] = $this->data["text47"];
        $ApplyData['ApplyData']['end'] = $this->data["text48"];
        $ApplyData['ApplyData']['disposalid'] = $this->DisposalData->getLastInsertID(); 
        $ApplyData['ApplyData']['analysisid'] = $this->AnalysisData->getLastInsertID();
        $ApplyData['ApplyData']['asset'] = $this->data["text44"];
        $ApplyData['ApplyData']['expense'] = $this->data["text45"];
        $ApplyData['ApplyData']['accountno'] = $this->data["text46"];
        $this->ApplyData->save($ApplyData);

        //Set up Attachement Data
        $AttachmentData['AttachmentData']['fname'] = $this->data["text18"];
        $AttachmentData['AttachmentData']['fpurpose'] = $this->data["text19"];
        $AttachmentData['AttachmentData']['name'] = $this->data["text51"];
        $AttachmentData['AttachmentData']['dec'] = $this->data["text53"];
        $AttachmentData['AttachmentData']['purpose'] = $this->data["text52"];
        $AttachmentData['AttachmentData']['schedule'] = $this->data["text54"];
        $AttachmentData['AttachmentData']['responsibility'] = $this->data["text55"];
        $AttachmentData['AttachmentData']['applyid'] = $this->ApplyData->getLastInsertID();
        $AttachmentData['AttachmentData']['date'] = date("Y-m-d H:i:s");
        $AttachmentData['AttachmentData']['dep'] = $this->data["text50"];
        $this->AttachmentData->save($AttachmentData);

        //Set up Authentication Data
        $AuthenticationData['AuthenticationData']['auth1'] = $this->Auth->user('username');
        $AuthenticationData['AuthenticationData']['auth6'] = $this->data["text10"];
        $AuthenticationData['AuthenticationData']['date1'] = date("Y-m-d H:i:s");  
        $AuthenticationData['AuthenticationData']['attachmentid'] = $this->AttachmentData->getLastInsertID();
        $this->AuthenticationData->save($AuthenticationData);
        
    }

    public function apply () {
        $this->autoLayout = false;
        $ringino =$this->AuthenticationData->getLastInsertID();
        $this->set('ringino', $ringino);
        $this->set('username', $this->Auth->user('username'));
        $budget_list = $this->BudgetData->find('list');
        $this->set('budget_list',$budget_list);

				
    }

    public function analise () {
        $this->autoLayout = false;
    }

    public function confirm () {
        $this->autoLayout = false;
        $idlist2=$this->data["idlist2"];
        $authedit = $this->AuthenticationData->findById($idlist2);

        $attachmentid = $authedit['AuthenticationData']['attachmentid'];
        $attachmentedit = $this->AttachmentData->findById($attachmentid);
 
        $applyid = $attachmentedit['AttachmentData']['applyid'];
        $applyedit = $this->ApplyData->findById($applyid);

        $budgetid = $applyedit['ApplyData']['budgetid'];
        $disposalid = $applyedit['ApplyData']['disposalid'];
        $analysisid = $applyedit['ApplyData']['analysisid'];
        $budgetedit = $this->BudgetData->findById($budgetid);
        $disposaledit = $this->DisposalData->findById($disposalid);
        $analysisedit = $this->AnalysisData->findById($analysisid);

        $this -> set("authedit", $authedit);
        $this -> set("attachmentedit", $attachmentedit);
        $this -> set("applyedit", $applyedit);
        $this -> set("budgetid", $budgetid);
        $this -> set("budgetedit", $budgetedit);
        $this -> set("disposaledit", $disposaledit);
        $this -> set("analysisedit", $analysisedit);
    }

    public function confirm_check () {
        $this->modelClass = null;
        $this->set("header_for_layout","Application for RINGI");
        $username = $this->Auth->user('username');
        $userrole = $this->Auth->user('role');
        $attachmentid=$this->data["attachmentid"];
        $this -> set("attachmentid", $attachmentid); 

        $authenticationedit = $this->AuthenticationData->findById($attachmentid);
        $attachment =$authenticationedit['AuthenticationData']['attachmentid']; 
        $attachmentedit=$this->AttachmentData->findById($attachment);
        $applyid = $attachmentedit['AttachmentData']['applyid'];
        $applyedit = $this->ApplyData->findById($applyid);

        $budgetid = $applyedit['ApplyData']['budgetid'];
        $disposalid = $applyedit['ApplyData']['disposalid'];
        $analysisid = $applyedit['ApplyData']['analysisid'];
        $budgetedit = $this->BudgetData->findById($budgetid);
        $disposaledit = $this->DisposalData->findById($disposalid);
        $analysisedit = $this->AnalysisData->findById($analysisid);

        //Set Up Analyisis Data
        $AnalysisData['AnalysisData']['id'] = $analysisid;
        if(array_key_exists('text20', $this->data)){$AnalysisData['AnalysisData']['comment'] = $this->data["text20"];}
        if(array_key_exists('text22', $this->data)){$AnalysisData['AnalysisData']['freview'] = $this->data["text22"];}
        if(array_key_exists('text23', $this->data)){$AnalysisData['AnalysisData']['fmanager'] = $this->data["text23"];}
        if(array_key_exists('text24', $this->data)){$AnalysisData['AnalysisData']['fdate'] = $this->data["text24"];}
        if(array_key_exists('text21', $this->data)){$AnalysisData['AnalysisData']['fdep'] = $this->data["text21"];}
        if(array_key_exists('text26', $this->data)){$AnalysisData['AnalysisData']['pcompare'] = $this->data["text26"];}
        if(array_key_exists('text27', $this->data)){$AnalysisData['AnalysisData']['pmanager'] = $this->data["text27"];}
        if(array_key_exists('text29', $this->data)){$AnalysisData['AnalysisData']['pdate'] = $this->data["text29"];}
        if(array_key_exists('text25', $this->data)){$AnalysisData['AnalysisData']['pdep'] = $this->data["text25"];}
        $this->AnalysisData->save($AnalysisData);

        //Set up Disposal Data
        $DisposalData['DisposalData']['id'] = $disposalid;
        if(array_key_exists('text40', $this->data)){$DisposalData['DisposalData']['current'] = $this->data["text40"];}
        if(array_key_exists('text41', $this->data)){$DisposalData['DisposalData']['after'] = $this->data["text41"];}
        $this->DisposalData->save($DisposalData);

        //Up date Apply Data
        $ApplyData['ApplyData']['id'] = $applyid; 
        if(array_key_exists('text34', $this->data)){$ApplyData['ApplyData']['assetcurrent'] = $this->data["text34"];}
        if(array_key_exists('text35', $this->data)){$ApplyData['ApplyData']['assetafter'] = $this->data["text35"];}
        if(array_key_exists('text36', $this->data)){$ApplyData['ApplyData']['expensecurrent'] = $this->data["text36"];}
        if(array_key_exists('text37', $this->data)){$ApplyData['ApplyData']['expenseafter'] = $this->data["text37"];}
        if(array_key_exists('text47', $this->data)){$ApplyData['ApplyData']['start'] = $this->data["text47"];}
        if(array_key_exists('text48', $this->data)){$ApplyData['ApplyData']['end'] = $this->data["text48"];}
        if(array_key_exists('text44', $this->data)){$ApplyData['ApplyData']['asset'] = $this->data["text44"];}
        if(array_key_exists('text45', $this->data)){$ApplyData['ApplyData']['expense'] = $this->data["text45"];}
        if(array_key_exists('text46', $this->data)){$ApplyData['ApplyData']['accountno'] = $this->data["text46"];}
        $this->ApplyData->save($ApplyData);

        //Set up Attachement Data
        $AttachmentData['AttachmentData']['id'] = $attachment;
        if(array_key_exists('text18', $this->data)){$AttachmentData['AttachmentData']['fname'] = $this->data["text18"];}
        if(array_key_exists('text19', $this->data)){$AttachmentData['AttachmentData']['fpurpose'] = $this->data["text19"];}
        if(array_key_exists('text51', $this->data)){$AttachmentData['AttachmentData']['name'] = $this->data["text51"];}
        if(array_key_exists('text53', $this->data)){$AttachmentData['AttachmentData']['dec'] = $this->data["text53"];}
        if(array_key_exists('text52', $this->data)){$AttachmentData['AttachmentData']['purpose'] = $this->data["text52"];}
        if(array_key_exists('text55', $this->data)){$AttachmentData['AttachmentData']['schedule'] = $this->data["text54"];}
        if(array_key_exists('text55', $this->data)){$AttachmentData['AttachmentData']['responsibility'] = $this->data["text55"];}
        if(array_key_exists('text50', $this->data)){$AttachmentData['AttachmentData']['dep'] = $this->data["text50"];}
        $this->AttachmentData->save($AttachmentData);

        //Set up Authentication Data
        $AuthenticationData['AuthenticationData']['id'] = $attachmentid;
        if(array_key_exists('text10', $this->data)){$AuthenticationData['AuthenticationData']['auth6'] = $this->data["text10"];}
        
        if($authenticationedit['AuthenticationData']['date1'] == NULL && $auth['AuthenticationData']['auth1']==$username){
            $AuthenticationData['AuthenticationData']['date1'] = date("Y-m-d H:i:s");
        }
        if($authenticationedit['AuthenticationData']['date2'] == NULL && $userrole == 'mgr'){
            $AuthenticationData['AuthenticationData']['date2'] = date("Y-m-d H:i:s");
        }
        if($authenticationedit['AuthenticationData']['date3'] == NULL && $userrole =='agm'){
            $AuthenticationData['AuthenticationData']['date3'] = date("Y-m-d H:i:s");
        }
        if($authenticationedit['AuthenticationData']['date4'] == NULL && $userrole == 'gm'){
            $AuthenticationData['AuthenticationData']['date4'] = date("Y-m-d H:i:s");
        }
        if($authenticationedit['AuthenticationData']['date5'] == NULL && $userrole =='hr'){
            $AuthenticationData['AuthenticationData']['date5'] = date("Y-m-d H:i:s");
        }
        if($authenticationedit['AuthenticationData']['date6'] == NULL && $userrole=='pr'){
             $AuthenticationData['AuthenticationData']['date6'] = date("Y-m-d H:i:s"); 
        }
        if($authenticationedit['AuthenticationData']['date7'] == NULL && $userrole=='admin' ){
             $AuthenticationData['AuthenticationData']['date7'] = date("Y-m-d H:i:s");
        }
        $this->AuthenticationData->save($AuthenticationData);
     }
}
