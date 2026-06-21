<?php
namespace Modules\Paquete3Configuracion\Models;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model {
    protected $table = 'empresa';
    protected $fillable = ['nombre', 'nit', 'direccion', 'telefono', 'correo', 'moneda', 'sucursal', 'ciudad', 'actividad_economica', 'codigo_autorizacion', 'leyenda_factura'];
}
