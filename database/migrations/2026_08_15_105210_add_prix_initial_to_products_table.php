
2026 08 15 000000 add prix initial to products table · PHP
<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('prix_initial', 8, 2)->nullable()->after('prix');
        });
    }
 
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('prix_initial');
        });
    }
};
 