El formulario de alta de empleado contendrá, como mínimo, los siguientes campos:
# Nombre
# Apellidos
# DNI
# Correo electrónico
# Teléfono
# Fecha de alta
# Provincia
# Sede
# Departamento
Para esta primera fase:
# Provincias, sedes y departamentos se cargarán desde arrays en PHP (no desde BD aún).
Al enviar el formulario:
# Se validan los campos.
# Si hay errores, se muestran mensajes claros al usuario.
# Si todo es correcto, se muestra un resumen de los datos introducidos (simulando el alta).
Requisitos técnicos
Uso de funciones en PHP para:
# Validar campos (validarDni(), validarEmail(), etc.).
# Limpiar/sanitizar entradas.
# Pintar opciones de desplegables (pintarSelectProvincias(), etc.).
# Estructura mínima del proyecto:
# public/index.php (formulario y control del flujo).
# src/validaciones.php (funciones de validación).
# src/datos.php (arrays de provincias, sedes, departamentos).
# src/vistas.php (si quieres que trabajen con vistas parciales).


