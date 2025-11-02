<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Modifier l'enum payment_method pour inclure les nouvelles options
            DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('mobile_money', 'paydunya', 'bank_transfer', 'wave', 'orange_money', 'cash', 'card') NULL");
            
            // Ajouter cash_payment_details si elle n'existe pas déjà
            if (!Schema::hasColumn('orders', 'cash_payment_details')) {
                $table->text('cash_payment_details')->nullable()->after('payment_notes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Remettre l'enum original
            DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('mobile_money', 'paydunya', 'bank_transfer') NULL");
            
            // Supprimer cash_payment_details si elle existe
            if (Schema::hasColumn('orders', 'cash_payment_details')) {
                $table->dropColumn('cash_payment_details');
            }
        });
    }
};
