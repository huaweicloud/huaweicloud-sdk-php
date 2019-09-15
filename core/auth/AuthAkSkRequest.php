<?php
namespace core\auth;
use core\common\BaseClient;

require_once dirname(__FILE__).'/AuthRequest.php';
require_once dirname(__FILE__) . '/Signer.php';
class AuthAkSkRequest extends AuthRequest {

    private $requestUrl;

    /**
     * @return string
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    /**
     *  拼接url地址
     */
    public function setRequestUrl()
    {
        $this->requestUrl = parent::getScheme().'://'.parent::getHost().self::getUri();
    }

    /**
     * @param BaseClient $client
     * @return Signer
     */
    public function sign(BaseClient $client){
        $sign = new Signer();
        $client = $client->getConfig();
        $sign->AppKey = strval($client['ak']);
        $sign->AppSecret = strval($client['sk']);
        $sign->Sign($this);
        //print_r($this);
        return $sign;
    }
}