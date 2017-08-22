
<?php 
include_once('common.php');
$allowed = array(".", "-", "_");
$email_id ="";
$password = "";

//echo "           =>>>>>>> ".hash('sha256',addslashes(strip_tags($email_id)));
//echo "</br> </br> </br> </br> </br> </br> </br>           =>>>>>>> ".hash('sha256',addslashes(strip_tags($password)))."</br> </br> ";
$error = array();
if(isset($_POST['btnlogin']))
{
//  var_dump($_POST);
    $email_id = $_POST['txtEmailID'];
    $password = $_POST['txtpassword'];

    if (empty($email_id))
    {
        $error['emailError'] = "Please Provide valid email id";
    }   
    if(empty($password))
    {
        $error['passwordError'] = "Please Provide valid passowrd";
    }
    elseif (!isEmail($email_id))
    {
        $error['emailError'] = "Please Provide valid email id";
    }

    if(empty($error))
    {
        $email_id = $mysqli->real_escape_string(strip_tags($email_id));
        $password_value = hash('sha256',addslashes(strip_tags($password)));
        $qstring = "select coalesce(id,0) as id, coalesce(username,'') as username,
                    coalesce(password,'') as password,
                    coalesce(email,'') as email_id,
                    coalesce(admin,'') as admin,
                    coalesce(locked,0) as locked,
                    coalesce(supportpin,'') as supportpin,
                    coalesce(is_email_verify,0) as is_email_verify,
                    coalesce(secret,'') as secret,
                    coalesce(authused,0) as authused
                    from users WHERE encrypt_username = '" . hash('sha256',$email_id) . "'";
        
        $result = $mysqli->query($qstring);
        $user = $result->fetch_assoc();
        //var_dump($user);
        
        $secret = $user['secret'];
        if (($user) && ($user['password'] == $password_value) && ($user['locked'] == 0) && ($user['authused'] == 0))
        {
            //  session_start();
            session_regenerate_id (true); //prevent against session fixation attacks.
                                
            //var_dump($user);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email_id'] = $user['email_id'];
            $_SESSION['user_session'] = $user['username'];
            $_SESSION['user_admin'] = $user['admin'];
            $_SESSION['user_supportpin'] = $user['supportpin'];
            $_SESSION['is_email_verify'] = $user['is_email_verify'];
            
            header("Location:homepage.php");
            exit();

        } 
        elseif (($user) && ($user['password'] == $password_value) && ($user['locked'] == 1))
        {
            $pin = $user['supportpin'];
            $error['emailError'] = "Account is locked. Contact support for more information. $pin";
        }
        elseif (($user) && ($user['password'] == $password_value) && ($user['locked'] == 0) && ($user['authused'] == 1 && ($oneCode == $_POST['auth']))) 
        {
            //      session_start();
            session_regenerate_id (true); //prevent against session fixation attacks.
                                
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email_id'] = $user['email_id'];
            $_SESSION['user_session'] = $user['username'];
            $_SESSION['user_admin'] = $user['admin'];
            $_SESSION['user_supportpin'] = $user['supportpin'];
            $_SESSION['is_email_verify'] = $user['is_email_verify'];
            header("Location:homepage.php");
            exit();
        }
        else
        {
                $error['emailError'] = "email_id, password is incorrect";
        }
    }
    else
    {
        $error['emailError'] = "email_id, password is incorrect";
    }
}
//var_dump($_SESSION);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Welcome To | Golden Coin</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/content.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />


</head>

<body class="theme-red login-page">
  
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-header">
                <a href="javascript:void(0);"class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" ></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a style="font-size:24px;"class="navbar-brand" href="index.php">Golden Coin</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    
                     <li class="dropdown">
                        <a style="font-size:24px;" href="index.php" role="button">Home</a>
                        
                    </li>
                    <li class="dropdown">
                        <a style="font-size:24px;" href="#" role="button">Explorer</a>
                        
                    </li>
                    <li class="dropdown">
                        <a style="font-size:24px;" href="#" role="button">Blocks</a>
                        
                    </li>

                    <li class="dropdown">
                        <a style="font-size:24px;" href="signup.php" role="button">Sign Up</a>
                        
                    </li>
                  
                    <li class="dropdown">
                        <a style="font-size:24px;" href="login.php" role="button">Sign In</a>
                        
                    </li>
                   
                    
                </ul>
            </div>
        </div>
    </nav>
   


     <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">Admin<b>BSB</b></a>
            <small>Admin BootStrap Based - Material Design</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" method="POST">
                    <div class="msg">Sign in to start your session</div>
                    <div> <?php if(isset($error['emailError'])) { echo "<br/><span style='color: red;' class=\"messageClass\">".$error['emailError']."</span>";  }?> </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">

                            <input id="txtEmailID" name="txtEmailID" class="form-control" placeholder="Email Id" required autofocus type="text"
                                            value="<?php echo $email_id;?>">
                                            
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            
                            <input id="txtpassword" name="txtpassword" class="form-control" type="password" placeholder="Password" required value="<?php echo $password;?>">
                            <?php if(isset($error['passwordError'])) { echo "<br/><span class=\"messageClass\">".$error['passwordError']."</span>";  }?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">Remember Me</label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit" id="btnlogin" name="btnlogin" value="Sign In">SIGN IN</button>
                            <!-- <input type="submit" class="button Lockerblue ladda-button" id="btnlogin" name="btnlogin" value="Sign In"/> -->
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                            <a href="signup.php">Register Now!</a>
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="forgot-password.php">Forgot Password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>   

            

           
              

   
<?php
include('footer.php');
?>