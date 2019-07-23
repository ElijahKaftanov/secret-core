<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Base extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table)  {
            $table->integerIncrements('id');
            $table->string('username')->unique();
            $table->text('public_key');

            $table->timestamps();
        });

        Schema::create('secrets', function (Blueprint $table)  {
            $table->integerIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->text('message');

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secrets');
        Schema::dropIfExists('users');
    }
}
