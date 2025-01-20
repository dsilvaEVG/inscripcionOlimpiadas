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
        <h1>Listado de clases</h1>
        <button id="menuPrincipal">Menú Principal</button>
    </header>
    <main>
    <div>
            <table>
                <tr>
                    <th>Id. Clase</th>
                    <th>Nombre Clase</th>
                </tr>
                <?php
            if(count($dataToView["data"])>0){
                foreach($dataToView["data"] as $clase){
                    ?>
                    <tr id="<?php echo $clase["idClase"]; ?>">
                        <td><?php echo $clase["idClase"]; ?></td> 
                        <td><?php echo $clase["nomClase"]; ?></td>                         
                    </tr>
                    <?php
                } 
            } else {
                ?>
                <tr><td colspan='4'>No hay clases disponibles</td></tr>
            <?php
            }
            ?>
            </table>
        </div>
        <button id="altaClaseBtn">Alta clase</button>
        <div id="formContainer" style="display: none;">
            <h2>Añadir nueva clase</h2>
            <form autocomplete="off" id="altaClaseForm">
                <label for="idClase">Id Clase:</label>
                <input type="text" id="idClase" name="idClase" required><br><br>

                <label for="nomClase">Nombre Prueba:</label>
                <input type="text" id="nomClase" name="nomClase" required><br><br>

                <button type="submit">Guardar</button>
            </form>
        </div>
    </main>
    <footer></footer>
    <script src="<?php echo JS.'listaClases.js'; ?>"></script>
</body>
</html>