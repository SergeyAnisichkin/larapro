<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private const TABLE_NAME = 'tg_app_configs';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('app_name');
            $table->string('app_id');
            $table->string('api_hash');
            $table->string('test_server');
            $table->string('prod_server');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
