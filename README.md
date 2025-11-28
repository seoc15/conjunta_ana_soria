# 👨‍💻 Formulario de Alta de Empleado (Fase 1)

Este proyecto implementa la primera fase de un sistema de alta de empleados utilizando PHP puro. Se centra en el diseño de un formulario completo, la validación estricta de los datos y el uso de una estructura modularizada con funciones dedicadas para cada tarea.

## ✨ Características Principales

* **Formulario Completo:** Captura de datos esenciales del empleado.
* **Validación Robusta:** Verificación de formato y obligatoriedad de campos.
* **Estructura Modular:** Código separado en funciones y archivos para una fácil gestión y mantenimiento.
* **Desplegables Dinámicos:** Opciones de selección cargadas desde estructuras de datos en PHP.

## 📋 Campos del Formulario

El formulario de alta requiere los siguientes datos del nuevo empleado:

| Campo | Requisito | Notas |
| :--- | :--- | :--- |
| **Nombre** | Requerido | |
| **Apellidos** | Requerido | |
| **DNI** | Requerido | Validación estricta de formato. |
| **Correo Electrónico** | Requerido | Validación de formato de email. |
| **Teléfono** | Requerido | |
| **Fecha de Alta** | Requerido | |
| **Provincia** | Seleccionable | Datos cargados desde `src/datos.php`. |
| **Sede** | Seleccionable | Datos cargados desde `src/datos.php`. |
| **Departamento** | Seleccionable | Datos cargados desde `src/datos.php`. |

## ⚙️ Requisitos Técnicos y Estructura

El proyecto sigue una estructura mínima para asegurar la separación de responsabilidades (*Separation of Concerns*).

### 📁 Estructura del Proyecto


