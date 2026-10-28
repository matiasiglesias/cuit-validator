<?php

namespace CuitValidator;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\ValidatorProviderInterface;

/**
 * Class Module
 * @package CuitValidator
 * @author Matias Iglesias <matiasiglesias@matiasiglesias.com.ar>
 */
class Module implements
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
     * Expected to return \Laminas\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Laminas\ServiceManager\Config
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
