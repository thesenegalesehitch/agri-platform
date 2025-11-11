<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        // Les anciennes tables ne sont pas recréées car la plateforme
        // ne gère plus les ventes de produits.
    }
};

