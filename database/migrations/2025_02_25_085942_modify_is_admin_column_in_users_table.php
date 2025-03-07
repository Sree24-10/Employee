<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin'); // Remove existing column
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('is_admin', ['0', '1'])->default('0')->comment('0 = User, 1 = Admin')->after('password');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
            $table->boolean('is_admin')->default(0); // Restore as boolean if needed
        });
    }
};
