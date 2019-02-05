<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsAndAssetPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('symbol');

            $table->timestamps();
        });

        Schema::create('asset_prices', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('asset_id');
            $table->foreign('asset_id')->references('id')->on('assets');
            $table->decimal('price', 20, 8);
            $table->unsignedInteger('trade_volume');
            $table->dateTime('timestamp');

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
        Schema::dropIfExists('assets');
        Schema::dropIfExists('asset_prices');
    }
}
