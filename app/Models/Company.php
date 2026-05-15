<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'user_id',
        // Vista general
        'name', 'description', 'category', 'logo', 'banner',
        // Aspecto legal
        'tipo_negocio', 'razon_social', 'nit', 'nombre_comercial',
        'cedula_propietario', 'habeas_data_accepted', 'direccion_fisica',
        'camara_comercio_file', 'rut_file', 'rut_personal_file',
        // Redes y contacto
        'address', 'phone', 'email', 'instagram', 'facebook', 'website',
        'latitude', 'longitude',
        // Estado
        'status',
    ];

    public function user()     { return $this->belongsTo(User::class); }
    public function products() { return $this->hasMany(Product::class); }
    public function expenses() { return $this->hasMany(Expense::class); }
    public function orderDetails()
    {
        return $this->hasManyThrough(OrderDetail::class, Product::class);
    }
}
