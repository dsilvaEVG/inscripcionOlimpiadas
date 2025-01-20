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
        <h1>Listado de pruebas</h1>
        <button id="menuPrincipal">Menú Principal</button>
    </header>
    <main>
        <div>
            <table>
                <tr>
                    <th>Id. Prueba</th>
                    <th>Nombre Prueba</th>
                </tr>
                <?php
            if(count($dataToView["data"])>0){
                foreach($dataToView["data"] as $prueba){
                    ?>
                    <tr id="<?php echo $prueba["idPrueba"]; ?>">
                        <td><?php echo $prueba["idPrueba"]; ?></td> 
                        <td><?php echo $prueba["nombrePrueba"]; ?></td>                         
                    </tr>
                    <?php
                } 
            } else {
                ?>
                <tr><td colspan='4'>No hay pruebas disponibles</td></tr>
            <?php
            }
            ?>
            </table>
        </div>
        <button id="altaPruebaBtn">Alta prueba</button>
        <div id="formContainer" style="display: none;">
            <h2>Añadir nueva prueba</h2>
            <form id="altaPruebaForm">
                <label for="idPrueba">Id Prueba:</label>
                <input type="text" id="idPrueba" name="idPrueba" required><br><br>

                <label for="nombrePrueba">Nombre Prueba:</label>
                <input type="text" id="nombrePrueba" name="nombrePrueba" required><br><br>

                <button type="submit">Guardar</button>
            </form>
        </div>


    </main>
    <footer></footer>
    <script src="<?php echo JS.'pruebas.js'; ?>"></script>
</body>
</html>