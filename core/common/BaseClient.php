<?php
namespace core\common;
use Exception;

require_once dirname(__FILE__) . '/../../core/autoloader.php';
class BaseClient
{
    public $config;

    function __construct(array $config = []){
        $this->config = $config;
        $this->validate();
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
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
    }
}