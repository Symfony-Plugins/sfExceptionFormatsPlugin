<?php

$app = 'frontend';
include dirname(__FILE__).'/../bootstrap/unit.php';
sfContext::createInstance($configuration);

$t = new lime_test(20, new lime_output_color);

$request = sfContext::getInstance()->getRequest();
$formats = array('html', 'txt', 'js', 'css', 'json', 'xml', 'rdf', 'atom');

$t->diag('->getTemplateName()');
$t->is(sfExceptionFormatsToolkit::getTemplateName(), 'exception.html.php', '->getTemplateName() returns correct value for "default" response format');
foreach ($formats as $format)
{
  $request->setRequestFormat($format);
  $t->is(sfExceptionFormatsToolkit::getTemplateName(), 'exception.'.$format.'.php', '->getTemplateName() returns correct value for "'.$format.'" format');
}

sfConfig::set('sf_debug', false);
$request->setRequestFormat(null);

$t->is(sfExceptionFormatsToolkit::getTemplateName(), 'error_500.html.php', '->getTemplateName() returns correct value for "default" response format');
foreach ($formats as $format)
{
  $request->setRequestFormat($format);
  $t->is(sfExceptionFormatsToolkit::getTemplateName(), 'error_500.'.$format.'.php', '->getTemplateName() returns correct value for "'.$format.'" format');
}

$t->diag('->getTemplateDirs()');
$t->is_deeply(sfExceptionFormatsToolkit::getTemplateDirs(), array(
  sfConfig::get('sf_app_config_dir'),
  sfConfig::get('sf_config_dir'),
  realpath(dirname(__FILE__).'/../../config'),
), '->getTemplateDirs() returns correct directories');

sfConfig::set('app_sf_exception_formats_plugin_templates_dir', realpath(dirname(__FILE__).'/../fixtures/project/data/errors'));
$t->is_deeply(sfExceptionFormatsToolkit::getTemplateDirs(), array(
  realpath(dirname(__FILE__).'/../fixtures/project/data/errors'),
  sfConfig::get('sf_app_config_dir'),
  sfConfig::get('sf_config_dir'),
  realpath(dirname(__FILE__).'/../../config'),
), '->getTemplateDirs() includes custom directory');
