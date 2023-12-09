<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('prodi_id')->contrained('prodi');
            $table->timestamps();
        });

        Schema::create('semester_tahun', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prodi_id')->contrained('prodi');
            $table->foreignId('semester_id')->contrained('semesters');
            $table->foreignId('tahun_ajaran_id')->contrained('tahun_ajaran_id');
            $table->text('ket')->nullable();
            $table->string('nominal');
            $table->enum('publish', ['0', '1'])->default(0);
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
        Schema::dropIfExists('semesters');
    }
};
