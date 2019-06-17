<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('detalle');
            // $table->string('imagen1');
            // $table->string('imagen2');
            $table->integer('descuento')->nullable();
            $table->integer('categoria_id');
            $table->decimal('precio', 8, 0);
            // $table->integer('stock');
            $table->softDeletesTz();
            $table->timestampsTz();
        });

        Schema::create('categorias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->softDeletesTz();
            $table->timestampsTz();
        });

        Schema::create('categoriassecundarias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->softDeletesTz();
            $table->timestampsTz();
        });

        Schema::create('talles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->softDeletesTz();
            $table->timestampsTz();
        });

        Schema::create('colores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->softDeletesTz();
            $table->timestampsTz();
        });

        Schema::create('categoriassecundaria_producto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('categoriassecundaria_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            $table->softDeletesTz();
            $table->timestampsTz();
        });

        Schema::create('producto_talle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('producto_id')->unsigned();
            $table->integer('talle_id')->unsigned();
            $table->softDeletesTz();
            $table->timestampsTz();
        });

        Schema::create('colore_producto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('producto_id')->unsigned();
            $table->integer('colore_id')->unsigned();
            $table->softDeletesTz();
            $table->timestampsTz();
        });

        // Schema::create('stocks', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->integer('producto_id');
        //     $table->integer('producto_talle_id');
        //     $table->integer('colore_producto_id');
        //     $table->integer('cantidad');
        //     $table->softDeletesTz();
        //     $table->timestampsTz();
        // });
        
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('producto_id');
            $table->integer('talle_id');
            $table->integer('cantidad');
            $table->softDeletesTz();
            $table->timestampsTz();
        });


        Schema::create('producto_stock', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('producto_id')->unsigned();
            $table->integer('stock_id')->unsigned();
            $table->softDeletesTz();
            $table->timestampsTz();
        });

        Schema::create('stock_talle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('talle_id')->unsigned();
            $table->integer('stock_id')->unsigned();
            $table->softDeletesTz();
            $table->timestampsTz();
        });

        Schema::create('imagenesdetalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path');
            $table->integer('producto_id')->unsigned();
            $table->softDeletesTz();
            $table->timestampsTz();
        });


        // Schema::create('imagenesdetalle_producto', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->integer('producto_id')->unsigned();
        //     $table->integer('imagenesdetalle_id')->unsigned();
        //     $table->softDeletesTz();
        //     $table->timestampsTz();
        // });

        Schema::create('imagenesshops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path');
            $table->integer('producto_id')->unsigned();
            $table->softDeletesTz();
            $table->timestampsTz();
        });


        // Schema::create('imagenesshop_producto', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->integer('producto_id')->unsigned();
        //     $table->integer('imagenesshop_id')->unsigned();
        //     $table->softDeletesTz();
        //     $table->timestampsTz();
        // });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('categoriasecundarias');
        Schema::dropIfExists('talles');
        Schema::dropIfExists('colores');
        Schema::dropIfExists('categoriasecundaria_producto');
        Schema::dropIfExists('producto_talle');
        Schema::dropIfExists('colore_producto');
        Schema::dropIfExists('stocks');
        Schema::dropIfExists('producto_stock');
        Schema::dropIfExists('imagenesdetalles');
        Schema::dropIfExists('imagenesdetalle_producto');
        Schema::dropIfExists('imagenesshops');
        Schema::dropIfExists('imagenesshop_producto');
    }
}
