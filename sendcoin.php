<?php $active ='Transactions'; ?>
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
$reciever_address= "";
$coin_amount = 0;
$trans_desc ="";
$spendingpassword = "";
$user_current_balance2 = 0;
$client = "";
if(_LIVE_)
{
	$client = new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
	if(isset($client))
	{
		$user_current_balance = $client->getBalance($user_session) - $fee;
		$user_current_balance2 = $user_current_balance;
	}
}

if(isset($_POST['btnlogin']))
{
//	var_dump($_POST);
	$coin_amount = $_POST['txtChar'];
	$reciever_address = $_POST['btcaddress'];
	$trans_desc = $_POST['discription'];
	$spendingpassword = $_POST['spendingpassword'];
	$user_current_balance = 0;
	
	if(_LIVE_)
{
	$client = new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
	if(isset($client))
	{
		$user_current_balance = $client->getBalance($user_session) - $fee;
	}
}
	if (empty($reciever_address))
	{
		$error['reciever_addressError'] = "Please Provide valid Address";
	}	
	
	if (empty($coin_amount))
	{
		$error['txtCharError'] = "Please Provide valid Amount";
	}	
	if(empty($spendingpassword))
	{
		$error['spendingpasswordError'] = "Please Provide valid Spending Password";
	}	
	if ($coin_amount > $user_current_balance)
	{
		$error['txtCharError'] = "Withdrawal amount exceeds your wallet balance";
	}
	if(!empty($spendingpassword))
	{
		$qstring = "select coalesce(id,0) as id,coalesce(transcation_password,'') as transcation_password ";
		$qstring .= "from users WHERE encrypt_username = '" . hash('sha256',$user_session) . "'";
		
		$spendingpassword_value = hash('sha256',addslashes(strip_tags($spendingpassword)));
	
		$result	= $mysqli->query($qstring);
		$user = $result->fetch_assoc();
		$transcation_password_v = $user['transcation_password'];
	
		if ($user['id']> 0 && ($transcation_password_v != $spendingpassword_value))
		{
			$error['spendingpasswordError'] = "Please provide valid Spending Password.";
		}
	}
	
	if(empty($error))
	{
		$withdraw_message = 'ssss';
		if(_LIVE_)
		{
			$withdraw_message = $client->withdraw($user_session, $reciever_address, (float)$coin_amount);
			//$withdraw_message = $client->payment($reciever_address,$coin_amount,'from $user_session');
		}
		header("Location:sucecsssend.php?m=".$withdraw_message);
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

    <section class="content" style="margin-top: 46px;">
        <div class="container-fluid">
           
            
            <!-- Body Copy -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                           <div class="above-prod-table pctrns">
									<h2>SEND COIN</h2>
                                    
                                        <p>Instantly send <?php echo $coin_fullname;?>(<?php echo $coin_short;?>) to any <?php echo $coin_fullname;?>(<?php echo $coin_short;?>) address.</p>
								</div>
                        </div>
                <div class="body">
                  <form action="sendcoin.php" method="post">
					<main id="content" class="topmg transactiontop main2-content">
						<div id="page-content">
										                      
                       <div name="loginForm" role="form" autocomplete="off" novalidate="" 
											class="ptl form-horizontal clearfix ng-pristine ng-invalid ng-invalid-required">
											<fieldset>
												<div  class="form-group">
													<label style="float:left;color: #ff3300;font-weight: bold;display: block;width: 150px;">TO:</label>
													
													<input id="btcaddress"  name ="btcaddress" class="validate mainaddress" placeholder="Paste your <?php echo $coin_short;?> Address" autocomplete="off" type="text" style="line-height: 52px;width: 100%;margin-bottom: 22px;"
													value="<?php echo $reciever_address;?>">
													
													<?php if(isset($error['reciever_addressError'])) { echo "<br/><span class=\"messageClass\">".$error['reciever_addressError']."</span>";  }?>	
												</div>
												<div  class="form-group">
                                                    <label style="float:left;color: #ff3300;font-weight: bold;display: block;width: 150px;">AMOUNT: <?php echo $coin_short;?></label>
											
													<input id = "btcval" class="validate" placeholder="0" autocomplete="off" onkeypress="return isNumberKey(event)"	name="txtChar" type="text" style="line-height: 52px;width: 100%;margin-bottom: 22px;" value ="<?php echo $coin_amount;?>">
													<?php if(isset($error['txtCharError'])) { echo "<br/><span class=\"messageClass\">".$error['txtCharError']."</span>";  }?>	
												</div>
												
												<div class="form-group">
													<label style="float:left;color: #ff3300;font-weight: bold;display: block;width: 150px;">DESCRIPTION</label>
                                                    <textarea id="discription" name ="discription" type="text" class="validate" placeholder="Description" style="position:relative;padding: 10px;height:200px; width:292px;font-size:14px;resize: none;-ms-overflow-style: none;border:1px solid #9e9e9e;" rows="30" col="50"><?php echo $trans_desc;?></textarea>
                                                    
												</div>
												<div  class="form-group">
                                                    <label style="float:left;color: #ff3300;font-weight: bold;display: block;width: 150px;margin-top:10px;">SPENDING PASSWORD:</label>
													
													<input id="spendingpassword" name="spendingpassword" class="form-control" autocomplete="off" type="password" style="line-height: 52px;width: 100%;margin-bottom: 22px;background-color:#ffb3b3;" value="<?php echo $spendingpassword;?>">
													<?php if(isset($error['spendingpasswordError'])) { echo "<br/><span class=\"messageClass\">".$error['spendingpasswordError']."</span>";  }?>	
												</div>
												
												<div class="mtl flex-center flex-end">
													<input type="submit" class="btn btn-info" id="btnlogin" name="btnlogin" value="Send" style="height:35px;width:92px"/>
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
