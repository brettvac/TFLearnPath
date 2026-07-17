<?php
/*
* @package    TF Learn Path Module
* @license    GNU General Public License version 3
*/

//No direct access
\defined('_JEXEC') or die;

use Joomla\CMS\Extension\Service\Provider\Module as ModuleServiceProvider;
use Joomla\CMS\Extension\Service\Provider\ModuleDispatcherFactory as ModuleDispatcherFactoryServiceProvider;
use Joomla\CMS\Extension\Service\Provider\HelperFactory as HelperFactoryServiceProvider;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class () implements ServiceProviderInterface {
    public function register(Container $container): void
    {
        $container->registerServiceProvider(new ModuleDispatcherFactoryServiceProvider('\\Naftee\\Module\\Tflearnpath'));
        $container->registerServiceProvider(new HelperFactoryServiceProvider('\\Naftee\\Module\\Tflearnpath\\Site\\Helper'));
        $container->registerServiceProvider(new ModuleServiceProvider());
    }
};