<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonMain for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Main\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class PesquisasController extends AbstractActionController
{
    public function indexAction()
    {

        $request = $this->getRequest();
        if ($request->isPost()) {
            $result = $request->getPost();
            $pesquisa = $result['pesquisa'];
        }

        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $query = $em->createQuery("SELECT Post FROM \Admin\Entity\Post Post WHERE (Post.titulo LIKE :pesquisa or Post.minText LIKE :pesquisa or Post.postComp LIKE :pesquisa or Post.dataPost LIKE :pesquisa) and Post.ativo like '1'");
        $query->setParameter('pesquisa', '%'.$pesquisa.'%');

        // Logica para verificar se obteve resultado
        $gresult = $query->getResult();
        if (isset($gresult[0]) == NULL){
            echo "<div class='alert alert-warning' align='center'><h1>Nenhum resultado encontrado para '".$pesquisa."'.</h1></div>";
            echo "<meta HTTP-EQUIV='refresh' CONTENT='3;URL=/'>";
    }

        $paginator = new Paginator(
            new DoctrinePaginator(new ORMPaginator($query))
        );

        $paginator
        ->setCurrentPageNumber($this->params()->fromRoute('page'))
        ->setItemCountPerPage(10);

        return new ViewModel(
            array(
                'pesquisas' => $paginator,
            )
        );
    
    }

}
