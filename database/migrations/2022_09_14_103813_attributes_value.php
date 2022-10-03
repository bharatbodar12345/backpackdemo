<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AttributesValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes_value', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('attributes_id')->nullable();
            $table->text('attribute_name')->nullable();
            $table->bigInteger('status')->nullable()->default(1)->comment('0 = Deactive, 1 = Active');
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
        Schema::dropIfExists('attributes_value');

    }
}
