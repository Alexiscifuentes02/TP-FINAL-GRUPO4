<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
use Gregwar\Captcha\CaptchaBuilder;

// Generar captcha
$builder = new CaptchaBuilder;
$builder->build();
$_SESSION['captcha_phrase'] = $builder->getPhrase();
?>

<form method="post" action="Action/accionVerificarLogin.php">
    <input type="text" name="user" placeholder="Usuario" required><br><br>
    <input type="password" name="psw" placeholder="Contraseña" required><br><br>

    <img src="<?php echo $builder->inline(); ?>" alt="CAPTCHA"><br><br>
    <input type="text" name="captcha_input" placeholder="Escriba el captcha" required><br><br>

    <input type="submit" value="Ingresar">
</form>

<?php
if(isset($_GET['error'])){
    if ($_GET['error'] === "1") echo "<p style='color:red;'>Usuario o contraseña incorrectos</p>";
    elseif ($_GET['error'] === "captcha") echo "<p style='color:red;'>Captcha incorrecto</p>";
}
?>






