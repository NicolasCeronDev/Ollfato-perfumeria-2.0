<?php
// Incluir el archivo de conexi\u00F3n
include 'conexion_db.php';

// --- CONSULTAS A LA BASE DE DATOS ---

// Consulta para "M\u00E1s Vendidos" (primeros 8)
$sql_mas_vendidos = "SELECT id_producto, nombre, descripcion, imagen_url FROM productos LIMIT 8";
$resultado_mas_vendidos = $conexion->query($sql_mas_vendidos);

// Consulta para "Nuevas Fragancias" (\u00faltimos 8 agregados por ID)
$sql_nuevos = "SELECT id_producto, nombre, descripcion, imagen_url FROM productos ORDER BY id_producto DESC LIMIT 8"; // <--- AHORA LIMIT 8
$resultado_nuevos = $conexion->query($sql_nuevos);

// Consulta para "Ofertas" (productos con id_oferta, uniendo para descuento, limitando a 8)
$sql_ofertas = "SELECT p.id_producto, p.nombre, p.descripcion, p.imagen_url, o.valor_descuento, o.tipo_descuento
                FROM productos p
                JOIN ofertas o ON p.id_oferta = o.id_oferta
                WHERE p.id_oferta IS NOT NULL
                LIMIT 8"; // <--- AHORA LIMIT 8
