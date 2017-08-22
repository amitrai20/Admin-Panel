<?php 
include_once('common.php');
$allowed = array(".", "-", "_");
$email_id = "";
$password = "";
$confirmpassword = "";
$spendingpassword = "";
$confirmspendingpassword = "";

$error = array();
if(isset($_POST['btnsignup']))
{
//  var_dump($_POST);
    $email_id = $_POST['txtEmailID'];
    $password = $_POST['signuppassword'];
    $confirmpassword = $_POST['confirmpassword'];
    $spendingpassword = $_POST['spendingpassword'];
    $confirmspendingpassword = $_POST['confirmspendingpassword'];

    if (empty($email_id))
    {
        $error['emailError'] = "Please Provide valid email id";
    }   
    if(empty($password))
    {
        $error['passwordError'] = "Please Provide valid Password";
    }
    if(empty($confirmpassword))
    {
        $error['confirmpasswordError'] = "Please Provide valid Password";
    }
    else if($confirmpassword != $password)
    {
        $error['confirmpasswordError'] = "Password and Confirm Password Must be same";
    }
    if(empty($spendingpassword))
    {
        $error['spendingpasswordError'] = "Please Provide valid Spending Password";
    }
    if(empty($confirmspendingpassword))
    {
        $error['confirmspendingpasswordError'] = "Please Provide valid Spending Password";
    }
    else if($confirmspendingpassword != $spendingpassword)
    {
        $error['confirmpasswordError'] = "Spending Password and Confirm Password Must be same";
    }
    
    if (!isEmail($email_id))
    {
        $error['emailError'] = "Please Provide valid email id";
    }
    
    $email_id = $mysqli->real_escape_string(strip_tags($email_id));
    $password_value = hash('sha256',addslashes(strip_tags($password)));
    $qstring = "select coalesce(id,0) as id
                from users WHERE encrypt_username = '" . hash('sha256',$email_id) . "'";
    
    $result = $mysqli->query($qstring);
    $user = $result->fetch_assoc();
    //var_dump($user);
    if ($user['id']> 0)
    {
        $error['emailError'] = "User with email id $email_id already exist.";
    }

    if(empty($error))
    {
        $email_id = $mysqli->real_escape_string(strip_tags($email_id));
        $password_value = hash('sha256',addslashes(strip_tags($password)));
        $spendingpassword_value = hash('sha256',addslashes(strip_tags($spendingpassword)));
        
        $qstring = "insert into `users`( `date`, `ip`, `username`, 
        `encrypt_username`, `password`, `transcation_password`, 
        `email`) values (";
        $qstring .= "now(), ";
        $qstring .= "'".$_SERVER['REMOTE_ADDR']."', ";
        $qstring .= "'".$email_id."', ";
        $qstring .= "'".hash('sha256',$email_id)."', ";
        $qstring .= "'".$password_value."', ";
        $qstring .= "'".$spendingpassword_value."', ";
        $qstring .= "'".$email_id."') ";
    //  echo $qstring;
        $result2    = $mysqli->query($qstring);
        if ($result2)
        {
            //  $user2 = $result2->fetch_assoc();
            //var_dump($user);
            //  header("Location:login.php");
            $email_id = "";
            $password = "";
            $confirmpassword = "";
            $spendingpassword = "";
            $confirmspendingpassword = "";
            $error['emailError2'] = "successfully registered";
        }
    }
}       
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

