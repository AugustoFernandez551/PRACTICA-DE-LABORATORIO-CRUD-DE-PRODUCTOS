<?php

class MarcaModel extends Model
{
    protected string $table = "marca";

    public function activas(): array
    {
        return $this->where(["estado = 1"])->orderBy("nombre")->get();
    }

    public function activaExiste(int $id): bool
    {
        $statement = $this->connect()->prepare(
            "SELECT id FROM marca WHERE id = :id AND estado = 1"
        );
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return (bool) $statement->fetch();
    }
}
