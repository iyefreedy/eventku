<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RoleUser extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
			'id'	=> [
				'type'				=> 'INT',
				'auto_increment'	=> true
			],
			'role'	=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> 100
			]
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('role_user');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('role_user');
	}
}
