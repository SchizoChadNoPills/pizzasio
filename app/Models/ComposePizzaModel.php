<?php

namespace App\Models;

use CodeIgniter\Model;
use App\MyClass\ComposePizza;

class ComposePizzaModel extends Model{
    
    protected $table = 'compose_pizza';
    protected $allowedFields = [
        'id_pizza', 'id_ing',
    ];
    protected $useTimestamps = false;

    public function insertPizzaIngredient($data)
    {
        $builder = $this->db->table($this->table);

        $builder->insertBatch($data);

    }

    public function updatePizza($data)
    {
        $builder = $this->db->table($this->table);

        if (isset($data['name'])) $builder->set('name', (string) $data['name']);
        if (isset($data['id_base'])) $builder->set('id_base', (int) $data['id_base']);
        if (isset($data['id_pate'])) $builder->set('id_pate', (int) $data['id_pate']);
        if (isset($data['active'])) $builder->set('active', (boolean) $data['active']);

        if (isset($data['id'])) {
            $builder->where('id', $data['id']);
            $builder->update();
        }
    }


    public function getIngredientByPizzaId($id_pizza) {
        $builder = $this->db->table($this->table);
        $builder->select('ingredient.name, ingredient.id, ingredient.price');
        $builder->join('ingredient', 'ingredient.id = compose_pizza.id_ing');
        $builder->where('compose_pizza.id_pizza', $id_pizza);
        $query = $builder->get();
        $data = $query->getResult();
        return $data;
    }

    public function getIngredientNameByPizzaId($id_pizza) {
        $builder = $this->db->table($this->table);
        $builder->select('ingredient.name');
        $builder->join('ingredient', 'ingredient.id = compose_pizza.id_ing');
        $builder->where('compose_pizza.id_pizza', $id_pizza);
        $query = $builder->get();
        $data = $query->getResult();
        return $data;
    }

    public function deleteIngredientPizza($data){
        $builder = $this->db->table($this->table);
        foreach ($data['ing_suppr'] as $delId) {
            $builder
                ->where('id_pizza', $data['id'])
                ->where('id_ingredient', $delId)
                ->limit(1)
                ->delete();
        }
    }
}