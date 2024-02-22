<?php

namespace App\Models;

use CodeIgniter\Model;
use App\MyClass\Pizza;

class PizzaModel extends Model
{
    protected $table = 'pizza';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'name', 'id_pate', 'id_base', 'active',
    ];
    protected $useTimestamps = false;

    public function createPizza($name, $base, $pate)
    {
        $builder = $this->db->table($this->table);
        $builder->set('name', $name);
        $builder->set('id_pate', $pate);
        $builder->set('id_base', $base);


        $builder->set('active', 0);

        $builder->insert();
        return $this->db->insertID();
    }

    public function updatePizza($data)
    {
        $builder = $this->db->table($this->table);

        if (isset($data['name'])) $builder->set('name', (string) $data['name']);
        if (isset($data['id_base'])) $builder->set('id_base', (int) $data['id_base']);
        if (isset($data['id_pate'])) $builder->set('id_pate', (int) $data['id_pate']);
        if (isset($data['active'])) $builder->set('active', (bool) $data['active']);

        if (isset($data['id'])) {
            $builder->where('id', $data['id']);
            $builder->update();
        }
    }

    public function getLastIdPizza()
    {
        $builder = $this->db->table($this->table)
            ->selectMax('id')
            ->get();

        $row = $builder->getRow();
        return $row->id;
    }

    public function getPizzaById($id)
    {
        return $this->find($id);
    }

    function getPaginatedPizza($start, $length, $searchValue, $orderColumnName, $orderDirection)

    {
        $builder = $this->builder();

        // Recherche
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('name', $searchValue);
            $builder->orlike('active', $searchValue);
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }
        $builder->limit($length, $start);
        return $builder->get()->getResultArray();
    }

    public function getTotalPizza()
    {
        return $this->builder()->countAllResults();
    }

    public function getFilteredPizza($searchValue)
    {
        $builder = $this->builder();
        // @phpstan-ignore-next-line
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('name', $searchValue);
            $builder->orlike('active', $searchValue);
        }
        return $builder->countAllResults();
    }

    public function getAllPizza(){
        $builder = $this->builder();
        return $builder->get()->getResultArray();
    }
}
