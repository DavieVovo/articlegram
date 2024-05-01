<?php $this->load->view('templates/header'); ?>
<style>
@media (min-width: 768px) {
  .w-md-50 {
    width: 50% !important;
  }
}
</style>
<?php
$user_id = $this->session->userdata('user_id');
$articles = $this->article_model->get_articles_by_user($user['user_id']);
$total_likes = $this->likes_model->total_likes_user($user['user_id']);
$total_posts = $this->article_model->total_articles_user($user['user_id']);

?>
<div class="container mt-5 mt-md-3 mb-5 mb-md-3 d-flex justify-content-center align-items-center flex-grow-1 flex-wrap gap-5">
    <div class="bg-white rounded p-3 d-flex flex-wrap align-items-center shadow-lg">
        <?php
        $profile_picture = isset($user['profile_picture']) ? base_url($user['profile_picture']) : base_url('img/avatar-placeholder.png');
        echo "<img src='$profile_picture' alt='Profile Picture' width=\"150px\"class=\"mb-3 rounded-circle me-3\">";
        ?>
        <div class="me-3">
        <h1 class="text-center fw-bold fs-5"><?php echo $user['user_name']; ?></h1>
        <ul class="list-group list-group-flush text-center">
            <li class="list-group-item"><strong>Email:</strong> <?php echo $user['user_email']; ?></li>
            <li class="list-group-item"><strong>Joined:</strong> <?php echo $user['created_at'] ? date('F j, Y', strtotime($user['created_at'])) : "" ?></li>
        </ul>
        </div>
        <div class="d-flex flex-grow-1 justify-content-around mt-3 mt-md-0">
            <div class="flex-grow-1 border-start">
                <h3 class="text-center fs-5">Total Posts</h3>
                <p class="fw-semibold fs-5 text-center"><?php echo $total_posts;?></p>
            </div>
            <div class="flex-grow-1 border-start border-end">
                <h3 class="text-center fs-5">Total Likes</h3>
                <p class="fw-semibold fs-5 text-center"><?php echo $total_likes;?></p>
            </div>
        </div>
        <div class="w-100 w-md-50">
        <p><strong>Bio:</strong> <?php echo $user['user_bio'] ? $user['user_bio'] : "No bio" ?></p>
        </div>
        <div class="w-100 w-md-50">
            <?php if($user_id === $user['user_id']) : ?>
                <a href="<?php echo site_url('profile/update_profile/' . $user['user_id']); ?>" class="btn btn-primary">Update Profile</a>
                <a href="<?php echo site_url('change_password'); ?>" class="btn btn-primary">Change Password</a>
                <?php endif;?>
            </div>
    </div>
    <div class="w-100 d-flex flex-wrap justify-content-center">
    <?php
        if ($articles) {
            foreach ($articles as $article): ?>
                <div class="col-md-4 mb-4 p-3">
                    <div class="card h-100 d-flex flex-column shadow">
                    <img class="card-img-top" style="height: 200px; width: auto;" src="<?php echo base_url($article['image_filename']); ?>" alt="image for <?php echo $article['title']; ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $article['title']; ?></h5>
                            <p class="card-text"><?php echo substr($article['content'], 0, 150); ?>...</p>
                            <a href="<?php echo site_url('articles/view/' . $article['id']); ?>" class="btn btn-primary mt-auto">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; 
            } else {
                echo 'there are no articles';
            }
            ?>
        </div>
</div>

<?php $this->load->view('templates/footer'); ?>