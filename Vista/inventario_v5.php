<?php
// Vista/inventario_v5.php (versión dinámica)
include_once __DIR__ . "/../configuracion.php";
include_once $ROOT . "Modelo/Producto.php";

$objProducto = new Producto();
$listaProductos = $objProducto->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="CSS/inventario.css">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<nav class="navbar sticky-top navbar-dark bg-dark px-3">
    <ul class="navbar-nav d-flex flex-row me-auto">
        <li class="nav-item"><a class="nav-link" href="#">Tienda</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
        <li class="nav-item active"><a class="nav-link" href="#">Inventario</a></li>
    </ul>

    <div class="d-flex flex-row align-items-center">
        <form class="d-flex me-3">
            <input class="form-control me-2" type="search" placeholder="Búsqueda">
            <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>

        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Iniciar sesión
            </button>
            <div class="dropdown-menu dropdown-menu-end p-3">
                <form>
                    <label class="form-label">Usuario</label>
                    <input type="text" class="form-control mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" class="form-control mb-3">
                    <button class="btn btn-primary w-100" type="submit">Iniciar sesión</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container my-4">
    <h2 class="mb-4">Inventario</h2>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID Producto</th>
                    <th>Miniatura</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Etiquetas</th>
                    <th>Disponible</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($listaProductos != null && count($listaProductos) > 0): ?>
                <?php foreach ($listaProductos as $producto): 
                    $stockQty = intval($producto->getCantStock());
                    $stockClass = 'stock-out';
                    $stockText = 'Sin stock';
                    if ($stockQty >= 5) { $stockClass='stock-in'; $stockText='En stock'; }
                    elseif ($stockQty >= 1) { $stockClass='stock-low'; $stockText='Stock bajo'; }
                    $imgSrc = $producto->getImg() ? "../Vista/" . $producto->getImg() : "https://via.placeholder.com/50x70?text=No+Img";
                ?>
                <tr>
                    <td><?= htmlspecialchars($producto->getId()) ?></td>
                    <td style="width:90px;">
                        <img src="<?= htmlspecialchars($imgSrc) ?>" class="img-thumbnail" width="50" 
                             data-bs-toggle="modal" data-bs-target="#imagePreviewModal" 
                             onclick="previewImage('<?= addslashes($imgSrc) ?>','<?= addslashes($producto->getNombre()) ?>')">
                        <form action="../Control/actionProducto.php" method="post" enctype="multipart/form-data" style="margin-top:6px;">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($producto->getId()) ?>">
                            <input type="file" name="proimg" class="form-control form-control-sm" style="font-size:0.75rem;">
                            <button type="submit" class="btn btn-sm btn-outline-primary mt-1">Subir</button>
                        </form>
                    </td>

                    <td style="min-width:150px;">
                        <form action="../Control/actionProducto.php" method="post" class="d-grid gap-1" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($producto->getId()) ?>">
                            <input type="text" name="pronombre" class="form-control form-control-sm" value="<?= htmlspecialchars($producto->getNombre()) ?>">
                    </td>

                    <td>
                            <textarea name="prodescripcion" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($producto->getDescripcion()) ?></textarea>
                    </td>

                    <td style="width:120px;">
                            <input type="number" name="proprecio" class="form-control form-control-sm" min="0" step="0.01" value="<?= htmlspecialchars($producto->getPrecio()) ?>">
                    </td>

                    <td style="width:110px;">
                            <input type="number" name="prostock" class="form-control form-control-sm" min="0" value="<?= htmlspecialchars($producto->getCantStock()) ?>">
                    </td>

                    <td>
                        <span class="stock-status <?= $stockClass ?>"><?= $stockText ?></span>
                    </td>

                    <td style="min-width:160px;">
                            <?php
                                $tags = array_filter(array_map('trim', explode(',', $producto->getGenero())));
                                foreach ($tags as $t) {
                                    if ($t !== '') echo '<span class="badge bg-secondary me-1">' . htmlspecialchars($t) . '</span>';
                                }
                            ?>
                            <input type="text" name="progenero" class="form-control form-control-sm mt-1" placeholder="Etiquetas (comma-separated)" value="<?= htmlspecialchars($producto->getGenero()) ?>">
                    </td>

                    <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" <?= ($producto->getDeshabilitado() ? '' : 'checked') ?> disabled>
                            </div>
                    </td>

                    <td style="width:180px;">
                            <div class="d-flex gap-1">
                                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                        </form>

                                <form action="../Control/actionProducto.php" method="post" onsubmit="return confirm('¿Eliminar producto <?= addslashes($producto->getNombre()) ?>?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($producto->getId()) ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="10">No hay productos para mostrar.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-3 mb-5">
        <a href="inventario_crear.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Agregar Nuevo Juego</a>
        <a href="catalogo_v3.php" class="btn btn-primary">></i> Volver al catalogo </a>
    </div>
</div>

<!-- Modales -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePreviewTitle">Vista Previa de Imagen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" class="img-fluid" alt="Vista previa">
            </div>
        </div>
    </div>
</div>

<script src="js/inventario.js"></script>
</body>
</html>
