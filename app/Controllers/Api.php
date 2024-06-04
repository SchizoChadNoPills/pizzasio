<?php

namespace App\Controllers;

use App\MyClass\User;

class Api extends BaseController
{
    public $acl = false;
    protected $start_session = false;

    public function getAllPizza()
    {
        $pizzaModel = model('PizzaModel');
        $allPizza = $pizzaModel->getAllPizza();
        return $this->json($allPizza);
    }

    public function getAllPromo()
    {
        $promoModel = model('PromoModel');
        $allPromo = $promoModel->getAllPromo();
        return $this->json($allPromo);
    }

    public function getIngredientByPizzaId()
    {
        if ($this->request->getVar('id_pizza') != null) {
            $composePizzaModel = model('ComposePizzaModel');
            $composePizza = $composePizzaModel->getIngredientNameByPizzaId((int)$this->request->getVar('id_pizza'));
            if ($composePizza != null) {
                return $this->json($composePizza);
            } else {
                return $this->json(["error" => "Pizza not found"], 500);
            }
        } else {
            return $this->json(["error" => "ID not found"], 500);
        }
    }



    public function getPizza()
    {
        if ($this->request->getVar('id') != null) {
            $pizzaModel = model('PizzaModel');
            $pizza = $pizzaModel->getPizzaById((int)$this->request->getVar('id'));
            if ($pizza != null) {
                return $this->json($pizza);
            } else {
                return $this->json(["error" => "Pizza not found"], 500);
            }
        } else {
            return $this->json(["error" => "ID not found"], 500);
        }
    }

    public function getUser()
    {
        if ($this->request->getVar('id') != null) {
            $userModel = model('UserModel');
            $user = $userModel->getUserById((int)$this->request->getVar('id'));
            if ($user != null) {
                return $this->json($user);
            } else {
                return $this->json(["error" => "Pizza not found"], 500);
            }
        } else {
            return $this->json(["error" => "ID not found"], 500);
        }
    }

    public function getCommandeByUserId()
    {
        $idUrl = (int)$this->request->getVar('user_id');

        if ($idUrl != null) {
            $commandeModel = model('CommandeModel');
            $commande = $commandeModel->getCommandeById($idUrl);
            if ($commande != null) {
                return $this->json($commande);
            } else {
                return $this->json(["error" => "Commande not found"], 500);
            }
        } else {
            return $this->json(["error" => "ID not found"], 500);
        }
    }



    public function getLogin()
    {
        if (($email = $this->request->getVar('email')) !== null
            && ($pass = $this->request->getVar('password')) !== null
        ) {
            $userModel = model('UserModel');
            $candidateData = $userModel->getUserByMail($email);

            if ($candidateData) {
                $candidate = new User(
                    $candidateData['id'],
                    $candidateData['username'],
                    $candidateData['email'],
                    $candidateData['password'],
                    $candidateData['admin'],
                    $candidateData['active'],
                    $candidateData['auth_attempt'],
                    $candidateData['photo']
                );
            } else {
                return $this->json(["error" => "User not found"], 500);
            }
            if ($candidate) {

                if ($candidate->getActive()) {

                    if (password_verify(
                        $pass,
                        $candidate->getPassword()
                    )) {
                        return $this->json(["id_user" => $candidate->getId()]);
                    } else {
                        $candidate->auth_attempt++;
                        if ($candidate->auth_attempt > 5) {
                            $userModel->setAuthAttempt(false, $email);
                        }
                        return $this->json(["error" => "Password incorrect", "auth_attempt" => $candidate->auth_attempt], 500);
                    }
                }
            }
        }
        return $this->json(["error" => "Mail or Password not found."], 500);
    }

    public function postRegister()
    {

    }

    public function postCommandeToAPI()
    {
        // Récupérer le corps JSON de la requête
        $requestData = $this->request->getJSON();
        $userId = $requestData->userId;

        // Insérer la commande dans la base de données
        $commandeModel = model('CommandeModel');
        $data = [
            'id_user' => $userId
        ];
        $commandeId = $commandeModel->insert($data);

        // Vérifier si l'insertion de la commande a réussi
        if (!$commandeId) {
            return $this->json(["error" => "Failed to save commande"], 500);
        }

        // Insérer les lignes de commande dans la base de données
        $lignecommandeModel = model('LigneCommandeModel');
        $pizzaArray = json_decode($requestData->pizza, true);
        $ligneData = [];
        foreach ($pizzaArray as $pizza) {
            // Remplacer les virgules par des points dans le prix de la pizza
            $price = str_replace(',', '.', $pizza['price']);
            // Formater le prix de la pizza avec 2 décimales
            $formattedPrice = number_format($price, 2);
            $ligneData[] = [
                'id_commande' => $commandeId,
                'id_pizza' => $pizza['id'],
                'price_commande' => $formattedPrice, // Utiliser le prix formaté
                'size_pizza' => $pizza['size']
            ];
        }


        // Insérer les données de la ligne de commande dans la base de données
        $inserted = $lignecommandeModel->insertBatch($ligneData);

        if ($inserted) {
            return $this->json(["success" => "Commande enregistrée avec succès", "commande_id" => $commandeId]);
        } else {
            return $this->json(["error" => "Failed to save commande"], 500);
        }
    }
}
