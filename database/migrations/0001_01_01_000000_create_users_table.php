<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Tabel admins berasal dari database PHP Native.
     * Migration ini sengaja dikosongkan agar Laravel tidak membuat ulang tabel admins.
     */
    public function up(): void {}

    public function down(): void {}
};
