<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_technology', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('technology_id')->constrained()->cascadeOnDelete();
            // $table->timestamps(); posso anche non servire
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /* Elimina il vincolo autonomamente creato nella funzione up,
        anche se normalmente in un ambiente di lavoro diverso andrebbe 
        eliminata prima la relazione e poi la tabella */

        Schema::dropIfExists('project_technology');
    }
};
