<?php

namespace Admin;

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

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Zend\Authentication\AuthenticationService' => function($serviceManager) {

                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                }
            )
        );
    }
    
    /**
    *
    *
    *
    * @param MvcEvent $e
    */

    public function onBootstrap($e)
    {
        /** @var \Zend\ModuleManager\ModuleManager $moduleManager */
        $moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
        /** @var \Zend\ModuleManager\SharedEventManager $sharedEvents */
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();

        //adiciona eventos ao modulo
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController', \Zend\Mvc\MvcEvent::EVENT_DISPATCH, array($this, 'mvcPredDispatch'),100);
    }

    /**
    * Verifica se precisa fazer a autorizacao do acesso
    * @param MvcEvent $event Evento
    * @return boolean
    */

    public function mvcPredDispatch($event)
    {
        $di = $event->getTarget()->getServiceLocator();
        $routeMatch = $event->getRouteMatch();
        $moduleName = $routeMatch->getParam('module');
        $controllerName = $routeMatch->getParam('controller');
        $actionName = $routeMatch->getParam('action');

       
        // COMENTADO PARA NAO PRECISAR DE AUTENTICAÇÃO
       // VOLTAR A HABILITAR ASSIM QUE PRECISO

        $authService = $di->get('Admin\Service\Auth');

       if (!$authService->authorize($moduleName, $controllerName, $actionName)) {
            // COMENTADO LINHA ABAIXO PARA NAO EXIBIR MENSAGEM DE ERRO
            //SEM A MENSAGEM ABAIXO QUANDO TENTA ACESSAR UM RECURSO SEM AUTORIZAÇÃO ELE JOGA NA TELA DE LOGIN E MANDA LOGAR
           // throw new \Exception("Voce nao tem permissao para acessar esse recurso!"); 
        }

         if (!$authService->authorize($moduleName, $controllerName, $actionName)) {
            // COMENTADO LINHA ABAIXO PARA NAO EXIBIR MENSAGEM DE ERRO
            //SEM A MENSAGEM ABAIXO QUANDO TENTA ACESSAR UM RECURSO SEM AUTORIZAÇÃO ELE JOGA NA TELA DE LOGIN E MANDA LOGAR
           // throw new \Exception("Voce nao tem permissao para acessar esse recurso!"); 
            echo "<center><b>VOCE NAO TEM PERMISSAO PARA ACESSAR ESSE RECURSO!</b></center>";
            
            die();
        }
        return true;
    }
}