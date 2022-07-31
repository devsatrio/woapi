<?php
$router->get('/', function () use ($router) {
    return "Api Work Order build with love & ".$router->app->version();
});

$router->get('work_list', 'MasterDataController@work_list');
$router->get('unit', 'MasterDataController@unit');
$router->get('work_pelaksana', 'MasterDataController@work_pelaksana');
$router->post('login', 'LoginController@login_act');

$router->get('work_order', 'WorkOrderController@index');
$router->post('work_order', 'WorkOrderController@store');