<?php
#error_reporting(1);
#ini_set("display_errors", 1);

if (!defined('FORUM_ROOT'))
	define('FORUM_ROOT', './');
require FORUM_ROOT.'include/common.php';

if ($forum_user['g_read_board'] == '0')
	message($lang_common['No view']);
else if ($forum_user['g_view_users'] == '0')
	message($lang_common['No permission']);

// Load the misc.php language file
require FORUM_ROOT.'lang/'.$forum_user['language'].'/misc.php';

require FORUM_ROOT.'lang/'.$forum_user['language'].'/escrows.php';
define('FORUM_PAGE', 'post');
require FORUM_ROOT.'header.php';

//odswiezam dane

// START SUBST - <!-- forum_main -->



if ($forum_user['is_guest'])
{
	header('Location: login.php');
	exit;
}
ob_start();

$currenttime = time();
$lastcheck = lastchecktime(60);
if (($currenttime - $lastcheck)> 60)
{
	try
	{
		update_btcaddresses();
		escrow_update_old_active_escrows();
		update_btc_price();
		forum_clear_cache();
	}
	catch (Exception $e)
	{
		echo "Addresses not updated";
	}
}
if ($forum_user['is_admmod'] and !isset($_GET['action']))
{
	//wyswietl liste zlecen wyplaty TYLKO DLA ADMINA
	if ($forum_user['g_id'] == FORUM_ADMIN)
	{	
		$query = array(
			'SELECT'	=> '*',
			'FROM'		=> 'payouts AS p',
			'WHERE'		=> 'p.status=0'
			);
		$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
		?>
		<div class="main-head">
				<h2 class="hn"><span><?php echo $lang_escrows['Payout orders']; ?></span></h2>
		</div>
		<table border="1">
			<tr class="<?php echo ($forum_page['item_count'] % 2 != 0) ? 'odd' : 'even' ?><?php if ($forum_page['item_count'] == 1) echo ' row1'; ?>">
				<td width="4%">Date</td>
				<td>Receiver name</td>
				<td width="4%">Amount</td>
				<td width="4%">Address</td>
				<td width ="4%">Escrow details</td>
				<td width ="14%">Action 
			<?php if (mysqli_num_rows($result)>1)
					{ ?>
				<a href ="<?php echo FORUM_ROOT.'escrows.php?action=send_all_payouts'; ?>"> <b>(Pay all)</b></a>
			<?php	}?>
					</td>
			</tr>
		
			<?php
		
			//'time, receiverid, amount, btcaddress, status, escrowid,'
			while ($row = $result->fetch_assoc())
			{
				$escrowinfo = find_escrow_by_id($row['escrowid']);
				if($escrowinfo['moderatorid'])
					$moderatorstring = "<a href=".FORUM_ROOT."profile.php?id=".$escrowinfo['moderatorid'].">".escrow_get_username($escrowinfo['moderatorid'])."</a>";
				else
					$moderatorstring = $lang_escrows['Moderation not requested'];
		
				$receivername =escrow_get_username($row['receiverid']);
				echo "<tr><td >".date('y/m/d',$row['time'])."</td>
				<td><a href=".FORUM_ROOT."profile.php?id=".$row['receiverid'].">".$receivername."</a></td>
				<td >".$row['amount']."</td>
				<td ><a href=http://blockchain.info/address/".$row['btcaddress'].">"."(Click)</a></td>
				<td><a href=".FORUM_ROOT."escrows.php?action=detail&id=".$row['escrowid']."&action=take_moderator_action>(Click)</a></td>";
				?>
				<td><a href ="<?php echo FORUM_ROOT.'escrows.php?id='.$row['index'].'&action=send_payout'; ?>"> <b>(Click to send)</b></a></td>
				<?php
				echo "</tr>";
			}
			?>
		</table>
		<?php
		}
	//wyswietl liste linkow do nowych problemow 
	
	$query = array(
		'SELECT'	=> '*',
		'FROM'		=> 'escrows AS e',
		'WHERE'		=> 'e.status='.PROBLEM_REPORTED
		);
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	
	?>
	</br>
	<div class="main-head">
			<h2 class="hn"><span><?php echo $lang_escrows['New escrow problems']; ?></span></h2>
	</div>
	<table border="1">
		<tr class="<?php echo ($forum_page['item_count'] % 2 != 0) ? 'odd' : 'even' ?><?php if ($forum_page['item_count'] == 1) echo ' row1'; ?>">
			<td width="4%">Date</td>
			<td>Buyer name</td>
			<td>Seller name</td>
			<td width="3%">Amount</td>
			<td width="4%">Recived</td>
			<td width="4%">Address</td>
			<td width ="12%">Moderator</td>
			<td width ="14%">Action</td>
		</tr>
		<?php
		//'time, receiverid, amount, btcaddress, status, escrowid,'
		while ($row = $result->fetch_assoc())
		{
			$addressid = find_address_id($row['btcaddress']);
			$addressbalance = find_address_balance($addressid);
			echo "<tr><td width=\"4%\">".date('y/m/d',$row['time'])."</td>
			<td><a href=".FORUM_ROOT."profile.php?id=".$row['buyerid'].">".escrow_get_username($row['buyerid'])."</a></td>
			<td><a href=".FORUM_ROOT."profile.php?id=".$row['sellerid'].">".escrow_get_username($row['sellerid'])."</a></td>
			<td width=\"3%\">".$row['amount']."btc</td>
			<td >".$addressbalance."btc</td>
			<td width=\"4%\"><a href="."http://blockchain.info/address/".$row['btcaddress'].">".'(click)'."</a></td>
			<td><a href=".FORUM_ROOT."profile.php?id=".$row['moderatorid'].">".escrow_get_username($row['moderatorid'])."</a></td>"
			?>
			<td><a href="<?php echo FORUM_ROOT.'escrows.php?id='.$row['index'].'&action=take_moderator_action'; ?>"><b>
			<?php 
			if ($row['moderatorid'])
			{
				echo $lang_escrows['Take moderator action'];
			}
			else
			{
				echo $lang_escrows['Moderate this problem'];
			}
			?> </b></a></td><?php
	}
		
		?>
		</tr>
	</table>
	<?php
	
	// wyswietl wszystkie biezace escrowy gdzie przyszly pieniadze
 	
	$query = array(
		'SELECT'	=> '*',
		'FROM'		=> 'escrows AS e',
		'WHERE'		=> 'e.status='.BITCOINS_RECEIVED.' OR e.status='.PROBLEM_REPORTED.' OR e.status='.BITCOINS_RELEASED,
		'ORDER BY'	=>	'time DESC'
		);
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	
	?>
	</br>
	<div class="main-head">
			<h2 class="hn"><span><?php echo $lang_escrows['Current escrows']; ?></span></h2>
	</div>
	<table border="1">
		<tr class="<?php echo ($forum_page['item_count'] % 2 != 0) ? 'odd' : 'even' ?><?php if ($forum_page['item_count'] == 1) echo ' row1'; ?>">
			<td width="4%">Date</td>
			<td>Buyer name</td>
			<td>Seller name</td>
			<td width="4%">Declared Amount</td>
			<td width="4%">Address</td>
			<td width ="12%">Status</td>
			<td width ="14%">Moderator</td>
		</tr>
		<?php
		//'time, receiverid, amount, btcaddress, status, escrowid,'
		while ($row = $result->fetch_assoc())
		{
			if($row['moderatorid'])
				$moderatorstring = "<a href=".FORUM_ROOT."profile.php?id=".$row['moderatorid'].">".escrow_get_username($row['moderatorid'])."</a>";
			else
				$moderatorstring = $lang_escrows['Moderation not requested'];
				
			echo "<tr><td>".date('y/m/d',$row['time'])."</td>
			<td><a href=".FORUM_ROOT."profile.php?id=".$row['buyerid'].">".escrow_get_username($row['buyerid'])."</a></td>
			<td><a href=".FORUM_ROOT."profile.php?id=".$row['sellerid'].">".escrow_get_username($row['sellerid'])."</a></td>
			<td >".$row['amount']."btc</td>
			<td ><a href="."http://blockchain.info/address/".$row['btcaddress'].">".'(click)'."</a></td>
			<td>".get_escrow_status($row['status'])."</td>
			<td>".$moderatorstring."</td></tr>";
	}	
		$_SESSION['currentpayout'] = escrow_moderator_get_currentpayout($forum_user['id']);
		?>
	</table>
	
	<!-- tabela z zarobkami moderatora -->
			<div class="main-head">
				<h2 class="hn"><span><?php echo $lang_escrows['Moderator earnings']; ?></span></h2>
		</div>
		<table border="1">
			<tr class="<?php echo ($forum_page['item_count'] % 2 != 0) ? 'odd' : 'even' ?><?php if ($forum_page['item_count'] == 1) echo ' row1'; ?>">
				<td>Currently earned</td>
				<td>Total earned</td>
				<td>Minimum payout amount: <?php echo $forum_config['o_minimum_escrow_value'];?>BTC</td>
			</tr>
			<tr>
				<td><?php echo $_SESSION['currentpayout']; ?> BTC</td>
				<td><?php echo escrow_moderator_get_totalpayout($forum_user['id']); ?> BTC</td>
				<td>
				<?php if ($_SESSION['currentpayout']>$forum_config['o_minimum_escrow_value'])
					  { ?>
					<a href="<?php echo FORUM_ROOT.'escrows.php?action=moderator_payout';?>"><b>Request earning payout</b></a>
				<?php }else
					  {?>
					<b>To small amount to payout</b>
				<?php } ?>
				</td>
			</tr>
		</table>
	<?php
}
else if (isset($_GET['action']) and $_GET['action']=='moderator_payout' and $forum_user['is_admmod'] and
	$_SESSION['currentpayout'] > $forum_config['o_minimum_escrow_value'])
{
	if (isset($_GET['answer']) and $_GET['answer']=='yes')
	{
		$now =time();
		escrow_note_new_payout($now,$forum_user['id'],$_SESSION['currentpayout'],$forum_user['btcaddress'],-1);
		escrow_update_moderator_currentpayout($forum_user['id'], 0);
		echo "<p>Thanks, please wait for admins payout</p>";
		$_SESSION['currentpayout']=0;
	}
	else
	{
?>
	<div class="main-head">
		<h2 class="hn"><span><?php echo "<b>".$lang_escrows['Are you sure you want to payout your earnings?']."</b>";?></span></h2>
	</div>
	<div>
	<table>
		<tr>
			<td width="80%">
				<p><?php echo $lang_escrows['If you are sure']?></p>
			</td>
			<td>
				<span class="submit primary">
					<a href="<?php echo FORUM_ROOT.'escrows.php?action=moderator_payout&answer=yes'; ?>"><?php echo "<b><u>".$lang_escrows['Confirm']."</u></b>"; ?></a>
				</span>
			</td>
		</tr>
	</table>
	</div>	
<?php
	}
}
else if (isset($_GET['action']) and $_GET['action']=='send_all_payouts' and $forum_user['g_id'] == FORUM_ADMIN)
{
	$query = array(
		'SELECT'	=> '*',
		'FROM'		=> 'payouts AS p',
		'WHERE'		=> 'p.status=0'
		);
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);	
	$payoutsum =0;
	while ($row = mysqli_fetch_assoc($result))
	{
		$payoutsum = $payoutsum + $row['amount'];
	}
	?>	
	<div class="main-head">
		<h2 class="hn"><span><?php echo "<b>".$lang_escrows['Are you sure you want to payout']." ".$payoutsum." BTC</b>";?></span></h2>
	</div>
	<span class="submit primary">
	<FORM METHOD="POST" ACTION="<?php echo FORUM_ROOT.'escrows.php?action=confirm_send_all_payouts'; ?>">
	<div>
		<table>
			<tr>
			<td >
				<p><?php echo $lang_escrows['Secondary blockchain password'];?></p>
			</td>
			<td>
				<INPUT TYPE="text" NAME='req_blockchain_password' >
			</td>
			</tr>
			
			<tr>
				<td>				
				<INPUT TYPE="submit" VALUE="<?php echo $lang_escrows['Accept'] ;?>">
				</td>
				<td>
					<a href=<?php echo FORUM_ROOT.'escrows.php';?>><?php echo $lang_escrows['Go back']; ?></a>
				</td>
			</tr>
		</table>
	</div>
	</FORM></span>
	<?php
}

