<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\RegionModel;

class CreateGeoRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = RegionModel::table();

        Schema::create($table, function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->on('geo_countries');
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
        $table = RegionModel::table();
        
        Schema::dropIfExists($table);
    }
}
