<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cast', function (Blueprint $table) {
            $table->string('nama')->after('id');
            $table->integer('umur')->after('nama');
            $table->text('bio')->after('umur');
        });
    }
};
