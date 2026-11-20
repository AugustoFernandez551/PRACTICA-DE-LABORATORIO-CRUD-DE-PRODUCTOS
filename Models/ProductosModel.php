<?php

class ProductosModel extends Model
{
    protected string $table = "producto";

    public function listarConDetalle(): array
    {
        return $this
            ->select("producto.id, producto.codigo, producto.nombre, producto.precio, producto.stock, categoria.nombre AS categoria, marca.nombre AS marca")
            ->join("INNER JOIN categoria ON categoria.id = producto.id_categoria")
            ->join("INNER JOIN marca ON marca.id = producto.id_marca")
            ->where(["producto.estado = 1"])
            ->orderBy("producto.id", "DESC")
            ->get();
    }
}