else if (isset($_GET['action']) and $_GET['action']=='confirm_send_all_payouts' and $forum_user['g_id'] == FORUM_ADMIN and
	isset($_POST['req_blockchain_password']))
{
	$query = array(
		'SELECT'	=> '*',
		'FROM'		=> 'payouts AS p',
		'WHERE'		=> 'p.status=0'
		);
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	$response_string = '<table>';	
	$response_string_end = '</table>';	
	$payment_memory=array();
	while ($row = mysqli_fetch_assoc($result))
	{
		if ($row['escrowid']>0)
		{
			$escrowinfo = find_escrow_by_id($row['escrowid']);
			$sourcebtcaddress = $escrowinfo['btcaddress'];
		}
		else
		{
			$sourcebtcaddress = $outgoingaddress;
		}
		
		$uri = $blockchainUserRoot."payment?password=".$_POST['req_blockchain_password']."&to=".
			$row['btcaddress']."&amount=".amount($row['amount'])."&from=".$sourcebtcaddress."&note=ToRepublic";
		$btc_data = get_bitcoin_data($uri);
		if ($btc_data->tx_hash)
		{
			$previousbalance = escrow_get_address_balance($sourcebtcaddress); //odczyt z bazy 
			$newbalance = $previousbalance -$row['amount']-$blockchainfee;
			escrow_update_address_balance($sourcebtcaddress,$newbalance);
			escrow_payout_insert_transaction_hash($row['index'],$btc_data->tx_hash);
			if ($row['escrowid']>0) //gdy to jest platnosc moderatora to id =-1
			{
				$thisEscrowId = $row['escrowid'];
				if ($escrowinfo['status']!=PARTIAL_BITCOIN_RETURN || in_array($thisEscrowId,$payment_memory))
				{  //nie moze zwalniac adresu przy pierwszej platnosci partial bo nie bedzie moglo wykonac drugiej
					escrow_free_escrow_address($sourcebtcaddress,$newbalance , $_POST['req_blockchain_password']);
					
				}
				array_push($payment_memory, $thisEscrowId);
			}
		escrow_notify_payment_send($row['receiverid'],$row['amount'],$row['btcaddress'],$btc_data->tx_hash);
		escrow_change_payment_status($row['index'],PAYOUT_REALISED);
		}
		sleep(1);
		$response_string = $response_string.'<tr><td>'.$row['amount'].'</td><td>'.$btc_data->tx_hash.'</td></tr>';
	}
	echo $response_string.$response_string_end;
}

