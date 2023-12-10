<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    protected $table = 'prodi';

    public function semester(){
        return $this->hasMany(Semester::class, 'prodi_id');
    }
}
