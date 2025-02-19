<!-- Initalize php-->
<?php
if (!isset($_SESSION["token"]) || $_SESSION["token"] == '') {
    $_SESSION["token"] = md5(rand(0, 10000000));
}
?>

<!-- page header-->
<header class="header">
    <div class="header__top">
        <div class="grid">
            <div class="header__inner">
                <a class="logo" aria-label="Logo" href="<?php echo rootPath(); ?>" style="height: auto;">
                </a>
                <nav class="header__nav">
                    <ul id="menu-main-menu-new" class="menu">
                        <li id="menu-item-6081"
                            class="menu-item menu-item-type-post_type menu-item-object-page  menu-item-6081">
                        <!-- header menus-->
                        <li id="menu-item-10296"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-10296"><a
                                    href="<?php echo rootPath(); ?>">Home</a></li>
                        <li id="menu-item-10297"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-10296"><a
                                    href="<?php echo rootPath(); ?>players.php">Players</a></li>
                        <!-- php check if user is logged in-->
                        <?php if (!$session->isLoggedIn()) { ?>

                            <li id="menu-item-10298"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-10296"><a
                                        href="<?php echo rootPath(); ?>login.php">Login</a></li>
                            <li id="menu-item-10298"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-10296"><a
                                        href="<?php echo rootPath(); ?>register.php">Sign Up</a></li>

                        <?php } else { ?>
                            <li id="menu-item-10298"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-10296"><a
                                        href="#">Welcome, <?php echo $loggedInUserObj->name; ?></a></li>

                        <?php } ?>
                    </ul>
                </nav>
                <!-- the following 'hamburger' code is a html code used for menus-->
                <a class="nav-trigger nav-trigger--new" id="nav-trigger--new" href="#">
                    <div class="nav-trigger__icon">
                        <svg class="nav-trigger__hamburger nav-trigger__hamburger--mobile"
                             xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path fill="#FFF" d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path>
                        </svg>
                        <svg class="nav-trigger__hamburger nav-trigger__hamburger--desktop" width="22" height="18"
                             xmlns="http://www.w3.org/2000/svg">
                            <g fill-rule="nonzero" fill="none">
                                <path fill="#FFF" d="M0 0h22v2H0z"></path>
                                <path fill="#FFF" d="M12 1v5h-2V1zM22 1v16h-2V1zM2 1v16H0V1zM12 12v5h-2v-5z"></path>
                                <path fill="#FFF" d="M0 16h22v2H0z"></path>
                                <circle stroke="#FFF" stroke-width="2" cx="11" cy="9" r="3"></circle>
                            </g>
                        </svg>
                        <svg class="nav-trigger__close" width="15" height="16" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.72792244 8L.07106819 2.34314575 1.48528175.9289322 7.142136 6.58578644 12.79899025.92893219l1.41421356 1.41421356L8.55634956 8l5.65685425 5.65685425-1.41421356 1.41421356L7.142136 9.41421356l-5.65685425 5.65685425-1.41421356-1.41421356L5.72792244 8z"
                                  fill="#FFF" fill-rule="nonzero"></path>
                        </svg>
                    </div>
                    <span>Menu</span>
                </a>

                <div class="header__right header__right--alt">
                    <div class="header__right-top">
                        <a class="search-trigger" id="search-trigger" href="#">
                            <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.5 11h-.79l-.28-.27A6.471 6.471 0 0 0 13 6.5 6.5 6.5 0 1 0 6.5 13c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L17.49 16l-4.99-5zm-6 0C4.01 11 2 8.99 2 6.5S4.01 2 6.5 2 11 4.01 11 6.5 8.99 11 6.5 11z"
                                      fill="#FFF" fill-rule="evenodd"></path>
                            </svg>
                        </a>
                        <!-- once user logged in can access the Players page-->
                        <ul id="menu-topmenu-top" class="menu">
                            <li id="menu-item-10074"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-10074">
                                <a href="<?php echo rootPath(); ?>">Home</a>
                            </li>
                            <li id="menu-item-10074"
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-10074">
                                <a href="<?php echo rootPath(); ?>players.php">Players</a>
                            </li>
                            <?php if ($session->isLoggedIn()) { ?>
                                <li id="menu-item-10074"
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-10074">
                                    <a href="#">Welcome, <?php echo $loggedInUserObj->name; ?></a>
                                </li>
                            <?php } else { ?>
                                <li id="menu-item-10074"
                                    class="menu-item menu-item-type-custom menu-item-object-custom menu-item-10074">
                                    <a href="<?php echo rootPath(); ?>login.php">Login</a>
                                </li>
                            <?php } ?>


                        </ul>
                    </div>
                    <div class="header__right-bottom">
                        <?php if ($session->isLoggedIn()) { ?>
                            <ul id="menu-topmenu-bottom" class="menu">
                                <li id="menu-item-10068"
                                    class="top-button menu-item menu-item-type-custom menu-item-object-custom menu-item-10068">
                                    <a href="<?php echo rootPath(); ?>logout.php">
                                        Logout </a></li>
                            </ul>
                        <!-- register menu -->
                        <?php } else { ?>
                            <ul id="menu-topmenu-bottom" class="menu">
                                <li id="menu-item-10068"
                                    class="top-button menu-item menu-item-type-custom menu-item-object-custom menu-item-10068">
                                    <a href="<?php echo rootPath(); ?>register.php">
                                        Register Now </a></li>
                            </ul>

                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>