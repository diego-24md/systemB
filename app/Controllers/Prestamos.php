<?php

namespace App\Controllers;

use App\Models\PrestamosModel;

class Prestamos extends BaseController
{
    protected $prestamosModel;

    public function __construct()
    {
        $this->prestamosModel = new PrestamosModel();
    }

    public function index()
    {
        $data['prestamos'] = $this->prestamosModel->findAll();

        $data['header'] = view('Partials/header');
        $data['footer'] = view('Partials/footer');

        return view('prestamos/index', $data);
    }
}