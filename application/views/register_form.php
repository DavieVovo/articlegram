<?php $this->load->view('templates/header'); ?>

<div class="container mt-5 mt-md-0 d-flex justify-content-center align-items-center flex-grow-1">
    <div class="card p-3 shadow">
        <h2 class="text-center mb-4">User Registration</h2>
        <form action="<?php echo site_url('auth/store'); ?>" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control <?php echo (form_error('username')) ? 'is-invalid' : ''; ?>" id="username" name="username">
                <?php echo form_error('username', '<div class="invalid-feedback">', '</div>'); ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control <?php echo (form_error('email')) ? 'is-invalid' : ''; ?>" id="email" name="email">
                <?php echo form_error('email', '<div class="invalid-feedback">', '</div>'); ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control <?php echo (form_error('password')) ? 'is-invalid' : ''; ?>" id="password" name="password">
                <?php echo form_error('password', '<div class="invalid-feedback">', '</div>'); ?>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control <?php echo (form_error('confirm_password')) ? 'is-invalid' : ''; ?>" id="confirm_password" name="confirm_password">
                <?php echo form_error('confirm_password', '<div class="invalid-feedback">', '</div>'); ?>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <div class="mt-2">
            <a href="<?php echo site_url('auth/login'); ?>">Already have an account? Login here</a>
        </div>
    </div>
</div>
<?php $this->load->view('templates/footer'); ?>
