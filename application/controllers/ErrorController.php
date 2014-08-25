<?php

class ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {   $this->_helper->layout()->disableLayout();
        $content = null;
        $errors = $this->_getParam('error_handler');
        
            switch ($errors->type) {
                case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
                case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
                // 404 error -- controller or action not found
                $this->getResponse()->setRawHeader('HTTP/1.1 404 Not Found');
                $content .= "<h1>404 Page not found!</h1>" . PHP_EOL;
                $content .= "<p>The page you requested was not found.</p>";
                $this->view->errorType = 404;
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->exception = $errors->exception;
                break;
                default:
                 
                     $this->getResponse()->setHttpResponseCode(500);

                
     // status code
               $content .= "<h1>Application error!</h1>" . PHP_EOL;
               $content .= "<p>An unexpected error occurred with your request. Please try again later.</p>";
     // Log the exception
                #
            $exception = $errors->exception;

                $log = new Zend_Log(
                    new Zend_Log_Writer_Stream(
                         FILE_PATH .'/temp/applicationException.log'
                    )
                );

                $log->debug($exception->getMessage() . "\n" .
                $exception->getTraceAsString());

                break;
      }

     

      // Clear previous content
        $this->getResponse()->clearBody();
        $this->view->content = $content;
    }
    public function rolecomp()
    {
      $namespace = new Zend_Session_Namespace('someaction');
      $rolecompuser_id = $namespace->data;
      $request = $this->getRequest();
      $id = $this->_request->getParam('id');
      $this->view->id = $id;//print_r($id);exit;
      $rolename=$rolecompuser_id['rolename'];
      $compid=$rolecompuser_id['compid'];
      $userid=$rolecompuser_id['userid'];
      $roleid=$rolecompuser_id['roleid'];
      return array('rolename'=>$rolename,'compid'=>$compid,'userid'=>$userid,'edituserid'=>$id,'roleid'=>$roleid);
    }


}

