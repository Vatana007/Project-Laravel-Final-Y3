<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // 1. Categories & Positions
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable(); // Merged from 2026_01_30_030120
            $table->timestamps();
        });

        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('base_salary', 10, 2);
            $table->timestamps();
        });

        // 2. People: Suppliers, Customers, Employees
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('position_id')->constrained()->onDelete('cascade');
            $table->string('phone');
            $table->string('email')->unique();
            $table->date('start_date');
            $table->timestamps();
        });

        // 3. Products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Merged from 2026_01_30_030631: category_id is nullable
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('barcode')->unique();
            $table->decimal('cost_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->integer('qty')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Merged from 2026_01_30_031247
        });

        // 4. Sales & POS
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');
            $table->string('invoice_number')->unique();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('final_total', 10, 2);
            // Merged from 2026_01_24_091652: Changed from payment_type to payment_method
            $table->string('payment_method')->default('cash'); 
            $table->timestamps();
        });

        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products');
            $table->integer('qty');
            $table->decimal('price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        // 5. Inventory Transactions
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('supplier_id')->nullable()->constrained();
            $table->enum('type', ['in', 'out', 'sale', 'return', 'broken']);
            $table->integer('qty');
            $table->text('note')->nullable(); // Merged from 2026_01_30_031904
            $table->timestamp('date')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_transactions');
        Schema::dropIfExists('sale_details');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('products');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('categories');
    }
};