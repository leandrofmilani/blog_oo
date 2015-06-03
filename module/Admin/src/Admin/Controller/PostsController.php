<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use \Admin\Form\Post as PostForm;
use \Admin\Form\PostEditor as PostEditorForm;
use \Admin\Entity\Post as Post;
use \Admin\Entity\Comentario as Comentario;
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
class PostsController extends AbstractActionController
{

    /**
     * Exibe os posts
     * @return void
     */
    public function indexAction()
    {
      
        $session = $this->getServiceLocator()->get('Session');

        if (!$session->offsetGet('user')) {
            $this->flashMessenger()
            ->addErrorMessage('Voce precisa logar'); 

            return $this->redirect()->toUrl('/admin/login');                       
        }
        
        //var para fazer consulta no DB
        $id = $session->offsetGet('id');
        $em =  $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        if ($role = $session->offsetGet('role') == 'ADMIN'){
            $query = $em->createQuery('SELECT Post FROM \Admin\Entity\Post Post order by Post.id DESC');
        }else {        
            $query = $em->createQuery('SELECT Post FROM \Admin\Entity\Post Post WHERE Post.usuario = :id order by Post.id DESC');
            $query->setParameters(array('id' => $id));
        }
        

        $paginator = new Paginator(
            new DoctrinePaginator(new ORMPaginator($query))
        );


        $paginator
        ->setCurrentPageNumber($this->params()->fromRoute('page'))
        ->setItemCountPerPage(10);

        return new ViewModel(
            array(
                'posts' => $paginator
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

        /*
        Se chegar algo em $id entao é uma edição, ainda vai comprar se é editor,
        entao, se vier algo em $id e for editor teré um form para o editor editar sem post sem poder ativar/desativar
        se nao obedecer ao if ou nao chegou post, entao 1- é um novo post, onde o editor podera grava-lo como ativadou ou desativado
        ou 2- é somente o admin editado o post, onde o mesmo terá acesso a tudo inclusive ativar/desativar.
        */
        $id = $this->params()->fromRoute('id', 0);
        $session = $this->getServiceLocator()->get('Session');
        if ($role = $session->offsetGet('role') == 'EDITOR'){
            $form = new PostEditorForm($em);
        }
        if ($role = $session->offsetGet('role') == 'ADMIN'){
            $form = new PostForm($em);
        }
        $request = $this->getRequest();

        //minha alteracao
        $this->getServiceLocator()->get('Admin\Service\Auth');
                $session = $this->getServiceLocator()->get('Session');
                //var_dump($session->offsetGet('id'));
        //var_dump($session);
       // die();

        if ($request->isPost()) {
            $post = new Post();
            $values = $request->getPost();
            //$form->setInputFilter($post->getInputFilter());
            $form->setData($values);
            
            if ($form->isValid()) {             
                $values = $form->getData();


                if ( (int) $values['id'] > 0)
                $post = $em->find('\Admin\Entity\Post', $values['id']);

                $post->setTitulo($values['titulo']);
                $post->setMinText($values['minText']);
                $post->setPostComp($values['postComp']);
                $post->setAtivo($values['ativo']);
               // $user = $session->offsetGet('user');

                /*
                se for uma edição nao irá mudar o id do autor,
                se for um novo post irá setar o id do autor
                */
                if ( (int) $values['id'] > 0){
                     // se for edição nao mudará autor..
                }else{
                  $autor = $em->find('\Admin\Entity\Usuario', $session->offsetGet('user'));
                  $post->setUsuario($autor);
                }
              
                $post->setDataPost(new \DateTime('now'));
                $em->persist($post);

                try {
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage('Post armazenado com sucesso');
                } catch (\Exception $e) {
                    $this->flashMessenger()->addErrorMessage($e,'Erro ao armazenar post');
                }

                return $this->redirect()->toUrl('/admin/posts/index');
            }
            else{
                echo"<center><b>FORM INVALIDO</b></center>";
            }
        }

        $id = $this->params()->fromRoute('id', 0);

        if ((int) $id > 0) {
            $post = $em->find('\Admin\Entity\Post', $id);
            $form->bind($post);
        }

        return new ViewModel(
            array('form' => $form)
        );
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
            $post = $em->find('\Admin\Entity\Post', $id);

            $contComents=(count($post->getComentarios()));
            $comentarios=$post->getComentarios();

            //echo $contComents;

            $i=0;
            while($i<$contComents){
            $em->remove($comentarios[$i]);
            $i++;
            }

            $em->remove($post);

            try {
                $em->flush();
                $this->flashMessenger()->addSuccessMessage("Post e seus ".$contComents." comentarios excluidos com sucesso");
            } catch (\Exception $e) {
                $this->flashMessenger()->addErrorMessage('Erro ao excluir Post');
            }
        }

        return $this->redirect()->toUrl('/admin/posts/index');
    }

}
