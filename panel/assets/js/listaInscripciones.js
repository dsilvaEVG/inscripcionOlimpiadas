document.addEventListener("DOMContentLoaded", function() {
    const idClase = document.querySelector('input[type="hidden"]').id; //idClase necesario para buscar en SQL

    const menuPrincipalBtn = document.getElementById("menuPrincipal"); //Boton para volver al menu principal

    menuPrincipalBtn.addEventListener("click", function() { //Funcion enlace a menu principal
        window.location.href = "index.php";
    });

    const selectElements = document.querySelectorAll('select'); //Apunta a todos los elementos <select>
   
    selectElements.forEach(select => {
        const idPrueba = select.id; // En el atributo id señalamos el idPrueba para las busquedas SQL
        const formData = new FormData();
        formData.append('idPrueba', idPrueba);
        formData.append('idClase', idClase);

        //Esta funcion nos busca al inicio el alumno inscrito a una prueba segun una clase 
        //(es el option por defecto. Si hay un alumno inscrito saldrá su nombre y si no, un mensaje que no hay alumno)
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
                        select.innerHTML = ''; // Limpiamos todas las opciones
                        const option = document.createElement('option');
                        option.textContent = result.mensaje; // El mensaje "No se encontraron alumnos"
                        option.disabled = true; // No puede ser seleccionada
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
        //Llamamos a la funcion para que me busque los inscritos de la clase
        buscarInscritos();
    })
       
    //Creamos un array donde vamos a guardar los valores de select
    const selectMarcados = [];

    //Creamos una función que utilizaremos para actualizar los valores de los select cada vez que cambiemos el valor de alguno de ellos
    function actualizarAlumnos() {
        selectMarcados.length = 0; // Cuando actualicemos, vaciamos el array
        selectElements.forEach(select => {
            const opcionMarcada = Array.from(select.options).find(option => option.selected);  //Metemos en un array todos los option del select y buscamos aquel que está seleccionado

            // Solo almacenamos el nombre del alumno si no es el mensaje de "No se encontraron alumnos"
            if (opcionMarcada && opcionMarcada.textContent !== "No se encontraron alumnos") { //Si hay opción seleccionada y no coincide con "No se encontraron alumnos" lo agregamos al array
                selectMarcados.push(opcionMarcada.textContent); // Almacenamos el nombre
            }
        });
        console.log(selectMarcados);  // Para ver el contenido del array
    }

    //Agregar un eventListener a todos los select para que se actualice el array al haber un cambio de valor
    selectElements.forEach(select =>{
        select.addEventListener('change', actualizarAlumnos);
    })

    //Al iniciar la página siempre cargaremos el array en primer lugar
    actualizarAlumnos();

    // Al hacer clic en todos los select, cargamos los alumnos en options nuevos
    selectElements.forEach(select => {

        select.addEventListener('click', async function() {
            const valorSelect = select.value; // Guardar el valor seleccionado previamente
            const formDataAlumnos = new FormData();
            formDataAlumnos.append('idClase', idClase);

            try {
                const responseAlumnos = await fetch('index.php?controlador=Inscripciones&accion=cListaClase', {
                    method: 'POST',
                    body: formDataAlumnos,
                });

                if (responseAlumnos.ok) {
                    const resultAlumnos = await responseAlumnos.json(); //Guardo la busqueda en resultAlumnos

                    // Buscamos en cada uno de los options que aparecen en el select. Borramos aquellos que no se encuentran seleccionados y que no digan "No se encontraron alumnos"
                    Array.from(select.options).forEach(option => {
                        if (!option.selected && option.textContent !== "No se encontraron alumnos") {
                            select.removeChild(option); //Evitamos duplicados de datos
                        }
                    });

                    // Filtramos y agregamos solo aquellos alumnos no marcados previamente
                    resultAlumnos.forEach(alumno => {
                        const nombreAlumno = alumno.nombre;

                        // Verificar si el alumno ya está marcado en selectMarcados
                        if (!selectMarcados.includes(nombreAlumno)) {
                            const option = document.createElement('option');
                            option.value = alumno.idAlumno;  // El valor será el ID
                            option.textContent = alumno.nombre;  // El texto será el nombre
                            select.appendChild(option);
                        }
                    });

                    // Restauramos el valor previamente seleccionado si está presente
                    if (valorSelect) {
                        select.value = valorSelect;
                    }
                }

            } catch (error) {
                console.error('Error al cargar los alumnos:', error);
            }
        });
    });
});
