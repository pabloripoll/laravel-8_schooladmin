<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Student\StudentModel;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = StudentModel::table();

        Schema::create($table, function (Blueprint $table) {
            $table->id();
            $table->integer('idcode')->unique();
            $table->foreignId('school_id')->on('schools');
            $table->integer('country_id')->nullable();
            $table->integer('province_id')->nullable();
            $table->integer('region_id')->nullable();            
            $table->integer('city_id')->nullable();
            $table->string('name', 64)->nullable();
            $table->string('surname', 64)->nullable();
            $table->string('personal_id', 32)->unique();
            $table->string('phone', 32)->nullable();
            $table->string('email', 64)->nullable();
            $table->string('address', 128)->nullable();
            $table->timestamps();

            $table->index('idcode');
            $table->index('school_id');
            $table->index('country_id');
            $table->index('province_id');
            $table->index('region_id');
            $table->index('city_id');
            $table->index('personal_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
