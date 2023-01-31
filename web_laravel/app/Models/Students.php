<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Type\Integer;

class Students extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'gender',
        'birthdate',
        'status',
        'avatar',
        'course_id',
    ];
    public function course():BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    public function getAgeAttribute():int
    {
        return  date_diff(date_create($this->created_at), date_create('now'))->y;
    }

}
