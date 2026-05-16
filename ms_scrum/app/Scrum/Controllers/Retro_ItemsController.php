<?php
namespace App\Scrum\Controllers;

use App\Scrum\Models\Retro_Items;
use Exception;

class Retro_ItemsController {
    const CATEGORIAS_VALIDAS = ['accion', 'logro', 'impedimento', 'comentario', 'otro'];

    function getAll(){
        $rows = Retro_Items::all();
        return $rows->toJson();
    }
    function saveData($data){
            $camposObligatorios = ['sprint_id', 'categoria', 'descripcion'];
        $camposFaltantes = [];

        foreach ($camposObligatorios as $campo) {
            if (empty($data[$campo])) {
                $camposFaltantes[] = $campo;
            }
        }

        if (!empty($camposFaltantes)) {
            throw new Exception("Faltan campos obligatorios: " . implode(', ', $camposFaltantes), 3);
        }

        $sprintsController = new SprintsController();
        $sprintsController->getOne($data['sprint_id']);

        if (!in_array($data['categoria'], self::CATEGORIAS_VALIDAS)) {
            throw new Exception("Categoría inválida. Valores permitidos: " . implode(', ', self::CATEGORIAS_VALIDAS), 3);
        }

        $item = new Retro_Items();
        $item->sprint_id = $data['sprint_id'];
        $item->categoria = $data['categoria'];
        $item->descripcion = $data['descripcion'];
        $item->cumplida = $data['cumplida'];
        $item->fecha_revision = $data['fecha_revision'];
        $item->save();
        return $item->toJson();
    }

    function getOne($id){
        $item = Retro_Items::find($id);
        if(empty($item)){
            throw new Exception("El item $id no existe", 1);
        }
        return $item;
    }

    function modify($id, $data){
        $sprintsController = new SprintsController();
        $sprintsController->getOne($data['sprint_id']);

        if (!in_array($data['categoria'], self::CATEGORIAS_VALIDAS)) {
            throw new Exception("Categoría inválida. Valores permitidos: " . implode(', ', self::CATEGORIAS_VALIDAS), 3);
        }

        $item = $this->getOne($id);
        $item->sprint_id = $data['sprint_id'];
        $item->categoria = $data['categoria'];
        $item->descripcion = $data['descripcion'];
        $item->cumplida = $data['cumplida'];
        $item->fecha_revision = $data['fecha_revision'];
        $item->save();
        return $item;
    }

    function remove($id){
        $item = $this->getOne($id);
        $item->delete();
    }
}