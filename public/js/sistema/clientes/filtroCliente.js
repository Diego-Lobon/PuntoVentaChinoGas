
import { Ziggy } from '/js/ziggy.js';

// Obtener el select
const select = document.querySelector('#tipo');

// Guardar el valor por defecto
const valorPorDefecto = select.value;

// Escuchar el evento "pageshow"
window.addEventListener('pageshow', () => {
  // Establecer el valor del select al valor por defecto
  select.value = valorPorDefecto;
});

const selectTipo = document.querySelector('#tipo');
selectTipo.addEventListener('change', () => {
    const tipo = selectTipo.value;
    actualizarTablaClientes(tipo);
});

function actualizarTablaClientes(tipo) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch('http://127.0.0.1:8000/clientes/tipo', {
        method: 'POST',
        body: JSON.stringify({tipo: tipo}),
        headers: {
            'Content-Type': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        // Limpiar la tabla
        const tbody = document.querySelector('#table_clientes tbody');
        tbody.innerHTML = '';

        // Generar las filas de la tabla
        data.clientes.forEach(cliente => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${cliente.id}</td>
                <td>${cliente.nombreCliente}</td>
                <td>${cliente.direccion}</td>
                <td>${cliente.celular}</td>
                <td>${cliente.tipo}</td>
                <td class="acciones_table">
                    <a href="${Ziggy.routes['sistema.clientes.edit'].uri.replace('{cliente}', cliente.id)}">
                        <button class='btn-editar'>Editar</button>
                    </a>
                    <form action="${Ziggy.routes['sistema.clientes.destroy'].uri.replace('{cliente}', cliente.id)}" method="POST">
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

