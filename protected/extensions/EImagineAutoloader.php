<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ESmartyViewRenderer
 *
 * @author huunguyen
 */
class EImagineAutoloader {

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

    /**
     * @return Imagine\Image\ImagineInterface
     */
    public function getImagine() {
        switch ($this->driver) {
            case "gd2":
                return new Imagine\Gd\Imagine();
            case "imagick":
                return new Imagine\Imagick\Imagine();
            case "gmagick":
                return new Imagine\Gmagick\Imagine();
        }
    }

    /**
     * @param $filename string
     * @param $width int
     * @param $height int
     * @return Imagine\Image\ImageInterface
     */
    public function resize($filename, $width, $height) {
        /* @var $im Imagine\Image\ImageInterface */
        $im = $this->getImagine()->open($filename)->copy();
        $size = $im->getSize();
        $maxSize = new Box($width, $height);

        // We do not need to resize image, so just copy it if needed
        if (($size->getWidth() <= $maxSize->getWidth() && $size->getHeight() <= $maxSize->getHeight()) || (!$maxSize->getHeight() && !$maxSize->getWidth())) {
            return $im;
        }

        // Resizing is necessary
        $k = $size->getWidth() / $maxSize->getWidth() > $size->getHeight() / $maxSize->getHeight() ? $size->getWidth() / $maxSize->getWidth() : $size->getHeight() /
                $maxSize->getHeight();

        $size = $size->scale(1 / $k);

        return $im->resize($size);
    }

    /**
     * @param $filename string
     * @param $width int
     * @param $height int
     * @return Imagine\Image\ImageInterface
     */
    public function crop($filename, $width, $height) {
        return $this->getImagine()->open($filename)->copy()->crop(new Point(0, 0), new Box($width, $height));
    }

    /**
     * @param $filename string
     * @param $width int
     * @param $height int
     * @return Imagine\Image\ImageInterface
     */
    public function thumb($filename, $width, $height) {
        /* @var $im Imagine\Image\ImageInterface */
        $im = $this->getImagine()->open($filename)->copy();
        $size = $im->getSize();
        $maxSize = new Box($width, $height);

        // We do not need to resize image, so just copy it if needed
        if (($size->getWidth() <= $maxSize->getWidth() && $size->getHeight() <= $maxSize->getHeight()) || (!$maxSize->getHeight() && !$maxSize->getWidth())) {
            return $im;
        }

        $im->resize($this->calcResizeBeforeCrop($size, $maxSize));
        $size = $im->getSize();

        $w = min($maxSize->getWidth(), $size->getWidth());
        $h = min($maxSize->getHeight(), $size->getHeight());
        return $im->resize($this->calcResizeBeforeCrop($size, $maxSize))
                        ->crop(new Point(ceil(($size->getWidth() - $w) / 2), ceil(($size->getHeight() - $h) / 2)), $maxSize);
    }

    /**
     * Handles size string eg "100x200 crop"
     *
     * @param $originalFilename
     * @param $size
     * @param $targetFilename
     */
    public function handleAndSave($originalFilename, $size, $targetFilename) {
        list($w, $h) = explode("x", $size, 2);
        $op = "resize";
        if (strpos($h, " ")) {
            list($h, $op) = explode(" ", $h, 2);
        }

        if ($op == "crop") {
            $im = $this->crop($originalFilename, $w, $h);
        } else if ($op == "thumb") {
            $im = $this->thumb($originalFilename, $w, $h);
        } else {
            $im = $this->resize($originalFilename, $w, $h);
        }
        $im->save($targetFilename);
    }

    private function calcResizeBeforeCrop(Box $image, Box $size) {
        $yAspect = $image->getHeight() / $size->getHeight();
        $xAspect = $image->getWidth() / $size->getWidth();

        if ($xAspect == $yAspect || ($xAspect < 1 && $yAspect < 1)) {
            return $size;
        }

        if ($xAspect < 1) {
            return new Box($image->getWidth(), $size->getHeight());
        }
        if ($yAspect < 1) {
            return new Box($size->getWidth(), $image->getHeight());
        }

        if ($xAspect < $yAspect) {
            return new Box($size->getWidth(), (int) ceil($image->getHeight() / $xAspect));
        } else {
            return new Box((int) ceil($image->getWidth() / $yAspect), $size->getHeight());
        }
    }

}
