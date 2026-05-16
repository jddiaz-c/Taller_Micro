<?php
namespace App\Scrum\Controllers;

use App\Scrum\Models\Sprint;  // ← debe estar aquí, antes de la clase
use Exception;

class SprintsController {

    function getAll(){
        $rows = Sprint::all();
        return $rows->toJson();
    }
    
    function saveData($data){
        $camposObligatorios = ['nombre', 'fecha_inicio', 'fecha_fin'];
    $camposFaltantes = [];

    foreach ($camposObligatorios as $campo) {
        if (empty($data[$campo])) {
            $camposFaltantes[] = $campo;
        }
    }

    if (!empty($camposFaltantes)) {
        throw new Exception("Faltan campos obligatorios: " . implode(', ', $camposFaltantes), 3);
    }
            $sprint = new Sprint();
        $sprint->nombre = $data['nombre'];
        $sprint->fecha_inicio = $data['fecha_inicio'];
        $sprint->fecha_fin = $data['fecha_fin'];
        $sprint->save();
        return $sprint->toJson();
    }

    function getOne($id){
        $sprint = Sprint::find($id);
        if(empty($sprint)){
            throw new Exception("El sprint $id no existe", 1);
        }
        return $sprint;
    }

    function modify($id, $data){
        $sprint = $this->getOne($id);
        $sprint->nombre = $data['nombre'];
        $sprint->fecha_inicio = $data['fecha_inicio'];
        $sprint->fecha_fin = $data['fecha_fin'];
        $sprint->save();
        return $sprint;
    }

    function remove($id){
        $sprint = $this->getOne($id);
        $sprint->delete();
    }
}