<?php

namespace App\Models;

use CodeIgniter\Model;
use App\MyClass\Category;

class PromoModel extends Model
{

    protected $table = 'promo';
    protected $allowedFields = [
        'description', 'effect',
        'active', 'date', 'duree'
    ];
    protected $useTimestamps = false;

    public function getAllPromo()
    {
        $builder = $this->builder();
        $builder->distinct()
            ->select('p.description, p.effect, p.active, p.date, p.duree')
            ->from('promo AS p');
        $promos = $builder->get()->getResultArray();

        return $promos;
    }
}
