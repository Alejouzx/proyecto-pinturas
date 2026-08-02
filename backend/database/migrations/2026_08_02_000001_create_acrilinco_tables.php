<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        Schema::create('acabados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('marca')->default('Acrilinco');
            $table->foreignId('categoria_id')->constrained('categorias')->cascadeOnDelete();
            $table->foreignId('acabado_id')->constrained('acabados')->cascadeOnDelete();
            $table->string('codigo_color_hex', 7);
            $table->string('nombre_color');
            $table->decimal('precio', 12, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->boolean('disponible')->default(true);
            $table->string('imagen_url')->nullable();
            $table->timestamps();
        });

        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_seguimiento', 20)->unique();
            $table->string('cliente_nombre');
            $table->string('cliente_email')->nullable();
            $table->string('cliente_telefono', 20)->nullable();
            $table->decimal('total', 12, 2);
            $table->string('estado')->default('confirmado');
            $table->text('notas')->nullable();
            $table->timestamps();
        });

        Schema::create('pedido_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->unsignedInteger('cantidad');
            $table->decimal('precio_unitario', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->unsignedInteger('stock_actual')->default(0);
            $table->unsignedInteger('stock_minimo')->default(10);
            $table->timestamp('ultima_actualizacion')->useCurrent();
        });

        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo')->nullable();
            $table->foreignId('producto_id')->nullable()->constrained('productos')->nullOnDelete();
            $table->string('cliente_telefono', 20)->nullable();
            $table->text('mensaje')->nullable();
            $table->string('estado')->default('pendiente');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->string('cliente_nombre')->nullable();
            $table->string('cliente_email')->nullable();
            $table->string('cliente_telefono', 20)->nullable();
            $table->decimal('metros_cuadrados', 10, 2)->nullable();
            $table->string('tipo_superficie')->nullable();
            $table->decimal('costo_material', 12, 2)->nullable();
            $table->decimal('costo_mano_obra', 12, 2)->nullable();
            $table->decimal('total', 12, 2)->nullable();
            $table->string('estado')->default('enviado');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presupuestos');
        Schema::dropIfExists('consultas');
        Schema::dropIfExists('inventario');
        Schema::dropIfExists('pedido_items');
        Schema::dropIfExists('pedidos');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('acabados');
        Schema::dropIfExists('categorias');
    }
};