else if ( isset($_GET['action']) and $_GET['action']=='send_payout' and $forum_user['g_id'] == FORUM_ADMIN and
	isset($_GET['id']) and is_numeric($_GET['id']))
{
	$query = array(
		'SELECT'	=> '*',
		'FROM'		=> 'payouts AS p',
		'WHERE'		=> 'p.index='.$_GET['id']
		);
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	$row = mysqli_fetch_assoc($result);	
	$payoutsum = $row['amount'];
	?>	
	<div class="main-head">
		<h2 class="hn"><span><?php echo "<b>".$lang_escrows['Are you sure you want to payout']." ".$payoutsum." BTC</b>";?></span></h2>
	</div>
	<span class="submit primary">
	<FORM METHOD="POST" ACTION="<?php echo FORUM_ROOT.'escrows.php?id='.$_GET['id'].'&action=confirm_send_payout'; ?>">
	<div>
		<table>
			<tr>
			<td >
				<p><?php echo $lang_escrows['Secondary blockchain password'];?></p>
			</td>
			<td>
				<INPUT TYPE="text" NAME='req_blockchain_password' >
			</td>
			</tr>
			
			<tr>
				<td>				
				<INPUT TYPE="submit" VALUE="<?php echo $lang_escrows['Accept'] ;?>">
				</td>
				<td>
					<a href="<?php echo FORUM_ROOT.'escrows.php'; ?>"><?php echo $lang_escrows['Go back']; ?></a>
				</td>
			</tr>
		</table>
	</div>
	</FORM></span>
	<?php
}

else if (isset($_GET['action']) and $_GET['action']=='confirm_send_payout' and $forum_user['g_id'] == FORUM_ADMIN and
	isset($_POST['req_blockchain_password']) and isset($_GET['id']) and is_numeric($_GET['id']))
{
	$query = array(
		'SELECT'	=> '*',
		'FROM'		=> 'payouts AS p',
		'WHERE'		=> 'p.index='.$_GET['id']
		);
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	$response_string = '<table>';	
	$response_string_end = '</table>';
	
	$row = mysqli_fetch_assoc($result);
	if ($row['escrowid']>0) //gdy to jest platnosc moderatora to id =-1
	{
		$escrowinfo = find_escrow_by_id($row['escrowid']);
		$sourcebtcaddress = $escrowinfo['btcaddress'];
	}
	else
	{
		$sourcebtcaddress = $outgoingaddress;
	}
	$uri = $blockchainUserRoot."payment?password=".$_POST['req_blockchain_password']."&to=".
			$row['btcaddress']."&amount=".amount($row['amount'])."&from=".$sourcebtcaddress;
	$btc_data = get_bitcoin_data($uri);  //place
	#print $btc_data;
	#echo($uri);
	if ($btc_data->tx_hash)
	{
		$previousbalance = escrow_get_address_balance($sourcebtcaddress); //odczyt z bazy 
		$newbalance = $previousbalance -$row['amount']-$blockchainfee;
		escrow_update_address_balance($sourcebtcaddress,$newbalance);
		escrow_change_payment_status($row['index'],PAYOUT_REALISED);
		escrow_payout_insert_transaction_hash($row['index'],$btc_data->tx_hash);
		if ($row['escrowid']>0)
			escrow_free_escrow_address($sourcebtcaddress,$newbalance , $_POST['req_blockchain_password']);
		escrow_notify_payment_send($row['receiverid'],$row['amount'],$row['btcaddress'],$btc_data->tx_hash);
	}
	$response_string = $response_string.'<tr><td>'.$row['amount'].' BTC</td><td>'.$btc_data->tx_hash.'</td></tr>';
	echo $response_string.$response_string_end;
}

