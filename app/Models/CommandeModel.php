<?php

namespace App\Models;

use CodeIgniter\Model;

class CommandeModel extends Model
{
    protected $table = 'commande';
    protected $allowedFields = [
        'id_commande', 'date_commande',
        'id_client', 'total_commande',
    ];
    protected $useTimestamps = false;


}