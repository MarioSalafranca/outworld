<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AbsolutDrinksController;


Route::get('/historia', [PageController::class, 'historia'])->name('historia');
Route::get('/contacto', [PageController::class, 'contacto'])->name('contacto');
Route::get('/aviso-legal', [PageController::class, 'avisoLegal'])->name('avisoLegal');
Route::get('/politica-cookies', [PageController::class, 'politicaCookies'])->name('politicaCookies');
Route::get('/politica-privacidad', [PageController::class, 'politicaPrivacidad'])->name('politicaPrivacidad');
Route::get('/carrito-compra', [PageController::class, 'carrito'])->name('carrito');
Route::get('/producto', [PageController::class, 'producto'])->name('producto');

// Rutas Home
Route::get('/', [HomeController::class, 'home'])->name('home');

// Rutas Auth
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/check-age', [AuthController::class, 'checkAge'])->name('checkAge');

// Rutas Cuenta
Route::get('/cuenta', [CuentaController::class, 'cuenta'])->name('cuenta');
Route::get('/miCuenta', [CuentaController::class, 'miCuenta'])->name('miCuenta');
Route::post('/actualizar-contrasena', [CuentaController::class, 'actualizarPassword'])->name('actualizarPassword');
Route::post('/modificar-cuenta', [CuentaController::class, 'modificarCuenta'])->name('modificarCuenta');
Route::get('/factura/{id}', [CuentaController::class, 'descargarFactura'])->name('descargarFactura');
Route::get('/eliminar', [CuentaController::class, 'eliminarCuenta'])->name('eliminarCuenta');

// Rutas Tienda
Route::get('/tienda', [TiendaController::class, 'tienda'])->name('tienda');
Route::get('/producto/{id}', [TiendaController::class, 'producto'])->name('producto');
Route::get('/carrito', [TiendaController::class, 'carrito'])->name('carrito');
Route::post('/pedido', [TiendaController::class, 'procesarPedido'])->name('procesarPedido');

// Rutas Absolut Drinks
Route::get('/absolut-drinks', [AbsolutDrinksController::class, 'absolutDrinks'])->name('absolutDrinks');
Route::get('/drink/{id}', [AbsolutDrinksController::class, 'drink'])->name('drink');
Route::post('/drink/{id}/comentar', [AbsolutDrinksController::class, 'comentar'])->name('comentar');
Route::post('/reseñas/{id}/responder', [AbsolutDrinksController::class, 'responder'])->name('responder');

// Rutas admin
Route::get('/panel', [AdminController::class, 'panel'])->name('panel');
Route::post('/panel/user/{usuario_user}/make-admin', [AdminController::class, 'makeAdmin'])->name('panel.makeAdmin');
Route::delete('/panel/user/{usuario_user}', [AdminController::class, 'deleteUser'])->name('panel.deleteUser');

Route::delete('/panel/compra/{id}', [AdminController::class, 'deleteCompra'])->name('panel.deleteCompra');
Route::get('/panel/compra/{id}/invoice', [AdminController::class, 'downloadInvoice'])->name('panel.invoice');
// CREAR Y REGISTRAR COMPRA
Route::get('/panel/compra/create', [AdminController::class, 'createCompra'])->name('panel.createCompra');
Route::post('/panel/compra/registrar', [AdminController::class, 'registrarCompraAdmin'])->name('panel.registrarCompraAdmin');
// BORRAR PRODUCTO
Route::delete('/panel/producto/{id}', [AdminController::class, 'deleteProducto'])->name('panel.deleteProducto');
// EDITAR PRODUCTO Y CONFIRMAR ACTUALIZAR
Route::get('/panel/producto/{id}/editar', [AdminController::class, 'editarProducto'])->name('panel.editarProducto');
Route::put('/panel/producto/{id}', [AdminController::class, 'updateProducto'])->name('panel.updateProducto');
// CREAR Y REGISTRAR PRODUCTO
Route::get('/panel/producto/create', [AdminController::class, 'createProducto'])->name('panel.createProducto');
Route::post('/panel/producto/registrar', [AdminController::class, 'registrarProductoAdmin'])->name('panel.registrarProductoAdmin');
// DRINKS
// CREAR Y REGISTRAR DRINK
Route::get('/panel/drinks/create',      [AdminController::class, 'createDrink'])->name('panel.createDrink');
Route::post('/panel/drinks', [AdminController::class, 'registrarDrink'])->name('panel.registrarDrink');
// BORRAR DRINK
Route::delete('/panel/drinks/{id}',     [AdminController::class, 'deleteDrink'])->name('panel.deleteDrink');
// CREAR Y ACTUALIZAR DRINK
Route::get('/panel/drinks/{id}/editar',   [AdminController::class, 'editDrink'])->name('panel.editDrink');
Route::put('/panel/drinks/{id}', [AdminController::class, 'updateDrink'])->name('panel.updateDrink');
