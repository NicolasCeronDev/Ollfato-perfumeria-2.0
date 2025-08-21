<?php
// Incluir el archivo de conexi\u00F3n a la base de datos
include 'conexion_db.php';

// --- CONSULTA PARA OBTENER TODOS LOS PERFUMES \u00C1RABES ---
// Seg\u00FAn tu tabla 'generos_perfumes', el ID para 'Arabes' es el 4.
$sql_productos_arabes = "SELECT id_producto, nombre, descripcion, imagen_url
                        FROM productos
                        WHERE id_genero_perfume = 4"; // Filtra por g\u00E9nero \u00C1RABE (ID 4)
$resultado_productos_arabes = $conexion->query($sql_productos_arabes);

?>
<html>

<head>
    <title>
        Perfumes para el
    </title>
    <link rel="stylesheet" href="productosArabes.css">
    <link rel="stylesheet" href="Carrito.css">
    <link rel="stylesheet" href="General.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <header class="header">
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
                        <li><a href="productosparael.php" class="bar">Perfumes Para El</a></li>
                        <li><a href="productosparaella.php" class="bar">Perfumes Para Ella</a></li>
                        <li><a href="productosUnisex.php" class="bar">Perfumes Unisex</a></li>
                    </ul>
                </div>
                <div class="CarritoNav">
                    <button class="abrir-carrito-btn">
                        <img src="Contenido/Logotipos/carrito-de-compras.png" width="22px">
                    </button>
                </div>
            </nav>
        </div>

        <div class="titulo">
            <h1>
                <center> Perfumes Arabes </center>
            </h1>
            <p>
                En Olfato Perfumería, ofrecemos una exquisita selección de perfumes de las mejores marcas, diseñados
                para capturar la esencia de cada persona. Desde fragancias frescas y ligeras hasta aromas intensos y
                envolventes, tenemos el perfume perfecto para cada estilo y ocasión.
                Nuestra misión es brindarte una experiencia única de compra, donde la calidad, la elegancia y la
                sofisticación se combinan en cada frasco. <br> <br>

                ¡Haz que cada día sea memorable con un toque de fragancia única!</p>
        </div> <br> <br> <br>
    </header>
    <div class="barra-busqueda">
        <input type="text" id="buscador-productos" placeholder="Buscar perfumes...">
        <button id="boton-buscar">
            <i class="fa-solid fa-search"></i>
        </button>
    </div>
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

    <section class="productos">
        <div class="seccionperfumes">
            <?php
            // Verificar si se encontraron productos árabes
            if ($resultado_productos_arabes && $resultado_productos_arabes->num_rows > 0) {
                // --- Bucle: Recorrer cada PRODUCTO árabe ---
                while ($producto = $resultado_productos_arabes->fetch_assoc()) {
                    // Generar el HTML para cada producto
            ?>
                    <div class="producto tarjetaperfumes"
                        data-id="<?php echo $producto['id_producto']; ?>"
                        data-nombre="<?php echo htmlspecialchars($producto['nombre']); ?>"
                        data-imagen="<?php echo htmlspecialchars($producto['imagen_url']); ?>"
                        data-descripcion="<?php echo htmlspecialchars($producto['descripcion']); ?>">
                        <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>
                        <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <div class="cart-section">
                            <button class="vista-rapida-btn" title="Vista rápida">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            <button class="agregaralcarrito" data-id="<?php echo $producto['id_producto']; ?>">Agregar al carrito</button>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No se encontraron productos árabes en este momento.</p>";
            }
            ?>
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
    <script src="finalizar-compra.js"></script>
    <script src="scroll-navbar.js"></script>

    <!--fin Carrito-->
    <?php
    // Cerrar la conexi\u00F3n a la base de datos al final del archivo
    $conexion->close();
    ?>
</body>

</html>