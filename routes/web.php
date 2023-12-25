<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MenuPrincipalController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CrearInventarioController;
use App\Http\Controllers\CrearVentasController;
use App\Http\Controllers\EditarInventarioController;
use App\Http\Controllers\EditarVentasController;

use App\Http\Controllers\ValidarPasswordController;

use Tightenco\Ziggy\Ziggy;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/ziggy', function () {
    $routes = Ziggy::toJson();

    return view('ziggy', compact('routes'));
})->name('ziggy');

Route::get('/', [LoginController::class, 'index'])->name('sistema.login');
Route::post('/', [LoginController::class, 'login'])->name('sistema.login');

Route::get('/logout', [LogoutController::class, 'logout'])->name('sistema.logout');

Route::get('/menuPrincipal', [MenuPrincipalController::class, 'index'])->name('sistema.menuPrincipal');

Route::get('inventario', [InventarioController::class, 'index'])->name('sistema.inventario.index');
Route::get('inventario/crear', [InventarioController::class, 'create'])->name('sistema.inventario.create');
Route::post('inventario', [InventarioController::class, 'store'])->name('sistema.inventario.store');
Route::get('inventario/{producto}/editar', [InventarioController::class, 'edit'])->name('sistema.inventario.edit');
Route::put('inventario/{producto}', [InventarioController::class, 'update'])->name('sistema.inventario.update');
Route::delete('inventario/{producto}', [InventarioController::class, 'destroy'])->name('sistema.inventario.destroy');
Route::post('inventario/{producto}/editar', [InventarioController::class, 'validarEditNombreProducto'])->name('sistema.inventario.validarEditNombreProducto');
Route::post('inventario/crear', [InventarioController::class, 'validarCrearNombreProducto'])->name('sistema.inventario.validarCrearNombreProducto');

Route::get('clientes', [ClienteController::class, 'index'])->name('sistema.clientes.index');
Route::get('clientes/crear', [ClienteController::class, 'create'])->name('sistema.clientes.create');
Route::post('clientes', [ClienteController::class, 'store'])->name('sistema.clientes.store');
Route::get('clientes/{cliente}/editar', [ClienteController::class, 'edit'])->name('sistema.clientes.edit');
Route::put('clientes/{cliente}', [ClienteController::class, 'update'])->name('sistema.clientes.update');
Route::delete('clientes/{cliente}', [ClienteController::class, 'destroy'])->name('sistema.clientes.destroy');
Route::post('clientes/crear', [ClienteController::class, 'validarCrearNombreCliente'])->name('sistema.clientes.validarCrearNombreCliente');
Route::post('clientes/{cliente}/editar', [ClienteController::class, 'validarEditNombreCliente'])->name('sistema.clientes.validarEditNombreCliente');

Route::post('clientes/tipo', [ClienteController::class, 'filtroTipoCliente'])->name('sistema.clientes.filtroTipoCliente');


Route::get('ventas', [VentasController::class, 'index'])->name('sistema.ventas.index');
Route::get('ventas/crear', [VentasController::class, 'create'])->name('sistema.ventas.create');
Route::post('ventas', [VentasController::class, 'store'])->name('sistema.ventas.store');
Route::get('ventas/{venta}/editar', [VentasController::class, 'edit'])->name('sistema.ventas.edit');
Route::put('ventas/{venta}', [VentasController::class, 'update'])->name('sistema.ventas.update');
Route::delete('ventas/{venta}', [VentasController::class, 'destroy'])->name('sistema.ventas.destroy');
Route::post('ventas/crear', [VentasController::class, 'buscarVentaCliente'])->name('sistema.ventas.buscarVentaCliente');
Route::post('ventas/crear/datosCliente', [VentasController::class, 'cargarVentaDatosCliente'])->name('sistema.ventas.cargarVentaDatosCliente');
Route::post('ventas/filtro', [VentasController::class, 'filtroVentasTabla'])->name('sistema.ventas.filtroVentasTabla');

Route::get('ventas/export_ventas-excel', [VentasController::class, 'exportExcel'])->name('sistema.ventas.exportExcel');



Route::get('usuarios', [UsuarioController::class, 'index'])->name('sistema.usuarios.index');
Route::get('usuarios/crear', [UsuarioController::class, 'create'])->name('sistema.usuarios.create');
Route::post('usuarios', [UsuarioController::class, 'store'])->name('sistema.usuarios.store');
Route::get('usuarios/{usuario}/editar', [UsuarioController::class, 'edit'])->name('sistema.usuarios.edit');
Route::put('usuarios/{usuario}', [UsuarioController::class, 'update'])->name('sistema.usuarios.update');
Route::delete('usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('sistema.usuarios.destroy');
Route::post('usuarios/crear', [UsuarioController::class, 'validarCrearNombreUsuario'])->name('sistema.usuarios.validarCrearNombreUsuario');
Route::post('usuarios/{usuario}/editar', [UsuarioController::class, 'validarEditNombreUsuario'])->name('sistema.usuarios.validarEditNombreUsuario');




