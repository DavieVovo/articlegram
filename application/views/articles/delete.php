<?php $this->load->view('templates/header'); ?>

<div class="container d-flex flex-wrap flex-grow-1 align-items-center justify-content-center">
    <div class="card p-3 shadow">
        <h1 class="text-primary-emphasis">Delete Article</h1>
        <p>Are you sure you want to delete this article?</p>
        <form action="<?php echo site_url('articles/destroy/'.$article_id); ?>" method="post">
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="<?php echo site_url('articles/view/' . $article_id); ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>