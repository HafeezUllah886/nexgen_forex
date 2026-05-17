<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->foreignId('area_id')->nullable()->after('area')->constrained('areas')->nullOnDelete();
        });

        DB::table('accounts')
            ->select('area')
            ->whereNotNull('area')
            ->where('area', '!=', '')
            ->distinct()
            ->orderBy('area')
            ->get()
            ->each(function ($account) {
                $areaId = DB::table('areas')->insertGetId([
                    'name' => $account->area,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('accounts')
                    ->where('area', $account->area)
                    ->update(['area_id' => $areaId]);
            });
    }

    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('area_id');
        });

        Schema::dropIfExists('areas');
    }
};
