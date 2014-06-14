<?php
use Doctrine\Common\Annotations\AnnotationRegistry;

// Composer
if (!file_exists($file = __DIR__.'/../../vendor/autoload.php')) {
    throw new \RuntimeException('Please run composer first.');
}
$loader = require_once __DIR__.'/../../vendor/autoload.php';
AnnotationRegistry::registerLoader(array($loader, 'loadClass'));
return $loader;
