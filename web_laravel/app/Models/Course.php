<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;
    protected $fillable =[
        'name'
    ];
    public function getYearAttribute():int
    {
        return  date_diff(date_create($this->created_at), date_create('now'))->y;
    }
    public function students():HasMany
    {
        return $this->hasMany(Students::class);
    }
}
