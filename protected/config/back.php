<?php
$configDir = dirname(__FILE__);
$root = $configDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
$params = require_once($configDir . DIRECTORY_SEPARATOR . 'backparams.php');

// Setup some default path aliases. These alias may vary from projects.
Yii::setPathOfAlias('root', $root);
Yii::setPathOfAlias('libs', $configDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'libs');
Yii::setPathOfAlias('vendors', $configDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendors');
Yii::setPathOfAlias('extensions', $configDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'extensions');

return CMap::mergeArray(
            require(dirname(__FILE__) . '/main.php'), array(
            'theme' => 'admin',
            'components' => array(
                'urlManager' => array(
                    'urlFormat' => 'path',
                    'showScriptName' => false,
                    'urlSuffix' => '.html',
                    'rules' => array(
                        'admin' => 'site/login',
                        'admin/<_c>' => '<_c>',
                        'admin/<_c>/<_a>' => '<_c>/<_a>',
                    ),
                ),
            )
                )
);
?>