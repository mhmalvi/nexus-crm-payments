<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCoulmnStudenInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_invoice', function (Blueprint $table) {
            //
            $table->renameColumn('Company_id', 'company_id');
            $table->renameColumn('Company_name', 'company_name');
            $table->renameColumn('Company_logo', 'company_logo');
            $table->renameColumn('Course_code', 'course_code');
            $table->renameColumn('Course_title', 'course_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_invoice', function (Blueprint $table) {
            //
        });
    }
}
