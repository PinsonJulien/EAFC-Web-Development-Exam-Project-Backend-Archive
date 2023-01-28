<?php

use App\Models\SiteRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Country;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Account
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();

            // Personal data
            $table->string('lastname');
            $table->string('firstname');
            $table->foreignIdFor(Country::class, 'nationality_country_id');
            $table->date('birthdate');
            $table->string('address');
            $table->string('postal_code'); // Because it avoids conversions of 0001 to 1; or allows letters for some countries.
            $table->foreignIdFor(Country::class, 'address_country_id');
            $table->string('phone', 50);
            $table->string('picture')->nullable();

            $table->foreignIdFor(SiteRole::class);


            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
