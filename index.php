<?php

require 'vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ]
]);

$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('resources/views', [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    return $view;
};
/*VARIAVEIS GLOBAIS*/
$slides = require('app/db/db_slides.php');
$container['view']['slides'] = $slides;

$slides2 = require('app/db/db_slides2.php');
$container['view']['slides2'] = $slides2;

/* Rotas que renderizam as páginas que estão em ./resources/views*/

$app->get('/', function($request, $response) {
    $data = require('app/db/db_home.php');
    return $this->view->render($response, 'home.mobile.twig', [
        'pageTitle' => 'Home',
        'servicos' => $data["servicos"],
    ]);
})->setName('home');

$app->get('/about', function($request, $response) {
    return $this->view->render($response, 'about.mobile.twig');
})->setName('about');

$app->get('/services', function($request, $response) {
    return $this->view->render($response, 'services.mobile.twig');
})->setName('services');

$app->get('/contact', function($request, $response) {
    return $this->view->render($response, 'contact.mobile.twig');
})->setName('contact');

$app->post('/contact', function($request, $response) {
    die('Contact');
})->setName('contact');

$app->run();
