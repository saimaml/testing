<?php

if (version_compare(PHP_VERSION, '5.4.0', '<')) {
  throw new Exception('The Facebook SDK v4 requires PHP version 5.4 or higher.');
}

spl_autoload_register(function ($class)
{
  // project-specific namespace prefix
  $prefix = 'Facebook\\';

  // base directory for the namespace prefix
  $base_dir = defined('FACEBOOK_SDK_V4_SRC_DIR') ? FACEBOOK_SDK_V4_SRC_DIR : __DIR__ . '/src/Facebook/';

  // does the class use the namespace prefix?
  $len = strlen($prefix);
  if (strncmp($prefix, $class, $len) !== 0) {
    // no, move to the next registered autoloader
    return;
  }

  // get the relative class name
  $relative_class = substr($class, $len);

  // replace the namespace prefix with the base directory, replace namespace
  // separators with directory separators in the relative class name, append
  // with .php
   $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
  

  // if the file exists, require it
  if (file_exists($file)) {
    require $file;
  }
});