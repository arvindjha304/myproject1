<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
        protected function _intitDb()
	{
		$section = getenv('PLACES_CONFIG') ? getenv('PLACES_CONFIG') : 'live';
		$config = new Zend_Config_Ini('./application/config.ini', $section);
		Zend_Registry::set('config', $config);

		// set up database
		$db = Zend_Db::factory($config->db->adapter, $config->db->config->asArray());
		Zend_Db_Table::setDefaultAdapter($db);
		Zend::register('DB', $db);
	}
	
	
	
        protected function _initAutoload()
	{
	ini_set('memory_limit','128M');
	// Add autoloader empty namespace
	$autoLoader = Zend_Loader_Autoloader::getInstance();
	$resourceLoader = new Zend_Loader_Autoloader_Resource(array(
		'basePath'      => APPLICATION_PATH,
		'namespace'     => '',
		'resourceTypes' => array(
		'form' => array(
			'path'      => 'forms',
			'namespace' => 'Form_',
		),
		'model' => array(
			'path'      => 'models/',
			'namespace' => 'Model_'
		),
		),
	));
	// Return it so that it can be stored by the bootstrap
	$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();

$frontend= array('lifetime' => 7200,
                 'automatic_serialization' => true);


    $backend= array(
    'cache_dir' => './public/cachedata/',
    );

    $cache = Zend_Cache::factory('core',
    'File',
    $frontend,
    $backend
    );
	Zend_Registry::set('cache',$cache);
//$title = Zend_Registry::get('cache'); // this works fine
	return $autoLoader;
	} 
        protected function _initRoutes()
	{
		$frontController=Zend_Controller_Front::getInstance();
                $frontController->throwExceptions(false);

                
		$router=$frontController->getRouter();
                $writer = new Zend_Log_Writer_Firebug();
                $logger = new Zend_Log($writer);
                $logger->log('This is a log message!', Zend_Log::INFO);
//                $frontController->setControllerDirectory(array(
//    'default' => APPLICATION_PATH. '/controllers',));
      
             //   $frontController->dispatch();

            

                       $route = new Zend_Controller_Router_Route('module/:controller/:action/*',
               array('module' => 'default',

                ));
                $router->addRoute('admin', $route);
                $router->addRoute('register', $route);
                $frontController->setRouter ( $router );
        }
        protected function _initConstant()
    {
	$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
	define('BASEURL' ,$baseUrl);
   
	defined('APPLICATION_PATH')
	or define('APPLICATION_PATH', $baseUrl.'/application/');

      

    // defined('SITE_PRODUCT_IMAGE_URL')
	// or define('SITE_PRODUCT_IMAGE_URL',$baseUrl.'/public/upload');

	// $path_public = str_replace("application","public",APPLICATION_PATH);
	
	// defined('FILE_PATH')
	// or define('FILE_PATH',$path_public);
    }
    protected function _initView()
	{
	// Initialize view
        //require_once 'Zend/Controller/Action/Helper/ViewRenderer.php';
	Zend_Layout::startMvc();
	$view = new Zend_View();
	//$view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $viewRenderer->setView($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
	$view->doctype('XHTML1_STRICT');


      return $view;
	}
	/*This Healper class added by Govind*/
	protected function _initControllerHelpers()
	{
		Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH . '/controllers/Helper', 'Tourchhelper');	
	}
//	protected function _initFoo ()
//{
//
//    $this->bootstrap('FrontController');
//    $front = $this->getResource('FrontController');
//
//    $response = new Zend_Controller_Response_Http;
//    $response->setHeader('Content-Type', 'image/jpeg');
//
//    $front->setResponse($response);
//
//}
}

