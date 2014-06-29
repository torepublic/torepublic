<?php

if (!defined('FORUM_ROOT'))
	define('FORUM_ROOT', './');
require FORUM_ROOT.'include/common.php';


$appr = $forum_user['g_moderator'] || ($forum_user['g_id'] == FORUM_ADMIN);
$limit = 23;


$query = array(
	'SELECT'	=> 'users.id as i, username, SUM(IF(mark=1,1,0)) as o, SUM(IF(mark=-1,1,0)) as p, SUM(mark) as q',
	'FROM'		=> 'pun_karma LEFT JOIN posts ON posts.id=pun_karma.post_id LEFT JOIN ' .
	'users ON users.id=posts.poster_id',
	'GROUP BY'	=> 'users.id',
	'ORDER BY'	=> 'q DESC',
	'LIMIT'		=> $limit.', 1'
);

$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
$cur = $forum_db->fetch_assoc($result);
$karma = $cur['q'];

//Transformuje Members do Active Members
$query = array(
	'UPDATE' 	=>  'users',
	'SET'		=>	'group_id=8',
	'WHERE'		=>	'group_id=3 AND karma>='.$karma
);
$forum_db->query_build($query) or error(__FILE__, __LINE__);	

// transformujemy Active Members do Members
$query = array(
	'UPDATE' 	=>  'users',
	'SET'		=>	'group_id=3',
	'WHERE'		=>	'group_id=8 AND karma<'.$karma
);
$forum_db->query_build($query) or error(__FILE__, __LINE__);	

?>

</table>
</div>
<div style="float: center;">
<table border='1' align='center'>
<tr align='center'><td colspan='4'>Progi punktowe</td></tr>
<tr align='center'><td>Nazwa     </td><td>Uprawnienia</td><td>Prog punktowy</td></tr>
<?php
{
	echo "<tr align='center'><td>";
        echo "Member" . "</td><td>";
        echo 'Uprawnia do czytania chronionych dzialow' . "</td><td>";
        echo $forum_config['o_nya_new_member_treshold'] . "</td></tr>";
	echo "<tr align='center'><td>";
        echo "Active Member" . "</td><td>";
        echo 'Uprawnia do pisania tematow ukrytych dla Members (generowany dynamicznie)' . "</td><td>";
        echo $karma . "</td></tr>";
	echo "<tr align='center'><td>";      
        echo "Tag Hide" . "</td><td>";
        echo 'Uprawnia do czytania tekstow znajdujacych sie w tagu Hide' . "</td><td>";
        echo $forum_config['o_nya_hide_treshold']. "</td></tr>";
}
?>
</table>
</div>
