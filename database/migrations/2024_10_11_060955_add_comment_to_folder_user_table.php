<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('folder_user', function (Blueprint $table) {
            $table->string('comment')->nullable()->after('access_level'); // Add comment column
        });
    }

    public function down()
    {
        Schema::table('folder_user', function (Blueprint $table) {
            $table->dropColumn('comment'); // Remove the column if rolled back
        });
    }
};
