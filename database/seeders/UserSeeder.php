<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Permissions\UserRole;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        if(User::where('email','=', 'super@admin.com')->count() == 0) {

            $superUser = User::firstOrCreate([
                'name' => 'Super Admin',
                'email' => 'super@admin.com',
                'password' =>  bcrypt('$up3r4dmin'),
                'status' =>  true,
            ]);

            UserRole::firstOrCreate([
                'user_id' => $superUser->id,
                'role_id' => 1
            ]);
        }        
    }
}
