<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
	public function up()
	{
		//

		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'auto_increment' => true,
			],
			'email'       => [
				'type'           => 'VARCHAR',
				'constraint'     => '100',
			],
			'name' => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
			],
			'image' => [
				'type'			 => 'VARCHAR',
				'constraint'     => 100,
			],
			'password' => [
				'type'			 => 'VARCHAR',
				'constraint'     => 100,
			],
			'token' => [
				'type'			 => 'VARCHAR',
				'constraint'     => 100,
			],
			'is_active' => [
				'type'			 => 'INT',
				'constraint'     => 1,
			],
			'role_id' => [
				'type'			 => 'INT',
				'constraint'     => 3,
			],
			'created_at' => [
				'type'			 => 'DATETIME',
			],
			'updated_at' => [
				'type'			 => 'DATETIME',
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('user');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('user');
	}
}
