<?php

/**
 * APARTADO: AUDITORÍA TÉCNICA (BACKEND)
 * CONTROLADOR: BitacoraController.php
 * FUNCIÓN: Proporciona los datos del registro de auditoría. Permite al Administrador
 *          revisar el historial de acciones y el rendimiento de las peticiones.
 */

namespace Modules\Paquete9Auditoria\Http\Controllers;

use Modules\Paquete9Auditoria\Models\Bitacora;
use App\Http\Controllers\Controller;

class BitacoraController extends Controller
{
    public function index()
    {
        return Bitacora::with('usuario.persona')
            ->orderByDesc('id')
            ->get();
    }
}
