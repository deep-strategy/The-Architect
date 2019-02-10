<?php

use App\Models\PriceFrequency;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceFrequenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_frequencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::table('asset_prices', function (Blueprint $table) {
           $table->unsignedInteger('price_frequency_id');
           $table->foreign('price_frequency_id')->references('id')->on('price_frequencies');
           $table->unique(['asset_id', 'price_frequency_id', 'timestamp']);
           $table->dropUnique('asset_prices_asset_id_timestamp_unique');
        });

        PriceFrequency::create(['identifier' => '1 minute interval', 'slug' => '1min']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_frequencies');
    }
}
