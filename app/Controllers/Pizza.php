<?php

namespace App\Controllers;

use App\MyClass\Pizza as ClassPizza;

class Pizza extends BaseController
{

    public function getIndex()
    {
        return $this->view('pizza\index');
    }

    public function getEdit($id_pizza)
    {

        $this->addbreadcrumb('Administration', '#');
        $this->addbreadcrumb('Gestion des pizzas', ['Pizza']);
        $stepModel = model('StepModel');
        $steps = $stepModel->getAllStep();
        $categoryModel = model('CategoryModel');
        $categories = $categoryModel->getAllCategory();
        $ingredientModel = model('IngredientModel');
        $ingredients = $ingredientModel->getAllIngredient();
        $pate = $ingredientModel->getIngredientByIdCategory(10);
        $base = $ingredientModel->getIngredientByIdCategory(13);



        if ($id_pizza == "new") {
            $this->addBreadcrumb('Création pizza', ['Pizza', 'edit', 'new']);
            return $this->view('/pizza/edit', ['steps' => $steps, 'categories' => $categories, 'ingredients' => $ingredients, 'pate' => $pate, 'base' => $base]);
        }

        $pizzaModel = model('PizzaModel');
        $this->title = "gerer la pizza";
        $pizza = $pizzaModel->getPizzaById($id_pizza);
        if ($pizza) {
            $composePizzaModel = model('ComposePizzaModel');
            $id_ingredient = $composePizzaModel->getIngredientByPizzaId($pizza['id']);
            $this->addBreadcrumb('Edition de ' . $pizza['name'], ['Pizza']);
            return $this->view('/pizza/edit', ['pizza' => $pizza, 'steps' => $steps, 'categories' => $categories, 'ingredients' => $ingredients, 'pate' => $pate, 'base' => $base, 'id_ingredient' => $id_ingredient]);
        }
        return $this->error('La pizza n\'existe pas');
        return $this->redirect('Pizza');
    }

    public function getAjaxIngredients()
    {
        $idCateg = $this->request->getVar('idCateg');
        $ingredientModel = model('IngredientModel');
        $ingredients = $ingredientModel->getIngredientByIdCategory($idCateg);
        return $this->response->setJSON($ingredients);
    }

    public function postResult()
    {
        $data = $this->request->getPost();
        $pizzaModel = model('PizzaModel');
        $id = $pizzaModel->createPizza($data['name'], $data['base'], $data['pate']);
        $data_ing = array();
        foreach ($data['ingredients'] as $ing) {
            $data_ing[] = ['id_pizza' => $id, 'id_ing' => (int) $ing];
        }
        $composePizza = model('ComposePizzaModel');
        $composePizza -> insertPizzaIngredient($data_ing);
        return $this->redirect('Pizza');
    }
}
