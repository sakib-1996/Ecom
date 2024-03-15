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
        Schema::create('product_s_e_o_s', function (Blueprint $table) {
            $table->id(); 
        
            $table->string('meta_title')->nullable(); 
            $table->unsignedBigInteger('product_id'); 
            $table->string('meta_des')->nullable(); 
            $table->string('meta_img')->nullable();
            $table->string('meta_slug')->nullable(); 
        
            $table->timestamps();
        
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_s_e_o_s');
    }
};
