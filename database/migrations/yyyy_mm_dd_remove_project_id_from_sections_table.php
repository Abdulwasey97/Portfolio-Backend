<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sections', function (Blueprint $table) {
            if (Schema::hasColumn('sections', 'project_id')) {
                $table->dropForeign(['project_id']);
                $table->dropColumn('project_id');
            }
        });
    }

    public function down()
    {
        Schema::table('sections', function (Blueprint $table) {
            if (!Schema::hasColumn('sections', 'project_id')) {
                $table->foreignId('project_id')->nullable()->after('page_id');
                $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            }
        });
    }
};
