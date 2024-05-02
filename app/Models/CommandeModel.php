<?php

namespace App\Models;

use CodeIgniter\Model;

class CommandeModel extends Model
{
    protected $table = 'commande';
    protected $allowedFields = [
        'id_commande', 'date_commande',
        'id_user', 'total_commande',
    ];
    protected $useTimestamps = false;

    public function getLigneCommandeByIdCommande($id)
    {
        $builder = $this->db->table('ligne_commande');
        $builder->select('ligne_commande.*, pizza.name as pizza_name');
        $builder->join('pizza', 'pizza.id = ligne_commande.id_pizza');
        $query = $builder->where('id_commande', $id)->get();
        return $query->getResult();
    }


    public function getCommandeById($user_id)
    {
        $data = [];
        $commandes = $this->where('id_user', $user_id)->findAll();
        foreach ($commandes as $commande) {
            $ligne_commande = $this->getLigneCommandeByIdCommande($commande['id_commande']);
            $data[] = ['commande' => $commande, 'ligne_commande' => $ligne_commande];
        }
        return $data;
    }
}
