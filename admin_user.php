<?php $active ='My Addresses'; ?>

<?php 
	include_once('common.php');
	page_protect();
	if(!isset($_SESSION['user_id']))
	{
		logout();
	}
	$error = array();
	$userList = array();
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
			$user_current_balance = $client->getBalance($user_session) - $fee;
		}
	}

	$qstring = "select coalesce(id,0) as id, coalesce(username,'') as username, coalesce(`date`,now()) as `date`, coalesce(admin,0) as admin, 
	coalesce(locked, 0) as locked, coalesce(ip,'') as ip from users ";
	
	$result	= $mysqli->query($qstring);
	while ($user = $result->fetch_assoc())
	{
		$userList[] = $user;
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

								<style>
                         table{
                                display: table;
                                width:100%;
                            }
                            @media screen and (max-width:786px){
                            table{
                                display: table;
                                width:60%;
                            }
                            .card .body {
                                  margin-left: 7px;
                            }
                            .card .header h2 {
							    margin-left: -14px;
							    margin-bottom: -9px;
							    margin-top: 4px;
                            }
                            #tr1{
                            	    font-size: 13px;
                            }
                            #tbd1{
                            	font-size:11px;
                            }	
                        }

                        </style>
     <!-- Widgets ends-->
 

    <section class="content" style="margin-top:54px;">
        <div class="container-fluid">
            
            <!-- Text Styles -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>User Admin</h2>
                        
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <form action="myaddress.php" method="post">
					<main id="content" class="topmg main2-content" style="margin-bottom:15em;">
						<div id="page-content">
							<div class="row content-container general">
								<div class="vrtbl-responsive">
                                <div class="container">
									<table class="vrtbl vrtbl-striped" id="blocks" table border=1 frame=void rules=rows>
										<thead>
											<tr id="tr1">
												<th>UserName</th>
												<th>Created</th>
												<th>Is Admin?</th>
												<th>Is Locked?</th>
												<th>Delete</th>
												
											</tr>
										</thead>
                                        </div>
										<tbody id="tbd1">
							<?php                               
                        
                                                        if(count($userList)>0)
                                                        {
                                                            
                                                            foreach ($userList as $userValue)
                                                            {
                                                    ?>  
                                                                <tr>
                                                                    <td><?php echo $userValue['username'];?></td>
                                                                    <td><?php echo $userValue['date'];?></td>
                                                                    <td><?php if($userValue['admin']== 1) { ?>                                         
                                                                        <strong>Yes</strong> <a href="updatea.php?m=0&i=<?php echo $userValue['id']; ?>">De-admin</a> <?php } else { ?> 
                                                                        No <a style="color:blue;"href="updatea.php?m=<?php echo rand(1,10000);?>&i=<?php echo $userValue['id'] ;?>">Make admin</a> <?php } ?></td>
                                                                    <td><?php if($userValue['locked']== 1) { ?>                                        
                                                                        <strong>Yes</strong> 
                                                                        <a style="color: #00e6e6;"href="updatel.php?m=0&i=<?php echo $userValue['id']; ?>">Unlock</a> <?php } else { ?> 
                                                                        No <a style="color: #00e600;"href="updatel.php?m=<?php echo rand(1,10000);?>&i=<?php echo $userValue['id']; ?>">Lock</a> <?php } ?></td>
                                                                    <td><a style="color:red;"href="infodel.php?&m=<?php echo rand(1,10000);?>&i=<?php echo $userValue['id']; ?>" 
                                                                    onclick="return confirm('Are you sure you really want to delete user <?php echo  $userValue['username']." ";?>id =<?php echo $userValue['id']; ?>');">
                                                                        Delete</a></td>
                                                                </tr>
                                                    <?php                                           
                                                            }                                           
                                                        }
                                                        else if(count($userList)== 0)
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
