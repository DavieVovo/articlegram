<?php $this->load->view('templates/header'); ?>
<style>
    @media screen and (min-width: 600px) {
        .custom-card {
            min-width: 500px;
        }
    }
        
</style>
<div class="container mt-5 mt-md-3 mb-5 mb-md-3 d-flex justify-content-center align-items-center flex-grow-1">
    <div class="card p-3 shadow custom-card">
        <h2 class="text-center mb-4">Update Profile</h2>
        <div class="mb-3 d-flex justify-content-center">
            <?php if (!empty($user['profile_picture'])): ?>
                <img src="<?php echo base_url($user['profile_picture']); ?>" alt="Current Profile Picture" class="mx-auto rounded-circle">
            <?php else: ?>
                <p>No profile picture uploaded</p>
            <?php endif; ?>
        </div>
        <?php echo form_open_multipart('profile/update_profile/' . $user['user_id']); ?>
            <div class="mb-3">
                <label for="user_name" class="form-label">Name</label>
                <input type="text" class="form-control <?php echo (form_error('user_name')) ? 'is-invalid' : ''; ?>" id="user_name" name="user_name" value="<?php echo $user['user_name']; ?>">
                <?php echo form_error('user_name', '<div class="invalid-feedback">', '</div>'); ?>
            </div>
            <div class="mb-3">
                <label for="user_email" class="form-label">Email</label>
                <input type="email" class="form-control <?php echo (form_error('user_email')) ? 'is-invalid' : ''; ?>" id="user_email" name="user_email" value="<?php echo $user['user_email']; ?>">
                <?php echo form_error('user_email', '<div class="invalid-feedback">', '</div>'); ?>
            </div>
            <div class="mb-3">
                <label for="user_bio" class="form-label">Bio</label>
                <textarea class="form-control <?php echo (form_error('user_bio')) ? 'is-invalid' : ''; ?>" id="user_bio" name="user_bio"><?php echo $user['user_bio']; ?></textarea>
                <?php echo form_error('user_bio', '<div class="invalid-feedback">', '</div>'); ?>
            </div>
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Profile Picture</label>
                <input type="file" class="form-control <?php echo (isset($error)) ? 'is-invalid' : ''; ?>" id="profile_picture" name="profile_picture">
                <?php if(isset($error)) echo '<div class="invalid-feedback">' . $error . '</div>'; ?>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
