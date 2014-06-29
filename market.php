<?php
/**
 * Allows users to search the forum based on various criteria.
 *
 * @copyright (C) 2008-2012 PunBB, partially based on code (C) 2008-2009 FluxBB.org
 * @license http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 * @package PunBB
 */

if (!defined('FORUM_ROOT'))
	define('FORUM_ROOT', './');
require FORUM_ROOT.'include/common.php';

($hook = get_hook('se_start')) ? eval($hook) : null;

// Load the search.php language file
require FORUM_ROOT.'lang/'.$forum_user['language'].'/search.php';
require FORUM_ROOT.'lang/'.$forum_user['language'].'/escrows.php';
require FORUM_ROOT.'lang/'.$forum_user['language'].'/post.php';

//print_r($_SESSION);
// Setup form
$forum_page['group_count'] = $forum_page['item_count'] = $forum_page['fld_count'] = 0;
$forum_page['form_action'] = ($tid ? forum_link($forum_url['new_reply'], $tid) : forum_link($forum_url['new_topic'], $fid));
$forum_page['form_attributes'] = array();

$forum_page['hidden_fields'] = array(
	'form_sent'		=> '<input type="hidden" name="form_sent" value="1" />',
	'form_user'		=> '<input type="hidden" name="form_user" value="'.((!$forum_user['is_guest']) ? forum_htmlencode($forum_user['username']) : 'Guest').'" />',
	'csrf_token'	=> '<input type="hidden" name="csrf_token" value="'.generate_form_token($forum_page['form_action']).'" />'
);

// Setup help
$forum_page['text_options'] = array();
if ($forum_config['p_message_bbcode'] == '1')
	$forum_page['text_options']['bbcode'] = '<span'.(empty($forum_page['text_options']) ? ' class="first-item"' : '').'><a class="exthelp" href="'.forum_link($forum_url['help'], 'bbcode').'" title="'.sprintf($lang_common['Help page'], $lang_common['BBCode']).'">'.$lang_common['BBCode'].'</a></span>';
if ($forum_config['p_message_img_tag'] == '1')
	$forum_page['text_options']['img'] = '<span'.(empty($forum_page['text_options']) ? ' class="first-item"' : '').'><a class="exthelp" href="'.forum_link($forum_url['help'], 'img').'" title="'.sprintf($lang_common['Help page'], $lang_common['Images']).'">'.$lang_common['Images'].'</a></span>';
if ($forum_config['o_smilies'] == '1')
	$forum_page['text_options']['smilies'] = '<span'.(empty($forum_page['text_options']) ? ' class="first-item"' : '').'><a class="exthelp" href="'.forum_link($forum_url['help'], 'smilies').'" title="'.sprintf($lang_common['Help page'], $lang_common['Smilies']).'">'.$lang_common['Smilies'].'</a></span>';

// Setup breadcrumbs
$forum_page['crumbs'][] = array($forum_config['o_board_title'], forum_link($forum_url['index']));
$forum_page['crumbs'][] = array($lang_escrows['Market'], FORUM_ROOT.'market.php');//array($cur_posting['forum_name'], forum_link($forum_url['forum'], array($cur_posting['id'], sef_friendly($cur_posting['forum_name']))));
$forum_page['crumbs'][] = isset($_GET['action']) && $_GET['action']!='viewoffer' ? $lang_escrows['Sell'] : $lang_escrows['Buy'];

($hook = get_hook('po_pre_header_load')) ? eval($hook) : null;


($hook = get_hook('ul_qr_get_details')) ? eval($hook) : null;
if ($forum_user['g_read_board'] == '0')
	message($lang_common['No view']);
//else if ($forum_user['g_search'] == '0')
//	message($lang_search['No search permission']);

define('FORUM_PAGE', 'post');
require FORUM_ROOT.'header.php';
// START SUBST - <!-- forum_main -->
ob_start();


// USUWANIE OFERT
market_move_to_trash_old_offers();
	
