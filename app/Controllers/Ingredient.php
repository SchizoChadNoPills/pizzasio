<?php

namespace App\Controllers;

use App\MyClass\Ingredient as ClassIngredient;

class Ingredient extends BaseController
{
    public function getIndex()
    {
        return $this->view('ingredient\index');
    }

    public function getEdit($id_ingredient){

        $this->addbreadcrumb('Administration','#');
        $this->addbreadcrumb('Gestion des ingredients',['Ingredient']);
        $categoryModel = model('CategoryModel');
        if ($id_ingredient == "new"){
            $this->addBreadcrumb('Création ingredient', ['Ingredient', 'edit', 'new']);
            return $this->view('/ingredient/edit', ['categ' => $categoryModel-> getAllCategory()]);
        }
        
        $ingredientModel = model('IngredientModel');
        $this->title = "gerer l\'ingrédient";
        $ing = $ingredientModel->getIngredientById($id_ingredient);
        $this->addBreadcrumb('Edition de ' . $ing['name'], ['Ingredient', 'edit', $id_ingredient]);
        if ($ing) {
            return $this->view('/ingredient/edit', ['ing' => $ing, 'categ' => $categoryModel-> getAllCategory()]);
        }
        return $this->error('L\'ingrédient n\'existe pas');
        return $this->redirect('Ingredient');
        
    }

    public function postSearchIngredient()
    {

        $ingredientModel = model('IngredientModel');

 

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

        $data = $ingredientModel->getPaginatedIngredient($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Obtenez le nombre total de lignes sans filtre

        $totalRecords = $ingredientModel->getTotalIngredient();

        // Obtenez le nombre total de lignes filtrées pour la recherche

        $filteredRecords = $ingredientModel->getFilteredIngredient($searchValue);
        $result = [
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ];
        return $this->response->setJSON($result);
    }

    public function postSave()
    {
        $ingredientModel = model('IngredientModel');
        $data = $this->request->getPost();
        $id = (isset($data['id']) ? $data['id'] : null);
        $bio = (isset($data['bio']) ? true : false);
        $vegan = (isset($data['vegan']) ? true : false);
        $id_category = (isset($data['id_category'])) ? $data['id_category'] : 1;
        

        $ingredient = new ClassIngredient(

            $id, 
            $data['name'], 
            $data['stock'], 
            $data['price'], 
            $bio, 
            $vegan, 
            $id_category
            
        );

        if($data['type'] == "update") {
            $ingredientModel->updateIngredient($ingredient);
            $this->success("L'ingrédient a bien été modifié");
            return $this->redirect('Ingredient');
        } else if ($data['type'] == "insert") {
            $ingredientModel->createIngredient($ingredient);
            $this->success("L'ingrédient a bien été créé");
            return $this->redirect('Ingredient');
        } else {
            $this->error("Il y a eu une erreur");
            return $this->redirect('Ingredient');
        }
    }

    public function getDelete()
    {
        $id = $this->request->getGet('id');
        $ingredientModel = model('ingredientModel');
        $ingredientModel->deleteIngredient($id);
        $this->success("L'ingrédient a bien été supprimer");
        return $this->redirect('Ingredient');
    }
}
