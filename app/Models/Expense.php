<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['company_id', 'concept', 'amount', 'date', 'description'];
    public function company() { return $this->belongsTo(Company::class); }
}
