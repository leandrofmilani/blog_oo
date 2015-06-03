<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Controlador que para efetuar login
 *
 * @category Admin
 * @package Controller
 * @author  Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 */
class LoginController extends AbstractActionController
{

    /**
     * 
     * @return void
     */
    public function loginAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');      
        $request = $this->getRequest();

        if ($request->isPost()) {
            $values = $request->getPost();

            try {
                $this->getServiceLocator()->get('Admin\Service\Auth')->authenticate($values);
                $session = $this->getServiceLocator()->get('Session');
                
                if ($session->offsetGet('role') == 'ADMIN')
                    return $this->redirect()->toUrl('/admin/administracao');
                elseif ($session->offsetGet('role') == 'EDITOR')
                    return $this->redirect()->toUrl('/admin/posts/index');
                else
                    return $this->redirect()->toUrl('/');
            }catch(\Exception $e){
                $this->flashMessenger()->addErrorMessage($e->getMessage());
            }

           return $this->redirect()->toUrl('/admin/login');
        }

        return $this->request;
    }

    /**
     * 
     * @return void
     */
    public function logoutAction()
    {

        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');      
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $values = $request->getPost();  

            try {
                $this->getServiceLocator()->get('Admin\Service\Auth')->logout();               
            }catch(\Exception $e){
                $this->flashMessenger()->addErrorMessage($e->getMessage());
            }
        
           return $this->redirect()->toUrl('/');
           }

        return $this->request;
        
    }
}
