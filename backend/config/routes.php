<?php
/**
 * definition des routes
 * '/' => 'home' signifie que la route / sera gérée par le controller homeController
 */
$routes = [
    '/' => 'home',
    '/register' => 'register',
    '/login' => 'login',
    '/table' => 'table',
    '/plongee' => 'plongee/plongee',
    '/plongee/profile' => 'plongee/profile',
    '/plongee/equipement' => 'plongee/equipement',
    '/plongee/tableau'=>'plongee/tableau',
];