<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key');

            $table->json('value')->nullable();

            $table->primary(['key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
