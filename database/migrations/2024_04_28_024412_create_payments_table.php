<?php

use App\Models\OrderItems;
use App\Models\Orders;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Orders::class)->constrained();
            $table->float('amount');
            $table->timestamp('payment_date');
            $table->tinyInteger('payment_method')->default(0)->comment('0:thanh toán khi nhận hàng. 1:Ví VNPay');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