$resultado_ofertas = $conexion->query($sql_ofertas);
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Productos - Ollfato Perfumería</title>
    <link rel="stylesheet" href="Productos.css">
    <link rel="stylesheet" href="General.css">
    <link rel="stylesheet" href="Carrito.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <header class="Header">
        <div class="seccionPrincipal">
            <nav class="navbar">
                <div class="Logo">
                    <a href="Index.html">
                        <img src="Contenido/Logotipos/LogoSinfondo.png" width="80" alt="Aqui va el Logo">
                    </a>
                </div>
                <div>
                    <ul>
                        <li><a href="Index.html" class="bar">Inicio</a></li>
                        <li><a href="Productos.php" class="bar">Productos</a></li>
                        <li><a href="#footer" class="bar">Contacto</a></li>
                        <li><a href="Emprende.html" class="bar">Emprende </a></li>
                    </ul>
                </div>
                <div class="CarritoNav">
                    <button class="abrir-carrito-btn">
                        <img src="Contenido/Logotipos/carrito-de-compras.png" width="22px">
                    </button>
                </div>
            </nav>
            <div class="Titulo_1">
                <h1> Productos</h1>
            </div>
        </div>
    </header>

    <div class="Asesoria">
        <a href="https://wa.me/573162385351" class="whatsapp-icon" target="_blank">
            <img src="Contenido/Logotipos/whatsapp.png" alt="WhatsApp">
        </a>
        <div class="pppWhatsapp">
            <p>
            <h4> Obten Asesoria</h4>
            <h6>¡Gratis y personalizada!</h6>
            </p>
        </div>
    </div>

    <a href="#" class="flechaArriba">
        <img src="Contenido/Logotipos/punta-de-flecha-hacia-arriba.png" alt="flecha">
    </a>

    <!--link volver-->
    <div class="volver"><a href="Index.html" class="linkVolver"><- volver</a></div>
    <!--Que estas buscando -->

    <section id="Categorias">
        <div class="banner">
            <h1>¿Que estas buscando?</h1>
            <Div class="contCategoria">
                <div class="categoria">
                    <a href="productosparael.php">
                        <img src="Contenido/Perfumes/CategoriasFondos/ParaEllos.jpg" alt="Para ellos"
                            class="imgCategorias">
                    </a>
                    <button onclick="window.location.href='productosparael.php'">Para Ellos</button>
                </div>

                <div class="categoria">
                    <a href="productosparaella.php">
                        <img src="Contenido/Perfumes/CategoriasFondos/ParaEllas.jpg" alt="Para ellos"
                            class="imgCategorias">
                    </a>
                    <button onclick="window.location.href='productosparaella.php'">Para Ellas</button>
                </div>

                <div class="categoria">
                    <a href="productosUnisex.php">
                        <img src="Contenido/Perfumes/CategoriasFondos/Unisex-.jpg" alt="Para ellos"
                            class="imgCategorias">
                    </a>
                    <button onclick="window.location.href='productosUnisex.php'">Unisex</button>
                </div>

                <div class="categoria">
                    <a href="productosArabes.php">
                        <img src="Contenido/Perfumes/CategoriasFondos/Arabes.jpg" alt="Arabes" class="imgCategorias">
                    </a>
                    <button onclick="window.location.href='productosArabes.php'">Arabes</button>
                </div>
            </Div>
        </div>
    </section>

    <!--Carrito de compras para el carrito-->
    <div class="opciones-globales-carrito">
        <button class="cerrar-opciones">X</button>
        <h3>Selecciona el tamaño:</h3>
        <label><input type="radio" name="tamano-global" value="30ml" data-precio="20000"> 30ml - $20.000</label><br>
        <label><input type="radio" name="tamano-global" value="60ml" data-precio="35000"> 60ml - $35.000</label><br>
        <label><input type="radio" name="tamano-global" value="100ml" data-precio="55000"> 100ml - $55.000</label><br>

        <h3>Selecciona el color del envase:</h3>
        <select id="color-global">
            <option value="">Selecciona un color</option>
            <option value="rojo">Rojo</option>
            <option value="fucsia">Fucsia</option>
            <option value="morado">Morado</option>
            <option value="azul">Azul</option>
            <option value="verde">Verde</option>
            <option value="dorado">Dorado</option>
            <option value="negro">Negro</option>
        </select>

        <h3>Cantidad:</h3>
        <div class="selector-cantidad-global">
            <button class="cantidad-restar-global">-</button>
            <input type="number" id="cantidad-global" value="1" min="1">
            <button class="cantidad-sumar-global">+</button>
        </div>
        <p class="precio-producto-global">Precio: $0</p>
        <button class="agregar-al-carrito-global">Agregar al carrito</button>
    </div>

    <div class="carrito-lateral">
        <button class="cerrar-carrito">X</button>
        <h2>Carrito de Compras</h2>
        <div class="carrito-items">
        </div>
        <button class="finalizar-compra">Finalizar Compra</button>
    </div>

    <script src="Carrito.js"></script>

    <!--fin Carrito-->

    <!--Oculto barra de busqueda que es irrelevante para esta subpagina-->
    <div class="ocultar-barra">
        <div class="barra-busqueda">
            <input type="text" id="buscador-productos" placeholder="Buscar perfumes...">
            <button id="boton-buscar">
                <i class="fa-solid fa-search"></i>
            </button>
        </div>
    </div>

  <section class="seccionMasVendidosyNuevosLanzamientos">
    <h2>Más Vendidos</h2>
    <div class="contenedor-slide">
        <?php
        // Verificar si la consulta de más vendidos devolvió resultados
        if ($resultado_mas_vendidos && $resultado_mas_vendidos->num_rows > 0) {
            // Recorrer cada fila y generar el HTML para cada producto
            while($fila = $resultado_mas_vendidos->fetch_assoc()) {
                ?>
                <div class="producto"
                    data-id="<?php echo $fila['id_producto']; ?>"
                    data-nombre="<?php echo htmlspecialchars($fila['nombre']); ?>"
                    data-imagen="<?php echo htmlspecialchars($fila['imagen_url']); ?>"
                    data-descripcion="<?php echo htmlspecialchars($fila['descripcion']); ?>">
                    <img src="<?php echo htmlspecialchars($fila['imagen_url']); ?>" height="200px" alt="<?php echo htmlspecialchars($fila['nombre']); ?>">
                    <h3><?php echo htmlspecialchars($fila['nombre']); ?></h3>
                    <div class="cart-section">
                        <button class="vista-rapida-btn" title="Vista rapida">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <button class="agregaralcarrito" data-id="<?php echo $fila['id_producto']; ?>">Agregar al carrito</button>
                    </div>
                </div>
                <?php
            }
        } else {
            // Mostrar un mensaje si no se encontraron productos
            echo "<p>No se encontraron productos más vendidos en este momento.</p>";
        }
        ?>
    </div>
</section>

