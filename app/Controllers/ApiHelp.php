<?php

namespace App\Controllers;


class ApiHelp extends BaseController
{
    public function getIndex()
    {
        return $this->view('/api/index');
    }

}