<?php

return [
    'required' => 'El campo :attribute es obligatorio.',
    'email' => 'El campo :attribute debe ser una dirección de correo válida.',
    'max' => [
        'string' => 'El campo :attribute no debe ser mayor a :max caracteres.',
    ],
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'unique' => 'El valor del campo :attribute ya está en uso.',
    'numeric' => 'El campo :attribute debe ser un número.',
    'image' => 'El campo :attribute debe ser una imagen.',
    'mimes' => 'El campo :attribute debe ser un archivo de tipo: :values.',
    
    'attributes' => [
        'name' => 'nombre',
        'email' => 'correo electrónico',
        'phone' => 'teléfono',
        'description' => 'descripción',
        'category' => 'categoría',
        'address' => 'dirección',
        'nit' => 'NIT/RUT',
        'logo' => 'logo',
        'banner' => 'banner'
    ],
];
