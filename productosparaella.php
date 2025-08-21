<?php
// Incluir el archivo de conexi\u00F3n a la base de datos
include 'conexion_db.php';

// --- CONSULTA PARA OBTENER LAS CATEGOR\u00CDAS DE PERFUMES FEMENINOS ---
// Necesitamos obtener las categor\u00EDas que est\u00E1n asociadas al g\u00E9nero Femenino.
// Seg\u00FAn tu tabla 'generos_perfumes', el ID para 'Femenino' es el 2.
$sql_categorias = "SELECT id_categoria, nombre_categoria FROM categorias WHERE id_genero_perfume = 2 ORDER BY nombre_categoria ASC"; // Ordenamos por nombre
$resultado_categorias = $conexion->query($sql_categorias);

?>
<html>

<head>
    <title>
        Perfumes para ella
    </title>
    <link rel="stylesheet" href="Productosparaella.css">
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
                        <li><a href="productosUnisex.php" class="bar">Perfumes Unisex</a></li>
                        <li><a href="productosArabes.php" class="bar">Perfumes Arabes</a></li>
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
                <center> Perfumes para ella </center>
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

    <div class="exploraesencias">
        <div class="esencias">
            <h2> Explora Nuestras Exquisitas Esencias </h2> <br>
            <p>En Olfato Perfumería, te ofrecemos una selección de fragancias únicas que se adaptan a tu personalidad y
                a
                cada ocasión. Desde aromas frescos y ligeros hasta los más intensos y envolventes, nuestras esencias
                están
                pensadas para brindarte una experiencia sensorial incomparable. A continuación, explora nuestras
                categorías
                y encuentra la fragancia perfecta para ti.
        </div> <br> <br>

        <div class="esenciasfotos">
            <div class="esencias3">
                <center> <img src="Contenido/LauProductos/Frutal2.webp"> </center>
                <center>
                    <h3> Frutal </h3>
                </center>
                <center>
                    <p> Fragancias frescas y dulces, con notas de frutas jugosas, ideales para un toque alegre y
                        vibrante.
                    </p>
                </center>
            </div>
            <div class="esencias3">
                <center> <img src="Contenido/LauProductos/Floral2.avif"> </center>
                <center>
                    <h3> Floral </h3>
                </center>
                <center>
                    <p> Aromas suaves y delicados, inspirados en las flores, perfectos para una fragancia fresca y
                        femenina.
                    </p>
                </center>
            </div>
            <div class="esencias3">
                <center> <img src="Contenido/LauProductos/orientales.jpg"> </center>
                <center>
                    <h3> Orientales </h3>
                </center>
                <center>
                    <p>Fragancias cálidas y exóticas, con notas especiadas y amaderadas, ideales para quienes buscan un
                        aroma intenso y misterioso.</p>
                </center>
            </div>

            <div class="esencias3">
                <center> <img src="Contenido/LauProductos/GourmandFondo2.jpg"> </center>
                <center>
                    <h3> Gourmand </h3>
                </center>
                <center>
                    <p> Notas dulces y cálidas, evocando aromas de alimentos deliciosos como vainilla, caramelo o
                        chocolate.</p>
                </center>
            </div>
        </div>
    </div>
    <div class="barra-busqueda">
        <input type="text" id="buscador-productos" placeholder="Buscar perfumes...">
        <button id="boton-buscar">
            <i class="fa-solid fa-search"></i>
        </button>
    </div>

    <?php
    // Verificar si se encontraron categorías femeninas
    if ($resultado_categorias && $resultado_categorias->num_rows > 0) {
        // --- Bucle principal: Recorrer cada CATEGORÍA ---
        while ($categoria = $resultado_categorias->fetch_assoc()) {
            // Mostrar el título de la categoría actual
    ?>
            <div class="orientalesfondo">
                <h3><?php echo htmlspecialchars($categoria['nombre_categoria']); ?></h3>
            </div>
            <?php

            // --- Consulta SECUNDARIA: Obtener PRODUCTOS para esta CATEGORÍA y el género Femenino ---
            $sql_productos_por_categoria = "SELECT id_producto, nombre, descripcion, imagen_url
                                      FROM productos
                                      WHERE id_genero_perfume = 2 -- Filtro por género FEMENINO (ID 2)
                                      AND id_categoria = " . $categoria['id_categoria'];
            $resultado_productos = $conexion->query($sql_productos_por_categoria);

            // --- Mostrar los PRODUCTOS de esta categoría ---
            ?>
            <section class="productos">
                <div class="seccionperfumes">
                    <?php
                    if ($resultado_productos && $resultado_productos->num_rows > 0) {
                        // --- Bucle ANIDADO: Recorrer cada PRODUCTO dentro de la categoría ---
                        while ($producto = $resultado_productos->fetch_assoc()) {
                    ?>
                            <div class="producto tarjetaperfumes"
                                data-id="<?php echo $producto['id_producto']; ?>"
                                data-nombre="<?php echo htmlspecialchars($producto['nombre']); ?>"
                                data-imagen="<?php echo htmlspecialchars($producto['imagen_url']); ?>"
                                data-descripcion="<?php echo htmlspecialchars($producto['descripcion']); ?>">
                                <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>
                                <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                <div class="cart-section">
                                    <button class="vista-rapida-btn" title="Vista rapida">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                    <button class="agregaralcarrito" data-id="<?php echo $producto['id_producto']; ?>">Agregar al carrito</button>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p>No se encontraron productos en esta categoría en este momento.</p>";
                    }
                    ?>
                </div>
            </section>
    <?php
        }
    } else {
        echo "<p>No se encontraron categorías de perfumes para ella en la base de datos.</p>";
    }
    ?>

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