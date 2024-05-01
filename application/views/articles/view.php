<?php $this->load->view('templates/header'); ?>
<?php
    $article_id = $article->id;
    $user_id = $this->session->userdata('user_id');
    $username = $this->user_model->get_username_by_id($article->user_id);
    $is_liked = $this->article_model->is_article_liked_by_user($article_id, $user_id);
    $total_likes = $this->likes_model->total_likes_article($article_id);
    $comments = $this->article_model->get_article_comments($article_id);
?>
<style>
    .comment-modal {
        position: fixed;
        bottom: -100%;
        left: 50%;
        transform: translateX(-50%);
        max-width: 600px;
        width: 100%;
        transition: 0.3s ease-out;
        z-index: 9999;
        height: 80vh;
        background-color: white;
        box-shadow: inset 0px 0px 5px rgba(0, 0, 0, .2);
    }
    .comment-modal-content {
        position: relative;
    }
    .close-comments {
        position: absolute;
        right: 1rem;
        top: 1rem;
        transition: .3s ease;
    }
    .close-comments:hover {
        transform: translateY(-3px);
    }

    .show-modal {
        transform: translate(-50%, 0);
        bottom: 0;
    }

    .custom-scrollbar::-webkit-scrollbar {
    width: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 5px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
<div class="container d-flex flex-grow-1 align-items-center justify-content-center">
    <div class="row my-3">
        <div class="py-3 col-12 col-lg-6 mb-3 mb-lg-0 ">
            <img class="shadow rounded p-0 w-100" src="<?php echo base_url($article->image_filename); ?>" alt="image for <?php echo $article->title; ?>">
        </div>
        <div class="col-12 col-lg-6 d-flex align-items-center">
            <div class="card p-3 shadow">
                <h2 class="text-primary-emphasis"><?php echo $article->title; ?></h2>
                <?php if ($user_id && !($user_id == $article->user_id)): ?>
                    <div class="mb-2 d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center gap-1">
                            <?php if (!$is_liked): ?>
                                <a href="<?php echo site_url('articles/like/'.$article_id); ?>" class="btn btn-link p-0">
                                    <i class="far fa-heart text-dark"></i>
                                </a>
                                <?php else: ?>
                                    <a href="<?php echo site_url('articles/unlike/'.$article_id); ?>" class="btn btn-link p-0">
                                        <i class="fas fa-heart text-danger"></i>
                                    </a>
                                    <?php endif; ?>
                                    <p class="mb-0"><?php echo $total_likes?></p>
                        </div>
                    </div>
                    <?php else: ?>
                        <div class="d-flex align-items-center gap-1">
                        <i class="fas fa-heart text-danger"></i>
                        <p class="mb-0"><?php echo $total_likes?></p>
                        </div>
                <?php endif; ?>
                <div class="mb-2">
                    <a href="<?php echo site_url('profile/index/' . $article->user_id); ?>" class="fw-bold link-secondary text-decoration-none"><?php echo $username?></a>
                </div>
                <p class="mb-2"><?php echo date('F j, Y', strtotime($article->created_at));?></p>
                <p><?php echo $article->content; ?></p>
                <?php if($user_id == $article->user_id) : ?>
                    <div>
                        <a href="<?php echo site_url('articles/edit/' . $article_id); ?>" class="btn btn-warning">Edit</a>    
                        <a href="<?php echo site_url('articles/delete/' . $article_id); ?>" class="btn btn-danger">Delete</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="mt-3 justify-content-center d-flex gap-3">
            <button class="btn btn-secondary comment-btn">View comments</button>
            <a href="<?php echo site_url('home'); ?>" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
</div>
<div class="comment-modal rounded">
    <div class="comment-modal-content p-3 w-100 d-flex flex-column h-100">
        <button class="close-comments btn">
            <svg width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M8.00386 9.41816C7.61333 9.02763 7.61334 8.39447 8.00386 8.00395C8.39438 7.61342 9.02755 7.61342 9.41807 8.00395L12.0057 10.5916L14.5907 8.00657C14.9813 7.61605 15.6144 7.61605 16.0049 8.00657C16.3955 8.3971 16.3955 9.03026 16.0049 9.42079L13.4199 12.0058L16.0039 14.5897C16.3944 14.9803 16.3944 15.6134 16.0039 16.0039C15.6133 16.3945 14.9802 16.3945 14.5896 16.0039L12.0057 13.42L9.42097 16.0048C9.03045 16.3953 8.39728 16.3953 8.00676 16.0048C7.61624 15.6142 7.61624 14.9811 8.00676 14.5905L10.5915 12.0058L8.00386 9.41816Z" fill="#888"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12ZM3.00683 12C3.00683 16.9668 7.03321 20.9932 12 20.9932C16.9668 20.9932 20.9932 16.9668 20.9932 12C20.9932 7.03321 16.9668 3.00683 12 3.00683C7.03321 3.00683 3.00683 7.03321 3.00683 12Z" fill="#888"></path> </g></svg>
        </button>
        <h2 class="text-center mb-3 text-primary-emphasis">Comments</h2>
        <div class="flex-grow-1 w-100 overflow-auto mb-3 rounded p-3 border custom-scrollbar">
            <?php if ($comments) {

                foreach($comments as $comment) {
                    $comment_content = $comment['content'];
                    $comment_username = $this->user_model->get_username_by_id($comment['user_id']);
                    $comment_user_profile = base_url($this->user_model->get_profile_by_id($comment['user_id']));
                    $comment_time_stamp = date('F j, Y', strtotime($comment['created_at']));
                    ?>
                    <div class="d-flex align-items-center gap-3 mb-3 border-bottom py-3">
                        <?php
                        echo "<img src='$comment_user_profile' alt='Profile Picture' height=\"100px\" class=\"rounded-circle\">";
                        ?>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <p class="fw-bold mb-0"><?php echo $comment_username;?></p>
                                <p class="mb-0"><?php echo $comment_time_stamp;?></p>
                            </div>
                            <p><?php echo $comment_content?></p>
                        </div>
                    </div>
                    <?php } 
                } else {
                    echo "<p>Be the first to comment on this article</p>";
                }
                    
                    ?>
            </div>
            <form class="w-100" action="<?php echo site_url('articles/comment/'.$article->id); ?>" method="POST">
                <?php if($user_id) :?>
                <div class="mb-3">
                    <textarea class="form-control bg-light <?php echo form_error('comment') ? 'is-invalid' : '' ?>" name="comment" id="comment" cols="30" rows="3" class="w-100">Add comment...</textarea>
                    <?php echo form_error('comment', '<div class="invalid-feedback">', '</div>'); ?>
                </div>
                <button type="submit" name="submit_comment"class="btn btn-secondary">Submit</button>
                <?php else :?>
                    <textarea class="form-control bg-light" name="comment" id="comment" cols="30" rows="3" class="w-100" disabled readonly>Log in to comment on this article</textarea>
                    <?php endif;?>
            </form>
        </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const commentTextArea = document.getElementById("comment");
    const commentsBtn = document.querySelector(".comment-btn");
    const closeComments = document.querySelector(".close-comments");
    const commentMdl = document.querySelector(".comment-modal");
    const urlParams = new URLSearchParams(window.location.search);
    const showModal = urlParams.get('showComment');

    if (showModal === 'true') {
        commentMdl.classList.add('show-modal');
    }

    commentTextArea.addEventListener("focus", function() {
        if (commentTextArea.value.trim() === "Add comment...") {
            commentTextArea.value = "";
        }
    });
    commentTextArea.addEventListener("blur", function() {
        if (commentTextArea.value.trim() === "") {
            commentTextArea.value = "Add comment...";
        }
    });
    commentsBtn.addEventListener("click", (evt) => {
        evt.preventDefault();
        commentMdl.classList.add("show-modal");
    });
    closeComments.addEventListener("click", (evt) => {
        evt.preventDefault();
        commentMdl.classList.remove("show-modal");
    });
});

</script>

<?php $this->load->view('templates/footer'); ?>