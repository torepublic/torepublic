<?php

if (!defined('FORUM_ROOT'))
	define('FORUM_ROOT', './');
require FORUM_ROOT.'include/common.php';

($hook = get_hook('ul_start')) ? eval($hook) : null;

if ($forum_user['g_read_board'] == '0')
	message($lang_common['No view']);
else if ($forum_user['g_view_users'] == '0')
	message($lang_common['No permission']);

define('FORUM_PAGE', 'invites');
require FORUM_ROOT.'header.php';

// START SUBST - <!-- forum_main -->
ob_start();


$appr = $forum_user['g_moderator'] || ($forum_user['g_id'] == FORUM_ADMIN);
$limit = 100;
/*
if (isset($_SESSION['invited_by_user']))
{
$query = array(
	'SELECT'	=> 'username, invitedBy, registered',
	'FROM'		=> 'users',
	'ORDER BY'	=> 'registered DESC',
	'WHERE'		=> 'invitedBy=\''.$_SESSION['invited_by_user'].'\''
);
}
*/

//zrobic listowanie wszystkich nowych userow z ograniczeniem $limit
$query = array(
	'SELECT'	=> 'username, invitedBy, registered, id',
	'FROM'		=> 'users',
	'ORDER BY'	=> 'registered DESC',
	'LIMIT'		=> '0, ' . $limit
);

$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);


?>

<div style="float:left;width:100%">

	<div style="float:left;width:100%;height:25pt;"> <?php echo $limit; ?> ostatnio zarejestrowanych</div>
	<div style="float:left;width:100%;height:25pt;">
		<div style="float:left;width:33%">Zarejestrowany: </div>
		<div style="float:left;width:33%">Zapraszajacy:</div>
		<div style="float:left;width:33%">Data</div>
	</div>
<?php

while ($cur = $forum_db->fetch_assoc($result))
{
	//if (!$cur['invitedBy'])
	//	$inviter ='None';
	//else
	$inviter = $cur['invitedBy'];
	echo '<div style="float:left;width:100%;"><div style="float:left;width:33%;"><a href="'.FORUM_ROOT.'profile.php?id='.$cur['id'].'">'.$cur['username'].'</a></div><div style="float:left;width:33%;height:15pt;">'.$inviter.'</div><div style="float:left;width:33%">'.date("d-m-Y", $cur['registered']).'</div></div>';
}

?>


</div>

<?php
//($hook = get_hook('ul_end')) ? eval($hook) : null;

$tpl_temp = forum_trim(ob_get_contents());
$tpl_main = str_replace('<!-- forum_main -->', $tpl_temp, $tpl_main);
ob_end_clean();
// END SUBST - <!-- forum_main -->

require FORUM_ROOT.'footer.php';
 
?>

