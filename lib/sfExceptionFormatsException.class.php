<?php

/**
 * A custom exception class used for rendering exception or error templates.
 * 
 * @package     sfExceptionFormatsPlugin
 * @subpackage  exception
 * @author      Kris Wallsmith <kris.wallsmith@gmail.com>
 * @version     SVN: $Id$
 */
class sfExceptionFormatsException extends sfException
{
  /**
   * @see sfException
   */
  static public function createFromException(Exception $e)
  {
    $exception = new sfExceptionFormatsException($e->getMessage());
    $exception->setWrappedException($e);

    return $exception;
  }

  /**
   * Renders an exception or error template.
   * 
   * @param   string $file
   * @param   string $format
   */
  public function render($file, $format)
  {
    $exception = is_null($this->wrappedException) ? $this : $this->wrappedException;

    if (sfConfig::get('sf_debug'))
    {
      /**
       * @see sfException::outputStackTrace()
       */
      $message = null !== $exception->getMessage() ? $exception->getMessage() : 'n/a';
      $name    = get_class($exception);
      if (in_array($format, array('html', 'txt')))
      {
        $traces = self::getTraces($exception, 'html' == $format ? $format : 'plain');
      }

      // dump main objects values
      $settingsTable = $requestTable = $responseTable = $globalsTable = $userTable = '';
      if (class_exists('sfContext', false) && sfContext::hasInstance())
      {
        $context = sfContext::getInstance();
        $settingsTable = self::formatArrayAsHtml(sfDebug::settingsAsArray());
        $requestTable  = self::formatArrayAsHtml(sfDebug::requestAsArray($context->getRequest()));
        $responseTable = self::formatArrayAsHtml(sfDebug::responseAsArray($context->getResponse()));
        $userTable     = self::formatArrayAsHtml(sfDebug::userAsArray($context->getUser()));
        $globalsTable  = self::formatArrayAsHtml(sfDebug::globalsAsArray());
      }
    }

    include $file;
  }
}
