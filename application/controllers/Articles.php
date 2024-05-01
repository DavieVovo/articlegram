<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load models
        $this->load->helper('url');
        $this->load->model('article_model');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('user_model');
        $this->load->model('likes_model');
        $this->load->database();
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['articles'] = $this->article_model->get_articles_by_user($user_id);
        $this->load->view('articles/index', $data);
    }

    public function view($id) {
        $this->load->model('article_model');
    
        $article = $this->article_model->get_article_by_id($id);
    
        $data['article'] = $article;
        $data['title'] = $article->title;
    
        $this->load->view('articles/view', $data);
    }

    public function create() {
        $data['title'] = "Create Article";

        $this->load->view('articles/create', $data);
    }

    public function edit($article_id) {
        $this->load->helper('url');

        $data['article'] = $this->article_model->get_article_by_id($article_id);
        $data['title'] = "Edit Article";

        $this->load->view('articles/edit', $data);
    }

    public function delete($article_id) {
        $this->load->helper('url');

        $data['article_id'] = $article_id;
        $data['title'] = "Delete Article";

        $this->load->view('articles/delete', $data);
    }

    public function store() {
        $this->form_validation->set_rules('title', 'Article Title', 'required');
        $this->form_validation->set_rules('content', 'Article Content', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('articles/create');
        } else {
            $title = $this->input->post('title');
            $content = $this->input->post('content');
            $user_id = $this->session->userdata('user_id');

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 1024 * 8;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image')) {
                $upload_error = $this->upload->display_errors();
                $this->load->view('articles/create', ['upload_error' => $upload_error]);
            } else {
                $image_data = $this->upload->data();
                $image_path = 'uploads/' . $image_data['file_name'];

                $data = array('title' => $title, 'content' => $content, 'image_filename' => $image_path, 'user_id' => $user_id);

                $this->article_model->create_article($data);

                redirect('home');
            }
        }
    }

    public function update($id) {
        // Form validation rules
        $this->form_validation->set_rules('title', 'Article Title', 'required');
        $this->form_validation->set_rules('content', 'Article Content', 'required');
        $article = $this->article_model->get_article_by_id($id);
    
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('articles/edit', ['article' => $article]);
        } else {
            $title = $this->input->post('title');
            $content = $this->input->post('content');
    
            if (!empty($_FILES['image']['name'])) {
                // Handle image upload
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 1024 * 8;
                $this->load->library('upload', $config);
    
                if (!$this->upload->do_upload('image')) {
                    $upload_error = $this->upload->display_errors();
                    $this->load->view('articles/edit', ['article' => $article, 'upload_error' => $upload_error]);
                    return;
                } else {
                    $image_data = $this->upload->data();
                    $image_path = 'uploads/' . $image_data['file_name'];
                }
            } else {
                $image_path = $article->image_filename;
            }
            $data = array(
                'title' => $title,
                'content' => $content,
                'image_filename' => $image_path
            );

            $this->article_model->update_article($id, $data);
    
            redirect('articles/view/'.$id);
        }
    }
    
    public function destroy($id) {
        $this->article_model->delete_article($id);

        redirect('home');
    }

    public function like($article_id) {
        $user_id = $this->session->userdata('user_id');
        $this->likes_model->like_article($user_id, $article_id);
        redirect('articles/view/'.$article_id);
    }
    
    public function unlike($article_id) {
        $user_id = $this->session->userdata('user_id');
        $this->likes_model->unlike_article($user_id, $article_id);
        redirect('articles/view/'.$article_id);
    }

    public function comment($article_id) {
        $this->form_validation->set_rules('comment', 'Comment', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            redirect('articles/view/'.$article_id.'?error=true');
        } else {
            $user_id = $this->session->userdata('user_id');
            $comment_content = $this->input->post('comment');
            if ($comment_content !== "Add comment...") {
                $this->article_model->insert_comment($article_id, $user_id, $comment_content);
                redirect('articles/view/'.$article_id.'?showComment=true');
            } else {
                redirect('articles/view/'.$article_id.'?error=true');  
            }
        }
    }
}