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
        Schema::create('my_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('priority_id')->default(1);
            $table->string('name');
            $table->text('notes')->nullable();
            $table->string('file')->nullable();
            $table->text('due_date')->nullable();
            $table->boolean('completed')->default(false);
            $table->timestamp('reminder')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('my_days', function (Blueprint $table) {
            $table->foreign('priority_id')->references('id')->on('priorities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_days');
    }
};
