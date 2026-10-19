<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add comprehensive fields to drivers table
        Schema::table('drivers', function (Blueprint $table) {
            $table->date('dob')->nullable()->after('user_id');
            $table->string('license_file')->nullable()->after('license_number');
            $table->string('ghana_card_no')->nullable()->after('license_file');
            $table->string('ghana_card_file')->nullable()->after('ghana_card_no');
            $table->string('passport_file')->nullable()->after('ghana_card_file');
            $table->string('previous_employer')->nullable()->after('experience_years');
            $table->string('reference_phone')->nullable()->after('previous_employer');
            $table->string('guarantor')->nullable()->after('reference_phone');
            $table->string('guarantor_phone')->nullable()->after('guarantor');
            $table->string('g_ghana_card_no')->nullable()->after('guarantor_phone');
            $table->string('guarantor_ghana_card_file')->nullable()->after('g_ghana_card_no');
            $table->string('relationship')->nullable()->after('guarantor_ghana_card_file');
            $table->string('emergency_person')->nullable()->after('relationship');
            $table->string('emergency_phone')->nullable()->after('emergency_person');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending')->after('emergency_phone');
            $table->string('payment_reference')->nullable()->after('payment_status');
        });

        // Add comprehensive fields to vehicles table
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('registration_number')->nullable()->after('license_plate');
            $table->string('color')->nullable()->after('registration_number');
            $table->string('vin')->nullable()->unique()->after('color');
            $table->enum('fuel_type', ['petrol', 'diesel', 'hybrid', 'electric', 'gas'])->nullable()->after('vin');
            $table->enum('transmission', ['manual', 'automatic'])->nullable()->after('fuel_type');
            $table->string('engine_size')->nullable()->after('transmission');
            $table->date('insurance_expiry')->nullable()->after('engine_size');
            $table->date('inspection_expiry')->nullable()->after('insurance_expiry');
            $table->date('registration_expiry')->nullable()->after('inspection_expiry');
            $table->integer('mileage')->nullable()->after('registration_expiry');
            $table->integer('number_of_seats')->nullable()->after('mileage');
            $table->string('registration_document')->nullable()->after('number_of_seats');
            $table->string('insurance_document')->nullable()->after('registration_document');
            $table->string('inspection_certificate')->nullable()->after('insurance_document');
        });

        // Add more fields to users table
        Schema::table('users', function (Blueprint $table) {
            $table->date('dob')->nullable()->after('address');
            $table->string('ghana_card_no')->nullable()->after('dob');
            $table->string('passport_no')->nullable()->after('ghana_card_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn([
                'dob',
                'license_file',
                'ghana_card_no',
                'ghana_card_file',
                'passport_file',
                'previous_employer',
                'reference_phone',
                'guarantor',
                'guarantor_phone',
                'g_ghana_card_no',
                'guarantor_ghana_card_file',
                'relationship',
                'emergency_person',
                'emergency_phone',
                'payment_status',
                'payment_reference',
            ]);
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'registration_number',
                'color',
                'vin',
                'fuel_type',
                'transmission',
                'engine_size',
                'insurance_expiry',
                'inspection_expiry',
                'registration_expiry',
                'mileage',
                'number_of_seats',
                'registration_document',
                'insurance_document',
                'inspection_certificate',
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'dob',
                'ghana_card_no',
                'passport_no',
            ]);
        });
    }
};
