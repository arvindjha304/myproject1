<?php

class TestController extends Zend_Controller_Action {

//
	public function init() {
		
		// Optional added for consistency
		//$this->_helper->layout->disableLayout();
	}

	public function indexAction() {
	
	
	
		$layout = Zend_Layout::getMvcInstance();
		$layout->setLayout('layout');
		
		
		
	}

	
}
