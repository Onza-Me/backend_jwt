<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('blocked_tokens_user_ids')) {
           return;
        }
        Schema::create('blocked_tokens_user_ids', function (Blueprint $table) {
            $table->foreignId('user_id');
            $table->timestamp('expire_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(!Schema::hasTable('blocked_tokens_user_ids')) {
            return;
        }
        Schema::dropIfExists('blocked_tokens_user_ids');
    }
}
