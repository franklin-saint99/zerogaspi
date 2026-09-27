<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Suppression des tables hors diagramme, vides et non reliées au reste :
 * - magasins   (les infos vendeur sont dans users : address, siret)
 * - reductions (la réduction se lit avec prix_initial et prix dans products)
 *
 * À ne lancer que si aucun code n'utilise les modèles Magasin ou Reduction.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('magasins');
        Schema::dropIfExists('reductions');
    }

    public function down(): void
    {
        Schema::create('magasins', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100)->nullable();
            $table->string('adresse')->nullable();
            $table->string('telephone', 20)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->timestamps();
        });

        Schema::create('reductions', function (Blueprint $table) {
            $table->id();
            $table->integer('pourcentage')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->timestamps();
        });
    }
};