else if ($forum_user['is_admmod'] and isset($_GET['id']) and is_numeric($_GET['id']) 
		and isset($_GET['action']) and ($_GET['action']=='take_moderator_action') and isset($_GET['answer']) 
		and $_GET['answer']=='yes' and isset($_SESSION['escrowinfo']) and $_SESSION['escrowinfo']['status']==PROBLEM_REPORTED
		and $escrowinfo['moderatorid']==0)
{
	$moderatorid = $forum_user['id'];
	set_escrow_moderatorid($_GET['id'], $forum_user['id']);
	redirect(FORUM_ROOT.'escrows.php?id='.$_GET['id'].'&mod=1', $lang_post['Post redirect']);
}
//pytanie moderatora o potwierdzenie checi moderacji sporu
// oraz inne akcje dla modow
else if ($forum_user['is_admmod'] and isset($_GET['id']) and is_numeric($_GET['id']) and isset($_GET['action']) 
		and ($_GET['action']=='take_moderator_action') )
{
	$_SESSION['escrowinfo'] = find_escrow_by_id($_GET['id']);
	//jesli nie ma jeszcze moderatora tego problemu
	if ($_SESSION['escrowinfo']['moderatorid']==0 and $_SESSION['escrowinfo']['status']==PROBLEM_REPORTED)
	{
	?>
	</br>
	<div class="main-head">
			<h2 class="hn"><span><?php echo $lang_escrows['Do you really want to moderate?']; ?></span></h2>
	</div>
	<table border="1">
		<tr class="<?php echo ($forum_page['item_count'] % 2 != 0) ? 'odd' : 'even' ?><?php if ($forum_page['item_count'] == 1) echo ' row1'; ?>">
			<td><a href="<?php echo FORUM_ROOT.'escrows.php?id='.$_GET['id'].'&action=take_moderator_action&answer=yes';?>"><b>Yes</b></a></td>
			<td><a href="<?php echo FORUM_ROOT.'escrows.php';?>"><b>No</b></a></td>
		</tr>
	</table>
	<?php
	}//jesli  problem jest ogladany przez moderatora problemu
	if ($_SESSION['escrowinfo']['moderatorid']==$forum_user['id'] and $_SESSION['escrowinfo']['status']==PROBLEM_REPORTED or $forum_user['g_id'] == FORUM_ADMIN)
	{
	?>
		</br>
	<div class="main-head">
			<h2 class="hn"><span><?php echo $lang_escrows['Choose action']; ?></span></h2>
	</div>
	<table border="1">
		<tr class="<?php echo ($forum_page['item_count'] % 2 != 0) ? 'odd' : 'even' ?><?php if ($forum_page['item_count'] == 1) echo ' row1'; ?>">
			
			<?php $problemlink = sprintf($lang_escrows['click to read details link'],$_SESSION['escrowinfo']['problemid']); ?>

			<td>See claim history<?php echo $problemlink;?></td>
			<!-- No refund powoduje ze kasa jest zwalniana i idzie do sprzedawcy, wymaga potwierdzenia-->
			<td><a href="<?php echo FORUM_ROOT.'escrows.php?id='.$_GET['id'].'&action=no_refund';?>">No refund</a></td>
		</tr>
		<tr>
			<!-- Partial refund powoduje ,ze otwiera sie strona z pytaniem ile procent zrefundowac kupujacemu -->
			<td><a href="<?php echo FORUM_ROOT.'escrows.php?id='.$_GET['id'].'&action=partial_refund';?>">Partial refund</a></td>
			<!-- Full refund powoduje, ze cala kasa wraca do kupujacego -->
			<td><a href="<?php echo FORUM_ROOT.'escrows.php?id='.$_GET['id'].'&action=full_refund';?>">Full refund</a></td>
		</tr>
	</table>
	<?php
	}
	
	$sellerinfo = get_user_info($_SESSION['escrowinfo']['sellerid']);
	$buyerinfo = get_user_info($_SESSION['escrowinfo']['buyerid']);
	$addressbalance = find_address_balance_by_address($_SESSION['escrowinfo']['btcaddress']);
	?>
	
		
	<div class="main-head">
			<h2 class="hn"><span><?php echo $lang_escrows['Escrow details']; ?></span></h2>
	</div>
	<table border="1">
		<tr class="<?php echo ($forum_page['item_count'] % 2 != 0) ? 'odd' : 'even' ?><?php if ($forum_page['item_count'] == 1) echo ' row1'; ?>">
			<td>ID</td>
			<td><?php echo $_SESSION['escrowinfo']['index'];?></td>
			
			<td>Date</td>
			<td><?php echo date('Y-m-d H:i', $_SESSION['escrowinfo']['time']);?></td>
		</tr>
		<tr>
			<td>Buyer</td>
			<td><?php echo "<a href=".FORUM_ROOT."profile.php?id=".$_SESSION['escrowinfo']['buyerid'].">".escrow_get_username($_SESSION['escrowinfo']['buyerid'])."</a>";?></td>

			<td>Seller</td>
			<td><?php echo "<a href=".FORUM_ROOT."profile.php?id=".$_SESSION['escrowinfo']['sellerid'].">".escrow_get_username($_SESSION['escrowinfo']['sellerid'])."</a>";?></td>

		</tr>
		<tr>
			<td>Subject</td>
			<td><?php echo $_SESSION['escrowinfo']['subject'];?></td>

			<td>Declared amount</td>
			<td><?php echo $_SESSION['escrowinfo']['amount'];?></td>
		</tr>
		<tr>
			<td>Received amount</td>
			<td><?php echo $addressbalance." btc";?></td>

			<td>Received time</td>
			<td><?php echo date('Y-m-d H:i',$_SESSION['escrowinfo']['recivedtime']);?></td>
		</tr>
		<tr>
			<td>Storage address</td>
			<td><?php echo "<a href=http://blockchain.info/address/".$_SESSION['escrowinfo']['btcaddress'].">"."(click)</a>"?></td>
			
			<td>Moderator</td>
			<td><?php echo escrow_get_username($_SESSION['escrowinfo']['moderatorid']);?></td>
		</tr>
		<tr>
			<td>Status</td>
			<td><?php echo get_escrow_status($_SESSION['escrowinfo']['status']);?></td>

			<td>Problem occured</td>
			<td><?php echo ($_SESSION['escrowinfo']['problemoccured']) ? 'Yes' : 'No';?></td>
		</tr>
		<tr>
			<td>Claim reason</td>
			<td><?php echo escrow_get_claim_reason($_SESSION['escrowinfo']['problemreason']);?></td>
			
			<td>Action claimed</td>
			<td><?php echo escrow_get_action_claimed($_SESSION['escrowinfo']['problemclaim']);?></td>
		</tr>
		<tr>
			<td>Payout amount</td>
			<td><?php echo escrow_get_payout_amount($_SESSION['escrowinfo']);?></td>
			
			<td>Payout address</td>
			<td><?php echo escrow_get_payout_address_link($_SESSION['escrowinfo']);?></td>
		</tr>
		<tr>
			<td>Seller address</td>
			<td><?php echo "<a href=http://blockchain.info/address/".$sellerinfo['btcaddress'].">"."(click)</a>"?></td>
			
			<td>Buyer address</td>
			<td><?php echo "<a href=http://blockchain.info/address/".$buyerinfo['btcaddress'].">"."(click)</a>"?></td>
		</tr>
	</table>
	<?php
}
//NO REFUND
else if (isset($_GET['action']) and isset($_GET['id']) and isset($_SESSION['escrowinfo']) and $forum_user['is_admmod'] and 
	$forum_user['id']==$_SESSION['escrowinfo']['moderatorid'] and $_GET['action']=='no_refund')
{ 
	?>
			<div class="main-head">
			<h2 class="hn"><span><?php echo "<b>".$lang_escrows['Are you sure you want to give no return?']."</b>";?></span></h2>
			</div>
			<div>
			<table>
				<tr>
					<td width="80%">
						<p><?php echo $lang_escrows['If you are sure']?></p>
					</td>
					<td>
						<span class="submit primary">
							<a href="<?php echo FORUM_ROOT.'escrows.php?id='.$_GET['id'].'&action=confirm_no_refund'; ?>"><?php echo "<b><u>".$lang_escrows['Confirm']."</u></b>"; ?></a>
						</span>
					</td>
				</tr>
			</table>
			</div>	
	<?php
}
else if (isset($_GET['action']) and isset($_GET['id']) and isset($_SESSION['escrowinfo']) and $forum_user['is_admmod'] and
	$forum_user['id']==$_SESSION['escrowinfo']['moderatorid'] and $_GET['action']=='partial_refund')
{
	// TU PARTIAL REFUND ARE YOU SURE? 
	?>
			<div class="main-head">
			<h2 class="hn"><span><?php echo "<b>".$lang_escrows['Are you sure you want to give partial return?']."</b>";?></span></h2>
			</div>
			<div>
			<table>
				<tr>
					<td width="80%">
						<p><?php echo $lang_escrows['If you are sure']?></p>
					</td>
					<td>
						<span class="submit primary">
							<a href="<?php echo FORUM_ROOT.'escrows.php?id='.$_GET['id'].'&action=confirm_partial_refund'; ?>"><?php echo "<b><u>".$lang_escrows['Confirm']."</u></b>"; ?></a>
						</span>
					</td>
				</tr>
			</table>
			</div>	
	<?php	

} 
else if (isset($_GET['action']) and isset($_GET['id']) and isset($_SESSION['escrowinfo']) and $forum_user['is_admmod'] and 
	$forum_user['id']==$_SESSION['escrowinfo']['moderatorid'] and $_GET['action']=='full_refund')
{
	//TU FULL REFUND ARE YOU SURE? 
	?>
			<div class="main-head">
			<h2 class="hn"><span><?php echo "<b>".$lang_escrows['Are you sure you want to give full return?']."</b>";?></span></h2>
			</div>
			<div>
			<table>
				<tr>
					<td width="80%">
						<p><?php echo $lang_escrows['If you are sure']?></p>
					</td>
					<td>
						<span class="submit primary">
							<a href="<?php echo FORUM_ROOT.'escrows.php?id='.$_GET['id'].'&action=confirm_full_refund'; ?>"><?php echo "<b><u>".$lang_escrows['Confirm']."</u></b>"; ?></a>
						</span>
					</td>
				</tr>
			</table>
			</div>	
	<?php
}
//NO REFUND
else if (isset($_GET['action']) and isset($_GET['id']) and isset($_SESSION['escrowinfo']) and $forum_user['is_admmod'] and 
	$forum_user['id']==$_SESSION['escrowinfo']['moderatorid'] and 
	$_GET['action']=='confirm_no_refund' and $_SESSION['escrowinfo']['status']==PROBLEM_REPORTED)
{ 
	$escrowinfo = $_SESSION['escrowinfo'];
	$selleraddress = get_user_info($escrowinfo['sellerid']);
	$selleraddress = $selleraddress['btcaddress'];
	
	change_escrow_status($escrowinfo['index'] ,NO_BITCOIN_RETURN);
	$_SESSION['escrowinfo']['status']= NO_BITCOIN_RETURN;
	$amount=escrow_get_payout_amount($escrowinfo);
	$now = time();
	escrow_note_new_payout($now, $escrowinfo['sellerid'],$amount ,$selleraddress,$escrowinfo['index']);
	escrow_notify_problem_resolved($escrowinfo);
	$moderatorincome = escrow_get_moderator_earning($escrowinfo);
	escrow_note_moderator_earnings($forum_user['id'], $moderatorincome);
	?>
	<h1>Confirmed</h1>
	<?php
}// FULL REFUND
else if (isset($_GET['action']) and isset($_GET['id']) and isset($_SESSION['escrowinfo']) and $forum_user['is_admmod'] and 
	$forum_user['id']==$_SESSION['escrowinfo']['moderatorid'] and 
	$_GET['action']=='confirm_full_refund' and $_SESSION['escrowinfo']['status']==PROBLEM_REPORTED)
{
	$escrowinfo = $_SESSION['escrowinfo'];
	$buyeraddress = get_user_info($escrowinfo['buyerid']);
	$buyeraddress = $buyeraddress['btcaddress'];
	change_escrow_status($escrowinfo['index'] ,FULL_BITCOIN_RETURN); 
	$escrowinfo['status']= FULL_BITCOIN_RETURN;
	$amount=escrow_get_payout_amount($escrowinfo);
	$now = time();
	escrow_note_new_payout($now, $escrowinfo['buyerid'],$amount ,$buyeraddress,$escrowinfo['index']);
	escrow_notify_problem_resolved($escrowinfo);
	$moderatorincome = escrow_get_moderator_earning($escrowinfo);
	escrow_note_moderator_earnings($forum_user['id'], $moderatorincome);
	?>
	<h1>Confirmed</h1>
	<?php
}  //PARTIAL REFUND
else if (isset($_GET['action']) and isset($_GET['id']) and isset($_SESSION['escrowinfo']) and isset($_GET['answer']) and $forum_user['is_admmod'] and 
	$forum_user['id']==$_SESSION['escrowinfo']['moderatorid'] and $_GET['action']=='confirm_partial_refund' and
	$_GET['answer']=='yes' and $_SESSION['escrowinfo']['status']==PROBLEM_REPORTED and isset($_POST['req_refund_percentage']) and
	intval($_POST['req_refund_percentage'])<100 and intval($_POST['req_refund_percentage'])>0)
{ 
	$now = time();
	//$escrowinfo = $_SESSION['escrowinfo'];
	change_escrow_status($_SESSION['escrowinfo']['index'] ,PARTIAL_BITCOIN_RETURN);
	$_SESSION['escrowinfo']['status']= PARTIAL_BITCOIN_RETURN;
	$totalpayoutamount = escrow_get_payout_amount($_SESSION['escrowinfo']);
	$buyerpayoutamount = $_POST['req_refund_percentage']/100*$totalpayoutamount;
	$sellerpayoutamount= (1-$_POST['req_refund_percentage']/100)*$totalpayoutamount;
	
	$buyeraddress= get_user_info($_SESSION['escrowinfo']['buyerid']);
	$buyeraddress= $buyeraddress['btcaddress'];
	$selleraddress= get_user_info($_SESSION['escrowinfo']['sellerid']);
	$selleraddress= $selleraddress['btcaddress'];
	
	//buyer payment
	escrow_note_new_payout($now, $_SESSION['escrowinfo']['buyerid'] ,
		$buyerpayoutamount ,$buyeraddress,$_SESSION['escrowinfo']['index']);
	
	//seller payment
	escrow_note_new_payout($now, $_SESSION['escrowinfo']['sellerid'] ,
		$sellerpayoutamount ,$selleraddress,$_SESSION['escrowinfo']['index']);
	escrow_notify_problem_resolved($_SESSION['escrowinfo']);
	$moderatorincome = escrow_get_moderator_earning($_SESSION['escrowinfo']);
	escrow_note_moderator_earnings($forum_user['id'], $moderatorincome);
	?>
	<h1>Confirmed <?php echo $buyerpayoutamount;?> BTC refund.</h1>
	<?php	
}
//  PARTIAL REFUND 
else if (isset($_GET['action']) and isset($_GET['id']) and isset($_SESSION['escrowinfo']) and $forum_user['is_admmod'] and 
	$forum_user['id']==$_SESSION['escrowinfo']['moderatorid'] and $_GET['action']=='confirm_partial_refund')
{ 

// formularz ile procent z wyplaty dla kupujacego 
?>
	<div class="main-head">
		<h2 class="hn"><span><?php echo "<b>".$lang_escrows['Insert refund percentage']."</b>";?></span></h2>
	</div>
	<span class="submit primary">
	<FORM METHOD="POST" ACTION="<?php echo FORUM_ROOT.'escrows.php?id='.$_GET['id'].'&action=confirm_partial_refund&answer=yes'; ?>">

	<div>
		<table>
			<tr>
			<td >
				<p><?php echo $lang_escrows['Refund percentage']?></p>
			</td>
				<td>
				<INPUT TYPE="number" NAME='req_refund_percentage' VALUE="50">%
				</td>
			</tr>
			
			<tr>
				<td>				
				<INPUT TYPE="submit" VALUE="<?php echo $lang_escrows['Accept'] ?>">
				</td>
				<td>
				<a href="<?php echo FORUM_ROOT.'escrows.php?id='.$_GET['id'].'&action=take_moderator_action'; ?>"><?php echo "<b><u>".$lang_escrows['Go back']."</u></b>"; ?></a>
				</td>
			</tr>
		</table>
	</div>
	</FORM></span>
<?php
//potem 
// new payment for seller
//new payment for buyer
// messages for seller and buyer
// close topic
}

