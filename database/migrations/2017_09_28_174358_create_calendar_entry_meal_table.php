<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarEntryMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_entry_meal', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('meal_id');
            $table->unsignedInteger('calendar_entry_id');
            $table->unsignedInteger('rule_id')->nullable();
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
        Schema::dropIfExists('calendar_entry_meal');
    }
}
