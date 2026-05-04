<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/auth/register' => [[['_route' => 'auth_register', '_controller' => 'App\\Controller\\AuthController::register'], null, ['POST' => 0], null, false, false, null]],
        '/api/orders' => [[['_route' => 'order_create', '_controller' => 'App\\Controller\\OrderController::create'], null, ['POST' => 0], null, false, false, null]],
        '/api/orders/my' => [[['_route' => 'order_my', '_controller' => 'App\\Controller\\OrderController::myOrders'], null, ['GET' => 0], null, false, false, null]],
        '/api/reviews' => [[['_route' => 'review_create', '_controller' => 'App\\Controller\\ReviewController::create'], null, ['POST' => 0], null, false, false, null]],
        '/api/services' => [
            [['_route' => 'services_list', '_controller' => 'App\\Controller\\ServiceController::list'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'service_create', '_controller' => 'App\\Controller\\ServiceController::create'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/auth/login' => [[['_route' => 'api_login'], null, ['POST' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/api/(?'
                    .'|reviews/service/([^/]++)(*:74)'
                    .'|services/([^/]++)(*:98)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        74 => [[['_route' => 'review_by_service', '_controller' => 'App\\Controller\\ReviewController::byService'], ['id'], ['GET' => 0], null, false, true, null]],
        98 => [
            [['_route' => 'service_show', '_controller' => 'App\\Controller\\ServiceController::show'], ['id'], ['GET' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
