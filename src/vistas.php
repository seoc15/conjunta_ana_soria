<?php
require_once __DIR__ . '/datos.php';

function pintarSelectProvincias($name = 'provincia', $selected = null) {
    global $provincias;
    echo "<select name=\"" . htmlspecialchars($name) . "\" id=\"" . htmlspecialchars($name) . "\">\n";
    echo "<option value=\"\">-- Seleccione --</option>\n";
    foreach ($provincias as $k => $v) {
        $sel = ($k === $selected) ? ' selected' : '';
        echo "<option value=\"" . htmlspecialchars($k) . "\"$sel>" . htmlspecialchars($v) . "</option>\n";
    }
    echo "</select>\n";
}

function pintarSelectSedes($name = 'sede', $selected = null) {
    global $sedes;
    echo "<select name=\"" . htmlspecialchars($name) . "\" id=\"" . htmlspecialchars($name) . "\">\n";
    echo "<option value=\"\">-- Seleccione --</option>\n";
    foreach ($sedes as $k => $v) {
        $sel = ($k === $selected) ? ' selected' : '';
        echo "<option value=\"" . htmlspecialchars($k) . "\"$sel>" . htmlspecialchars($v) . "</option>\n";
    }
    echo "</select>\n";
}

function pintarSelectDepartamentos($name = 'departamento', $selected = null) {
    global $departamentos;
    echo "<select name=\"" . htmlspecialchars($name) . "\" id=\"" . htmlspecialchars($name) . "\">\n";
    echo "<option value=\"\">-- Seleccione --</option>\n";
    foreach ($departamentos as $k => $v) {
        $sel = ($k === $selected) ? ' selected' : '';
        echo "<option value=\"" . htmlspecialchars($k) . "\"$sel>" . htmlspecialchars($v) . "</option>\n";
    }
    echo "</select>\n";
}
