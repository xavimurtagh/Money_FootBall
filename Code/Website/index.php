<!-- Initalize php-->
<?php
require_once("initialize.php");
global $database;
$message = "";
?>

<!-- project layout and page header-->
<html lang="en-US">
<head>
    <title>ai.football</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(ABSPATH.PROJECT_LAYOUT.'/frontend/'.'head-scripts.php'); ?>
</head>
<!-- project layout and page header-->
<body class="home page-template-default page page-id-10 desktop cookies-set cookies-accepted">
<?php include(ABSPATH.PROJECT_LAYOUT.'/frontend/'.'header.php'); ?>
<main class="main" id="main">
    <div class="page-top">
<!-- class definitions for page layout and text-->
        <div class="hero-slider swiper-container">
            <div class="swiper-wrapper">
                <div class="hero-slide swiper-slide">
                    <div class="grid grid--flex">
                        <div class="hero-slide__content">
                            <div class="hero-slide__left">
                            <!-- text for front page-->
                                <h4>Data science for the football transfer market</h4>
                                <h1 class="hero-slide__title">Machine learning to build better teams</h1>
                                <p>ai.football enables football professionals to use the power of A.I to make better transfer decisions.</p>

                            <div class="hero-slide__right hero-slide__right--column">
                           
                                <div class="hero-slide__api-title"></div>
                                <div class="hero-slide__api-text"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- background imagery-->
                <div class="hero-slide__background hero-slide__background--1">
                    <img src="<?php echo rootPath();?>assets/frontend/img/keeper.jpg" alt="stadium background">
                </div>
            </div>
        </div>
 </div>
 