<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolImageModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_id',
        'role',
        'file',
        'ext',
        'size',
        'width',
        'heigh',
        'url',
        'name',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schools_images';

    static function table(){
        $protected = new SchoolImageModel;
        return $protected->table;
    }    

}
