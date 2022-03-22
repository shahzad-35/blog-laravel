<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category');
            $table->timestamps();
        });
        $this->saveCategories();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }

    public function saveCategories()
    {
        $now =Carbon::now();
        $categories = json_decode(file_get_contents(base_path('database/migrations/categories.json')), true);
        foreach (json_decode(file_get_contents(base_path('database/migrations/categories.json')), true) as $key => $category) {
            $categories[$key]['category'] = $category['category'];
            $categories[$key]['created_at'] = $categories[$key]['updated_at'] = $now;
        }
        \DB::table("categories")->insert(array_values($categories));
        return true;
    }
}
