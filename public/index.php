<?php
require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/validaciones.php';
require_once __DIR__ . '/../src/vistas.php';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($values as $k => $v) {
        $values[$k] = isset($_POST[$k]) ? limpiar($_POST[$k]) : '';
    }

    if (!validarTextoRequired($values['nombre'])) {
        $errors['nombre'] = 'El nombre es obligatorio.';
    }
    if (!validarTextoRequired($values['apellidos'])) {
        $errors['apellidos'] = 'Los apellidos son obligatorios.';
    }
    $dniErr = validarDni($values['dni']);
    if ($dniErr !== true) {
        $errors['dni'] = $dniErr;
    }
    $emailErr = validarEmail($values['email']);
    if ($emailErr !== true) {
        $errors['email'] = $emailErr;
    }
    $telErr = validarTelefono($values['telefono']);
    if ($telErr !== true) {
        $errors['telefono'] = $telErr;
    }
    $fechaErr = validarFechaAlta($values['fecha_alta']);
    if ($fechaErr !== true) {
        $errors['fecha_alta'] = $fechaErr;
    }

    if ($values['provincia'] === '' || !array_key_exists($values['provincia'], $provincias)) {
        $errors['provincia'] = 'Seleccione una provincia válida.';
    }
    if ($values['sede'] === '' || !array_key_exists($values['sede'], $sedes)) {
        $errors['sede'] = 'Seleccione una sede válida.';
    }
    if ($values['departamento'] === '' || !array_key_exists($values['departamento'], $departamentos)) {
        $errors['departamento'] = 'Seleccione un departamento válido.';
    }

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
                .success-card{background:linear-gradient(180deg, rgba(0,255,65,0.05), rgba(0,255,65,0.01));border:1px solid rgba(0,255,65,0.12);box-shadow:0 12px 50px var(--glow), 0 2px 8px rgba(0,0,0,0.6);padding:24px;border-radius:12px;transform:translateY(0);animation:slideIn 0.5s ease-out}
                h1{color:var(--accent);font-size:1.6rem;text-shadow:0 0 20px rgba(0,255,65,0.3);margin-top:0;letter-spacing:1px}
                dl{display:grid;grid-template-columns:1fr 1fr;gap:12px 20px}
                dt{color:var(--accent);font-weight:700;font-size:0.95rem}
                dd{color:#bdbdbd;margin:0;padding:8px 12px;background:rgba(0,255,65,0.02);border-left:2px solid var(--accent);border-radius:4px}
                .lights{display:flex;gap:8px;justify-content:center;margin:20px 0}
                .lights span{width:12px;height:12px;border-radius:50%;background:var(--accent);box-shadow:0 0 12px rgba(0,255,65,0.8), 0 0 24px rgba(0,255,65,0.2);animation:pulse 2s infinite}
                .lights span:nth-child(1){animation-delay:0s}
                .lights span:nth-child(2){animation-delay:0.25s}
                .lights span:nth-child(3){animation-delay:0.5s}
                @keyframes pulse{0%{transform:translateY(0);opacity:0.8}50%{transform:translateY(-8px);opacity:1;filter:brightness(1.3)}100%{transform:translateY(0);opacity:0.8}}
                @keyframes slideIn{0%{transform:translateY(20px);opacity:0}100%{transform:translateY(0);opacity:1}}
                a{color:var(--accent);text-decoration:none;font-weight:600;transition:all 0.3s ease;padding:10px 16px;border:1px solid rgba(0,255,65,0.3);border-radius:6px;display:inline-block;margin-top:16px}
                a:hover{box-shadow:0 6px 20px rgba(0,255,65,0.15);transform:translateY(-2px)}
                @media (max-width:768px){
                    body{padding:18px}
                    .container{max-width:100%}
                    .success-card{padding:18px;border-radius:10px}
                    h1{font-size:1.3rem}
                    dl{grid-template-columns:1fr;gap:10px}
                    dt{font-size:0.9rem}
                    dd{font-size:0.9rem;padding:6px 10px}
                    .lights{gap:6px;margin:16px 0}
                    .lights span{width:10px;height:10px}
                    a{padding:8px 12px;font-size:0.9rem}
                }
                @media (max-width:480px){
                    body{padding:12px}
                    .container{max-width:100%}
                    .success-card{padding:14px;border-radius:8px}
                    h1{font-size:1.1rem;letter-spacing:0.5px}
                    dl{grid-template-columns:1fr;gap:8px}
                    dt{font-size:0.85rem}
                    dd{font-size:0.85rem;padding:6px 10px}
                    .lights{gap:5px;margin:12px 0}
                    .lights span{width:8px;height:8px;box-shadow:0 0 8px rgba(0,255,65,0.6), 0 0 16px rgba(0,255,65,0.15)}
                    a{padding:8px 12px;font-size:0.85rem;width:100%;text-align:center}
                }
            </style>
        </head>
        <body>
        <div class="container">
            <h1>✓ Empleado dado de alta</h1>
            <div class="lights">
                <span></span><span></span><span></span>
            </div>
            <div class="success-card">
                <dl>
                    <dt>Nombre</dt><dd><?php echo htmlspecialchars($values['nombre']); ?></dd>
                    <dt>Apellidos</dt><dd><?php echo htmlspecialchars($values['apellidos']); ?></dd>
                    <dt>DNI</dt><dd><?php echo htmlspecialchars($values['dni']); ?></dd>
                    <dt>Correo electrónico</dt><dd><?php echo htmlspecialchars($values['email']); ?></dd>
                    <dt>Teléfono</dt><dd><?php echo htmlspecialchars($values['telefono']); ?></dd>
                    <dt>Fecha de alta</dt><dd><?php echo htmlspecialchars($values['fecha_alta']); ?></dd>
                    <dt>Provincia</dt><dd><?php echo htmlspecialchars($provincias[$values['provincia']]); ?></dd>
                    <dt>Sede</dt><dd><?php echo htmlspecialchars($sedes[$values['sede']]); ?></dd>
                    <dt>Departamento</dt><dd><?php echo htmlspecialchars($departamentos[$values['departamento']]); ?></dd>
                </dl>
                <a href="../">← Volver</a>
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
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body{font-family:Arial,Helvetica,sans-serif;max-width:900px;margin:20px auto;padding:10px}
        form{display:grid;grid-template-columns:1fr 1fr;gap:12px}
        .full{grid-column:1/3}
        label{display:block;font-weight:bold;margin-bottom:4px}
        input[type="text"], input[type="email"], input[type="date"], select{width:100%;padding:6px}
        .error{color:#a00;font-size:0.9em}
        .actions{grid-column:1/3;text-align:right}
    </style>
</head>
<body>
<div class="container">
    <header class="hero">
        <div class="header-title">Formulario de alta de empleado</div>
        <div class="lights" aria-hidden="true">
            <span></span><span></span><span></span>
        </div>
    </header>
    <main class="main-grid">
        <section class="form-card">
            <h2 style="margin-top:0;color:#fff;font-size:1.1rem">Datos del empleado</h2>
            <div class="form-grid">
                
<?php if (!empty($errors)): ?>
    <div class="error">
        <p>Hay errores en el formulario. Corríjalos y vuelva a enviar.</p>
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

            <div class="actions" style="grid-column:1/3;text-align:right;margin-top:8px">
                <button type="submit">Dar de alta</button>
            </div>
        </form>
        </section>

        <!-- aside eliminado según petición: no mostrar resumen visual -->
    </main>

</div>

</body>
</html>
