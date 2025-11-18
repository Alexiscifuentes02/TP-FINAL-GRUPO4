<?php
echo "Bienvenido Usuario: " . $usuario->getNombre();
echo "<br>Roles: " . implode(", ", $roles);
?>

<?php if ($mostrarAdmin): ?>
    <hr>
    <h3>Opciones de Administrador:</h3>
    <ul>
        <li><a href="../paginaUsuarios.php">Administrar Usuarios</a></li>
    </ul>
<?php endif; ?>

<?php if ($mostrarDeposito): ?>
    <hr>
    <h3>Opciones de Depósito:</h3>
    <ul>
        <li><a href="../paginaDeposito.php">Administrar Depósito</a></li>
    </ul>
<?php endif; ?>

<form method="post" action="Action/accionPaginaSegura.php">
    <button type="submit" name="cerrarSesion">Cerrar Sesión</button>
</form>
