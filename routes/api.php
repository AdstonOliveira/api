<?php

use Illuminate\Http\Request;

Route::group([ 'middleware' => ['cors'] ], function () {
    /* ROTAS CLIENTES endpoint v1/clientes*/
    Route::get('v1/clientes/ativos/nome/{nome}', 'API\ClienteController@getNome');
    Route::get('v1/clientes/inativos/nome/{nome}', 'API\ClienteController@getNomeApagado');
    Route::get('v1/clientes/apagados', 'API\ClienteController@apagados');

    Route::resource('v1/clientes', 'API\ClienteController');

    /** ROTAS PRODUTOS v1/produtos*/
    Route::get('v1/produtos/ativos/nome/{nome}', 'API\ProdutoController@getNome');
    Route::get('v1/produtos/inativos/nome/{nome}', 'API\ProdutoController@getNomeApagado');
    Route::get('v1/produtos/apagados', 'API\ProdutoController@apagados');

    Route::resource('v1/produtos', 'API\ProdutoController');

});











