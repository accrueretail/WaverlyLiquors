<?php
/**
 * Created by PhpStorm.
 * User: anands
 * Date: 17/07/16
 * Time: 12:54 PM
 */


$_routes = [
	
    'welcome/{param}' => 'index',
    '' => 'index',
    'index' => 'index',
    'login' => 'login',
    'about-wine' => 'about-wine',
    'about-beer' => 'about-beer',
    'about-us' => 'about-us',
    'tasting' => 'tasting',
    'spirits' => 'spirits',
    'services' => 'services',
    'education' => 'education',
    'guide' => 'guide',
    'privacy-policy' => 'privacy-policy',
    'terms-conditions' => 'terms-conditions',
    'shipping' => 'shipping',
    'contact-us' => 'contact-us',
    'events' => 'events',
    'myaccount' => 'myaccount',
    'myaccount/{type}' => 'myaccount',
    'myaccount/{type}/{addr_id}' => 'myaccount',
    'checkout/{type}' => 'checkout',
    'checkout/{type}/{addr_id}' => 'checkout',
    'checkout/{type}/{addr_id}/{tip}' => 'checkout',
    'payment' => 'payment',
    'payment/{payment_status}' => 'payment',
    'ordersuccess/{payment_id}/{cart_id}' => 'ordersuccess',
    'success' => 'success',
    'failure' => 'failure',
    'feature-products' => 'feature-products',
    'api/{func}/{category}' => 'api',
    'api/{func}/{status}/{pid}' => 'api',
    'online/{pid}' => 'product-details',
    'product-details/{pid}/{sid}' => 'product-details',
    'recipe-details/{recipeid}' => 'recipe-details',
    'recipes' => 'recipes',
    'cart' => 'cart',
    'buy-{product-type}' => 'product-listing',
    'search' => 'product-listing',
    '{product-type}/{category}' => 'product-listing',
];
