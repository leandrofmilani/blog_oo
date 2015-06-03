<?php

namespace Admin\Form;

use \Zend\Form\Form as Form;
use \Zend\Form\Element;

class Post extends Form
{

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        parent::__construct('post');
        $this->setAttribute('action', '');
        $this->setAttribute('method', 'post');

        $this->add(
            array(
                'name' => 'id',
                'type' => 'hidden',
            )
        );

        $this->add(array(
            'name' => 'titulo',
            'type' => 'text',
            'options' => array(
                'label' => 'Titulo:*'
            ),
            'attributes' => array(
                'placeholder' => 'Informe o titulo',
                'id' => 'titulo'
            )
        ));

         $this->add(array(
            'name' => 'minText',
            'type' => 'text',
            'options' => array(
                'label' => 'Mini Texto:*'
            ),
            'attributes' => array(
                'placeholder' => 'Informe o mini texto',
                'id' => 'minText'
            )
        ));

          $this->add(array(
            'name' => 'postComp',
            'type' => 'text',
            'options' => array(
                'label' => 'Post Completo:*'
            ),
            'attributes' => array(
                'placeholder' => 'Digite o post Completo',
                'id' => 'postComp'
            )
        ));
          
            $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'ativo',
                'options' => array(
                    'label' => 'Ativo:*',
                    'value_options' => array(
                    '1' => 'Ativo',
                    '0' => 'Inativo',
                    ),
                ),
            'attributes' => array(
                'value' => '1',
                ),
            ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Salvar'
            )
        ));

    }

}