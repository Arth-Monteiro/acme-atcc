<?php

use App\Models\People;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 15);
            $table->string('lastname', 32);
            $table->string('email', 20)->unique();
            $table->string('cpf', 11)->unique();
            $table->string('cellphone', 15);
            $table->string('emergency_contact', 15);
            $table->string('company', 64);
            $table->string('job_title', 20);
            $table->enum('blood_type', People::BLOOD_TYPES);
            $table->enum('qualification', People::QUALIFICATION);
            $table->unsignedInteger('tag_id')->unique();
            $table->foreign('tag_id')->references('id')->on('tags')->nullable();
            $table->string('insert_by', 64);
            $table->string('update_by', 64);
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
        Schema::dropIfExists('people');
    }
}