if (isset($_GET['action']) && $_GET['action']=='sell' && !isset($_GET['fid']) && !$forum_user['is_guest'])
{
	?>
		<div class="main-head">
			<h2 class="hn"><span><?php echo $lang_escrows['Choose a category']; ?></span></h2>
		</div>
		<div style="border:1;width:100%;height:100pt;float:left;">		
	<?php
		echo market_get_category_sell_page($forum_config['o_trade_category_id']);
		$SESSION['preview_loaded']=0;
	?>
		</div>
	<?php 	
}
else if (isset($_GET['action']) && $_GET['action']=='sell' && isset($_GET['fid']) && is_numeric($_GET['fid']) && !$forum_user['is_guest'])	
{
	$_SESSION['fid'] = $_GET['fid'];
	$query = array(
		'SELECT'	=> 'f.id, f.forum_name, f.moderators, f.redirect_url, f.cat_id',
		'FROM'		=> 'forums AS f',
		'WHERE'		=> 'f.id='.intval($_GET['fid'])//.' AND f.cat_id='.intval($forum_config['o_trade_category_id'])
		);
			
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	$cur_posting = $forum_db->fetch_assoc($result);
	$_SESSION['cur_posting'] = $cur_posting;
	if (!$cur_posting)
		message($lang_common['Bad request']);

	// Setup form
	$forum_page['group_count'] = $forum_page['item_count'] = $forum_page['fld_count'] = 0;
	$forum_page['form_action'] = ($tid ? forum_link($forum_url['new_reply'], $tid) : forum_link($forum_url['new_topic'], $fid));
	$forum_page['form_attributes'] = array();
	$forum_page['hidden_fields'] = array(
		'form_sent'		=> '<input type="hidden" name="form_sent" value="1" />',
		'form_user'		=> '<input type="hidden" name="form_user" value="'.((!$forum_user['is_guest']) ? forum_htmlencode($forum_user['username']) : 'Guest').'" />',
		'csrf_token'	=> '<input type="hidden" name="csrf_token" value="'.generate_form_token($forum_page['form_action']).'" />'
		);
	?>
	<div class="main-subhead">
		<h2 class="hn"><span><?php echo ($tid) ? $lang_post['Compose your reply'] : $lang_post['Compose your topic'] ?></span></h2>
	</div>
	<div id="post-form" class="main-content main-frm">
	<?php
	// If there were any errors, show them
	if (!empty($errors))
	{
		$forum_page['errors'] = array();
		foreach ($errors as $cur_error)
			$forum_page['errors'][] = '<li class="warn"><span>'.$cur_error.'</span></li>';
	?>
		<div class="ct-box error-box">
			<h2 class="warn hn"><?php echo $lang_post['Post errors'] ?></h2>
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
	
	<form id="afocus" class="frm-form frm-ctrl-submit" method="post" accept-charset="utf-8" action="<?php echo FORUM_ROOT.'market.php?action=preview' ?>"<?php if (!empty($forum_page['form_attributes'])) echo ' '.implode(' ', $forum_page['form_attributes']) ?>>
		<div class="hidden">
			<?php echo implode("\n\t\t\t\t", $forum_page['hidden_fields'])."\n" ?>
		</div>
		
	<?php
	if ($forum_user['is_guest'])
		{
			$forum_page['email_form_name'] = ($forum_config['p_force_guest_email'] == '1') ? 'req_email' : 'email';
		?>
			<fieldset class="frm-group group<?php echo ++$forum_page['group_count'] ?>">
				<legend class="group-legend"><strong><?php echo $lang_post['Guest post legend'] ?></strong></legend>
				<div class="sf-set set<?php echo ++$forum_page['item_count'] ?>">
					<div class="sf-box text required">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>"><span><?php echo $lang_post['Guest name'] ?></span></label><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="req_username" value="<?php if (isset($_POST['req_username'])) echo forum_htmlencode($username); ?>" size="35" maxlength="25" /></span>
					</div>
				</div>
				<div class="sf-set set<?php echo ++$forum_page['item_count'] ?>">
					<div class="sf-box text<?php if ($forum_config['p_force_guest_email'] == '1') echo ' required' ?>">
						<label for="fld<?php echo ++$forum_page['fld_count'] ?>"><span><?php echo $lang_post['Guest e-mail'] ?></span></label><br />
						<span class="fld-input"><input type="email" id="fld<?php echo $forum_page['fld_count'] ?>" name="<?php echo $forum_page['email_form_name'] ?>" value="<?php if (isset($_POST[$forum_page['email_form_name']])) echo forum_htmlencode($email); ?>" size="35" maxlength="80" <?php if ($forum_config['p_force_guest_email'] == '1') echo 'required' ?> /></span>
					</div>
				</div>		
			</fieldset>
		<?php
		// Reset counters
	
		$forum_page['group_count'] = $forum_page['item_count'] = 0;
	}
	?>
					<div class="sf-set set<?php echo ++$forum_page['item_count'] ?>">
				<div class="sf-box text required longtext">
					<label for="fld<?php echo ++$forum_page['fld_count'] ?>"><span><?php echo $lang_escrows['Offer subject'] ?></span></label><br />
					<span class="fld-input"><input id="fld<?php echo $forum_page['fld_count'] ?>" type="text" name="req_subject" value="<?php if (isset($_SESSION['req_subject'])) echo forum_htmlencode($_SESSION['req_subject']); ?>" size="70" maxlength="70" required /></span>
				</div>
			</div>

			<div class="txt-set set<?php echo ++$forum_page['item_count'] ?>">
				<div class="txt-box textarea required">
					<label for="fld<?php echo ++$forum_page['fld_count'] ?>"><span><?php echo $lang_escrows['Offer content'] ?></span></label>
					<div class="txt-input"><span class="fld-input"><textarea id="fld<?php echo $forum_page['fld_count'] ?>" name="req_message" rows="15" cols="95" required spellcheck="true"><?php echo isset($_SESSION['req_message']) ? forum_htmlencode($_SESSION['req_message']) : (isset($forum_page['quote']) ? forum_htmlencode($forum_page['quote']) : '') ?></textarea></span></div>
				</div>
			</div>
				
			<div class="txt-set set<?php echo ++$forum_page['item_count'] ?>">
				<div class="txt-box textarea required">
					<label for="fld<?php echo ++$forum_page['fld_count'] ?>"><span><?php echo $lang_escrows['Price'] ?></span></label><br />
					<div class="txt-input"><span class="fld-input"><input name='req_price' type="number" required value='<?php $_SESSION['req_price']?>'></input></span></div>
					<!--<label for="fld<?php echo ++$forum_page['fld_count'] ?>"> <small><?php echo "BTC"; ?></small></label>-->

					<input type="radio" name="currency" value="0" checked> BTC<br>
					<input type="radio" name="currency" value="1" > PLN<br>
					<input type="radio" name="currency" value="2" > USD<br>
				</div>
			</div>
				
			<div class="txt-set set<?php echo ++$forum_page['item_count'] ?>">
				<div class="txt-box textarea required">
					<label for="fld<?php echo ++$forum_page['fld_count'] ?>"><span><?php echo $lang_escrows['Duration'] ?></span></label><br />
					<div class="txt-input"><span class="fld-input"><input name='req_duration' type="number" required value='<?php echo $_SESSION['req_duration']?>'></input></span></div>
					<label for="fld<?php echo ++$forum_page['fld_count'] ?>"> <small><?php echo sprintf($lang_escrows['Additional time price'],$forum_config['o_market_auction_default_duration'],$forum_config['o_market_additional_time_price']) ?></small></label>
				</div>
			</div>
	<?php

	$forum_page['checkboxes'] = array();
	//$forum_page['checkboxes']['promote_on_main_page'] = '<div class="mf-item"><span class="fld-input"><input type="checkbox" id="fld'.(++$forum_page['fld_count']).'" name="promote_on_main_page" value="1"'.(isset($_POST['promote_on_main_page']) ? ' checked="checked"' : '').' /></span> <label for="fld'.$forum_page['fld_count'].'">'.sprintf($lang_escrows['Promote on main page'], $forum_config['o_market_main_page_promotion']).'</label></div>';
	$forum_page['checkboxes']['promote_stick_up'] = '<div class="mf-item"><span class="fld-input"><input type="checkbox" id="fld'.(++$forum_page['fld_count']).'" name="promote_stick_up" value="1"'.(isset($_POST['promote_sticku_up']) ? ' checked="checked"' : '').' /></span> <label for="fld'.$forum_page['fld_count'].'">'.sprintf($lang_escrows['Promote stick up'],$forum_config['o_market_stick_up_promotion'] ).'</label></div>';
	$forum_page['checkboxes']['add_picture'] = '<div class="mf-item"><span class="fld-input"><input type="checkbox" id="fld'.(++$forum_page['fld_count']).'" name="add_picture" value="1"'.(isset($_POST['add_picture']) ? ' checked="checked"' : '').' /></span> <label for="fld'.$forum_page['fld_count'].'">'.$lang_escrows['Add picture'].'</label></div>';
	if (!empty($forum_page['checkboxes']))
	{
	?>
		<fieldset class="mf-set set<?php echo ++$forum_page['item_count'] ?>">
			<div class="mf-box checkbox">
				<?php echo implode("\n\t\t\t\t\t", $forum_page['checkboxes'])."\n" ?>
			</div>
		</fieldset>
	<?php
	}
	?>
			<div class="txt-set set<?php echo ++$forum_page['item_count'] ?>">
				<div class="txt-box textarea">
					<label for="fld<?php echo ++$forum_page['fld_count'] ?>"><span><?php echo $lang_escrows['Picture url'] ?></span></label><br />
					<div class="txt-input"><span class="fld-input"><input name='req_picture_url' type="text" value='<?php echo $_SESSION['req_picture_url']?>'></input></span></div>
					<label for="fld<?php echo ++$forum_page['fld_count'] ?>"> <small><?php echo sprintf($lang_escrows['Miniature price'],$forum_config['o_market_miniature_price']) ?></small></label>
				</div>
			</div>
			
	<fieldset class="frm-group group<?php echo ++$forum_page['group_count'] ?>">
		<legend class="group-legend"><strong><?php echo $lang_common['Required information'] ?></strong></legend>
	</fieldset>
		<div class="frm-buttons">
			<span class="submit primary"><input type="submit" name="submit_button" value="<?php echo $lang_escrows['Next'] ?>" /></span>
		</div>
		</form>
	</div>
<?php	
}
else if (isset($_GET['action']) && $_GET['action']=='preview')
{
	$errors = array();
	if(!isset($_POST['req_subject']))
		$_POST['req_subject']=$_SESSION['req_subject'];
	if(!isset($_POST['req_message']))
		$_POST['req_message']=$_SESSION['req_message'];
	if(!isset($_POST['req_picture_url']))
		$_POST['req_picture_url']=$_SESSION['req_picture_url'];
	if(!isset($_POST['req_duration']))
		$_POST['req_duration']=$_SESSION['req_duration'];
	if(!isset($_POST['req_price']))
		$_POST['req_price']=$_SESSION['req_price'];
	if(!isset($_POST['promote_stick_up']))
		$_POST['promote_stick_up']=$_SESSION['promote_stick_up'];
	if(!isset($_POST['promote_on_main_page']))
		$_POST['promote_on_main_page']=$_SESSION['promote_on_main_page'];	
	if(!isset($_POST['add_picture']))
		$_POST['add_picture']=$_SESSION['add_picture'];	
	if(!isset($_POST['currency']))
		$_POST['currency']=$_SESSION['currency'];

	$_SESSION['req_subject']= 		forum_htmlencode($_POST['req_subject']);
	$_SESSION['req_message']= 		forum_htmlencode($_POST['req_message']);
	$_SESSION['req_picture_url']= 	forum_htmlencode($_POST['req_picture_url']);
	$_SESSION['add_picture']=		$_POST['add_picture'];
	$_SESSION['req_price']=		$_POST['req_price'];
	$_SESSION['currency']= 	$_POST['currency'];
	
	//validate data
	if(!is_numeric($_POST['req_duration']) or isset($_POST['req_duration']) and ($_POST['req_duration'])<1)
		$errors[] = 'Duration not valid';
	else
		$_SESSION['req_duration']=$_POST['req_duration'];
		
	if(!is_numeric($_POST['req_price']) or isset($_POST['req_price']) and ($_POST['req_price'])<0)
		$errors[] = 'Price not valid';
	else
		$_SESSION['req_price']=$_POST['req_price'];
		
	if(!filter_var($_POST['req_picture_url'], FILTER_VALIDATE_URL) and $_POST['add_picture']=='1')
		$errors[] = 'Not valid picture url';
	else
		$_SESSION['req_picture_url']=$_POST['req_picture_url'];
	$price =0;
			
	if ($forum_user['is_guest'])
	{
		$price = $price+$forum_config['o_guest_auction_price'];
		$username = '_'.$forum_db->escape(forum_trim($_POST['req_username']));
		//echo "USERNAME", $username;
		$email = strtolower(forum_trim(($forum_config['p_force_guest_email'] == '1') ? $_POST['req_email'] : $_POST['email']));

		// Load the profile.php language file
		require FORUM_ROOT.'lang/'.$forum_user['language'].'/profile.php';

		// It's a guest, so we have to validate the username
		$errors = array_merge($errors, validate_username($username));
					
		if (!defined('FORUM_EMAIL_FUNCTIONS_LOADED'))
			require FORUM_ROOT.'include/email.php';

		if (!is_valid_email($email))
			$errors[] = $lang_post['Invalid e-mail'];

		if (is_banned_email($email))
			$errors[] = $lang_profile['Banned e-mail'];
		
		$_SESSION['username'] = $username;
		$_SESSION['email']	=$email;
	}
	
	$_SESSION['promote_stick_up']=$_POST['promote_stick_up'];
	$_SESSION['promote_on_main_page']=$_POST['promote_on_main_page'];
	

	$extra_days = $_POST['req_duration'] -$forum_config['o_market_auction_default_duration'];
	
	if($forum_config['o_market_auction_default_duration']< $_POST['req_duration'])
		$price = $price + ($_POST['req_duration']-$forum_config['o_market_auction_default_duration'])*$forum_config['o_market_additional_time_price'];
	if($_POST['promote_on_main_page']=='1')
		$price = $price + $forum_config['o_market_main_page_promotion'];
	if($_POST['promote_stick_up']=='1')
		$price = $price + $forum_config['o_market_stick_up_promotion'];
	if($_POST['add_picture']=='1')
		$price = $price + $forum_config['o_market_miniature_price'];
	
		
	if(!empty($errors))
	{
		$forum_page['errors'] = array();
		foreach ($errors as $cur_error)
			$forum_page['errors'][] = '<li class="warn"><span>'.$cur_error.'</span></li>';
	?>
		<div class="ct-box error-box">
			<h2 class="warn hn"><span><?php echo $lang_profile['Register errors'] ?></span></h2>
			<ul class="error-list">
				<?php echo implode("\n\t\t\t\t", $forum_page['errors'])."\n" ?>
			</ul>
		</div>
	<?php
	}		
	$first_column_style ="width:35%;height:30pt;float:left;";
	$second_column_style="width:65%;height:30pt;float:left;";
	?>
	<div style="width:100%;float:left;">
		<div style="<?php echo $first_column_style;?>"><?php echo '<b>'.$lang_escrows['Offer subject'].'</b>'?></div><div style="<?php echo $second_column_style;?>"><?php echo htmlspecialchars($_POST['req_subject']) ?></div>
		<div ><?php echo '<b>'.$lang_escrows['Offer content'].'</b>'?></div><div>"><?php echo htmlspecialchars($_POST['req_message']) ?></div>
		<div style="<?php echo $first_column_style;?>"><?php echo '<b>'.$lang_escrows['Price'].'</b>'?></div><div style="<?php echo $second_column_style;?>"><?php echo  round(htmlspecialchars($_POST['req_price']),4); ?></div>
		<div style="<?php echo $first_column_style;?>"><?php echo '<b>'.$lang_escrows['Duration'].'</b>'?></div><div style="<?php echo $second_column_style;?>"><?php echo htmlspecialchars($_POST['req_duration']).' '.$lang_escrows['Days'].' '.(($extra_days>0)? '(+) '.($extra_days*$forum_config['o_market_additional_time_price']) :'(-) 0').'BTC'; ?></div>
		<div style="<?php echo $first_column_style;?>"><?php echo '<b>'.$lang_escrows['Add picture'].'</b>'?></div><div style="<?php echo $second_column_style;?>"><?php echo (($_POST['add_picture']=='1')? '(+) '.htmlspecialchars($forum_config['o_market_miniature_price']):'(-) '.'0').' BTC'; ?></div>
		<?php
		if($_POST['add_picture']=='1')
		{
			$height_style = ";height:300pt";
		?>	
			
			<div style="<?php echo $first_column_style.$height_style ;?>"><?php echo '<b>'.$lang_escrows['Add picture'].'</b>'?></div><div style="<?php echo $second_column_style.$height_style ;?>"><?php echo '<img src="'.$_POST['req_picture_url'].'" style="display:block;" width="50%" height="50%">'; ?></div><?php
		}
		if($forum_user['is_guest'])
		{?>
			<div style="<?php echo $first_column_style;?>"><?php echo '<b>'.$lang_escrows['Guest price'].'</b>'?></div><div style="<?php echo $second_column_style;?>"><?php echo '(+) '.$forum_config['o_guest_auction_price'].' BTC'; ?></div>
		<?php
		}
		?>
		
		<div style="<?php echo $first_column_style;?>"><?php echo '<b>'.$lang_escrows['Promote main page'].'</b>'?></div><div style="<?php echo $second_column_style;?>"><?php echo (($_POST['promote_on_main_page']=='1')? '(+) '.$forum_config['o_market_main_page_promotion']:'(-) '.'0').' BTC'; ?></div>
		<div style="<?php echo $first_column_style;?>"><?php echo '<b>'.$lang_escrows['Promote by stick up'].'</b>'?></div><div style="<?php echo $second_column_style;?>"><?php echo (($_POST['promote_stick_up']=='1')? '(+) '.$forum_config['o_market_stick_up_promotion']:'(-) '.'0').' BTC'; ?></div>
		<div style="<?php echo $first_column_style;?>"><?php echo '<b>'.$lang_escrows['Costs'].'</b>'?></div><div style="<?php echo $second_column_style;?>"><?php echo $price.' BTC';?></div>
		<div style="<?php echo $first_column_style;?>"><?php echo '<b>'.$lang_escrows['Click to revise'].'</b>';?></div><div style="<?php echo $second_column_style;?>"><?php echo '<a href="./market.php?action=sell&fid='.$_SESSION['fid'].'"><b>'.$lang_escrows['Revise'].'</b></a>';?></div>
	<?php 
	if (empty($errors))
	{

		$_SESSION['offer_verified']=1;
		if ($price>0)
		{
			if($_SESSION['preview_loaded']==0)
			{
				?>
				<div style="<?php echo $first_column_style;?>"><?php echo '<b>'.$lang_escrows['Please send'].' '.$price.' BTC '.$lang_escrows['to'].':</b>';?></div>
				<div style="<?php echo $second_column_style;?>"><?php echo '<b>'.$my_bitcoin_address.'</b>';?></div>
				<div style="width:100%;height:40pt;float:left;">
					<form method="post" action=<?php echo FORUM_ROOT.'market.php?action=preview'?>>
						<span class="submit primary"><input type="submit" name="list_offer" value="<?php echo $lang_escrows['Confirm payment'] ?>" /></span>
					</form>
				</div>
				<?php
				$_SESSION['balance'] = satoshi2bitcoin(market_get_single_address_balance($my_bitcoin_address));
				echo " SESSION BALANCE ".$_SESSION['balance'];
				
				$_SESSION['preview_loaded']=1;
			}
			else
			{
				$new_balance = satoshi2bitcoin(market_get_single_address_balance($my_bitcoin_address));
				if ($new_balance+pow(0.1, 5)<$_SESSION['balance']+$price)
				{
					//echo "BILANS ".$_SESSION['balance']." NOWY BILANS ".$new_balance." CENA ".$price;
					?>
					<div style="width:100%;float:left;"> <?php echo '<b>'.sprintf($lang_escrows['Please pay more'],($_SESSION['balance']+$price-$new_balance),$my_bitcoin_address).'</b>';?></div>
					<div style="width:100%;height:40pt;float:left;">
						<form method="post" action=<?php echo FORUM_ROOT.'market.php?action=preview'?>>
							<span class="submit primary"><input type="submit" name="list_offer" value="<?php echo $lang_escrows['Confirm payment'] ?>" /></span>
						</form>
					</div>
				<?php
				}
				else
				{
				?>
					<div style="<?php echo $first_column_style;?>"><?php echo '<b>'.$lang_escrows['Click to sell'].'</b>';?></div>
						<form method="post" action=<?php echo FORUM_ROOT.'market.php?action=list_offer'?>>
							<span class="submit primary"><input type="submit" name="list_offer" value="<?php echo $lang_escrows['List auction'] ?>" /></span>
						</form>
				<?php
				}
			}
		}
		else
		{
		?>
			<div style="<?php echo $first_column_style;?>"><?php echo '<b>'.$lang_escrows['Click to sell'].'</b>';?></div>
			<form method="post" action=<?php echo FORUM_ROOT.'market.php?action=list_offer'?>>
			<span class="submit primary"><input type="submit" name="list_offer" value="<?php echo $lang_escrows['List auction'] ?>" /></span>
			</form>
		<?php
		}
	}
	 ?>
		</div>
	</div>
	<?php
}
else if (isset($_GET['action']) && $_GET['action']=='list_offer')
{
	 if (isset($_SESSION['offer_verified']) and $_SESSION['offer_verified']==1)
		{
			// If the user is logged in we get the username and e-mail from $forum_user
			if (!$forum_user['is_guest'])
			{
				$username = $forum_user['username'];
				$email = $forum_user['email'];
			}
			else
			{ 
				$username =$_SESSION['username'];
				$email = $_SESSION['email'];
			}	
			// Otherwise it should be in $_POST


			$subject = $_SESSION['req_subject'];
			$message = $_SESSION['req_message'];
			$cur_posting = $_SESSION['cur_posting'];
			//$email = $forum_user['email'];
			
			//$username = $forum_user['username'];
			$hide_smilies = '0';
			
			$now = time();

			$post_info = array(
				'is_guest'		=> $forum_user['is_guest'],
				'poster'		=> $username,
				'poster_id'		=> $forum_user['id'],	// Always 1 for guest posts
				'poster_email'	=> ($forum_user['is_guest'] && $email != '') ? $email : null,	// Always null for non-guest posts
				//'poster_email'	=> $email,	// Always null for non-guest posts
				'subject'		=> $subject,
				'message'		=> $message,
				'hide_smilies'	=> $hide_smilies,
				'posted'		=> $now,
				'subscribe'		=> ($forum_config['o_subscriptions'] == '1' && (isset($_POST['subscribe']) && $_POST['subscribe'] == '1')),
				'forum_id'		=> $cur_posting['id'],
				'forum_name'	=> $cur_posting['forum_name'],
				'update_user'	=> true,
				'update_unread'	=> true,
				'visibility'	=> 0
				);
			add_topic($post_info, $new_tid, $new_pid);
			
			// NOTE AUCTION
			$duration = $_SESSION['req_duration'] * 60*60*24;
			$_SESSION['req_picture_url'] = forum_htmlencode($_SESSION['req_picture_url']);
			market_add_auction($new_tid, $_SESSION['req_price'], $_SESSION['req_picture_url'], $_SESSION['promote_on_main_page'], $duration, $_SESSION['currency']);
			
			// STICK UP
			if ($_SESSION['promote_stick_up']=='1')
			{
				$query = array(
						'UPDATE'	=> 'topics',
						'SET'		=> 'sticky=1',
						'WHERE'		=> 'id='.$new_tid.' AND forum_id='.$cur_posting['id']
					);
					$forum_db->query_build($query) or error(__FILE__, __LINE__);
			}	
			// MAIN PAGE PROMOTION
			if ($_SESSION['promote_on_main_page']=='1')
			{
				$auction_url=FORUM_ROOT.'viewtopic.php?id='.$new_tid;
				$comercial_message = '<a href='.$auction_url.'>'.$subject.'</a>';
				market_add_comercial($comercial_message, $duration);
				market_change_mainpage_comercial();
			}
			$_SESSION['balance'] = satoshi2bitcoin(market_get_single_address_balance($my_bitcoin_address));
			unset($_SESSION['offer_verified']);
			
			$redirect_url = FORUM_ROOT.'market.php?action=viewoffer&id='.$new_tid;
			redirect($redirect_url);
		}
}
else if (isset($_GET['action']) && $_GET['action']=='search')
{
	$all_trade_forums = get_category_fids($forum_config['o_trade_category_id']);
	$all_trade_forums[]=$forum_config['o_old_sell_forum'];
	
	$keywords = (isset($_GET['keywords']) && is_string($_GET['keywords'])) ? forum_trim($_GET['keywords']) : null;
	$author = (isset($_GET['author']) && is_string($_GET['author'])) ? forum_trim($_GET['author']) : null;
	$sort_dir = (isset($_GET['sort_dir'])) ? (($_GET['sort_dir'] == 'DESC') ? 'DESC' : 'ASC') : 'DESC';
	$show_as = (isset($_GET['show_as'])) ? $_GET['show_as'] : 'topics';
	$sort_by = (isset($_GET['sort_by'])) ? intval($_GET['sort_by']) : null;
	$search_in = (!isset($_GET['search_in']) || $_GET['search_in'] == 'all') ? 0 : (($_GET['search_in'] == 'message') ? 1 : -1);
	$forum = (isset($_GET['forum']) && is_array($_GET['forum'])) ? array_map('intval', $_GET['forum']) : $all_trade_forums;

	if (preg_match('#^[\*%]+$#', $keywords))
		$keywords = '';

	if (preg_match('#^[\*%]+$#', $author))
		$author = '';

	if (!$keywords && !$author)
		message($lang_search['No terms']);

	// Create a cache of the results and redirect the user to the results
	include 'include/search_functions.php';
	create_search_cache($keywords, $author, $search_in, $forum, $show_as, $sort_by, $sort_dir);

	
}
else if ($forum_user['is_admmod'] && isset($_GET['action']) && $_GET['action']=='delete_auction' && isset($_GET['id']) && is_numeric($_GET['id']))
{
	
	delete_auction($_GET['id']);
}
else if (!$forum_user['is_admmod'] && isset($_GET['action']) && $_GET['action']=='delete_auction' && isset($_GET['id']) && is_numeric($_GET['id']))
{
	$topic_info = market_get_topic_info($_GET['id']);
	if($forum_user['username']==$topic_info['poster'])
	{
		delete_auction($_GET['id']);
		$redirect_url = FORUM_ROOT.'market.php';
		redirect($redirect_url);		
	}
}
else if (isset($_GET['action']) && $_GET['action']=='viewoffer' && isset($_GET['id']) && is_numeric($_GET['id']))
{
	$id = $_GET['id'];
	if (!defined('FORUM_PARSER_LOADED'))
		require FORUM_ROOT.'include/parser.php';

	$forum_page['item_count'] = 0;
	
	$query = array(
		'SELECT'	=> 'p.id, p.message, p.posted, t.subject, a.image_url, a.price, a.duration, a.currency, u.reputation, u.group_id, u.id, u.karma, u.num_posts, u.username',//, g.id, g.g_title',
		'FROM'		=> 'posts AS p',
		'JOINS'		=>	array(
			array(
				'INNER JOIN'	=>	'auctions AS a',
				'ON'			=>	'p.topic_id=a.topic_id'
			),
			array(
				'INNER JOIN'	=>	'users AS u',
				'ON'			=>	'p.poster_id=u.id'
			),
			array(
				'INNER JOIN'	=>	'topics AS t',
				'ON'			=>	'p.topic_id=t.id'
			),

		),
		'WHERE'		=> 'p.topic_id='.$id,
		'ORDER BY'	=> 'p.id',
		'LIMIT'		=> '0,50'
	);

	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	$auction_info = $forum_db->fetch_assoc($result);
	
	if (strlen($auction_info['image_url'])==0)
		$auction_info['image_url']= FORUM_ROOT.'img/no_photo.jpg';
		
	if ($auction_info['currency']==1) //PLN
		$auction_info['price']= round($auction_info['price']/$forum_config['btc_price_pln'],5);
	else if ($auction_info['currency']==2) //USD
		$auction_info['price'] = round($auction_info['price']/$forum_config['btc_price_usd'],5);	
?>
	
<div id="container" >
	<div id="subject" style="background-color:#dde4eb;clear:both;text-align:center;">
	<b><?php echo $auction_info['subject'];
	if( $forum_user['is_admmod'])
	{
		echo '<a href="'.FORUM_ROOT.'market.php?action=delete_auction&id='.$id.'" >'.$lang_escrows['Delete auction'].'</a>';
	}
	?></b></div>
	<div id="gallery" style="background-color:#f4f9fd;width:25%;float:left;">
	<img src="<?php echo $auction_info['image_url']?>" style="width:98%;height:99%"></div>

	<div id="content" style="background-color:white;width:50%;float:left;border:10px solid white">
	<?php echo parse_message($auction_info['message'], $cur_post['hide_smilies']);?></div>

<div id="seller-info-and-action" style="background-color:white;width:20%;float:left;">
	<?php echo '<ul><i><a href="'.FORUM_ROOT.'profile.php?id='.$auction_info['id'].'">'.$auction_info['username'].'</a></i>'.' ('.$auction_info['reputation'].')</ul>';
	echo '<ul>'.$auction_info['g_title'].'</ul>';
	echo '<ul>Karma: '.$auction_info['karma'].'   Posts: '.$auction_info['num_posts'].'</ul>';
	echo '<ul><a href="'.FORUM_ROOT.'market.php?action=user_auctions&poster_name='.$auction_info['username'].'"><i>'.$lang_escrows['Other user auctions'].'</i></a></ul>';
	echo '<ul><a href="'.FORUM_ROOT.'misc.php?section=pun_pm&pmpage=compose&receiver_id='.$auction_info['id'].'">'.$lang_escrows['Send message'].'</a></ul>';
	echo '<ul>'.$lang_escrows['Price'].' : '.$auction_info['price'].' BTC</ul>';
	$seconds = $auction_info['duration']-(time()-$auction_info['posted']);
	echo '<ul>'.$lang_escrows['Finishes in'].' '.market_get_duration($seconds).'</ul>';
	//$form_link = FORUM_ROOT.'startescrow.php?email='.$auction_info['id'].'&price='.$auction_info['price'].'&subject='.$auction_info['subject'];
	//$form_link =forum_link($forum_url['buy_now'], $auction_info['id'], $auction_info['price'], $auction_info['subject']);
	$form_link = FORUM_ROOT.'escrows.php?action=start_new_escrow&user_id='.$auction_info['id'].'&price='.$auction_info['price'].'&subject='.$auction_info['subject'];
	$_SESSION['price']	=$auction_info['price'];	
	$_SESSION['subject']=$auction_info['subject'];
	
	if($forum_user['id']!=$auction_info['id'])
	{
	?>
<ul>
	
	<form method="post" action="<?php echo $form_link; ?>">
		<span class="submit primary"><input type="submit" name="submit_button" value="<?php echo $lang_escrows['Buy now']?>" /></span>
	</form>
</ul>

<?php }?>
</div>
<div id="comments header" style="background-color:#FFD700;clear:both;text-align:center;">
	<?php echo '<a href="'.FORUM_ROOT.'post.php?tid='.$id.'"><u>'.$lang_escrows['Write comment'].'</u></a>';?></div>
</div>
<?php
$i =0;
while ($row = $result->fetch_assoc())
	{

	$row_colorC0='edf4eb';$row_colorC1='F9F9F9';
	?>
<div style="width:100%;float:left;";>
	<div id="time" style="background-color:#F9F9F9;width:100%;text-align:center;"><?php echo format_time($row['posted']);?></div>
	<div id="comment.<?php echo $i; ?>" style="background-color:#FFA500;clear:both;text-align:center;">
		<div id="content" style="background-color:#<?php echo $row_colorC0;?>;width:30%;float:left;"><?php echo '<i><a href="'.FORUM_ROOT.'profile.php?id='.$auction_info['id'].'">'.$row['username'].'</a> (R'.$row['reputation'].',K'.$row['karma'].',P'.$row['num_posts'].')</i>';?></div>
		<div id="content" style="background-color:#<?php echo $row_colorC1;?>;width:70%;float:left;"><?php echo '<i>'.$row['message']?></div>
	</div>
</div>

	<?php
	$i++;
	}
}
else
{			
	$offers_amount_per_page = 25;
	$start_number=0;
	$link_base = 'market.php?';
	if( isset($_GET['category']) && is_numeric($_GET['category']))
		$link_base=$link_base.'category='.$_GET['category'];
		
	if( isset($_GET['p']) && is_numeric($_GET['p']))
		$start_number =$_GET['p']*$offers_amount_per_page;
	if( isset($_GET['p']) && is_numeric($_GET['p']) && $_GET['p']>0)
		{
		$link_ending=$link_base.'&p='.($_GET['p']+1); 
		$link_ending2=$link_base.'&p='.($_GET['p']-1);
		}
	else
		{
		$link_ending=$link_base.'&p=1'; 
		$link_ending2=$link_base.'&p=0';
		}
?>

		<div style="width:100%;float:left;">
			<form align="top" method="get" accept-charset="utf-8" action="<?php echo FORUM_ROOT.'market.php?action=search&show_as=topics&keywords='.$_POST['keywords'].$bonus ?>">

				<div class="hidden">
					<input type="hidden" name="action" value="search" />
				</div>
				<?php
				// Get the list of categories and forums
				$query = array(
					'SELECT'	=> 'f.id AS fid, f.forum_name, f.redirect_url, f.num_topics',
					'FROM'		=> 'forums AS f',
					'WHERE'		=> 'f.cat_id ='.intval($forum_config['o_trade_category_id']),
					'ORDER BY'	=> 'f.num_topics DESC'
					);

				$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

				$forums = array();
				while ($cur_forum = $forum_db->fetch_assoc($result))
				{
					$forums[] = $cur_forum;
				}

				if (!empty($forums))
				{
					$trade_forum_ids= array();
					$cur_category = 0;
					foreach ($forums as $cur_forum)
					{
						echo '<input type="checkbox" id="fld'.(++$forum_page['fld_count']).'" name="forum[]" value="'.$cur_forum['fid'].'" /> <a href="'.FORUM_ROOT.'market.php?category='.$cur_forum['fid'].'"><label >'.forum_htmlencode($cur_forum['forum_name']).'('.$cur_forum['num_topics'].')</a></label> | ';
						$trade_forum_ids[]=$cur_forum['fid'];
					}
					echo "\t\t\t\t\t\t\t".'</fieldset>'."\n";
				}
				?>
		</div>
		<div style="width:100%;height:45pt;float:left;">
			
				<input type="text" id="fld<?php echo $forum_page['fld_count'] ?>" name="keywords" size="30%" maxlength="100" <?php echo ($advanced_search) ? '' : 'required' ?> />
				<input type="submit" name="search" value="<?php echo $lang_search['Submit search'] ?>" />
				<a href="<?php echo FORUM_ROOT.$link_ending2;?>"><?php echo $lang_escrows['Previous Page'];?></a> | 
				<a href="<?php echo FORUM_ROOT.$link_ending;?>"><?php echo $lang_escrows['Next Page'];?></a> | 
				<a href="<?php echo FORUM_ROOT.$link_base;?>"><?php echo $lang_escrows['First Page'];?></a> |				
				<?php if (!$forum_user['is_guest'])
				{ ?>
				<a href="<?php echo FORUM_ROOT.'market.php?action=sell'; ?>"><?php echo '<u><b>'.$lang_escrows['Sell'].'</b></u>';?></a> |
				<a href="<?php echo FORUM_ROOT.'market.php?action=user_auctions&poster_name='.$forum_user['username']; ?>"><?php echo '<u><b>'.$lang_escrows['My auctions'].'</b></u>';?></a> |
				<a href="<?php echo FORUM_ROOT.'escrows.php'; ?>"><?php echo '<u><b>'.$lang_escrows['My transactions'].'</b></u>';?></a> 
				<?php }?>
			</form>		
			
		</div>
<div style="width:100%;float:left;">
	<?php
	if(isset($_GET['action']) && $_GET['action']='user_auctions' && isset($_GET['poster_name']))
	{
		echo market_get_newest_offers($forum_config['o_trade_category_id'],0,$offers_amount_per_page, $start_number, $_GET['poster_name'], $forum_user['username']);
	}
	else
	{
		if (isset($_GET['category']) and is_numeric($_GET['category']))
			echo market_get_newest_offers($forum_config['o_trade_category_id'], $_GET['category'], $offers_amount_per_page, $start_number);
		else  
			echo market_get_newest_offers($forum_config['o_trade_category_id'],0,$offers_amount_per_page, $start_number); // display offers from all tradeforums
	}
	?>
</div>

<?php
}

$tpl_temp = forum_trim(ob_get_contents());
$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
ob_end_clean();
//($hook = get_hook('ul_end')) ? eval($hook) : null;
require FORUM_ROOT.'footer.php';
?>

