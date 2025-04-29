
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pages', function($table) {

            $table->string('image');

        });
    }

    public function down()
    {
        Schema::dropIfExists('pages');
    }
};