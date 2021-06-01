<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Admin\User;

class AddRoleToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = User::table();

        Schema::table($table, function (Blueprint $table) {
            $table->integer('idcode')->unique()->after('id');
            $table->tinyInteger('role')->after('idcode');

            $table->index('idcode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = User::table();

        Schema::table($table, function (Blueprint $table) {
            $table->dropColumn('idcode');
            $table->dropColumn('role');
        });
    }
}
