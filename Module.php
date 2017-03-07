<?php

namespace CuitValidator;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ValidatorProviderInterface;

/**
 * Class Module
 * @package CuitValidator
 * @author Matias Iglesias <matiasiglesias@matiasiglesias.com.ar>
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ValidatorProviderInterface

{
    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array|\Zend\ServiceManager\Config
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getValidatorConfig()
    {
        return [
            'invokables' => [
                'Cuit' => 'CuitValidator\Validator\Cuit',
            ],
        ];
    }
}
