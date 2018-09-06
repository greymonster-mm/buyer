<?php

use Yaf\Controller\BaseController;

class AuthController extends BaseController {

    protected $server;
    protected function init()
    {
        parent::init();
        $config = \Yaf_Registry::get('config');
        $database = $config->get('database');
        OAuth2\Autoloader::register();
        $storage = new \OAuth2\Storage\Pdo(array(
            'dsn' => 'mysql:host='.$database->get('product.host').';dbname=' . $database->get('product.dbname'),
            'username' => $database->get('product.user'),
            'password' => $database->get('product.password')));
        $this->server = new OAuth2\Server($storage);
        $this->request = OAuth2\Request::createFromGlobals();
        $this->response = new OAuth2\Response();
        //var_dump($this->request);die;
        
    } 

    public function TokenAction()
    {
        $username = $this->request('username', 'nousername');
        $password = $this->request('password', 'nopassword');
        
        /* $request = new OAuth2\Request([],array(
        		'client_id'     => 'blog', // valid client id
            'redirect_uri'  => 'http://fake/', // valid redirect URI
            'response_type' => 'code',
            'state'         => 'xyz'
        		//'username' => $username,
        		//'password' => $password,
        ),[],[],[],$_SERVER); 
        $token = $this->server->handleAuthorizeRequest($request, $this->response, true);
        return $this->jsonReturn($token);*/
       
        /* $request = new OAuth2\Request([],array(
        		'grant_type'    => 'authorization_code', // valid grant type
            'client_id'     => 'blog', // valid client id
            'client_secret' => 'taoistblessme', // valid client secret
            'code'          => '99296292c429ad91a3e20e42d55a68b9eeaedde4', // valid code
        	'redirect_uri'  => 'http://fake/',
        		//'username' => $username,
        		//'password' => $password,
        ),[],[],[],$_SERVER);
        $token = $this->server->grantAccessToken( $request, $this->response);
        return $this->jsonReturn($token);  */
        
        $request = new OAuth2\Request([],array(
            'grant_type' => 'password',
            'client_id' => 'blog',
            'client_secret' => 'taoistblessme',
            'username' => $username,
            'password' => $password,
            //'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            //'iss' => '123',
            //'sub' => 'sdf',
            //'aud' => 'aud',
            //'nbf' => '1300815780',
            //'scope' => ""
        ),[],[],[],$_SERVER);
        $token = $this->server->grantAccessToken( $request, $this->response);
        return $this->jsonReturn($token);
    }

}
