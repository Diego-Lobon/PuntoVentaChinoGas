<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VentasExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        $ventas = DB::select('CALL sp_ventas_listar_venta()');

        // Transformar los datos en una colección
        $data = array_map(function($venta) {
            return [
                'id' => $venta->id,
                'idCliente' => $venta->idCliente,
                'idVendedor' => $venta->idVendedor,
                'idProducto' => $venta->idProducto,
                'nombreCliente' => $venta->nombreCliente,
                'nombreVendedor' => $venta->nombreVendedor,
                'direccion' => $venta->direccion,
                'celular' => $venta->celular,
                'cantidad' => $venta->cantidad,
                'nombreProducto' => $venta->nombreProducto,
                'precioUnitario' => $venta->precioUnitario,
                'tipoCliente' => $venta->tipoCliente,
                'tipoPago' => $venta->tipoPago,
                'total' => $venta->total,
                'created_at' => $venta->created_at,
                'updated_at' => $venta->updated_at,
            ];
        }, $ventas);

        return new Collection($data);

    }
}