//zlecono wyswietlenie szczegolow
else if (isset($_GET['action']) and isset($_GET['id']) and $_GET['action']=='detail' and 
((isset($_SESSION['buyer']) and isset($_SESSION['seller'])) 
    or     (isset($_GET['mod']) and $forum_user['is_admmod']=='is_admmod')))
{
	$id = $_GET['id'];
	if (is_numeric($id))
	{
		$query = array(
			'SELECT'	=>	'e.*',
			'FROM'		=>	'escrows AS e',
			'WHERE'		=>	'e.index='.$id 
			);
		($hook = get_hook('ul_qr_get_details')) ? eval($hook) : null;
		$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
		//print_r($result);
		//$details = mysql_fetch_assoc($result);
		$_SESSION['escrowinfo']=mysqli_fetch_assoc($result);
		if($forum_user['id']== $_SESSION['escrowinfo']['sellerid'] or $forum_user['id']== $_SESSION['escrowinfo']['buyerid'] or $forum_user['is_admmod'])
		{
			$addressID = find_address_id($_SESSION['escrowinfo']['btcaddress']);
			$balance = find_address_balance($addressID);
			?>
			<div class="main-head">
			<h2 class="hn"><span><?php echo $lang_escrows['Escrow summary']; ?></span></h2>
			</div>
			<table border="1">
				<tr class="<?php echo ($forum_page['item_count'] % 2 != 0) ? 'odd' : 'even' ;?><?php if ($forum_page['item_count'] == 1) echo ' row1'; ?>">
					<td width="25%">Date</td><td><?php echo date('Y-m-d',$_SESSION['escrowinfo']['time']); ?></td>
				</tr>
				<tr>
					<td width="25%">Buyer name</td><td> <?php echo escrow_get_username($_SESSION['escrowinfo']['buyerid']);?></td>
				</tr>
				<tr>
					<td width="25%">Seller name</td><td> <?php echo escrow_get_username($_SESSION['escrowinfo']['sellerid']);?></td>
				</tr>
				<tr>
					<td width="25%">Ordered Amount</td><td> <?php echo $_SESSION['escrowinfo']['amount'];?></td>
				</tr>
				<tr>
					<td width="25%">Received</td><td> <?php echo $balance;?></td>
				</tr>
				<tr>
					<?php $problemlink = sprintf($lang_escrows['click to read details link'],$_SESSION['escrowinfo']['problemid']); ?>
					<td width="25%">Problem reported</td><td> <?php echo ($_SESSION['escrowinfo']['problemoccured'])? 'Yes'.$problemlink : 'Not' ;?></td>
				</tr>
				<?php 
				if ($forum_user['id']== $_SESSION['escrowinfo']['sellerid'] or $forum_user['id']== $_SESSION['escrowinfo']['buyerid'])
				{
				?>
				<tr>
					<td width="25%">Action</td>
					<td>
					<table border="0">
						<tr>
							<!--jesli wplacone ale jeszcze nie doszlo do konca czasu i user jest kupujacym -->
							<?php 
							if (($_SESSION['escrowinfo']['status']==BITCOINS_RECEIVED OR $_SESSION['escrowinfo']['status']==PROBLEM_REPORTED) and $_SESSION['escrowinfo']['buyerid']==$forum_user['id'])
							{ ?>
								<td width="48%"><span class="submit primary"><a href="<?php echo FORUM_ROOT.'escrows.php?action=accept&id='.$id; ?>"><?php echo "<b>".$lang_escrows['Transaction succedeed']."</b>";?></a></FORM></span></td>
							<?php
							} ?>
							<!--zawsze moze byc GO BACK-->
							<td><a href="<?php echo FORUM_ROOT.'escrows.php'; ?>"><?php echo "<b>".$lang_escrows['Go back']."</b>";?></a></td>
							<!-- jesli nie doszlo do konca aukcji i pieniadze zostaly wplacone kupujacy moze REPORT PROBLEM-->
							<?php
							if ($_SESSION['escrowinfo']['status']==BITCOINS_RECEIVED and $_SESSION['escrowinfo']['buyerid']==$forum_user['id'])
							{
								$_SESSION['can_report_problem']=1;
							?>
							<td><a href="<?php echo FORUM_ROOT.'escrows.php?action=report_problem&id='.$id; ?>"><?php echo "<b>".$lang_escrows['Report problem']; ?></a></td>
							<?php
							}
							?>
							<!-- jesli doszlo do konca aukcji i jest sprzedawca lub kupujacym ze zwrotem to moze wyplacic pieniadze -->
							<!--  lub jesli przyznano kupujacemu zwrot pieniedzy -->
							<?php
							if ($_SESSION['escrowinfo']['status']==BITCOINS_RELEASED and $_SESSION['escrowinfo']['sellerid']==$forum_user['id'])
							{
							?>
							<td><a href="<?php echo FORUM_ROOT.'escrows.php?id='.$id.'&action=payout'; ?>"><?php echo "<b>".$lang_escrows['Payout']."</b>"; ?></a></td>
							<?php	
							}
							?>
						</tr>
					</table>
					</td>
				</tr>
			<?php } ?>
			</table>

			<?php
		}
	}
}
// zgloszono problem
else if (isset($_GET['action']) and isset($_GET['id']) and $_GET['action']=='report_problem')
{
	$id = $_GET['id'];
	if (is_numeric($id))
	{
		$query = array(
			'SELECT'	=>	'e.*',
			'FROM'		=>	'escrows AS e',
			'WHERE'		=>	'e.index='.$id 
			);
		$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
		$_SESSION['escrowinfo'] = mysqli_fetch_assoc($result);
		if($forum_user['id']== $_SESSION['escrowinfo']['sellerid'] or $forum_user['id']== $_SESSION['escrowinfo']['buyerid'] and $_SESSION['escrowinfo']['status']!=PROBLEM_REPORTED)
		{
			
			$_SESSION['problem_subject'] = sprintf($lang_escrows['New problem reported by buyer'], $_SESSION['escrowinfo']['index'] , escrow_get_username($_SESSION['escrowinfo']['buyerid']), $_SESSION['escrowinfo']['subject'], $_SESSION['escrowinfo']['amount']);
			if (count($_SESSION['problem_subject'] >70))
			{
				$_SESSION['problem_subject'] = substr($_SESSION['problem_subject'],0,70);
			}
			$_SESSION['can_report_problem']=1;
			?>
			<div class="main-head">
			<h2 class="hn"><span><?php echo "<b>".$lang_escrows['Are you sure?']."</b>";?></span></h2>
			</div>
			<div>
			<table>
				<tr>
					<td width="80%">
						<p><?php echo $lang_escrows['If you are sure please click the link']?></p>
					</td>
					<td>
						<span class="submit primary">
							<a href="<?php echo FORUM_ROOT.'reportproblem.php?fid='.$forum_config['o_problem_forum_id'].'&subject=1'; ?>"><?php echo "<b><u>".$lang_escrows['Report problem']."</u></b>"; ?></a>
						</span>
					</td>
				</tr>
			</table>
			</div>
			<?php
		}
	}
}
// przed czasem zwolniono srodki
else if (isset($_GET['action']) and isset($_GET['id']) and $_GET['action']=='accept' and is_numeric($_GET['id']))
{
	$escrowinfo = find_escrow_by_id($_GET['id']);
	//print_r($escrowinfo);
	//sprawdzam czy uprawniony uzytkownik wszedl pod ten link
	if ($escrowinfo['buyerid']==$forum_user['id'] && ($escrowinfo['status']==BITCOINS_RECEIVED || $escrowinfo['status']==PROBLEM_REPORTED))
	{
		change_escrow_status($_GET['id'], BITCOINS_RELEASED);
		redirect(FORUM_ROOT.'escrows.php');
		?>
		<div class="main-head">
			<h2 class="hn"><span></span></h2>
		</div>
		<table>
		<tr>
		<td>
		<?php
		echo "<h1>".$lang_escrows['Thank you for bitcoins release']."</h1>";
		?>
		</td>
		<td>
		<FORM METHOD="LINK" ACTION="<?php echo FORUM_ROOT.'escrows.php'; ?>">
			<INPUT TYPE="submit" VALUE="<?php echo $lang_escrows['Go back'] ?>"></FORM>
		</td>
		</table>
		<?php
		
	}
	else
	{
		?>
		<div class="main-head">
			<h2 class="hn"><span></span></h2>
		</div>
		<table>
		<tr>
		<td>
		<?php
		echo "<h1>".$lang_common['No permission']."</h1>";
		?>
		</td>
		<td>
		<FORM METHOD="LINK" ACTION="<?php echo FORUM_ROOT.'escrows.php'; ?>">
			<INPUT TYPE="submit" VALUE="<?php echo $lang_escrows['Go back'] ?>"></FORM>
		</td>
		</table>
		<?php
	}
}

