<?php

use CodeDredd\Soap\Facades\Soap;
/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/register-customer', 'WalletController@registerCustomer');
$router->post('/wallet-recharge', 'WalletController@walletRecharge');
$router->post('/pay', 'WalletController@pay');
$router->post('/confirm-pay', 'WalletController@confirmPay');
$router->get('/check-balance', 'WalletController@checkBalance');
