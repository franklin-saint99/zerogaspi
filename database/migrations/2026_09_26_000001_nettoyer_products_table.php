<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
 * Nettoyage de la table products
 * - suppression des colonnes en double : user_id, categorie_id, prix_normal, prix_reduit, quantite
 * - prix_initial, prix, stock, category_id et vendeur_id deviennent obligatoires
 */
return new class extends Migration
{
    private array $doublons = ['user_id', 'categorie_id', 'prix_normal', 'prix_reduit', 'quantite'];

    public function up(): void
    {
        // 1. Retirer les clés étrangères des colonnes concernées
        foreach (array_merge($this->doublons, ['category_id', 'vendeur_id']) as $colonne) {
            $this->supprimerClesEtrangeres('products', $colonne);
        }

        // 2. Supprimer les colonnes en double (toutes vides dans la base actuelle)
        $aSupprimer = array_values(array_filter(
            $this->doublons,
            fn ($colonne) => Schema::hasColumn('products', $colonne)
        ));

        if (! empty($aSupprimer)) {
            Schema::table('products', function (Blueprint $table) use ($aSupprimer) {
                $table->dropColumn($aSupprimer);
            });
        }

        // 3. Remplir les valeurs manquantes avant de rendre les colonnes obligatoires
        //    (sans prix initial connu, on considère qu'il n'y a pas de réduction)
        DB::table('products')->whereNull('prix_initial')->update(['prix_initial' => DB::raw('prix')]);
        DB::table('products')->whereNull('stock')->update(['stock' => 0]);

        // 4. Colonnes obligatoires
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('prix_initial', 10, 2)->nullable(false)->change();
            $table->decimal('prix', 10, 2)->nullable(false)->change();
            $table->integer('stock')->default(0)->nullable(false)->change();
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
            $table->unsignedBigInteger('vendeur_id')->nullable(false)->change();
        });

        // 5. Remettre uniquement les deux clés étrangères utiles
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->foreign('vendeur_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        $this->supprimerClesEtrangeres('products', 'category_id');
        $this->supprimerClesEtrangeres('products', 'vendeur_id');

        Schema::table('products', function (Blueprint $table) {
            $table->decimal('prix_initial', 10, 2)->nullable()->change();
            $table->decimal('prix', 10, 2)->nullable()->change();
            $table->integer('stock')->default(0)->nullable()->change();
            $table->unsignedBigInteger('category_id')->nullable()->change();
            $table->unsignedBigInteger('vendeur_id')->nullable()->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('categorie_id')->nullable()->constrained('categories');
            $table->decimal('prix_normal', 10, 2)->nullable();
            $table->decimal('prix_reduit', 10, 2)->nullable();
            $table->integer('quantite')->nullable();

            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->foreign('vendeur_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    // Supprime toutes les clés étrangères posées sur une colonne,
    // qu'elles aient été créées par Laravel ou à la main dans phpMyAdmin
    private function supprimerClesEtrangeres(string $table, string $colonne): void
    {
        if (! Schema::hasColumn($table, $colonne)) {
            return;
        }

        foreach (Schema::getForeignKeys($table) as $cle) {
            if (in_array($colonne, $cle['columns'], true)) {
                Schema::table($table, function (Blueprint $t) use ($cle) {
                    $t->dropForeign($cle['name']);
                });
            }
        }
    }
};