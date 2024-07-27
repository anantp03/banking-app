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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('account_number')->unique();
            $table->decimal('balance',15,2)->default(10000.00);
            $table->string('firstname');
            $table->string('lastname');
            $table->string('dob');
            $table->text('address');
            $table->tinyInteger('status')->default(1)->comment('0 - Inactive | Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
