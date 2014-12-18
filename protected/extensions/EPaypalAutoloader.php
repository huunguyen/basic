<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EPaypalAutoloader
 *
 * @author huunguyen
 */
class EPaypalAutoloader {
    /**
     * @var list of paths to search for classes.
     * Add full paths to modules here.
     */
    static $paths = array();

    /**
     * Class autoload loader.
     *
     * @static
     * @param string $className
     * @return boolean
     */
    static function loadClass($className) {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        foreach (array('Imagine') as $dirPrefix) {
            $file = __DIR__ . '/../' . $dirPrefix . '/' . $path . '.php';
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
        }

        return false;
    }
}

?>
