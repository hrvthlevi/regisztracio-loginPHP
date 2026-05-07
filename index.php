<?php

// Példa: URL elemzése és megfelelő funkció hívása
/* $requestUri = $_SERVER['REQUEST_URI']; */
$requestUri = strtok($_SERVER['REQUEST_URI'], '?'); //kérdőjel nélkül
$requestMethod = $_SERVER['REQUEST_METHOD'];
$basePath = '/reg2'; // Az alkalmazás gyökérútvonala

// Eltávolítjuk a gyökérútvonalat a kérésekből
$path = str_replace($basePath, '', $requestUri);

$routes = [
    '/' => __DIR__ . '/login.php',
	'/about' => __DIR__ . '/views/about.php',
	'/active' => __DIR__ . '/active_users.php',
    '/contact' => __DIR__ . '/views/contact.php',
    '/404' => __DIR__ . '/views/404.php'
];


// Ha az útvonal szerepel a definiált útvonalak között, importáljuk a megfelelő fájlt

    if (isset($routes[$path])) {
        include_once($routes[$path]);
    }
     else {
        // Include the 404 error page
        include_once($routes['/404']);
    }






