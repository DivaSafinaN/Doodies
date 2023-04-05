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
            $table->foreignId('task_group_id')->constrained();
            $table->unsignedBigInteger('priority_id')->default(1);
            $table->string('name');
            $table->text('notes')->nullable();
            $table->text('due_date')->nullable();
            $table->boolean('completed')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('tasks', function (Blueprint $table) {
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
        Schema::dropIfExists('tasks');
    }
};
