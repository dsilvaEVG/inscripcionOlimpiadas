<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Base de datos</title>
    <link rel="stylesheet" href="<?php echo CSS.'estilo.css'; ?>">
</head>

<body>
    <header>
        <h1>Clase <?php echo $_GET['nomClase']; ?></h1>
        <button id="menuPrincipal">Menú Principal</button>
    </header>
    <main>
        <div>
            <form>

            <?php
                if(count($dataToView["data"])>0){
                    foreach($dataToView["data"] as $prueba){
                        ?>
                        <label for="idPrueba<?php echo $prueba["idPrueba"];?>"><?php echo $prueba["nombrePrueba"]; ?></label>
                        <select id="<?php echo $prueba["idPrueba"];?>" name="idPrueba<?php echo $prueba["idPrueba"];?>"></select>
                        <br/><br/>
                        <?php
                    } 
                } else {
                    ?>
                    <tr><td colspan='4'>No hay pruebas en la base de datos</td></tr>
                <?php
                }
                ?>
                <input type="hidden" id="<?php echo $_GET['idClase']; ?>">
                <button type="submit">Modificar</button>
            </form>
        </div>
    </main>
    <footer></footer>
    <script src="<?php echo JS.'listaInscripciones.js'; ?>"></script>
</body>
</html>