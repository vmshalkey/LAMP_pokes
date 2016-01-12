<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Model {

	public function login_user($post) {
		// add user to db
		// VALIDATION
		$this->form_validation->set_rules("email", "Email Address", "trim|required|valid_email");
		$this->form_validation->set_rules("password", "Password", "trim|required");
		// END VALIDATION RULES
		if($this->form_validation->run() === FALSE) {
		     $this->session->set_flashdata("errors", validation_errors());
		     return FALSE;
		} else {
			$query = "SELECT * FROM users WHERE email = ? AND password = ?";
			$values = array($post['email'], $post['password']);
			$user = $this->db->query($query, $values)->row_array();
			if(empty($user)) {
				$this->session->set_flashdata("errors", "Email or password you entered is invalid.");
				return FALSE;
			} else {
				$this->session->set_userdata('id', $user['id']);
				return TRUE;
			}
		}
	}
	public function register_user($post) {
		// add user to db
		// VALIDATION
		$this->form_validation->set_rules("first_name", "First Name", "trim|required|alpha");
		$this->form_validation->set_rules("last_name", "Last Name", "trim|required|alpha");
		$this->form_validation->set_rules("alias", "Alias", "trim|required|alpha");
		$this->form_validation->set_rules("email", "Email Address", "trim|required|valid_email|is_unique[users.email]");
		$this->form_validation->set_rules("password", "Password", "trim|required|min_length[8]");
		$this->form_validation->set_rules("password_confirm", "Confirm Password", "trim|required|matches[password]");
		// END VALIDATION RULES
		if($this->form_validation->run() === FALSE) {
		     $this->session->set_flashdata("errors", validation_errors());
		} else {
			$query = "INSERT INTO users (first_name, last_name, alias, email, poke_history, password, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
			$values = array($post['first_name'], $post['last_name'], $post['alias'], $post['email'], $post['history'], $post['password']);
			$this->db->query($query, $values);
		}
	}
	public function get_user_info() {
		$query = "SELECT first_name, poke_history FROM users WHERE id = ?";
		$values = $this->session->userdata('id');
		$user = $this->db->query($query, $values)->row_array();
		return $this->db->query($query, $values)->row_array();
	}
	public function get_pokers() {
		$query = "SELECT users.first_name, pokes.count FROM pokes
					LEFT JOIN users ON pokes.poker_id = users.id
					WHERE pokes.poked_id = ?
					ORDER BY pokes.count DESC";
		$values = $this->session->userdata('id');
		$pokers = $this->db->query($query, $values)->result_array();
		return $this->db->query($query, $values)->result_array();
	}
	public function get_friends() {
		$query = "SELECT id, first_name, last_name, alias, email, poke_history FROM users WHERE id <> ?";
		$values = $this->session->userdata('id');
		$friends = $this->db->query($query, $values)->result_array();
		return $this->db->query($query, $values)->result_array();
	}
	public function poke_someone($post) {
			$query = "SELECT * FROM pokes WHERE poker_id = ? AND poked_id = ?";
			$values = array($this->session->userdata('id'), $post['getting_poked']);
			$relationship = $this->db->query($query, $values)->row_array();

			if(empty($relationship)) {
				$query1 = "INSERT INTO pokes (poker_id, poked_id, count, created_at, updated_at) VALUES (?, ?, '1', NOW(), NOW())";
				$values1 = array($this->session->userdata('id'), $post['getting_poked']);
				$this->db->query($query1, $values1);

				$query2 = "UPDATE users SET poke_history = poke_history + 1 WHERE id = ?";
				$values2 = array($post['getting_poked']);
				$this->db->query($query2, $values2);
			} else {
				$query1 = "UPDATE pokes SET count = count + 1 WHERE poker_id = ? AND poked_id = ?";
				$values1 = array($this->session->userdata('id'), $post['getting_poked']);
				$this->db->query($query1, $values1);

				$query2 = "UPDATE users SET poke_history = poke_history + 1 WHERE id = ?";
				$values2 = array($post['getting_poked']);
				$this->db->query($query2, $values2);
			}
	}
	public function ignore_poke($post) {
		$query2 = "DELETE FROM pokes WHERE id = ?";
		$values = $post['remove_poke'];
		$this->db->query($query2, $values);
	}
	public function my_pokes() {
		$query = "SELECT users.poke_history, pokes.poked_id FROM pokes LEFT JOIN users ON pokes.poked_id = users.id WHERE pokes.poker_id = ?";
		$values = $this->session->userdata('id');
		$my_pokes = $this->db->query($query, $values)->result_array();
		return $this->db->query($query, $values)->result_array();
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */