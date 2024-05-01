<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Load the database library
        $this->load->database();
    }

    public function insert_user($data) {

        $this->db->insert('users', $data);

        return $this->db->affected_rows() > 0;
    }

    public function get_user_by_id($user_id) {

        $query = $this->db->get_where('users', array('user_id' => $user_id));

        return $query->row_array();
    }

    public function get_user_by_email($email) {
        $this->db->where('user_email', $email);

        $query = $this->db->get('users');

        return $query->row();
    }

    public function get_username_by_id($user_id) {
        $query = $this->db->select('user_name')->where('user_id', $user_id)->get('users');

        if ($query->num_rows() > 0) {
            return $query->row()->user_name;
        } else {
            return false;
        }
    }

    public function get_profile_by_id($user_id) {
        $query = $this->db->select('profile_picture')->where('user_id', $user_id)->get('users');

        if ($query->num_rows() > 0) {
            return $query->row()->profile_picture;
        } else {
            return false;
        }
    }

    public function verify_password($user_id, $password) {
        $user = $this->db->get_where('users', ['user_id' => $user_id])->row();
        if ($user) {
            return password_verify($password, $user->user_password_hash);
        } else {
            return false;
        }
    }

    public function change_password($user_id, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $this->db->set('user_password_hash', $hashed_password);
        $this->db->where('user_id', $user_id);
        $this->db->update('users');
    }

    public function update_user_profile($user_id, $data)
    {
        $this->db->where('user_id', $user_id);
        $this->db->update('users', $data);
        
        return $this->db->affected_rows() > 0;
    }
    public function is_unique_username($username) {
        $this->db->where('user_name', $username);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function is_unique_email($email) {
        $this->db->where('user_email', $email);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }
}
