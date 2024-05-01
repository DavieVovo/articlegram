<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('article_model');
        $this->load->model('likes_model');
    }

    public function index($user_id)
    {
        $user = $this->user_model->get_user_by_id($user_id);
        $data['title'] = `Profile ` . $user['user_name'];

        $data['user'] = $user;

        $this->load->view('profile/profile_view', $data);
    }

    public function username_check($username) {
        $user_id = $this->session->userdata('user_id');
        $original_username = $this->user_model->get_username_by_id($user_id);
    
        if ($username !== $original_username && !$this->user_model->is_unique_username($username)) {
            $this->form_validation->set_message('username_check', 'The {field} is already taken.');
            return false;
        } else {
            return true;
        }
    }
    
    public function email_check($email) {
        $user_id = $this->session->userdata('user_id');
        $user = $this->user_model->get_user_by_id($user_id);
        $original_email = $user['user_email'];
    
        if ($email !== $original_email && !$this->user_model->is_unique_email($email)) {
            $this->form_validation->set_message('email_check', 'The {field} is already taken.');
            return false;
        } else {
            return true;
        }
    }

    public function update_profile($user_id)
{
    $data['title'] = "Update Profile";

    $this->form_validation->set_rules('user_name', 'Username', 'required|min_length[4]|max_length[50]|callback_username_check');
    $this->form_validation->set_rules('user_email', 'Email', 'required|valid_email|callback_email_check');
    $this->form_validation->set_rules('user_bio', 'Bio', 'required');
    $data['user'] = $this->user_model->get_user_by_id($user_id);

    if ($this->form_validation->run() == FALSE) {
        $this->load->view('profile/profile_update', $data);
    } else {
        $username = $this->input->post('user_name');
        $email = $this->input->post('user_email');
        $bio = $this->input->post('user_bio');

        if (!empty($_FILES['profile_picture']['name'])) {
            $config['upload_path'] = './uploads/profile_pictures/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 5 * 1024;
            $config['file_name'] = $user_id;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('profile_picture')) {
                $upload_error = $this->upload->display_errors();
                $this->load->view('profile/profile_update',['user' => $data['user'], 'upload_error' => $upload_error]);
                return;
            } else {
                $image_data = $this->upload->data();
                $image_path = 'uploads/profile_pictures/' . $image_data['file_name'];
            }

            // Resize image to a square
            $config_resize['image_library'] = 'gd2';
            $config_resize['source_image'] = $image_path;
            $config_resize['create_thumb'] = FALSE;
            $config_resize['maintain_ratio'] = FALSE;
            $config_resize['width'] = 200;
            $config_resize['height'] = 200;
            $this->load->library('image_lib', $config_resize);

            if (!$this->image_lib->resize()) {
                echo $this->image_lib->display_errors();
            }

            // Calculate offsets for centering the crop
            $original_width = $image_data['width'];
            $original_height = $image_data['height'];
            $desired_size = 200; // Set to desired square size
            $offset_x = ($original_width - $desired_size) / 2;
            $offset_y = ($original_height - $desired_size) / 2;

            // Configuration for cropping
            $config_crop['image_library'] = 'gd2';
            $config_crop['source_image'] = $image_path;
            $config_crop['maintain_ratio'] = FALSE;
            $config_crop['width'] = $desired_size;
            $config_crop['height'] = $desired_size;
            $config_crop['x_axis'] = $offset_x;
            $config_crop['y_axis'] = $offset_y;
            $this->image_lib->initialize($config_crop);

            // Crop the image
            if (!$this->image_lib->crop()) {
                echo $this->image_lib->display_errors();
            }
        } else {
            $image_path = $data['user']['profile_picture'];
        }
        $update_data = array(
            'user_name' => $username,
            'user_email' => $email,
            'user_bio' => $bio,
            'profile_picture' => $image_path
        );

        $this->user_model->update_user_profile($user_id, $update_data);

        redirect('profile/index/' . $user_id);
    }
}
}