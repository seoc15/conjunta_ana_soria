<?php
// Script de prueba para validar DNI
require_once __DIR__ . '/src/validaciones.php';

$ejemplos = [
    '12345678A',
    '77667777E',
    '33454556O',
    '12345678Z',  // Correcto esperado
    '77667777G',  // Correcto esperado
    '33454556M',  // Correcto esperado
];

$tabla = 'TRWAGMYFPDXBNJZSQVHLCKE';

echo "<h2>Validación de DNI - Ejemplos</h2>";
echo "<table border='1' cellpadding='8'>";
echo "<tr><th>DNI Ingresado</th><th>Números</th><th>Letra Ingresada</th><th>Posición (mod 23)</th><th>Letra Correcta</th><th>Resultado</th></tr>";

foreach ($ejemplos as $dni) {
    if (preg_match('/^([0-9]{8})([A-Z])$/', $dni, $m)) {
        $numeros = $m[1];
        $letra = $m[2];
        $posicion = intval($numeros) % 23;
        $correcta = $tabla[$posicion];
        $resultado = validarDni($dni);
        $status = ($resultado === true) ? '✓ Válido' : '✗ ' . $resultado;
        echo "<tr>";
        echo "<td>$dni</td>";
        echo "<td>$numeros</td>";
        echo "<td>$letra</td>";
        echo "<td>$posicion</td>";
        echo "<td>$correcta</td>";
        echo "<td>$status</td>";
        echo "</tr>";
    }
}
echo "</table>";
?>
