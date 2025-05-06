<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id('feedback_id'); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key
            $table->string('title'); // Title column to store the latest logged user_id title
            $table->string('message'); // Message to admin
            $table->string('admin_response')->nullable(); // Admin response (nullable)
            $table->boolean('is_read')->default(false); // Track if the response has been read
            $table->timestamp('date_sent')->useCurrent(); // Date sent
            $table->timestamps(); // Laravel's created_at and updated_at

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback');
    }
}
