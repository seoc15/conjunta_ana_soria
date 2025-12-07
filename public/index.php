<?php
// CORRECCIÓN CLAVE: Usamos __DIR__ para que Docker encuentre la ruta exacta
require_once(__DIR__ . '/src/datos.php');
require_once(__DIR__ . '/src/validaciones.php');
require_once(__DIR__ . '/src/vistas.php');

$errors = [];
$values = [
    'nombre' => '',
    'apellidos' => '',
    'dni' => '',
    'email' => '',
    'telefono' => '',
    'fecha_alta' => '',
    'provincia' => '',
    'sede' => '',
    'departamento' => ''
];

// Si hay datos POST, los procesamos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($values as $k => $v) {
        $values[$k] = isset($_POST[$k]) ? limpiar($_POST[$k]) : '';
    }

    // Validaciones
    if (!validarTextoRequired($values['nombre'])) $errors['nombre'] = 'El nombre es obligatorio.';
    if (!validarTextoRequired($values['apellidos'])) $errors['apellidos'] = 'Los apellidos son obligatorios.';
    
    $dniErr = validarDni($values['dni']);
    if ($dniErr !== true) $errors['dni'] = $dniErr;
    
    $emailErr = validarEmail($values['email']);
    if ($emailErr !== true) $errors['email'] = $emailErr;
    
    $telErr = validarTelefono($values['telefono']);
    if ($telErr !== true) $errors['telefono'] = $telErr;
    
    $fechaErr = validarFechaAlta($values['fecha_alta']);
    if ($fechaErr !== true) $errors['fecha_alta'] = $fechaErr;

    // Validar selects usando los arrays de datos.php
    if ($values['provincia'] === '' || !array_key_exists($values['provincia'], $provincias)) {
        $errors['provincia'] = 'Seleccione una provincia válida.';
    }
    if ($values['sede'] === '' || !array_key_exists($values['sede'], $sedes)) {
        $errors['sede'] = 'Seleccione una sede válida.';
    }
    if ($values['departamento'] === '' || !array_key_exists($values['departamento'], $departamentos)) {
        $errors['departamento'] = 'Seleccione un departamento válido.';
    }

    // Si no hay errores, mostramos la pantalla de éxito
    if (empty($errors)) {
        ?>
        <!doctype html>
        <html lang="es">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width,initial-scale=1">
            <title>Resumen de alta</title>
            <style>
                :root{ --bg:#0a0a0b; --accent:#00ff41; --glow:rgba(0,255,65,0.15) }
                *{box-sizing:border-box}
                body{margin:0;padding:28px;background:radial-gradient(circle at 5% 5%, rgba(0,255,65,0.04), transparent 8%), linear-gradient(180deg,var(--bg),#060607 60%);color:#fff;font-family:Inter,Arial,Helvetica,sans-serif;min-height:100vh}
                .container{max-width:900px;margin:0 auto}
                .success-card{background:linear-gradient(180deg, rgba(0,255,65,0.05), rgba(0,255,65,0.01));border:1px solid rgba(0,255,65,0.12);box-shadow:0 12px 50px var(--glow), 0 2px 8px rgba(0,0,0,0.6);padding:24px;border-radius:12px;animation:slideIn 0.5s ease-out}
                h1{color:var(--accent);font-size:1.6rem;text-shadow:0 0 20px rgba(0,255,65,0.3);margin-top:0}
                dl{display:grid;grid-template-columns:1fr 1fr;gap:12px 20px}
                dt{color:var(--accent);font-weight:700}
                dd{color:#bdbdbd;margin:0;padding:8px 12px;background:rgba(0,255,65,0.02);border-left:2px solid var(--accent);border-radius:4px}
                .lights{display:flex;gap:8px;justify-content:center;margin:20px 0}
                .lights span{width:12px;height:12px;border-radius:50%;background:var(--accent);box-shadow:0 0 12px rgba(0,255,65,0.8);animation:pulse 2s infinite}
                .lights span:nth-child(2){animation-delay:0.25s}
                .lights span:nth-child(3){animation-delay:0.5s}
                @keyframes pulse{0%{opacity:0.8}50%{opacity:1;filter:brightness(1.3)}100%{opacity:0.8}}
                @keyframes slideIn{0%{transform:translateY(20px);opacity:0}100%{transform:translateY(0);opacity:1}}
                a{color:var(--accent);text-decoration:none;font-weight:600;padding:10px 16px;border:1px solid rgba(0,255,65,0.3);border-radius:6px;display:inline-block;margin-top:16px}
            </style>
        </head>
        <body>
        <div class="container">
            <h1>✓ Empleado dado de alta</h1>
            <div class="lights"><span></span><span></span><span></span></div>
            <div class="success-card">
                <dl>
                    <dt>Nombre</dt><dd><?php echo htmlspecialchars($values['nombre']); ?></dd>
                    <dt>Apellidos</dt><dd><?php echo htmlspecialchars($values['apellidos']); ?></dd>
                    <dt>DNI</dt><dd><?php echo htmlspecialchars($values['dni']); ?></dd>
                    <dt>Email</dt><dd><?php echo htmlspecialchars($values['email']); ?></dd>
                    <dt>Teléfono</dt><dd><?php echo htmlspecialchars($values['telefono']); ?></dd>
                    <dt>Fecha Alta</dt><dd><?php echo htmlspecialchars($values['fecha_alta']); ?></dd>
                    <dt>Provincia</dt><dd><?php echo htmlspecialchars($provincias[$values['provincia']] ?? $values['provincia']); ?></dd>
                    <dt>Sede</dt><dd><?php echo htmlspecialchars($sedes[$values['sede']] ?? $values['sede']); ?></dd>
                    <dt>Departamento</dt><dd><?php echo htmlspecialchars($departamentos[$values['departamento']] ?? $values['departamento']); ?></dd>
                </dl>
                <a href="./">← Volver</a>
            </div>
        </div>
        </body>
        </html>
        <?php
        exit;
    }
}

function old($key, $values) {
    return isset($values[$key]) ? htmlspecialchars($values[$key]) : '';
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Alta de empleado</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;max-width:900px;margin:20px auto;padding:10px;background-color:#1e1e1e;color:#fff}
        .container{background:#252526;padding:20px;border-radius:8px;box-shadow:0 4px 6px rgba(0,0,0,0.3)}
        form{display:grid;grid-template-columns:1fr 1fr;gap:15px}
        .full{grid-column:1/3}
        label{display:block;font-weight:bold;margin-bottom:5px;color:#ccc}
        input, select{width:100%;padding:8px;background:#333;border:1px solid #555;color:#fff;border-radius:4px}
        .error{color:#ff6b6b;font-size:0.85em;margin-top:4px}
        button{background:#007acc;color:white;border:none;padding:10px 20px;cursor:pointer;border-radius:4px;font-size:1rem}
        button:hover{background:#005fa3}
        .header-title{font-size:1.5rem;margin-bottom:20px;border-bottom:1px solid #444;padding-bottom:10px}
    </style>
</head>
<body>
<div class="container">
    <div class="header-title">Formulario de alta de empleado</div>

    <?php if (!empty($errors)): ?>
        <div class="full error" style="margin-bottom:15px;padding:10px;background:rgba(255,0,0,0.1);border-radius:4px">
            Hay errores en el formulario. Por favor revíselos.
        </div>
    <?php endif; ?>

    <form method="post" action="" novalidate>
        <div>
            <label for="nombre">Nombre</label>
            <input id="nombre" name="nombre" type="text" value="<?php echo old('nombre', $values); ?>">
            <?php if (!empty($errors['nombre'])): ?><div class="error"><?php echo $errors['nombre']; ?></div><?php endif; ?>
        </div>

        <div>
            <label for="apellidos">Apellidos</label>
            <input id="apellidos" name="apellidos" type="text" value="<?php echo old('apellidos', $values); ?>">
            <?php if (!empty($errors['apellidos'])): ?><div class="error"><?php echo $errors['apellidos']; ?></div><?php endif; ?>
        </div>

        <div>
            <label for="dni">DNI</label>
            <input id="dni" name="dni" type="text" value="<?php echo old('dni', $values); ?>" placeholder="12345678A">
            <?php if (!empty($errors['dni'])): ?><div class="error"><?php echo $errors['dni']; ?></div><?php endif; ?>
        </div>

        <div>
            <label for="email">Correo electrónico</label>
            <input id="email" name="email" type="email" value="<?php echo old('email', $values); ?>">
            <?php if (!empty($errors['email'])): ?><div class="error"><?php echo $errors['email']; ?></div><?php endif; ?>
        </div>

        <div>
            <label for="telefono">Teléfono</label>
            <input id="telefono" name="telefono" type="text" value="<?php echo old('telefono', $values); ?>" placeholder="612345678">
            <?php if (!empty($errors['telefono'])): ?><div class="error"><?php echo $errors['telefono']; ?></div><?php endif; ?>
        </div>

        <div>
            <label for="fecha_alta">Fecha de alta</label>
            <input id="fecha_alta" name="fecha_alta" type="date" value="<?php echo old('fecha_alta', $values); ?>">
            <?php if (!empty($errors['fecha_alta'])): ?><div class="error"><?php echo $errors['fecha_alta']; ?></div><?php endif; ?>
        </div>

        <div>
            <label for="provincia">Provincia</label>
            <?php pintarSelectProvincias('provincia', $values['provincia']); ?>
            <?php if (!empty($errors['provincia'])): ?><div class="error"><?php echo $errors['provincia']; ?></div><?php endif; ?>
        </div>

        <div>
            <label for="sede">Sede</label>
            <?php pintarSelectSedes('sede', $values['sede']); ?>
            <?php if (!empty($errors['sede'])): ?><div class="error"><?php echo $errors['sede']; ?></div><?php endif; ?>
        </div>

        <div class="full">
            <label for="departamento">Departamento</label>
            <?php pintarSelectDepartamentos('departamento', $values['departamento']); ?>
            <?php if (!empty($errors['departamento'])): ?><div class="error"><?php echo $errors['departamento']; ?></div><?php endif; ?>
        </div>

        <div class="full" style="text-align:right;margin-top:10px">
            <button type="submit">Dar de alta</button>
        </div>
    </form>
</div>
</body>
</html>