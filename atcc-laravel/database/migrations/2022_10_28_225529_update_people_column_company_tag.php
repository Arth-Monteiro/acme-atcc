<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePeopleColumnCompanyTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('people', function(Blueprint $table) {
            $table->unsignedInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->dropUnique('people_email_unique');
            $table->dropUnique('people_cpf_unique');
            $table->dropColumn('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('people', function(Blueprint $table) {
            $table->dropColumn('company_id');
            $table->unsignedInteger('tag_id')->nullable();
            $table->unique('cpf');
            $table->unique('email');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }
}
