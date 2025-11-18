<?php
include_once("../Configuracion.php");
include_once($ROOT . "Control/AbmUsuario.php");


$abm = new AbmUsuario();
$lista = $abm->buscar([]); // obtenerUsuarios()
?>

<h2>Administración de Usuarios</h2>

<a href="formUsuario.php">➕ Nuevo Usuario</a>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Deshabilitado</th>
        <th>Acciones</th>
    </tr>

    <?php
    if ($lista != null) {
        foreach ($lista as $usuario) {
            echo "<tr>";
            echo "<td>".$usuario->getId()."</td>";
            echo "<td>".$usuario->getNombre()."</td>";
            echo "<td>".$usuario->getMail()."</td>";
            echo "<td>".$usuario->getDeshabilitado()."</td>";
            echo "<td>
                    <a href='formUsuario.php?id=".$usuario->getId()."'>Editar</a> |
                    <a href='Action/accionEliminarUsuario.php?id=".$usuario->getId()."'>Eliminar</a>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No hay usuarios registrados.</td></tr>";
    }
    ?>
</table>
