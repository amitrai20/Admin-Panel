<?php $active ='Contact Us'; ?>

<?php 
include_once('common.php');
page_protect();
if(!isset($_SESSION['user_id']))
{
	logout();
}
$error = array();
$transactionList = array();
$user_session = $_SESSION['user_session'];
$user_current_balance = 0;
$user_email= $user_session;
$text_subject = "";
$trans_desc ="";

$client = "";
if(_LIVE_)
{
	$client = new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
	if(isset($client))
	{
		$user_current_balance = $client->getBalance($user_session) - $fee;
	}
}

if(isset($_POST['btnlogin']))
{
//	var_dump($_POST);
	$text_subject = $_POST['text_subject'];
	$user_email = $_POST['user_email'];
	$trans_desc = $_POST['discription'];
	
	//$user_current_balance = $client->getBalance($user_session) - $fee;
	
	if (empty($user_email))
	{
		$error['user_emailError'] = "Please Provide valid Email";
	}	
	
	if (empty($text_subject))
	{
		$error['text_subjectError'] = "Please Provide valid Subject";
	}
	
	
	
	if (empty($trans_desc))
	{
		$error['discriptionError'] = "Please Provide valid Message";
	}
	
	if(empty($error))
	{
		
		sendMailToAdmin(ADMIN_EMAIL, $user_email, $text_subject, $trans_desc);
		
		$error2['user_emailError'] = "Thank you for contacting us. You request has been submitted to concern person";
		$user_email= $user_session;
		$text_subject = "";
		$trans_desc ="";
	}	
}
?>

<?php
include('header.php');
?>

           
            <!-- #User Info -->
            <!-- Menu -->
           <?php
             include('menubar.php');
           ?>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2016 - 2017 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.5
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
    </section>
     <!-- Widgets -->
   <?php
include('widget.php');
?>

<!--widgets ends-->


                    <?php 
					if($_SESSION['user_admin'] == 1)
					{
					?>
						<a href="admin_user.php"><!--<i class="zmdi zmdi-help-outline iconFAQ" style=""></i>-->User list</a>
					<?php

					}
                    ?>	
            <script>
				function openNav() {
					document.getElementById("mySidenav").style.width = "250px";
					document.getElementById("openbtn").style.display = "none";
					document.getElementById("closebtn").style.display = "block";
				}

				function closeNav() {
					document.getElementById("mySidenav").style.width = "0";
					document.getElementById("openbtn").style.display = "block";
					document.getElementById("closebtn").style.display = "none";
				}

            </script>
                        
    <section class="content" style="margin-top: 46px;">
        <div class="container-fluid">
            
            <div class="row clearfix">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 style="font-size:33px"> 
                                Contact Us
                            </h2>
                        </div>
                    
                        <div class="body">
                           <form action="contactus.php" method="post">
                               <fieldset>
									<div  class="form-group">
										<label style="float:left;color: #ff3300;font-weight: bold;display: block;width: 150px;">Email ID:</label>
													<input id="user_email"  name ="user_email" class="validate mainaddress" 
													placeholder="Email Id" autocomplete="off" type="text"size="38"
													value="<?php echo $user_email;?>">
													
													<?php if(isset($error['user_emailError'])) { echo "<br/><span class=\"messageClass\">".$error['user_emailError']."</span>";  }?>	
													<?php if(isset($error2['user_emailError'])) { echo "<br/><span class=\"messageClass\">".$error2['user_emailError']."</span>";  }?>	
									</div>
									<div  class="form-group">
													<label style="float:left;color: #ff3300;font-weight: bold;display: block;width: 150px;">Subject :</label>
													<input id = "btcval" class="validate" placeholder="Subject" autocomplete="off" 
													name="text_subject" type="text" size="38" value ="<?php echo $text_subject;?>">
													<?php if(isset($error['text_subjectError'])) { echo "<br/><span class=\"messageClass\">".$error['text_subjectError']."</span>";  }?>	
									</div>
												
									<div class="form-group">
													<label style="float:left;color: #ff3300;font-weight: bold;display: block;width: 150px;">Description:</label>
													<textarea id="discription" name ="discription" type="text" class="validate" placeholder="Description" style="position:relative;padding: 10px;height:200px; width:292px;font-size:14px;resize: none;-ms-overflow-style: none;border:1px solid #9e9e9e;" rows="30" col="50"><?php echo $trans_desc;?></textarea>
													<?php if(isset($error['discriptionError'])) { echo "<br/><span class=\"messageClass\">".$error['discriptionError']."</span>";  }?>	
									</div>
									<div class="mtl flex-center flex-end" style="margin-top:10px;margin-left:70px">
													<input type="submit" class="btn btn-info" id="btnlogin" name="btnlogin" value="Send" style="width: 100px;height: 40px;"/>
									</div>
								</fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
include('footer.php');
?>
