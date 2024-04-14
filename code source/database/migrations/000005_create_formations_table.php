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
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('label');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::disableForeignKeyConstraints();

    // Supprimez la table "formations"
    Schema::dropIfExists('formations');

    Schema::enableForeignKeyConstraints();
}
};
