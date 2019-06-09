<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the admin default user
        if (empty(
                DB::table('users')->where('email', 'admin@admin.com')->first()
            )
        ) {
            DB::table('users')->insert([
                'is_admin' => true,
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin@123'),
            ]);
        }

        if (empty(
            DB::table('users')->where('email', 'user@user.com')->first()
            )
        ) {
            // Create the visitor default user
            DB::table('users')->insert([
                'is_admin' => false,
                'first_name' => 'User',
                'last_name' => 'User',
                'email' => 'user@user.com',
                'password' => Hash::make('user@123'),
            ]);
        }
        
        // Seeding the db table with bulk insertion
        factory(User::class, 1000)->create();
    }
}
