<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeesFactory> */
    use HasFactory;
    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $fillable = ['first_name','last_name','id_companies','email','phone'];

    public function companies()
    {
        return $this->belongsTo(Companies::class, 'id_companies', 'id');
    }
}
