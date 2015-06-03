<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonMain for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class ExibirpostController extends AbstractActionController
{
    public function indexAction()
    {

        $id = $this->params()->fromRoute('id', 0);
        
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $query = $em->createQuery('SELECT Post FROM \Admin\Entity\Post Post WHERE Post.id = :id order by Post.id DESC');         
        $query->setParameters(array('id' => $id));

        $paginator = new Paginator(
            new DoctrinePaginator(new ORMPaginator($query))
        );

        $paginator
        ->setCurrentPageNumber($this->params()->fromRoute('page'))
        ->setItemCountPerPage(10);


        return new ViewModel(
            array(
                'posts' => $paginator,

            )
        );
    
    }

    public function comentarAction()
    {

    }

    public function deleteAction()
    {
    	
    }
}
