<?php

$this->dispatcher->connect('application.throw_exception', array('sfExceptionFormatsToolkit', 'listenForThrowException'));
