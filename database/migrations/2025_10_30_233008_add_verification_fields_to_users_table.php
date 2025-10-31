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
            // Vérification téléphone (seulement si n'existent pas)
            if (!Schema::hasColumn('users', 'phone_verified')) {
                $table->boolean('phone_verified')->default(false)->after('phone');
                $table->string('phone_verification_code', 10)->nullable()->after('phone_verified');
                $table->timestamp('phone_verification_code_expires_at')->nullable()->after('phone_verification_code');
            }
            
            // Vérification CNI
            if (!Schema::hasColumn('users', 'cni_number')) {
                $table->string('cni_number', 50)->nullable()->after('phone_verification_code_expires_at');
                $table->string('cni_recto_path')->nullable()->after('cni_number');
                $table->string('cni_verso_path')->nullable()->after('cni_recto_path');
                $table->boolean('cni_verified')->default(false)->after('cni_verso_path');
                $table->timestamp('cni_verified_at')->nullable()->after('cni_verified');
                $table->text('cni_verification_notes')->nullable()->after('cni_verified_at');
            }
            
            // Adresse avec région/ville Sénégal (seulement si n'existent pas)
            if (!Schema::hasColumn('users', 'region')) {
                $table->string('region', 100)->nullable()->after('cni_verification_notes');
            }
            if (!Schema::hasColumn('users', 'ville')) {
                $table->string('ville', 100)->nullable()->after('region');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [];
            
            if (Schema::hasColumn('users', 'phone_verified')) {
                $columns = array_merge($columns, ['phone_verified', 'phone_verification_code', 'phone_verification_code_expires_at']);
            }
            if (Schema::hasColumn('users', 'cni_number')) {
                $columns = array_merge($columns, ['cni_number', 'cni_recto_path', 'cni_verso_path', 'cni_verified', 'cni_verified_at', 'cni_verification_notes']);
            }
            if (Schema::hasColumn('users', 'region')) {
                $columns[] = 'region';
            }
            if (Schema::hasColumn('users', 'ville')) {
                $columns[] = 'ville';
            }
            
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
