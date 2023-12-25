import { Ziggy } from '/js/ziggy.js';

// Obtener el select
const selectVendedor = document.querySelector('#vendedor');
const selectTipoCliente = document.querySelector('#tipoCliente');
const selectProducto = document.querySelector('#producto');
const inputFecha = document.querySelector('#fecha');

// Guardar el valor por defecto
const valorPorDefectoVendedor = selectVendedor.value;
const valorPorDefectoTipoCliente = selectTipoCliente.value;
const valorPorDefectoProducto = selectProducto.value;
const valorPorDefectoFecha = inputFecha.value;

// Escuchar el evento "pageshow"
window.addEventListener('pageshow', () => {
  // Establecer el valor del select al valor por defecto
  selectVendedor.value = valorPorDefectoVendedor;
  selectTipoCliente.value = valorPorDefectoTipoCliente;
  selectProducto.value = valorPorDefectoProducto;
  inputFecha.value = valorPorDefectoFecha;
});

console.log(Ziggy)

const selects = document.querySelectorAll("#filtros select");
const inputs = document.querySelectorAll("#filtros input");

var fechaVenta = undefined

function filtro(){

    console.log("Vendedor: "+document.getElementById("vendedor").value)
    console.log("Cliente: "+document.getElementById("tipoCliente").value)
    console.log("Producto: "+document.getElementById("producto").value)

    if (isNaN(Date.parse(document.getElementById("fecha").value))) {
        //console.log("Fecha inválida");
        fechaVenta = 'default'
    } else {
        //console.log("Fecha válida");
        fechaVenta = document.getElementById("fecha").value
    }

    console.log("Fecha: "+fechaVenta)

    const nombreVendedor = document.getElementById("vendedor").value
    const tipoCliente = document.getElementById("tipoCliente").value
    const nombreProducto = document.getElementById("producto").value

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('http://127.0.0.1:8000/ventas/filtro', {
        method: 'POST',
        body: JSON.stringify({nombreVendedor: nombreVendedor, tipoCliente: tipoCliente, nombreProducto: nombreProducto, fechaVenta: fechaVenta}),
        headers: {
            'Content-Type': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {

        console.log(data)
        console.log(data.fecha)

        const tbody = document.querySelector('#table_ventas tbody');
        tbody.innerHTML = '';

        data.ventas.forEach(venta => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${venta.id}</td>
                <td>${venta.nombreCliente}</td>
                <td>${venta.nombreVendedor}</td>
                <td>${venta.direccion}</td>
                <td>${venta.celular}</td>
                <td>${venta.cantidad}</td>
                <td>${venta.nombreProducto}</td>
                <td>S/. ${venta.precioUnitario}</td>
                <td>${venta.tipoCliente}</td>
                <td>${venta.tipoPago}</td>
                <td>${venta.created_at}</td>
                <td>S/. ${venta.total}</td>
                <td class="acciones_table">
                    <a href="${Ziggy.routes['sistema.ventas.edit'].uri.replace('{venta}', venta.id)}">
                        <button class='btn-editar'>Editar</button>
                    </a>
                    <form action="${Ziggy.routes['sistema.ventas.destroy'].uri.replace('{venta}', venta.id)}" method="POST">
                        <input type="hidden" name="_token" value="${ csrfToken }">    
                        <input type="hidden" name="_method" value="delete">
                        <button class='btn-delete'>Eliminar</button>
                    </form>
                </td>
            `;
            
            tbody.appendChild(tr);
        });

    })
    .catch(error => console.error(error));


}




selects.forEach((select) => {
  
    select.addEventListener('change', ()=>{
        filtro()
    })
 
})

inputs.forEach((input) => {
  
    input.addEventListener('blur', ()=>{
        filtro()
    })
 
})
