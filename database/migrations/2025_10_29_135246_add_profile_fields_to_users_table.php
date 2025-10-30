<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('address_line1')->nullable()->after('phone');
            $table->string('address_line2')->nullable()->after('address_line1');
            $table->string('city')->nullable()->after('address_line2');
            $table->string('postal_code')->nullable()->after('city');
            $table->string('country')->nullable()->after('postal_code');
            // Buyer
            $table->string('billing_vat_number')->nullable()->after('country');
            // Producer
            $table->string('farm_name')->nullable()->after('billing_vat_number');
            $table->string('farm_type')->nullable()->after('farm_name');
            // Equipment owner
            $table->string('company_name')->nullable()->after('farm_type');
            $table->string('siret')->nullable()->after('company_name');
            $table->unsignedInteger('fleet_size')->nullable()->after('siret');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone','address_line1','address_line2','city','postal_code','country',
                'billing_vat_number','farm_name','farm_type','company_name','siret','fleet_size'
            ]);
        });
    }
};
