<?php $this->load->view('templates/header'); ?>

<div class="container mt-5">
    <h2 class="text-center mb-5">Welcome to <span class="fw-bold text-primary-emphasis">ARTICLEGRAM</span></h2>
    <div class="row">
        <?php
        if ($articles) {
            foreach ($articles as $article): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 d-flex flex-column shadow">
                    <img class="card-img-top" style="height: 200px; width: auto;" src="<?php echo base_url($article->image_filename); ?>" alt="image for <?php echo $article->title; ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $article->title; ?></h5>
                            <p class="card-text"><?php echo substr($article->content, 0, 150); ?>...</p>
                            <a href="<?php echo site_url('articles/view/' . $article->id); ?>" class="btn btn-primary mt-auto">Read More</a>
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
