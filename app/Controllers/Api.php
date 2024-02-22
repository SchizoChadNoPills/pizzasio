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
                        return $this->json($candidate->getID());
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
       return $this->json(["error" => "Mail or Password not found."],500);
    }

    public function postRegister()
    {
        
    }
}
