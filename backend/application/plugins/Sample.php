<?php
/**
 * @name SamplePlugin
 * @desc Yaf定义了如下的6个Hook,插件之间的执行顺序是先进先Call
 * @see http://www.php.net/manual/en/class.yaf-plugin-abstract.php
 * @author menmei
 */
class SamplePlugin extends Yaf_Plugin_Abstract {

	public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
	    
	}

	public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
	    $route_safe = require APPLICATION_PATH . '/conf/route.php';
	    $method = $request->getMethod();
	    $action = $request->getActionName();
	    if ($route_safe[$action])
	    {
	        if ($route_safe[$action]['method'] != $method)
	        {
	            die(json_encode(['data'=>'非法的请求方法！', 'code' => Common::CODE_ERROR]));
	        }
	        if ('oauth' == $route_safe[$action]['login'])
	        {
	            $request->setParam ('auth', 'oauth');
	        }
	    }
	
	}

	public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
	}

	public function preDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
	}

	public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
	}

	public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
	}
}
