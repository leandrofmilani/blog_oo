<?php

namespace Core;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\ModuleRouteListener as ModuleRouteListener;

class Module
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap($e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $e->getApplication()->getServiceManager()->get('viewhelpermanager')->setFactory('currentUrl', function($sm) use ($e) {
            $viewHelper = new \Core\View\Helper\CurrentUrl($e->getRouteMatch());
            return $viewHelper;
        });

        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'DbAdapter' => 'Core\Db\AdapterServiceFactory'
            )
        );
    }
}