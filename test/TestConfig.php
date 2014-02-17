<?php
return array(
    'modules' => array(
        'ZfcBase',
    	'ZfcRbac',
    	'ZfcUser',
    	'DoctrineModule',
    	'DoctrineORMModule',
    	'DoctrineDataFixtureModule',
    	'ZfcUserDoctrineORM',
    	'RbacUserDoctrineOrm'
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'test.config.php',
        ),
        'module_paths' => array(
            'module',
            'vendor',
        ),
    ),
);