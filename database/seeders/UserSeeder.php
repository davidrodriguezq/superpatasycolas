<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'    => 'Admin Super Patas',
                'email'   => 'admin@superpatasycolas.com',
                'phone'   => '987654321',
                'address' => 'Av. Universitaria 1234, San Martín de Porres, Lima',
                'role'    => 'admin',
            ],
            [
                'name'    => 'María García',
                'email'   => 'maria@superpatasycolas.com',
                'phone'   => '976543210',
                'address' => 'Jr. Los Laureles 456, Los Olivos, Lima',
                'role'    => 'collaborator',
            ],
            [
                'name'    => 'Carlos López',
                'email'   => 'carlos@superpatasycolas.com',
                'phone'   => '965432109',
                'address' => 'Av. Túpac Amaru 789, Comas, Lima',
                'role'    => 'collaborator',
            ],
            [
                'name'    => 'Ana Torres',
                'email'   => 'ana.torres@gmail.com',
                'phone'   => '954321098',
                'address' => 'Jr. Las Flores 321, Independencia, Lima',
                'role'    => 'adopter',
            ],
            [
                'name'    => 'Luis Mendoza',
                'email'   => 'luis.mendoza@gmail.com',
                'phone'   => '943210987',
                'address' => 'Av. Los Alisos 654, Los Olivos, Lima',
                'role'    => 'adopter',
            ],
            [
                'name'    => 'Rosa Flores',
                'email'   => 'rosa.flores@gmail.com',
                'phone'   => '932109876',
                'address' => 'Jr. Las Magnolias 987, San Martín de Porres, Lima',
                'role'    => 'adopter',
            ],
            [
                'name'    => 'Pedro Huamán',
                'email'   => 'pedro.huaman@gmail.com',
                'phone'   => '921098765',
                'address' => 'Av. Canta Callao 147, San Martín de Porres, Lima',
                'role'    => 'surrenderer',
            ],
            [
                'name'    => 'Carmen Quispe',
                'email'   => 'carmen.quispe@gmail.com',
                'phone'   => '910987654',
                'address' => 'Jr. Los Pinos 258, Comas, Lima',
                'role'    => 'surrenderer',
            ],
        ];

        foreach ($users as $data) {
            $role = $data['role'];
            unset($data['role']);

            $user = User::create(array_merge($data, [
                'password' => Hash::make('password'),
            ]));

            $user->assignRole($role);
        }
    }
}
