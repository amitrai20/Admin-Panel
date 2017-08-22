
<?php $active ='Security Center'; ?>
<?php 
include_once('common.php');
//ALTER TABLE `users` ADD `otp_value` VARCHAR(500) NULL DEFAULT '' AFTER `authused`, ADD `is_email_verify` TINYINT NULL DEFAULT '0' AFTER `otp_value`;

page_protect();
if(!isset($_SESSION['user_id']))
{
	logout();
}

$otp_value = "";

$user_session = $_SESSION['user_session'];
$user_current_balance = 0;

$error = array();
$error = array();
$client = "";
if(_LIVE_)
{
	$client = new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
	if(isset($client))
	{
		$user_current_balance = $client->getBalance($user_session) - $fee;
	}
}


if(isset($_POST['btnSpending']))
{
	$otp_value = $_POST['otp_value_text'];
	
	//var_dump($otp_value); 
	if(empty($otp_value))
	{
		$error['otpError'] = "Please Provide your Valid OTP Value";
	}

	if(empty($error))
	{
	$otp_value_string = hash('sha256',addslashes(strip_tags($otp_value)));
	$qstring = "select coalesce(id,0) as id
				from users where otp_value = '" . $otp_value_string . "'";
	
	$user2 = array();
	$result2 = $mysqli->query($qstring);
//	var_dump($result2);
	if($result2)
	{
		$user2 = $result2->fetch_assoc();
	}
	//var_dump($user);
	if ($user2['id'] <= 0)
	{
		$error['otpError'] = "Your provided OTP Value do not match with  with our store Value. Please provide valid one.";
	}
	
	
	if(empty($error))
	{
		$_SESSION['is_email_verify'] = 1;
		$qstring = "update `users`set "; 
		$qstring .= "`is_email_verify` = 1 ";
		$qstring .= " WHERE ";
		//	$qstring .= " encrypt_username = '" . hash('sha256',$user_session) . "' and ";
		$qstring .= " id = ".$user2['id'];
		$result3 = $mysqli->query($qstring);
		if($result3)
		{
			$error['otpError'] = "Your Email has been successfuly verified.";
			$otp_value = "";
		}
	}
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


     <!-- Widgets -->
  

<style>
    @media screen and (max-width:786px){
            #mo_cnt.modal-content{
                width:110%!important;
            }
    }
    </style>
    <section class="content">
        <div class="container" style="width:100%">
            <form action="verifyemail.php" method="post">
					<main id="content" class="topmg transactiontop main2-content">
						<div id="page-content">
							<div class="modal-content" id="mo_cnt"style="margin-top:-20px;width:100%;">
								<div id="send1ststep">
									<div class="modal-head">
										<div class="col l8">
											<h5><!--<i class="zmdi zmdi-long-arrow-up zmdi-hc-fw"></i>-->Verify Email</h5>
											<p>An OTP has been send to your registered Email ID. Please check your email.</p>
										</div>
										<div class="col l4 right-align">
											<!--<i class="zmdi zmdi-close-circle-o modal-close"></i>-->
										</div>
									</div>
									<div class="form-horizontal white signUpContainer center" style="width:90%;padding:1%;padding-left:5%">
										<fieldset>
                                          
										
											<div class="row">
												<div class="form-group col-md-3" id="half1">
													<label style="float:left;color: #ff3300;margin-top:10px;font-weight: bold;display: block;width: 150px;">OTP Value:</label>
													<input id="otp_value_text" name="otp_value_text" autocomplete="off" class="form-control" 
													type="text" value="<?php echo $otp_value;?>" placeholder="Enter OTP" style="width:90px;padding:1px;background-color:#ffb3b3;">
												</div>
											</div>
											<div class="row" style="padding:0px;margin-top:10px">
												<div class="form-group col-md-6" id="half1" style="width:98%;margin-top:-25px">
													<?php if(isset($error['otpError'])) { echo "<br/><span class=\"messageClass\">".$error['otpError']."</span>";  }?>	
												</div>
											</div>											
											<div class="row">
												<div class="form-group col-md-8" style="width:50%;font-weight:bold;font-size:1.3em;margin-bottom:20px;">
													<input type="submit" class="btn btn-info" id="btnSpending" name="btnSpending" value="Verfiy Email"/>
												</div>
											<div> 
										</fieldset>
									</div>
								</div>
							</div>
						</div>
					</main>
				</form>

        </div>
    </section>

    <?php
include('footer.php');
?>
