<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('employeeperformance', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->unsignedBigInteger('empid'); // Foreign key for employee
            $table->date('date'); // Performance evaluation date
            $table->enum('performance', ['Excellent', 'Good', 'Average', 'Poor']); // Enum field
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('empid')->references('id')->on('employee')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_performance');
    }
};
