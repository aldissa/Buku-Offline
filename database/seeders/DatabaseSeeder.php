<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'kasir2',
            'username' => 'kasir2',
            'password' => bcrypt('kasir2'),
            'role'  => 'kasir'
        ]);
        User::create([
            'name' => 'admin1',
            'username' => 'admin1',
            'password' => bcrypt('admin1'),
            'role'  => 'admin'
        ]);
        User::create([
            'name' => 'owner1',
            'username' => 'owner1',
            'password' => bcrypt('owner1'),
            'role'  => 'owner'
        ]);

        Buku::create([
            'nama' => 'Jujutsu kaisen',
            'foto' => 'img/jjk5.jpg',
            'deskripsi' => 'Jujutsu kaisen Vol 4',
            'harga' => '20000',
            'status' => 'dijual',
            'stok' => '10'
        ]);
        Buku::create([
            'nama' => 'Melangkah',
            'foto' => 'img/melangkah.jpg',
            'deskripsi' => 'Teruslah Melangkah',
            'harga' => '10000',
            'status' => 'tidak dijual',
            'stok' => '15'
        ]);
    }
}
