<?php
include_once("../Configuracion.php");
include_once($ROOT . "Control/AbmUsuario.php");

$abm = new AbmUsuario();
$edit = false;
$usuario = null;

if (isset($_GET['id'])) {
    $edit = true;
    $usuario = new Usuario();
    $usuario->buscar($_GET['id']);
}

// Listar roles desde la tabla rol
$roles = (new Rol())->listar("");  
?>

<h2><?php echo $edit ? "Editar Usuario" : "Nuevo Usuario"; ?></h2>

<form 
    method="post" 
    action="Action/<?php echo $edit ? 'accionEditarUsuario.php' : 'accionNuevoUsuario.php'; ?>"
>
    <?php if ($edit): ?>
        <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>">
    <?php endif; ?>

    Nombre: 
    <input type="text" name="nombre" value="<?php echo $edit ? $usuario->getNombre() : ""; ?>">
    <br><br>

    Contraseña: 
    <input type="text" name="pass" value="">
    <br><br>

    Email: 
    <input type="text" name="mail" value="<?php echo $edit ? $usuario->getMail() : ""; ?>">
    <br><br>

Roles:
<br>

<?php
foreach ($roles as $rol) {
    echo "<label>
            <input type='radio' name='rol' value='".$rol->getId()."'>
            ".$rol->getRolDescripcion()."
          </label><br>";
}
?>


    <br>
    <input type="submit" value="Guardar">

</form>

<br>
<a href="paginaUsuarios.php">◀ Volver</a>
