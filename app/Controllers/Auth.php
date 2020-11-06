<?php

namespace App\Controllers;

use App\Models\UserModel as UserModel;

class Auth extends BaseController
{
	public function index()
	{
		$data = [
			'title' => 'Login | Eventku',
			'validation' => $this->validator
		];

		if ($this->request->getPost()) {

			$input = [
				'email' => $this->request->getPost('email'),
				'password' => $this->request->getPost('password')
			];

			if (!$this->validator->run($input, 'login')) {
				return redirect()->to('/auth')->withInput();
			} else {

				$userModel = new UserModel();
				$user = $userModel->where(['email' => $input['email']])->first();

				if (!$user) {
					session()->setFlashdata('error', 'Email belum terdaftar');
					return redirect()->to('/auth')->withInput();
				} else {

					if (!password_verify($input['password'], $user->password)) {
						session()->setFlashdata('error', 'Password salah');
						return redirect()->to('/auth')->withInput();
					} else {

						if ($user->is_active == 0) {
							session()->setFlashdata('error', 'Email belum di aktivasi. Lakukan aktivasi terlebih dahulu');
							return redirect()->to('/auth')->withInput();
						} else {
							return redirect()->to('/user');
						}
					}
				}
			}
		}
		return view('auth/login', $data);
	}

	public function register()
	{
		$data = [
			'title' => 'Register | Eventku',
			'validation' => $this->validator
		];

		if ($this->request->getPost()) {
			$input = [
				'name' => $this->request->getPost('name'),
				'email' => $this->request->getPost('email'),
				'password'	=> $this->request->getPost('password'),
				'confirmpassword' => $this->request->getPost('confirmpassword')
			];

			if (!$this->validator->run($input, 'register')) {
				return redirect()->to('/auth/register')->withInput();
			} else {
				$userModel = new UserModel();
				$user = new \App\Entities\User();

				$token = base64_encode(random_bytes(32));
				$user->name = $input['name'];
				$user->email = $input['email'];
				$user->password = $input['password'];
				$user->image = 'default.jpg';
				$user->is_active = 0;
				$user->token = $token;
				$user->role_id = 3;

				$reg = $userModel->save($user);

				if ($reg) {
					$this->_sendMail($input['email'], $token);
				} else {
					return redirect()->to('/auth/register')->withInput();
				}
			}
		}
		return view('auth/register', $data);
	}

	public function forgotpassword()
	{
		return view('auth/forgotpassword');
	}

	public function verify()
	{
		$email = $this->request->getGet('email');
		$token = $this->request->getGet('token');

		$userModel = new UserModel();
		$user = $userModel->where(['email' => $email])->first();

		if ($user->token == $token) {
			$user =
				$userModel->save([
					'id'	=> $user->id,
					'is_active' => 1
				]);
		}

		session()->setFlashdata('success', 'Akun anda telah di aktivasi. Silahkan login');
		return redirect()->to('/auth')->withInput();
	}

	//--------------------------------------------------------------------

	private function _sendMail($user, $token)
	{

		$config['protocol'] = 'smtp';
		$config['SMTPHost'] = 'smtp.gmail.com';
		$config['SMTPUser'] = 'quraisy2104@gmail.com';
		$config['SMTPPass'] = 'iye83616766';
		$config['SMTPPort'] = 465;
		$config['SMTPCrypto'] = 'ssl';
		$config['mailType'] = 'html';

		$email = \Config\Services::email();
		$email->initialize($config);
		$body = 'Click this link to verify your account : <a href="' . base_url() . '/auth/verify?email=' . $user . '&token=' . urlencode($token) . '">Activation</a>';

		$email->setFrom('quraisy2104@gmail.com', 'Eventku');
		$email->setTo($user);
		$email->setSubject('Activation');
		$email->setMessage($body);

		if ($email->send()) {
			session()->setFlashdata('success', 'Berhasil mendaftar. Silahkan cek email untuk melakukan verifikasi.');
			return redirect()->to('/auth')->withInput();
		} else {
			echo $email->printDebugger();
		}
	}
}
