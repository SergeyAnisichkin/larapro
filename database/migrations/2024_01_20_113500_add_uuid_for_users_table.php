<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private const TABLE = 'users';
    private const COLUMN = 'uuid';

    public function up(): void
    {
        Schema::table(self::TABLE, static function (Blueprint $table): void {
            $table->string(self::COLUMN);
        });
    }

    public function down(): void
    {
        Schema::table(self::TABLE, static function (Blueprint $table): void {
            $table->dropColumn(self::COLUMN);
        });
    }
};
