<?php
$p = $data["producto"];
$editar = isset($p["id"]);
$accion = $editar ? "actualizar/" . (int) $p["id"] : "guardar";
$valor = fn($campo) => htmlspecialchars((string) ($p[$campo] ?? ""), ENT_QUOTES, "UTF-8");
$titulo = $editar ? "Editar producto" : "Registrar producto";
?>
<!doctype html>
<html lang="es"><meta charset="utf-8"><title><?= $titulo ?></title>
<h1><?= $titulo ?></h1>
<?php if ($data["error"]): ?><p><?= htmlspecialchars($data["error"]) ?></p><?php endif; ?>
<form method="post" action="<?= BASE_URL ?>/productos/<?= $accion ?>">
<?php foreach (["categorias" => ["Categoría","id_categoria"], "marcas" => ["Marca","id_marca"]] as $lista => [$etiqueta,$campo]): ?>
    <p><label><?= $etiqueta ?>
        <select name="<?= $campo ?>" required>
            <option value="">Seleccione</option>
            <?php foreach ($data[$lista] as $item): ?>
                <option value="<?= (int) $item["id"] ?>" <?= ($p[$campo] ?? "") == $item["id"] ? "selected" : "" ?>>
                    <?= htmlspecialchars($item["nombre"]) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label></p>
<?php endforeach; ?>
    <p><label>Código <input name="codigo" maxlength="30" value="<?= $valor("codigo") ?>" required></label></p>
    <p><label>Nombre <input name="nombre" maxlength="120" value="<?= $valor("nombre") ?>" required></label></p>
    <p><label>Descripción <input name="descripcion" maxlength="250" value="<?= $valor("descripcion") ?>" ></label></p>
    <p><label>Precio <input name="precio" type="number" min="0" max="99999999.99" step="0.01" value="<?= $valor("precio") ?>" required></label></p>
    <p><label>Stock <input name="stock" type="number" min="0" step="1" value="<?= $valor("stock") ?>" required></label></p>
    <p><label>Unidad de medida <input name="unidad_medida" maxlength="30" value="<?= $valor("unidad_medida") ?>" required></label></p>
    <p><label>Fecha de registro <input name="fecha_registro" type="date" value="<?= $valor("fecha_registro") ?>" required></label></p>
    <button>Guardar</button>
    <a href="<?= BASE_URL ?>/productos">Volver</a>
</form></html>
