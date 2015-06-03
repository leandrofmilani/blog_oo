<?php

// module/Admin/conï¬g/module.config.php:
return array(
    'controllers' => array( //add module controllers
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Interesses' => 'Admin\Controller\InteressesController',
            'Admin\Controller\Usuarios' => 'Admin\Controller\UsuariosController',
            'Admin\Controller\Comentarios' => 'Admin\Controller\ComentariosController',
            'Admin\Controller\Posts' => 'Admin\Controller\PostsController',
            'Admin\Controller\Administracao' => 'Admin\Controller\AdministracaoController',
            'Admin\Controller\Login' => 'Admin\Controller\LoginController',
            'Admin\Controller\Logout' => 'Admin\Controller\LogoutController',
            'Admin\Controller\Exibirpost' => 'Admin\Controller\ExibirpostController',
        ),
    ),
    //ConfiguraÃ§Ã£o doctrine
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Admin/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Admin\Entity' => 'application_entities'
                )
            ))),
    //*********************************************************

    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                        'module'        => 'admin'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                        'child_routes' => array( //permite mandar dados pela url 
                            'wildcard' => array(
                                'type' => 'Wildcard'
                            ),
                        ),
                    ),
                    
                ),
            ),
            'posts' => array(
                'type' => 'segment',             
                'options' => array(
                    'route' => '/admin/posts/index/[page/:page]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Posts',
                        'action'        => 'index',
                        'module'        => 'admin',
                        'page' => 1, //exibe por pagina
                    ),
                ),
            ),
            'novo' => array(
                'type' => 'segment',             
                'options' => array(
                    'route' => '/admin/comentarios/novo/[page/:page]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Comentarios',
                        'action'        => 'novo',
                        'module'        => 'admin',
                        'page' => 1, //exibe por pagina
                    ),
                ),
            ), 
            'comentarios' => array(
                'type' => 'segment',             
                'options' => array(
                    'route' => '/admin/comentarios/index/[page/:page]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Comentarios',
                        'action'        => 'index',
                        'module'        => 'admin',
                        'page' => 1, //exibe por pagina
                    ),
                ),
            ),
            'login' => array(
                'type' => 'segment',             
                'options' => array(
                    'route' => '/admin/login/index/[page/:page]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Login',
                        'action'        => 'index',
                        'module'        => 'admin',
                        'page' => 1, //exibe por pagina
                    ),
                ),
            ),
            'administracao' => array(
                'type' => 'segment',             
                'options' => array(
                    'route' => '/admin/administracao/index/[page/:page]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Administracao',
                        'action'        => 'index',
                        'module'        => 'admin',
                        'page' => 1, //exibe por pagina
                    ),
                ),
            ),
            'usuarios' => array(
                'type' => 'segment',             
                'options' => array(
                    'route' => '/admin/usuarios/index/[page/:page]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Usuarios',
                        'action'        => 'index',
                        'module'        => 'admin',
                        'page' => 1, //exibe por pagina
                    ),
                ),
            ),
            'comentarios_post' => array(
                'type' => 'segment',             
                'options' => array(
                    'route' => '/admin/exibirpost/index/id/[page/:page]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Exibirpost',
                        'action'        => 'index',
                        'module'        => 'admin',
                        'page' => 1, //exibe por pagina
                    ),
                ),
            ),
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'Session' => function ($sm) {
                return new Zend\Session\Container('SessionAdmin');
            },
        )
    ),
    

    'view_manager' => array( //the module can have a specific layout
        // 'template_map' => array(
        //     'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        // ),
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
    ),
   /* 'db' => array( //module can have a specific db configuration
        'driver' => 'PDO_SQLite',
        'dsn' => 'sqlite:' . __DIR__ .'/../data/admin.db',
        'driver_options' => array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    )*/
);
