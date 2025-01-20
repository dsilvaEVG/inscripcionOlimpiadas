// Obtener todos los selects
const selects = document.querySelectorAll('select');

// Función para actualizar las opciones deshabilitadas en los selects
function updateSelects() {
  // Obtener todos los valores seleccionados de los selects
  const selectedValues = Array.from(selects).map(select => select.value);
  
  // Iterar sobre cada select
  selects.forEach(select => {
    // Iterar sobre cada opción del select actual
    for (let option of select.options) {
      // Si el valor de la opción está seleccionado en cualquiera de los selects, deshabilitarla
      if (selectedValues.includes(option.value) && select.value !== option.value) {
        option.disabled = true;
      } else {
        option.disabled = false;
      }
    }
  });
}

// Añadir el evento de cambio para cada select
selects.forEach(select => {
  select.addEventListener('change', updateSelects);
});

// Llamar a la función inicialmente para establecer el estado de las opciones
updateSelects();
