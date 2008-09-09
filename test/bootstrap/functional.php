<?php

$sf_symfony_lib_dir = isset($_SERVER['SYMFONY']) ? $_SERVER['SYMFONY'] : sprintf('%s/lib/vendor/symfony/lib', realpath(dirname(__FILE__).'/../../../..'));

require_once $sf_symfony_lib_dir.'/vendor/lime/lime.php';
require_once $sf_symfony_lib_dir.'/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

require_once dirname(__FILE__).'/../fixtures/project/config/ProjectConfiguration.class.php';
$configuration = sfProjectConfiguration::getApplicationConfiguration('frontend', 'test', true);
sfContext::createInstance($configuration);

// remove all cache
sfToolkit::clearDirectory(sfConfig::get('sf_app_cache_dir'));