//zlecono wyplate  i potwierdzono
else if (isset($_GET['action']) && isset($_GET['id']) && isset($_GET['answer']) && 
	$_GET['action']=='payout' && $_GET['answer'] == 'yes' && is_numeric($_GET['id']) && 
	isset($_SESSION['escrowinfo']) && $forum_user['id']==$_SESSION['escrowinfo']['sellerid'] &&
	$_SESSION['escrowinfo']['status']==BITCOINS_RELEASED)
{
		$now = time();
		escrow_note_new_payout($now, $forum_user['id'], $_SESSION['finalpayout'] , $_SESSION['receiveraddress'], $_GET['id']);
		change_escrow_status($_SESSION['escrowinfo']['index'],ESCROW_FINISHED);
		$_SESSION['escrowinfo']['status']=ESCROW_FINISHED;
		redirect(FORUM_ROOT.'escrows.php');
		?>
		<div class="main-head">
		<h2 class="hn"><span><?php echo $lang_escrows['Payment summary']; ?></span></h2>
		</div>
		<table border="1">
		<tr>
			<td>
				<h2><?php echo $lang_escrows['Seller payment thanks'] ;?> </h2>
			</td>
			<td><span class="cancel">
				<FORM METHOD="LINK" ACTION="<?php echo FORUM_ROOT.'escrows.php'; ?>"><INPUT TYPE="submit" VALUE="<?php echo $lang_escrows['Go back'];?>"></FORM>
				</span>
			</td>
		</tr>
		</table>
		<?php
} 

// zlecono wyplate

