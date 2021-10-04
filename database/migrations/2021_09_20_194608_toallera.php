<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Toallera extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toallera', function (Blueprint $table) {
            $table->id();
            $table->string("worker", 100);
            $table->string("curp", 25);
            $table->boolean("active");
            $table->unsignedBigInteger("departamentId");
            $table->foreign("departamentId")->references("id")->on("departament");
            $table->string("nss", 11);
            $table->date("entry");
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
        //
        Schema::dropIfExists("toallera");
    }
}
