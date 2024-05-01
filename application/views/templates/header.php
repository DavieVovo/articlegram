<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articlegram | <?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
</head>
<body class="d-flex flex-column min-vh-100" style="background: url(<?php echo base_url('img/background.jpg')?>); background-size: cover; background-position: center; background-attachment: fixed;">

<nav class="navbar navbar-expand-lg navbar-light bg-primary-subtle p-3 fw-semibold shadow sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary-emphasis" href="<?php echo site_url('home'); ?>">ARTICLEGRAM</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <div class="align-items-center d-flex justify-content-lg-end w-100 justify-content-center">
        <?php if($this->session->userdata('user_id')): 
            $user = $this->user_model->get_user_by_id($this->session->userdata('user_id'));
            ?>
                <ul class="navbar-nav d-flex align-items-center d-lg-none">
                    <li class="nav-item d-flex flex-column justify-content-center"><p class="px-3 mb-1 py-2">Welcome, <?php echo !empty($user['user_name']) ? $user['user_name'] : $this->session->userdata('username');?></p>
                    <?php
                    $profile_picture = isset($user['profile_picture']) ? base_url($user['profile_picture']) : base_url('img/avatar-placeholder.png');
                    echo "<img src='$profile_picture' alt='Profile Picture' width=\"150px\" class=\"mb-3 mx-auto rounded-circle\">";
                    ?>
                  </li>
                    <li class="nav-item">
                        <a href="<?php echo site_url('profile/index/' . $this->session->userdata('user_id')); ?>" class="nav-link link-light link-body-emphasis px-3 mb-1">View Profile</a>
                    </li>
                    <li class="nav-item"><a href="<?php echo site_url('articles/create'); ?>" class="nav-link link-light link-body-emphasis px-3 mb-1">Create New Article</a></li>
                    <li class="nav-item"><a href="<?php echo site_url('logout'); ?>" class="nav-link link-light link-body-emphasis px-3">Log Out</a></li>
                </ul>
                <p class="mb-0 me-2 d-lg-block d-none">Welcome, <?php echo !empty($user['user_name']) ? $user['user_name'] : $this->session->userdata('username');?></p>
                <div class="dropdown d-none d-lg-block me-3">
                  <button class="btn dropdown-toggle p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php
        $profile_picture = base_url($user['profile_picture']);
        echo "<img src='$profile_picture' alt='Profile Picture' height=\"50px\" class=\"rounded-circle\">";
        ?>
                  </button>
                  <ul class="dropdown-menu bg-primary-subtle">
                  <li class="nav-item">
                        <a href="<?php echo site_url('profile/index/' . $this->session->userdata('user_id')); ?>" class="nav-link link-light link-body-emphasis px-3 mb-1">View Profile</a>
                    </li>
                    <li class="nav-item"><a href="<?php echo site_url('articles/create'); ?>" class="nav-link link-light link-body-emphasis px-3 mb-1">Create New Article</a></li>
                    <li class="nav-item"><a href="<?php echo site_url('logout'); ?>" class="nav-link link-light link-body-emphasis px-3">Log Out</a></li>
                  </ul>
              </div>
        <?php else: ?>
            <a href="<?php echo site_url('login'); ?>" class="nav-link link-light link-body-emphasis px-3">Log In</a>
        <?php endif; ?>
        </div>
    </div>
  </div>
</nav>
