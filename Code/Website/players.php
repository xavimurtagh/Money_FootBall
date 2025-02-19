<!-- Initialize php-->  
<?php
require_once("initialize.php");
global $database;
$message = "";

// php check if user is logged in
if (!$session->isLoggedIn()) redirectTo(rootPath() . "login.php");
global $database;

// gets and splits names of all players in database
$querystr = "";
if (isset($_GET['btnSearch'])) {
    $querystr = "SELECT * FROM players WHERE id > 0  "; // 264638

    if (isset($_GET['name']) && $_GET['name']) {
        $str = explode(' ', $_GET['name']);

        // gets long name for each player
        foreach ($str as $name) {
            if (strlen($name) > 2) {
                $querystr .= " AND long_name like '%" . $name . "%' ";
            }
        }

    }


}
if (empty($querystr)) {
    $querystr = "SELECT * FROM players WHERE id > 0"; // 264638
}
// request to access data
$resultSet = $database->query($querystr);
$players = Player::findBySql($querystr);
$totalCount = count($players);

// $page is (int)$_GET['pageNbr'] if !empty($_GET['pageNbr'])== TRUE, $page is 1 if !empty($_GET['pageNbr'])== FALSE
$page = !empty($_GET['pageNbr']) ? (int)$_GET['pageNbr'] : 1;

// 2. records per page ($perPage)
$perPage = rows_per_page();
$pagination = new Pagination($page, $perPage, $totalCount);
$pagination->offset();
$recordNumber = $pagination->offset() + 1;

// instead of finding all records, just finds the records for this page
$sql = $querystr;
$sql .= " ORDER BY value_eur DESC ";
$sql .= " LIMIT {$perPage} ";
$sql .= " OFFSET {$pagination->offset()} ";
//echo $sql;exit;
$players = Player::findBySql($sql);

$flag = 0;
$url = curPageURL();
// if pageNbr in current URL
if (strpos($url, 'pageNbr')) {
    $flag = 1;
    // splits before and after && 
    $ary = explode('&&', $url);
    //to avoid appending'page Number' appending again and again
    $url = $ary[0];
}
// if $flag == 0 and $players isnt empty
if (($flag == 0) && (!empty($players))) {

    // if btnsearch not in url
    if (!(strpos($url, 'btnSearch'))) {
        $url = $url . "?btnSearch=";
    }
    // splits before and after && 
    $ary = explode('&&', $url);
    //to avoid appending'page Number' appending again and again
    $url = $ary[0]; 

}
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

    <!-- images and text that come up in the players page once logged in--> 
    <div class="page-top">

        <div class="hero-slider swiper-container">
            <div class="swiper-wrapper">
                <div class="hero-slide swiper-slide">
                    <div class="grid grid--flex">
                        <div class="hero-slide__content">
                            <div class="hero-slide__left hero-slide__left--wide">

                                <h4>Find the players you're looking for</h4>


                                <h1 class="hero-slide__title">DATA ANALYTICS</h1>
                                <p>ai.football helps clubs to be prepared for the
                                    upcoming transfer window. By providing the tools to compare
                                    players, you won't miss out on the
                                    best transfer decisions.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-slide__background hero-slide__background--1">
                <img src="<?php echo rootPath();?>assets/frontend/img/keeper.jpg" alt="stadium background">
                </div>
            </div>
        </div>
        <div class="nav-flex">
            <div class="nav-flex__grid">
                <div class="nav-flex__inner">
                    <div class="nav-flex-block">
                        <a class="nav-flex-block__inner scroll-anchor" href="#section--1">
                            <div class="nav-flex-block__label">Find the best players</div>
                            <div class="nav-flex-block__title">Playersn</div>
                        </a>
                    </div>
                    <div class="nav-flex-block">
                        <a class="nav-flex-block__inner scroll-anchor" href="#section--3">
                            <div class="nav-flex-block__label">Focus on the players that add value</div>
                            <div class="nav-flex-block__title">Data Science</div>
                        </a>
                    </div>
                    <div class="nav-flex-block">
                        <a class="nav-flex-block__inner scroll-anchor" href="#section--5">
                            <div class="nav-flex-block__label">An artifical intelligence analysis about a player</div>
                            <div class="nav-flex-block__title">A.I Analysis</div>
                        </a>
                    </div>
                    <div class="nav-flex-block">
                        <a class="nav-flex-block__inner scroll-anchor" href="#section--7">
                            <div class="nav-flex-block__label">Compare prospect players with your current squad members</div>
                            <div class="nav-flex-block__title">Goal to build better teams</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section section--news section--gray" id="latest">
        <div class="section__intro section__intro--less-margin" style="    margin-bottom: 0;padding-top: 30px;">
            <h2 class="section__title">Data Analytics</h2>
            <p>Find the players your team is looking for</p>
        </div>
        <div class="grid ac">
            <div class="items al">

                <?php if ($players) { ?>
                    <?php foreach ($players as $key => $player) { ?>
                        <div class="item">
                            <a class="item__inner" href="<?php echo rootPath();?>player-details.php?id=<?php echo $player->id;?>">
                                <div class="item__left">
                                    <div class="item__icon item__icon--press-release" style="background-image: url(<?php echo $player->player_face_url; ?>); background-size: 5em"></div>
                                    <div class="item__date">
                                        <span><?php echo $player->long_name; ?></span>
                                    </div>
                                    <div class="item__thumbnail">
                                        <img src="<?php echo $player->player_face_url; ?>" alt="">
                                    </div>
                                </div>
                                <div class="item__content">
                                    <h4 class="item__title"><?php echo $player->age; ?> years
                                        old,<?php echo $player->preferred_foot; ?>
                                        Foot,<?php echo $player->player_traits; ?></h4>
                                </div>

                                <div class="item__label"><?php echo $player->nationality_name; ?></div>
                            </a>
                        </div>
                    <?php } ?>
                    <?php
                    echo "<center>";
                    echo getPaginationString($page, $totalCount, $perPage, $adjacents = 1, $targetpage = $url, $pagestring = "&&pageNbr=");
                    echo "</center>";
                } else { ?>
                    <h3 class="text-center">No record found.</h3>
                <?php } ?>
            </div>
        </div>
    </section>
</body>
</html>
