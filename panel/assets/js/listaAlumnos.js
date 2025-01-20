
document.addEventListener("DOMContentLoaded", function() {
    // Obtener los elementos
    const altaAlumnoBtn = document.getElementById("altaAlumnoBtn");
    const formContainer = document.getElementById("formContainer");
    const altaAlumnoForm = document.getElementById("altaAlumnoForm");
    const idAlumnoInput = document.getElementById("idAlumno");
    const nombreInput = document.getElementById("nombre");
    const menuPrincipalBtn = document.getElementById("menuPrincipal");

    menuPrincipalBtn.addEventListener("click", function() {
        // Redirigir a 'index.php' al hacer clic en el botón
        window.location.href = "index.php";
    });

    function abrirFormulario(url){
        idClase.innerHTML='';
        fetch(url)
        .then(response => response.json())
        .then(data => {

            console.log(data);
            // Llenar el select con los datos obtenidos
            if (data && data.length > 0) {
                data.forEach(resultado => {
                    const option = document.createElement('option');
                    option.value = resultado.idClase;  // El valor será el ID
                    option.textContent = resultado.nomClase;  // El texto será el nombre
                    idClase.appendChild(option);
                });
            } else {
                const option = document.createElement('option');
                option.textContent = 'No se encontraron resultados';
                idClase.appendChild(option);
            }
        })
        .catch(error => {
            console.error('Error al realizar la búsqueda:', error);
        });
    }

    abrirFormulario('index.php?controlador=Clases&accion=cSelectClases');

    // Mostrar u ocultar el formulario cuando se haga clic en el botón
    altaAlumnoBtn.addEventListener("click", function() {
        formContainer.style.display = formContainer.style.display === "none" ? "block" : "none";
    });

    // Enviar el formulario con AJAX
    altaAlumnoForm.addEventListener("submit", async function(e) {
        e.preventDefault(); // Prevenir el comportamiento por defecto del formulario (recarga de página)

        const formData = new FormData(altaAlumnoForm);

        try {
            // Enviar los datos con fetch
            const response = await fetch("index.php?controlador=Alumnos&accion=cInsertAlumno", {
                method: "POST",
                body: formData
            });

            // Verificar que la respuesta fue exitosa
            if (response.ok) {
                const responseText = await response.text();

                if (responseText === "true") {
                    // Crear un nuevo párrafo con el mensaje "Resultado correcto"
                    const nuevoParrafo = document.createElement("p");
                    nuevoParrafo.textContent = "Resultado correcto"; // Mensaje de éxito

                    // Añadir el párrafo al cuerpo de la página
                    document.body.appendChild(nuevoParrafo);

                    // Recargar la página después de un corto retraso para ver el mensaje
                    setTimeout(() => {
                        location.reload(); // Recargar la página
                    }, 500); // Retraso de medio segundo antes de la recarga
                } else {
                    alert("Hubo un problema al insertar la prueba.");
                }
            } else {
                throw new Error("Hubo un problema con la solicitud.");
            }
        } catch (error) {
            alert(error.message); // Mostrar mensaje de error si ocurre algún problema
        }
});

});
