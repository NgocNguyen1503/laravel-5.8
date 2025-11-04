<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    private $names = [
        'Akira Nguyen',
        'Minh Tran',
        'Lan Pham',
        'Tuan Le',
        'Hanh Do',
        'Khoa Bui',
        'Nhi Vo',
        'Quang Ho',
        'Huong Dang',
        'Nam Phan',
    ];

    private $emails = [
        'akira.nguyen@example.com',
        'minh.tran@example.com',
        'lan.pham@example.com',
        'tuan.le@example.com',
        'hanh.do@example.com',
        'khoa.bui@example.com',
        'nhi.vo@example.com',
        'quang.ho@example.com',
        'huong.dang@example.com',
        'nam.phan@example.com',
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => $this->names[$i],
                'email' => $this->emails[$i],
                'password' => Hash::make("12345678"),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
