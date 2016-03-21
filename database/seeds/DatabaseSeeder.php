<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = User::create([
            'name' => 'test',
            'email' => 'test@test.com',
        ]);
        $u->password = '$2y$10$Q7hi.IQlFFY3A96BJveDtOPQ9Nf40i2Vf4QV0g8IoDYA8RZtgTD06';
        $u->save();
    }
}
