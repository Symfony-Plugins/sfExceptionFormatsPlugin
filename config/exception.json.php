{
  error: {
    code: 500,
    message: "Internal Server Error"
  },
  debug: {
    exception: "<?php echo get_class($exception) ?>",
    message: "<?php echo addslashes($exception->getMessage()) ?>"
  }
}
