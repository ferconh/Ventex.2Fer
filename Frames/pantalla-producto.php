<?php
// Incluir el archivo de conexión
require_once('../php-servicios/Conexion_db/conexion_usser_select.php');

// Comprobar si la sesión está iniciada
session_start();
// if (!isset($_SESSION['id'])) {
//     // Si no hay sesión iniciada, redireccionar o manejar el caso según tus necesidades
//     // Por ejemplo, redireccionar a una página de inicio de sesión
//     header("Location: login.php");
//     exit;
// }

// Obtener el ID de usuario de la sesión
if (!isset($_POST['id_product'])) {
    $id_product = 5;
} else {
    $id_product = $_POST['id_product'];
}
//extraido desde el perfil con el boton del editar producto

// Preparar la consulta para obtener los datos del usuario
$sql = "SELECT Nombre_Prod, Descripcion, Precio, Categoria, Subcategoria, Id_usser_regristro,Imagen FROM productos WHERE ID_Producto = ?";
// Verificar si la preparación de la consulta tuvo éxito

$stmt = mysqli_prepare($Conexion_usser_select, $sql);
if (!$stmt) {
    exit('Error en la preparación de la consulta: ' . mysqli_error($Conexion_usser_select));
}
// Vincular parámetro(s) a la consulta preparada
mysqli_stmt_bind_param($stmt, "i", $id_product);

// Ejecutar la consulta preparada
mysqli_stmt_execute($stmt);

// Vincular variables a los resultados de la consulta
mysqli_stmt_bind_result($stmt, $Nombre_Prod, $Descripcion, $Precio, $Categoria, $Subcategoria, $id_Seller, $Imagen);

// Obtener los resultados
mysqli_stmt_fetch($stmt);

// Cerrar la consulta preparada
mysqli_stmt_close($stmt);


$sql2 = "SELECT Contact_description,profile_Description,instagram,x,whatsapp FROM seller_porfile WHERE Id_sellerP = ?";
// Verificar si la preparación de la consulta tuvo éxito


$stmt2 = mysqli_prepare($Conexion_usser_select, $sql2);
if (!$stmt2) {
    exit('Error en la preparación de la consulta: ' . mysqli_error($Conexion_usser_select));
}
// Vincular parámetro(s) a la consulta preparada
mysqli_stmt_bind_param($stmt2, "i", $id_Seller);

// Ejecutar la consulta preparada
mysqli_stmt_execute($stmt2);

// Vincular variables a los resultados de la consulta
mysqli_stmt_bind_result($stmt2, $Descripcion_contact, $profile_Description, $instagram, $x, $whatsapp);

// Obtener los resultados
mysqli_stmt_fetch($stmt2);

