<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use \App\Models\School\SchoolModel;

class StudentModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [        
        'idcode',
        'school_id',
        'country_id',
        'province_id',
        'region_id',
        'city_id',
        'name',
        'surname',
        'personal_id',
        'phone',
        'email',
        'address'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'students';

    static function table(){
        $protected = new StudentModel;
        return $protected->table;
    }
    
    /**
     * Get the user that owns the phone.
     */
    public function school()
    {
        return $this->belongsTo(schoolModel::class, 'school_id', 'id');
    }

    /**
     * Get the user that owns the phone.
     */
    public function image()
    {
        return $this->hasOne(StudentImageModel::class, 'student_id', 'id');
    }
}
