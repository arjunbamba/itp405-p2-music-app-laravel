<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role; //importing the Role model we created via (php artisan make:model Role)

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            // Will have 2 roles in roles table (user and admin) 
            // In app, different checks that allow us to do different things based on the role
            // Cannot write that logic depending on name because name can change (i.e. admin to superadmin)
            // Slug is string key that will represent role and stay fixed throughout application
            $table->string('name'); //creating columns
            $table->string('slug'); 
            $table->timestamps();
        });

        // Create role id foreign key column on the users table
        // Modifying the users table and adding a role_id foreign key
        Schema::table('users', function (Blueprint $table) {
            // $table->foreign('role_id')->references('id')->on('roles');
            $table->foreignId('role_id')->constrained(); //another equivalent way 
        });

        // See the db with the 2 roles we care about - user and admin
        // See the roles table with default data that's gonna be used in dev and production environment 
        $roles = [
            'user' => 'User',
            'admin' => 'Admin',
        ];

        foreach ($roles as $slug => $name) {
            // $role = new Role(); // will create Eloquent model for this
            // $role->slug = $slug;
            // $role->name = $name;
            // $role->save();

            // Mass Assignment
            // Not allowed to call static method create on our eloquent model and pass it data
            // Must specify the properties that you want to be allowed to be mass assigned
            // If you do this, need to specify protected fillable property that is the columns that you want to allow for mass assignment 
            Role::create([
                'slug' => $slug,
                'name' => $name,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove the role_id foreign key column on users table
        Schema::dropColumns('users', ['role_id']);

        Schema::dropIfExists('roles');
    }
}
