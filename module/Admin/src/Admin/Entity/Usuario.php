<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * @ORM\Entity
 * @ORM\Table (name = "usuario")
 *
 * @author Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 * @category Admin
 * @package Entity
 */
class Usuario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    protected $id;

    /**
    * @ORM\Column (type="string")
    *
    * @var string
    */
    protected $role;


    ///**
    //* @ORM\Column (type="string")
    //*
    //* @var string
    //*/
    //protected $role;


    protected $inputFilter;

    /**
     * @ORM\Column (type="string")
     *
     * @var string
     */
    protected $nome;

    /**
     * @ORM\Column (type="string")
     *
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column (type="string")
     *
     * @var string
     */
    protected $senha;

    /**
     * @ORM\Column (type="datetime")
     *
     * @var datetime
     */
    protected $dataNasc;


    /**
    *@ORM\OneToMany(targetEntity="Post", mappedBy="usuario")
    *
    */
    protected $posts;

    public function __construct()
    {
    $this->posts = new ArrayCollection();
    }

    public function getPosts()
    {
    return $this->posts;
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
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
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
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param string $senha
     */
    public function setSenha($senha)
    {
        $this->senha = md5($senha);
    }

    /**
     * @return datetime
     */
    public function getDataNasc()
    {
        $data = $this->dataNasc;
        return $data->format('Y-m-d');
    }

    /**
     * @param datetime $dataNasc
     */
    public function setDataNasc($dataNasc)
    {
        $this->dataNasc = $dataNasc;
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
                'name' => 'nome',
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
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToUpper',
                        'options' => array('encoding' => 'UTF-8')
                    ),
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
                'name' => 'dataNasc',
                'required' => true,
                'validators' => array (
                            array (
                                'name' => 'date',
                                'options' => array (
                                        'format' => "Y-m-d",
                                        'messages' => array(
                                            \Zend\Validator\Date::INVALID => 'Inválido.',
                                            \Zend\Validator\Date::INVALID_DATE => 'Data inválida.',
                                            \Zend\Validator\Date::FALSEFORMAT => 'Formato inválido.',
                                        ), 
                                        ) 
                                ) 
                            ) 
                )));

            /*$inputFilter->add($factory->createInput(array(
                'name' => 'celular',
                    array(
                        'name' => 'Int',
                        'options' => array(
                            'min' => 8,
                            'max' => 11,
                            'message' => 'O campo celular deve ter maximo 11 digitos',
                        )
                    )
                )
            ));*/
            
            /*$inputFilter->add($factory->createInput(array( 
                'name' => 'celular', 
                'required' => true, 
                'filters'  => array( 
                    array('name' => 'Int'), 
                ), 
                'validators' => array( 
                    array( 
                        'name' => 'Between', 
                        'options' => array( 
                            'min' => 8, 
                            'max' => 10, 
                        ), 
                    ), 
                ), 
            )));*/

            $inputFilter->add($factory->createInput(array(
                'name' => 'senha',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array('message' => 'O campo Senha nÃ£o pode estar vazio')
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 8,
                            'max' => 20,
                            'message' => 'O campo senha deve ter mais que 8 caracteres e menos que 20',
                        ),
                    ),
                ),
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}

?>