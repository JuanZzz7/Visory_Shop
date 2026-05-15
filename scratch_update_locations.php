<?php

use App\Models\Company;

// Centro de Ubaté
$baseLat = 5.3086;
$baseLng = -73.8149;

$companies = Company::whereNull('latitude')->orWhereNull('longitude')->get();

foreach ($companies as $company) {
    // Generar un pequeño desplazamiento aleatorio (aprox 500m)
    $lat = $baseLat + (mt_rand(-5000, 5000) / 1000000);
    $lng = $baseLng + (mt_rand(-5000, 5000) / 1000000);
    
    $company->update([
        'latitude'  => $lat,
        'longitude' => $lng,
        'address'   => 'Carrera ' . mt_rand(5, 12) . ' #' . mt_rand(1, 20) . '-' . mt_rand(1, 80) . ', Ubaté'
    ]);
}

echo "Se actualizaron " . $companies->count() . " empresas con ubicaciones en Ubaté.\n";
