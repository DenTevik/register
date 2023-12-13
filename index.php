<?php
const BASE_PATH = __DIR__.'/';

// Autoload
spl_autoload_register(function($className)
{
  $namespace=str_replace("\\","/",__NAMESPACE__);
  $className=str_replace("\\","/",$className);
  $class=BASE_PATH."/".(empty($namespace)?"":$namespace."/")."{$className}.php";
  require_once($class);
});

require_once('inc/functions.php');
require_once('core/Database.php');
require_once('inc/routes.php');
require_once('inc/controller.php');
require_once('inc/render.php');


$route = $_GET['main_route'] ?? "";
$attributes = [];
foreach ($_GET as $key => $value) {
  if ($key != 'main_route') {
    $attributes['GET'][$key] = htmlspecialchars($value, ENT_QUOTES);
  }
}
foreach ($_POST as $key => $value) {
  $attributes['POST'][$key] = htmlspecialchars($value, ENT_QUOTES);
}
foreach ($_FILES as $key => $value) {
  $attributes['FILES'][$key] = $value;
}

new Routes($route, $attributes);
