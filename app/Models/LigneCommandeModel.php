<?php

namespace App\Models;

use CodeIgniter\Model;

class LigneCommandeModel extends Model
{
    protected $table = 'ligne_commande';
    protected $allowedFields = [
        'id_commande', 'id_pizza',
        'price_commande', 'size_pizza',
    ];
    protected $useTimestamps = false;


}