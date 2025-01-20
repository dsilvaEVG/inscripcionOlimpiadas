document.getElementById('pruebas').addEventListener('click', function(){
    window.location.href = 'index.php?controlador=Pruebas&accion=cListaPruebas';
});
document.getElementById('clases').addEventListener('click', function(){
    window.location.href = 'index.php?controlador=Clases&accion=cListaClases';
});
document.getElementById('alumnos').addEventListener('click', function(){
    window.location.href = 'index.php?controlador=Alumnos&accion=cListaAlumnos';
});

document.getElementById('inscripcionesBtn').addEventListener('click', function(){

    const formContainer = document.getElementById("formContainer");
    const idInscrip = document.getElementById("idClase");
    const eligeClaseForm = document.getElementById("eligeClaseForm");
    // window.location.href = 'index.php?controlador=Continente&accion=cListadoContinentes';
    formContainer.style.display = formContainer.style.display === "none" ? "block" : "none";

    function abrirFormulario(urlBusqueda){
        idClase.innerHTML='';

        fetch(urlBusqueda)
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

eligeClaseForm.addEventListener('submit', function(){
    event.preventDefault();

    const idClaseSeleccionada = document.querySelector('select option:checked').value;
    // const nomClaseSeleccionada = idClase.textContent;
    let nomClaseSeleccionada = document.querySelector('select option:checked').textContent;
        

    if (idClaseSeleccionada) {
        window.location.href = `index.php?controlador=Inscripciones&accion=cListaInscripciones&idClase=${idClaseSeleccionada}&nomClase=${nomClaseSeleccionada}`;
    } else {
        alert("Por favor, selecciona una clase.");
    }
})
});







// document.getElementById('inscripciones').addEventListener('click', function(){
//     window.location.href = 'index.php?controlador=Continente&accion=cListadoContinentes';
// });