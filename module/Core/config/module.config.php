<?php

return array(
    'di' => array(),
    'view_manager' => array(
        'template_path_stack' => array(
            'core' => __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'session' => 'Core\View\Helper\Session'
        )
    ),
);
