<?php

class mainActions extends sfActions
{
  public function executeIndex()
  {
    return sfView::NONE;
  }

  public function executeThrow()
  {
    throw new sfException('Something went wrong.');
  }
}
