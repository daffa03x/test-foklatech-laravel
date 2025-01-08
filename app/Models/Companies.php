<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    /** @use HasFactory<\Database\Factories\CompaniesFactory> */
    use HasFactory;
    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $fillable = ['name','email','logo','website'];

    public function employees()
    {
        return $this->hasMany(Employees::class, 'id_companies', 'id');
    }
    
}
