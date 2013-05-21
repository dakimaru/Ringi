<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
 
class BudgetDatasController extends AppController {
   public $scaffold; 
  /* public function index() {
        $this->modelClass = null;
        $this->layout = "Ringi";
        $this->set("header_for_layout","Application for Budget");
        $this->set("footer_for_layout","copyright by ENSPIREA. 2013.");

        $text1 = $this -> data["text1"];
        $this -> set("text1", Sanitize::stripAll($text1));

        $datas = $this->BudgetData->find('all');
        $this->set('datas',$datas);
        if ($this->request->is('post')) {
            $this->BudgetData->save($this->request->data);
        }
    }

    public function budget() {
        $this->modelClass = null;        
        $this->layout = "Ringi";
        $this->set("header_for_layout","Application for Budget");
        $this->set("footer_for_layout","copyright by ENSPIREA. 2013.");        
        $datas = $this->BudgetData->find('all');
        $this->set('datas',$datas);
    }

    public function add() {
        $this->modelClass = null;
        $this->layout = "Ringi";
        $this->set("header_for_layout","Edit for Budget");
        $this->set("footer_for_layout","copyright by ENSPIREA. 2013.");
        if ($this->request->is('post')) {
            $this->BudgetData->save($this->request->data);
        }
   }
   
    public function change($id) {
        $this->modelClass = null;
        $this->layout = "Ringi";
        $this->set("header_for_layout","Change for Budget");
        $this->set("footer_for_layout","copyright by ENSPIREA. 2013.");
        $this->BudgetData->id = $id;
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->BudgetData->save($this->request->data);
            $this->redirect(array('action' => 'index'));
        } else {
            $this->request->data = $this->BudgetData->read(null, $id);
        }
   }
   */
}
