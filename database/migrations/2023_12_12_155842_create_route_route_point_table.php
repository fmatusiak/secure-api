<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('route_route_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('route_id')->index();
            $table->unsignedBigInteger('route_point_id')->index();
            $table->integer('order');
            $table->time('arrival_time')->nullable();
            $table->timestamps();

            $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
            $table->foreign('route_point_id')->references('id')->on('route_points')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_route_point');
    }
};
