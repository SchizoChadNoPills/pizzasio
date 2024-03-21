<?php

namespace App\Controllers;

use App\MyClass\Pizza as ClassPizza;

class Pizza extends BaseController
{

    public function getIndex()
    {
        return $this->view('/pizza/index');
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
            $pizza_ing = $composePizzaModel->getIngredientByPizzaId($pizza['id']);
            $this->addBreadcrumb('Edition de ' . $pizza['name'], ['Pizza']);
            return $this->view('/pizza/edit', ['pizza' => $pizza, 'steps' => $steps, 'categories' => $categories, 'ingredients' => $ingredients, 'pate' => $pate, 'base' => $base, 'pizza_ing' => $pizza_ing]);
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
        $data_ing[] = ['id_pizza' => $id, 'id_ing' => (int) $data['base']];
        $data_ing[] = ['id_pizza' => $id, 'id_ing' => (int) $data['pate']];
        $composePizza = model('ComposePizzaModel');
        $composePizza->insertPizzaIngredient($data_ing);
        return $this->redirect('Pizza');
    }

    public function postSearchPizza()
    {
        $pizzaModel = model('pizzaModel');

        // Paramètres de pagination et de recherche envoyés par DataTables
        $draw        = $this->request->getPost('draw');
        $start       = $this->request->getPost('start');
        $length      = $this->request->getPost('length');
        $searchValue = $this->request->getPost('search')['value'];

        // Obtenez les informations sur le tri envoyées par DataTables

        $orderColumnIndex = $this->request->getPost('order')[0]['column'];
        $orderDirection = $this->request->getPost('order')[0]['dir'];
        $orderColumnName = $this->request->getPost('columns')[$orderColumnIndex]['data'];



        // Obtenez les données triées et filtrées pour la colonne "sku_syaleo"
        $data = $pizzaModel->getPaginatedPizza($start, $length, $searchValue, $orderColumnName, $orderDirection);



        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $pizzaModel->getTotalPizza();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $pizzaModel->getFilteredPizza($searchValue);

        $result = [
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ];
        return $this->response->setJSON($result);
    }

    public function getAjaxPizzaContent()
    {
        $idPizza = $this->request->getVar('idPizza');
        $pizzaModel = model('PizzaModel');
        $ingredientModel = model('ingredientModel');
        $pizza = $pizzaModel->getPizzaById($idPizza);

        if ($pizza) {
            $composePizzaModel = model('ComposePizzaModel');
            $pizza_ing = $composePizzaModel->getIngredientByPizzaId($pizza['id']);
            $id_base = $ingredientModel->getIngredientById($pizza['id_base']);
            $id_pate = $ingredientModel->getIngredientById($pizza['id_pate']);
            $id_ing = $ingredientModel->getIngredientById($pizza['id']);
        }

        $result = array();
        $result = [
            'pizza'           => $pizza,
            'base'    => $id_base,
            'pate' => $id_pate,
            'ingredients' => $pizza_ing,
        ];
        return $this->response->setJson($result);
    }
}
