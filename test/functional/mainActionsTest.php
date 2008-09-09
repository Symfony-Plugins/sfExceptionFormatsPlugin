<?php

include dirname(__FILE__).'/../bootstrap/functional.php';

class mainActionsTestBrowser extends sfTestBrowser
{
  public function listenToException(sfEvent $event)
  {
  }
}

$b = new mainActionsTestBrowser;
$t = $b->test();

$b->getAndCheck('main', 'throw', null, 500);
$t->like($b->getResponse()->getContentType(), '/^text\/html/', 'content type is "html"');
$t->like($b->getResponse()->getContent(), '/^<!DOCTYPE/', 'response is "html"');

$b->getAndCheck('main', 'throw', 'main/throw?sf_format=txt', 500);
$t->like($b->getResponse()->getContentType(), '/^text\/plain/', 'content type is "plain text"');
$t->like($b->getResponse()->getContent(), '/^\[exception\]/', 'response in "plain text"');

$b->getAndCheck('main', 'throw', 'main/throw?sf_format=js', 500);
$t->like($b->getResponse()->getContentType(), '/^application\/javascript/', 'content type is "javascript"');
$t->like($b->getResponse()->getContent(), '/^\/\*/', 'response is "javascript"');

$b->getAndCheck('main', 'throw', 'main/throw?sf_format=css', 500);
$t->like($b->getResponse()->getContentType(), '/^text\/css/', 'content type is "css"');
$t->like($b->getResponse()->getContent(), '/^\/\*/', 'response is "css"');

$b->getAndCheck('main', 'throw', 'main/throw?sf_format=json', 500);
$t->like($b->getResponse()->getContentType(), '/^application\/json/', 'content type is "json"');
$t->like($b->getResponse()->getContent(), '/^\{/', 'response is "json"');

$b->getAndCheck('main', 'throw', 'main/throw?sf_format=xml', 500);
$t->like($b->getResponse()->getContentType(), '/^text\/xml/', 'content type is "xml"');
$t->like($b->getResponse()->getContent(), '/^<\?xml/', 'response is "xml"');

$b->getAndCheck('main', 'throw', 'main/throw?sf_format=rdf', 500);
$t->like($b->getResponse()->getContentType(), '/^application\/rdf\+xml/', 'content type is "rdf"');
$t->like($b->getResponse()->getContent(), '/^<\?xml/', 'response is "xml"');

$b->getAndCheck('main', 'throw', 'main/throw?sf_format=atom', 500);
$t->like($b->getResponse()->getContentType(), '/^application\/atom\+xml/', 'content type is "atom"');
$t->like($b->getResponse()->getContent(), '/^<\?xml/', 'response is "xml"');

