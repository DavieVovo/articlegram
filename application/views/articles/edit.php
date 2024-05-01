<?php $this->load->view('templates/header'); ?>

<div class="container my-5 d-flex justify-content-center align-items-center flex-grow-1">
    <div class="card shadow p-3">
        <h1 class="text-center text-primary-emphasis">Edit Article</h1>
        <div class="d-flex justify-content-center">
            <img class="w-25 mb-3" src="<?php echo base_url($article->image_filename); ?>" alt="image for <?php echo $article->title; ?>">
        </div>
        <form action="<?php echo site_url('articles/update/'.$article->id); ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Article Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $article->title; ?>">
        </div>
        
        <div class="mb-3">
            <label for="content" class="form-label">Article Content</label>
            <textarea class="form-control" id="content" name="content" rows="5"><?php echo $article->content; ?></textarea>
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Article Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        
        <button type="submit" class="btn btn-primary">Update Article</button>
        
    </form>
</div>
</div>

<?php $this->load->view('templates/footer'); ?>
