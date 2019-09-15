<?php
namespace autoscaling\v1\client;
use core\common\BaseClient;
use core\common\HttpResponse;
use Exception;

use autoscaling\v1\service\ScalingGroupService;
use autoscaling\v1\service\ScalingConfiguration;
use autoscaling\v1\service\ScalingInstanceService;
use autoscaling\v1\service\ScalingPolicyService;
use autoscaling\v1\service\ScalingLogService;

require_once dirname(__FILE__).'/../../../core/autoloader.php';

class ASV1Client extends BaseClient{


    /**
     * Factory method to create a new AS client using an array of configuration options.
     *
     * @param array $config Client configuration data
     *
     * @return ASV1Client
     */
    public static function factory(array $config = [])
    {
        return new ASV1Client($config);
    }

    function __construct(array $config = []){
        $this->config = $config;
        $this->validate();
    }

    /**
     * 查询弹性伸缩组列表
     * @param array $req
     * @return HttpResponse
     */
    public function getGroupList(array $req=[])
    {
        return ScalingGroupService::getInstance()->getGroupList($req, $this);
    }

    /**
     * 创建弹性伸缩组
     * @param array $req
     * @return HttpResponse
     * @throws Exception
     */
    public function createGroup(array $req)
    {
        return ScalingGroupService::getInstance()->createGroup($req, $this);
    }

    /**
     * 修改弹性伸缩组
     * @param array $req
     * @return HttpResponse
     * @throws Exception
     */
    public function updateGroup(array $req)
    {
        return ScalingGroupService::getInstance()->updateGroup($req, $this);
    }

    /**
     * 删除弹性伸缩组
     * @param array $req
     * @return HttpResponse
     * @throws Exception
     */
    public function deleteGroup(array $req)
    {
        return ScalingGroupService::getInstance()->deleteGroup($req, $this);
    }

    /**
     * 启用或停止弹性伸缩组
     * @param array $req
     * @return HttpResponse
     * @throws Exception
     */
    public function actionGroup(array $req)
    {
        return ScalingGroupService::getInstance()->actionGroup($req, $this);
    }

    /**
     * 创建弹性伸缩配置
     * @param array $req
     * @return HttpResponse
     * @throws Exception
     */
    public function createConfiguration(array $req)
    {
        return ScalingConfiguration::getInstance()->createConfiguration($req, $this);
    }

    /**
     * 查询弹性伸缩配置列表
     * @param array $req
     * @return HttpResponse
     */
    public function getConfigurationList(array $req=[])
    {
        return ScalingConfiguration::getInstance()->getConfigurationList($req, $this);
    }

    /**
     * 删除弹性伸缩配置列表
     * @param array $req
     * @return HttpResponse
     * @throws Exception
     */
    public function deleteConfiguration(array $req)
    {
        return ScalingConfiguration::getInstance()->deleteConfiguration($req, $this);
    }

    /**
     * 查询弹性伸缩组中的实例列表
     * @param array $req
     * @return HttpResponse
     * @throws Exception
     */
    public function getInstanceList(array $req=[])
    {
        return ScalingInstanceService::getInstance()->getInstanceList($req, $this);
    }

    /**
     * 批量操作实例
     * @param array $req
     * @return HttpResponse
     * @throws Exception
     */
    public function actionInstance(array $req)
    {
        return ScalingInstanceService::getInstance()->actionInstance($req, $this);
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

    /**
     * 执行或启用或停止弹性伸缩策略
     * @param array $req
     * @return HttpResponse
     * @throws Exception
     */
    public function actionPolicy(array $req)
    {
        return ScalingPolicyService::getInstance()->actionPolicy($req, $this);
    }

    /**
     * 查询弹性伸缩策略列表
     * @param array $req
     * @return HttpResponse
     * @throws Exception
     */
    public function getLogList(array $req=[])
    {
        return ScalingLogService::getInstance()->getLogList($req, $this);
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