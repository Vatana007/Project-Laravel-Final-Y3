<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // 1. Categories & Positions (Settings) 
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Manager, Cashier
            $table->decimal('base_salary', 10, 2);
            $table->timestamps();
        });

        // 2. People: Suppliers, Customers, Employees 
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Coca-Cola Company
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) { // Members
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
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
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('barcode')->unique();
            $table->decimal('cost_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->integer('qty')->default(0); // Current stock
            $table->string('image')->nullable();
            $table->timestamps();
        });

        // 4. Sales & POS 
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Cashier
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null'); // Member
            $table->string('invoice_number')->unique(); // INV-2023001
            $table->decimal('total_amount', 10, 2); // Subtotal
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('final_total', 10, 2);
            $table->string('payment_type'); // Cash, QR, Card
            $table->timestamps(); // created_at serves as sale date
        });

        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products');
            $table->integer('qty');
            $table->decimal('price', 10, 2); // Price at moment of sale
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        // 5. Inventory Transactions [cite: 4]
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('user_id')->constrained(); // Who did the action
            $table->foreignId('supplier_id')->nullable()->constrained(); // Only for stock in
            $table->enum('type', ['in', 'out', 'sale', 'return', 'broken']);
            $table->integer('qty');
            $table->timestamp('date')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        // Drop all tables in reverse order to avoid foreign key errors
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