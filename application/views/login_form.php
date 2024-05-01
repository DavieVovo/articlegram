<?php $this->load->view('templates/header'); ?>

<div class="container mt-5 mt-md-0 d-flex justify-content-center align-items-center flex-grow-1">
    <div class="card p-3 shadow">
        <h1 class="text-center text-primary-emphasis mb-4">User Login</h1>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form action="<?php echo site_url('auth/authenticate'); ?>" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="text" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <div class="mt-2">
            <a href="<?php echo site_url('auth/create'); ?>">Don't have an account? Sign up here</a>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
