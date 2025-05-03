document.addEventListener('DOMContentLoaded', () => {
    const carritoFinalItemsDiv = document.querySelector('.carrito-items-final');
    const totalFinalElement = document.querySelector('.total-final');
    const carrito = localStorage.getItem('carrito') ? JSON.parse(localStorage.getItem('carrito')) : [];
    let totalCompra = 0;
    const metodoPagoSelect = document.getElementById('metodo-pago');
    const detallesPagoDiv = document.getElementById('detalles-pago');
    const detallesTransferenciaDiv = document.getElementById('detalles-transferencia');
    const detallesNequiDiv = document.getElementById('detalles-nequi');
    const detallesDaviplataDiv = document.getElementById('detalles-daviplata');
    const detallesTarjetaDiv = document.getElementById('detalles-tarjeta');
    const detallesContraentregaDiv = document.getElementById('detalles-contraentrega');
    const formularioFacturacion = document.getElementById('formulario-facturacion');
    const formularioPago = document.getElementById('formulario-pago');
    const botonFinalizarPedido = document.querySelector('button[type="submit"]');

    function mostrarCarritoFinal() {
        carritoFinalItemsDiv.innerHTML = '';
        totalCompra = 0;
        if (carrito.length === 0) {
            // *** Línea para modificar el texto del carrito vacío en finalizar compra ***
            const mensajeCarritoVacioFinal = document.createElement('p');
            mensajeCarritoVacioFinal.textContent = 'No tienes ningún producto en tu carrito para finalizar la compra.';
            carritoFinalItemsDiv.appendChild(mensajeCarritoVacioFinal);
            totalFinalElement.textContent = `Total: $0`; // Asegurarse de mostrar el total en 0
        } else {
            carrito.forEach(item => {
                const itemDiv = document.createElement('div');
                itemDiv.classList.add('item-final');

                let precioFinalItem = parseFloat(item.precioUnitario); // Convertir a número
                let precioOriginalHTML = '';

                if (item.descuento > 0) {
                    const descuentoDecimal = parseFloat(item.descuento) / 100; // Convertir a número
                    precioFinalItem = item.precioUnitario * (1 - descuentoDecimal);
                    precioOriginalHTML = `<span style="text-decoration: line-through; color: grey; margin-right: 5px;">$${parseFloat(item.precioUnitario).toFixed(2)}</span>`;
                }
                itemDiv.innerHTML = `
                <div class="item-imagen-final"><img src="${item.imagenSrc}" alt="${item.nombre}"></div>
                <div class="item-info-final">
                    <div class="item-nombre-final">${item.nombre}</div>
                    <div class="item-detalle-final">Tamaño: ${item.tamano}</div>
                    <div class="item-detalle-final">Color: ${item.color}</div>
                    <div class="item-detalle-final">Cantidad: ${item.cantidad}</div>
      <div class="item-precio-final">Precio: ${precioOriginalHTML}$${precioFinalItem.toFixed(2)}</div>
                </div>
            `;
                carritoFinalItemsDiv.appendChild(itemDiv);
                totalCompra += item.precioUnitario * item.cantidad;
            });
            totalFinalElement.textContent = `Total: $${totalCompra.toFixed(2)}`;
        }
        const botonVolverAtras = document.getElementById('volverAtras');

        if (botonVolverAtras) {
            botonVolverAtras.addEventListener('click', (event) => {
                window.history.back();
            });
        }
    }

    function mostrarDetallesPago(metodo) {
        detallesPagoDiv.style.display = 'none';

        detallesTransferenciaDiv.style.display = 'none';
        detallesNequiDiv.style.display = 'none';
        detallesDaviplataDiv.style.display = 'none';
        detallesTarjetaDiv.style.display = 'none';
        detallesContraentregaDiv.style.display = 'none';

        if (metodo === 'transferencia') {
            detallesTransferenciaDiv.style.display = 'block';
        } else if (metodo === 'nequi') {
            detallesNequiDiv.style.display = 'block';
        } else if (metodo === 'daviplata') {
            detallesDaviplataDiv.style.display = 'block';
        } else if (metodo === 'tarjeta') {
            detallesTarjetaDiv.style.display = 'block';
        } else if (metodo === 'contraentrega') {
            detallesContraentregaDiv.style.display = 'block';
        } else {
            detallesPagoDiv.innerHTML = '<p>Por favor, selecciona un método de pago para ver los detalles.</p>';
            detallesPagoDiv.style.display = 'block';
        }
    }

    mostrarCarritoFinal();
    mostrarDetallesPago(metodoPagoSelect.value);

    metodoPagoSelect.addEventListener('change', (event) => {
        mostrarDetallesPago(event.target.value);
    });

    const modalPedidoExito = document.getElementById('modal-pedido-exito');
    const cerrarModal = document.querySelector('.cerrar-modal');
    const botonIrAInicio = document.getElementById('boton-ir-a-inicio');

    botonFinalizarPedido.addEventListener('click', () => {
        const nombre = formularioFacturacion.nombre.value;
        const email = formularioFacturacion.email.value;
        const telefono = formularioFacturacion.telefono.value;
        const direccion = formularioFacturacion.direccion.value;
        const ciudad = formularioFacturacion.ciudad.value;
        const barrio = formularioFacturacion.barrio.value;
        const notas = formularioFacturacion.notas.value;
        const metodoPago = metodoPagoSelect.value;

        const pedido = {
            items: carrito,
            total: totalCompra,
            nombre: nombre,
            email: email,
            telefono: telefono,
            direccion: direccion,
            ciudad: ciudad,
            barrio: barrio,
            notas: notas,
            metodoPago: metodoPago,
            fechaPedido: new Date().toISOString()
        };

        // Agregar detalles de pago al objeto pedido según el método seleccionado
        if (metodoPago === 'transferencia') {
            pedido.banco_transferencia = formularioPago['banco_transferencia'].value;
            pedido.numero_cuenta_transferencia = formularioPago['numero_cuenta_transferencia'].value;
            pedido.tipo_cuenta_transferencia = formularioPago['tipo_cuenta_transferencia'].value;
            pedido.referencia_transferencia = formularioPago['referencia_transferencia'].value;
        } else if (metodoPago === 'nequi') {
            pedido.numero_nequi = formularioPago['numero_nequi'].value;
            pedido.nombre_nequi = formularioPago['nombre_nequi'].value;
        } else if (metodoPago === 'daviplata') {
            pedido.numero_daviplata = formularioPago['numero_daviplata'].value;
            pedido.nombre_daviplata = formularioPago['nombre_daviplata'].value;
        } else if (metodoPago === 'tarjeta') {
            pedido.numero_tarjeta = formularioPago['numero_tarjeta'].value;
            pedido.fecha_expiracion = formularioPago['fecha_expiracion'].value;
            pedido.cvc = formularioPago['cvc'].value;
            pedido.nombre_titular_tarjeta = formularioPago['nombre_titular_tarjeta'].value;
        }

        if (formularioFacturacion.checkValidity() && formularioPago.checkValidity() && carrito.length > 0) {
            console.log('Pedido a enviar:', pedido);
            modalPedidoExito.style.display = 'block'; // Mostrar el modal
            localStorage.removeItem('carrito');
        } else {
            alert('Por favor, completa todos los campos requeridos y asegúrate de tener productos en el carrito.');
        }
    });
    cerrarModal.addEventListener('click', () => {
        modalPedidoExito.style.display = 'none';
        window.location.href = 'PagPrincipal.html'; // Redirigir al cerrar
    });

    botonIrAInicio.addEventListener('click', () => {
        modalPedidoExito.style.display = 'none';
        window.location.href = 'PagPrincipal.html'; // Redirigir al hacer clic en el botón
    });

    // Cerrar el modal si el usuario hace clic fuera de él
    window.addEventListener('click', (event) => {
        if (event.target == modalPedidoExito) {
            modalPedidoExito.style.display = 'none';
            window.location.href = 'PagPrincipal.html';
        }
    });
});