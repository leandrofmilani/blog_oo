<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'acl' => array(
        'roles' => array(
            'VISITANTE' => null,
            'EDITOR' => 'VISITANTE',
            'ADMIN' => 'EDITOR',
        ),
        'resources' => array(
            'Main\Index.index',
            'Main\Controller\Index.index',
            'Main\Controller\Pesquisas.index',
            'Admin\Controller\Comentarios.index',
            'Admin\Controller\Comentarios.save',
            'Admin\Controller\Comentarios.delete',
            'Admin\Controller\Comentarios.novo',
            'Admin\Controller\Login.index',
            'Admin\Controller\Login.login',
            'Admin\Controller\Login.logout',
            'Admin\Controller\Logout.index',
            'Admin\Controller\Usuarios.index',
            'Admin\Controller\Usuarios.save',
            'Admin\Controller\Usuarios.delete',
            'Admin\Controller\Posts.index',
            'Admin\Controller\Posts.save',
            'Admin\Controller\Posts.delete',
            'Admin\Controller\Administracao.index',
            'Admin\Controller\Exibirpost.index',
            'Admin\Controller\Exibirpost.exibir',
            'Admin\Controller\Exibirpost.id',


        ),
        'privilege' => array(
            'VISITANTE' => array(
                'allow' => array(
                    'Admin\Controller\Login.login',
                    'Admin\Controller\Comentarios.index',
                    'Admin\Controller\Comentarios.save',
                    'Admin\Controller\Comentarios.novo',
                    'Admin\Controller\Login.index',
                    'Main\Controller\Index.index',
                    'Main\Controller\Pesquisas.index',
                    'Main\Index.index',
                    'Admin\Controller\Exibirpost.index',
                    'Admin\Controller\Exibirpost.exibir',
                    'Admin\Controller\Exibirpost.id',
                )
            ),
            'EDITOR' => array(
                'allow' => array(
                    'Admin\Controller\Login.logout',
                    'Admin\Controller\Logout.index',
                    'Admin\Controller\Posts.index',
                    'Admin\Controller\Posts.save',
                )
            ),
            'ADMIN' => array(
                'allow' => array(
                    'Admin\Controller\Usuarios.index',
                    'Admin\Controller\Comentarios.index',
                    'Admin\Controller\Comentarios.delete',
                    'Admin\Controller\Usuarios.save',
                    'Admin\Controller\Usuarios.delete',
                    'Admin\Controller\Administracao.index',
                    'Admin\Controller\Posts.delete',
                )
            ),
        )
    )
);
