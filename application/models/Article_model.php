<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends CI_Model {

    public function get_articles() {
        $query = $this->db->get('articles');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    public function create_article($data) {
        // Insert the new article into the database
        $this->db->insert('articles', $data);
        // Return the ID of the inserted article
        return $this->db->insert_id();
    }

    public function get_article_by_id($id) {
        $query = $this->db->get_where('articles', array('id' => $id));

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    public function update_article($article_id, $data) {
        $this->db->where('id', $article_id);
        $this->db->update('articles', $data);
    }

    public function delete_article($article_id) {
        $this->db->where('id', $article_id);
        $this->db->delete('articles');
    }

    public function get_articles_by_user($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('articles');
        return $query->result_array();
    }

    public function is_article_liked_by_user($article_id, $user_id) {
        $this->db->where('article_id', $article_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('likes');
    
        return $query->num_rows() > 0;
    }
    public function insert_comment($article_id, $user_id, $comment_content) {
        $data = array(
            'article_id' => $article_id,
            'user_id' => $user_id,
            'content' => $comment_content
        );
        $this->db->insert('comments', $data);
    }

    public function get_article_comments($article_id) {
        $this->db->where('article_id', $article_id);
        $query = $this->db->get('comments');
        return $query->result_array();
    }

    public function total_articles_user($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('articles');

        return $query->num_rows();
    }
}