// Cerrar la consulta preparada
mysqli_stmt_close($stmt2);
$more = mysqli_query($Conexion_usser_select, "SELECT * FROM productos WHERE Categoria = '$Categoria' ORDER BY RAND() LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Producto</title>
    <link rel="stylesheet" href="../Styles/Styles-producto.css">
    <link rel="stylesheet" href="../Componentes/header.css">
    <link rel="stylesheet" href="../Componentes/footer.css">
    <link rel="stylesheet" href="../Componentes/cardProduct.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
<header>
        <section><p class="logo">Ventex</p></section>
        <nav>
            <ul class="menu">
                <li><a href="">Inicio</a></li>
                <li><a href="">Categoria</a></li>
                <li><a href="">Planes</a></li>
                <li><a href="">Vender</a></li>
            </ul>
        </nav>
        <form class="busqueda">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Buscar">
        </form>
        <section class="imgProfile">
            <div></div>
        </section>
    </header>
    <main>

    <!-- Parte principal que muestra el producto------------------------------------->

        <section class="contenedor-Producto">
            <section id="img-Producto">
                <img src="../Product-Images/<?php echo $Imagen ?>"> 
            </section>
            <article id="description">
                <section class="desc">
                    <h1 class="name-Product"><?php echo $Nombre_Prod ?></h1>
                    <span class="category"><?php echo $Categoria ?></span>
                    <span id="price-product">$<?php echo $Precio ?></span>

                    <span id="top">Top 5 en popularidad</span>
                    <span id="desc-Contacto"><?php echo $Descripcion_contact ?></span>
                    <span id="text-desc"><?php echo $Descripcion ?></span>
                    <form action="../Frames/pantalla-perfil-vc.php" method="post" id="form-seller">
                        <input type="hidden" name="Id_seller" value="<?php echo $id_Seller; ?>">
                        <input type="submit" id="bot" value="Ver perfil del vendedor">
                    </form>
                    <input type="submit" id="bot" value="Reportar Producto">


                </section>
            </article>
        </section>
<!-- ------------------------------------------------------------------------------ -->

<!-- Contedor de los productos relacionados --------------------------------------- -->

        <section class="container-moreProductos">
            <article class="textU">
                <h1 class="textorel">Productos Relacionados</h1>
            </article>
            <section class="cont">
                <?php while ($mostrar = mysqli_fetch_array($more)) { ?>

                    <form action="../Frames/pantalla-producto.php" method="post" id="form1">
                        <button class="producto" onclick="enviarFormulario()">
                            <input type="hidden" name="id_product" value="<?php echo $mostrar['ID_Producto']; ?>">
                            <section class="card"> <!--Esto contiene la informacion de un producto-->
                                <div class="image"><img src="../Product-Images/<?php echo $mostrar['Imagen']; ?>"></div>
                                    <span class="price">$<?php echo $mostrar['Precio'] ?></span>
                                    <span class="title"><?php echo $mostrar['Nombre_Prod'] ?></span>
                            </section>

                            <script>
                                function enviarFormulario() {
                                    document.getElementById('form1').submit();
                                }
                            </script>
                        </button>
                    </form>

                <?php } ?>
            </section>
        </section>
<!-- ---------------------------------------------------------------------------- -->

<!-- Contenedor Información de contacto -->

            <section class="cont-Contact">
                <article class="textU">
                    <h1>Informacion de contacto</h1>
                </article>
                <section class="part-Desc">
                    <article id="descriptionD">
                        <p class="text-Desc">
                            <?php echo $profile_Description ?>
                        </p>
                    </article>
                </section>
                <section class="part-Redes">
                    <article id="contacto">
                        <article class="redes">
                            <a href="<?php echo $instagram ?>"target="_blank" ><i class="fa-brands fa-instagram"></i></a>
                            <a href="<?php echo $whatsapp ?>" target="blank" ><i class="fa-brands fa-whatsapp"></i></a>
                            <a href="<?php echo $x ?>" target="blank"><i class="fa-brands fa-x-twitter"></i></a>
                        </article>
                    </article>
                </section>
            </section>
<!-- ---------------------------------------------------------------------------------- -->
<!-- Contenedor de la valoración -->

        <section class="cont-Valoracion">
            <section class="part-Comentarios">
                <section class="textU">
                    <h1>Deja un Comentario</h1>
                </section>
                <form id="inputVal" method="post" action="../php-servicios/save_data/save_new_comentario.php">
                    <input type="hidden" name="fecha_Coment" value="<?php echo date('Y-m-d'); ?>">
                    <input type="hidden" name="hora_comentario" value="<?php echo date('H:i:s'); ?>">
                    <input type="hidden" name="id_prod" value="<?php echo $id_product; ?>">
                    <input type="text" placeholder="Escribe una reseña del producto" name="descripcion" id="text-Comen">
                    <article class="input-Comentar"><input class="submit-Com" type="submit" value="Comentar"></article>
                </form>
            </section>
            
            <section class="part-Reseñas">
                <section class="textU">
                    <h1>Reseñas</h1>
                </section>
                <section class="contRes" id="contRes">

                </section>
            </section>
        </section>
        <form action="" method="post">
            <input type="hidden" value="<?php echo $id_product ?>" name="id_product" id="id_product">
        </form>
        <script>
            document.addEventListener("DOMContentLoaded", getData);

            function getData() {
                let input = document.getElementById("id_product").value;
                let content = document.getElementById("contRes");
                let url = "../php-servicios/load_data/load-info-comentarios-Pantalla-seller.php";
                let formData = new FormData();
                formData.append('id_product', input);

                fetch(url, {
                        method: "POST",
                        body: formData
                    }).then(response => response.text())
                    .then(data => {
                        console.log(data);
                        content.innerHTML = data;
                    }).catch(err => console.log(err));
            }
        </script>
    </main>

    <footer>
        <section class="con">
            <section class="name-year">
                <h1>2023-Ventex</h1>
            </section>
            <section class="logo-ventex">
                <h1>Ventex</h1>
            </section>
            <section class="socialmedia-ventex">
                <a href=""><i class="fa-brands fa-facebook"></i></a>
                <a href=""><i class="fa-brands fa-square-x-twitter"></i></a>
                <a href=""><i class="fa-brands fa-tiktok"></i></a>
            </section>
        </section>
        <section class="aviso">
            <span>Ventex no pide a través de SMS o de las redes sociales datos bancarios, tarjetas de crédito, clave NIP,
                contraseñas o datos sensibles de cualquier tipo. 
                <br>Si necesitas aclarar cualquier duda, puedes contactar con el Call Center en 800 225 5748.
            </span>
        </section>
    </footer>

</body>

</html>