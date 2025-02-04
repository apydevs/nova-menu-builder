<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use OptimistDigital\MenuBuilder\MenuBuilder;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    public function up()
    {
        Schema::create(MenuBuilder::getMenusTableName(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create(MenuBuilder::getMenuItemsTableName(), function (Blueprint $table) {
            $table->bigIncrements('id')->index();
            $table->unsignedBigInteger('menu_id')->nullable()->index();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->string('short_text')->nullable();
            $table->string('locale');
            $table->string('class')->nullable();
            $table->string('value')->nullable();
            $table->string('target')->default('_self');
            $table->json('data')->nullable();
            $table->integer('parent_id')->nullable()->index();
            $table->integer('order');
            $table->boolean('enabled')->default(1);
            $table->timestamps();

            $table->foreign('menu_id')->references('id')->on(MenuBuilder::getMenusTableName())->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists(MenuBuilder::getMenuItemsTableName());
        Schema::dropIfExists(MenuBuilder::getMenusTableName());
    }
}
