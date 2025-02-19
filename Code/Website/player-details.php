<!-- Initialize php--> 
<?php
require_once("initialize.php");
global $database;
$message = "";

// php check if user is logged in
if (!$session->isLoggedIn()) redirectTo(rootPath() . "login.php");
global $database;
$player = Player::findById($_GET['id']);
?>

<!-- declaring document as html and in english--> 
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- includes and evaluates head-scripts.php--> 
    <?php include(ABSPATH . PROJECT_LAYOUT . '/frontend/' . 'head-scripts.php'); ?>
</head>
<body class="home page-template-default page page-id-10 desktop cookies-set cookies-accepted">
<main class="main" id="main">

    <!-- includes and evaluates header.php--> 
    <?php include(ABSPATH . PROJECT_LAYOUT . '/frontend/' . 'header.php'); ?>

    <!-- images and text that come up once a player is clicked on--> 
    <div class="page-top">
        <div class="hero-slider swiper-container">
            <div class="swiper-wrapper">
                <div class="hero-slide swiper-slide">
                    <div class="grid grid--flex">
                        <div class="hero-slide__content">
                            <div class="hero-slide__left">

                                <h4>  <img src="<?php echo $player->player_face_url; ?>" alt=""><?php echo $player->long_name; ?></h4>


                                <h1 class="hero-slide__title">Player Analysis</h1>
                                <p>Here are the statistics of <?php echo $player->long_name; ?>. ai.football uses the power of artificial intelligence to evaluate a player's transfer value to determine if they are over or undervalued. </p>

                            </div>
                            </div>
                        </div>


                    </div>
                    <!-- background imagery--> 

                    <div class="hero-slide__background hero-slide__background--1">


                        <img src="<?php echo rootPath();?>assets/frontend/img/keeper.jpg"
                             alt="" style="">
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- getting image of flag players declared nationality-->  
    <section class="section section--page-intro">
        <div class="grid grid--small">
            <div class="post-intro">
                <div class="box">
                    <center><img src="<?php echo $player->nation_flag_url; ?>"alt=""> </center>
                    <div class="box__row">

                        <div class="box__col">
                            <div class="editor">

				                <!-- getting full name and text below it on individual player page--> 
                                <h2> <?php echo $player->long_name?></h2>
                                <p>ai.football uses the power of artifical intelligence to understand what drives player valuation and how clubs can deploy this to build better teams.</p>
                            </div>
                        </div>
                        <div class="box__col">
                            <div class="editor">
                                <ul>
                                    <li>

                                    <!-- printing players details on individual page--> 
                                         Date of birth: <?php echo $player->dob; ?>
                                    </li>
                                    <li>
                                        Age: <?php echo $player->age; ?>
                                    </li>
                                    <li>
                                        Rating: <?php echo $player->weight_kg; ?>
                                    </li>
                                    <li>
                                        Height: <?php echo $player->height_cm; ?>
                                    </li>
                                    <li>
                                        Preffered Foot: <?php echo $player->preferred_foot; ?>
                                    </li>
                                    <li>
                                        Skills: <?php echo $player->player_traits; ?>
                                    </li>

                                </ul>
                                <p><strong>Goal! Using A.I to Build Better Teams</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- printing statistics on bottom of individual player page-->
    <section class="section section--gray">
        <div class="grid grid--small">
            <div class="awards">

                <div class="pricing__tabs">
                    <div class="pricing__tab pricing__tab--active" id="recruitment">
                        <div class="pricing-table">
                            <div class="pricing-table__inner">
                                <div class="pricing-table__header">
                                    <div class="pricing-table__label">Overall</div>
                                    <div class="pricing-table__title">A.I Rating</div>
                                </div>
                                <div class="pricing-table__price-wrapper">
                                    <div class="pricing-table__price"><span><?php echo $player->overall;?></span></div>
                                    <div class="pricing-table__time">ai.football</div>
                                </div>
                            </div>
                        </div>


                        <div class="pricing-table">
                            <div class="pricing-table__inner">
                                <div class="pricing-table__header">
                                    <div class="pricing-table__label">Player</div>
                                    <div class="pricing-table__title">Transfer Value</div>
                                </div>
                                <div class="pricing-table__price-wrapper">
                                    <div class="pricing-table__price"><span><?php echo $player->value_eur;?></span></div>
                                    <div class="pricing-table__time">ai.football</div>
                                </div>
                            </div>
                        </div>


                        <div class="pricing-table">
                            <div class="pricing-table__inner">
                                <div class="pricing-table__header">
                                    <div class="pricing-table__label">Player</div>
                                    <div class="pricing-table__title">A.I Value</div>
                                </div>
                                <div class="pricing-table__price-wrapper">
                                    <div class="pricing-table__price"><span><?php echo $player->predsOLS;?></span></div>
                                    <div class="pricing-table__time">ai.football</div>
                                </div>
                            </div>
                        </div>

                        <div class="pricing-table">
                            <div class="pricing-table__inner">
                                <div class="pricing-table__header">
                                    <div class="pricing-table__label">Player</div>
                                    <div class="pricing-table__title">Potential Savings</div>
                                </div>
                                <div class="pricing-table__price-wrapper">
                                    <div class="pricing-table__price"><span><?php echo ($player->value_eur - $player->predsOLS);?></span></div>
                                    <div class="pricing-table__time">ai.football</div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>
</main>
</body>
</html>