<body class="theme-red signup-page">
  
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
  

 <div class="signup-box">
        <div class="logo">
            <a href="javascript:void(0);">Admin<b>BSB</b></a>
            <small>Admin BootStrap Based - Material Design</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_up" method="POST">
                    <div class="msg">Register a new membership</div>
                    <div><?php if(isset($error['emailError2'])) { echo "<br/><span style='color: green;' class=\"messageClass2\">".$error['emailError2']."</span>";  }?></div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <!-- <input type="email" class="form-control" name="email" placeholder="Email Address" required> -->
                            <input id="txtEmailID" name="txtEmailID" class="form-control" type="text" placeholder="Email Address" required value="<?php echo $email_id;?>">
                            <?php if(isset($error['emailError'])) { echo "<br/><span class=\"messageClass\">".$error['emailError']."</span>";  }?>  
                            
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <!-- <input type="password" class="form-control" name="password" minlength="6" placeholder="Password" required> -->
                            <input id="signuppassword" name="signuppassword" autocomplete="off" class="form-control" type="password" minlength="6" placeholder="Password" required value="<?php echo $password;?>">
                            <?php if(isset($error['passwordError'])) { echo "<br/><span class=\"messageClass\">".$error['passwordError']."</span>";  }?>    
                            <span id="result" style="float:left"></span>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <!-- <input type="password" class="form-control" name="confirm" minlength="6" placeholder="Confirm Password" required> -->
                            <input id="confirmpassword" name="confirmpassword" class="form-control" autocomplete="off" type="password" minlength="6" placeholder="Confirm Password" required value="<?php echo $confirmpassword;?>">
                            <?php if(isset($error['confirmpasswordError'])) { echo "<br/><span class=\"messageClass\">".$error['confirmpasswordError']."</span>";  }?>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <!-- <input type="password" class="form-control" name="confirm" minlength="6" placeholder="Spending Password" required> -->
                            <input id="spendingpassword" name="spendingpassword" class="form-control" autocomplete="off" type="password" minlength="6" placeholder="Spending Password" required value="<?php echo $spendingpassword;?>">
                            <?php if(isset($error['spendingpasswordError'])) { echo "<br/><span class=\"messageClass\">".$error['spendingpasswordError']."</span>";  }?>    
                            <span id="spendingresult" style="float:left"></span>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <!-- <input type="password" class="form-control" name="confirm" minlength="6" placeholder="Confirm Spending Password" required> -->
                            <input id="confirmspendingpassword" name="confirmspendingpassword" class="form-control" autocomplete="off" type="password" placeholder="Confirm Spending Password" required value="<?php echo $confirmspendingpassword;?>">
                            <?php if(isset($error['confirmspendingpasswordError'])) { echo "<br/><span class=\"messageClass\">".$error['confirmspendingpasswordError']."</span>";  }?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="terms" id="terms" class="filled-in chk-col-pink">
                        <label for="terms">I read and agree to the <a href="javascript:void(0);">terms of usage</a>.</label>
                    </div>
                    
                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit" id="btnsignup" name="btnsignup" value="Sign Up">SIGN UP</button>
                    <!-- <input type="submit" class="button Lockerblue ladda-button" id="btnsignup" name="btnsignup" value="Sign Up"/> -->

                    <div class="m-t-25 m-b--5 align-center">
                        <a href="login.php">You already have a membership?</a>
                    </div>
                </form>
     <script type="text/javascript">

             function validateEmail(emailField)
                    {
                        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                        return expr.test(emailField);
                    }
                    
            function checkStrength(password) 
                {
                    var strength = 0
                    if (password.length < 6) 
                    {
                        $('#result').removeClass()
                        $('#result').addClass('short')
                        return 'Weak'
                    }
                    if (password.length > 7) strength += 1
                    // If password contains both lower and uppercase characters, increase strength value.
                    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
                    // If it has numbers and characters, increase strength value.
                    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
                    // If it has one special character, increase strength value.
                    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
                    // If it has two special characters, increase strength value.
                    if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
                    // Calculated strength value, we can return messages
                    // If value is less than 2
                    if (strength < 2) 
                    {
                        $('#result').removeClass()
                        $('#result').addClass('weak')
                        return 'Regular'
                    } 
                    else if (strength == 2) 
                    {
                        $('#result').removeClass()
                        $('#result').addClass('good')
                        return 'Normal'
                    } 
                    else 
                    {
                        $('#result').removeClass()
                        $('#result').addClass('strong')
                        return 'Strong'
                    }
                }
    </script>
            </div>
        </div>
    </div>

              

   
<?php
include('footer.php');
?>

