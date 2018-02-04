<?php
/**
 * Created by PhpStorm.
 * User: shanks
 * Date: 16/8/13
 * Time: 下午4:09
 */
namespace App\Http\Controllers;

use OAuth2;

class OAuthClient {
    static function get_outh_server() {
        $server  =  array (
            'host'      =>  '127.0.0.1',
            'port'      =>  6379
        ) ;
        $predis = new \Predis\Client($server);

        OAuth2\Autoloader::register();


        // $storage = new OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));
        $storage = new OAuth2\Storage\Redis($predis);

       // $storage->setClientDetails(OAUTH2_CLIENT_ID, OAUTH2_CLIENT_SECRET, OAUTH2_CLIENT_URL);

        $config = array(
            'allow_implicit' => true,
            'id_lifetime' => 30 * 86400,
            'access_lifetime' => 30 * 86400
        );

        $server = new OAuth2\Server($storage, $config);
        $grantTypeObject = new OAuth2\GrantType\UserCredentials($storage);
        $server->addGrantType($grantTypeObject);

        // 支持授权码模式
        $server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));
        $server->addGrantType($grantTypeObject);

        return $server;
    }
}
