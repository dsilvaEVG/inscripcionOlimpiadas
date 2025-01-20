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
        <h1>Selecciona una tabla</h1>
    </header>
    <main>
        <div>
            <button id="pruebas">Pruebas</button>
            <button id="clases">Clases</button>
            <button id="alumnos">Alumnos</button>
            <button id="inscripcionesBtn">Inscripciones</button>
        </div>
        <div id="formContainer" style="display: none;">
            <h2>Elige clase</h2>
            <form id="eligeClaseForm">
                <label for="idClase">Elige Clase:</label>
                <select id="idClase" name="idClase" required>
                    <!-- Las opciones se agregarán dinámicamente con JavaScript -->
                </select><br><br>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </main>
    <footer></footer>
    <script src="<?php echo JS.'menuPrincipal.js'; ?>"></script>
</body>
</html>