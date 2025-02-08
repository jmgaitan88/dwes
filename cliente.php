<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="estilos.css" rel="stylesheet" type="text/css" />
    <title>Tarea 9</title>
 <body>
    <header>
        <h1 id="titulo">Pokémon</h1>
    </header>
    <section>
        <?php
        // Si se ha hecho una peticion que busca informacion de un autor "get_datos_autor" a traves de su "id"...
        if (isset($_GET["action"]) && isset($_GET["name"]) && $_GET["action"] == "get_datos_pokemon") 
        {
            //Se realiza la peticion a la api que nos devuelve el JSON con la información de los autores
            $app_info = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $_GET["name"]);
            // Se decodifica el fichero JSON y se convierte a array
            $app_info = json_decode($app_info);
            ?>
            <h1> <?php echo $app_info->name ?> </h1>
        
            <h2> Tipo </h2>
            <ul> 
                <?php foreach($app_info->types as $type): ?>

                    <li>
                        <?php echo $type->type->name ?>
                    </li>

                <?php endforeach; ?>    
            
            </ul>
            
            <h2> Habilidades </h2>
            <ul> 
                <?php foreach($app_info->abilities as $ability): ?>

                    <li>
                        <?php echo $ability->ability->name ?>
                    </li>

                <?php endforeach; ?>    
            
            </ul>
            
            <h2> Movimientos </h2>

            <ul>
                <?php foreach($app_info->moves as $move): ?>
                    <li>
                        <?php echo $move->move->name ?>
                    </li>
                <?php endforeach; ?>
            </ul>


            <br />
            <!-- Enlace para volver a la lista de autores -->
            <a id="volver" href="http://localhost/Tarea9DWES/cliente.php" alt="Lista de pokemon">Volver a la lista de todos los pokemon</a>
        <?php
        }
        else //sino muestra la lista de los Pokémon
        {   
            $offset = 0;
            if(isset($_GET["offset"])){
                $offset = $_GET["offset"];
            }
            $limit = 20;
            // Pedimos al la api que nos devuelva una lista de libros. La respuesta se da en formato JSON
            $lista_pokemon = file_get_contents('https://pokeapi.co/api/v2/pokemon?offset='.$offset.'&limit='.$limit);
            // Convertimos el fichero JSON en array
            
            $lista_pokemon = json_decode($lista_pokemon);
        ?>
            <ul>
            <!-- Mostramos una entrada por cada libros -->
            <?php foreach($lista_pokemon->results as $pokemon): ?>
                <li class="listapokemon" >
                    <!-- Enlazamos cada pokemon de libro con su informacion (primer if) -->
                    <a class="enlacepokemon" href="<?php echo "http://localhost/Tarea9DWES/cliente.php?action=get_datos_pokemon&name=" . $pokemon->name  ?>">
                    <?php echo $pokemon->name ?>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>
            <br>
            <?php
                if($lista_pokemon->previous){ ?>
                    <a href="http://localhost/Tarea9DWES/cliente.php?offset=<?php echo $offset - $limit; ?>" class="botones">Anterior</a>
                <?php } ?>
                
                <?php if($lista_pokemon->next){ ?>
                    <a href="http://localhost/Tarea9DWES/cliente.php?offset=<?php echo $offset + $limit; ?>" class="botones">Siguiente</a>
                <?php }
            ?>
            


        <?php
        } ?>
    </section>
    <footer>
        <h2 id="footer">Elaborado por: Juan Manuel Gaitan Padilla</h2>
    </footer>

 </body>
</html>
