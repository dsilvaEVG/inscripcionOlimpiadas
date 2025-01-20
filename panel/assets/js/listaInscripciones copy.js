document.addEventListener("DOMContentLoaded", function() {
    const idClase = document.querySelector('input[type="hidden"]').id; //idClase necesario para buscar en SQL

    const menuPrincipalBtn = document.getElementById("menuPrincipal"); //Boton para volver al menu principal

    menuPrincipalBtn.addEventListener("click", function() {
        window.location.href = "index.php";
    });

    const selectElements = document.querySelectorAll('select'); //Apunta a todos los elementos <select>
    let opcionesSeleccionadas = {};  // Objeto para almacenar las opciones seleccionadas (por idPrueba)

    selectElements.forEach(select => {
        const idPrueba = select.id; // En el atributo id señalamos el idPrueba para las busquedas SQL
        const formData = new FormData();
        formData.append('idPrueba', idPrueba);
        formData.append('idClase', idClase);

        // Variable para controlar si la búsqueda de alumnos ya se realizó
        let alumnosCargados = false;

        async function buscarInscritos() {
            try {
                const response = await fetch(`index.php?controlador=Inscripciones&accion=cBuscarInscritos`, {
                    method: 'POST',
                    body: formData,  
                });

                if (response.ok) {
                    const result = await response.json();

                    if (result.mensaje) {
                        // Si no hay alumnos, mostramos la opción "No hay alumnos"
                        const option = document.createElement('option');
                        option.textContent = result.mensaje;
                        option.disabled = true; // No puede ser seleccionada
                        option.selected = true; // Se selecciona por defecto
                        select.appendChild(option);
                    } else if (result.alumno) {
                        // Si hay un alumno, lo mostramos en un option
                        const option = document.createElement('option');
                        option.id = result.alumno.idAlumno;
                        option.textContent = result.alumno.nombre;
                        select.appendChild(option);
                    }
                }

            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Al hacer clic en el select, cargamos los alumnos si no se han cargado previamente
        select.addEventListener('click', async function() {
            if (!alumnosCargados) {
                // Si no se han cargado alumnos, se hace la búsqueda
                await buscarInscritos();
                
                // Ahora cargamos la lista de alumnos
                const formDataAlumnos = new FormData();
                formDataAlumnos.append('idClase', idClase);

                try {
                    const responseAlumnos = await fetch('index.php?controlador=Inscripciones&accion=cListaClase', {
                        method: 'POST',
                        body: formDataAlumnos,
                    });

                    if (responseAlumnos.ok) {
                        const resultAlumnos = await responseAlumnos.json();

                        // Limpiar las opciones previas (excepto el mensaje "No hay alumnos" si se mostró)
                        select.innerHTML = '';
                        if (resultAlumnos && resultAlumnos.length > 0) {
                            // Si hay alumnos, agregar las opciones correspondientes
                            resultAlumnos.forEach(alumno => {
                                // Verificamos si esta opción ya está seleccionada en otro select
                                if (!opcionesSeleccionadas[alumno.idAlumno]) {
                                    const option = document.createElement('option');
                                    option.value = alumno.idAlumno;  // El valor será el ID
                                    option.textContent = alumno.nombre;  // El texto será el nombre
                                    select.appendChild(option);
                                }
                            });
                        } else {
                            // Si no hay alumnos, agregar un mensaje
                            const option = document.createElement('option');
                            option.textContent = 'No se encontraron alumnos';
                            select.appendChild(option);
                        }
                    }

                } catch (error) {
                    console.error('Error al cargar los alumnos:', error);
                }

                // Marcar como cargado para evitar múltiples búsquedas
                alumnosCargados = true;
            }
        });

        // Al seleccionar una opción en el select
        select.addEventListener('change', function(event) {
            const selectedOption = event.target.value;
            if (selectedOption) {
                // Guardamos la opción seleccionada para que no se repita en los otros selects
                opcionesSeleccionadas[selectedOption] = true;
            }
        });

        // Llamada inicial para cargar la información (si es necesario)
        buscarInscritos(); 
    });
});
