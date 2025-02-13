<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('employeeperformance', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('empid'); 
            $table->date('date');
            $table->enum('performance', ['Excellent', 'Good', 'Average', 'Poor']); 
            $table->timestamps();

            
            $table->foreign('empid')->references('id')->on('employee')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_performance');
    }
};
