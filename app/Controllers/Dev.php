<?php

namespace App\Controllers;
class Dev extends BaseController
{
    public function getIndex()
    {
        $categoryModel = model('categoryModel');
        $categories = $categoryModel->getCategoryByIdStep(5);
        return $this->view('/dev/index', ['categories' => $categories]);
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
        // $pizzaModel = model('PizzaModel');
        // $pizzaModel -> getLastIdPizza();
        return $this->view('/dev/result', ['data' => $data, 'id' => $id]);
    }

    public function getAjaxIngredients() {
        $idCateg = $this->request->getVar('idCateg');
        $ingredientModel = model('IngredientModel');
        $ingredients = $ingredientModel->getIngredientByIdCategory($idCateg);

        return $this->response->setJSON($ingredients);
    }
}