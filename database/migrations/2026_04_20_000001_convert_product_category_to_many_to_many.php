<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->primary(['category_id', 'product_id']);
        });

        DB::table('products')
            ->whereNotNull('category_id')
            ->get(['id', 'category_id'])
            ->each(fn($p) => DB::table('category_product')->insert([
                'category_id' => $p->category_id,
                'product_id'  => $p->id,
            ]));

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropIndex(['category_id']);
            $table->dropColumn('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
        });

        DB::table('category_product')->get()->each(function ($row) {
            DB::table('products')->where('id', $row->product_id)
                ->whereNull('category_id')
                ->update(['category_id' => $row->category_id]);
        });

        Schema::dropIfExists('category_product');
    }
};
