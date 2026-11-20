<!doctype html>
<html lang="es"><meta charset="utf-8"><title>Productos</title>
<h1>Productos activos</h1>
<p><a href="<?= BASE_URL ?>/productos/crear">Registrar producto</a></p>
<table border="1"><thead><tr>
<th>Código</th><th>Producto</th><th>Categoría</th><th>Marca</th><th>Precio</th><th>Stock</th><th>Opciones</th>
</tr></thead><tbody>
<?php foreach ($data["productos"] as $producto): ?>
<tr>
    <?php foreach (["codigo","nombre","categoria","marca","precio","stock"] as $campo): ?>
        <td><?= htmlspecialchars((string) $producto[$campo], ENT_QUOTES, "UTF-8") ?></td>
    <?php endforeach; ?>
    <td><a href="<?= BASE_URL ?>/productos/editar/<?= (int) $producto["id"] ?>">Editar</a>
        <form method="post" action="<?= BASE_URL ?>/productos/eliminar/<?= (int) $producto["id"] ?>">
            <button>Eliminar</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</tbody></table></html>
