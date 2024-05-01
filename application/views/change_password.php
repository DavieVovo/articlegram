<?php $this->load->view('templates/header'); ?>

<div class="container d-flex flex-grow-1 justify-content-center align-items-center">
    <div class="card p-3">
        <h1 class="text-primary-emphasis">Change Password</h1>
        <form action="<?php echo site_url('change_password'); ?>" method="post">
            <!-- Current password -->
            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" class="form-control <?php echo (form_error('current_password')) ? 'is-invalid' : ''; ?>" id="current_password" name="current_password">
                <?php echo form_error('current_password', '<div class="invalid-feedback">', '</div>'); ?>
            </div>
            <!-- New password -->
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control <?php echo (form_error('new_password')) ? 'is-invalid' : ''; ?>" id="new_password" name="new_password">
                <?php echo form_error('new_password', '<div class="invalid-feedback">', '</div>'); ?>
            </div>
            <!-- Confirm new password -->
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control <?php echo (form_error('confirm_password')) ? 'is-invalid' : ''; ?>" id="confirm_password" name="confirm_password">
                <?php echo form_error('confirm_password', '<div class="invalid-feedback">', '</div>'); ?>
            </div>
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
