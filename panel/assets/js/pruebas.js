
document.addEventListener("DOMContentLoaded", function() {
    // Obtener los elementos
    const altaPruebaBtn = document.getElementById("altaPruebaBtn");
    const formContainer = document.getElementById("formContainer");
    const altaPruebaForm = document.getElementById("altaPruebaForm");
    const idPruebaInput = document.getElementById("idPrueba");
    const nombrePruebaInput = document.getElementById("nombrePrueba");
    const menuPrincipalBtn = document.getElementById("menuPrincipal");

    menuPrincipalBtn.addEventListener("click", function() {
        // Redirigir a 'index.php' al hacer clic en el botón
        window.location.href = "index.php";
    });

    // Mostrar u ocultar el formulario cuando se haga clic en el botón
    altaPruebaBtn.addEventListener("click", function() {
        formContainer.style.display = formContainer.style.display === "none" ? "block" : "none";
    });

    // Enviar el formulario con AJAX
    altaPruebaForm.addEventListener("submit", async function(e) {
        e.preventDefault(); // Prevenir el comportamiento por defecto del formulario (recarga de página)

        const formData = new FormData(altaPruebaForm);

        try {
            // Enviar los datos con fetch
            const response = await fetch("index.php?controlador=Pruebas&accion=cInsertPrueba", {
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
                    }, 500); // Retraso de 1 segundo antes de la recarga
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
