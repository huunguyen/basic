<?php
$configDir = dirname(__FILE__);
$root = $configDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
$params = require_once($configDir . DIRECTORY_SEPARATOR . 'frontparams.php');
return CMap::mergeArray(
                require(dirname(__FILE__) . '/main.php'), array(
            'theme' => 'frontend',
            'components' => array(
                'urlManager' => array(
                    'urlFormat' => 'path',
                    'showScriptName' => false,
                    'urlSuffix' => '.html',
                    'rules' => array(
                        '<controller:\w+>/<id:\d+>' => '<controller>/view',
                        '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                    ),
                ),
            )
                // Put front-end settings there
                )
);
?>