<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{

    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Category::class)
                ->constrained()
                ->onDelete('cascade');

            $table->foreignIdFor(User::class)
                ->constrained()
                ->onDelete('cascade');

            $table->string('title');
            $table->longText('content')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
