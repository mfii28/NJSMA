<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? SITE_NAME ?></title>
    <meta name="description" content="<?= $pageDescription ?? 'Welcome to the official website of New Juaben South Municipal Assembly.' ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= SITE_URL ?>/lib/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= SITE_URL ?>/lib/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?= SITE_URL ?>/lib/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= SITE_URL ?>/lib/vendor/aos/aos.css" rel="stylesheet">
    <link href="<?= SITE_URL ?>/lib/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="<?= SITE_URL ?>/lib/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS Files -->
    <link rel="stylesheet" href="<?= SITE_URL ?>/lib/css/variable.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/lib/css/main.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/lib/css/njsma-ama-ui.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/inc/css.css">
</head>
<body>
    <?php include VIEW_PATH . '/partials/navbar.php'; ?>
