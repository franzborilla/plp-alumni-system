<?php


namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{


    public function run(): void
    {
        DB::table('users')->insert([


            // Admin
            [
                'username' => 'franz',
                'password' => Hash::make('Franz23_'),
                'last_name' => 'Borilla',
                'first_name' => 'Francene Doroty',
                'middle_name' => 'Binalay',
                'suffix' => null,
                'email' => 'franceneborilla@gmail.com',
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],


            // Alumni
            [
                'username' => 'jpborleo',
                'password' => Hash::make('P@ul02_'),
                'last_name' => 'Borleo',
                'first_name' => 'John Paul',
                'middle_name' => 'Ermeo',
                'suffix' => null,
                'email' => 'jpborleo@gmail.com',
                'role' => 'alumni',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'lexixieya',
                'password' => Hash::make('Zhanie09_'),
                'last_name' => 'Chavez',
                'first_name' => 'Zhan Lexie',
                'middle_name' => 'Magdayao',
                'suffix' => null,
                'email' => 'zhanlexiechavez@gmail.com',
                'role' => 'alumni',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],


            // Additional 10 Alumni
            [
                'username' => 'marktorres',
                'password' => Hash::make('Mark24_'),
                'last_name' => 'Torres',
                'first_name' => 'Mark Angelo',
                'middle_name' => 'Santos',
                'suffix' => null,
                'email' => 'marktorres@gmail.com',
                'role' => 'alumni',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'claracastro',
                'password' => Hash::make('Clara25_'),
                'last_name' => 'Castro',
                'first_name' => 'Clara Mae',
                'middle_name' => 'Villanueva',
                'suffix' => null,
                'email' => 'claracastro@gmail.com',
                'role' => 'alumni',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'joshlim',
                'password' => Hash::make('Josh19_'),
                'last_name' => 'Lim',
                'first_name' => 'Joshua',
                'middle_name' => 'Tan',
                'suffix' => null,
                'email' => 'joshlim@gmail.com',
                'role' => 'alumni',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'samanthacruz',
                'password' => Hash::make('Sam22_'),
                'last_name' => 'Cruz',
                'first_name' => 'Samantha',
                'middle_name' => 'De Leon',
                'suffix' => null,
                'email' => 'samanthacruz@gmail.com',
                'role' => 'alumni',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'kevinlopez',
                'password' => Hash::make('Kevin20_'),
                'last_name' => 'Lopez',
                'first_name' => 'Kevin',
                'middle_name' => 'Garcia',
                'suffix' => null,
                'email' => 'kevinlopez@gmail.com',
                'role' => 'alumni',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'michelleong',
                'password' => Hash::make('Miche23_'),
                'last_name' => 'Ong',
                'first_name' => 'Michelle',
                'middle_name' => 'Lim',
                'suffix' => null,
                'email' => 'michelleong@gmail.com',
                'role' => 'alumni',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'carlareyes',
                'password' => Hash::make('Carla21_'),
                'last_name' => 'Reyes',
                'first_name' => 'Carla',
                'middle_name' => 'Domingo',
                'suffix' => null,
                'email' => 'carlareyes@gmail.com',
                'role' => 'alumni',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'miguelramos',
                'password' => Hash::make('Miguel22_'),
                'last_name' => 'Ramos',
                'first_name' => 'Miguel',
                'middle_name' => 'Fernandez',
                'suffix' => null,
                'email' => 'miguelramos@gmail.com',
                'role' => 'alumni',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'angelasantos',
                'password' => Hash::make('Angela23_'),
                'last_name' => 'Santos',
                'first_name' => 'Angela',
                'middle_name' => 'Perez',
                'suffix' => null,
                'email' => 'angelasantos@gmail.com',
                'role' => 'alumni',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'johndelacruz',
                'password' => Hash::make('John24_'),
                'last_name' => 'Dela Cruz',
                'first_name' => 'John',
                'middle_name' => 'Marquez',
                'suffix' => null,
                'email' => 'johndelacruz@gmail.com',
                'role' => 'alumni',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
