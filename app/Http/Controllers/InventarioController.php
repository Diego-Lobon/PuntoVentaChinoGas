<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventarioController extends Controller
{
    
    public function index(){

        if(!Auth::check()){
            return redirect()->route('sistema.login');
        }

        $productos = DB::select("CALL sp_inventario_listar_productos()");
        $productos = json_decode(json_encode($productos), true);
        $cantidadTotalBalones = DB::select("CALL sp_inventario_sumar_cantidad_de_balones()");
        $utilidadTotal = DB::select("CALL sp_inventario_sumar_utilidad()");

        return view('sistema.inventario.inventario', [
            'productos' => $productos, 
            'cantidadTotalBalones' => $cantidadTotalBalones, 
            'utilidadTotal' => $utilidadTotal
        ]);

    }

    public function create(){

        if(!Auth::check()){
            return redirect()->route('sistema.login');
        }

        return view('sistema.inventario.crearInventario');
    }

    public function store(Request $request){

        DB::statement('CALL sp_inventario_crear_producto(?, ?, ?, ?)', [
            $request->nombreProducto, 
            $request->cantidad, 
            $request->precioCompra,
            $request->precioVenta
        ]);

        return redirect()->route('sistema.inventario.index');

    }

    public function edit(Inventario $producto){

        if(!Auth::check()){
            return redirect()->route('sistema.login');
        }
        
        return view('sistema.inventario.editarInventario', compact('producto'));

    }

    public function validarEditNombreProducto(Request $request){

        $inputValue = $request->input('inputValue');
        $idProducto = $request->input('idProducto');
        
        $resultado = DB::select('CALL sp_inventario_buscar_nombre_producto_por_id(?)', [$idProducto]);
        $nombreProducto = $resultado[0]->nombreProducto;

        $resultado = DB::select('CALL sp_inventario_validacion_buscar_producto(?, ?, @encontrado)', [$inputValue, $nombreProducto]);
        $encontrado = DB::select('SELECT @encontrado')[0]->{'@encontrado'};
        
        // Verificar el valor de $encontrado para depurar el código
        
        return $encontrado;

    }

    public function validarCrearNombreProducto(Request $request){

        $inputValue = $request->input('inputValue');

        $resultado = DB::select('CALL sp_inventario_validacion_crear_producto(?, @encontrado)', [$inputValue]);
        $encontrado = DB::select('SELECT @encontrado')[0]->{'@encontrado'};
        
        // Verificar el valor de $encontrado para depurar el código
        
        return $encontrado;

    }

    public function update(Request $request, $id){

        DB::statement('CALL sp_inventario_actualizar_producto(?, ?, ?, ?, ?)', [
            $id,
            $request->nombreProducto, 
            $request->cantidad, 
            $request->precioCompra,
            $request->precioVenta
        ]);

        return redirect()->route('sistema.inventario.index');

    }

    public function destroy($id){

        DB::statement('CALL sp_inventario_eliminar_producto(?)', [$id]);

        return redirect()->route('sistema.inventario.index')->with('eliminar', 'ok')->with('dato', 'El producto se eliminó con éxito');

    }

}
