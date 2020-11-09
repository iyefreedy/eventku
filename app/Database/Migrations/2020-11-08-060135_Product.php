<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
			'id' => [
				'type'  => 'INT',
				'constraint' => 11,
				'auto_increment' => true
			],
			'name' => [
				'type'  => 'VARCHAR',
				'constraint' => 50
			],
			'price' => [
				'type'  => 'INT',
				'constraint' => 11
			],
			'description' => [
				'type'  => 'TEXT'
			],
			'image' => [
				'type'  => 'VARCHAR',
				'constraint' => 50
			],
			'created_at' => [
				'type'  => 'DATETIME',
			],
			'updated_at' => [
				'type'  => 'DATETIME',
			]

		]);
		$this->forge->addKey('id');
		$this->forge->createTable('products');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable('products');
	}
}
