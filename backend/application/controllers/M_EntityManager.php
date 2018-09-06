<?php
namespace Yaf\Controller;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class M_EntityManager
{
    static protected  $em;
    static public function getInstance()
    {
        if (!self::$em) {
            $config = \Yaf_Registry::get('config');
            $database = $config->get('database');

            if (ini_get('yaf.environ') == 'product')
            {
                $isDevMode = false;
                $conn = array(
                    'driver' => $database->get('product.driver'),
                    'host'   => $database->get('product.host'),
                    'user'   => $database->get('product.user'),
                    'password' => $database->get('product.password'),
                    'dbname'   => $database->get('product.dbname'),
                    'charset'  => $database->get('product.charset')
                );
            }else
            {
                $isDevMode = false;
                $conn = array(
                    'driver' => $database->get('develop.driver'),
                    'host'   => $database->get('develop.host'),
                    'user'   => $database->get('develop.user'),
                    'password' => $database->get('develop.password'),
                    'dbname'   => $database->get('develop.dbname'),
                    'charset'  => $database->get('develop.charset')
                );
            }
            $config = Setup::createAnnotationMetadataConfiguration(array('/home/menmei/buyer/conf/src'), $isDevMode, null, null, false);

            if ($isDevMode)
            {
                //@todo 缓存 等设置
            	$cache = new \Doctrine\Common\Cache\ArrayCache;
            	$logger = new \Doctrine\DBAL\Logging\EchoSQLLogger();
            	$config->setSQLLogger($logger);
            }else
            {

            }

            // obtaining the entity manager
            self::$em = EntityManager::create($conn, $config);
        }
        return self::$em;
    }
}

?>