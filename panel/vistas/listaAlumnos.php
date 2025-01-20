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
                    <th>Id. Alumno</th>
                    <th>Nombre Alumno</th>
                    <th>Clase</th>
                </tr>
                <?php
            if(count($dataToView["data"])>0){
                foreach($dataToView["data"] as $alumno){
                    ?>
                    <tr id="<?php echo $alumno["idAlumno"]; ?>">
                        <td><?php echo $alumno["idAlumno"]; ?></td> 
                        <td><?php echo $alumno["nombre"]; ?></td>                         
                        <td><?php echo $alumno["nomClase"]; ?></td>                         
                    </tr>
                    <?php
                } 
            } else {
                ?>
                <tr><td colspan='4'>No hay alumnos en la base de datos</td></tr>
            <?php
            }
            ?>
            </table>
        </div>
        <button id="altaAlumnoBtn">Alta alumno</button>
        <div id="formContainer" style="display: none;">
            <br/>
            <h2>Añadir nueva clase</h2>
            <form autocomplete="off" id="altaAlumnoForm">
                <label for="idAlumno">Id Alumno:</label>
                <input type="text" id="idAlumno" name="idAlumno" required><br><br>

                <label for="nombre">Nombre Alumno:</label>
                <input type="text" id="nombre" name="nombre" required><br><br>

                <label for="idClase">Clase:</label>
                <select id="idClase" name="idClase">
                <!-- Las opciones se llenarán dinámicamente -->
                </select>

                <button type="submit">Guardar</button>
            </form>
        </div>
    </main>
    <footer></footer>
    <script src="<?php echo JS.'listaAlumnos.js'; ?>"></script>
</body>
</html>