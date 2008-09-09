<?xml version="1.0" encoding="UTF-8"?>
<error code="500" message="Internal Server Error">
  <debug exception="<?php echo get_class($exception) ?>" message="<?php echo htmlspecialchars($exception->getMessage(), ENT_COMPAT, sfConfig::get('sf_charset')) ?>" />
</error>
