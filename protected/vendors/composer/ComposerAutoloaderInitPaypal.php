<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ComposerAutoloaderInitPaypal
 *
 * @author huunguyen
 */
class ComposerAutoloaderInitPaypal
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitPaypal', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader();
        spl_autoload_unregister(array('ComposerAutoloaderInitPaypal', 'loadClassLoader'));

        $vendorDir = dirname(__DIR__);
        $baseDir = dirname($vendorDir);

        $map = require __DIR__ . '/autoloadpaypal_namespaces.php';
        foreach ($map as $namespace => $path) {
            $loader->set($namespace, $path);
        }

        $classMap = require __DIR__ . '/autoloadpaypal_classmap.php';
        if ($classMap) {
            $loader->addClassMap($classMap);
        }

        $loader->register(true);

        return $loader;
    }
}
?>
