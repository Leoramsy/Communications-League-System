<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('players', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('position_id')->constrained('positions');
            $table->string('name');
            $table->string('surname')->deafult('');
            $table->string('nick_name');
            $table->string('id_number')->nullable();
            $table->date('date_of_birth');
            $table->string('contact_number');
            $table->string('image')->nullable();
            $table->boolean('active')->default(TRUE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('players');
    }

}
