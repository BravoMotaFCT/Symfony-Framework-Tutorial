<?php
// example.com/web/front.php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\Routing\CompiledRoute;

$request = Request::createFromGlobals();
$routes = include __DIR__.'/../src/app.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);


use Symfony\Component\Routing\Matcher\CompiledUrlMatcher;
use Symfony\Component\Routing\Matcher\Dumper\CompiledUrlMatcherDumper;
$compiledRoutes = (new CompiledUrlMatcherDumper($routes))->getCompiledRoutes();
// $compiledRoutes is a plain PHP array you can cache it, typically by exporting it to a PHP file
file_put_contents('preRoutes.php', '<?php return ' . var_export($compiledRoutes, true) . ';');
$compiledRoutes2 = include 'preRoutes.php'; //EOCaching (not active)
$matcher = new CompiledUrlMatcher($compiledRoutes2, $context);


//$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

try {
    extract($matcher->match($request->getPathInfo()), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);

    $response = new Response(ob_get_clean());
} catch (Routing\Exception\ResourceNotFoundException $exception) {
    $response = new Response('Not Found', 404);
} catch (Exception $exception) {
    $response = new Response('An error occurred', 500);
}


$response->send();