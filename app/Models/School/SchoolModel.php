<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Student\StudentModel;

class SchoolModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idcode',
        'country_id',
        'province_id',
        'region_id',
        'city_id',
        'name',
        'licence',
        'phone',
        'email',
        'website',
        'address'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schools';

    static function table(){
        $protected = new SchoolModel;
        return $protected->table;
    }

    /**
     * Get the user that owns the phone.
     */
    public function image()
    {
        return $this->hasOne(SchoolImageModel::class, 'school_id', 'id');
    }

    /**
     * Get the user that owns the phone.
     */
    public function students()
    {
        return $this->hasMany(StudentModel::class, 'school_id', 'id');
    }

}
