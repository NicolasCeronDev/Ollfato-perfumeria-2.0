document.addEventListener('DOMContentLoaded', () => {
    // --- Selectores de Elementos ---
    const productos = document.querySelectorAll('.producto');
    const carritoLateral = document.querySelector('.carrito-lateral');
    const botonCerrarCarrito = document.querySelector('.cerrar-carrito');
    const carritoItemsDiv = document.querySelector('.carrito-items');
    const opcionesGlobales = document.querySelector('.opciones-globales-carrito');
    const cerrarOpcionesBtn = opcionesGlobales.querySelector('.cerrar-opciones');
    const agregarCarritoGlobalBtn = opcionesGlobales.querySelector('.agregar-al-carrito-global');
    const cantidadInputGlobal = opcionesGlobales.querySelector('#cantidad-global');
    const precioProductoGlobalElement = opcionesGlobales.querySelector('.precio-producto-global');
    const radiosTamanoGlobal = opcionesGlobales.querySelectorAll('input[type="radio"][name="tamano-global"]');
    const selectColorGlobal = opcionesGlobales.querySelector('#color-global');
    const finalizarCompraBtn = document.querySelector('.finalizar-compra');
    const abrirCarritoIcon = document.querySelector('.abrir-carrito-btn') || document.querySelector('.abrir-carrito-link');

    const buscadorProductos = document.getElementById('buscador-productos');
    let terminoBusquedaGlobal = '';

    buscadorProductos.addEventListener('input', (event) => {
        terminoBusquedaGlobal = event.target.value.toLowerCase();
        filtrarProductos(terminoBusquedaGlobal);
    });

    function filtrarProductos(termino) {
        productos.forEach(producto => {
            const nombreProducto = producto.dataset.nombre.toLowerCase();
            if (nombreProducto.includes(termino)) {
                producto.style.display = 'block'; // Mostrar el producto
            } else {
                producto.style.display = 'none'; // Ocultar el producto
            }
        });
    }

    // --- Estado del Carrito y Producto Seleccionado ---
    let carrito = localStorage.getItem('carrito') ? JSON.parse(localStorage.getItem('carrito')) : [];
    let productoSeleccionado = null;
    let opcionesMostradas = false;

    // --- Inicialización ---
    actualizarCarritoLateral();

    // --- Funciones de Interacción del Carrito ---

    // Función para abrir el carrito lateral
    function abrirCarrito() {
        carritoLateral.classList.add('abierto');
    }

    // Función para cerrar el carrito lateral
    function cerrarCarrito() {
        carritoLateral.classList.remove('abierto');
    }

    // Función para guardar el carrito en el localStorage
    function guardarCarrito() {
        localStorage.setItem('carrito', JSON.stringify(carrito));
    }

    // Función para actualizar la visualización del carrito lateral
    function actualizarCarritoLateral() {
        carritoItemsDiv.innerHTML = '';
        let subtotalCarrito = 0;
        if (carrito.length === 0) {
            // *** Línea para modificar el texto del carrito vacío ***
            const mensajeCarritoVacio = document.createElement('p');
            mensajeCarritoVacio.textContent = 'Tu carrito está vacío.';
            carritoItemsDiv.appendChild(mensajeCarritoVacio);
        } else {
            carrito.forEach((item, index) => {
                const itemDiv = crearElementoCarrito(item, index);
                carritoItemsDiv.appendChild(itemDiv);

                let precioConDescuento = item.precioUnitario;
                if (item.descuento > 0) {
                    const descuentoDecimal = item.descuento / 100;
                    precioConDescuento = item.precioUnitario * (1 - descuentoDecimal);

                    // Modificar el itemDiv para mostrar el precio original tachado
                    const precioOriginalElement = document.createElement('span');
                    precioOriginalElement.classList.add('precio-original');
                    precioOriginalElement.style.textDecoration = 'line-through';
                    precioOriginalElement.style.color = 'grey';
                    precioOriginalElement.style.marginRight = '5px';
                    precioOriginalElement.textContent = `$${item.precioUnitario.toFixed(2)}`;

                    const precioConDescuentoElement = itemDiv.querySelector('.item-precio');
                    precioConDescuentoElement.textContent = `Precio: $${precioConDescuento.toFixed(2)}`;
                    precioConDescuentoElement.prepend(precioOriginalElement);
                }

                subtotalCarrito += precioConDescuento * item.cantidad;
            });

            agregarSubtotalCarrito(subtotalCarrito);
        }
    }

    // Función para crear un elemento visual del carrito
    function crearElementoCarrito(item, index) {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('carrito-item');
        const precioTotalItem = item.precioUnitario * item.cantidad;
        itemDiv.innerHTML = `
            <div class="item-imagen"><img src="${item.imagenSrc}" alt="${item.nombre}"></div>
            <div class="item-nombre">${item.nombre}</div>
            <div class="item-detalle">Tamaño: ${item.tamano}</div>
            <div class="item-detalle">Color: ${item.color}</div>
            <div class="item-detalle">Cantidad: ${item.cantidad}</div>
            <div class="item-precio">Precio: $${precioTotalItem}</div>
            <button class="eliminar-item" data-index="${index}">Eliminar</button>
        `;
        const botonEliminar = itemDiv.querySelector('.eliminar-item');
        botonEliminar.addEventListener('click', () => eliminarItemCarrito(index));
        return itemDiv;
    }

    // Función para eliminar un item del carrito
    function eliminarItemCarrito(indexAEliminar) {
        carrito.splice(indexAEliminar, 1);
        guardarCarrito();
        actualizarCarritoLateral();
    }

    // Función para agregar el subtotal al carrito lateral
    function agregarSubtotalCarrito(subtotal) {
        const subtotalDiv = document.createElement('div');
        subtotalDiv.classList.add('carrito-subtotal');
        subtotalDiv.innerHTML = `<strong>Subtotal: $${subtotal}</strong>`;
        carritoItemsDiv.appendChild(subtotalDiv);
    }

    // --- Funciones de Interacción de Opciones Globales ---

    // Función para mostrar las opciones globales del producto
    function mostrarOpcionesGlobales(producto, event) {
        opcionesGlobales.style.display = 'flex';
        opcionesGlobales.style.opacity = '0';
        opcionesGlobales.style.transform = 'translateY(10px)';

        productoSeleccionado = producto;
        precioProductoGlobalElement.textContent = 'Precio: $0';
        cantidadInputGlobal.value = 1;
        radiosTamanoGlobal.forEach(radio => radio.checked = false);
        selectColorGlobal.value = '';

        const botonRect = event.target.getBoundingClientRect();
        const endTop = botonRect.bottom + window.scrollY - 462;
        const endLeft = botonRect.left + window.scrollX - (opcionesGlobales.offsetWidth / 3.56) + (botonRect.width / 3);
        const startTop = endTop + 20;
        const startLeft = endLeft;

        opcionesGlobales.style.top = `${startTop}px`;
        opcionesGlobales.style.left = `${startLeft}px`;

        setTimeout(() => {
            opcionesGlobales.style.transition = 'transform 0.3s ease-out, opacity 0.3s ease-out, top 0.3s ease-out, left 0.3s ease-out';
            opcionesGlobales.style.top = `${endTop}px`;
            opcionesGlobales.style.left = `${endLeft}px`;
            opcionesGlobales.style.opacity = '1';
            opcionesGlobales.style.transform = 'translateY(0)';
            opcionesMostradas = true;
        }, 10);
    }

    // Función para ocultar las opciones globales
    function ocultarOpcionesGlobales() {
        opcionesGlobales.style.display = 'none';
        opcionesGlobales.style.transform = 'translateY(0)';
        opcionesGlobales.style.transition = 'none';
        productoSeleccionado = null;
        opcionesMostradas = false;
    }

    // Función para agregar el producto al carrito desde las opciones globales
    function agregarProductoGlobalAlCarrito() {
        if (productoSeleccionado) {
            const nombre = productoSeleccionado.dataset.nombre;
            const cantidad = parseInt(cantidadInputGlobal.value);
            const tamanoSeleccionado = document.querySelector('input[name="tamano-global"]:checked');
            const colorSeleccionado = selectColorGlobal.value;
            let precioUnitario = 0;
            // Obtener el descuento del elemento HTML si existe
            const descuentoProducto = parseInt(productoSeleccionado.dataset.descuento || '0');


            if (tamanoSeleccionado) {
                if (colorSeleccionado) {

                    precioUnitario = parseFloat(tamanoSeleccionado.dataset.precio);
                    const nuevoItem = {
                        nombre: nombre,
                        cantidad: cantidad,
                        tamano: tamanoSeleccionado.value,
                        color: colorSeleccionado,
                        precioUnitario: precioUnitario,
                        imagenSrc: productoSeleccionado.querySelector('img').src,
                        descuento: descuentoProducto // Guardar el descuento
                    };

                    const indexExistente = carrito.findIndex(item =>
                        item.nombre === nuevoItem.nombre &&
                        item.tamano === nuevoItem.tamano &&
                        item.color === nuevoItem.color
                    );

                    if (indexExistente !== -1) {
                        carrito[indexExistente].cantidad += nuevoItem.cantidad;
                    } else {
                        carrito.push(nuevoItem);
                    }

                    guardarCarrito();
                    actualizarCarritoLateral();
                    ocultarOpcionesGlobales();
                    if (abrirCarritoIcon) {
                        abrirCarritoIcon.click();
                    }

                } else {
                    alert('Por favor, selecciona un color.');
                }
                } else {
                    alert('Por favor, selecciona un tamaño.');
                }
            }
        }

        // Función para actualizar el precio en las opciones globales
        function actualizarPrecioOpcionesGlobales() {
            const tamanoSeleccionado = document.querySelector('input[name="tamano-global"]:checked');
            if (tamanoSeleccionado) {
                precioProductoGlobalElement.textContent = `Precio: $${parseFloat(tamanoSeleccionado.dataset.precio) * parseInt(cantidadInputGlobal.value)}`;
            }
        }

        // --- Funciones de Vista Rápida ---

        // Función para mostrar el modal de vista rápida
        function mostrarVistaRapida(productoContenedor) {
            if (productoContenedor) {
                const nombre = productoContenedor.dataset.nombre;
                const imagenSrc = productoContenedor.dataset.imagen;
                const descripcion = productoContenedor.dataset.descripcion;

                modalVistaRapida.innerHTML = `
                <button class="cerrar-modal">&times;</button>
                <div class="modal-contenido">
                    <div class="modal-imagen">
                        ${imagenSrc ? `<img src="${imagenSrc}" alt="${nombre}">` : ''}
                    </div>
                    <div class="modal-detalles">
                        <h3>${nombre}</h3>
                        <p class="descripcion-producto">${descripcion}</p>
                        <div class="modal-acciones">
                            <button class="agregaralcarrito-modal">Agregar al carrito</button>
                        </div>
                    </div>
                </div>
            `;
                modalFondo.style.display = 'flex';

                const cerrarModalBtn = modalVistaRapida.querySelector('.cerrar-modal');
                cerrarModalBtn.addEventListener('click', ocultarVistaRapida);

                const agregarAlCarritoModalBtn = modalVistaRapida.querySelector('.agregaralcarrito-modal');
                if (agregarAlCarritoModalBtn) {
                    agregarAlCarritoModalBtn.addEventListener('click', () => {
                        const botonElegirOpciones = productoContenedor.querySelector('.agregaralcarrito:not(.agregaralcarrito-modal)');
                        if (botonElegirOpciones) {
                            botonElegirOpciones.click();
                        }
                        ocultarVistaRapida();
                    });
                }
            }
        }

        // Función para ocultar el modal de vista rápida
        function ocultarVistaRapida() {
            modalFondo.style.display = 'none';
        }

        // --- Event Listeners ---

        // Abrir carrito
        if (abrirCarritoIcon) {
            abrirCarritoIcon.addEventListener('click', abrirCarrito);
        }

        // Agregar producto (abrir opciones)
        productos.forEach(producto => {
            const botonCarrito = producto.querySelector('.agregaralcarrito');
            botonCarrito.addEventListener('click', (event) => mostrarOpcionesGlobales(producto, event));
        });

        // Cerrar opciones globales
        cerrarOpcionesBtn.addEventListener('click', ocultarOpcionesGlobales);

        // Agregar al carrito desde opciones globales
        agregarCarritoGlobalBtn.addEventListener('click', agregarProductoGlobalAlCarrito);

        // Cambiar cantidad en opciones globales (sumar)
        const cantidadSumarGlobalBtn = opcionesGlobales.querySelector('.cantidad-sumar-global');
        if (cantidadSumarGlobalBtn) {
            cantidadSumarGlobalBtn.addEventListener('click', () => {
                cantidadInputGlobal.value = parseInt(cantidadInputGlobal.value) + 1;
                actualizarPrecioOpcionesGlobales(); //actualizar precio al sumar
            });
        }

        // Cambiar cantidad en opciones globales (restar)
        const cantidadRestarGlobalBtn = opcionesGlobales.querySelector('.cantidad-restar-global');
        if (cantidadRestarGlobalBtn) {
            cantidadRestarGlobalBtn.addEventListener('click', () => {
                const currentValue = parseInt(cantidadInputGlobal.value);
                if (currentValue > 1) {
                    cantidadInputGlobal.value = currentValue - 1;
                    actualizarPrecioOpcionesGlobales(); // Actualizar precio al restar
                }
            });
        }

        // Actualizar precio al cambiar tamaño en opciones globales
        radiosTamanoGlobal.forEach(radio => {
            radio.addEventListener('change', actualizarPrecioOpcionesGlobales);
        });

        // Actualizar precio al cambiar cantidad en opciones globales
        cantidadInputGlobal.addEventListener('input', actualizarPrecioOpcionesGlobales);

        // Cerrar carrito lateral
        botonCerrarCarrito.addEventListener('click', cerrarCarrito);

        // Finalizar compra
        finalizarCompraBtn.addEventListener('click', () => {
            guardarCarrito();
            window.location.href = 'finalizar-compra.html';
        });

        // --- Event Listeners de Búsqueda  ---
        const lupaBoton = document.querySelector('.barra-busqueda #boton-buscar'); // Selecciona el botón de la lupa

        lupaBoton.addEventListener('click', () => {
            if (terminoBusquedaGlobal) {
                const primerCoincidencia = Array.from(productos).find(producto =>
                    producto.dataset.nombre.toLowerCase().includes(terminoBusquedaGlobal) && producto.style.display !== 'none'
                );

                if (primerCoincidencia) {
                    primerCoincidencia.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
        // --- Event Listeners de Vista Rápida ---

        const vistaRapidaBtns = document.querySelectorAll('.vista-rapida-btn');
        const modalFondo = document.createElement('div');
        modalFondo.classList.add('modal-fondo');
        const modalVistaRapida = document.createElement('div');
        modalVistaRapida.classList.add('modal-vista-rapida');
        modalFondo.appendChild(modalVistaRapida);
        document.body.appendChild(modalFondo);

        vistaRapidaBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const productoContenedor = btn.closest('.producto');
                mostrarVistaRapida(productoContenedor);
            });
        });

        window.addEventListener('click', (event) => {
            if (event.target === modalFondo) {
                ocultarVistaRapida();
            }
        });

    });