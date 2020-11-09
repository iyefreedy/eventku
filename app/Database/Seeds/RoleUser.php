<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleUser extends Seeder
{
	public function run()
	{
		//


		$this->db->table('role_user')->insert(['role' => 'Administrator']);
		$this->db->table('role_user')->insert(['role' => 'Member']);
		$this->db->table('role_user')->insert(['role' => 'User']);
	}
}
