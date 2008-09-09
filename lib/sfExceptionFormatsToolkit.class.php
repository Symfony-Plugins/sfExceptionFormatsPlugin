<?php

/**
 * Encapsulates exception handling logic.
 * 
 * @package     sfExceptionFormatsPlugin
 * @subpackage  util
 * @author      Kris Wallsmith <kris.wallsmith@gmail.com>
 * @version     SVN: $Id$
 */
class sfExceptionFormatsToolkit
{
  /**
   * Processes the application.throw_exception event.
   * 
   * @param   sfEvent $event
   * 
   * @return  boolean
   * 
   * @see     sfException::outputStackTrace()
   */
  static public function listenForThrowException(sfEvent $event)
  {
    $context   = sfContext::getInstance();
    $request   = $context->getRequest();
    $response  = $context->getResponse();
    $exception = $event->getSubject();

    if ($request instanceof sfWebRequest)
    {
      $files = array_map(create_function('$d', 'return $d.\'/'.self::getTemplateName().'\';'), self::getTemplateDirs());
      foreach ($files as $file)
      {
        if (is_readable($file))
        {
          $response->setStatusCode(500);
          $response->setContentType($request->getMimeType($request->getRequestFormat()));

          if (!sfConfig::get('sf_test'))
          {
            foreach ($response->getHttpHeaders() as $name => $value)
            {
              header($name.': '.$value);
            }
          }

          sfExceptionFormatsException::createFromException($exception)->render($file, $format);

          return true;
        }
      }
    }

    return false;
  }

  /**
   * Returns the name of the template to present.
   * 
   * @return  string
   */
  static public function getTemplateName()
  {
    return vsprintf('%s.%s.php', array(
      sfConfig::get('sf_debug') ? 'exception' : 'error_500',
      ($format = sfContext::getInstance()->getRequest()->getRequestFormat()) ? $format : 'html',
    ));
  }

  /**
   * Returns an array of template directories.
   * 
   * @return  array
   */
  static public function getTemplateDirs()
  {
    $dirs = array();

    // custom
    if (sfConfig::get('app_sf_exception_formats_plugin_templates_dir'))
    {
      $dirs[] = sfConfig::get('app_sf_exception_formats_plugin_templates_dir');
    }

    // application
    if (sfConfig::get('sf_app_config_dir'))
    {
      $dirs[] = sfConfig::get('sf_app_config_dir');
    }

    // project
    $dirs[] = sfConfig::get('sf_config_dir');

    // default
    $dirs[] = realpath(dirname(__FILE__).'/../config');

    return $dirs;
  }
}
