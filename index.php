<?php

/**
 * This file demonstrates how to implement internationalization
 * with Slim Framework, Twig and Symfony's Translate component.
 *
 * Enjoy
 * Helge Sverre <email@helgesverre.com>
 */


// include the composer autoloader
require './vendor/autoload.php';

// Use the ridiculously long Symfony namespaces
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;


// Instantiate and setup Slim application instance
$app = new \Slim\Slim(array(
    'view' => new \Slim\Views\Twig(),
    'templates.path' => './views'
));

// ONLY FOR EXAMPLE, DON'T DO THIS
$language = $_GET["lang"];

// First param is the "default language" to use.
$translator = new Translator($language, new MessageSelector());

// Set a fallback language incase you don't have a translation in the default language
$translator->setFallbackLocales(['en_US']);

// Add a loader that will get the php files we are going to store our translations in
$translator->addLoader('php', new PhpFileLoader());

// Add language files here
$translator->addResource('php', './lang/no_NB.php', 'no_NB'); // Norwegian
$translator->addResource('php', './lang/en_US.php', 'en_US'); // English

// Get the view
$view = $app->view();

// Add the parserextensions TwigExtension and TranslationExtension to the view
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
    new TranslationExtension($translator)
);

// setup a home route
$app->get("/", function () use ($app) {
    // Render a twig view
    $app->render("example.twig");
});

// Run the slim app
$app->run();