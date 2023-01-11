<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWakalahApplicationsTable extends Migration
{
    // This is the wakalah application migration file;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wakalah_applications', function (Blueprint $table) {
                $table->id();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('email')->unique();
                $table->string('ic_number')->nullable();
                $table->string('phone')->nullable();
                $table->string('wakalah_type')->nullable();
                $table->string('address')->nullable();
                $table->string('institution_name')->nullable();
                $table->string('city')->nullable();
                $table->string('state')->nullable();
                $table->string('zip')->nullable();
                $table->string('bank_account')->nullable();
                $table->string('bank_name')->nullable();
                $table->unsignedBigInteger('status_id')->default(3);
                $table->string('affiliate_link')->nullable();
                $table->string('wakalah_id')->nullable();
                $table->string('rejection_reason')->nullable();
                $table->string('approval_by')->nullable();
                $table->string('approval_at')->timestamps();
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
        Schema::dropIfExists('wakalah_applications');
    }
}
