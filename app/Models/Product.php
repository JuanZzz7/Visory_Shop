<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'company_id', 'name', 'description', 'price', 'stock', 'image', 'active', 'featured',
    ];

    protected $casts = ['active' => 'boolean', 'featured' => 'boolean', 'price' => 'decimal:2'];

    public function company() { return $this->belongsTo(Company::class); }
    public function orderDetails() { return $this->hasMany(OrderDetail::class); }

    public function getImageUrlAttribute()
    {
        if (!empty($this->image) && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }
        if ($this->company && !empty($this->company->logo) && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->company->logo)) {
            return asset('storage/' . $this->company->logo);
        }
        return asset('images/logo.png');
    }
}
