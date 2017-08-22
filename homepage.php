<?php $active ='Home'; ?>

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
        $transactionList = $client->getTransactionList($user_session);
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

<!--widgets ends here-->
    
    <section class="content">
        <div class="container-fluid">    
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>
            
            
            <div class="row clearfix">
                           </div>

            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>LAST 5 TRANSACTIONS</h2>
                            
                        </div>
                         <div class="body">
                  <form action="transactions.php" method="post">
                        <main id="content" class="topmg transactiontop main2-content">
                    <div id="page-content">
                        
                        <style>
                            @media screen and (max-width:786px){
                               table#t02{
                                   display: table;
                                width:90%;
                               }
                               #r1{
                                   display:none;
                               }
                            }
                             @media screen and (min-width:786px){
                               #r2{
                                   display:none;

                               }
                               #r1{
                                   
                               }
                            }
                            table{
                                display: table;
                                width:100%;
                            }
                            </style>
                        <div class="row" id="r1">
                            <table border=1 frame=void rules=rows>
                                
                                    <tr>
                                       
                                        <td><strong>Date</strong></td>
                                        <td><strong>Address</strong></td>
                                        <td><strong>Type</strong></td>
                                         <td><strong>Amount</strong></td>
                                        <td><strong>Confirmations</strong></td>
                                        <td><strong>TX</strong></td>
                                        
                                    </tr>
                                
                                <tbody>
<?php
                                $bold_txxs = "";
                               if(count($transactionList)>0 || count($transactionList)<6)
                                {
                                   foreach($transactionList as $transaction) {
                                      if($transaction['category']=="send") { $tx_type = '<b style="color: #FF0000;">Sent</b>'; } else { $tx_type = '<b style="color: #01DF01;">Received</b>'; }
                                      echo '<tr>
                                               <td>'.date('n/j/Y h:i a',$transaction['time']).'</td>
                                               <td>'.$transaction['address'].'</td>
                                               <td>'.$tx_type.'</td>
                                               <td>'.abs($transaction['amount']).'</td>
                                               <td>'.$transaction['confirmations'].'</td>
                                               <td colspan=\"3\"><a href="' . $blockchain_url,  $transaction['txid'] . '" target="_blank">Info</a></td>
                                            </tr>';
                                   }
                                }
                                else if((count($transactionList)== 0))
                                {
                                    echo "<tr><td colspan=\"3\">There is no Transaction exists</td></tr>";
                                }
?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row" id="r2">
                            <table id="t02" border=1 frame=void rules=rows id="t02">
                                
                                    <tr>
                                       
                                        <td>Date</td>
                                        <td>Address</td>
                                        <td>Type</td>
                                         <td>Amount</td>
                                        <td>Confirmations</td>
                                        <td>TX</td>
                                        
                                    </tr>
                                
                                <tbody>
<?php
                                $bold_txxs = "";
                               if(count($transactionList)>0 || count($transactionList)<6)
                                {
                                   foreach($transactionList as $transaction) {
                                      if($transaction['category']=="send") { $tx_type = '<b style="color: #FF0000;">Sent</b>'; } else { $tx_type = '<b style="color: #01DF01;">Received</b>'; }
                                      echo '<tr>
                                               <td>'.date('n/j/Y h:i a',$transaction['time']).'</td>
                                               <td>'.$transaction['address'].'</td>
                                               <td>'.$tx_type.'</td>
                                               <td>'.abs($transaction['amount']).'</td>
                                               <td>'.$transaction['confirmations'].'</td>
                                               <td colspan=\"3\"><a href="' . $blockchain_url,  $transaction['txid'] . '" target="_blank">Info</a></td>
                                            </tr>';
                                   }
                                }
                                else if((count($transactionList)== 0))
                                {
                                    echo "<tr><td colspan=\"3\">There is no Transaction exists</td></tr>";
                                }
?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                    </main>
                </form>
                        </div>
                    </div>
                </div>
            </div>
             

   
<?php
include('footer.php');
?>
