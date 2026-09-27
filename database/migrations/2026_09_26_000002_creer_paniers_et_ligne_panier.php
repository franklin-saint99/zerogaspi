<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
 * Correction du panier
 * Avant : panier (user_id, product_id)  -> un panier = un seul produit
 *         commande_produit              -> lignes rattachées à la commande, sans lien avec le panier
 * Après : paniers 1 --- 1..* ligne_panier *..1 products
 *         paniers 1 --- 0..1 commandes
 *
 * Les commandes existantes sont conservées : chacune reçoit un panier "valide"
 * et ses lignes de commande_produit sont recopiées dans ligne_panier.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1. L'ancienne table panier (vide, créée à la main) disparaît
        Schema::dropIfExists('panier');

        // 2. Nouvelles tables
        Schema::create('paniers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('statut', ['en_cours', 'valide'])->default('en_cours');
            $table->timestamps();
        });

        Schema::create('ligne_panier', function (Blueprint $table) {
            $table->id();
            // Composition : si le panier est supprimé, ses lignes le sont aussi
            $table->foreignId('panier_id')->constrained('paniers')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products');
            $table->unsignedInteger('quantite')->default(1);
            $table->decimal('prix_unitaire', 10, 2);
            $table->timestamps();

            // Un même produit n'apparaît qu'une fois par panier
            $table->unique(['panier_id', 'product_id']);
        });

        // 3. Lien commande -> panier (nullable le temps de reprendre les données)
        Schema::table('commandes', function (Blueprint $table) {
            $table->unsignedBigInteger('panier_id')->nullable()->after('id');
        });

        // 4. Reprise des données existantes
        foreach (DB::table('commandes')->orderBy('id')->get() as $commande) {
            $panierId = DB::table('paniers')->insertGetId([
                'user_id'    => $commande->user_id,
                'statut'     => 'valide',
                'created_at' => $commande->created_at,
                'updated_at' => $commande->updated_at,
            ]);

            DB::table('commandes')
                ->where('id', $commande->id)
                ->update(['panier_id' => $panierId]);

            $lignes = DB::table('commande_produit')
                ->where('commande_id', $commande->id)
                ->whereNotNull('product_id')
                ->select('product_id', DB::raw('SUM(quantite) AS quantite'), DB::raw('MAX(prix) AS prix'))
                ->groupBy('product_id')
                ->get();

            foreach ($lignes as $ligne) {
                DB::table('ligne_panier')->insert([
                    'panier_id'     => $panierId,
                    'product_id'    => $ligne->product_id,
                    'quantite'      => $ligne->quantite ?? 1,
                    'prix_unitaire' => $ligne->prix ?? 0,
                    'created_at'    => $commande->created_at,
                    'updated_at'    => $commande->updated_at,
                ]);
            }
        }

        // 5. commandes : on retire user_id (l'acheteur se retrouve via le panier)
        $this->supprimerClesEtrangeres('commandes', 'user_id');
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        // 6. commandes : panier_id obligatoire et unique (1 panier -> 0..1 commande)
        DB::table('commandes')->whereNull('total')->update(['total' => 0]);

        Schema::table('commandes', function (Blueprint $table) {
            $table->unsignedBigInteger('panier_id')->nullable(false)->change();
            $table->decimal('total', 10, 2)->nullable(false)->change();
            $table->unique('panier_id');
            $table->foreign('panier_id')->references('id')->on('paniers')->restrictOnDelete();
        });

        // 7. commande_produit n'a plus de raison d'exister
        Schema::dropIfExists('commande_produit');
    }

    public function down(): void
    {
        // Recréer commande_produit et user_id dans commandes
        Schema::create('commande_produit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->nullable()->constrained('commandes');
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->integer('quantite')->nullable();
            $table->decimal('prix', 10, 2)->nullable();
            $table->timestamps();
        });

        Schema::table('commandes', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users');
        });

        // Recopier les données dans l'ancien format
        foreach (DB::table('commandes')->get() as $commande) {
            $panier = DB::table('paniers')->find($commande->panier_id);

            DB::table('commandes')
                ->where('id', $commande->id)
                ->update(['user_id' => $panier?->user_id]);

            foreach (DB::table('ligne_panier')->where('panier_id', $commande->panier_id)->get() as $ligne) {
                DB::table('commande_produit')->insert([
                    'commande_id' => $commande->id,
                    'product_id'  => $ligne->product_id,
                    'quantite'    => $ligne->quantite,
                    'prix'        => $ligne->prix_unitaire,
                ]);
            }
        }

        $this->supprimerClesEtrangeres('commandes', 'panier_id');
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn('panier_id');
        });

        Schema::dropIfExists('ligne_panier');
        Schema::dropIfExists('paniers');

        Schema::create('panier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->integer('quantite')->default(1)->nullable();
            $table->timestamps();
        });
    }

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