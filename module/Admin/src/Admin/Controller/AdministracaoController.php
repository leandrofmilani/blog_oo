<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Form\Usuario as UsuarioForm;
use \Admin\Entity\Usuario as Usuario;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

/**
 * Controlador que gerencia os usuÃ¡rios
 *
 * @category Admin
 * @package Controller
 * @author  Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 */
class AdministracaoController extends AbstractActionController
{

    /**
     * Exibe os usuÃ¡rios
     * @return void
     */
    public function indexAction()
    {
         
    }

    /**
     * Cria ou edita um usuÃ¡rio
     * @return void
     */
    public function saveAction()
    {
       
    }    

    /**
     * Exclui um usuÃ¡rio
     * @return void
     */
    public function deleteAction()
    {
        
    }

}
