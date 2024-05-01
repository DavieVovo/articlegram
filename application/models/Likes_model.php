<?php
class Likes_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function like_article($user_id, $article_id) {
        $data = array(
            'user_id' => $user_id,
            'article_id' => $article_id
        );
        $this->db->insert('likes', $data);
    }

    public function unlike_article($user_id, $article_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('article_id', $article_id);
        $this->db->delete('likes');
    }
    public function total_likes_article($article_id) {
        $this->db->where('article_id', $article_id);
        $query = $this->db->get('likes');

        return $query->num_rows();
    }
    public function total_likes_user($user_id) {
        $this->db->select('count(like_id) as total_likes');
        $this->db->from('likes');
        $this->db->join('articles', 'likes.article_id = articles.id');
        $this->db->where('articles.user_id', $user_id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row()->total_likes;
        } else {
            return 0;
        }
    }
}