else if ( isset($_GET['action']) and isset($_GET['id']) and $_GET['action']=='payout' and
	is_numeric($_GET['id']) and isset($_SESSION['escrowinfo']) and 
	$forum_user['id']==$_SESSION['escrowinfo']['sellerid'] and $_SESSION['escrowinfo']['status']==BITCOINS_RELEASED)
{
	$_SESSION['finalpayout'] = escrow_get_payout_amount($_SESSION['escrowinfo']);
	$_SESSION['receiveraddress']= escrow_get_seller_address($_SESSION['escrowinfo']);
	
	?>
	<div class="main-head">
		<h2 class="hn"><span><?php echo $lang_escrows['Please check your data'] ;?></span></h2>
	</div>
	<table>
	<tr>
		<td>Amount</td>
		<td>Address</td>
	</tr>
	<tr>
		<td> <?php echo "<h1>".$_SESSION['finalpayout']."</h1>"; ?> </td>
		<td> <?php echo "<h1>".$_SESSION['receiveraddress']."</h1>";?> </td>
	</tr>
	<tr>
		<td>
		<FORM METHOD="POST" ACTION="<?php echo FORUM_ROOT.'escrows.php?id='.$_GET['id'].'&action=payout&answer=yes'; ?>">
			<INPUT TYPE="submit" VALUE="<?php echo $lang_escrows['Accept']; ?>"></FORM>
		</td>
		<td>
		<FORM METHOD="LINK" ACTION="<?php echo FORUM_ROOT.'escrows.php'; ?>">
			<INPUT TYPE="submit" VALUE="<?php echo $lang_escrows['Go back']; ?>"></FORM>
		</td>
	</tr>
	</table>
	<?php	
}
 // kupujacy zaakceptowal
else if (isset($_GET['action']) and isset($_GET['id']) and $_GET['action']=='accept')
{
	$id = $_GET['id'];
	if (is_numeric($id))
	{
		$query = array(
			'SELECT'	=>	'e.*',
			'FROM'		=>	'escrows AS e',
			'WHERE'		=>	'e.index='.$id 
			);
		$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
		$_SESSION['escrowinfo'] = mysqli_fetch_assoc($result);
		if($forum_user['id']== $_SESSION['escrowinfo']['buyerid'])
		{
			//uwolnij btc
		$query = array(
			'UPDATE'	=>	'escrows',
			'SET'		=> 'status = '.BITCOINS_RELEASED,
			'WHERE'		=> 'id = '.$id,
			);
		$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
		?>
		<div class="main-head">
		<h2 class="hn"><span><?php echo $lang_escrows['Escrow summary']; ?></span></h2>
		</div>
		<table border="1">
		<tr><td><h2>Thank you for accepting the transaction.</h2></td></tr>
		<tr><td><span class="cancel"><FORM METHOD="LINK" ACTION="<?php echo FORUM_ROOT.'escrows.php'; ?>"><INPUT TYPE="submit" VALUE="<?php echo $lang_escrows['Go back'];?>"></FORM></span></td></tr>
		</table>
		<?php
		}
	}
}
else if (isset($_GET['action']) && isset($_GET['user_id']) && $_GET['action']=='start_new_escrow' && is_numeric($_GET['user_id']))
{
// Send form e-mail?
if (isset($_GET['user_id']))
{
	$recipient_id = intval($_GET['user_id']);

	if ($recipient_id < 2 || $recipient_id==$forum_user['id'])
		message($lang_common['Bad request']);

	// User pressed the cancel button
	if (isset($_POST['cancel']))
		redirect(forum_htmlencode($_POST['redirect_url']), $lang_common['Cancel redirect']);

	$query = array(
		'SELECT'	=> 'u.username, u.email, u.email_setting, u.pubkey',
		'FROM'		=> 'users AS u',
		'WHERE'		=> 'u.id='.$recipient_id
	);

	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	$recipient_info = $forum_db->fetch_assoc($result);

	if (!$recipient_info)
	{
		message($lang_common['Bad request']);
	}

	if ($recipient_info['email_setting'] == 2 && !$forum_user['is_admmod'])
		message($lang_misc['Form e-mail disabled']);

	if ($recipient_info['email'] == '')
		message($lang_common['Bad request']);

	if (isset($_POST['form_sent']))
	{
		// Clean up message and subject from POST
		$subject = forum_trim($_POST['req_subject']);
		$message = forum_trim($_POST['req_message']);
		$amount	 = forum_trim($_POST['req_amount']);
		$message = sprintf($lang_escrows['Escrow message'], $recipient_info['username'], $forum_user['username'] ,$amount).'[i]'.$message.'[/i]';

		if (!is_numeric($amount) || $amount < $forum_config['o_minimum_escrow_value'])
			$errors[] = $lang_escrows['Wrong amount'];
		if ($subject == '')
			$errors[] = $lang_misc['No e-mail subject'];
		if ($message == '')
			$errors[] = $lang_misc['No e-mail message'];
		else if (strlen($message) > FORUM_MAX_POSTSIZE_BYTES)
			$errors[] = sprintf($lang_misc['Too long e-mail message'], forum_number_format(strlen($message)), forum_number_format(FORUM_MAX_POSTSIZE_BYTES));
		if ($forum_user['last_email_sent'] != '' && (time() - $forum_user['last_email_sent']) < $forum_user['g_email_flood'] && (time() - $forum_user['last_email_sent']) >= 0)
			$errors[] = sprintf($lang_misc['Email flood'], $forum_user['g_email_flood']);

		// Did everything go according to plan?
		if (empty($errors))
		{
			startescrow_send_message($message, $subject, $recipient_info['username'], $amount);
			$forum_flash->add_info($lang_misc['E-mail sent redirect']);
			redirect(forum_htmlencode($_POST['redirect_url']), $lang_misc['E-mail sent redirect']);
		}
	}

	// Setup form
	$forum_page['group_count'] = $forum_page['item_count'] = $forum_page['fld_count'] = 0;
	$forum_page['form_action'] = '';// forum_link($forum_url['email'], $recipient_id);

	$forum_page['hidden_fields'] = array(
		'form_sent'		=> '<input type="hidden" name="form_sent" value="1" />',
		'redirect_url'	=> '<input type="hidden" name="redirect_url" value="'.forum_htmlencode($forum_user['prev_url']).'" />',
		'csrf_token'	=> '<input type="hidden" name="csrf_token" value="'.generate_form_token($forum_page['form_action']).'" />'
	);

	// Setup main heading
	$forum_page['main_head'] = sprintf($lang_escrows['Start escrow with'], forum_htmlencode($recipient_info['username']));

	// Setup breadcrumbs
	$forum_page['crumbs'] = array(
		array($forum_config['o_board_title'], forum_link($forum_url['index'])),
		sprintf($lang_escrows['Start escrow with'], forum_htmlencode($recipient_info['username']))
	);
	//define('FORUM_PAGE', 'formemail');
	require FORUM_ROOT.'header.php';

	// START SUBST - <!-- forum_main -->
	ob_start();

	($hook = get_hook('mi_email_output_start')) ? eval($hook) : null;
}
?>
	<div class="main-head">
		<h2 class="hn"><span><?php echo $forum_page['main_head'] ?></span></h2>
	</div>
	<div class="main-content main-frm">
		<!--
		<div class="ct-box warn-box">
			<p class="important"><?php echo $lang_misc['E-mail disclosure note'] ?></p>
		</div> -->
<?php

	// If there were any errors, show them
	if (!empty($errors))
	{
		$forum_page['errors'] = array();
		foreach ($errors as $cur_error)
			$forum_page['errors'][] = '<li class="warn"><span>'.$cur_error.'</span></li>';

		($hook = get_hook('mi_pre_email_errors')) ? eval($hook) : null;

?>
		<div class="ct-box error-box">
			<h2 class="warn hn"><?php echo $lang_misc['Form e-mail errors'] ?></h2>
			<ul class="error-list">
				<?php echo implode("\n\t\t\t\t", $forum_page['errors'])."\n" ?>
			</ul>
		</div>
<?php

	}

?>
		<div id="req-msg" class="req-warn ct-box error-box">
			<p class="important"><?php echo $lang_common['Required warn'] ?></p>
		</div>
		<form id="afocus" class="frm-form" method="post" accept-charset="utf-8" action="<?php echo $forum_page['form_action'] ?>">
			<div class="hidden">
				<?php echo implode("\n\t\t\t\t", $forum_page['hidden_fields'])."\n" ?>
			</div>
<?php ($hook = get_hook('mi_email_pre_fieldset')) ? eval($hook) : null; ?>
			<fieldset class="frm-group group<?php echo ++$forum_page['group_count'] ?>">
				<legend class="group-legend"><strong><?php echo $lang_escrows['Start escrow'] ?></strong></legend>

<?php ($hook = get_hook('mi_recipient_public_key')) ? eval($hook) : null; ?>
				<div class="txt-set set<?php echo ++$forum_page['item_count'] ?>">
					<div class="txt-box textarea required">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>"><span><?php echo $lang_misc['Recipient public key'] ?></span></label>
						<div class="txt-input"><span class="fld-input"><textarea readonly id="fld<?php echo $forum_page['fld_count'] ?>" name="recipient_pubkey" rows="5" cols="95" required><?php echo(isset($recipient_info['pubkey']) ? forum_htmlencode($recipient_info['pubkey']) : 'No public key found') ?></textarea></span></div>
					</div>
				</div>

<?php ($hook = get_hook('mi_email_pre_subject')) ? eval($hook) : null; ?>
				<div class="sf-set set<?php echo ++$forum_page['item_count'] ?>">
					<div class="sf-box text required longtext">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>"><span><?php echo $lang_misc['E-mail subject'] ?></span></label><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="req_subject" value="<?php echo(isset($_POST['req_subject']) ? forum_htmlencode($_POST['req_subject']) : $_SESSION['subject']) ?>" size="75" maxlength="70" required /></span>
					</div>
				</div>

<?php ($hook = get_hook('pun_pm_fn_send_form_pre_amount_input')) ? eval($hook) : null; ?>
				<div class="txt-set set<?php echo ++$forum_page['item_count'] ?>">
					<div class="txt-box textarea required">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>"><span><?php echo $lang_misc['Amount'] ?></span> <small><?php echo sprintf($lang_misc['Amount notice'], $forum_config['o_minimum_escrow_value']); ?></small></label><br />
						<div class="txt-input"><span class="fld-input"><input name='req_amount' type="number" required value='<?php echo (isset($amount) ? $amount : forum_htmlencode($_SESSION['price']))?>'></input></span></div>
					</div>
				</div>

<?php ($hook = get_hook('mi_email_pre_message_contents')) ? eval($hook) : null; ?>
				<div class="txt-set set<?php echo ++$forum_page['item_count'] ?>">
					<div class="txt-box textarea required">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>"><span><?php echo $lang_misc['E-mail message'] ?></span></label>
						<div class="txt-input"><span class="fld-input"><textarea id="fld<?php echo $forum_page['fld_count'] ?>" name="req_message" rows="10" cols="95" required><?php echo(isset($_POST['req_message']) ? forum_htmlencode($_POST['req_message']) : '') ?></textarea></span></div>
					</div>
				</div>
<?php ($hook = get_hook('mi_email_pre_fieldset_end')) ? eval($hook) : null; ?>
			</fieldset>
<?php ($hook = get_hook('mi_email_fieldset_end')) ? eval($hook) : null; ?>
			<div class="frm-buttons">
				<span class="submit primary"><input type="submit" name="submit" value="<?php echo $lang_common['Submit'] ?>" /></span>
				<span class="cancel"><input type="submit" name="cancel" value="<?php echo $lang_common['Cancel'] ?>" formnovalidate /></span>
			</div>
		</form>
	</div>
<?php


}

