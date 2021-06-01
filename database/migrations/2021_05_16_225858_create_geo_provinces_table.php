<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\ProvinceModel;

class CreateGeoProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = ProvinceModel::table();

        Schema::create($table, function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->on('geo_countries');
            $table->foreignId('region_id')->on('geo_regions');
            $table->string('name', 64)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = ProvinceModel::table();

        Schema::dropIfExists($table);
    }
}
