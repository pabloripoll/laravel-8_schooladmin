<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\School\SchoolModel;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = SchoolModel::table();

        Schema::create($table, function (Blueprint $table) {
            $table->id();
            $table->integer('idcode')->unique();
            $table->integer('country_id')->nullable();
            $table->integer('province_id')->nullable();
            $table->integer('region_id')->nullable();            
            $table->integer('city_id')->nullable();
            $table->string('name', 128)->unique();
            $table->string('licence', 64)->unique()->nullable();
            $table->string('phone', 64)->nullable();
            $table->string('email', 64)->nullable();
            $table->string('website', 128)->nullable();
            $table->string('address', 128)->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->index('idcode');
            $table->index('country_id');
            $table->index('province_id');
            $table->index('region_id');
            $table->index('city_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = SchoolModel::table();

        Schema::dropIfExists($table);
    }
}
