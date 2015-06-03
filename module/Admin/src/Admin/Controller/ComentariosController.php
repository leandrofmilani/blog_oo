<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Form\Comentario as ComentarioForm;
use \Admin\Form\Comentarioadmin as ComentarioadminForm;
use \Admin\Entity\Comentario as Comentario;
use \Admin\Entity\Post as Post;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

/**
 * Controlador que gerencia os posts
 *
 * @category Admin
 * @package Controller
 * @author  Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 */
class ComentariosController extends AbstractActionController
{

    /**
     * Exibe os posts
     * @return void
     */
    public function indexAction()
    {
 

        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $query = $em->createQuery('SELECT Comentario FROM \Admin\Entity\Comentario Comentario order by Comentario.id DESC');
        

        $paginator = new Paginator(
            new DoctrinePaginator(new ORMPaginator($query))
        );


        $paginator
        ->setCurrentPageNumber($this->params()->fromRoute('page'))
        ->setItemCountPerPage(10);

        return new ViewModel(
            array(
                'comentarios' => $paginator
            )
        );
    }

    /**
     * Cria ou edita um post
     * @return void
     */
    public function saveAction()
    {
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
       
        $request = $this->getRequest();

          $values = $request->getPost();

          $id = $this->params()->fromRoute('id', 0);
          if ( $id > 0){
             $form = new ComentarioForm($em);
          }else{
             $form = new ComentarioadminForm($em);
          }

        //minha alteracao
        $this->getServiceLocator()->get('Admin\Service\Auth');
        $session = $this->getServiceLocator()->get('Session');
        if ($request->isPost()) {
            $comentario = new Comentario();
            $form->setInputFilter($comentario->getInputFilter());
            $form->setData($values);
            
            if ($form->isValid()) {             
                $values = $form->getData();


                if ( (int) $values['id'] > 0)
                $comentario = $em->find('\Admin\Entity\Comentario', $values['id']);
                $comentario->setEmail($values['email']);
                $comentario->setComentario($values['comentario']);
                $comentario->setDataComentario(new \DateTime('now'));
               // $user = $session->offsetGet('user');
                //SE CHEGAR ALGUMA COISA EM COMO 'id_post' ENTAO ARMAZENARA NA VARIAVEL $id_post, 
                //CASO NAO CHEGUE NADA $id_post sera valor 1


                $id_post = $request->getPost('id_post');
                if($id_post = $request->getPost('id_post') == null){
                ////////// NÓIA PARA PEGAR POST PELA ID_COMENTARIO //////////
                $idComent = $this->params()->fromRoute('id', 0);
                $em1 =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
                $comentario = $em1->find('\Admin\Entity\Comentario', $idComent);
                $postTeste = new Post();
                $postTeste = $em1->find('\Admin\Entity\Post', $comentario->getPost());
                $id_post=$postTeste->getId();
                ////////// NÓIA PARA PEGAR POST PELA ID_COMENTARIO //////////
                }else{
                   $id_post = $request->getPost('id_post');
                }

                
                
                $post = $em->find('\Admin\Entity\Post', (int)$id_post);
                $comentario->setPost($post);

                 


                $em->persist($comentario);

                try {
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage('Comentario armazenado com sucesso');
                } catch (\Exception $e) {
                    $this->flashMessenger()->addErrorMessage($e,'Erro ao armazenar Comentario');
                }

                return $this->redirect()->toUrl('/admin/comentarios/index');
            }
            else{
                echo"<center><b>FORM INVALIDO</b></center>";
            }
        }

        $id = $this->params()->fromRoute('id', 0);

        if ((int) $id > 0) {
            $post = $em->find('\Admin\Entity\Comentario', $id);
            $form->bind($post);
        }

        return new ViewModel(
            array('form' => $form)
        );
    }  



    public function novoAction()
    {   

         $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
       
        $request = $this->getRequest();
        if ($request->isPost()) {
             $comentario = new Comentario();
            $values = $request->getPost();
        }
   
       
        $comentario->setEmail($values['email']);
        $comentario->setComentario($values['comentario']);
        $comentario->setDataComentario(new \DateTime('now'));
        $id_post = $request->getPost('id_post');
        $post = new Post();
        $post = $em->find('\Admin\Entity\Post', (int)$id_post);
        $comentario->setPost($post);       
        $em->persist($comentario);
    

                try {
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage('Comentario armazenado com sucesso');
                } catch (\Exception $e) {
                    $this->flashMessenger()->addErrorMessage($e, 'Erro ao armazenar Comentario');
                }
                
                return $this->redirect()->toUrl('/admin/exibirpost/index/id/'.$id_post);
    }  

    /**
     * Exclui um post
     * @return void
     */
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        if ($id > 0) {
            $comentario = $em->find('\Admin\Entity\Comentario', $id);
            $em->remove($comentario);

            try {
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Comentario excluido com sucesso');
            } catch (\Exception $e) {
                $this->flashMessenger()->addErrorMessage('Erro ao excluir comentario');
            }
        }

        return $this->redirect()->toUrl('/admin/comentarios/index');
    }

}
