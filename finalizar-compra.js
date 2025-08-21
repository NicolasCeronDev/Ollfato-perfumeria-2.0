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
    const botonFinalizarPedido = document.querySelector('.contenedor-finalizar-compra button[type="submit"]');

    function mostrarCarritoFinal() {
        carritoFinalItemsDiv.innerHTML = '';
        totalCompra = 0;
        
        if (carrito.length === 0) {
            const mensajeCarritoVacioFinal = document.createElement('p');
            mensajeCarritoVacioFinal.textContent = 'No tienes ningún producto en tu carrito para finalizar la compra.';
            carritoFinalItemsDiv.appendChild(mensajeCarritoVacioFinal);
            totalFinalElement.textContent = 'Total: $0';
            botonFinalizarPedido.disabled = true;
        } else {
            botonFinalizarPedido.disabled = false;
            carrito.forEach(item => {
                const itemDiv = document.createElement('div');
                itemDiv.classList.add('item-final');

                let precioUnitarioItem = parseFloat(item.precioUnitario);
                let precioFinalItem = precioUnitarioItem;
                let precioOriginalHTML = '';

                if (item.descuento && item.descuento > 0) {
                    const descuentoDecimal = parseFloat(item.descuento) / 100;
                    precioFinalItem = precioUnitarioItem * (1 - descuentoDecimal);
                    precioOriginalHTML = `<span style="text-decoration: line-through; color: grey; margin-right: 5px;">$${precioUnitarioItem.toFixed(2)}</span>`;
                }

                totalCompra += precioFinalItem * item.cantidad;

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
            });

            totalFinalElement.textContent = `Total: $${totalCompra.toFixed(2)}`;
        }

        const botonVolverAtras = document.getElementById('volverAtras');
        if (botonVolverAtras) {
            botonVolverAtras.addEventListener('click', (event) => {
                event.preventDefault();
                window.history.back();
            });
        }
    }

    function mostrarDetallesPago(metodo) {
        detallesTransferenciaDiv.style.display = 'none';
        detallesNequiDiv.style.display = 'none';
        detallesDaviplataDiv.style.display = 'none';
        detallesTarjetaDiv.style.display = 'none';
        detallesContraentregaDiv.style.display = 'none';
        detallesPagoDiv.style.display = 'none';

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

    botonFinalizarPedido.addEventListener('click', (event) => {
        event.preventDefault();

        const nombre = formularioFacturacion.nombre.value.trim();
        const email = formularioFacturacion.email.value.trim();
        const telefono = formularioFacturacion.telefono.value.trim();
        const direccion = formularioFacturacion.direccion.value.trim();
        const ciudad = formularioFacturacion.ciudad.value.trim();
        const barrio = formularioFacturacion.barrio.value.trim();
        const notas = formularioFacturacion.notas.value.trim();
        const metodoPago = metodoPagoSelect.value;

        const detallesPago = {};
        if (metodoPago === 'transferencia') {
            detallesPago.banco_transferencia = formularioPago['banco-transferencia'].value.trim();
            detallesPago.numero_cuenta_transferencia = formularioPago['numero-cuenta-transferencia'].value.trim();
            detallesPago.tipo_cuenta_transferencia = formularioPago['tipo-cuenta-transferencia'].value.trim();
            detallesPago.referencia_transferencia = formularioPago['referencia-transferencia'].value.trim();
        } else if (metodoPago === 'nequi') {
            detallesPago.numero_nequi = formularioPago['numero-nequi'].value.trim();
            detallesPago.nombre_nequi = formularioPago['nombre-nequi'].value.trim();
        } else if (metodoPago === 'daviplata') {
            detallesPago.numero_daviplata = formularioPago['numero-daviplata'].value.trim();
            detallesPago.nombre_daviplata = formularioPago['nombre-daviplata'].value.trim();
        } else if (metodoPago === 'tarjeta') {
            detallesPago.numero_tarjeta = formularioPago['numero-tarjeta'].value.trim();
            detallesPago.fecha_expiracion = formularioPago['fecha-expiracion'].value.trim();
            detallesPago.cvc = formularioPago['cvc'].value.trim();
            detallesPago.nombre_titular_tarjeta = formularioPago['nombre-titular-tarjeta'].value.trim();
        }

        const itemsCarritoParaEnviar = localStorage.getItem('carrito') ? JSON.parse(localStorage.getItem('carrito')) : [];

        const datosPedido = {
            cliente: {
                nombre: nombre,
                email: email,
                telefono: telefono,
                direccion: direccion,
                ciudad: ciudad,
                barrio: barrio,
                notas: notas
            },
            carrito: itemsCarritoParaEnviar,
            pago: {
                metodo: metodoPago,
                detalles: detallesPago
            },
            total: totalCompra
        };

        if (formularioFacturacion.checkValidity() && metodoPago !== "" && itemsCarritoParaEnviar.length > 0) {
            let pagoDetallesValidos = true;

            if (pagoDetallesValidos) {
                fetch('procesar_pedido.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(datosPedido)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => { throw new Error('Error HTTP ' + response.status + ': ' + text) });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        document.getElementById('modal-pedido-exito').style.display = 'block';
                        localStorage.removeItem('carrito');
                        mostrarCarritoFinal();
                    } else {
                        console.error('Error reportado por el servidor:', data.error);
                        alert('Hubo un error al procesar tu pedido: ' + (data.error || 'Error desconocido'));
                    }
                })
                .catch(error => {
                    console.error('Error en la solicitud Fetch o al procesar la respuesta:', error);
                    alert('Hubo un problema de comunicación con el servidor. Por favor, inténtalo de nuevo.');
                });
            }
        } else {
            alert('Por favor, completa todos los campos requeridos, selecciona un método de pago y asegúrate de tener productos en el carrito.');
        }
    });

    const modalPedidoExito = document.getElementById('modal-pedido-exito');
    const cerrarModal = document.querySelector('.cerrar-modal');
    const botonIrAInicio = document.getElementById('boton-ir-a-inicio');

    cerrarModal.addEventListener('click', () => {
        modalPedidoExito.style.display = 'none';
        window.location.href = 'Index.html';
    });

    botonIrAInicio.addEventListener('click', () => {
        modalPedidoExito.style.display = 'none';
        window.location.href = 'Index.html';
    });

    window.addEventListener('click', (event) => {
        if (event.target == modalPedidoExito) {
            modalPedidoExito.style.display = 'none';
            window.location.href = 'Index.html';
        }
    });
});