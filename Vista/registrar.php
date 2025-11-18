<?php
include_once("../Configuracion.php");
include_once($ROOT . "Control/AbmUsuario.php");
include_once($ROOT . "Modelo/Rol.php");

$abm = new AbmUsuario();
$rolObj = new Rol();
$roles = $rolObj->listar();

if(isset($_POST["registrar"])){

    $_POST["deshabilitado"] = "0000-00-00 00:00:00";

    // 1) Alta del usuario
    $resp = $abm->alta($_POST);

    if($resp["resultado"]){

        $objUsuario = $resp["obj"];
        $idUsuario = $objUsuario->getId();

        // 2) Asignar rol
        $abm->darRol(["id" => $idUsuario, "idrol" => $_POST["rol"]]);

        echo "<p style='color:green;'>✔ Usuario registrado correctamente.</p>";
    } else {
        echo "<p style='color:red;'>❌ Error: ".$resp['error']."</p>";
    }
}
?>

<h3>Registrar Nuevo Usuario</h3>

<form method="post">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="pass" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="mail" required><br><br>

    <label>Rol:</label><br>
    <select name="rol" required>
        <?php
        foreach($roles as $r){
            echo "<option value='".$r->getId()."'>".$r->getRolDescripcion()."</option>";
        }
        ?>
    </select><br><br>

    <input type="submit" name="registrar" value="Registrar Usuario">
</form>
