<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * @ORM\Entity
 * @ORM\Table (name = "comentario")
 *
 * @author Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 * @category Admin
 * @package Entity
 */
class Comentario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    protected $id;

    protected $inputFilter;

    /**
     * @ORM\Column (type="string")
     *
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column (type="text")
     *
     * @var text
     */
    protected $comentario;

    /**
     * @ORM\ManyToOne(targetEntity="\Admin\Entity\Post")
     * @ORM\JoinColumn(name="id_post", referencedColumnName="id")
     * 
     * @var \Admin\Entity\Post
     */
    protected $post;

     /**
     * @ORM\Column (type="datetime")
     *
     * @var datetime
     */
    protected $dataComentario;

    /**
     *
     * @return void
     */
    public function __construct(){
        $this->usuario = new ArrayCollection();
    }
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return text
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param text $comentario
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    }


    /**
     * @param Usuario $post
     */
    public function setPost(\Admin\Entity\Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

     /**
     * @return datetime
     */
    public function getDataComentario()
    {
         $data = $this->dataComentario;
        return $data->format('Y-m-d H:i');
    }

    /**
     * @param datetime $dataComentario
     */
    public function setDataComentario($dataComentario)
    {
        $this->dataComentario = $dataComentario;
    }


    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     *
     * @return Zend/InputFilter/InputFilter
     */
    public function getInputFilter(){

        

       if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'id',
                'required' => false,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'email',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo E-mail não pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 255,
                            'message' => 'O campo E-mail deve ter mais que 3 caracteres e menos que 255',
                        ),
                    ),
                    array(
                        'name' => 'EmailAddress',
                        'options' => array('message' => 'NÃ£o parece ser um e-mail válido')
                    ),
                ),
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToLower',
                        'options' => array('encoding' => 'UTF-8')
                    ),
                ),
            )));

             $inputFilter->add($factory->createInput(array(
                'name' => 'comentario',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo Nome nÃ£o pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 3,
                            'max' => 255,
                            'message' => 'O campo nome deve ter mais que 3 caracteres e menos que 255',
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

         return $this->inputFilter;

        }


       

}

?>