<!-- Initalize php-->  
<?php
require_once("initialize.php");
if ($session->isLoggedIn()) {
    redirectTo(rootPath() . "index.php");
}
$arr_errors = array();
if (isset($_POST['submit'])) {
    // user information
    $name             = $_POST['name'];
    $email           = $_POST['email'];
    $password        = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $datetime = wembloCmsDatetime();

    //deals with problems when registering
    if ($password != $confirmPassword) {
        $arr_errors[] = "Passwords do not match";
    }
    if (empty($name)) {
        $arr_errors[] = "Name is required";
    }
    if (empty($email)) {
        $arr_errors[] = "Email is required";
    }
    if (empty($password)) {
        $arr_errors[] = "Password is required";
    }
    $emailAlreadyExists    = User::findByEmail($email);

    if (($emailAlreadyExists)) {
        $arr_errors[] = "Email Already Registered";
    }

    //adds user details to database
    if (empty($arr_errors)) {
        $adminObj                  = User::findById('1');
        $user_obj                   = new User();
        $user_obj->id            =   (User::findLastRecord())->id+1;
        $user_obj->email            = $email;
        $user_obj->name            =  $name;
        $user_obj->password         = md5($password);
        $user_obj->role             = 2;

        $user_obj->status           = 1;
        $user_obj->datetime          = $datetime;
        $userCreated               = $user_obj->create();
        if (!$userCreated) {
            // $database->lastError();
            $arr_errors [] = 'Please try again..';
        }
        else {
            $newlyCreatedUserId = $userCreated;

            // result after successful registration
            global $session;
            $session->message("Thank you for registering with ai.football. Please login below.");
            header("location:login.php");
            exit;
        }
    }
}

// layout of page and text
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="/favicon.png">
    <title>ai.football Register</title>
    <link href="assets/frontend/css/style-1.css" rel="stylesheet">
</head>
<body>
<div id="app">
    <div class="">
        <div>
            <div class="fixed top-0 w-screen h-screen bg-center bg-cover flex justify-end items-center"
                 style="background-image: url('assets/frontend/img/keeper.jpg');">
                <div class="w-1/2 font-bold text-white uppercase lg:hidden">
                    <div class="text-2xl">A.I Football</div>
                    <div class="text-5xl">Using Machine Learning To Build Better Teams</div>
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
                                <h2 class="mb-8 text-center"> Create your Account </h2>

                                <?php if(!empty($arr_errors)) { ?>
                                    <div class="alert alert-danger" style="color: red; margin-bottom: 20px;">
                                        <h6>Please fix the following</h6>
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
                                <div>
                                    <label><span class="font-semibold">Name</span>
                                        <input autofocus="autofocus" placeholder="Name" name="name" type="text"
                                               class="form-input block w-full mt-2 bg-blue-100">
                                    </label>
                                </div>
                                <div class="mt-6">
                                    <label><span class="font-semibold">Email</span>
                                        <input autofocus="autofocus" placeholder="Email" name="email" type="email"
                                               class="form-input block w-full mt-2 bg-blue-100">
                                    </label>
                                </div>
                                <div class="mt-6">
                                    <label>
                                        <span class="font-semibold">Password</span>
                                        <input placeholder="Password" name="password" type="password" class="form-input block w-full mt-2 bg-blue-100">
                                    </label>
                                </div>
                                <div class="mt-6">
                                    <label>
                                        <span class="font-semibold">Confirm Password</span>
                                        <input placeholder="Retype Password" name="confirm_password" type="password" class="form-input block w-full mt-2 bg-blue-100">
                                    </label>
                                </div>
                                <button type="submit" name="submit" class="block w-full btn btn-primary mt-6"> Sign Up</button>
                                <a href="login.php" class="block my-8 text-lg text-center"> Already have an account? <span  class="text-azure-200">Login </span></a>
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