<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Company;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $baseLat = 5.3086;
        $baseLng = -73.8149;

        $companies = Company::whereNull('latitude')->orWhereNull('longitude')->get();

        foreach ($companies as $company) {
            $lat = $baseLat + (mt_rand(-8000, 8000) / 1000000);
            $lng = $baseLng + (mt_rand(-8000, 8000) / 1000000);
            
            $company->update([
                'latitude'  => $lat,
                'longitude' => $lng,
                'address'   => 'Carrera ' . mt_rand(5, 12) . ' #' . mt_rand(1, 15) . '-' . mt_rand(10, 90) . ', Villa de San Diego de Ubaté'
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
