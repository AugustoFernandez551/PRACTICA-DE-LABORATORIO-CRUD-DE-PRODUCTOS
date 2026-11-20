<?php
require_once "Models/CategoriaModel.php";
require_once "Models/MarcaModel.php";

class ProductosController extends Controller
{
    public function index(): void
    {
        $this->views->render($this, "listar", ["productos" => $this->model->listarConDetalle()]);
    }

    public function crear(): void
    {
        $this->formulario([]);
    }

    private function formulario(array $producto, string $error = ""): void
    {
        $this->views->render($this, "formulario", [
            "producto" => $producto,
            "categorias" => (new CategoriaModel())->activas(),
            "marcas" => (new MarcaModel())->activas(),
            "error" => $error
        ]);
    }

    private function activo(int $id): array
    {
        $producto = $this->model->find($id);
        if (!$producto || !$producto["estado"]) {
            http_response_code(404);
            exit("Producto no encontrado.");
        }
        return $producto;
    }

    public function editar(int $id): void
    {
        $this->formulario($this->activo($id));
    }

    public function guardar(): void
    {
        $this->persistir(null);
    }

    public function actualizar(int $id): void
    {
        $this->activo($id);
        $this->persistir($id);
    }

    private function persistir(?int $id): void
    {
        $datos = [];
        foreach (["codigo","nombre","descripcion","precio","stock","unidad_medida","fecha_registro","id_categoria","id_marca"] as $campo) {
            $datos[$campo] = trim((string) ($_POST[$campo] ?? ""));
        }
        $fecha = DateTime::createFromFormat("!Y-m-d", $datos["fecha_registro"]);
        $valido = $datos["nombre"] !== "" && $datos["codigo"] !== "" && $datos["unidad_medida"] !== ""
            && preg_match('/^\d{1,8}(\.\d{1,2})?$/D', $datos["precio"])
            && ctype_digit($datos["stock"]) && $datos["stock"] <= 2147483647
            && $fecha && $fecha->format("Y-m-d") === $datos["fecha_registro"]
            && (new CategoriaModel())->activaExiste((int) $datos["id_categoria"])
            && (new MarcaModel())->activaExiste((int) $datos["id_marca"]);
        if ($valido) {
            try {
                if ($id === null) {
                    $this->model->insert($datos + ["estado" => 1]);
                } else {
                    $this->model->update($id, $datos);
                }
                $this->volver();
            } catch (PDOException $error) {
                if (!in_array($error->getCode(), ["23000","22001"], true)) {
                    throw $error;
                }
            }
        }
        http_response_code(422);
        $this->formulario($datos + ["id" => $id], "Revisa los datos y utiliza un código único.");
    }

    public function eliminar(int $id): void
    {
        $this->activo($id);
        $this->model->update($id, ["estado" => 0]);
        $this->volver();
    }

    private function volver(): void
    {
        header("Location: " . BASE_URL . "/productos", true, 303);
        exit;
    }
}
