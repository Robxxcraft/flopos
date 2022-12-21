<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('total_amount');
            $table->bigInteger('total_quantity');
            $table->enum('courier', ['GoSend', 'JNE', 'JNT', 'Sicepat']);
            $table->enum('payment', ['Cash', 'Credit']);
            $table->text('address');
            $table->string('zipcode');
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
