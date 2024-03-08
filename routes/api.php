<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VendaController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/vendas', [VendaController::class, 'cadastrarNovaVenda']);

Route::post('/vendas/{sales_id}/adicionar-produtos', [VendaController::class, 'cadastrarNovosProdutos']);

Route::get('/vendas/produtos', [VendaController::class, 'listarProdutosDisponiveis']);

Route::get('/vendas', [VendaController::class, 'consultarVendasRealizadas']);

Route::get('/vendas/{sales_id}', [VendaController::class, 'consultarVendaEspecifica']);

Route::delete('/vendas/cancelar/{sales_id}', [VendaController::class, 'cancelarVenda']);

Route::delete('/vendas/{sales_id}/produtos', [VendaController::class, 'removerProduto']);