if (1)  //wyswietla wszystkie transakcje usera
	{
	//transakcje z ktorych mozna wyplacic kase
	$query = array(
		'SELECT'	=> 'e.*',
		'FROM'		=> 'escrows AS e',
		'WHERE'		=> 'e.sellerid='.intval($forum_user['id']).' AND e.status='.BITCOINS_RELEASED,
		'ORDER BY'	=>	'e.time DESC'
		);
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	?>
	<div class="main-head">
	<h2 class="hn"><span><?php echo $lang_escrows['Bitcoin payouts avalable']; ?></span></h2>
	</div>
	<table border="1">
		<tr class="<?php echo ' row1'; ?>">
			<td width="5%">Date</td>
			<td>Subject</td>
			<td>Buyer</td>
			<td>Seller</td>
			<td width="4%">Declared</td>
			<td>Transaction Status</td>
		</tr>
	<?php
	while ($row = $result->fetch_assoc())
	{
		$_SESSION['seller'] =escrow_get_username($row['sellerid']);
		$_SESSION['buyer']	=escrow_get_username($row['buyerid']);
		echo "<tr><td>".date('y-m-d',$row['time'])."</td><td><a href=".FORUM_ROOT."escrows.php?action=detail&id=".$row['index'].">".$row['subject'].
		"</a></td><td><a href=".FORUM_ROOT."profile.php?id=".$row['buyerid'].">".
		$_SESSION['buyer']."</a></td><td><a href=".
		FORUM_ROOT."profile.php?id=".$row['sellerid'].">".
		$_SESSION['seller']."</a></td><td>".
		$row['amount']."</td><td><a href=".FORUM_ROOT."escrows.php?action=detail&id=".$row['index'].">".
		get_escrow_status($row['status'])."</a></td></tr>";
	}

	?>

	</table>

	<?php
	
	
	//wszystkie transakcje usera	
	$query = array(
		'SELECT'	=> 'e.*',
		'FROM'		=> 'escrows AS e',
		'WHERE'		=> 'e.buyerid='.intval($forum_user['id']).' OR e.sellerid='.intval($forum_user['id']).'',
		'ORDER BY'	=>	'e.time DESC'
		);
	($hook = get_hook('ul_qr_get_users')) ? eval($hook) : null;
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	?>
	<div class="main-head">
	<h2 class="hn"><span><?php echo $lang_escrows['Escrow summary']; ?></span></h2>
	</div>
	<table border="1">
		<tr class="<?php echo ($forum_page['item_count'] % 2 != 0) ? 'odd' : 'even' ?><?php if ($forum_page['item_count'] == 1) echo ' row1'; ?>">
			<td width="5%">Date</td>
			<td>Subject</td>
			<td>Buyer</td>
			<td>Seller</td>
			<td width="4%">Amount</td>
			<td>Transaction Status</td>
		</tr>
	<?php
	while ($row = $result->fetch_assoc())
	{
		$_SESSION['seller'] =escrow_get_username($row['sellerid']);
		$_SESSION['buyer']	=escrow_get_username($row['buyerid']);
		echo "<tr><td>".date('y-m-d',$row['time'])."</td><td><a href=".FORUM_ROOT."escrows.php?action=detail&id=".$row['index'].">".$row['subject'].
		"</a></td><td><a href=".FORUM_ROOT."profile.php?id=".$row['buyerid'].">".
		$_SESSION['buyer']."</a></td><td><a href=".
		FORUM_ROOT."profile.php?id=".$row['sellerid'].">".
		$_SESSION['seller']."</a></td><td>".
		$row['amount']."</td><td><a href=".FORUM_ROOT."escrows.php?action=detail&id=".$row['index'].">".
		get_escrow_status($row['status'])."</a></td></tr>";
	}

	?>

	</table>

	<?php
}

//($hook = get_hook('ul_end')) ? eval($hook) : null;

$tpl_temp = forum_trim(ob_get_contents());
$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
ob_end_clean();
// END SUBST - <!-- forum_main -->

require FORUM_ROOT.'footer.php';
?>

<?php

?>
