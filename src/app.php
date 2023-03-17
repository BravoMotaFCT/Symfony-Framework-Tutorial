<?php
// example.com/src/app.php
use Symfony\Component\Routing;

//echo("<script>console.log('PHP: " . 'debuuuuug' . "');</script>");

$routes = new Routing\RouteCollection();
$routes->add('hello', new Routing\Route('/hello/{name}', ['name' => 'World']));
$routes->add('bye', new Routing\Route('/bye'));

return $routes;

?>