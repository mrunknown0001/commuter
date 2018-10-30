<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 30);
            $table->string('last_name', 30);
            $table->tinyInteger('user_type')->default(1); // 1 for commuters, 2 for drivers
            $table->string('student_number', 10)->nullable()->unique(); // for students
            $table->string('username', 20)->nullable()->unique();
            $table->string('mobile_number', 11)->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('active')->default(0); // 1 for active users, 0 for deactivated users
            $table->tinyInteger('registered')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
