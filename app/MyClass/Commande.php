<?php

namespace App\MyClass;

class Commande{
    protected $id;
    protected $id_pizza;
    protected $price_commande;
    protected $size_pizza;

    public function __construct(
        $id,
        $id_pizza,
        $price_commande,
        $size_pizza
    )
    {
        $this->id = $id;
        $this->id_pizza = $id_pizza;
        $this->price_commande = $price_commande;
        $this->size_pizza = $size_pizza;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getId_pizza()
    {
        return $this->id_pizza;
    }

    public function getPrice_commande()
    {
        return $this->price_commande;
    }

    public function getSize_pizza()
    {
        return $this->size_pizza;
    }

}
}