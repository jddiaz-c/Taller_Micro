<?php
namespace App\Scrum\Controllers;

use App\Scrum\Models\Retro_Items;
use Exception;

class Retro_ItemsController {

    function getItems(){
        $rows = Sprints::all();
        return $rows->toJson();
    }
    
    function guardarItem($data){
        $item = new Retro_Item();
        $item->sprint_id = $data['sprint_id'];
        $item->categoria = $data['categoria'];
        $item->descripcion = $data['descripcion'];
        $item->cumplida = $data['cumplida'];
        $item->fecha_revision = $data['fecha_revision'];
        $item->save();
        return $item->toJson();
    }

    function getItem($id){
        $item = Retro_Item::find($id);
        if(empty($item)){
            throw new Exception("El item $id no existe", 1);
        }
        return $item;
    }

    function modificarItem($id, $data){
        $item = $this->getItem($id);
        $item->sprint_id = $data['sprint_id'];
        $item->categoria = $data['categoria'];
        $item->descripcion = $data['descripcion'];
        $item->cumplida = $data['cumplida'];
        $item->fecha_revision = $data['fecha_revision'];
        $item->save();
        return $item;
    }

    function borrarItem($id){
        $item = $this->getItem($id);
        $item->delete();
    }
}