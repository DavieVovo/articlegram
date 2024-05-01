<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('article_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('user_model');
        $this->load->database();
    }

    public function index() {
        $data['title'] = 'Home';
        $data['articles'] = $this->article_model->get_articles();
        $this->load->view('home', $data);
    }

}