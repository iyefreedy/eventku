<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class User extends Seeder
{
	public function run()
	{
		//
		$data = [
			'username' => 'darth',
			'email'    => 'darth@theempire.com'
		];

		// Using Query Builder
		$this->db->table('users')->insert($data);
	}
}
