<?php

$rootDir = realpath(dirname(__FILE__).'/../../../..');

require_once $rootDir.'/config/ProjectConfiguration.class.php';

if (isset($app))
{
  $configuration = sfProjectConfiguration::getApplicationConfiguration($app, 'test', true, $rootDir);
}
else
{
  $configuration = new ProjectConfiguration($rootDir);

  $autoload = sfSimpleAutoload::getInstance();
  $autoload->addDirectory(dirname(__FILE__).'/../../lib');
  $autoload->register();
}

include sfConfig::get('sf_symfony_lib_dir').'/vendor/lime/lime.php';
