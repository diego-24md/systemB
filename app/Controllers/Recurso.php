<?php

namespace App\Controllers;

use App\Models\RecursoModel;
use App\Controllers\BaseController;

class Recurso extends BaseController
{
    public function index(): string
    {
        $model = new RecursoModel();
        $data = [
            'recursos' => $model->findAll(),
            'header'   => view('Partials/header'),
            'footer'   => view('Partials/footer'),
        ];
        return view('Libros/index', $data);
    }
}