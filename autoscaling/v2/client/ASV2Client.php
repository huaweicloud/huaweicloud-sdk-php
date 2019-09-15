<?php
namespace autoscaling\v2\client;
use core\common\BaseClient;
use core\common\HttpResponse;
use Exception;

use autoscaling\v2\service\ScalingPolicyService;

require_once dirname(__FILE__).'/../../../core/autoloader.php';

class ASV2Client extends BaseClient{


    /**
     * Factory method to create a new AS client using an array of configuration options.
     *
     * @param array $config Client configuration data
     *
     * @return ASV2Client
     */
    public static function factory(array $config = [])
    {
        return new ASV2Client($config);
    }

    function __construct(array $config = []){
        $this->config = $config;
        $this->validate();
    }

    /**
     * 创建弹性伸缩策略
     * @param array $req
     * @return HttpResponse
     * @throws Exception
     */
    public function createPolicy(array $req)
    {
        return ScalingPolicyService::getInstance()->createPolicy($req, $this);
    }

    /**
     * 修改弹性伸缩策略
     * @param array $req
     * @return HttpResponse
     * @throws Exception
     */
    public function updatePolicy(array $req)
    {
        return ScalingPolicyService::getInstance()->updatePolicy($req, $this);
    }

    /**
     * 查询弹性伸缩策略列表
     * @param array $req
     * @return HttpResponse
     * @throws Exception
     */
    public function getPolicyList(array $req=[])
    {
        return ScalingPolicyService::getInstance()->getPolicyList($req, $this);
    }

    private function validate()
    {
        if(empty($this->config))
        {
            throw new Exception('Please configure vodConfig');
        }

        if(empty($this->config['ak']))
        {
            throw new Exception( 'Please configure your ak');
        }

        if(empty($this->config['sk']))
        {
            throw new Exception('Please configure your sk');
        }

        if(empty($this->config['endpoint']))
        {
            throw new Exception("Please configure your endpoint");
        }

        if(empty($this->config['project_id']))
        {
            throw new Exception("Please configure your project_id");
        }
    }
}