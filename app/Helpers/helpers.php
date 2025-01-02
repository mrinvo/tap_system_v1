<?php

if (!function_exists('isActiveRoute')) {
    function isActiveRoute($routeName, $output = 'active') {
        return request()->routeIs($routeName) ? $output : '11';
    }
}

if (!function_exists('isActiveUrl')) {
    function isActiveUrl($url, $output = 'active') {
        return request()->is($url) ? $output : '11';
    }
}
