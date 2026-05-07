<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('name');
        });

        $products = DB::table('products')->orderBy('id')->get();
        foreach ($products as $product) {
            $base = Str::slug($product->name) ?: 'product-' . $product->id;
            $slug = $base;
            $i = 2;
            while (DB::table('products')->where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }
            DB::table('products')->where('id', $product->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
