<?php

namespace App\Controllers;

use App\Models\UserModel as UserModel;

class Auth extends BaseController
{
	public function login()
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
				return redirect()->to('/auth/login')->withInput();
			} else {
				$email = $this->request->getPost('email');
				$password = $this->request->getPost('password');
				$userModel = new UserModel();
				$user = $userModel->where(['email' => $email])->first();


				if ($user) {

					$user = $user->toArray();
					if (!password_verify($password, $user['password'])) {
						session()->setFlashdata('error', 'Password salah');
						return redirect()->to('/auth/login')->withInput();
					} else {
						if ($user['is_active'] == 0) {
							session()->setFlashdata('error', 'Email belum di aktivasi');
							return redirect()->to('/auth/login')->withInput();
						} else {
							$data = [
								'logged_in'	=> true,
								'email' => $email,
								'role_id' => $user['role_id']
							];
							session()->set($data);
							return redirect()->to('/user');
						}
					}
				} else {
					session()->setFlashdata('error', 'Email belum terdaftar');
					return redirect()->to('/auth/login')->withInput();
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
					$this->_sendMail($input['email'], $token, 'verify');
					session()->setFlashdata('success', 'Berhasil mendaftar. Silahkan cek email untuk melakukan verifikasi.');
					return redirect()->to('/auth/login')->withInput();
				}
			}
		}
		return view('auth/register', $data);
	}

	public function forgotpassword()
	{
		$data = [
			'title' => 'Lupa Password | Eventku'
		];

		if ($this->request->getPost()) {
			$input = [
				'email'	=> $this->request->getPost('email')
			];

			if (!$this->validator->run($input, 'forgotpassword')) {
				return redirect()->to('/auth/forgotpassword')->withInput();
			} else {

				$email = $this->request->getPost('email');
				$userModel = new UserModel();
				$user = $userModel->where(['email' => $email, 'is_active' => 1])->first();

				if ($user) {
					$token = base64_encode(random_bytes(32));
					$user->token = $token;
					$userModel->save($user);

					$this->_sendMail($user->email, $user->token, 'forgotpassword');

					session()->setFlashdata('success', 'Silahkan cek email anda. Dan klik link untuk reset password');
					return redirect()->to('/auth/login')->withInput();
				} else {
					session()->setFlashdata('error', 'Email belom terdaftar atau di aktivasi!');
					return redirect()->to('/auth/forgotpassword')->withInput();
				}
			}
		}

		return view('auth/forgot_password', $data);
	}

	public function resetpassword()
	{
		$email = $this->request->getGet('email');
		$token = $this->request->getGet('token');

		$userModel = new UserModel();
		$user = $userModel->where(['email' => $email, 'token' => $token])->first();
		if ($user) {
			session()->set(['id' => $user->id, 'email' => $user->email]);
			return redirect()->to('/auth/updatepassword');
		} else {
			session()->setFlashdata('error', 'Email atau token tidak valid');
			return redirect()->to('/auth/login')->withInput();
		}
	}


	public function updatepassword()
	{
		if (!session()->has('email')) {
			session()->setFlashdata('error', 'Masukkan email anda');
			return redirect()->to('/auth/forgotpassword')->withInput();
		}

		$data = [
			'title' => 'Reset Password | Eventku',
			'validation' => $this->validator
		];

		if ($this->request->getPost()) {
			$input = [
				'password' => $this->request->getPost('password'),
				'confirmpassword'	=> $this->request->getPost('confirmpassword')
			];

			if ($this->validator->run($input, 'resetpassword')) {
				$userModel = new UserModel();
				$id = session()->get('id');
				$password = $this->request->getPost('password');
				$user = $userModel->find($id);
				$user->password = $password;

				$userModel->update($user->id, ['password' => $user->password]);
				session()->destroy();
				session()->setFlashdata('success', 'Berhasil reset password');
				return redirect()->to('/auth/login')->withInput();
			} else {
				return redirect()->to('/auth/updatepassword')->withInput();
			}
		}


		return view('auth/reset_password', $data);
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
		return redirect()->to('/auth/login')->withInput();
	}

	public function logout()
	{
		dd(session()->get());
		session()->destroy();
		return redirect()->to('/auth/login');
	}

	//--------------------------------------------------------------------


	private function _sendMail($user, $token, $type)
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
		$bodyAcitvate = 'Click this link to verify your account : <a href="' . base_url() . '/auth/verify?email=' . $user . '&token=' . urlencode($token) . '">Activation</a>';
		$bodyForgotPassword = 'Click this link to reset your password : <a href="' . base_url() . '/auth/resetpassword?email=' . $user . '&token=' . urlencode($token) . '">Activation</a>';

		if ($type == 'verify') {

			$email->setFrom('quraisy2104@gmail.com', 'Eventku');
			$email->setTo($user);
			$email->setSubject('Activation');
			$email->setMessage($bodyAcitvate);
		} elseif ($type == 'forgotpassword') {

			$email->setFrom('quraisy2104@gmail.com', 'Eventku');
			$email->setTo($user);
			$email->setSubject('Forfot Password');
			$email->setMessage($bodyForgotPassword);
		}


		if (!$email->send()) {
			dd($email->printDebugger());
		}
	}
}
