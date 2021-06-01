<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\School\SchoolImageModel;

class CreateSchoolsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = SchoolImageModel::table();

        Schema::create($table, function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->on('schools');
            $table->string('role', 16);
            $table->string('file');
            $table->string('ext', 8)->nullable();
            $table->integer('size')->nullable();
            $table->integer('width')->nullable();
            $table->integer('heigh')->nullable();
            $table->string('url', 128)->nullable();
            $table->string('name', 128)->nullable();
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
        $table = SchoolImageModel::table();

        Schema::dropIfExists($table);
    }

}
