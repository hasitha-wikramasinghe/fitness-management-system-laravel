    <?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainees', function (Blueprint $table) {
            $table->bigInteger('id'); 
            $table->string('name', 100);
            $table->string('gender', 100);
            $table->date('date_of_birth');
            $table->string('email', 100);
            $table->unsignedInteger('attended_sessions')->default(0);
            $table->boolean('confirmed')->default(0);
            $table->string('password');
            $table->string('password_confirmation');
            $table->string('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainees');
    }
}
