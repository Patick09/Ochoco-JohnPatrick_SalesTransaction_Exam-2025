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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique(); // unique transaction ID
            $table->string('product_name'); // product/service name
            $table->decimal('amount', 10, 2); // sale amount
            $table->integer('quantity')->default(1); // quantity sold
            $table->decimal('total_amount', 10, 2); // total amount (amount * quantity)
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->date('sale_date'); // sale date
            $table->time('sale_time'); // sale time
            $table->text('notes')->nullable(); // additional notes
            $table->unsignedBigInteger('customer_id'); // foreign key to customers
            $table->timestamps();
        });
        
        // Add foreign key constraint after table creation
        Schema::table('sales', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
