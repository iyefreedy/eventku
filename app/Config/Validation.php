<?php

namespace Config;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var array
	 */
	public $ruleSets = [
		\CodeIgniter\Validation\Rules::class,
		\CodeIgniter\Validation\FormatRules::class,
		\CodeIgniter\Validation\FileRules::class,
		\CodeIgniter\Validation\CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------

	public $register = [
		'name' => [
			'label'	=> 'Full Name',
			'rules' => 'required|trim',
			'errors' => [
				'required'	=> '{field} tidak boleh kosong'
			]
		],
		'email' => [
			'label'	=> 'Email',
			'rules' => 'required|is_unique[user.email]|trim|valid_email',
			'errors' => [
				'required' => '{field} tidak boleh kosong',
				'is_unique' => '{field} sudah terdaftar',
				'valid_email' => '{field} tidak valid'
			]
		],
		'password' => [
			'label' => 'Password',
			'rules' => 'required|trim|min_length[3]|matches[confirmpassword]',
			'errors' => [
				'required' => '{field} tidak boleh kosong',
				'min_length' => '{field} tidak boleh kurang dari 3 karakter',
				'matches' => 'Konfirmasi Password tidak sama dengan {field}'
			]
		]
	];

	public $login = [
		'email' => [
			'label'	=> 'Email',
			'rules' => 'required|trim|valid_email',
			'errors' => [
				'required' => '{field} tidak boleh kosong',
				'valid_email' => '{field} tidak valid'
			]
		],
		'password' => [
			'label' => 'Password',
			'rules' => 'required|trim|min_length[3]',
			'errors' => [
				'required' => '{field} tidak boleh kosong',
				'min_length' => '{field} tidak boleh kurang dari 3 karakter'
			]
		]
	];
}
