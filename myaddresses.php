<?php $active ='My Addresses'; ?>

<?php 
	include_once('common.php');
	page_protect();
	if(!isset($_SESSION['user_id']))
	{
		logout();
	}
	$error = array();
	$addressList = array();
	$new_address = "";
	$user_session = $_SESSION['user_session'];
	$user_current_balance = 0;
	if(isset($_GET['nad']))
	{
		$new_address = $_GET['nad'];
	}
	$client = "";
	if(_LIVE_)
	{
		$client = new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
		if(isset($client))
		{
			//echo "<pre> dd </br>";var_dump($_SESSION);echo "</br> ddd <pre>";
			$addressList = $client->getAddressList($user_session);
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


     <!-- Widgets ends-->
 

    <section class="content" style="margin-top:54px;">
        <div class="container-fluid">
            
            <!-- Text Styles -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                My Addresses
                                <div style="float:right;color:red"><a href="genratenewaddress.php" class="btn btn-info">Create New Address</a></div>
                            </h2>
                        
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <form action="myaddress.php" method="post">
					<main id="content" class="topmg main2-content" style="margin-bottom:15em;">
						<style>
                         table{
                                display: table;
                                width:100%;
                            }
                            @media screen and (max-width:786px){
                            table{
                                display: table;
                                width:85%;
                            }
                            .card .body {
                                  margin-left: 12px;
                            }
                            }
                        </style>
						<div id="page-content">
							<div class="row content-container general">
								<div class="vrtbl-responsive">
                                <div class="container">
									<table class="vrtbl vrtbl-striped" id="blocks" table border=1 frame=void rules=rows>
										<thead>
											<tr>
												<th>Addresses</th>
												<th>Label</th>
												
											</tr>
										</thead>
                                        </div>
										<tbody>
<?php								
									if(!empty($new_address))
									{
										echo "<tr><td> New Address :- <strong>".$new_address."</strong></td>"
?>											<td colspan="2"><a href="http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=<?php echo $new_address?>">
												<img src="http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=<?php echo $new_address?>" 
												alt="QR Code" style="width:60px;border:0;"></td><tr>
<?php								}
									if(count($addressList)>0)
									{
										foreach ($addressList as $address)
										{	
											echo "<tr><td>".$address."</td>";
?>
											<td colspan="2"><a href="http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=<?php echo $address?>">
												<img src="http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=<?php echo $address?>" 
												alt="QR Code" style="width:60px;border:0;"></td><tr>
<?php
										}
									}
									else if((count($addressList)== 0) && empty($new_address))
									{
										echo "<tr><td colspan=\"3\">There is no Address exists</td></tr>";
									}
?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</main>
				</form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Text Styles -->
           
          
        </div>
    </section>

   <?php
include('footer.php');
?>
