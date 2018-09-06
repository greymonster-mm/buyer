<?php
namespace Yaf\Controller;

use Yaf\Controller\M_EntityManager;

/**
 * @name IndexController
 * @author menmei
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class BaseController extends \Yaf_Controller_Abstract {

    protected $server;
    protected function init()
    {
        header('Content-Type:application/json');
        $parameters = file_get_contents('php://input');
        $this->postdata = json_decode(trim($parameters),true);
        $this->em = M_EntityManager::getInstance();
        $this->_init_auth();
    }

    protected function request($name, $default = "unuse")
    {
    	$value = $default;
    	if (isset($this->postdata[$name]))
    	{
    		$value = $this->postdata[$name];
    	}elseif (isset($_REQUEST[$name]))
    	{
    		$value = $_REQUEST[$name];
    	}
    	return $value;
    }
    private function _init_auth()
    {
        \OAuth2\Autoloader::register();
        $config = \Yaf_Registry::get('config');
        $database = $config->get('database');
        $storage = new \OAuth2\Storage\Pdo(array(
            'dsn' => 'mysql:host='.$database->get('product.host').';dbname=' . $database->get('product.dbname'),
            'username' => $database->get('product.user'),
            'password' => $database->get('product.password')));
        $this->server = new \OAuth2\Server($storage);
        $this->request = \OAuth2\Request::createFromGlobals();
        $this->response = new \OAuth2\Response();

        $auth = $this->getRequest()->getParam ('auth');
        if ($auth == 'oauth')
        {
            $this->_auth();
        }
    }

    private function _auth()
    {
        $sql = "select user_id from oauth_access_tokens where access_token = '".$this->request('access_token')."'";
        $ret = $this->em->getConnection()->query( $sql )->fetchAll();
        if ($ret)
        {
            $this->user = $ret[0]['user_id'];
            $_SESSION['user'] = $this->user;
        }

        if ($this->request->request['refresh_token'])
        {
            if (!$this->server->handleRevokeRequest($this->request, $this->response))
            {

                $this->response->send();
                die;
            }

        }

        if (!$this->server->verifyResourceRequest($this->request, $this->response))
        {
            $this->response->send();
			die;
        }
        if ($this->request->request['refresh_token'])
        {
            if (!$this->server->handleRevokeRequest($this->request, $this->response))
            {
                $this->response->send();
                die;
            }

        }






    }

    protected function jsonReturn($data, $code = \Common::CODE_OK)
    {
        $ret = [
            'data' => $data,
            'code' => $code
        ];
        echo json_encode($ret);
        return False;
    }

    protected function object2arr($object)
    {
        $item = [];
        $methods = get_class_methods($object);
        foreach ($methods as $method)
        {
            if ($pos = strpos($method, 'get') !== false)
            {
                $key = lcfirst(substr($method, 3));
                $item[$key] = $object->$method();
            }
        }
        return $item;
    }
}
