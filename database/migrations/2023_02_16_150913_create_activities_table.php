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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('field_id');
            $table->foreignId('group_id');
            $table->string('name');
            $table->bigInteger('budget');
            $table->float('financial_target')->default(0);
            $table->float('financial_realization');
            $table->float('physical_target')->default(0);
            $table->float('physical_realization');
            $table->string('dones')->nullable();
            $table->string('problems')->nullable();
            $table->string('follow_up')->nullable();
            $table->string('todos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
};
