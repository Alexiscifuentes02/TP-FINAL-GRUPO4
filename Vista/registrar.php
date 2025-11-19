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

<style>
/* ======== ESTILOS GENERALES ======== */
body {
    font-family: Arial, sans-serif;
    background: #eef1f5;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding-top: 50px;
}

/* ======== TARJETA ======== */
.card {
    background: #ffffff;
    padding: 30px;
    width: 380px;
    border-radius: 15px;
    box-shadow: 0px 5px 20px rgba(0,0,0,0.15);
    animation: fadeIn 0.6s ease-out;
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(15px);}
    to {opacity: 1; transform: translateY(0);}
}

.card h3 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

/* ======== INPUTS ======== */
input, select {
    width: 100%;
    padding: 12px;
    margin-top: 6px;
    border-radius: 8px;
    border: 1px solid #bbb;
    transition: 0.2s;
}

input:focus, select:focus {
    border-color: #4a90e2;
    box-shadow: 0 0 6px rgba(74,144,226,0.4);
    outline: none;
}


label {
    font-size: 14px;
    color: #444;
}

button {
    width: 100%;
    padding: 12px;
    background: #4a90e2;
    color: white;
    border: none;
    margin-top: 15px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: 0.2s;
}

button:hover {
    background: #357ac9;
}
</style>

<div class="card">
    <h3>Registrar Nuevo Usuario</h3>

    <form method="post">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Contraseña:</label>
        <input type="password" name="pass" required>

        <label>Email:</label>
        <input type="email" name="mail" required>

        <label>Rol:</label>
        <select name="rol" required>
            <?php
            foreach($roles as $r){
                echo "<option value='".$r->getId()."'>".$r->getRolDescripcion()."</option>";
            }
            ?>
        </select>

        <button type="submit" name="registrar">Registrar Usuario</button>
    </form>
</div>
