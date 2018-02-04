<?php
/**
 * Created by PhpStorm.
 * User: shanks
 * Date: 16/8/13
 * Time: 下午5:08
 */

namespace App\Http\Controllers;

require_once __DIR__ .'/../../ToolUtil/OAuthClient.php';


class OauthController
{
    public function token() {
        $outhServer = OAuthClient::get_outh_server();

        $response = $outhServer->handleTokenRequest(\OAuth2\Request::createFromGlobals());
        var_dump($response); exit();
        $ret = array();
        $params = $response->getParameters();
        if($response->isSuccessful()) {
            $ret = BaseError::return_success_with_data($params);
        }
        else
        {
            $ret = BaseError::return_error($params["error"], $params["error_description"]);
        }

        return $this->json_parse($ret);
    }

}