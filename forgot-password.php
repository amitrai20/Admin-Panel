<?php 
include_once('common.php');
$allowed = array(".", "-", "_");
$email_id ="";

//echo "           =>>>>>>> ".hash('sha256',addslashes(strip_tags($email_id)));
//echo "</br>           =>>>>>>> ".hash('sha256',addslashes(strip_tags($password)));
$error = array();
if(isset($_POST['btnlogin']))
{
//  var_dump($_POST);
    $email_id = $_POST['txtEmailID'];
    
    if (empty($email_id))
    {
        $error['emailError'] = "Please Provide valid email id";
    }   
    elseif (!isEmail($email_id))
    {
        $error['emailError'] = "Please Provide valid email id";
    }

    if(empty($error))
    {
        $email_id = $mysqli->real_escape_string(strip_tags($email_id));
        
        $qstring = "select coalesce(id,0) as id, coalesce(username,'') as username
                    from users WHERE encrypt_username = '" . hash('sha256',$email_id) . "'";
        
        $result = $mysqli->query($qstring);
        $user = $result->fetch_assoc();
        //var_dump($user);
        
        
        if (($user) && ($user['id'] > 0 ))
        {
            $new_password = "s!w@".rand(0,100000);
            $password_value = hash('sha256',addslashes(strip_tags($new_password)));
            $sub =" Password Recovery Mail";
            $message_body =" Dear User \n";
            $message_body .= " Your recovery password is $new_password \n\n";
            $message_body .= " Please login and change it immediately\n\n";
            $message_body .= " Thanks \n";
            $message_body .= " Administrator";
            
            $qstring = "update users set `password` ='".$password_value."'"; 
            $qstring .= " WHERE encrypt_username = '" . hash('sha256',$email_id) . "' and id = ".$user['id'] ;
        
            $result2    = $mysqli->query($qstring);
    //      $user2 = $result2->fetch_assoc();
            
            $error['emailError2'] = "An Email has been send to your email id. ";

            sendpmail($email_id,$sub,$message_body);
        }
        else
        {
            $error['emailError'] = "the Provided email_id  is not registered with us";
        }
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

<body class="theme-red fp-page">
  
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
  

 <div class="fp-box">
        <div class="logo">
            <a href="javascript:void(0);">Admin<b>BSB</b></a>
            <small>Admin BootStrap Based - Material Design</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="forgot_password" method="POST">
                    <div class="msg">
                        Enter your email address that you used to register. We'll send you an email with your username and a
                        link to reset your password.<br>
                        <?php if(isset($error['emailError2'])) { echo "<br/><span class=\"messageClass2\">".$error['emailError2']."</span>";  }?>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input id="txtEmailID" name="txtEmailID" class="form-control" type="email" placeholder="Enter Registered Email" required autofocus  
                                            value="<?php echo $email_id;?>">
                                            <?php if(isset($error['emailError'])) { echo "<br/><span class=\"messageClass\">".$error['emailError']."</span>";  }?>  
                                                
                            
                        </div>
                    </div>
                    
                    <button class="btn btn-block btn-lg bg-pink waves-effect" id="btnlogin" name="btnlogin" value="Send" type="submit">RESET MY PASSWORD</button>

                    <div class="row m-t-20 m-b--5 align-center">
                        <a href="login.php">Sign In!</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

              

   
<?php
include('footer.php');
?>

