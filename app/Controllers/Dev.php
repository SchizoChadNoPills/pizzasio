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
        return $this->view('/dev/result', ['a' => $_POST]);
    }
}