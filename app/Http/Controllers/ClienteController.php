<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function index(){

        if(!Auth::check()){
            return redirect()->route('sistema.login');
        }

        $clientes = DB::select("CALL sp_clientes_listar_clientes()");
        $clientes = json_decode(json_encode($clientes), true);
 
        return view('sistema.clientes.cliente', ['clientes' => $clientes]);
    
    }

    public function create(){

        if(!Auth::check()){
            return redirect()->route('sistema.login');
        }

        return view('sistema.clientes.crearClientes');

    }

    public function store(Request $request){

        $nombreCliente = $request->nombreCliente;
        $direccion = $request->direccion;
        $celular = $request->celular;
        $tipo = $request->tipo;

        DB::statement('CALL sp_clientes_crear_cliente(?, ?, ?, ?)', [
            $nombreCliente, 
            $direccion, 
            $celular,
            $tipo
        ]);

        return redirect()->route('sistema.clientes.index');

    }

    public function validarCrearNombreCliente(Request $request){

        $inputValue = $request->input('inputValue');

        $resultado = DB::select('CALL sp_clientes_validacion_crear_cliente(?, @encontrado)', [$inputValue]);
        $encontrado = DB::select('SELECT @encontrado')[0]->{'@encontrado'};
        
        // Verificar el valor de $encontrado para depurar el código
        
        return $encontrado;

    }

    public function edit($id){

        if(!Auth::check()){
            return redirect()->route('sistema.login');
        }
        
        $cliente = DB::select('CALL sp_clientes_buscar_cliente_por_id(?)', [$id]);
        $cliente = json_decode(json_encode($cliente), true);

        return view('sistema.clientes.editarClientes', ['cliente' => $cliente]);

    }

    public function validarEditNombreCliente(Request $request){

        $inputValue = $request->input('inputValue');
        $idCliente = $request->input('idCliente');
        
        $resultado = DB::select('CALL sp_clientes_buscar_nombre_cliente_por_id(?)', [$idCliente]);
        $nombreCliente = $resultado[0]->nombreCliente;

        $resultado = DB::select('CALL sp_clientes_validacion_buscar_cliente(?, ?, @encontrado)', [$inputValue, $nombreCliente]);
        $encontrado = DB::select('SELECT @encontrado')[0]->{'@encontrado'};
        
        // Verificar el valor de $encontrado para depurar el código
        
        return $encontrado;

    }

    public function update(Request $request, $id){
 
        DB::statement('CALL sp_clientes_actualizar_cliente(?, ?, ?, ?, ?)', [
            $id, 
            $request->nombreCliente, 
            $request->direccion,
            $request->celular,
            $request->tipo
        ]);
    
        return redirect()->route('sistema.clientes.index');
        
    }

    public function destroy($id){

        DB::statement('CALL sp_clientes_eliminar_cliente(?)', [$id]);

        return redirect()->route('sistema.clientes.index')->with('eliminar', 'ok')->with('dato', 'El cliente se eliminó con éxito');

    }

    public function filtroTipoCliente(Request $request){
        
        //var_dump($request->tipo);
        $clientes = DB::select('CALL sp_clientes_filtrar_cliente(?)', [$request->tipo]);
        $clientes = json_decode(json_encode($clientes), true);

        

        return response()->json(['clientes' => $clientes]);

    }

}
