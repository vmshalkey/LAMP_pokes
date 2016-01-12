<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logins extends CI_Controller {

	public function index() {
		$this->load->view('login_home');
	}
	public function login_user() {
		if($this->login->login_user($this->input->post())){
			redirect('/welcome');
		} else {
			redirect('/');
		}
	}
	public function register_user() {
		$this->login->register_user($this->input->post());
		redirect('/');
	}

	public function show() {
		$user = $this->login->get_user_info();
		$pokers = $this->login->get_pokers();
		$friends = $this->login->get_friends();
		$my_pokes = $this->login->my_pokes();
		$this->load->view("welcome", array("user" => $user, "friends"=> $friends, "pokers"=>$pokers, "my_pokes"=> $my_pokes));
	}
	public function poke_someone() {
		$this->login->poke_someone($this->input->post());
		redirect('welcome');
	}
	public function poke_someone_back() {
		$this->login->poke_someone_back($this->input->post());
		redirect('welcome');
	}
	public function ignore_poke() {
		$this->login->ignore_poke($this->input->post());
		redirect('welcome');
	}
	public function logoff_user() {
		$this->session->sess_destroy();
		redirect('/');
	}
}

/* End of file logins.php */
/* Location: ./application/controllers/logins.php */