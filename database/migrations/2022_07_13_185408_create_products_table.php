<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nombre del producto');
            $table->string('description')->nullable()->comment('Descripción del producto');
            $table->integer('qty')->comment('Cantidad del producto');
            $table->decimal('price', 10, 2)->comment('Precio del producto');
            $table->unsignedBigInteger('category_id')->comment('Categoría del producto');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('no action')->onUpdate('no action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
