<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->unsigned()->nullable();
            $table->foreign('admin_id')->references('id')->on('admin_ids');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('identification')->unique();
            $table->tinyInteger('role')->default(2); // 1 for superadmin, 2 for regular admins
            $table->string('mobile_number')->nullable()->unique();
            // $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->tinyInteger('active')->default(1);
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
        Schema::dropIfExists('admins');
    }
}
