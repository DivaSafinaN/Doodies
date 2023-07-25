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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('priority_id')->default(1);
            $table->unsignedBigInteger('task_group_id')->nullable();
            $table->string('task_name');
            $table->text('notes')->nullable();
            $table->text('due_date')->nullable();
            $table->string('file')->nullable();
            $table->boolean('completed')->default(false);
            $table->boolean('add_to_myday')->default(true);
            $table->timestamp('reminder')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('priority_id')->references('id')->on('priorities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('task_group_id')
                ->references('id')
                ->on('task_groups')
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
        Schema::dropIfExists('tasks');
    }
};