<section class="seccionMasVendidosyNuevosLanzamientos2">
    <div class="New">
        <img src="Contenido/Logotipos/nuevo.png" alt="">
        <h2><br>Nuevas Fragancias</h2>
    </div>
    <div class="contenedor-slide">
        <?php
        // Verificar si la consulta de nuevos productos devolvió resultados
        if ($resultado_nuevos && $resultado_nuevos->num_rows > 0) {
            // Recorrer cada fila y generar el HTML para cada producto
            while($fila = $resultado_nuevos->fetch_assoc()) {
                ?>
                <div class="producto"
                    data-id="<?php echo $fila['id_producto']; ?>"
                    data-nombre="<?php echo htmlspecialchars($fila['nombre']); ?>"
                    data-imagen="<?php echo htmlspecialchars($fila['imagen_url']); ?>"
                    data-descripcion="<?php echo htmlspecialchars($fila['descripcion']); ?>">
                    <img src="<?php echo htmlspecialchars($fila['imagen_url']); ?>" height="200px" alt="<?php echo htmlspecialchars($fila['nombre']); ?>">
                    <h3><?php echo htmlspecialchars($fila['nombre']); ?></h3>
                    <div class="cart-section">
                        <button class="vista-rapida-btn" title="Vista rapida">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <button class="agregaralcarrito" data-id="<?php echo $fila['id_producto']; ?>">Agregar al carrito</button>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No se encontraron nuevos lanzamientos en este momento.</p>";
        }
        ?>
    </div>
</section>

    <!-- Repetir para cada producto -->

    <section id="NuestrasOfertas">
        <div style="background-color: #f5f5dcc2;">
            <br><br><br>
        </div>
        <h2 style="background-color: #f5f5dcc2;">Explora nuestras ofertas <br><br></h2>
        <div class="lista-productos">
            <?php
            // Verificar si la consulta de ofertas devolvió resultados
            // $resultado_ofertas proviene de la consulta que une productos con ofertas
            if ($resultado_ofertas && $resultado_ofertas->num_rows > 0) {
                // Recorrer cada fila de resultados (cada producto en oferta)
                while ($fila = $resultado_ofertas->fetch_assoc()) {
                    // Generar el HTML para CADA producto en oferta
            ?>
                    <div class="producto producto2"
                        data-id="<?php echo $fila['id_producto']; ?>"
                        data-nombre="<?php echo htmlspecialchars($fila['nombre']); ?>"
                        data-imagen="<?php echo htmlspecialchars($fila['imagen_url']); ?>"
                        data-descripcion="<?php echo htmlspecialchars($fila['descripcion']); ?>"
                        data-descuento="<?php echo htmlspecialchars($fila['valor_descuento']); // Usamos el valor del descuento para el data-descuento 
                                        ?>">
                        <div class="oferta-contenedor">
                            <div class="icono-descuento">
                                <span>-<?php echo htmlspecialchars(intval($fila['valor_descuento'])); ?>%</span>
                            </div>
                        </div>
                        <img src="<?php echo htmlspecialchars($fila['imagen_url']); ?>" alt="<?php echo htmlspecialchars($fila['nombre']); ?>">
                        <h3><?php echo htmlspecialchars($fila['nombre']); ?></h3>
                        <div class="cart-section">
                            <button class="vista-rapida-btn" title="Vista rapida">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            <button class="agregaralcarrito" data-id="<?php echo $fila['id_producto']; ?>">Agregar al carrito</button>
                        </div>
                    </div>
            <?php
                }
            } else {
                // Mensaje si no hay ofertas
                echo "<p>No se encontraron ofertas disponibles en este momento.</p>";
            }
            ?>
        </div>
        </div>


    </section>

    <footer id="footer">
        <div class="alineacion">
            <!-- Sección de contacto -->
            <div class="contact-section">
                <h3>Contáctanos</h3>
                <p>📍 Neiva, Colombia</p>
                <p>📱 WhatsApp: <a href="https://wa.me/573162385351">+57 (316) 4238 5351</a></p>
                <p>📧 Email: <a href="mailto:ventas@prosportcolombia.com">Olfato@PerfumeriaColombia.com</a></p>
            </div>
            <div class="social-icons">
                <div>
                    <h3>Síguenos</h3>
                </div>
                <div>
                    <a href="" target="_blank"><img src="Contenido/Logotipos/tik-tok.png" alt="Logo de Tik-tok"></a>
                    <a href="" target="_blank"><img src="Contenido/Logotipos/facebook.png" alt="Logo de facebook"></a>
                    <a href="https://www.instagram.com/olfato.perfumeria?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                        target="_blank"><img src="Contenido/Logotipos/instagram.png" alt="Logo de instagram"></a>
                </div>
            </div>
            <!-- Sección de políticas -->
            <div class="policies-section">
                <h3>Políticas del sitio</h3>
                <ul>
                    <li><a href="#">Términos & Condiciones</a></li>
                    <li><a href="#">Política de privacidad</a></li>
                    <li><a href="#">Política de cookies</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            &copy; 2025 Olfato Perfumería. Todos los derechos reservados. Descubre la elegancia en cada
            fragancia.
        </div>
    </footer>
    <script src="scroll-navbar.js"></script>
    <?php
    // Cerrar la conexi\u00F3n a la base de datos al final del archivo
    $conexion->close();
    ?>
</body>

</html>