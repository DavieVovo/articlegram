<?php $this->load->view('templates/header'); ?>

    <div class="container d-flex flex-grow-1 justify-content-center align-items-center">
        <div class="text-center">
            <h1 class="text-primary-emphasis">Success!</h1>
            <p><?php echo $success_message; ?></p>
            <a href="<?php echo site_url('home'); ?>" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
    <?php $this->load->view('templates/footer'); ?>