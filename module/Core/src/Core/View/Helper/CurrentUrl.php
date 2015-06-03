<?php

namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class CurrentUrl
 * @package Core\View\Helper
 * @author Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 */
class CurrentUrl extends AbstractHelper
{

    /**
     * @var \Zend\Mvc\Router\Http\RouteMatch
     */
    protected $routeMatch;

    /**
     * @param \Zend\Mvc\Router\Http\RouteMatch $routeMatch
     */
    public function __construct($routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }

    /**
     * @return null|string
     */
    public function __invoke()
    {
        if ($this->routeMatch) {
            $url = null;
            $module = $this->routeMatch->getParam('module');
            $controller = explode('\\',$this->routeMatch->getParam('controller'));

            if (isset($controller[2])) {
                $controller = preg_replace('/(?<!^)([A-Z])/', '-\\1', $controller[2]);
                $controller = strtolower($controller);
                $action = $this->routeMatch->getParam('action');
                $url = BASE_URL."/$module/$controller/$action";
            }

            return $url;
        }

    }
}