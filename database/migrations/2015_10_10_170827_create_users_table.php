<?php

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
            $table->string('email')->unique();
            $table->string('username')->nullable()->index();
            $table->string('password');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('ic_number')->nullable();
            $table->string('avatar')->nullable();
            $table->string('address')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('wakalah_id')->nullable();
            $table->string('wakalah_type')->nullable();
            $table->string('institution_name')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('role_id');
            $table->date('birthday')->nullable();
            $table->string('hash', 40)->unique();
            $table->string('device_id', 255)->nullable();
            $table->text('last_token')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('confirmation_code', 10)->nullable();
            $table->integer('confirmation_expiry')->nullable();
            $table->string('confirmation_token', 60)->nullable();
            $table->string('status', 20)->index();
            $table->integer('two_factor_country_code')->nullable();
            $table->integer('two_factor_phone')->nullable();
            $table->text('two_factor_options')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
