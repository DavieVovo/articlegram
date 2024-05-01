<?php $this->load->view('templates/header'); ?>

<div class="container d-flex justify-content-center align-items-center flex-grow-1 p-lg-5">
    <div class="card p-3 p-md-5 w-100 shadow">
        <h1 class="text-center text-primary-emphasis">Create New Article</h1>

        <?php echo form_open_multipart('articles/store'); ?>
            <div class="mb-3">
                <label for="title" class="form-label">Article Title</label>
                <input type="text" class="form-control <?php echo form_error('title') ? 'is-invalid' : '' ?>" id="title" name="title" value="<?php echo set_value('title'); ?>">
                <?php echo form_error('title', '<div class="invalid-feedback">', '</div>'); ?>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Article Content</label>
                <textarea class="form-control <?php echo form_error('content') ? 'is-invalid' : '' ?>" id="content" name="content" rows="5"><?php echo set_value('content'); ?></textarea>
                <?php echo form_error('content', '<div class="invalid-feedback">', '</div>'); ?>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Article Image</label>
                <input type="file" class="form-control <?php echo form_error('image') ? 'is-invalid' : '' ?>" id="image" name="image">
                <?php echo form_error('image', '<div class="invalid-feedback">', '</div>'); ?>
            </div>

            <button type="submit" class="btn btn-primary">Create Article</button>
            
        </form>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
