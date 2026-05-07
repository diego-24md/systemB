<?php

namespace App\Controllers;

use App\Models\NotificacionesModel;

class Notificaciones extends BaseController
{
    public function marcar($id)
    {
        $model = new NotificacionesModel();
        $model->update($id, ['leida' => 1]);
        return redirect()->back();
    }
}
