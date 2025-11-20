<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

// Crear phrase builder con solo números y 5 dígitos
$phraseBuilder = new PhraseBuilder(5, '0123456789');

// Generar captcha
$builder = new CaptchaBuilder(null, $phraseBuilder);
$builder->build();

$_SESSION['captcha_phrase'] = $builder->getPhrase();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login</title>

<style>
    body {
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: #eef1f6;
        font-family: "Segoe UI", sans-serif;
    }

    .login-card {
        background: white;
        padding: 40px;
        width: 350px;
        border-radius: 15px;
        box-shadow: 0px 4px 20px rgba(0,0,0,0.15);
        text-align: center;
    }

    .login-card h2 {
        margin-bottom: 20px;
        color: #333;
    }

    .login-card input[type="text"],
    .login-card input[type="password"] {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 15px;
    }

    .captcha-box {
        display: flex;
        justify-content: center;
        margin: 15px 0;
    }

    .login-card input[type="submit"] {
        width: 100%;
        padding: 12px;
        background: #4A90E2;
        border: none;
        border-radius: 8px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        margin-top: 10px;
        transition: background 0.25s;
    }

    .login-card input[type="submit"]:hover {
        background: #357ABD;
    }

    .error {
        margin-top: 15px;
        color: red;
        font-size: 14px;
    }
</style>
</head>
<body>

<div class="login-card">
    <h2>Iniciar Sesión</h2>

    <form method="post" action="Action/accionVerificarLogin.php">
        <input type="text" name="user" placeholder="Usuario" required>
        <input type="password" name="psw" placeholder="Contraseña" required>

        <div class="captcha-box">
            <img src="<?php echo $builder->inline(); ?>" alt="CAPTCHA">
        </div>

        <input type="text" name="captcha_input" placeholder="Escriba el captcha" required>

        <input type="submit" value="Ingresar">
    </form>

    <?php
    if(isset($_GET['error'])){
        if ($_GET['error'] === "1") echo "<p class='error'>Usuario o contraseña incorrectos</p>";
        elseif ($_GET['error'] === "captcha") echo "<p class='error'>Captcha incorrecto</p>";
    }
    ?>
</div>

</body>
</html>
