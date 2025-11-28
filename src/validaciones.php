<?php
// Funciones de validación y saneamiento

function limpiar($s) {
    $s = trim($s);
    $s = strip_tags($s);
    return $s;
}

function validarTextoRequired($s) {
    return $s !== '';
}

function validarEmail($email) {
    if ($email === '') return 'El email es obligatorio.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return 'Email inválido.';
    return true;
}

function validarTelefono($tel) {
    if ($tel === '') return 'El teléfono es obligatorio.';
    $clean = preg_replace('/[ \-\.\(\)\+]/', '', $tel);
    if (!preg_match('/^[0-9]{7,15}$/', $clean)) return 'Teléfono inválido. Debe contener entre 7 y 15 dígitos.';
    return true;
}

function validarFechaAlta($fecha) {
    if ($fecha === '') return 'La fecha de alta es obligatoria.';
    $d = DateTime::createFromFormat('Y-m-d', $fecha);
    if (!($d && $d->format('Y-m-d') === $fecha)) return 'Formato de fecha inválido (YYYY-MM-DD).';
    $hoy = new DateTime('today');
    if ($d > $hoy) return 'La fecha de alta no puede ser futura.';
    return true;
}

function validarDni($dni) {
    $dni = strtoupper(str_replace([' ', '-'], '', $dni));
    if ($dni === '') return 'El DNI es obligatorio.';

    // DNI normal: 8 dígitos + 1 letra (cualquier letra válida)
    if (preg_match('/^[0-9]{8}[A-Z]$/', $dni)) {
        return true;
    }

    // NIE: X/Y/Z + 7 dígitos + letra final (cualquier letra)
    if (preg_match('/^[XYZ][0-9]{7}[A-Z]$/', $dni)) {
        return true;
    }

    return 'DNI/NIE con formato inválido. Formato DNI: 8 dígitos + 1 letra (ej: 12345678A). NIE: X/Y/Z + 7 dígitos + letra.';
}
