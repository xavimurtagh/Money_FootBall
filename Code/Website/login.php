<!-- Initalize php-->
<?php
require_once("initialize.php");
if ($session->isLoggedIn()) {
    redirectTo(rootPath() . "index.php");
}
$arr_errors = array();
if (isset($_POST['submit'])) {

    if (((isset($_POST['email'])) && (isset($_POST['password']))) && ((!empty($_POST['email'])) && (!empty($_POST['password'])))) {
        // username or email 
        // check if the form is submitted
        if (isset($_POST['submit'])) {
            $log = trim($_POST['email']);
            $password = trim($_POST['password']);
        }
        $password = md5($password);
        $user_obj = User::authenticate($log, $password);
        
        if ($user_obj) {
            if ($user_obj->status != 0) {
                $session->login($user_obj);

                header("location:login.php");
                exit;
            } else {
                $arr_errors[] = "Account Suspended.";
            }
        } else {
            $arr_errors[] = "Email/password combination is incorrect.";
        }
    } else {
        $arr_errors[] = "Please enter email and password.";
    }
}
?>
<!-- apply stylesheet-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>ai.football Login</title>
    <link href="assets/frontend/css/style-1.css" rel="stylesheet">
</head>
<body>
<div id="app">
    <div class="">
        <div>
            <!-- imagery and text-->
            <div class="fixed top-0 w-screen h-screen bg-center bg-cover flex justify-end items-center"
                 style="background-image: url('assets/frontend/img/background_stadium.jpg');">
                <div class="w-1/2 font-bold text-white uppercase lg:hidden">
                    <div class="text-2xl">A.I Football</div>
                    <div class="text-5xl">Machine Learning Intelligence Platform</div>
                </div>
            </div>
            <div class="relative max-w-screen-xl mx-auto min-h-screen flex items-center lg:text-sm">
                <div class="bg-white rounded w-full max-w-lg my-16 mx-16 overflow-x-hidden lg:max-w-none lg:mx-2 lg:px-6">
                    <div>
                        <center style="padding: 10px 0px">
                           <a href="<?php echo rootPath(); ?>">
                           </a>

                        </center>
                        <div class="px-8 py-2">
                            <form id="app" action="" method="post">
                                <!-- warning for incorrect username or password -->
                                <?php if(!empty($arr_errors)) { ?>
                                    <div class="alert alert-danger" style="color: red;margin-bottom: 20px;">
                                        <h6>Username or password is incorrect(s)</h6>
                                        <ul>
                                            <?php foreach(($arr_errors) as $key => $error) :?>
                                                <li><?php echo $key+1; echo ' = '.$error; ?></li>
                                            <?php endforeach;?>
                                        </ul>

                                    </div>
                                <?php } ?>
                                <?php if(!empty($success_message)) { ?>
                                    <div class="alert alert-success  ">
                                        <button class="close" data-close="alert"></button>
                                        <p><?php echo $success_message; ?></p>
                                    </div>
                                <?php } ?>
                                <?php if($session->message) { ?>
                                    <div class="alert alert-success  ">
                                        <button class="close" data-close="alert"></button>
                                        <p><?php echo $session->message; ?></p>
                                    </div>
                                <?php } ?>

                                <!-- username and password -->
                                <div>
                                    <label><span class="font-semibold">Email</span>
                                        <input autofocus="autofocus" placeholder="Email" name="email" type="email"
                                               class="form-input block w-full mt-2 bg-blue-100">
                                    </label>
                                </div>
                                <div class="mt-6">
                                    <label>
                                        <span class="font-semibold">Password</span>
                                        <input placeholder="password" name="password" type="password" class="form-input block w-full mt-2 bg-blue-100">
                                    </label>
                                </div>
                                <button type="submit" name="submit" class="block w-full btn btn-primary mt-6"> Login</button>

                                <a href="register.php" class="block my-8 text-lg text-center"> Don't have an ai.football account? <span  class="text-azure-200">Register </span></a>
                            </form>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
