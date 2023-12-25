<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\VentasExport;
use Maatwebsite\Excel\Facades\Excel;


class VentasController extends Controller
{
    public function index(){

        if(!Auth::check()){
            return redirect()->route('sistema.login');
        }

        $ventas = DB::select("CALL sp_ventas_listar_venta()");
        $ventas = json_decode(json_encode($ventas), true);

        $cantidadTotalBalones = DB::select("CALL sp_ventas_sumar_cantidad_de_balones()");
        $utilidadTotal = DB::select("CALL sp_ventas_sumar_utilidad()");

        $productos = DB::select("CALL sp_ventas_cargar_nombre_id_productos()");
        $productos = json_decode(json_encode($productos), true);

        $vendedores = DB::select("CALL sp_ventas_cargar_nombre_id_users()");
        $vendedores = json_decode(json_encode($vendedores), true);

        $clientes = DB::select("CALL sp_ventas_cargar_nombre_id_clientes()");
        $clientes = json_decode(json_encode($clientes), true);

        return view('sistema.ventas.venta', [
            'ventas' => $ventas,
            'cantidadTotalBalones' => $cantidadTotalBalones,
            'utilidadTotal' => $utilidadTotal,
            'productos' => $productos,
            'vendedores' => $vendedores,
            'clientes' => $clientes,
        ]);

    }

    public function create(){

        if(!Auth::check()){
            return redirect()->route('sistema.login');
        }

        $productos = DB::select("CALL sp_ventas_cargar_nombre_id_productos()");
        $productos = json_decode(json_encode($productos), true);

        $vendedores = DB::select("CALL sp_ventas_cargar_nombre_id_users()");
        $vendedores = json_decode(json_encode($vendedores), true);

        return view('sistema.ventas.crearVentas', ['productos' => $productos, 'vendedores' => $vendedores]);
    }

    public function store(Request $request){

        $idCliente = $request->idCliente;
        $nombreCliente = $request->nombreCliente;
        $nombreVendedor = $request->select_vendedor;
        $direccion = $request->direccion;
        $celular = $request->celular;
        $cantidad = $request->cantidad;
        $nombreProducto = $request->select_producto;
        $tipoCliente = $request->select_tipo_cliente;
        $tipoPago = $request->select_tipo_pago;
        

        DB::statement('CALL sp_ventas_crear_venta(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $idCliente, 
            $nombreCliente, 
            $nombreVendedor,
            $direccion,
            $celular,
            $cantidad,
            $nombreProducto,
            $tipoCliente,
            $tipoPago,
        ]);

        return redirect()->route('sistema.ventas.index');

    }

    public function edit($id){

        if(!Auth::check()){
            return redirect()->route('sistema.login');
        }
        
        $venta = DB::select('CALL sp_ventas_buscar_venta_por_id(?)', [$id]);
        $venta = json_decode(json_encode($venta), true);

        $productos = DB::select("CALL sp_ventas_cargar_nombre_id_productos()");
        $productos = json_decode(json_encode($productos), true);

        $vendedores = DB::select("CALL sp_ventas_cargar_nombre_id_users()");
        $vendedores = json_decode(json_encode($vendedores), true);

        return view('sistema.ventas.editarVentas', [
            'venta' => $venta,
            'productos' => $productos,
            'vendedores' => $vendedores
        ]);

    }

    public function update(Request $request, $id){
 
        DB::statement('CALL sp_ventas_actualizar_venta(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $id, 
            $request->idCliente, 
            $request->nombreCliente,
            $request->select_vendedor,
            $request->direccion,
            $request->celular,
            $request->cantidad,
            $request->select_producto,
            $request->select_tipo_cliente,
            $request->select_tipo_pago
        ]);
    
        return redirect()->route('sistema.ventas.index');
        
    }

    public function destroy($id){

        DB::statement('CALL sp_ventas_eliminar_venta(?)', [$id]);

        return redirect()->route('sistema.ventas.index')->with('eliminar', 'ok')->with('dato', 'La venta se eliminó con éxito');

    }

    public function buscarVentaCliente(Request $request){
        
        $inputValue = $request->input('inputValue');
        
        $resultado = DB::select('CALL sp_clientes_buscar_cliente_por_nombre(?)', [$inputValue]);
        
        if (empty($resultado)) {
            return response()->json(['respuesta' => 'No se encontró ningún cliente']);
        }

        

        // Verificar el valor de $encontrado para depurar el código
        return response()->json(['respuesta' => $resultado]);

    }

    public function cargarVentaDatosCliente(Request $request){
        
        $inputValue = $request->input('inputValue');
        
        $resultado = DB::select('CALL sp_clientes_cargar_datos_cliente_por_nombre(?)', [$inputValue]);
        
        if (empty($resultado)) {
            return response()->json(['respuesta' => 'No se encontró ningún cliente']);
        }

        // Verificar el valor de $encontrado para depurar el código
        return response()->json(['respuesta' => $resultado]);

    }

    public function filtroVentasTabla(Request $request){

        

        $idVendedor = $request->input('nombreVendedor');
        $tipoCliente = $request->input('tipoCliente');
        $idProducto = $request->input('nombreProducto');
        $fechaVenta = $request->input('fechaVenta');

        if ($fechaVenta != 'default') {
            $fechaVenta = date('Y-m-d', strtotime($fechaVenta));
        }
            

        $ventas = DB::select('CALL sp_ventas_filtro(?, ?, ?, ?)', [
            $idVendedor,
            $tipoCliente,
            $idProducto,
            $fechaVenta
        ]);
        $ventas = json_decode(json_encode($ventas), true);
        //dd($nombreVendedor);
        return response()->json(['ventas' => $ventas, 'fecha' => $fechaVenta]);

    }

    public function exportExcel(){

        return Excel::download(new VentasExport, 'reporteVentas.xlsx');

    }

}
