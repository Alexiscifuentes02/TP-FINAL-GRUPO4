<?php
include_once __DIR__ . "/../configuracion.php";
include_once $ROOT . "Modelo/Producto.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Crear Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Crear Producto</h2>
        <form action="../Control/actionProducto.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="create">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="pronombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Desarrollador</label>
                <input type="text" name="prodesarrollador" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input type="number" step="0.01" name="proprecio" class="form-control" value="0">
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="prodescripcion" class="form-control" rows="4"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="prostock" class="form-control" value="0">
            </div>
            <div class="mb-3">
                <label class="form-label">Género / Etiquetas (coma-separado)</label>
                <input type="text" name="progenero" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Plataforma</label>
                <input type="text" name="plataforma" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Imagen</label>
                <input type="file" name="proimg" class="form-control">
            </div>
            <button class="btn btn-primary">Crear</button>
            <a href="inventario_v5.php" class="btn btn-secondary">Volver</a>
        </form>
    </div>
</body>
</html>

