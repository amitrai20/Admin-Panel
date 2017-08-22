<?php $active ='Transactions'; ?>
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
$new_address = "";
$client = "";
if(_LIVE_)
{
	$client = new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
	if(isset($client))
	{
		$new_address = $client->getAddress($user_session);
		$user_current_balance = $client->getBalance($user_session) - $fee;
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


     <!-- Widgets ends -->
   
            <style>
           @media screen and (max-width:786px){
            #img_addresss{
                     margin-left: 30%!important;
                     margin-top: -20%!important;

            }
            }
            </style>
    <section class="content" style="margin-top: 46px;">
        <div class="container-fluid">
           
            <!-- Body Copy -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                           <div class="above-prod-table pctrns">
									<h2>RECEIVE COIN</h2>
                                    
                                        <p>An address has been created for you to receive.</p>
								</div>
                        </div>
                <div class="body">
                  <form action="send.php" method="post">
					<main id="content" class="topmg transactiontop main2-content">
						<div id="page-content">
										                      
                       <div name="loginForm" role="form" autocomplete="off" novalidate="" 
											class="ptl form-horizontal clearfix ng-pristine ng-invalid ng-invalid-required">
											<fieldset>
										
											<div class="row">
												<div class="form-group col-md-2" id="half1">
													<label style="float:left; margin-top:10px;padding-left:10px; color:#000;">Address</label>
												</div>
												<div class="form-group col-md-3" id="half1" style="margin-bottom:5px">
													<label style="font-size:10px;float:left;margin-top:10px;padding-left:20px; color:#000;"><b><?php echo $new_address;?></b></label>
												</div>
												<div class="form-group col-md-5" id="half1" style="margin:0px">
													<label style="padding:0px;margin-top:-5px;">
													<a href="http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=<?php echo $new_address?>">
												<img src="http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=<?php echo $new_address?>" 
												alt="QR Code" style="width:200px;border:0;margin-left: 108%;margin-top: -42%;" id="img_addresss"/></a></label>
												</div>
											</div>											
										</fieldset>
										</div>
                        
                    </div>
					
				</form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Body Copy -->
        
        </div>
    </section>

 <?php
include('footer.php');
?>
