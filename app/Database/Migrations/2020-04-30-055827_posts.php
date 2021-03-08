<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE
			],
			'userId' => [
				'type' => 'VARCHAR',
				'constraint' => 100
			],
			'title' => [
				'type' => 'VARCHAR',
				'constraint' => 100
			],
			'body' => [
				'type' => 'TEXT',
				'constraint' => NULL
			]
			
		]);
		$this->forge->addKey('id');
		$this->forge->createTable('posts');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
