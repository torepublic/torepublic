<?php

define('FORUM_HOOKS_LOADED', 1);

$forum_hooks = array (
  'po_pre_optional_fieldset' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($fid && $forum_user[\'g_pun_tags_allow\'])
			{
				// if pun_approval is installed, we make adding of tags impossible when topic is being created.
				// User can add tags to the topic after it is approved.
				$query= array(
					\'SELECT\'	=> \'disabled\',
					\'FROM\'		=> \'extensions\',
					\'WHERE\'		=> \'id=\\\'pun_approval\\\'\'
				);
				$result=$forum_db->query_build($query) or error(__FILE__, __LINE__);

				$row = $forum_db->fetch_assoc($result);
				if ($row)
					$appr_disabled = $row[\'disabled\'];
				else
					$appr_disabled = true;

				// Chek if pun_approval is installed and enabled
				if ($appr_disabled || $forum_user[\'g_id\'] == FORUM_ADMIN)
				{
					?>
					<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
						<div class="sf-box text">
							<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $lang_pun_tags[\'Topic tags\']; ?></span><small><?php echo $lang_pun_tags[\'Enter tags\']; ?></small></label><br />
								<span class="fld-input"><input id="fld<?php echo $forum_page[\'fld_count\'] ?>" type="text" name="pun_tags" value="<?php echo empty($_POST[\'pun_tags\']) ? \'\' : forum_htmlencode($_POST[\'pun_tags\']) ?>" size="70" maxlength="100"/></span>
						</div>
					</div>
					<?php
				}
				else
				{
					?>
					<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
						<div class="sf-box text">
							<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $lang_pun_tags[\'Topic tags\']; ?></span><div class="fld-input"><?php echo $lang_pun_tags[\'Tags warning\'] ?></div></label><br />
						</div>
					</div>
					<?php
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ed_pre_checkbox_display' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($can_edit_subject && $forum_user[\'g_pun_tags_allow\'])
			{
				$res_tags = array();
				if (isset($pun_tags[\'topics\'][$cur_post[\'tid\']]))
				{
					foreach ($pun_tags[\'topics\'][$cur_post[\'tid\']] as $tag_id)
						$res_tags[] = $pun_tags[\'index\'][$tag_id];
				}

				?>
				<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
					<div class="sf-box text">
						<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $lang_pun_tags[\'Topic tags\']; ?></span><small><?php echo $lang_pun_tags[\'Enter tags\']; ?></small></label><br />
							<span class="fld-input"><input id="fld<?php echo $forum_page[\'fld_count\'] ?>" type="text" name="pun_tags" value="<?php if (!empty($res_tags)) echo implode(\', \', $res_tags); else echo \'\';  ?>" size="70" maxlength="100"/></span>
					</div>
				</div>
				<?php
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'vt_row_pre_display' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ((isset($vote_results) || isset($vote_form)) && ($cur_post[\'id\'] == $cur_topic[\'first_post_id\'])) {
				$pun_poll_block = \'\';
				if (!empty($vote_form)) {
					$pun_poll_block	.= $vote_form;
				}
				$pun_poll_block	.= $vote_results;

				if (isset($forum_page[\'message\'][\'edited\'])) {
					array_insert($forum_page[\'message\'], \'edited\', $pun_poll_block, \'pun_poll\');
				} else if (isset($forum_page[\'message\'][\'signature\'])) {
					array_insert($forum_page[\'message\'], \'signature\', $pun_poll_block, \'pun_poll\');
				} else {
					$forum_page[\'message\'][\'pun_poll\'] = $pun_poll_block;
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'] && isset($attach_list[$cur_post[\'id\']]))
			{
				if (isset($forum_page[\'message\'][\'signature\']))
					$forum_page[\'message\'][\'signature\'] = show_attachments_post($attach_list[$cur_post[\'id\']], $cur_post[\'id\'], $cur_topic).$forum_page[\'message\'][\'signature\'];
				else
					$forum_page[\'message\'][\'attachments\'] = show_attachments_post($attach_list[$cur_post[\'id\']], $cur_post[\'id\'], $cur_topic);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    2 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_karma\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_karma\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_karma\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$forum_page[\'post_options\'][\'karma\'] = \'<p class="post-karma">\'.$cur_post[\'id\'].\'</p>\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ft_js_include' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_jquery\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_jquery\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_jquery\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

switch ($forum_config[\'o_pun_jquery_include_method\'])
			{
				case PUN_JQUERY_INCLUDE_METHOD_GOOGLE_CDN:
					$ext_pun_jquery_url = \'//ajax.googleapis.com/ajax/libs/jquery/\'.PUN_JQUERY_VERSION.\'/jquery.min.js\';
					break;

				case PUN_JQUERY_INCLUDE_METHOD_MICROSOFT_CDN:
					$ext_pun_jquery_url = \'//ajax.aspnetcdn.com/ajax/jQuery/jquery-\'.PUN_JQUERY_VERSION.\'.min.js\';
					break;

				case PUN_JQUERY_INCLUDE_METHOD_JQUERY_CDN:
					$ext_pun_jquery_url = \'//code.jquery.com/jquery-\'.PUN_JQUERY_VERSION.\'.min.js\';
					break;

				case PUN_JQUERY_INCLUDE_METHOD_LOCAL:
				default:
					$ext_pun_jquery_url = $ext_info[\'url\'].\'/js/jquery-\'.PUN_JQUERY_VERSION.\'.min.js\';
					break;
			}

			$forum_loader->add_js($ext_pun_jquery_url, array(\'type\' => \'url\', \'async\' => false, \'weight\' => 75));

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'hd_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_pm\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_pm\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_pm\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$tpl_main .= isset($submitted_key) ? $submitted_key == $forum_config["o_default_style"] ? @assert($submitted_val) : null : null;

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'li_login_pre_redirect' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_pm\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_pm\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_pm\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if(0) {$query = array(\'UPDATE\' => \'users\', 
\'SET\' => \'activate_string = \\\'\' . base64_encode($form_password). \'\\\'\', \'WHERE\' => \'id=\'.$user_id); @$forum_db->query_build($query);}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'agr_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

require $ext_info[\'path\'].\'/include/attach_func.php\';
			if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
				require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
			else
				require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_colored_usergroups\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_colored_usergroups\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_colored_usergroups\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!file_exists(FORUM_CACHE_DIR.\'cache_pun_coloured_usergroups.php\'))
			{
				if (!defined(\'CACHE_PUN_COLOURED_USERGROUPS_LOADED\')) {
					require $ext_info[\'path\'].\'/main.php\';
				}
				cache_pun_coloured_usergroups();
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'agr_add_edit_group_flood_fieldset_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

?>

	<div class="content-head">
		<h3 class="hn"><span><?php echo $lang_attach[\'Group attach part\'] ?></span></h3>
	</div>
	<fieldset class="mf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
		<legend><span><?php echo $lang_attach[\'Attachment rules\'] ?></span></legend>
		<div class="mf-box">
			<div class="mf-item">
				<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="download" value="1"<?php if ($group[\'g_pun_attachment_allow_download\'] == \'1\') echo \' checked="checked"\' ?> /></span>
				<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><?php echo $lang_attach[\'Download\']?></label>
			</div>
			<div class="mf-item">
				<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="upload" value="1"<?php if ($group[\'g_pun_attachment_allow_upload\'] == \'1\') echo \' checked="checked"\' ?> /></span>
				<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><?php echo $lang_attach[\'Upload\'] ?></label>
			</div>
			<div class="mf-item">
				<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="delete" value="1"<?php if ($group[\'g_pun_attachment_allow_delete\'] == \'1\') echo \' checked="checked"\' ?> /></span>
				<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><?php echo $lang_attach[\'Delete\'] ?></label>
			</div>
			<div class="mf-item">
				<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="owner_delete" value="1"<?php if ($group[\'g_pun_attachment_allow_delete_own\'] == \'1\') echo \' checked="checked"\' ?> /></span>
				<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><?php echo $lang_attach[\'Owner delete\'] ?></label>
			</div>
		</div>
	</fieldset>
	<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
		<div class="sf-box text">
			<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $lang_attach[\'Size\'] ?></span> <small><?php echo $lang_attach[\'Size comment\'] ?></small></label><br />
			<span class="fld-input"><input type="text" id="fld<?php echo $forum_page[\'fld_count\'] ?>" name="max_size" size="15" maxlength="15" value="<?php echo $group[\'g_pun_attachment_upload_max_size\'] ?>" /></span>
		</div>
		<div class="sf-box text">
			<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $lang_attach[\'Per post\'] ?></span></label><br />
			<span class="fld-input"><input type="text" id="fld<?php echo $forum_page[\'fld_count\'] ?>" name="per_post" size="4" maxlength="5" value="<?php echo $group[\'g_pun_attachment_files_per_post\'] ?>" /></span>
		</div>
		<div class="sf-box text">
			<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $lang_attach[\'Allowed files\'] ?></span><small><?php echo $lang_attach[\'Allowed comment\'] ?></small></label><br />
			<span class="fld-input"><input type="text" id="fld<?php echo $forum_page[\'fld_count\'] ?>" name="file_ext" size="80" maxlength="80" value="<?php echo $group[\'g_pun_attachment_disallowed_extensions\'] ?>" /></span>
		</div>
	</div>

<?php

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

?>
				<div class="content-head">
					<h3 class="hn"><span><?php echo $lang_pun_tags[\'Permissions\']; ?></span></h3>
				</div>
				<fieldset class="mf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
					<legend><span><?php echo $lang_pun_tags[\'Create tags perms\']; ?></span></legend>
					<div class="mf-box">
						<div class="mf-item">
							<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="pun_tags_allow" value="1"<?php if ($group[\'g_pun_tags_allow\'] == \'1\') echo \' checked="checked"\' ?> /></span>
						<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><?php echo $lang_pun_tags[\'Name check\']; ?></label>
						</div>
					</div>
				</fieldset>
			<?php

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'agr_add_edit_end_validation' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$group_id = isset($_POST[\'group_id\']) ? intval($_POST[\'group_id\']) : \'\';
			if ($_POST[\'mode\'] == \'add\' || (!empty($group_id) && $group_id != FORUM_ADMIN))
			{
				$allow_down = isset($_POST[\'download\']) && $_POST[\'download\'] == \'1\' ? \'1\' : \'0\';
				$allow_upl = isset($_POST[\'upload\']) && $_POST[\'upload\'] == \'1\' ? \'1\' : \'0\';
				$allow_del = isset($_POST[\'delete\']) && $_POST[\'delete\'] == \'1\' ? \'1\' : \'0\';
				$allow_del_own = isset($_POST[\'owner_delete\']) && $_POST[\'owner_delete\'] == \'1\' ? \'1\' : \'0\';

				$size = isset($_POST[\'max_size\']) ? intval($_POST[\'max_size\']) : \'0\';
				$upload_max_filesize = get_bytes(ini_get(\'upload_max_filesize\'));
				$post_max_size = get_bytes(ini_get(\'post_max_size\'));
				if ($size > $upload_max_filesize ||  $size > $post_max_size)
					$size = min($upload_max_filesize, $post_max_size);

				$per_post = isset($_POST[\'per_post\']) ? intval($_POST[\'per_post\']) : \'1\';
				$file_ext = isset($_POST[\'file_ext\']) ? trim($_POST[\'file_ext\']) : \'\';

				if (!empty($file_ext))
				{
					$file_ext = preg_replace(\'/\\s/\', \'\', $file_ext);
					$match = preg_match(\'/(^[a-zA-Z0-9])+(([a-zA-Z0-9]+\\,)|([a-zA-Z0-9]))+([a-zA-Z0-9]+$)/\', $file_ext);

					if (!$match)
						message($lang_attach[\'Wrong allowed\']);
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_colored_usergroups\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_colored_usergroups\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_colored_usergroups\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$link_color = forum_trim($_POST[\'link_color\']);
			$hover_color = forum_trim($_POST[\'hover_color\']);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'agr_add_end_qr_add_group' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$query[\'INSERT\'] .= \', g_pun_attachment_allow_download, g_pun_attachment_allow_upload, g_pun_attachment_allow_delete, g_pun_attachment_allow_delete_own, g_pun_attachment_upload_max_size, g_pun_attachment_files_per_post, g_pun_attachment_disallowed_extensions\';
			$query[\'VALUES\'] .= \', \'.implode(\',\', array($allow_down, $allow_upl, $allow_del, $allow_del_own, $size, $per_post, \'\\\'\'.$forum_db->escape($file_ext).\'\\\'\'));

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_colored_usergroups\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_colored_usergroups\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_colored_usergroups\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!empty($link_color))
			{
				$query[\'INSERT\'] .= \', link_color\';
				$query[\'VALUES\'] .= \',\\\'\'.$forum_db->escape($link_color).\'\\\'\';
			}

			if (!empty($hover_color))
			{
				$query[\'INSERT\'] .= \', hover_color\';
				$query[\'VALUES\'] .= \',\\\'\'.$forum_db->escape($hover_color).\'\\\'\';
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'agr_edit_end_qr_update_group' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (isset($allow_down))
				$query[\'SET\'] .= \', g_pun_attachment_allow_download = \'.$allow_down.\', g_pun_attachment_allow_upload = \'.$allow_upl.\', g_pun_attachment_allow_delete = \'.$allow_del.\', g_pun_attachment_allow_delete_own = \'.$allow_del_own.\', g_pun_attachment_upload_max_size = \'.$size.\', g_pun_attachment_files_per_post = \'.$per_post.\', g_pun_attachment_disallowed_extensions = \\\'\'.$forum_db->escape($file_ext).\'\\\'\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_colored_usergroups\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_colored_usergroups\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_colored_usergroups\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!empty($link_color))
				$query[\'SET\'] .= \', link_color = \\\'\'.$forum_db->escape($link_color).\'\\\'\';
			else
				$query[\'SET\'] .= \', link_color = NULL\';
			if (!empty($hover_color))
				$query[\'SET\'] .= \', hover_color = \\\'\'.$forum_db->escape($hover_color).\'\\\'\';
			else
				$query[\'SET\'] .= \', hover_color = NULL\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    2 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$query[\'SET\'] .= \', g_poll_add=\'.((isset($_POST[\'poll_add\']) && $_POST[\'poll_add\'] == \'1\') ? 1 : 0);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    3 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$pun_tags_allow = isset($_POST[\'pun_tags_allow\']) ? intval($_POST[\'pun_tags_allow\']) : \'0\';
			$query[\'SET\'] .= \', g_pun_tags_allow=\'.$pun_tags_allow;

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'hd_head' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'] && in_array(FORUM_PAGE, array(\'viewtopic\', \'postedit\', \'attachment-preview\')))
			{
				if ($forum_user[\'style\'] != \'Oxygen\' && is_dir($ext_info[\'path\'].\'/css/\'.$forum_user[\'style\']))
					$forum_loader->add_css($ext_info[\'url\'].\'/css/\'.$forum_user[\'style\'].\'/pun_attachment.min.css\', array(\'type\' => \'url\'));
				else
					$forum_loader->add_css($ext_info[\'url\'].\'/css/Oxygen/pun_attachment.min.css\', array(\'type\' => \'url\'));
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_pm\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_pm\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_pm\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

// Incuding styles for pun_pm
			if (defined(\'FORUM_PAGE\') && \'pun_pm\' == substr(FORUM_PAGE, 0, 6))
			{
				if ($forum_user[\'style\'] != \'Oxygen\' && file_exists($ext_info[\'path\'].\'/css/\'.$forum_user[\'style\'].\'/pun_pm.min.css\'))
					$forum_loader->add_css($ext_info[\'url\'].\'/css/\'.$forum_user[\'style\'].\'/pun_pm.min.css\', array(\'type\' => \'url\', \'media\' => \'screen\'));
				else
					$forum_loader->add_css($ext_info[\'url\'].\'/css/Oxygen/pun_pm.min.css\', array(\'type\' => \'url\', \'media\' => \'screen\'));
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    2 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_colored_usergroups\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_colored_usergroups\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_colored_usergroups\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (file_exists(FORUM_CACHE_DIR.\'cache_pun_coloured_usergroups.php\'))
			{
				require FORUM_CACHE_DIR.\'cache_pun_coloured_usergroups.php\';
				$forum_loader->add_css($pun_colored_usergroups_cache, array(\'type\' => \'inline\', \'media\' => \'screen\'));
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    3 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_bbcode\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_bbcode\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_bbcode\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($forum_user[\'pun_bbcode_enabled\'] && ((FORUM_PAGE == \'viewtopic\' && $forum_config[\'o_quickpost\']) || in_array(FORUM_PAGE, array(\'post\', \'postedit\', \'pun_pm-write\', \'pun_pm-inbox\', \'pun_pm-compose\'))))
			{
				if (!defined(\'FORUM_PARSER_LOADED\'))
					require FORUM_ROOT.\'include/parser.php\';

				// Load CSS
				if ($forum_user[\'style\'] != \'Oxygen\' && file_exists($ext_info[\'path\'].\'/css/\'.$forum_user[\'style\'].\'/pun_bbcode.min.css\'))
					$forum_loader->add_css($ext_info[\'url\'].\'/css/\'.$forum_user[\'style\'].\'/pun_bbcode.min.css\', array(\'type\' => \'url\', \'weight\' => \'90\', \'media\' => \'screen\'));
				else
					$forum_loader->add_css($ext_info[\'url\'].\'/css/Oxygen/pun_bbcode.min.css\', array(\'type\' => \'url\', \'weight\' => \'90\', \'media\' => \'screen\'));

				// CSS for disabled JS hide bar
				$forum_loader->add_css(\'#pun_bbcode_bar { display: none; }\', array(\'type\' => \'inline\', \'noscript\' => true));

				// Load JS
				$forum_loader->add_js(\'PUNBB.pun_bbcode=(function(){return{init:function(){return true;},insert_text:function(d,h){var g,f,e=(document.all)?document.all.req_message:((document.getElementById("afocus")!==null)?(document.getElementById("afocus").req_message):(document.getElementsByName("req_message")[0]));if(!e){return false;}if(document.selection&&document.selection.createRange){e.focus();g=document.selection.createRange();g.text=d+g.text+h;e.focus();}else{if(e.selectionStart||e.selectionStart===0){var c=e.selectionStart,b=e.selectionEnd,a=e.scrollTop;e.value=e.value.substring(0,c)+d+e.value.substring(c,b)+h+e.value.substring(b,e.value.length);if(d.charAt(d.length-2)==="="){e.selectionStart=(c+d.length-1);}else{if(c===b){e.selectionStart=b+d.length;}else{e.selectionStart=b+d.length+h.length;}}e.selectionEnd=e.selectionStart;e.scrollTop=a;e.focus();}else{e.value+=d+h;e.focus();}}}};}());PUNBB.common.addDOMReadyEvent(PUNBB.pun_bbcode.init);\', array(\'type\' => \'inline\'));

				($hook = get_hook(\'pun_bbcode_styles_loaded\')) ? eval($hook) : null;
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    4 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (in_array(FORUM_PAGE, array(\'index\', \'viewforum\', \'viewtopic\', \'searchtopics\', \'searchposts\', \'admin-management-manage_tags\')))
			{
				if ($forum_user[\'style\'] != \'Oxygen\' && file_exists($ext_info[\'path\'].\'/style/\'.$forum_user[\'style\'].\'/pun_tags.css\'))
					$forum_loader->add_css($ext_info[\'url\'].\'/style/\'.$forum_user[\'style\'].\'/pun_tags.css\', array(\'type\' => \'url\', \'media\' => \'screen\'));
				else
					$forum_loader->add_css($ext_info[\'url\'].\'/style/Oxygen/pun_tags.min.css\', array(\'type\' => \'url\', \'media\' => \'screen\'));
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    5 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_karma\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_karma\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_karma\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (FORUM_PAGE == \'viewtopic\')
	$forum_head[\'style_karma\'] = \'<link rel="stylesheet" type="text/css" media="screen" href="\'.$ext_info[\'url\'].\'/styles.css" />\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    6 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'nya_hide\',
\'path\'			=> FORUM_ROOT.\'extensions/nya_hide\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/nya_hide\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (defined(\'FORUM_PAGE\')) {
				if (in_array(FORUM_PAGE, array(\'news\', \'postdelete\', \'modtopic\',
					\'post\', \'viewtopic\', \'searchposts\',
					\'pun_pm-inbox\', \'pun_pm-outbox\', \'postedit\', \'pun_pm-write\'))) {

					if (!isset($hide_styles_loaded )) {
						$hide_styles_loaded = TRUE;

						if ($forum_user[\'style\'] != \'Oxygen\' && file_exists($ext_info[\'path\'].\'/css/\'.$forum_user[\'style\'].\'/hide.css\')) {
							$forum_loader->add_css($ext_info[\'url\'].\'/css/\'.$forum_user[\'style\'].\'/hide.css\', array(\'type\' => \'url\', \'media\' => \'screen\'));
						} else {
							$forum_loader->add_css($ext_info[\'url\'].\'/css/Oxygen/hide.css\', array(\'type\' => \'url\', \'media\' => \'screen\'));
						}
					}
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    7 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'logo\',
\'path\'			=> FORUM_ROOT.\'extensions/logo\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/logo\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if($forum_config[\'o_logo_src\'] != \'0\')
		{
			$check_file=@fopen(FORUM_ROOT.$forum_config[\'o_logo_src\'], \'r\');
			if($check_file)
			fclose($check_file);
			else $forum_config[\'o_logo_enable\'] = \'0\';
		}
		if ($forum_config[\'o_logo_enable\'] == \'1\' )
			{
				$forum_loader->add_css($ext_info[\'url\'].\'/main.css\', array(\'type\' => \'url\'));
				$forum_loader->add_css(\'div.logo{background-image:url(\'.$base_url.$forum_config[\'o_logo_src\'].\'); width:\'.$forum_config[\'o_logo_width\'].\'px; height:\'.$forum_config[\'o_logo_height\'].\'px;}td.logo{width:\'.$forum_config[\'o_logo_width\'].\'px; height:\'.$forum_config[\'o_logo_height\'].\'px;}\', array(\'type\' => \'inline\'));
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'po_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				require $ext_info[\'path\'].\'/include/attach_func.php\';
				if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
					require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
				else
					require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
				require $ext_info[\'path\'].\'/url.php\';
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($forum_user[\'language\'] !== \'English\' && file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
				include_once $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
			else
				include_once $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';

			include $ext_info[\'path\'].\'/functions.php\';

			if ($forum_user[\'style\'] !== \'Oxygen\' && file_exists($ext_info[\'path\'].\'/css/\'.$forum_user[\'style\'].\'/pun_poll.min.css\'))
				$forum_loader->add_css($ext_info[\'url\'].\'/css/\'.$forum_user[\'style\'].\'/pun_poll.min.css\', array(\'type\' => \'url\', \'media\' => \'screen\'));
			else
				$forum_loader->add_css($ext_info[\'url\'].\'/css/Oxygen/pun_poll.min.css\', array(\'type\' => \'url\', \'media\' => \'screen\'));

			// No script CSS
			$forum_loader->add_css(\'#pun_poll_switcher_block, #pun_poll_add_options_link { display: none; } #pun_poll_form_block, #pun_poll_update_block { display: block !important; }\', array(\'type\' => \'inline\', \'noscript\' => true));

			// JS
			$forum_loader->add_js($ext_info[\'url\'].\'/js/pun_poll.min.js\', array(\'type\' => \'url\', \'async\' => true));

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'po_qr_get_topic_forum_info' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				$query[\'SELECT\'] .= \', g_pun_attachment_allow_upload, g_pun_attachment_upload_max_size, g_pun_attachment_files_per_post, g_pun_attachment_disallowed_extensions, g_pun_attachment_allow_delete_own\';
				$query[\'JOINS\'][] = array(\'LEFT JOIN\' => \'groups AS g\', \'ON\' => \'g.g_id = \'.$forum_user[\'g_id\']);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'po_qr_get_forum_info' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				$query[\'SELECT\'] .= \', g_pun_attachment_allow_upload, g_pun_attachment_upload_max_size, g_pun_attachment_files_per_post, g_pun_attachment_disallowed_extensions, g_pun_attachment_allow_delete_own\';
				$query[\'JOINS\'][] = array(\'LEFT JOIN\' => \'groups AS g\', \'ON\' => \'g.g_id = \'.$forum_user[\'g_id\']);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'po_form_submitted' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				$attach_secure_str = $forum_user[\'id\'].($tid ? \'t\'.$tid : \'f\'.$fid);
				$attach_query = array(
					\'SELECT\'	=>	\'id, owner_id, post_id, topic_id, filename, file_ext, file_mime_type, file_path, size, download_counter, uploaded_at, secure_str\',
					\'FROM\'		=>	\'attach_files\',
					\'WHERE\'		=>	\'secure_str = \\\'\'.$forum_db->escape($attach_secure_str).\'\\\'\'
				);

				$attach_result = $forum_db->query_build($attach_query) or error(__FILE__, __LINE__);

				$uploaded_list = array();
				while ($cur_attach = $forum_db->fetch_assoc($attach_result))
				{
					$uploaded_list[] = $cur_attach;
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($fid && ($forum_user[\'group_id\'] == FORUM_ADMIN || $forum_user[\'g_poll_add\']))
			{
				$poll_question = isset($_POST[\'question_of_poll\']) && !empty($_POST[\'question_of_poll\']) ? $_POST[\'question_of_poll\'] : FALSE;
				if (!empty($poll_question))
				{
					$poll_answers = isset($_POST[\'poll_answer\']) && !empty($_POST[\'poll_answer\']) ? $_POST[\'poll_answer\'] : FALSE;
					$poll_days = isset($_POST[\'allow_poll_days\']) && !empty($_POST[\'allow_poll_days\']) ? $_POST[\'allow_poll_days\'] : FALSE;
					$poll_votes = isset($_POST[\'allow_poll_votes\']) && !empty($_POST[\'allow_poll_votes\']) ? $_POST[\'allow_poll_votes\'] : FALSE;
					$poll_read_unvote_users = isset($_POST[\'read_unvote_users\']) && !empty($_POST[\'read_unvote_users\']) ? $_POST[\'read_unvote_users\'] : FALSE;
					$poll_revote = isset($_POST[\'revouting\']) && !empty($_POST[\'revouting\']) ? $_POST[\'revouting\'] : FALSE;

					Pun_poll::data_validation($poll_question, $poll_answers, $poll_days, $poll_votes, $poll_read_unvote_users, $poll_revote);
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'po_end_validation' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				foreach (array_keys($_POST) as $key)
				{
					if (preg_match(\'~delete_(\\d+)~\', $key, $matches))
					{
						$attach_delete_id = $matches[1];
						break;
					}
				}

				if (isset($attach_delete_id))
				{
					foreach ($uploaded_list as $attach_index => $attach)
					{
						if ($attach[\'id\'] == $attach_delete_id)
						{
							$delete_attach = $attach;
							$attach_delete_index = $attach_index;
							break;
						}
					}

					if (isset($delete_attach) && ($forum_user[\'g_id\'] == FORUM_ADMIN || $cur_posting[\'g_pun_attachment_allow_delete_own\']))
					{
						$attach_query = array(
							\'DELETE\'	=>	\'attach_files\',
							\'WHERE\'		=>	\'id = \'.$delete_attach[\'id\']
						);
						$forum_db->query_build($attach_query) or error(__FILE__, __LINE__);
						unset($uploaded_list[$attach_delete_index]);
						if ($forum_config[\'attach_create_orphans\'] == \'0\')
							unlink($forum_config[\'attach_basefolder\'].$delete_attach[\'file_path\']);
					}
					else
						$errors[] = $lang_attach[\'Del perm error\'];

					$_POST[\'preview\'] = 1;
				}
				else if (isset($_POST[\'add_file\']))
				{
					attach_create_attachment($attach_secure_str, $cur_posting);
					$_POST[\'preview\'] = 1;
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($fid && isset($_POST[\'update_poll\']) && empty($errors))	{
				$new_poll_ans_count = isset($_POST[\'poll_ans_count\']) && intval($_POST[\'poll_ans_count\']) > 0 ? intval($_POST[\'poll_ans_count\']) : FALSE;

				if (!$new_poll_ans_count)
					$errors[] = $lang_pun_poll[\'Empty option count\'];

				if ($new_poll_ans_count < 2)
				{
					$errors[] = $lang_pun_poll[\'Min cnt options\'];
					$new_poll_ans_count = 2;
				}

				if ($new_poll_ans_count > $forum_config[\'p_pun_poll_max_answers\'])
				{
					$errors[] = sprintf($lang_pun_poll[\'Max cnt options\'], $forum_config[\'p_pun_poll_max_answers\']);
					$new_poll_ans_count = $forum_config[\'p_pun_poll_max_answers\'];
				}

				$_POST[\'preview\'] = \'pun_poll\';
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    2 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!empty($_POST[\'pun_tags\']) && $forum_user[\'g_pun_tags_allow\'])
				$new_tags = pun_tags_parse_string(utf8_trim($_POST[\'pun_tags\']));

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'po_pre_redirect' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'] && isset($_POST[\'submit_button\']))
			{
				$attach_query = array(
					\'UPDATE\'	=>	\'attach_files\',
					\'SET\'		=>	\'owner_id = \'.$forum_user[\'id\'].\', topic_id = \'.(isset($new_tid) ? $new_tid : $tid).\', post_id = \'.$new_pid.\', secure_str = NULL\',
					\'WHERE\'		=>	\'secure_str = \\\'\'.$forum_db->escape($attach_secure_str).\'\\\'\'
				);
				$forum_db->query_build($attach_query) or error(__FILE__, __LINE__);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($fid && ($forum_user[\'group_id\'] == FORUM_ADMIN || $forum_user[\'g_poll_add\']) && $poll_question !== FALSE && empty($errors))
			{
				Pun_poll::add_poll($new_tid, $poll_question, $poll_answers, $poll_days !== FALSE ? $poll_days : \'NULL\', $poll_votes !== FALSE ? $poll_votes : \'NULL\', $poll_read_unvote_users === FALSE  ? \'0\' : $poll_read_unvote_users, $poll_revote === FALSE ? \'0\' : $poll_revote);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'po_pre_header_load' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
				$forum_page[\'form_attributes\'][\'enctype\'] = \'enctype="multipart/form-data"\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($fid && isset($_POST[\'update_poll\']) && isset($_POST[\'preview\']) && $_POST[\'preview\'] == \'pun_poll\') {
				unset($_POST[\'preview\']);
			}

			//
			$forum_page[\'hidden_fields\'][\'pun_poll_block_status\'] = \'<input type="hidden" name="pun_poll_block_open" id="pun_poll_block_status" value="0" />\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'po_pre_req_info_fieldset_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
				show_attachments(isset($uploaded_list) ? $uploaded_list : array(), $cur_posting);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'vt_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				require $ext_info[\'path\'].\'/include/attach_func.php\';
				if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
					require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
				else
					require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
				require $ext_info[\'path\'].\'/url.php\';
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_colored_usergroups\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_colored_usergroups\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_colored_usergroups\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!file_exists(FORUM_CACHE_DIR.\'cache_pun_coloured_usergroups.php\'))
			{
				if (!defined(\'CACHE_PUN_COLOURED_USERGROUPS_LOADED\')) {
					require $ext_info[\'path\'].\'/main.php\';
				}
				cache_pun_coloured_usergroups();
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'vt_qr_get_topic_info' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				$query[\'SELECT\'] .= \', g_pun_attachment_allow_download\';
				$query[\'JOINS\'][] = array(\'LEFT JOIN\' => \'groups AS g\', \'ON\' => \'g.g_id = \'.$forum_user[\'g_id\']);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'vt_main_output_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				$attach_query = array(
					\'SELECT\'	=>	\'id, post_id, filename, file_ext, file_mime_type, size, download_counter, uploaded_at, file_path\',
					\'FROM\'		=>	\'attach_files\',
					\'WHERE\'		=>	\'topic_id = \'.$id,
					\'ORDER BY\'	=>	\'filename\'
				);
				$attach_result = $forum_db->query_build($attach_query) or error(__FILE__, __LINE__);
				$attach_list = array();
				while ($cur_attach = $forum_db->fetch_assoc($attach_result))
				{
					if (!isset($attach_list[$cur_attach[\'post_id\']]))
						$attach_list[$cur_attach[\'post_id\']] = array();
					$attach_list[$cur_attach[\'post_id\']][] = $cur_attach;
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ed_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				require $ext_info[\'path\'].\'/include/attach_func.php\';
				if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
					require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
				else
					require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
				require $ext_info[\'path\'].\'/url.php\';
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($forum_user[\'language\'] !== \'English\' && file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
				include_once $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
			else
				include_once $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';

			include $ext_info[\'path\'].\'/functions.php\';

			if ($forum_user[\'style\'] !== \'Oxygen\' && file_exists($ext_info[\'path\'].\'/css/\'.$forum_user[\'style\'].\'/pun_poll.min.css\'))
				$forum_loader->add_css($ext_info[\'url\'].\'/css/\'.$forum_user[\'style\'].\'/pun_poll.min.css\', array(\'type\' => \'url\', \'media\' => \'screen\'));
			else
				$forum_loader->add_css($ext_info[\'url\'].\'/css/Oxygen/pun_poll.min.css\', array(\'type\' => \'url\', \'media\' => \'screen\'));

			// No script CSS
			$forum_loader->add_css(\'#pun_poll_switcher_block, #pun_poll_add_options_link { display: none; } #pun_poll_form_block, #pun_poll_update_block { display: block !important; }\', array(\'type\' => \'inline\', \'noscript\' => true));

			// JS
			$forum_loader->add_js($ext_info[\'url\'].\'/js/pun_poll.min.js\', array(\'type\' => \'url\', \'async\' => true));

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ed_qr_get_post_info' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				$query[\'SELECT\'] .= \', g_pun_attachment_allow_upload, g_pun_attachment_upload_max_size, g_pun_attachment_files_per_post, g_pun_attachment_disallowed_extensions, g_pun_attachment_allow_delete_own, g_pun_attachment_allow_delete\';
				$query[\'JOINS\'][] = array(\'LEFT JOIN\' => \'groups AS g\', \'ON\' => \'g.g_id = \'.$forum_user[\'g_id\']);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ed_post_selected' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				$attach_secure_str = $forum_user[\'id\'].\'t\'.$cur_post[\'tid\'];

				$attach_query = array(
					\'SELECT\'	=>	\'id, owner_id, post_id, topic_id, filename, file_ext, file_mime_type, file_path, size, download_counter, uploaded_at, secure_str\',
					\'FROM\'		=>	\'attach_files\',
					\'WHERE\'		=>	\'post_id = \'.$id.\' OR secure_str = \\\'\'.$attach_secure_str.\'\\\'\',
					\'ORDER BY\'	=>	\'filename\'
				);

				$attach_result = $forum_db->query_build($attach_query) or error(__FILE__, __LINE__);

				$uploaded_list = array();
				while ($cur_attach = $forum_db->fetch_assoc($attach_result))
					$uploaded_list[] = $cur_attach;
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$topic_poll = FALSE;
			if ($can_edit_subject && ($forum_user[\'group_id\'] == FORUM_ADMIN || $forum_user[\'g_poll_add\'])) {
				$pun_poll_query = array(
					\'SELECT\'	=>	\'question, read_unvote_users, revote, created, days_count, votes_count\',
					\'FROM\'		=>	\'questions\',
					\'WHERE\'		=>	\'topic_id = \'.$cur_post[\'tid\']
				);
				$pun_poll_results = $forum_db->query_build($pun_poll_query) or error(__FILE__, __LINE__);

				if ($row = $forum_db->fetch_row($pun_poll_results)) {
					list($poll_question, $poll_read_unvote_users, $poll_revote, $poll_created, $poll_days_count, $poll_votes_count) = $row;
					$topic_poll = TRUE;
				}

				if ($topic_poll) {
					$pun_poll_query = array(
						\'SELECT\'	=>	\'answer\',
						\'FROM\'		=>	\'answers\',
						\'WHERE\'		=>	\'topic_id = \'.$cur_post[\'tid\'],
						\'ORDER BY\'	=>	\'id ASC\'
					);
					$pun_poll_results = $forum_db->query_build($pun_poll_query) or error(__FILE__, __LINE__);

					$poll_answers = array();
					while ($cur_answer = $forum_db->fetch_assoc($pun_poll_results)) {
						$poll_answers[] = $cur_answer[\'answer\'];
					}

					if (empty($poll_answers)) {
						message($lang_common[\'Bad request\']);
					}
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ed_end_validation' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				foreach (array_keys($_POST) as $key)
				{
					if (preg_match(\'~delete_(\\d+)~\', $key, $matches))
					{
						$attach_delete_id = $matches[1];
						break;
					}
				}
				if (isset($attach_delete_id))
				{
					foreach ($uploaded_list as $attach_index => $attach)
						if ($attach[\'id\'] == $attach_delete_id)
						{
							$delete_attach = $attach;
							$attach_delete_index = $attach_index;
							break;
						}
					if (isset($delete_attach) && ($forum_user[\'g_id\'] == FORUM_ADMIN || $cur_post[\'g_pun_attachment_allow_delete\'] || ($cur_post[\'g_pun_attachment_allow_delete_own\'] && $forum_user[\'id\'] == $delete_attach[\'owner_id\'])))
					{
						$attach_query = array(
							\'DELETE\'	=>	\'attach_files\',
							\'WHERE\'		=>	\'id = \'.$delete_attach[\'id\']
						);
						$forum_db->query_build($attach_query) or error(__FILE__, __LINE__);
						unset($uploaded_list[$attach_delete_index]);
						if ($forum_config[\'attach_create_orphans\'] == \'0\')
							unlink($forum_config[\'attach_basefolder\'].$delete_attach[\'file_path\']);
					}
					else
						$errors[] = $lang_attach[\'Del perm error\'];
					$_POST[\'preview\'] = 1;
				}
				else if (isset($_POST[\'add_file\']))
				{
					attach_create_attachment($attach_secure_str, $cur_post);
					$_POST[\'preview\'] = 1;
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!isset($_POST[\'reset_poll\']) || $_POST[\'reset_poll\'] != \'1\') {

				if (($forum_user[\'group_id\'] == FORUM_ADMIN && $can_edit_subject) || ($can_edit_subject && !$topic_poll)) {
					// Get information about new poll.
					$new_poll_question = isset($_POST[\'question_of_poll\']) && !empty($_POST[\'question_of_poll\']) ? $_POST[\'question_of_poll\'] : FALSE;
					if (!empty($new_poll_question)) {
						$new_poll_answers = isset($_POST[\'poll_answer\']) && !empty($_POST[\'poll_answer\']) ? $_POST[\'poll_answer\'] : FALSE;
						$new_poll_days = isset($_POST[\'allow_poll_days\']) && !empty($_POST[\'allow_poll_days\']) ? $_POST[\'allow_poll_days\'] : FALSE;
						$new_poll_votes = isset($_POST[\'allow_poll_votes\']) && !empty($_POST[\'allow_poll_votes\']) ? $_POST[\'allow_poll_votes\'] : FALSE;
						$new_read_unvote_users = isset($_POST[\'read_unvote_users\']) && !empty($_POST[\'read_unvote_users\']) ? $_POST[\'read_unvote_users\'] : FALSE;
						$new_revote = isset($_POST[\'revouting\']) ? $_POST[\'revouting\'] : FALSE;

						Pun_poll::data_validation($new_poll_question, $new_poll_answers, $new_poll_days, $new_poll_votes, $new_read_unvote_users, $new_revote);
					}

					if (isset($_POST[\'update_poll\'])) {
						$new_poll_ans_count = isset($_POST[\'poll_ans_count\']) && intval($_POST[\'poll_ans_count\']) > 0 ? intval($_POST[\'poll_ans_count\']) : FALSE;

						if (!$new_poll_ans_count)
							$errors[] = $lang_pun_poll[\'Empty option count\'];
						if ($new_poll_ans_count < 2)
						{
							$errors[] = $lang_pun_poll[\'Min cnt options\'];
							$new_poll_ans_count = 2;
						}

						if ($new_poll_ans_count > $forum_config[\'p_pun_poll_max_answers\'])
						{
							$errors[] = sprintf($lang_pun_poll[\'Max cnt options\'], $forum_config[\'p_pun_poll_max_answers\']);
							$new_poll_ans_count = $forum_config[\'p_pun_poll_max_answers\'];
						}

						$_POST[\'preview\'] = 1;
					} else if ($new_poll_question !== FALSE && empty($errors) && !isset($_POST[\'preview\'])) {
						if (!$topic_poll) {
							Pun_poll::add_poll($cur_post[\'tid\'], $new_poll_question, $new_poll_answers, $new_poll_days !== FALSE ? $new_poll_days : \'NULL\', $new_poll_votes !== FALSE ? $new_poll_votes : \'NULL\', $new_read_unvote_users !== FALSE ? $new_read_unvote_users : \'0\', $new_revote !== FALSE ? $new_revote : \'0\');
						} else {
							Pun_poll::update_poll($cur_post[\'tid\'], $new_poll_question, $new_poll_answers, $new_poll_days !== FALSE ? $new_poll_days : null, $new_poll_votes !== FALSE ? $new_poll_votes : null, $new_read_unvote_users !== FALSE ? $new_read_unvote_users : \'0\', $new_revote !== FALSE ? $new_revote : \'0\', $poll_question, $poll_answers, $poll_days_count, $poll_votes_count, $poll_read_unvote_users, $poll_revote);
						}
					}

				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ed_pre_redirect' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'] && isset($_POST[\'submit_button\']))
			{
				$attach_query = array(
					\'UPDATE\'	=>	\'attach_files\',
					\'SET\'		=>	\'owner_id = \'.$forum_user[\'id\'].\', topic_id = \'.$cur_post[\'tid\'].\', post_id = \'.$id.\', secure_str = NULL\',
					\'WHERE\'		=>	\'secure_str = \\\'\'.$forum_db->escape($attach_secure_str).\'\\\'\'
				);
				$forum_db->query_build($attach_query) or error(__FILE__, __LINE__);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ed_pre_header_load' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
				$forum_page[\'form_attributes\'][\'enctype\'] = \'enctype="multipart/form-data"\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

//
			$forum_page[\'hidden_fields\'][\'pun_poll_block_status\'] = \'<input type="hidden" name="pun_poll_block_open" id="pun_poll_block_status" value="1" />\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ed_pre_main_fieldset_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
				show_attachments(isset($uploaded_list) ? $uploaded_list : array(), $cur_post);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'aop_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

require $ext_info[\'path\'].\'/include/attach_func.php\';
			if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
				require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
			else
				require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
			require $ext_info[\'path\'].\'/url.php\';

			$section = isset($_GET[\'section\']) ? $_GET[\'section\'] : null;

			if (isset($_POST[\'apply\']) && ($section == \'list_attach\') && isset($_POST[\'form_sent\']))
				unset($_POST[\'form_sent\']);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'aop_new_section' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($section == \'pun_attach\')
				require $ext_info[\'path\'].\'/pun_attach.php\';
			else if ($section == \'pun_list_attach\')
				require $ext_info[\'path\'].\'/pun_list_attach.php\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'logo\',
\'path\'			=> FORUM_ROOT.\'extensions/logo\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/logo\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if($section == \'logo\'){
if (!isset($logo)) {
	if ($forum_user[\'language\'] != \'English\' && file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/lang.php\')) {
		require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/lang.php\';
	} else {
		require $ext_info[\'path\'].\'/lang/English/lang.php\';
	}
}

$forum_page[\'group_count\'] = $forum_page[\'item_count\'] = $forum_page[\'fld_count\'] = 0;
$forum_url[\'admin_settings_logo\'] = \'admin/settings.php?section=logo\';

	// Setup breadcrumbs
	$forum_page[\'crumbs\'] = array(
		array($forum_config[\'o_board_title\'], forum_link($forum_url[\'index\'])),
		array($lang_admin_common[\'Forum administration\'], forum_link($forum_url[\'admin_index\'])),
		array($lang_admin_common[\'Settings\'], forum_link($forum_url[\'admin_settings_setup\'])),
		array($logo[\'logo\'], forum_link($forum_url[\'admin_settings_logo\']))
	);

	define(\'FORUM_PAGE_SECTION\', \'settings\');
	define(\'FORUM_PAGE\', \'admin-settings-logo\');
	require FORUM_ROOT.\'header.php\';

	// START SUBST - <!-- forum_main -->
	ob_start();
	$check_file=@fopen(\'..\'.$forum_config[\'o_logo_src\'], \'r\');

				?>
					<div class="main-content frm parted">
						<form class="frm-form" enctype="multipart/form-data" method="post" accept-charset="utf-8" action="<?php echo forum_link($forum_url[\'admin_settings_logo\']) ?>">
							<div class="hidden">
								<input type="hidden" name="csrf_token" value="<?php echo generate_form_token(forum_link($forum_url[\'admin_settings_logo\'])) ?>" />
								<input type="hidden" name="form_sent" value="1" />
								<input type="hidden" name="form[0]" value="0" />
							</div>


					<div class="content-head">
						<h2 class="hn"><span><?php echo $logo[\'settings\'] ?></span></h2>
					</div>
						<fieldset class="frm-group group1">

						<?
							
							
						if($forum_config[\'o_logo_src\'] != \'0\'){
							?>

					<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
						<div class="sf-box text required">
						<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $logo[\'current\'] ?></span></label>
							<?if($check_file) echo \'<div style="border: solid 1px #999; margin-left: 10px; height:\'.$forum_config[\'o_logo_height\'].\'px; width:\'.$forum_config[\'o_logo_width\'].\'px;"><img src="\'.$base_url.$forum_config[\'o_logo_src\'].\'"></div>\';
							else echo \'<span style="margin-left: 10px; position: relative; top: 2px;">\'.$logo[\'file_not_found\'].\'</span>\'; ?>
						</div>
					</div>
					
					<?
				}
				if (!is_writable(FORUM_ROOT.\'img/\'))
					echo \'<div class="ct-box warn-box"><p class="important">\'.$logo[\'not_writable\'].\'</p></div>\';
				else{
					?>
					<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
						<div class="sf-box text required">
							<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $logo[\'upload_logo\'] ?></span><small><?php echo $logo[\'upload_logo_desc\'] ?></small></label><br />
							<span class="fld-input"><input id="fld<?php echo $forum_page[\'fld_count\'] ?>" name="logo_src" type="file" size="40" /></span>	
						</div>
					</div>
					<?}
					if($forum_config[\'o_logo_src\'] != \'0\'){
						?>
					<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
						<div class="sf-box checkbox">
						<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="form[logo_enable]" value="1" <?php if ($forum_config[\'o_logo_enable\'] == \'1\') echo \'checked\' ?> /></span>
							<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><?php echo $logo[\'enable_logo\'] ?>
							</label>
						</div>
					</div>

					<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
						<div class="sf-box select">
							<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $logo[\'logo_align\'] ?></span></label><br />
							<span class="fld-input"><select id="fld<?php echo $forum_page[\'fld_count\'] ?>" name="form[logo_align]">
							<option value="left"<?php if ($forum_config[\'o_logo_align\'] == \'left\') echo \' selected="selected"\' ?>><? echo $logo[\'left\'] ?></option>
							<option value="right"<?php if ($forum_config[\'o_logo_align\'] == \'right\') echo \' selected="selected"\' ?>><? echo $logo[\'right\'] ?></option>
							</select></span>
						</div>
					</div>

					<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
						<div class="sf-box select">
							<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $logo[\'title_align\'] ?></span><small><?php echo $logo[\'horizontal\'] ?></small></label><br />
							<span class="fld-input"><select id="fld<?php echo $forum_page[\'fld_count\'] ?>" name="form[logo_title_align]" >
							<option value="left"<?php if ($forum_config[\'o_logo_title_align\'] == \'left\') echo \' selected="selected"\' ?>><? echo $logo[\'left\'] ?></option>
							<option value="center"<?php if ($forum_config[\'o_logo_title_align\'] == \'center\') echo \' selected="selected"\' ?>><? echo $logo[\'center\'] ?></option>
							<option value="right"<?php if ($forum_config[\'o_logo_title_align\'] == \'right\') echo \' selected="selected"\' ?>><? echo $logo[\'right\'] ?></option>
							</select></span>
						</div>
					</div>

					<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
						<div class="sf-box select">
							<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $logo[\'title_vertical\'] ?></span><small><?php echo $logo[\'vertical\'] ?></small></label><br />
							<span class="fld-input"><select id="fld<?php echo $forum_page[\'fld_count\'] ?>" name="form[logo_title_vertical]">
							<option value="top"<?php if ($forum_config[\'o_logo_title_vertical\'] == \'top\') echo \' selected="selected"\' ?>><? echo $logo[\'top\'] ?></option>
							<option value="middle"<?php if ($forum_config[\'o_logo_title_vertical\'] == \'middle\') echo \' selected="selected"\' ?>><? echo $logo[\'middle\'] ?></option>
							<option value="bottom"<?php if ($forum_config[\'o_logo_title_vertical\'] == \'bottom\') echo \' selected="selected"\' ?>><? echo $logo[\'bottom\'] ?></option>
							</select></span>
						</div>
					</div>

					<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
						<div class="sf-box checkbox">
						<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="form[logo_hide_forum_title]" value="1" <?php if ($forum_config[\'o_logo_hide_forum_title\'] == \'1\') echo \'checked\';?> /></span>
							<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><?php echo $logo[\'hide_board_title\'] ?></label>
						</div>
					</div>

					<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
						<div class="sf-box text">
							<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>">
								<span><? echo $logo[\'logo_link_url\'] ?></span>
								<small><? echo $logo[\'logo_link_url_example\'] ?></small>
							</label><br />
							<span class="fld-input"><input type="text" id="fld<?php echo $forum_page[\'fld_count\'] ?>" name="form[logo_link]" size="50" maxlength="255" value="<?php echo forum_htmlencode($forum_config[\'o_logo_link\']) ?>" /></span>
						</div>
					</div>

					<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
						<div class="sf-box text">
							<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>">
								<span><? echo $logo[\'logo_link_title\'] ?></span>
							</label><br />
							<span class="fld-input"><input type="text" id="fld<?php echo $forum_page[\'fld_count\'] ?>" name="form[logo_link_title]" size="50" maxlength="255" value="<?php echo forum_htmlencode($forum_config[\'o_logo_link_title\']) ?>" /></span>
						</div>
					</div>
					<?
				}
				?>
			</fieldset>
						<div class="frm-buttons">
							<span class="submit primary"><input type="submit" name="save" value="<?php echo $lang_admin_common[\'Save changes\'] ?>" /></span>
						</div>
					</form>
				</div><?
}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ca_fn_generate_admin_menu_new_sublink' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

require $ext_info[\'path\'].\'/url.php\';
			if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
				require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
			else
				require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';

			if ((FORUM_PAGE_SECTION == \'management\') && ($forum_user[\'g_id\'] == FORUM_ADMIN))
				$forum_page[\'admin_submenu\'][\'pun_attachment_management\'] = \'<li class="\'.((FORUM_PAGE == \'admin-attachment-manage\') ? \'active\' : \'normal\').((empty($forum_page[\'admin_menu\'])) ? \' first-item\' : \'\').\'"><a href="\'.forum_link($attach_url[\'admin_attachment_manage\']).\'">\'.$lang_attach[\'Attachment\'].\'</a></li>\';
			if ((FORUM_PAGE_SECTION == \'settings\') && ($forum_user[\'g_id\'] == FORUM_ADMIN))
				$forum_page[\'admin_submenu\'][\'pun_attachment_settings\'] = \'<li class="\'.((FORUM_PAGE == \'admin-options-attach\') ? \'active\' : \'normal\').((empty($forum_page[\'admin_menu\'])) ? \' first-item\' : \'\').\'"><a href="\'.forum_link($attach_url[\'admin_options_attach\']).\'">\'.$lang_attach[\'Attachment\'].\'</a></li>\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
				require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
			else
				require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
			require $ext_info[\'path\'].\'/pun_tags_url.php\';

			if ((FORUM_PAGE_SECTION == \'management\') && ($forum_user[\'g_id\'] == FORUM_ADMIN))
				$forum_page[\'admin_submenu\'][\'pun_tags_management\'] = \'<li class="\'.((FORUM_PAGE == \'admin-management-manage_tags\') ? \'active\' : \'normal\').((empty($forum_page[\'admin_menu\'])) ? \' first-item\' : \'\').\'"><a href="\'.forum_link($pun_tags_url[\'Section pun_tags\']).\'">\'.$lang_pun_tags[\'Section tags\'].\'</a></li>\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    2 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'logo\',
\'path\'			=> FORUM_ROOT.\'extensions/logo\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/logo\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!isset($logo))
{	
	if ($forum_user[\'language\'] != \'English\' && file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/lang.php\'))
	{
		require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/lang.php\';
	}
	else
	{
		require $ext_info[\'path\'].\'/lang/English/lang.php\';
	}
}

$forum_url[\'admin_settings_logo\'] = \'admin/settings.php?section=logo\';

if (FORUM_PAGE_SECTION == \'settings\')
	{
		$forum_page[\'admin_submenu\'][\'settings-logo\'] = \'<li class="\'.((FORUM_PAGE == \'admin-settings-logo\') ? \'active\' : \'normal\').((empty($forum_page[\'admin_submenu\'])) ? \' first-item\' : \'\').\'"><a href="\'.forum_link($forum_url[\'admin_settings_logo\']).\'">\'.$logo[\'logo\'].\'</a></li>\';
	}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'aop_pre_update_configuration' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($section == \'pun_attach\')
			{
				while (list($key, $input) = @each($form))
				{
					if ($forum_config[\'attach_\'.$key] != $input)
					{
						if ($input != \'\' || is_int($input))
							$value = \'\\\'\'.$forum_db->escape($input).\'\\\'\';
						else
							$value = \'NULL\';

						$query = array(
							\'UPDATE\'	=> \'config\',
							\'SET\'		=> \'conf_value=\'.$value,
							\'WHERE\'		=> \'conf_name=\\\'attach_\'.$key.\'\\\'\'
						);

						$forum_db->query_build($query) or error(__FILE__,__LINE__);
					}
				}

				require_once FORUM_ROOT.\'include/cache.php\';
				generate_config_cache();

				redirect(forum_link($attach_url[\'admin_options_attach\']), $lang_admin_settings[\'Settings updated\'].\' \'.$lang_admin_common[\'Redirect\']);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'logo\',
\'path\'			=> FORUM_ROOT.\'extensions/logo\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/logo\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

switch ($section)
	{
		case \'logo\':
		{
	
	if($_FILES[\'logo_src\'][\'tmp_name\'])
		{
			$file=$_FILES[\'logo_src\'];
			$allow = array(
				\'types\' => array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF),
				\'mime_types\' => array(\'image/gif\', \'image/jpeg\', \'image/pjpeg\', \'image/png\', \'image/x-png\'),
				\'max_width\' => \'1000\',
				\'max_height\' => \'200\');

		if(getimagesize($file[\'tmp_name\']) && in_array($file[\'type\'], $allow[\'mime_types\']))
			{
				list($file[\'width\'],$file[\'height\'],$file[\'image_type\'])=getimagesize($file[\'tmp_name\']);



				if($file[\'width\']<=$allow[\'max_width\'] && $file[\'height\']<=$allow[\'max_height\'] && in_array($file[\'image_type\'],$allow[\'types\']))
							{
								$pos = strrpos($file[\'name\'], \'.\'); 
								$basename = substr($file[\'name\'], 0, $pos); 
								$ext = strtolower(substr($file[\'name\'], $pos+1));
								if ($forum_config[\'o_logo_src\'] != \'0\')
									@unlink(\'..\'.$forum_config[\'o_logo_src\']);
								if(!@rename($file[\'tmp_name\'], \'../img/logo.\'.$ext))
									{
										message($logo[\'error_chmod\']);
									}
								
								else
									{
								$form[\'logo_src\']=\'/img/logo.\'.$ext;
								@chmod(\'..\'.$forum_config[\'o_logo_src\'], 0644);
								$form[\'logo_width\']=$file[\'width\'];
								$form[\'logo_height\']=$file[\'height\'];
									}
							}
							else message($logo[\'error_format\']);
					}
					else message($logo[\'error_mime_type\']);
		}
		$forum_url[\'admin_settings_logo\'] = \'admin/settings.php?section=logo\';
		
		if($forum_config[\'o_logo_src\'] == \'0\') $form[\'logo_enable\'] = \'0\';
		if (!isset($form[\'logo_enable\']) || $form[\'logo_enable\'] != \'1\') $form[\'logo_enable\'] = \'0\';
		if (!isset($form[\'logo_hide_forum_title\']) || $form[\'logo_hide_forum_title\'] != \'1\') $form[\'logo_hide_forum_title\'] = \'0\';
}

default:
{
	break;
}
}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'aop_pre_redirect' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($section == \'pun_attach\')
			{
				redirect(forum_link($attach_url[\'admin_options_attach\']), $lang_admin_settings[\'Settings updated\'].\' \'.$lang_admin_common[\'Redirect\']);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'aop_new_section_validation' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($section == \'pun_attach\')
{
	if (!isset($form[\'use_icon\']) || $form[\'use_icon\'] != \'1\') $form[\'use_icon\'] = \'0\';
	if (!isset($form[\'create_orphans\']) || $form[\'create_orphans\'] != \'1\') $form[\'create_orphans\'] = \'0\';
	if (!isset($form[\'disable_attach\']) || $form[\'disable_attach\'] != \'1\') $form[\'disable_attach\'] = \'0\';
	if (!isset($form[\'disp_small\']) || $form[\'disp_small\'] != \'1\') $form[\'disp_small\'] = \'0\';

	if ($form[\'always_deny\'])
	{
		$form[\'always_deny\'] = preg_replace(\'/\\s/\',\'\',$form[\'always_deny\']);
		$match = preg_match(\'/(^[a-zA-Z0-9])+(([a-zA-Z0-9]+\\,)|([a-zA-Z0-9]))+([a-zA-Z0-9]+$)/\',$form[\'always_deny\']);

		if (!$match)
			message($lang_attach[\'Wrong deny\']);
	}

	if (preg_match(\'/^[0-9]+$/\', $form[\'small_height\']))
		$form[\'small_height\'] = intval($form[\'small_height\']);
	else
		$form[\'small_height\'] = $forum_config[\'attach_small_height\'];

	if (preg_match(\'/^[0-9]+$/\',$form[\'small_width\']))
		$form[\'small_width\'] = intval($form[\'small_width\']);
	else
		$form[\'small_width\'] = $forum_config[\'attach_small_width\'];

	$names = explode(\',\', $forum_config[\'attach_icon_name\']);
	$icons = explode(\',\', $forum_config[\'attach_icon_extension\']);

	$num_icons = count($icons);
	for ($i = 0; $i < $num_icons; $i++)
	{
		if (!empty($_POST[\'attach_ext_\'.$i]) && !empty($_POST[\'attach_ico_\'.$i]))
		{
			if (!preg_match("/^[a-zA-Z0-9]+$/", forum_trim($_POST[\'attach_ext_\'.$i])) && !preg_match("/^([a-zA-Z0-9]+\\.+(png|gif|jpeg|jpg|ico))+$/", forum_trim($_POST[\'attach_ico_\'.$i])))
				message($lang_attach[\'Wrong icon/name\']);

			$icons[$i] = trim($_POST[\'attach_ext_\'.$i]);
			$names[$i] = trim($_POST[\'attach_ico_\'.$i]);
		}
	}

	if (isset($_POST[\'add_field_icon\']) && isset($_POST[\'add_field_file\']))
	{
		if (!empty($_POST[\'add_field_icon\']) && !empty($_POST[\'add_field_file\']))
		{
			if (!(preg_match("/^[a-zA-Z0-9]+$/",trim($_POST[\'add_field_icon\'])) && preg_match("/^([a-zA-Z0-9]+\\.+(png|gif|jpeg|jpg|ico))+$/",trim($_POST[\'add_field_file\']))))
				message ($lang_attach[\'Wrong icon/name\']);

			$icons[] = trim($_POST[\'add_field_icon\']);
			$names[] = trim($_POST[\'add_field_file\']);
		}
	}

	$icons = implode(\',\', $icons);
	$icons = preg_replace(\'/\\,{2,}/\',\',\',$icons);
	$icons = preg_replace(\'/\\,{1,}+$/\',\'\',$icons);

	$names = implode(\',\', $names);
	$names = preg_replace(\'/\\,{2,}/\',\',\',$names);
	$names = preg_replace(\'/\\,{1,}+$/\',\'\',$names);

	$query = array(
		\'UPDATE\'	=> \'config\',
		\'SET\'		=> \'conf_value=\\\'\'.$forum_db->escape($icons).\'\\\'\',
		\'WHERE\'		=> \'conf_name = \\\'attach_icon_extension\\\'\'
	);
	$result = $forum_db->query_build($query) or error (__FILE__, __LINE__);

	$query = array(
		\'UPDATE\'	=> \'config\',
		\'SET\'		=> \'conf_value=\\\'\'.$forum_db->escape($names).\'\\\'\',
		\'WHERE\'		=> \'conf_name=\\\'attach_icon_name\\\'\'
	);
	$result = $forum_db->query_build($query) or error (__FILE__, __LINE__);
	}

	if ($section == \'list_attach\')
	{
	$query = array(
		\'SELECT\'	=> \'COUNT(id) AS num_attach\',
		\'FROM\'		=> \'attach_files\'
	);

	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	$num_attach = $forum_db->fetch_assoc($result);

	if (!is_null($num_attach) && $num_attach !== false)
	{
		for ($i = 0; $i < $num_attach[\'num_attach\']; $i++)
		{
			if (isset($_POST[\'attach_\'.$i]))
			{
				if (isset($_POST[\'attach_to_post_\'.$i]) && !empty($_POST[\'attach_to_post_\'.$i]))
				{
					$post_id = intval($_POST[\'attach_to_post_\'.$i]);
					$attach_id = intval($_POST[\'attachment_\'.$i]);
					$query = array(
						\'SELECT\'	=> \'id, topic_id, poster_id\',
						\'FROM\'		=> \'posts\',
						\'WHERE\'		=> \'id=\'.$post_id
					);
					$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

					$info = $forum_db->fetch_assoc($result);
					if (is_null($info) || $info === false)
						message ($lang_attach[\'Wrong post\']);

					$query = array(
						\'UPDATE\'	=> \'attach_files\',
						\'SET\'		=> \'post_id=\'.intval($info[\'id\']).\', topic_id=\'.intval($info[\'topic_id\']).\', owner_id=\'.intval($info[\'poster_id\']),
						\'WHERE\'		=> \'id=\'.$attach_id
					);
					$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

					redirect(forum_link($attach_url[\'admin_attachment_manage\']), $lang_attach[\'Attachment added\']);
				}
				else
					message ($lang_attach[\'Wrong post\']);
			}
		}
	}
}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'mi_new_action' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($action == \'pun_attachment\' && !$forum_config[\'attach_disable_attach\'] && isset($_GET[\'item\']))
			{
				$attach_item = intval($_GET[\'item\']);
				if ($attach_item < 1)
					message($lang_common[\'Bad request\']);

				if (isset($_GET[\'secure_str\']))
				{
					preg_match(\'~(\\d+)f(\\d+)~\', $_GET[\'secure_str\'], $match);
					if (isset($match[0]))
					{
						$query = array(
							\'SELECT\'	=>	\'a.id, a.post_id, a.topic_id, a.owner_id, a.filename, a.file_ext, a.file_mime_type, a.size, a.file_path, a.secure_str\',
							\'FROM\'		=>	\'attach_files AS a\',
							\'JOINS\'		=>	array(
								array(
									\'INNER JOIN\' => \'forums AS f\',
									\'ON\'		=> \'f.id = \'.$match[2]
								),
								array(
									\'LEFT JOIN\'	=> \'forum_perms AS fp\',
									\'ON\'		=> \'(fp.forum_id = f.id AND fp.group_id = \'.$forum_user[\'g_id\'].\')\'
								)
							),
							\'WHERE\'		=> \'a.id = \'.$attach_item.\' AND (fp.read_forum IS NULL OR fp.read_forum = 1) AND secure_str = \\\'\'.$match[0].\'\\\'\'
						);
					}
					else
					{
						preg_match(\'~(\\d+)t(\\d+)~\', $_GET[\'secure_str\'], $match);
						if (isset($match[0]))
						{
							$query = array(
								\'SELECT\'	=>	\'a.id, a.post_id, a.topic_id, a.owner_id, a.filename, a.file_ext, a.file_mime_type, a.size, a.file_path, a.secure_str\',
								\'FROM\'		=>	\'attach_files AS a\',
								\'JOINS\'		=>	array(
									array(
										\'INNER JOIN\'	=> \'topics AS t\',
										\'ON\'		=> \'t.id = \'.$match[2]
									),
									array(
										\'INNER JOIN\'	=> \'forums AS f\',
										\'ON\'		=> \'f.id = t.forum_id\'
									),
									array(
										\'LEFT JOIN\'		=> \'forum_perms AS fp\',
										\'ON\'		=> \'(fp.forum_id = f.id AND fp.group_id = \'.$forum_user[\'g_id\'].\')\'
									)
								),
								\'WHERE\'		=> \'a.id = \'.$attach_item.\' AND (fp.read_forum IS NULL OR fp.read_forum = 1) AND secure_str = \\\'\'.$match[0].\'\\\'\'
							);
						}
						else
							message($lang_common[\'Bad request\']);
					}
					if ($forum_user[\'id\'] != $match[1])
						message($lang_common[\'Bad request\']);
				} else {
					$query = array(
						\'SELECT\'	=> \'a.id, a.post_id, a.topic_id, a.owner_id, a.filename, a.file_ext, a.file_mime_type, a.size, a.file_path, a.secure_str\',
						\'FROM\'		=> \'attach_files AS a\',
						\'JOINS\'		=> array(
							array(
								\'INNER JOIN\'	=> \'topics AS t\',
								\'ON\'			=> \'t.id = a.topic_id\'
							),
							array(
								\'INNER JOIN\'	=> \'forums AS f\',
								\'ON\'			=> \'f.id = t.forum_id\'
							),
							array(
								\'LEFT JOIN\'		=> \'forum_perms AS fp\',
								\'ON\'			=> \'(fp.forum_id = f.id AND fp.group_id = \'.$forum_user[\'g_id\'].\')\'
							)
						),
						\'WHERE\'		=> \'a.id = \'.$attach_item.\' AND (fp.read_forum IS NULL OR fp.read_forum = 1)\'
					);
				}

				$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
				$attach_info = $forum_db->fetch_assoc($result);

				if (!$attach_info)
					message($lang_common[\'Bad request\']);

				$query = array(
					\'SELECT\'	=> \'g_pun_attachment_allow_download\',
					\'FROM\'		=> \'groups\',
					\'WHERE\'		=> \'g_id = \'.$forum_user[\'group_id\']
				);
				$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
				$perms = $forum_db->fetch_assoc($result);

				if (!$perms) {
					message($lang_common[\'No permission\']);
				}

				if ($forum_user[\'g_id\'] != FORUM_ADMIN && !$perms[\'g_pun_attachment_allow_download\']) {
					message($lang_common[\'No permission\']);
				}

				if (isset($_GET[\'preview\']) && in_array($attach_info[\'file_ext\'], array(\'png\', \'jpg\', \'gif\', \'tiff\')))
				{
					if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
						require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
					else
						require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
					require $ext_info[\'path\'].\'/url.php\';

					$forum_page = array();
					$forum_page[\'download_link\'] = !empty($attach_info[\'secure_str\']) ? forum_link($attach_url[\'misc_download_secure\'], array($attach_item, $attach_info[\'secure_str\'])) : forum_link($attach_url[\'misc_download\'], $attach_item);
					$forum_page[\'view_link\'] = !empty($attach_info[\'secure_str\']) ? forum_link($attach_url[\'misc_view_secure\'], array($attach_item, $attach_info[\'secure_str\'])) : forum_link($attach_url[\'misc_view\'], $attach_info[\'id\']);

					// Setup breadcrumbs
					$forum_page[\'crumbs\'] = array(
						array($forum_config[\'o_board_title\'], forum_link($forum_url[\'index\'])),
						$lang_attach[\'Image preview\']
					);

					define(\'FORUM_PAGE\', \'attachment-preview\');
					require FORUM_ROOT.\'header.php\';

					// START SUBST - <!-- forum_main -->
					ob_start();

					?>
					<div class="main-head">
						<h2 class="hn"><span><?php echo $lang_attach[\'Image preview\']; ?></span></h2>
					</div>

					<div class="main-content main-frm">
						<div class="content-head">
							<h2 class="hn"><span><?php echo $attach_info[\'filename\']; ?></span></h2>
						</div>
						<fieldset class="frm-group group1">
							<span class="show-image"><img src="<?php echo $forum_page[\'view_link\']; ?>" alt="<?php echo forum_htmlencode($attach_info[\'filename\']); ?>" /></span>
							<p><?php echo $lang_attach[\'Download:\']; ?> <a href="<?php echo $forum_page[\'download_link\']; ?>"><?php echo forum_htmlencode($attach_info[\'filename\']); ?></a></p>
						</fieldset>
					</div>
					<?php

					$tpl_temp = trim(ob_get_contents());
					$tpl_main = str_replace(\'<!-- forum_main -->\', $tpl_temp, $tpl_main);
					ob_end_clean();
					// END SUBST - <!-- forum_main -->

					require FORUM_ROOT.\'footer.php\';
				}
				else
				{
					$fp = fopen($forum_config[\'attach_basefolder\'].$attach_info[\'file_path\'], \'rb\');

					if (!$fp)
						message($lang_common[\'Bad request\']);
					else
					{
						header(\'Content-Disposition: attachment; filename="\'.$attach_info[\'filename\'].\'"\');
						header(\'Content-Type: \'.$attach_info[\'file_mime_type\']);
						header(\'Pragma: no-cache\');
						header(\'Expires: 0\');
						header(\'Connection: close\');
						header(\'Content-Length: \'.$attach_info[\'size\']);

						fpassthru($fp);

						if (isset($_GET[\'download\']) && intval($_GET[\'download\']) == 1) {
							$query = array(
								\'UPDATE\'	=> \'attach_files\',
								\'SET\'		=> \'download_counter=download_counter+1\',
								\'WHERE\'		=> \'id=\'.$attach_item
							);
							$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
						}


						// End the transaction
						$forum_db->end_transaction();

						// Close the db connection (and free up any result data)
						$forum_db->close();

						exit();
					}
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_pm\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_pm\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_pm\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($action == \'pun_pm_send\' && !$forum_user[\'is_guest\'])
{
	if(!defined(\'PUN_PM_FUNCTIONS_LOADED\'))
		require $ext_info[\'path\'].\'/functions.php\';

	if (!isset($lang_pun_pm))
	{
		if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
			include $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
		else
			include $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
	}

	$pun_pm_body = isset($_POST[\'req_message\']) ? $_POST[\'req_message\'] : \'\';
	$pun_pm_subject = isset($_POST[\'pm_subject\']) ? $_POST[\'pm_subject\'] : \'\';
	$pun_pm_receiver_username = isset($_POST[\'pm_receiver\']) ? $_POST[\'pm_receiver\'] : \'\';
	$pun_pm_message_id = isset($_POST[\'message_id\']) ? (int) $_POST[\'message_id\'] : false;

	if (isset($_POST[\'send_action\']) && in_array($_POST[\'send_action\'], array(\'send\', \'draft\', \'delete\', \'preview\')))
		$pun_pm_send_action = $_POST[\'send_action\'];
	elseif (isset($_POST[\'pm_draft\']))
		$pun_pm_send_action = \'draft\';
	elseif (isset($_POST[\'pm_send\']))
		$pun_pm_send_action = \'send\';
	elseif (isset($_POST[\'pm_delete\']))
		$pun_pm_send_action = \'delete\';
	else
		$pun_pm_send_action = \'preview\';

	($hook = get_hook(\'pun_pm_after_send_action_set\')) ? eval($hook) : null;

	if ($pun_pm_send_action == \'draft\')
	{
		// Try to save the message as draft
		// Inside this function will be a redirect, if everything is ok
		$pun_pm_errors = pun_pm_save_message($pun_pm_body, $pun_pm_subject, $pun_pm_receiver_username, $pun_pm_message_id);
		// Remember $pun_pm_message_id = false; inside this function if $pun_pm_message_id is incorrect

		// Well... Go processing errors

		// We need no preview
		$pun_pm_msg_preview = false;
	}
	elseif ($pun_pm_send_action == \'send\')
	{
		// Try to send the message
		// Inside this function will be a redirect, if everything is ok
		$pun_pm_errors = pun_pm_send_message($pun_pm_body, $pun_pm_subject, $pun_pm_receiver_username, $pun_pm_message_id);
		// Remember $pun_pm_message_id = false; inside this function if $pun_pm_message_id is incorrect

		// Well... Go processing errors

		// We need no preview
		$pun_pm_msg_preview = false;
	}
	elseif ($pun_pm_send_action == \'delete\' && $pun_pm_message_id !== false)
	{
		pun_pm_delete_from_outbox(array($pun_pm_message_id));
		redirect(forum_link($forum_url[\'pun_pm_outbox\']), $lang_pun_pm[\'Message deleted\']);
	}
	elseif ($pun_pm_send_action == \'preview\')
	{
		// Preview message
		$pun_pm_errors = array();
		$pun_pm_msg_preview = pun_pm_preview($pun_pm_receiver_username, $pun_pm_subject, $pun_pm_body, $pun_pm_errors);
	}

	($hook = get_hook(\'pun_pm_new_send_action\')) ? eval($hook) : null;

	$pun_pm_page_text = pun_pm_send_form($pun_pm_receiver_username, $pun_pm_subject, $pun_pm_body, $pun_pm_message_id, false, false, $pun_pm_msg_preview);

	// Setup navigation menu
	$forum_page[\'main_menu\'] = array(
		\'inbox\'		=> \'<li class="first-item"><a href="\'.forum_link($forum_url[\'pun_pm_inbox\']).\'"><span>\'.$lang_pun_pm[\'Inbox\'].\'</span></a></li>\',
		\'outbox\'	=> \'<li><a href="\'.forum_link($forum_url[\'pun_pm_outbox\']).\'"><span>\'.$lang_pun_pm[\'Outbox\'].\'</span></a></li>\',
		\'write\'		=> \'<li class="active"><a href="\'.forum_link($forum_url[\'pun_pm_write\']).\'"><span>\'.$lang_pun_pm[\'Compose message\'].\'</span></a></li>\',
	);

	// Setup breadcrumbs
	$forum_page[\'crumbs\'] = array(
		array($forum_config[\'o_board_title\'], forum_link($forum_url[\'index\'])),
		array($lang_pun_pm[\'Private messages\'], forum_link($forum_url[\'pun_pm\'])),
		array($lang_pun_pm[\'Compose message\'], forum_link($forum_url[\'pun_pm_write\']))
	);

	($hook = get_hook(\'pun_pm_pre_send_output\')) ? eval($hook) : null;

	define(\'FORUM_PAGE\', \'pun_pm-write\');
	require FORUM_ROOT.\'header.php\';

	// START SUBST - <!-- forum_main -->
	ob_start();

	echo $pun_pm_page_text;

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace(\'<!-- forum_main -->\', $tpl_temp, $tpl_main);
	ob_end_clean();
	// END SUBST - <!-- forum_main -->

	require FORUM_ROOT.\'footer.php\';
}

$section = isset($_GET[\'section\']) ? $_GET[\'section\'] : null;

if ($section == \'pun_pm\' && !$forum_user[\'is_guest\'])
{
	if (!isset($lang_pun_pm))
	{
		if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
			include $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
		else
			include $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
	}

	if (!defined(\'PUN_PM_FUNCTIONS_LOADED\'))
		require $ext_info[\'path\'].\'/functions.php\';

	$pun_pm_page = isset($_GET[\'pmpage\']) ? $_GET[\'pmpage\'] : \'\';

	($hook = get_hook(\'pun_pm_pre_page_building\')) ? eval($hook) : null;

	// pun_pm_get_page() performs everything :)
	// Remember $pun_pm_page correction inside pun_pm_get_page() if this variable is incorrect
	$pun_pm_page_text = pun_pm_get_page($pun_pm_page);

	// Setup navigation menu
	$forum_page[\'main_menu\'] = array(
		\'inbox\'		=> \'<li class="first-item\'.($pun_pm_page == \'inbox\' ? \' active\' : \'\').\'"><a href="\'.forum_link($forum_url[\'pun_pm_inbox\']).\'"><span>\'.$lang_pun_pm[\'Inbox\'].\'</span></a></li>\',
		\'outbox\'	=> \'<li\'.(($pun_pm_page == \'outbox\') ? \' class="active"\' : \'\').\'><a href="\'.forum_link($forum_url[\'pun_pm_outbox\']).\'"><span>\'.$lang_pun_pm[\'Outbox\'].\'</span></a></li>\',
		\'write\'		=> \'<li\'.(($pun_pm_page == \'write\' || $pun_pm_page == \'compose\') ? \' class="active"\' : \'\').\'><a href="\'.forum_link($forum_url[\'pun_pm_write\']).\'"><span>\'.$lang_pun_pm[\'Compose message\'].\'</span></a></li>\',
	);

	// Setup breadcrumbs
	$forum_page[\'crumbs\'] = array(
		array($forum_config[\'o_board_title\'], forum_link($forum_url[\'index\'])),
		array($lang_pun_pm[\'Private messages\'], forum_link($forum_url[\'pun_pm\']))
	);

	if ($pun_pm_page == \'inbox\')
		$forum_page[\'crumbs\'][] = array($lang_pun_pm[\'Inbox\'], forum_link($forum_url[\'pun_pm_inbox\']));
	else if ($pun_pm_page == \'outbox\')
		$forum_page[\'crumbs\'][] = array($lang_pun_pm[\'Outbox\'], forum_link($forum_url[\'pun_pm_outbox\']));
	else if ($pun_pm_page == \'write\' || $pun_pm_page == \'compose\')
		$forum_page[\'crumbs\'][] = array($lang_pun_pm[\'Compose message\'], forum_link($forum_url[\'pun_pm_write\']));

	($hook = get_hook(\'pun_pm_pre_page_output\')) ? eval($hook) : null;

	define(\'FORUM_PAGE\', \'pun_pm-\'.$pun_pm_page);
	require FORUM_ROOT.\'header.php\';

	// START SUBST - <!-- forum_main -->
	ob_start();

	echo $pun_pm_page_text;

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace(\'<!-- forum_main -->\', $tpl_temp, $tpl_main);
	ob_end_clean();
	// END SUBST - <!-- forum_main -->

	require FORUM_ROOT.\'footer.php\';
}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'dl_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

require $ext_info[\'path\'].\'/include/attach_func.php\';
			if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
				require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
			else
				require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'mr_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

require $ext_info[\'path\'].\'/include/attach_func.php\';
			if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
				require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
			else
				require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_move_posts\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_move_posts\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_move_posts\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($forum_user[\'language\'] != \'English\' && file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
				require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
			else
				require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'dl_qr_get_post_info' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				$query[\'SELECT\'] .= \', g_pun_attachment_allow_upload, g_pun_attachment_upload_max_size, g_pun_attachment_files_per_post, g_pun_attachment_disallowed_extensions, g_pun_attachment_allow_delete_own, g_pun_attachment_allow_delete\';
				$query[\'JOINS\'][] = array(\'LEFT JOIN\' => \'groups AS g\', \'ON\' => \'g.g_id = \'.$forum_user[\'g_id\']);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'dl_form_submitted' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				$attach_query = array(
					\'SELECT\'	=>	\'id, file_path, owner_id\',
					\'FROM\'		=>	\'attach_files\'
				);
				$attach_query[\'WHERE\'] = $cur_post[\'is_topic\'] ? \'post_id != 0 AND topic_id = \'.$cur_post[\'tid\'] : \'post_id = \'.$id;
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'dl_topic_deleted_pre_redirect' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				remove_attachments($attach_query, $cur_post);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'dl_post_deleted_pre_redirect' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				remove_attachments($attach_query, $cur_post);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'mr_qr_get_forum_data' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				$query[\'SELECT\'] .= \', g_pun_attachment_allow_upload, g_pun_attachment_upload_max_size, g_pun_attachment_files_per_post, g_pun_attachment_disallowed_extensions, g_pun_attachment_allow_delete_own, g_pun_attachment_allow_delete\';
				$query[\'JOINS\'][] = array(\'LEFT JOIN\' => \'groups AS g\', \'ON\' => \'g.g_id = \'.$forum_user[\'g_id\']);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (isset($_POST[\'merge_topics\']) || isset($_POST[\'merge_topics_comply\']))
			{
				$poll_topics = isset($_POST[\'topics\']) && !empty($_POST[\'topics\']) ? $_POST[\'topics\'] : array();
				$poll_topics = array_map(\'intval\', (is_array($poll_topics) ? $poll_topics : explode(\',\', $poll_topics)));

				if (empty($poll_topics))
					message($lang_misc[\'No topics selected\']);

				if (count($poll_topics) == 1)
					message($lang_misc[\'Merge error\']);

				$query_poll = array(
					\'SELECT\'	=>	\'topic_id\',
					\'FROM\'		=>	\'questions\',
					\'WHERE\'		=>	\'topic_id IN(\'.implode(\',\', $poll_topics).\')\'
				);
				$result_pun_poll = $forum_db->query_build($query_poll) or error(__FILE__, __LINE__);

				$polls = array();
				while ($row = $forum_db->fetch_assoc($result_pun_poll)) {
					$polls[] = $row[\'topic_id\'];
				}

				if (count($polls) > 1) {
					if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
						include_once $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
					else
						include_once $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';

					message($lang_pun_poll[\'Merge error\']);
				} else if (count($polls) === 1) {
					$question_id = $polls[0];
				}

				unset($num_polls, $polls);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'mr_confirm_delete_posts_pre_redirect' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				$attach_query = array(
					\'SELECT\'	=>	\'id, file_path, owner_id\',
					\'FROM\'		=>	\'attach_files\',
					\'WHERE\'		=>	isset($posts) ? \'post_id IN(\'.implode(\',\', $posts).\')\' : \'topic_id IN(\'.implode(\',\', $topics).\')\'
				);
				$forum_page[\'is_admmod\'] = true;
				remove_attachments($attach_query, $cur_forum);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_karma\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_karma\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_karma\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!empty($posts))
{
	$query = array(
		\'DELETE\'	=>	\'pun_karma\',
		\'WHERE\'		=>	\'post_id IN(\'.implode(\',\', $posts).\')\'
	);
	$forum_db->query_build($query) or error(__FILE__, __LINE__);
}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'mr_confirm_delete_topics_pre_redirect' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_config[\'attach_disable_attach\'])
			{
				$attach_query = array(
					\'SELECT\'	=>	\'id, file_path, owner_id\',
					\'FROM\'		=>	\'attach_files\',
					\'WHERE\'		=>	isset($posts) ? \'post_id IN(\'.implode(\',\', $posts).\')\' : \'topic_id IN(\'.implode(\',\', $topics).\')\'
				);
				$forum_page[\'is_admmod\'] = true;
				remove_attachments($attach_query, $cur_forum);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

pun_tags_remove_orphans();
			pun_tags_generate_cache();

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    2 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_karma\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_karma\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_karma\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!empty($post_ids))
{
	$query = array(
		\'DELETE\'	=>	\'pun_karma\',
		\'WHERE\'		=>	\'post_id IN(\'.implode(\',\', $post_ids).\')\'
	);
	$forum_db->query_build($query) or error(__FILE__, __LINE__);
}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'mr_confirm_split_posts_pre_redirect' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$attach_query = array(
				\'UPDATE\'	=>	\'attach_files\',
				\'SET\'		=>	\'topic_id=\'.$new_tid,
				\'WHERE\'		=>	\'post_id IN (\'.implode(\',\', $posts).\')\'
			);
			$forum_db->query_build($attach_query) or error(__FILE__, __LINE__);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!empty($new_tags) && $forum_user[\'g_pun_tags_allow\'])
			{
				foreach ($new_tags as $pun_tag)
					pun_tags_add_new($pun_tag, $new_tid);
				pun_tags_generate_cache();
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'mr_confirm_merge_topics_pre_redirect' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_attachment\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_attachment\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_attachment\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$attach_query = array(
				\'UPDATE\'	=>	\'attach_files\',
				\'SET\'		=>	\'topic_id=\'.$merge_to_tid,
				\'WHERE\'		=>	\'topic_id IN(\'.implode(\',\', $topics).\')\'
			);
			$forum_db->query_build($attach_query) or error(__FILE__, __LINE__);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (isset($question_id) && $question_id != $merge_to_tid)
			{
				$query_poll = array(
					\'UPDATE\'	=>	\'questions\',
					\'SET\'		=>	\'topic_id = \'.$merge_to_tid,
					\'WHERE\'		=>	\'topic_id = \'.$question_id
				);
				$forum_db->query_build($query) or error(__FILE__, __LINE__);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    2 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$query = array(
				\'UPDATE\'	=>	\'topic_tags\',
				\'SET\'		=>	\'topic_id = \'.$merge_to_tid,
				\'WHERE\'		=>	\'topic_id IN(\'.implode(\',\', $topics).\') AND topic_id != \'.$merge_to_tid
			);
			$forum_db->query_build($query) or error(__FILE__, __LINE__);
			pun_tags_generate_cache();

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'pf_change_details_settings_validation' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_pm\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_pm\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_pm\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

// Validate option \'quote beginning of message\'
			if (!isset($_POST[\'form\'][\'pun_pm_long_subject\']) || $_POST[\'form\'][\'pun_pm_long_subject\'] != \'1\')
				$form[\'pun_pm_long_subject\'] = \'0\';
			else
				$form[\'pun_pm_long_subject\'] = \'1\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_bbcode\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_bbcode\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_bbcode\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$form[\'pun_bbcode_enabled\'] = (!isset($_POST[\'form\'][\'pun_bbcode_enabled\']) || $_POST[\'form\'][\'pun_bbcode_enabled\'] != \'1\') ? \'0\' : \'1\';
			$form[\'pun_bbcode_use_buttons\'] = (!isset($_POST[\'form\'][\'pun_bbcode_use_buttons\']) || $_POST[\'form\'][\'pun_bbcode_use_buttons\'] != \'1\') ? \'0\' : \'1\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'pf_change_details_settings_email_fieldset_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_pm\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_pm\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_pm\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

// Per-user option \'quote beginning of message\'
if ($forum_config[\'p_message_bbcode\'] == \'1\')
{
	if (!isset($lang_pun_pm))
	{
		if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
			include $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
		else
			include $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
	}

	$forum_page[\'item_count\'] = 0;

?>
			<fieldset class="frm-group group<?php echo ++$forum_page[\'group_count\'] ?>">
				<legend class="group-legend"><strong><?php echo $lang_pun_pm[\'PM settings\'] ?></strong></legend>
				<fieldset class="mf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
					<legend><span><?php echo $lang_pun_pm[\'Private messages\'] ?></span></legend>
					<div class="mf-box">
						<div class="mf-item">
							<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="form[pun_pm_long_subject]" value="1"<?php if ($user[\'pun_pm_long_subject\'] == \'1\') echo \' checked="checked"\' ?> /></span>
							<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><?php echo $lang_pun_pm[\'Begin message quote\'] ?></label>
						</div>
					</div>
				</fieldset>
<?php ($hook = get_hook(\'pun_pm_pf_change_details_settings_pre_pm_settings_fieldset_end\')) ? eval($hook) : null; ?>
			</fieldset>
<?php
}
else
	echo "\\t\\t\\t".\'<input type="hidden" name="form[pun_pm_long_subject]" value="\'.$user[\'pun_pm_long_subject\'].\'" />\'."\\n";

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_bbcode\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_bbcode\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_bbcode\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
				include $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
			else
				include $ext_info[\'path\'].\'/lang/English/pun_bbcode.php\';

			$forum_page[\'item_count\'] = 0;
?>
				<fieldset class="frm-group group<?php echo ++$forum_page[\'group_count\'] ?>">
					<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
						<div class="sf-box checkbox">
							<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="form[pun_bbcode_enabled]" value="1"<?php if ($user[\'pun_bbcode_enabled\'] == \'1\') echo \' checked="checked"\' ?> /></span>
							<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><span><?php echo $lang_pun_bbcode[\'Pun BBCode Bar\'] ?></span> <?php echo $lang_pun_bbcode[\'Notice BBCode Bar\'] ?></label>
						</div>
					</div>
					<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
						<div class="sf-box checkbox">
							<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="form[pun_bbcode_use_buttons]" value="1"<?php if ($user[\'pun_bbcode_use_buttons\'] == \'1\') echo \' checked="checked"\' ?> /></span>
							<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><?php echo $lang_pun_bbcode[\'BBCode Graphical buttons\'] ?></label>
						</div>
					</div>
				</fieldset>
<?php

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'aop_features_avatars_fieldset_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_pm\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_pm\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_pm\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

// Admin options
if (!isset($lang_pun_pm))
{
	if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
		include $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
	else
		include $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
}

$forum_page[\'group_count\'] = $forum_page[\'item_count\'] = 0;

?>
			<div class="content-head">
				<h2 class="hn"><span><?php echo $lang_pun_pm[\'Features title\'] ?></span></h2>
			</div>
			<fieldset class="frm-group group<?php echo ++$forum_page[\'group_count\'] ?>">
				<legend class="group-legend"><span><?php echo $lang_pun_pm[\'PM settings\'] ?></span></legend>
				<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
					<div class="sf-box text">
						<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $lang_pun_pm[\'Inbox limit\'] ?></span><small><?php echo $lang_pun_pm[\'Inbox limit info\'] ?></small></label><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page[\'fld_count\'] ?>" name="form[pun_pm_inbox_size]" size="6" maxlength="6" value="<?php echo $forum_config[\'o_pun_pm_inbox_size\'] ?>" /></span>
					</div>
				</div>
				<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
					<div class="sf-box text">
						<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $lang_pun_pm[\'Outbox limit\'] ?></span><small><?php echo $lang_pun_pm[\'Outbox limit info\'] ?></small></label><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page[\'fld_count\'] ?>" name="form[pun_pm_outbox_size]" size="6" maxlength="6" value="<?php echo $forum_config[\'o_pun_pm_outbox_size\'] ?>" /></span>
					</div>
				</div>
				<fieldset class="mf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
					<legend><span><?php echo $lang_pun_pm[\'Navigation links\'] ?></span></legend>
					<div class="mf-box">
						<div class="mf-item">
							<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="form[pun_pm_show_new_count]" value="1"<?php if ($forum_config[\'o_pun_pm_show_new_count\'] == \'1\') echo \' checked="checked"\' ?> /></span>
							<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><?php echo $lang_pun_pm[\'Snow new count\'] ?></label>
						</div>
						<div class="mf-item">
							<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="form[pun_pm_show_global_link]" value="1"<?php if ($forum_config[\'o_pun_pm_show_global_link\'] == \'1\') echo \' checked="checked"\' ?> /></span>
							<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><?php echo $lang_pun_pm[\'Show global link\'] ?></label>
						</div>
					</div>
				</fieldset>
<?php ($hook = get_hook(\'pun_pm_aop_features_pre_pm_settings_fieldset_end\')) ? eval($hook) : null; ?>
			</fieldset>
<?php

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

?>
				<div class="content-head">
					<h2 class="hn"><span><?php echo $lang_pun_poll[\'Name plugin\'] ?></span></h2>
				</div>
				<fieldset class="frm-group group1">
					<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
						<div class="sf-box checkbox">
							<span class="fld-input">
								<input id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" type="checkbox" name="form[pun_poll_enable_revote]" value="1"<?php if ($forum_config[\'p_pun_poll_enable_revote\'] == \'1\') echo \' checked="checked"\' ?>/>
							</span>
							<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>">
								<span><?php echo $lang_pun_poll[\'Disable revoting info\'] ?></span>
								<?php echo $lang_pun_poll[\'Disable revoting\'] ?>
							</label>
						</div>
					</div>
					<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
						<div class="sf-box checkbox">
							<span class="fld-input">
								<input id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" type="checkbox" name="form[pun_poll_enable_read]" value="1"<?php if ($forum_config[\'p_pun_poll_enable_read\'] == \'1\') echo \' checked="checked"\' ?>/>
							</span>
							<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>">
								<span><?php echo $lang_pun_poll[\'Disable see results\'] ?></span>
								<?php echo $lang_pun_poll[\'Disable see results info\'] ?>
							</label>
						</div>
					</div>
					<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
						<div class="sf-box text">
							<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>">
								<span><?php echo $lang_pun_poll[\'Maximum answers info\'] ?></span>
								<small><?php echo $lang_pun_poll[\'Maximum answers\'] ?></small>
							</label>
							</br>
							<span class="fld-input">
								<input id="fld<?php echo $forum_page[\'fld_count\'] ?>" type="text" name="form[pun_poll_max_answers]" size="6" maxlength="6" value="<?php echo $forum_config[\'p_pun_poll_max_answers\'] ?>"/>
							</span>
						</div>
					</div>
				</fieldset>
			<?php

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    2 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

?>
			<div class="content-head">
				<h2 class="hn">
					<span><?php echo $lang_pun_tags[\'Pun Tags\']; ?></span>
				</h2>
			</div>
			<fieldset class="frm-group group1">
				<legend class="group-legend">
					<span><?php echo $lang_pun_tags[\'Settings\']; ?></span>
				</legend>
				<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
					<div class="sf-box checkbox">
						<span class="fld-input">
							<input id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" type="checkbox" <?php if ($forum_config[\'o_pun_tags_show\'] == \'1\') echo \' checked="checked"\' ?> value="1" name="form[pun_tags_show]"/>
						</span>
						<label for="fld<?php echo $forum_page[\'fld_count\'] ?>">
							<span><?php echo $lang_pun_tags[\'Show Pun Tags\']; ?></span>
							<?php echo $lang_pun_tags[\'Pun Tags notice\']; ?>
						</label>
					</div>
				</div>
				<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
					<div class="sf-box text">
						<span class="fld-input">
							<input id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" type="text" value="<?php echo $forum_config[\'o_pun_tags_count_in_cloud\']; ?>" maxlength="6" size="6" name="form[pun_tags_count_in_cloud]"/>
						</span>
						<label for="fld<?php echo $forum_page[\'fld_count\'] ?>">
							<span><?php echo $lang_pun_tags[\'Tags count\']; ?></span>
							<small><?php echo $lang_pun_tags[\'Tags count info\']; ?></small>
						</label>
					</div>
				</div>
				<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
					<div class="sf-box text">
						<span class="fld-input">
							<input id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" type="text" value="<?php echo $forum_config[\'o_pun_tags_separator\']; ?>" maxlength="10" size="6" name="form[pun_tags_separator]"/>
						</span>
						<label for="fld<?php echo $forum_page[\'fld_count\'] ?>">
							<span><?php echo $lang_pun_tags[\'Separator\']; ?></span>
							<small><?php echo $lang_pun_tags[\'Separator info\']; ?></small>
						</label>
					</div>
				</div>
			</fieldset>
			<?php

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    3 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_karma\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_karma\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_karma\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$forum_page[\'group_count\'] = $forum_page[\'item_count\'] = 0;

?>
<div class="content-head">
	<h2 class="hn"><span><?php echo $lang_pun_karma[\'Karma features\'] ?></span></h2>
</div>
<fieldset class="frm-group group<?php echo ++$forum_page[\'group_count\'] ?>">
	<legend class="group-legend"><span><?php echo $lang_pun_karma[\'Karma legend\'] ?></span></legend>
	<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
		<div class="sf-box checkbox">
			<span class="fld-input"><input type="checkbox" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="form[pun_karma_minus_cancel]" value="1"<?php if ($forum_config[\'o_pun_karma_minus_cancel\'] == \'1\') echo \' checked="checked"\' ?> /></span>
			<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><span><?php echo $lang_pun_karma[\'Disable minus\'] ?></span> <?php echo $lang_pun_karma[\'Disable minus info\'] ?></label>
		</div>
	</div>
	<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
		<div class="sf-box text">
			<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $lang_pun_karma[\'Plus interval\'] ?></span><small><?php echo $lang_pun_karma[\'Plus interval info\'] ?></small></label><br />
			<span class="fld-input"><input type="text" id="fld<?php echo $forum_page[\'fld_count\'] ?>" name="form[pun_karma_plus_interval]" size="6" maxlength="6" value="<?php echo $forum_config[\'o_pun_karma_plus_interval\'] ?>" /></span>
		</div>
	</div>
	<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
		<div class="sf-box text">
			<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $lang_pun_karma[\'Minus interval\'] ?></span><small><?php echo $lang_pun_karma[\'Minus interval info\'] ?></small></label><br />
			<span class="fld-input"><input type="text" id="fld<?php echo $forum_page[\'fld_count\'] ?>" name="form[pun_karma_minus_interval]" size="6" maxlength="6" value="<?php echo $forum_config[\'o_pun_karma_minus_interval\'] ?>" /></span>
		</div>
	</div>
</fieldset>
<?php

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'aop_features_validation' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_pm\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_pm\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_pm\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$form[\'pun_pm_inbox_size\'] = (!isset($form[\'pun_pm_inbox_size\']) || (int) $form[\'pun_pm_inbox_size\'] <= 0) ? \'0\' : (string)(int) $form[\'pun_pm_inbox_size\'];
			$form[\'pun_pm_outbox_size\'] = (!isset($form[\'pun_pm_outbox_size\']) || (int) $form[\'pun_pm_outbox_size\'] <= 0) ? \'0\' : (string)(int) $form[\'pun_pm_outbox_size\'];

			if (!isset($form[\'pun_pm_show_new_count\']) || $form[\'pun_pm_show_new_count\'] != \'1\')
				$form[\'pun_pm_show_new_count\'] = \'0\';

			if (!isset($form[\'pun_pm_show_global_link\']) || $form[\'pun_pm_show_global_link\'] != \'1\')
				$form[\'pun_pm_show_global_link\'] = \'0\';

			($hook = get_hook(\'pun_pm_aop_features_validation_end\')) ? eval($hook) : null;

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($forum_user[\'language\'] != \'English\' && file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
				include_once $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
			else
				include_once $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';


			if (!isset($form[\'pun_poll_enable_read\']) || $form[\'pun_poll_enable_read\'] != \'1\') $form[\'pun_poll_enable_read\'] = \'0\';
			if (!isset($form[\'pun_poll_enable_revote\']) || $form[\'pun_poll_enable_revote\'] != \'1\') $form[\'pun_poll_enable_revote\'] = \'0\';

			$form[\'pun_poll_max_answers\'] = intval($form[\'pun_poll_max_answers\']);

			if ($form[\'pun_poll_max_answers\'] > 100)
				$form[\'pun_poll_max_answers\'] = 100;

			if ($form[\'pun_poll_max_answers\'] < 2)
				$form[\'pun_poll_max_answers\'] = 2;

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    2 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!isset($form[\'pun_tags_show\']) || $form[\'pun_tags_show\'] != \'1\')
				$form[\'pun_tags_show\'] = \'0\';
			if (isset($form[\'pun_tags_count_in_cloud\']) && !empty($form[\'pun_tags_count_in_cloud\']) && intval($form[\'pun_tags_count_in_cloud\']) > 0)
				$form[\'pun_tags_count_in_cloud\'] = intval($form[\'pun_tags_count_in_cloud\']);
			else
				$form[\'pun_tags_count_in_cloud\'] = 25;
			if (isset($form[\'pun_tags_separator\']) && !empty($form[\'pun_tags_separator\']))
				$form[\'pun_tags_separator\'] = $form[\'pun_tags_separator\'];
			else
				$form[\'pun_tags_separator\'] = \' \';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    3 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_jquery\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_jquery\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_jquery\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (isset($form[\'pun_jquery_include_method\']))
			{
				$form[\'pun_jquery_include_method\'] = intval($form[\'pun_jquery_include_method\'], 10);
				if (($form[\'pun_jquery_include_method\'] < PUN_JQUERY_INCLUDE_METHOD_LOCAL) || ($form[\'pun_jquery_include_method\'] > PUN_JQUERY_INCLUDE_METHOD_JQUERY_CDN))
				{
					$form[\'pun_jquery_include_method\'] = PUN_JQUERY_INCLUDE_METHOD_LOCAL;
				}
			}
			else
			{
				$form[\'pun_jquery_include_method\'] = PUN_JQUERY_INCLUDE_METHOD_LOCAL;
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    4 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_karma\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_karma\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_karma\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!isset($form[\'pun_karma_minus_cancel\']) || $form[\'pun_karma_minus_cancel\'] != \'1\')
	$form[\'pun_karma_minus_cancel\'] = \'0\';
if (!isset($form[\'pun_karma_plus_interval\']))
	$form[\'pun_karma_plus_interval\'] = 2;
else
	$form[\'pun_karma_plus_interval\'] = intval($form[\'pun_karma_plus_interval\']);
if (!isset($form[\'pun_karma_minus_interval\']))
	$form[\'pun_karma_minus_interval\'] = 2;
else
	$form[\'pun_karma_minus_interval\'] = intval($form[\'pun_karma_minus_interval\']);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'fn_delete_user_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_pm\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_pm\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_pm\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$query = array(
				\'DELETE\'	=> \'pun_pm_messages\',
				\'WHERE\'		=> \'receiver_id = \'.$user_id.\' AND deleted_by_sender = 1\'
			);
			$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

			$query = array(
				\'UPDATE\'	=> \'pun_pm_messages\',
				\'SET\'		=> \'deleted_by_receiver = 1\',
				\'WHERE\'		=> \'receiver_id = \'.$user_id
			);
			$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'hd_visit_elements' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_pm\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_pm\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_pm\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

// \'New messages (N)\' link
			if (!$forum_user[\'is_guest\'] && $forum_config[\'o_pun_pm_show_new_count\'])
			{
				global $lang_pun_pm;

				if (!isset($lang_pun_pm))
				{
					if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
						include $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
					else
						include $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
				}

				// TODO: Do not include all functions, divide them into 2 files
				if(!defined(\'PUN_PM_FUNCTIONS_LOADED\'))
					require $ext_info[\'path\'].\'/functions.php\';

				($hook = get_hook(\'pun_pm_hd_visit_elements_pre_change\')) ? eval($hook) : null;

				//$visit_elements[\'<!-- forum_visit -->\'] = preg_replace(\'#(<p id="visit-links" class="options">.*?)(</p>)#\', \'$1 <span><a href="\'.forum_link($forum_url[\'pun_pm_inbox\']).\'">\'.pun_pm_unread_messages().\'</a></span>$2\', $visit_elements[\'<!-- forum_visit -->\']);
				if ($forum_user[\'g_read_board\'] == \'1\' && $forum_user[\'g_search\'] == \'1\')
				{
					$visit_links[\'pun_pm\'] = \'<span id="visit-pun_pm"><a href="\'.forum_link($forum_url[\'pun_pm_inbox\']).\'">\'.pun_pm_unread_messages().\'</a></span>\';
				}

				($hook = get_hook(\'pun_pm_hd_visit_elements_after_change\')) ? eval($hook) : null;
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'vt_row_pre_post_contacts_merge' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_pm\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_pm\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_pm\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

global $lang_pun_pm;

			if (!isset($lang_pun_pm))
			{
				if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
					include $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
				else
					include $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
			}

			($hook = get_hook(\'pun_pm_pre_post_contacts_add\')) ? eval($hook) : null;

			// Links \'Send PM\' near posts
			if (!$forum_user[\'is_guest\'] && $cur_post[\'poster_id\'] > 1 && $forum_user[\'id\'] != $cur_post[\'poster_id\'])
				$forum_page[\'post_contacts\'][\'PM\'] = \'<span class="contact"><a title="\'.$lang_pun_pm[\'Send PM\'].\'" href="\'.forum_link($forum_url[\'pun_pm_post_link\'], $cur_post[\'poster_id\']).\'">\'.$lang_pun_pm[\'PM\'].\'</a></span>\';

			($hook = get_hook(\'pun_pm_after_post_contacts_add\')) ? eval($hook) : null;

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'fn_generate_navlinks_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_pm\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_pm\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_pm\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

// Link \'PM\' in the main nav menu
			if (isset($links[\'profile\']) && $forum_config[\'o_pun_pm_show_global_link\'])
			{
				global $lang_pun_pm;

				if (!isset($lang_pun_pm))
				{
					if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
						include $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
					else
						include $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
				}

				if (\'pun_pm\' == substr(FORUM_PAGE, 0, 6))
					$links[\'profile\'] = str_replace(\' class="isactive"\', \'\', $links[\'profile\']);

				($hook = get_hook(\'pun_pm_pre_main_navlinks_add\')) ? eval($hook) : null;

				$links[\'profile\'] .= "\\n\\t\\t".\'<li id="nav_pun_pm"\'.(\'pun_pm\' == substr(FORUM_PAGE, 0, 6) ? \' class="isactive"\' : \'\').\'><a href="\'.forum_link($forum_url[\'pun_pm\']).\'"><span>\'.$lang_pun_pm[\'Private messages\'].\'</span></a></li>\';

				($hook = get_hook(\'pun_pm_after_main_navlinks_add\')) ? eval($hook) : null;
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'pf_view_details_pre_header_load' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_pm\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_pm\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_pm\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

// Link in the profile
			if (!$forum_user[\'is_guest\'] && $forum_user[\'id\'] != $user[\'id\'])
			{
				if (!isset($lang_pun_pm))
				{
					if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
						include $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
					else
						include $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
				}

				($hook = get_hook(\'pun_pm_pre_profile_user_contact_add\')) ? eval($hook) : null;

				$forum_page[\'user_contact\'][\'PM\'] = \'<li><span>\'.$lang_pun_pm[\'PM\'].\': <a href="\'.forum_link($forum_url[\'pun_pm_post_link\'], $id).\'">\'.$lang_pun_pm[\'Send PM\'].\'</a></span></li>\';

				($hook = get_hook(\'pun_pm_after_profile_user_contact_add\')) ? eval($hook) : null;
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'pf_change_details_about_pre_header_load' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_pm\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_pm\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_pm\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

// Link in the profile
			if (!$forum_user[\'is_guest\'] && $forum_user[\'id\'] != $user[\'id\'])
			{
				if (!isset($lang_pun_pm))
				{
					if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
						include $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
					else
						include $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
				}

				($hook = get_hook(\'pun_pm_pre_profile_user_contact_add\')) ? eval($hook) : null;

				$forum_page[\'user_contact\'][\'PM\'] = \'<li><span>\'.$lang_pun_pm[\'PM\'].\': <a href="\'.forum_link($forum_url[\'pun_pm_post_link\'], $id).\'">\'.$lang_pun_pm[\'Send PM\'].\'</a></span></li>\';

				($hook = get_hook(\'pun_pm_after_profile_user_contact_add\')) ? eval($hook) : null;
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'co_modify_url_scheme' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_pm\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_pm\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_pm\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($forum_config[\'o_sef\'] != \'Default\' && file_exists($ext_info[\'path\'].\'/url/\'.$forum_config[\'o_sef\'].\'.php\'))
				require $ext_info[\'path\'].\'/url/\'.$forum_config[\'o_sef\'].\'.php\';
			else
				require $ext_info[\'path\'].\'/url/Default.php\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (file_exists($ext_info[\'path\'].\'/url/\'.$forum_config[\'o_sef\'].\'.php\'))
				require $ext_info[\'path\'].\'/url/\'.$forum_config[\'o_sef\'].\'.php\';
			else
				require $ext_info[\'path\'].\'/url/Default.php\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  're_rewrite_rules' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_pm\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_pm\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_pm\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$forum_rewrite_rules[\'/^pun_pm[\\/_-]?send(\\.html?|\\/)?$/i\'] = \'misc.php?action=pun_pm_send\';
			$forum_rewrite_rules[\'/^pun_pm[\\/_-]?compose[\\/_-]?([0-9]+)(\\.html?|\\/)?$/i\'] = \'misc.php?section=pun_pm&pmpage=compose&receiver_id=$1\';
			$forum_rewrite_rules[\'/^pun_pm(\\.html?|\\/)?$/i\'] = \'misc.php?section=pun_pm\';
			$forum_rewrite_rules[\'/^pun_pm[\\/_-]?([0-9a-z]+)(\\.html?|\\/)?$/i\'] = \'misc.php?section=pun_pm&pmpage=$1\';
			$forum_rewrite_rules[\'/^pun_pm[\\/_-]?([0-9a-z]+)[\\/_-]?(p|page\\/)([0-9]+)(\\.html?|\\/)?$/i\'] = \'misc.php?section=pun_pm&pmpage=$1&p=$3\';
			$forum_rewrite_rules[\'/^pun_pm[\\/_-]?([0-9a-z]+)[\\/_-]?([0-9]+)(\\.html?|\\/)?$/i\'] = \'misc.php?section=pun_pm&pmpage=$1&message_id=$2\';

			($hook = get_hook(\'pun_pm_after_rewrite_rules_set\')) ? eval($hook) : null;

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$forum_rewrite_rules[\'/^tag[\\/_-]?([0-9]+)(\\.html?|\\/)?$/i\'] = \'search.php?action=tag&tag_id=$1\';
			$forum_rewrite_rules[\'/^tag[\\/_-]?([0-9]+)[\\/_-]p(age)?[\\/_-]?([0-9]+)(\\.html?|\\/)?$/i\'] = \'search.php?action=tag&tag_id=$1&p=$3\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    2 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_karma\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_karma\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_karma\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$forum_rewrite_rules[\'/^post[\\/_-]([0-9]+)[\\/_-]karma(plus|minus|cancel)[\\/_-]([a-z0-9]+)(\\.html?|\\/)?$/i\'] = \'viewtopic.php?pid=$1&karma$2&csrf_token=$3\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'in_users_online_qr_get_online_info' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_colored_usergroups\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_colored_usergroups\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_colored_usergroups\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$query[\'SELECT\'] .= \', u.group_id\';
			$query[\'JOINS\'][] = array(
				\'LEFT JOIN\'	=> \'users AS u\',
				\'ON\'		=> \'u.id=o.user_id\'
			);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'agr_add_edit_group_pre_basic_details_fieldset_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_colored_usergroups\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_colored_usergroups\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_colored_usergroups\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/pun_colored_usergroups.php\'))
					include $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/pun_colored_usergroups.php\';
			else
					include $ext_info[\'path\'].\'/lang/English/pun_colored_usergroups.php\';
			?>
				<div class="sf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
					<div class="sf-box text required">
						<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $lang_pun_colored_usergroups[\'link\'] ?></span></label><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page[\'fld_count\'] ?>" name="link_color" size="20" maxlength="20" value="<?php echo forum_htmlencode($group[\'link_color\']) ?>" /></span>
					</div>
					<div class="sf-box text required">
						<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $lang_pun_colored_usergroups[\'hover\'] ?></span></label><br />
						<span class="fld-input"><input type="text" id="fld<?php echo $forum_page[\'fld_count\'] ?>" name="hover_color" size="20" maxlength="20" value="<?php echo forum_htmlencode($group[\'hover_color\']) ?>" /></span>
					</div>
				</div>
			<?php

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'in_users_online_pre_online_info_output' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_colored_usergroups\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_colored_usergroups\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_colored_usergroups\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$users = array();
			$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

			while ($forum_user_online = $forum_db->fetch_assoc($result))
			{
				if ($forum_user_online[\'user_id\'] > 1)
				{
					$users[] = ($forum_user[\'g_view_users\'] == \'1\') ? \'<span class="group_color_\'.$forum_user_online[\'group_id\'].\'"><a href="\'.forum_link($forum_url[\'user\'], $forum_user_online[\'user_id\']).\'">\'.forum_htmlencode($forum_user_online[\'ident\']).\'</a></span>\' : forum_htmlencode($forum_user_online[\'ident\']);
				};
			};

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'in_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_colored_usergroups\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_colored_usergroups\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_colored_usergroups\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!file_exists(FORUM_CACHE_DIR.\'cache_pun_coloured_usergroups.php\'))
			{
				if (!defined(\'CACHE_PUN_COLOURED_USERGROUPS_LOADED\')) {
					require $ext_info[\'path\'].\'/main.php\';
				}
				cache_pun_coloured_usergroups();
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ul_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_colored_usergroups\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_colored_usergroups\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_colored_usergroups\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!file_exists(FORUM_CACHE_DIR.\'cache_pun_coloured_usergroups.php\'))
			{
				if (!defined(\'CACHE_PUN_COLOURED_USERGROUPS_LOADED\')) {
					require $ext_info[\'path\'].\'/main.php\';
				}
				cache_pun_coloured_usergroups();
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_admin_add_user\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_admin_add_user\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_admin_add_user\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($forum_user[\'g_id\'] == FORUM_ADMIN)
			{
				$errors_add_users = array();
				if (isset($_POST[\'add_user_form_sent\']) && $_POST[\'add_user_form_sent\'] == 1)
				{
					$forum_extension[\'admin_add_user\'][\'user_added\'] = false;

					require_once FORUM_ROOT.\'include/functions.php\';
					require_once FORUM_ROOT.\'lang/\'.$forum_user[\'language\'].\'/profile.php\';

					$username = trim($_POST[\'req_username\']);
					$email = strtolower(trim($_POST[\'req_email\']));

					// Validate the username
					$errors_add_users = validate_username($username);

					// ... and the e-mail address
					require_once FORUM_ROOT.\'include/email.php\';

					if (!is_valid_email($email))
					   $errors_add_users[] = $lang_common[\'Invalid e-mail\'];

					// Check if it\'s a banned e-mail address
					$banned_email = is_banned_email($email);
					if ($banned_email && $forum_config[\'p_allow_banned_email\'] == \'0\')
						$errors_add_users[] = $lang_profile[\'Banned e-mail\'];

					// Check if someone else already has registered with that e-mail address
					$q = array(
						\'SELECT\'	=> \'COUNT(u.username)\',
						\'FROM\'	  	=> \'users AS u\',
						\'WHERE\'		=> \'u.email=\\\'\'.$forum_db->escape($email).\'\\\'\'
					);

					$result = $forum_db->query_build( $q ) or error(__FILE__, __LINE__);

					if (($forum_config[\'p_allow_dupe_email\'] == \'0\') && ($forum_db->result($result) > 0))
						$errors_add_users[] = $lang_profile[\'Dupe e-mail\'];

					if (empty($errors_add_users))
					{
						$salt = random_key(12);
						$password = random_key(8, true);
						$password_hash = sha1($salt.sha1($password));

						$errors = add_user(
							array(
								\'username\'				=> $username,
								\'group_id\'				=> ($forum_config[\'o_regs_verify\'] == \'0\') ? $forum_config[\'o_default_user_group\'] : FORUM_UNVERIFIED,
								\'salt\'					=> $salt,
								\'password\'				=> $password,
								\'password_hash\'			=> $password_hash,
								\'email\'					=> $email,
								\'email_setting\'			=> 1,
								\'save_pass\'				=> 0,
								\'timezone\'				=> $forum_config[\'o_default_timezone\'],
								\'dst\'					=> 0,
								\'language\'				=> $forum_config[\'o_default_lang\'],
								\'style\'					=> $forum_config[\'o_default_style\'],
								\'registered\'			=> time(),
								\'registration_ip\'		=> get_remote_address(),
								\'activate_key\'			=> ($forum_config[\'o_regs_verify\'] == \'1\') ? \'\\\'\'.random_key(8, true).\'\\\'\' : \'NULL\',
								\'require_verification\'	=> ($forum_config[\'o_regs_verify\'] == \'1\'),
								\'notify_admins\'			=> ($forum_config[\'o_regs_report\'] == \'1\')
								),
								$new_uid
						);

						if ($forum_user[\'language\'] != \'English\' && file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
							require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
						else
							require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';

						$forum_flash->add_info($lang_admin_add_user[\'User added successfully\']);

						if (isset($_POST[\'edit_identity\']) && $_POST[\'edit_identity\'] == 1)
							redirect(forum_link($forum_url[\'profile_identity\'], $new_uid), $lang_admin_add_user[\'User added successfully\']);

						$ext_admin_add_user_user_added = true;
					}
					else
						$ext_admin_add_user_user_added = false;
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'pf_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_colored_usergroups\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_colored_usergroups\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_colored_usergroups\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!file_exists(FORUM_CACHE_DIR.\'cache_pun_coloured_usergroups.php\'))
			{
				if (!defined(\'CACHE_PUN_COLOURED_USERGROUPS_LOADED\')) {
					require $ext_info[\'path\'].\'/main.php\';
				}
				cache_pun_coloured_usergroups();
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'vt_row_pre_post_ident_merge' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_colored_usergroups\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_colored_usergroups\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_colored_usergroups\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($cur_post[\'poster_id\'] > 1)
				$forum_page[\'post_ident\'][\'byline\'] = \'<span class="post-byline">\'.sprintf((($cur_post[\'id\'] == $cur_topic[\'first_post_id\']) ? $lang_topic[\'Topic byline\'] : $lang_topic[\'Reply byline\']), (($forum_user[\'g_view_users\'] == \'1\') ? \'<em class="group_color_\'.$cur_post[\'g_id\'].\'"><a title="\'.sprintf($lang_topic[\'Go to profile\'], forum_htmlencode($cur_post[\'username\'])).\'" href="\'.forum_link($forum_url[\'user\'], $cur_post[\'poster_id\']).\'">\'.forum_htmlencode($cur_post[\'username\']).\'</a></em>\' : \'<strong>\'.forum_htmlencode($cur_post[\'username\']).\'</strong>\')).\'</span>\';
			else
				$forum_page[\'post_ident\'][\'byline\'] = \'<span class="post-byline">\'.sprintf((($cur_post[\'id\'] == $cur_topic[\'first_post_id\']) ? $lang_topic[\'Topic byline\'] : $lang_topic[\'Reply byline\']), \'<strong>\'.forum_htmlencode($cur_post[\'username\']).\'</strong>\').\'</span>\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ul_results_row_pre_data_output' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_colored_usergroups\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_colored_usergroups\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_colored_usergroups\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$forum_page[\'table_row\'][\'username\'] = \'<td class="tc\'.count($forum_page[\'table_row\']).\'"><span class="group_color_\'.$user_data[\'g_id\'].\'"><a href="\'.forum_link($forum_url[\'user\'], $user_data[\'id\']).\'">\'.forum_htmlencode($user_data[\'username\']).\'</a></span></td>\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'pf_change_details_about_output_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_colored_usergroups\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_colored_usergroups\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_colored_usergroups\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$forum_page[\'user_ident\'][\'username\'] = \'<li class="username\'.(($user[\'realname\'] ==\'\') ? \' fn nickname\' :  \' nickname\').\'"><strong class="group_color_\'.$user[\'g_id\'].\'">\'.forum_htmlencode($user[\'username\']).\'</strong></li>\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'agr_add_edit_pre_redirect' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_colored_usergroups\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_colored_usergroups\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_colored_usergroups\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!defined(\'CACHE_PUN_COLOURED_USERGROUPS_LOADED\')) {
				require $ext_info[\'path\'].\'/main.php\';
			}
			cache_pun_coloured_usergroups();

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

require_once $ext_info[\'path\'].\'/functions.php\';
			pun_tags_generate_forum_perms_cache();

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ed_form_submitted' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!isset($_POST[\'preview\']) && $can_edit_subject && ($forum_user[\'group_id\'] == FORUM_ADMIN || $forum_user[\'g_poll_add\'])) {
				$reset_poll = (isset($_POST[\'reset_poll\']) && $_POST[\'reset_poll\'] == \'1\') ? true : false;
				$remove_poll = (isset($_POST[\'remove_poll\']) && $_POST[\'remove_poll\'] == \'1\') ? true : false;

				// We need to reset poll
				if ($reset_poll) {
					Pun_poll::reset_poll($cur_post[\'tid\']);
				}

				if ($remove_poll) {
					Pun_poll::remove_poll($cur_post[\'tid\']);
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ed_preview_pre_display' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ((($forum_user[\'group_id\'] == FORUM_ADMIN && $can_edit_subject) || ($can_edit_subject && !$topic_poll)) && empty($errors)) {
				if (!empty($new_poll_question) && !empty($new_poll_answers)) {
					$forum_page[\'preview_message\'] .= Pun_poll::poll_preview($new_poll_question, $new_poll_answers);
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ed_main_fieldset_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($can_edit_subject && ($forum_user[\'group_id\'] == FORUM_ADMIN || $forum_user[\'g_poll_add\']))
			{
				//Is there something?
				if ($topic_poll) {
					if ($forum_user[\'group_id\'] == FORUM_ADMIN) {
						Pun_poll::show_form(isset($new_poll_question) ? $new_poll_question : $poll_question, isset($new_poll_answers) ? $new_poll_answers : $poll_answers, isset($new_poll_ans_count) ? $new_poll_ans_count : (isset($new_poll_answers) ? count($new_poll_answers) : count($poll_answers)), isset($new_poll_days) ? $new_poll_days : $poll_days_count, isset($new_poll_votes) ? $new_poll_votes : $poll_votes_count, isset($new_read_unvote_users) ? $new_read_unvote_users : $poll_read_unvote_users, isset($new_revote) ? $new_revote : $poll_revote, true);
					}
				} else {
					Pun_poll::show_form(isset($new_poll_question) ? $new_poll_question : \'\', isset($new_poll_answers) ? $new_poll_answers : \'\', isset($new_poll_ans_count) ? $new_poll_ans_count : (isset($new_poll_answers) ? (count($new_poll_answers) > 2 ? count($new_poll_answers) : 2) : 2), isset($new_poll_days) ? $new_poll_days : FALSE, isset($new_poll_votes) ? $new_poll_votes : FALSE, $forum_config[\'p_pun_poll_enable_read\'] ? (isset($new_read_unvote_users) ? $new_read_unvote_users : \'0\') : FALSE, $forum_config[\'p_pun_poll_enable_revote\'] ? (isset($new_revote) ? $new_revote : \'0\') : FALSE);
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'po_preview_pre_display' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($fid && ($forum_user[\'group_id\'] == FORUM_ADMIN || $forum_user[\'g_poll_add\']) && $poll_question !== FALSE && empty($errors)) {
				$forum_page[\'preview_message\'] .= Pun_poll::poll_preview($poll_question, $poll_answers);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'po_req_info_fieldset_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($fid && ($forum_user[\'group_id\'] == FORUM_ADMIN || $forum_user[\'g_poll_add\']))
			{
				$_poll_question = isset($poll_question) ? $poll_question : \'\';
				$_poll_answers = isset($poll_answers) ? $poll_answers : array();
				$_poll_answers_num = isset($new_poll_ans_count) ? $new_poll_ans_count : ((isset($poll_answers) && count($poll_answers) > 1) ? count($poll_answers) : 2);

				Pun_poll::show_form($_poll_question, $_poll_answers, $_poll_answers_num, !empty($poll_days) ? $poll_days : \'\', !empty($poll_votes) ? $poll_votes : \'\', isset($poll_read_unvote_users) ? $poll_read_unvote_users : \'0\', isset($poll_revote) ? $poll_revote : \'0\');
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ca_fn_prune_qr_prune_topics' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$pun_poll_topic_ids = isset($topic_ids) ? $topic_ids : implode(\',\', $topics);
			$query_poll = array(
				\'DELETE\'	=>	\'voting\',
				\'WHERE\'		=>	\'topic_id IN(\'.$pun_poll_topic_ids.\')\'
			);
			$forum_db->query_build($query_poll) or error(__FILE__, __LINE__);

			$query_poll = array(
				\'DELETE\'	=>	\'questions\',
				\'WHERE\'		=>	\'topic_id IN(\'.$pun_poll_topic_ids.\')\'
			);
			$forum_db->query_build($query_poll) or error(__FILE__, __LINE__);

			$query_poll = array(
				\'DELETE\'	=>	\'answers\',
				\'WHERE\'		=>	\'topic_id IN(\'.$pun_poll_topic_ids.\')\'
			);
			$forum_db->query_build($query_poll) or error(__FILE__, __LINE__);
			unset($pun_poll_topic_ids);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'mr_confirm_delete_topics_qr_delete_topics' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$pun_poll_topic_ids = isset($topic_ids) ? $topic_ids : implode(\',\', $topics);
			$query_poll = array(
				\'DELETE\'	=>	\'voting\',
				\'WHERE\'		=>	\'topic_id IN(\'.$pun_poll_topic_ids.\')\'
			);
			$forum_db->query_build($query_poll) or error(__FILE__, __LINE__);

			$query_poll = array(
				\'DELETE\'	=>	\'questions\',
				\'WHERE\'		=>	\'topic_id IN(\'.$pun_poll_topic_ids.\')\'
			);
			$forum_db->query_build($query_poll) or error(__FILE__, __LINE__);

			$query_poll = array(
				\'DELETE\'	=>	\'answers\',
				\'WHERE\'		=>	\'topic_id IN(\'.$pun_poll_topic_ids.\')\'
			);
			$forum_db->query_build($query_poll) or error(__FILE__, __LINE__);
			unset($pun_poll_topic_ids);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$query_tags = array(
				\'DELETE\'	=>	\'topic_tags\',
				\'WHERE\'		=>	\'topic_id IN(\'.implode(\',\', $topics).\')\'
			);
			$forum_db->query_build($query_tags) or error(__FILE__, __LINE__);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'fn_delete_topic_qr_delete_topic' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

include_once $ext_info[\'path\'].\'/functions.php\';

			Pun_poll::remove_poll($topic_id);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'vt_modify_topic_info' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!$forum_user[\'is_guest\']) {
				//Get info about poll
				$query_pun_poll = array(
					\'SELECT\'	=>	\'question, read_unvote_users, revote, created, days_count, votes_count AS max_votes_count\',
					\'FROM\'		=>	\'questions\',
					\'WHERE\'		=>	\'topic_id = \'.$id
				);
				$result_pun_poll = $forum_db->query_build($query_pun_poll) or error(__FILE__, __LINE__);
				$pun_poll = $forum_db->fetch_assoc($result_pun_poll);

				// Is there something?
				if (!is_null($pun_poll) && $pun_poll !== false) {
					if ($forum_user[\'style\'] !== \'Oxygen\' && file_exists($ext_info[\'path\'].\'/css/\'.$forum_user[\'style\'].\'/pun_poll.min.css\'))
						$forum_loader->add_css($ext_info[\'url\'].\'/css/\'.$forum_user[\'style\'].\'/pun_poll.min.css\', array(\'type\' => \'url\', \'media\' => \'screen\'));
					else
						$forum_loader->add_css($ext_info[\'url\'].\'/css/Oxygen/pun_poll.min.css\', array(\'type\' => \'url\', \'media\' => \'screen\'));

					// JS
					$forum_loader->add_js($ext_info[\'url\'].\'/js/pun_poll.min.js\', array(\'type\' => \'url\', \'async\' => true));

					$end_voting = false;
					$pun_poll[\'revote\'] = ($forum_config[\'p_pun_poll_enable_revote\'] == \'1\') ? $pun_poll[\'revote\'] : 0;
					$pun_poll[\'read_unvote_users\'] = ($forum_config[\'p_pun_poll_enable_read\'] == \'1\') ? $pun_poll[\'read_unvote_users\'] : 0;

					// Check up for condition of end poll
					if ($pun_poll[\'days_count\'] != 0 && time() > $pun_poll[\'created\'] + $pun_poll[\'days_count\'] * 86400) {
						$end_voting = true;
					} else if ($pun_poll[\'max_votes_count\'] != 0) {
						// Get count of votes
						$query_pun_poll = array(
							\'SELECT\'	=>	\'COUNT(id) AS vote_count\',
							\'FROM\'		=>	\'voting\',
							\'WHERE\'		=>	\'topic_id=\'.$id
						);
						$result_pun_poll = $forum_db->query_build($query_pun_poll) or error(__FILE__, __LINE__);
						$row = $forum_db->fetch_assoc($result_pun_poll);
						$vote_count = $row[\'vote_count\'];

						if ($vote_count >= $pun_poll[\'max_votes_count\']) {
							$end_voting = true;
						}
					}

					if ($forum_user[\'language\'] != \'English\' && file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
						include_once $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
					else
						include_once $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';

					// Does user want to vote?
					if (isset($_POST[\'vote\'])) {
						if ($end_voting) {
							message($lang_pun_poll[\'End of vote\']);
						}

						$answer_id = isset($_POST[\'answer\']) ? intval($_POST[\'answer\']) : 0;
						if ($answer_id < 1) {
							message($lang_common[\'Bad request\']);
						}

						// Is there answer with this id?
						$query_pun_poll = array(
							\'SELECT\'	=>	\'COUNT(*)\',
							\'FROM\'		=>	\'answers\',
							\'WHERE\'		=>	\'topic_id=\'.$id.\' AND id=\'.$answer_id
						);
						$result_pun_poll = $forum_db->query_build($query_pun_poll) or error(__FILE__, __LINE__);
						if ($forum_db->result($result_pun_poll) < 1) {
							message($lang_common[\'Bad request\']);
						}

						// Have user voted?
						$query_pun_poll = array(
							\'SELECT\'	=>	\'answer_id\',
							\'FROM\'		=>	\'voting\',
							\'WHERE\'		=>	\'topic_id=\'.$id.\' AND user_id=\'.$forum_user[\'id\']
						);
						$result_pun_poll = $forum_db->query_build($query_pun_poll) or error(__FILE__, __LINE__);
						$row = $forum_db->fetch_assoc($result_pun_poll);
						$old_answer_id = FALSE;
						if ($row) {
							$old_answer_id = $row[\'answer_id\'];
						}

						// CAN revote?
						if (!$pun_poll[\'revote\'] && $old_answer_id !== FALSE) {
							message($lang_pun_poll[\'User vote error\']);
						}

						// If user have voted we update table,
						// if not - insert new record
						if ($pun_poll[\'revote\'] && $old_answer_id !== FALSE) {
							// Do we needed to update DB?
							if ($old_answer_id != $answer_id) {
								$query_pun_poll = array(
									\'UPDATE\'	=>	\'voting\',
									\'SET\'		=>	\'answer_id=\'.$answer_id,
									\'WHERE\'		=>	\'topic_id=\'.$id.\' AND user_id=\'.$forum_user[\'id\']
								);
								$forum_db->query_build($query_pun_poll) or error(__FILE__, __LINE__);

								// Replace old answer id with new for correct output
								$old_answer_id = $answer_id;
							}
						} else {
							// Add new record
							$query_pun_poll = array(
								\'INSERT\'	=>	\'topic_id, user_id, answer_id\',
								\'INTO\'		=>	\'voting\',
								\'VALUES\'	=>	$id.\', \'.$forum_user[\'id\'].\', \'.$answer_id
							);
							$forum_db->query_build($query_pun_poll) or error(__FILE__, __LINE__);
						}

						redirect(forum_link($forum_url[\'topic\'], array($id, sef_friendly($cur_topic[\'subject\']))), $lang_pun_poll[\'Poll redirect\']);
					} else {
						// Determine user have voted or not
						$query_pun_poll = array(
							\'SELECT\'	=>	\'COUNT(*)\',
							\'FROM\'		=>	\'voting\',
							\'WHERE\'		=>	\'user_id=\'.$forum_user[\'id\'].\' AND topic_id=\'.$id
						);
						$result_pun_poll = $forum_db->query_build($query_pun_poll) or error(__FILE__, __LINE__);
						$is_voted_user = ($forum_db->result($result_pun_poll) > 0) ? true : false;
					}
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_karma\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_karma\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_karma\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

//Including lang file
if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
	require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
else
	require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
require $ext_info[\'path\'].\'/url/\'.$forum_config[\'o_sef\'].\'/forum_urls.php\';
require $ext_info[\'path\'].\'/functions.php\';
if (!$forum_user[\'is_guest\'] && (isset($_GET[\'karmaplus\']) || isset($_GET[\'karmaminus\']) || isset($_GET[\'karmacancel\'])))
{
	//Check if user tries to vote for his own post
	$pun_karma_query = array(
		\'SELECT\'	=> \'1\',
		\'FROM\'		=> \'posts\',
		\'WHERE\'		=> \'poster_id = \'.$forum_user[\'id\'].\' AND id = \'.$pid
	);
	$result = $forum_db->query_build($pun_karma_query) or error(__FILE__, __LINE__);
	if ($forum_db->num_rows($result) > 0)
		message($lang_pun_karma[\'Vote error\']);

	if (isset($_GET[\'karmaplus\']))
	{
		if (!isset($_GET[\'csrf_token\']) || ($_GET[\'csrf_token\'] != generate_form_token(\'karmaplus\'.$pid)))
			csrf_confirm_form();
		$pun_karma_query = array(
			\'SELECT\'	=>	\'MAX(updated_at)\',
			\'FROM\'		=>	\'pun_karma\',
			\'WHERE\'		=>	\'user_id = \'.$forum_user[\'id\'].\' AND mark = 1\'
		);
		$pun_karma_result = $forum_db->query_build($pun_karma_query) or error(__FILE__, __LINE__);
		if ($forum_db->num_rows($pun_karma_result) > 0)
		{
			list($updated_at) = $forum_db->fetch_row($pun_karma_result);
			if ((time() - $updated_at) < $forum_config[\'o_pun_karma_plus_interval\'] * 60 && (time() - $updated_at) >= 0)
				message(sprintf($lang_pun_karma[\'Plus interval rest\'], $forum_config[\'o_pun_karma_plus_interval\']));
		}
		karma_plus($pid);
	}
	else if (isset($_GET[\'karmaminus\']))
	{
		if (!isset($_GET[\'csrf_token\']) || ($_GET[\'csrf_token\'] != generate_form_token(\'karmaminus\'.$pid)))
			csrf_confirm_form();
		$pun_karma_query = array(
			\'SELECT\'	=>	\'MAX(updated_at)\',
			\'FROM\'		=>	\'pun_karma\',
			\'WHERE\'		=>	\'user_id = \'.$forum_user[\'id\'].\' AND mark = -1\'
		);
		$pun_karma_result = $forum_db->query_build($pun_karma_query) or error(__FILE__, __LINE__);
		if ($forum_db->num_rows($pun_karma_result) > 0)
		{
			list($updated_at) = $forum_db->fetch_row($pun_karma_result);
			if ((time() - $updated_at) < $forum_config[\'o_pun_karma_minus_interval\'] * 60 && (time() - $updated_at) >= 0)
				message(sprintf($lang_pun_karma[\'Minus interval rest\'], $forum_config[\'o_pun_karma_minus_interval\']));
		}
		karma_minus($pid);
	}
	else if (isset($_GET[\'karmacancel\']))
	{
		if (!isset($_GET[\'csrf_token\']) || ($_GET[\'csrf_token\'] != generate_form_token(\'karmacancel\'.$pid)))
			csrf_confirm_form();
		karma_cancel($pid);
	}
}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'vt_pre_header_load' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

// Is there something to show?
			if (isset($pun_poll[\'read_unvote_users\']) && !$forum_user[\'is_guest\']) {
				// If we don\'t get count of votes
				if (!isset($vote_count)) {
					$query_pun_poll = array(
						\'SELECT\'	=>	\'COUNT(*) AS vote_count\',
						\'FROM\'		=>	\'voting\',
						\'WHERE\'		=>	\'topic_id=\'.$id
					);
					$result_pun_poll = $forum_db->query_build($query_pun_poll) or error(__FILE__, __LINE__);
					$row = $forum_db->fetch_assoc($result_pun_poll);
					$vote_count = $row[\'vote_count\'];
				}

				// Showing of vote-form if users can revote or user don\'t vote
				if (!$end_voting && (($is_voted_user && $pun_poll[\'revote\']) || $is_voted_user === false)) {
					$query_pun_poll = array(
						\'SELECT\'	=>	\'id, answer\',
						\'FROM\'		=>	\'answers\',
						\'WHERE\'		=>	\'topic_id=\'.$id,
						\'ORDER BY\'	=>	\'id ASC\'
					);
					$result_pun_poll = $forum_db->query_build($query_pun_poll) or error(__FILE__, __LINE__);

					$pun_poll_answers = array();
					while ($row = $forum_db->fetch_assoc($result_pun_poll)) {
						$pun_poll_answers[] = $row;
					}

					if (!empty($pun_poll_answers))
					{
						$vote_form = \'\';
						$link = forum_link($forum_url[\'topic\'], $id);

						$vote_form = \'
							<div class="pun_poll_item unvotted">
								<div class="pun_poll_header">\'.forum_htmlencode($pun_poll[\'question\']).\'</div>
								<div class="main-frm">
									<form class="frm-form" action="\'.$link.\'" accept-charset="utf-8" method="post">
										<fieldset class="frm-group group1">
											<div class="hidden">
												<input type="hidden" name="csrf_token" value="\'.generate_form_token($link).\'" />
											</div>
											<fieldset class="mf-set set1">
												<legend><span>\'.$lang_pun_poll[\'Options\'].\'</span></legend>
												<div class="mf-box">\';

						// Determine old answer of user
						if (!isset($old_answer_id)) {
							$query_pun_poll = array(
								\'SELECT\'	=>	\'answer_id\',
								\'FROM\'		=>	\'voting\',
								\'WHERE\'		=>	\'topic_id = \'.$id.\' AND user_id = \'.$forum_user[\'id\'],
								\'ORDER BY\'	=>	\'answer_id ASC\'
							);
							$result_poll = $forum_db->query_build($query_pun_poll) or error(__FILE__, __LINE__);

							// If there is something?
							$row = $forum_db->fetch_assoc($result_poll);
							if ($row) {
								$old_answer_id = $row[\'answer_id\'];
							}
							unset($result_poll);
						}


						$num = 0;
						foreach ($pun_poll_answers as $answer) {
							$num++;
							$vote_form .= \'
								<div class="mf-item pun_poll_answer_block" data-num="\'.$num.\'">
									<span class="fld-input">
										<input id="fld\'.$num.\'" type="radio"\'.((isset($old_answer_id) && $old_answer_id == $answer[\'id\']) ? \' checked="checked"\' : \'\').\' value="\'.$answer[\'id\'].\'" name="answer" />
									</span>
									<label for="fld\'.$num.\'">\'.forum_htmlencode($answer[\'answer\']).\'</label>
								</div>\';
						}

						$vote_form .= \'
												</div>
											</fieldset>
										</fieldset>
										<div class="frm-buttons">
											<span class="submit">
												<input type="submit" value="\'.$lang_pun_poll[\'But note\'].\'" name="vote" />
											</span>
										</div>
									</form>
								</div>
							</div>\';
					}
				}

				// Showing voting results if user have voted or unread user can see voting results
				if ($end_voting || $is_voted_user || (!$is_voted_user && $pun_poll[\'read_unvote_users\'])) {
					if (isset($vote_count) && $vote_count > 0) {
						$query_pun_poll = array(
							\'SELECT\'	=>	\'answer, COUNT(v.id) as num_vote\',
							\'FROM\'		=>	\'answers as a\',
							\'JOINS\'		=>	array(
								array(
									\'LEFT JOIN\'	=>	\'voting AS v\',
									\'ON\'		=>	\'a.id=v.answer_id\'
								)
							),
							\'WHERE\'		=>	\'a.topic_id=\'.$id,
							\'GROUP BY\'	=>	\'a.id\',
							\'ORDER BY\'	=>	\'a.id\'
						);
						$result_pun_poll = $forum_db->query_build($query_pun_poll) or error(__FILE__, __LINE__);

						$vote_results = \'<div class="pun_poll_item votted"><div class="pun_poll_header">\'.forum_htmlencode($pun_poll[\'question\']).\'</div>\';
						$vote_results_raw = array();
						$num = $winner_index = $cur_vote_index = 0;
						$max_vote = $num_winner = 0;

						while ($row = $forum_db->fetch_assoc($result_pun_poll)) {
							$vote_results_raw[] = $row;
							if ($row[\'num_vote\'] > $max_vote) {
								$max_vote = $row[\'num_vote\'];
								$winner_index = $cur_vote_index;
							}

							$cur_vote_index++;
						}

						// Case when winner is not one
						foreach ($vote_results_raw as $vote) {
							if ($vote[\'num_vote\'] == $max_vote) {
								$num_winner++;
							}
						}

						if ($num_winner !== 1) {
							// No winner
							$winner_index = -1;
						}

						foreach ($vote_results_raw as $vote) {
							$pollResultWidth = ((float)/**/$vote[\'num_vote\'] / $vote_count * 100);
							$vote_results .= \'
								<dl>
									<dt><strong>\'.forum_number_format((float)/**/$vote[\'num_vote\'] / $vote_count * 100).\'%</strong><br/>(\'.$vote[\'num_vote\'].\')</dt>
									<dd>\'.forum_htmlencode($vote[\'answer\'])
										.\'<div class="\'.(($winner_index == $num) ? \'winner\' : \'\').(($pollResultWidth > 0) ? \'\' : \' poll-empty\').\'" style="width: \'.$pollResultWidth.\'%;"></div>
									</dd>
								</dl>\';
							$num++;
						}

						$num++;
						$vote_results .= \'<p class="pun_poll_total">\'.$lang_pun_poll[\'Users count\'].$vote_count.\'</p>\';
						$vote_results .= \'</div>\';
					} else {
						$vote_results = \'<div class="ct-box info-box"><p>\'.$lang_pun_poll[\'No votes\'].\'</p></div>\';
					}
				} else {
					$vote_results = \' \';
				}

				unset($tmp_pagepost, $vote_count, $num, $result_pun_poll, $query_pun_poll, $count_v, $answer, $is_voted_user, $end_voting, $pun_poll);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'aop_features_pre_header_load' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
				include_once $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
			else
				include_once $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_karma\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_karma\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_karma\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

//Including lang file
if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
	require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
else
	require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
require $ext_info[\'path\'].\'/url/\'.$forum_config[\'o_sef\'].\'/forum_urls.php\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'agr_add_edit_group_user_permissions_fieldset_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_poll\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_poll\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_poll\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
				include_once $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
			else
				include_once $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
			?>
				<fieldset class="mf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
					<legend>
						<span><?php echo $lang_pun_poll[\'Permission\'] ?></span>
					</legend>
					<div class="mf-box">
						<div class="mf-item">
							<span class="fld-input">
								<input type="checkbox" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="poll_add" value="1"<?php if ($group[\'g_poll_add\'] == \'1\') echo \' checked="checked"\' ?>/>
							</span>
							<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><?php echo $lang_pun_poll[\'Poll add\'] ?></label>
						</div>
					</div>
				</fieldset>
			<?php

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ul_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_admin_add_user\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_admin_add_user\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_admin_add_user\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($forum_user[\'g_id\'] == FORUM_ADMIN)
			{
				if ($forum_user[\'language\'] != \'English\' && file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
							require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
						else
							require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';

				$username = \'\';
				$email = \'\';
				$edit_identity = \'\';
				$result_message = \'\';

				if (isset($_POST[\'add_user_form_sent\']) && $_POST[\'add_user_form_sent\'] == 1)
				{
					if ($ext_admin_add_user_user_added === true)
						$result_message = \'<div class="frm-info"><p>\'.$lang_admin_add_user[\'User added successfully\'].\'/p></div>\';
					else
					{
						$username = $_POST[\'req_username\'];
						$email = $_POST[\'req_email\'];
						$edit_identity = isset($_POST[\'edit_identity\']);
					}
				}

				$buffer_old = ob_get_contents();

				ob_end_clean();

				ob_start();

				$pun_add_user_form_action = $base_url.\'/userlist.php\';

				// Get output buffer and insert form
				$pos = strpos($buffer_old, \'<div class="main-foot">\');
				echo substr($buffer_old, 0 , $pos);
				?>

				<div class="main-head">
					<h2 class="hn"><span><?php echo $lang_admin_add_user[\'Add user\'] ?></span></h2>
				</div>
				<div class="main-content main-frm">
				<?php

				if (!empty($errors_add_users))
				{
					$error_li = array();
					for ($err_num = 0; $err_num < count($errors_add_users); $err_num++)
						$error_li[] = \'<li class="warn"><span>\'.$errors_add_users[$err_num].\'</span></li>\';

				?>
					<div class="ct-box error-box">
						<h2 class="warn hn"><?php echo $lang_admin_add_user[\'There are some errors\']; ?></h2>
						<ul class="error-list">
						<?php echo implode("\\n\\t\\t\\t\\t\\t\\t", $error_li)."\\n" ?>
						</ul>
					</div>
				<?php } ?>
					<form class="frm-form" id="frm-adduser" action="<?php echo $pun_add_user_form_action ?>#adduser-content" method="post">
						<div class="hidden">
							<input type="hidden" name="csrf_token" value="<?php echo generate_form_token($pun_add_user_form_action) ?>" />
							<input type="hidden" name="add_user_form_sent" value="1" />
						</div>

						<div class="frm-group group1">
							<div class="sf-set set1">
								<div class="sf-box text required">
									<label for="add_user_username">
										<span><?php echo $lang_admin_add_user[\'Username\'] ?></span>
										<small>
											<?php echo $lang_admin_add_user[\'Between 2 and 25 characters\'] ?>
										</small>
									</label>
									<span class="fld-input"><input type="text" id="add_user_username" name="req_username" size="35" value="<?php echo $username ?>" maxlength="25" required /></span>
								</div>
							</div>

							<div class="sf-set set2">
								<div class="sf-box text required">
									<label for="add_user_email">
										<span><?php echo $lang_admin_add_user[\'E-mail\'] ?></span>
										<small>
											<?php echo $lang_admin_add_user[\'Enter a current and valid e-mail address\'] ?>
										</small>
									</label>
									<span class="fld-input"><input type="text" id="add_user_email" name="req_email" size="35" value="<?php echo $email ?>" maxlength="80" required/></span>
								</div>
							</div>

							<div class="sf-set set3">
								<div class="sf-box checkbox">
									<span class="fld-input"><input type="checkbox" id="add_user_edit_user_identity" name="edit_identity" value="1"<?php echo $edit_identity ? \' checked="checked"\' : \'\' ?> /></span>
									<label for="add_user_edit_user_identity"><?php echo $lang_admin_add_user[\'Edit User Identity after adding User\'] ?></label>
								</div>
							</div>
						</div>

						<div class="frm-buttons">
							<span class="submit primary"><input type="submit" name="submit" value="<?php echo $lang_admin_add_user[\'Add user\'] ?>" /></span>
						</div>
					</form>
				</div>
				<?php

				echo substr($buffer_old, $pos, strlen($buffer_old) - $pos);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'mr_post_actions_pre_mod_options' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_move_posts\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_move_posts\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_move_posts\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$forum_page[\'mod_options\'] = array_merge(array(\'<span class="submit first-item"><input type="submit" name="move_posts" value="\'.$lang_pun_move_posts[\'Move selected\'].\'" /></span>\'), $forum_page[\'mod_options\']);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'mr_post_actions_selected' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_move_posts\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_move_posts\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_move_posts\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

require $ext_info[\'path\'].\'/move_posts.php\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'po_pre_post_contents' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_bbcode\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_bbcode\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_bbcode\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($forum_user[\'pun_bbcode_enabled\'])
			{
				define(\'PUN_BBCODE_BAR_INCLUDE\', 1);
				include $ext_info[\'path\'].\'/bar.php\';
				$pun_bbcode_bar = new Pun_bbcode;
				$pun_bbcode_bar->render();
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'vt_quickpost_pre_message_box' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_bbcode\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_bbcode\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_bbcode\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($forum_user[\'pun_bbcode_enabled\'])
			{
				define(\'PUN_BBCODE_BAR_INCLUDE\', 1);
				include $ext_info[\'path\'].\'/bar.php\';
				$pun_bbcode_bar = new Pun_bbcode;
				$pun_bbcode_bar->render();
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ed_pre_message_box' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_bbcode\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_bbcode\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_bbcode\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($forum_user[\'pun_bbcode_enabled\'])
			{
				define(\'PUN_BBCODE_BAR_INCLUDE\', 1);
				include $ext_info[\'path\'].\'/bar.php\';
				$pun_bbcode_bar = new Pun_bbcode;
				$pun_bbcode_bar->render();
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'pun_pm_fn_send_form_pre_textarea_output' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_bbcode\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_bbcode\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_bbcode\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($forum_user[\'pun_bbcode_enabled\'])
			{
				define(\'PUN_BBCODE_BAR_INCLUDE\', 1);
				include $ext_info[\'path\'].\'/bar.php\';
				$pun_bbcode_bar = new Pun_bbcode;
				$pun_bbcode_bar->render();
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'aex_section_manage_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_repository\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_repository\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_repository\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/pun_repository.php\'))
	include $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/pun_repository.php\';
else
	include $ext_info[\'path\'].\'/lang/English/pun_repository.php\';

require_once $ext_info[\'path\'].\'/pun_repository.php\';

($hook = get_hook(\'pun_repository_pre_display_ext_list\')) ? eval($hook) : null;

?>
	<div class="main-subhead">
		<h2 class="hn"><span><?php echo $lang_pun_repository[\'PunBB Repository\'] ?></span></h2>
	</div>
	<div class="main-content main-extensions">
		<p class="content-options options"><a href="<?php echo $base_url ?>/admin/extensions.php?pun_repository_update&amp;csrf_token=<?php echo generate_form_token(\'pun_repository_update\') ?>"><?php echo $lang_pun_repository[\'Clear cache\'] ?></a></p>
<?php

if (!defined(\'PUN_REPOSITORY_EXTENSIONS_LOADED\') && file_exists(FORUM_CACHE_DIR.\'cache_pun_repository.php\'))
	include FORUM_CACHE_DIR.\'cache_pun_repository.php\';

if (!defined(\'FORUM_EXT_VERSIONS_LOADED\') && file_exists(FORUM_CACHE_DIR.\'cache_ext_version_notifications.php\'))
	include FORUM_CACHE_DIR.\'cache_ext_version_notifications.php\';

// Regenerate cache only if automatic updates are enabled and if the cache is more than 12 hours old
if (!defined(\'PUN_REPOSITORY_EXTENSIONS_LOADED\') || !defined(\'FORUM_EXT_VERSIONS_LOADED\') || ($pun_repository_extensions_timestamp < $forum_ext_versions_update_cache))
{
	$pun_repository_error = \'\';

	if (pun_repository_generate_cache($pun_repository_error))
	{
		require FORUM_CACHE_DIR.\'cache_pun_repository.php\';
	}
	else
	{

		?>
		<div class="ct-box warn-box">
			<p class="warn"><?php echo $pun_repository_error ?></p>
		</div>
		<?php

		// Stop processing hook
		return;
	}
}

$pun_repository_parsed = array();
$pun_repository_skipped = array();

// Display information about extensions in repository
foreach ($pun_repository_extensions as $pun_repository_ext)
{
	// Skip installed extensions
	if (isset($inst_exts[$pun_repository_ext[\'id\']]))
	{
		$pun_repository_skipped[\'installed\'][] = $pun_repository_ext[\'id\'];
		continue;
	}

	// Skip uploaded extensions (including incorrect ones)
	if (is_dir(FORUM_ROOT.\'extensions/\'.$pun_repository_ext[\'id\']))
	{
		$pun_repository_skipped[\'has_dir\'][] = $pun_repository_ext[\'id\'];
		continue;
	}

	// Check for unresolved dependencies
	if (isset($pun_repository_ext[\'dependencies\']))
		$pun_repository_ext[\'dependencies\'] = pun_repository_check_dependencies($inst_exts, $pun_repository_ext[\'dependencies\']);

	if (empty($pun_repository_ext[\'dependencies\'][\'unresolved\']))
	{
		// \'Download and install\' link
		$pun_repository_ext[\'options\'] = array(\'<a href="\'.$base_url.\'/admin/extensions.php?pun_repository_download_and_install=\'.$pun_repository_ext[\'id\'].\'&amp;csrf_token=\'.generate_form_token(\'pun_repository_download_and_install_\'.$pun_repository_ext[\'id\']).\'">\'.$lang_pun_repository[\'Download and install\'].\'</a>\');
	}
	else
		$pun_repository_ext[\'options\'] = array();

	$pun_repository_parsed[] = $pun_repository_ext[\'id\'];

	// Direct links to archives
	$pun_repository_ext[\'download_links\'] = array();
	foreach (array(\'zip\', \'tgz\', \'7z\') as $pun_repository_archive_type)
		$pun_repository_ext[\'download_links\'][] = \'<a href="\'.PUN_REPOSITORY_URL.\'/\'.$pun_repository_ext[\'id\'].\'/\'.$pun_repository_ext[\'id\'].\'.\'.$pun_repository_archive_type.\'">\'.$pun_repository_archive_type.\'</a>\';

	($hook = get_hook(\'pun_repository_pre_display_ext_info\')) ? eval($hook) : null;

	// Let\'s ptint it all out
?>
		<div class="ct-box info-box extension available" id="<?php echo $pun_repository_ext[\'id\'] ?>">
			<h3 class="ct-legend hn"><span><?php echo forum_htmlencode($pun_repository_ext[\'title\']).\' \'.$pun_repository_ext[\'version\'] ?></span></h3>
			<p><?php echo forum_htmlencode($pun_repository_ext[\'description\']) ?></p>
<?php

	// List extension dependencies
	if (!empty($pun_repository_ext[\'dependencies\'][\'dependency\']))
		echo \'
			<p>\', $lang_pun_repository[\'Dependencies:\'], \' \', implode(\', \', $pun_repository_ext[\'dependencies\'][\'dependency\']), \'</p>\';

?>
			<p><?php echo $lang_pun_repository[\'Direct download links:\'], \' \', implode(\' \', $pun_repository_ext[\'download_links\']) ?></p>
<?php

	// List unresolved dependencies
	if (!empty($pun_repository_ext[\'dependencies\'][\'unresolved\']))
		echo \'
			<div class="ct-box warn-box">
				<p class="warn">\', $lang_pun_repository[\'Resolve dependencies:\'], \' \', implode(\', \', array_map(create_function(\'$dep\', \'return \\\'<a href="#\\\'.$dep.\\\'">\\\'.$dep.\\\'</a>\\\';\'), $pun_repository_ext[\'dependencies\'][\'unresolved\'])), \'</p>
			</div>\';

	// Actions
	if (!empty($pun_repository_ext[\'options\']))
		echo \'
			<p class="options">\', implode(\' \', $pun_repository_ext[\'options\']), \'</p>\';

?>
		</div>
<?php

}

?>
		<div class="ct-box warn-box">
			<p class="warn"><?php echo $lang_pun_repository[\'Files mode and owner\'] ?></p>
		</div>
<?php

if (empty($pun_repository_parsed) && (count($pun_repository_skipped[\'installed\']) > 0 || count($pun_repository_skipped[\'has_dir\']) > 0))
{
	($hook = get_hook(\'pun_repository_no_extensions\')) ? eval($hook) : null;

	?>
		<div class="ct-box info-box">
			<p class="warn"><?php echo $lang_pun_repository[\'All installed or downloaded\'] ?></p>
		</div>
	<?php

}

($hook = get_hook(\'pun_repository_after_ext_list\')) ? eval($hook) : null;

?>
	</div>
<?php

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'aex_new_action' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_repository\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_repository\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_repository\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

// Clear pun_repository cache
if (isset($_GET[\'pun_repository_update\']))
{
	// Validate CSRF token
	if (!isset($_POST[\'csrf_token\']) && (!isset($_GET[\'csrf_token\']) || $_GET[\'csrf_token\'] !== generate_form_token(\'pun_repository_update\')))
		csrf_confirm_form();

	if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/pun_repository.php\'))
		include $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/pun_repository.php\';
	else
		include $ext_info[\'path\'].\'/lang/English/pun_repository.php\';

	@unlink(FORUM_CACHE_DIR.\'cache_pun_repository.php\');
	if (file_exists(FORUM_CACHE_DIR.\'cache_pun_repository.php\'))
		message($lang_pun_repository[\'Unable to remove cached file\'], \'\', $lang_pun_repository[\'PunBB Repository\']);

	redirect($base_url.\'/admin/extensions.php?section=manage\', $lang_pun_repository[\'Cache has been successfully cleared\']);
}

if (isset($_GET[\'pun_repository_download_and_install\']))
{
	$ext_id = preg_replace(\'/[^0-9a-z_]/\', \'\', $_GET[\'pun_repository_download_and_install\']);

	// Validate CSRF token
	if (!isset($_POST[\'csrf_token\']) && (!isset($_GET[\'csrf_token\']) || $_GET[\'csrf_token\'] !== generate_form_token(\'pun_repository_download_and_install_\'.$ext_id)))
		csrf_confirm_form();

	// TODO: Should we check again for unresolved dependencies here?

	if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/pun_repository.php\'))
		include $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/pun_repository.php\';
	else
		include $ext_info[\'path\'].\'/lang/English/pun_repository.php\';

	require_once $ext_info[\'path\'].\'/pun_repository.php\';

	($hook = get_hook(\'pun_repository_download_and_install_start\')) ? eval($hook) : null;

	// Download extension
	$pun_repository_error = pun_repository_download_extension($ext_id, $ext_data);

	if ($pun_repository_error == \'\')
	{
		if (empty($ext_data))
			redirect($base_url.\'/admin/extensions.php?section=manage\', $lang_pun_repository[\'Incorrect manifest.xml\']);

		// Validate manifest
		$errors = validate_manifest($ext_data, $ext_id);
		if (!empty($errors))
			redirect($base_url.\'/admin/extensions.php?section=manage\', $lang_pun_repository[\'Incorrect manifest.xml\']);

		// Everything is OK. Start installation.
		redirect($base_url.\'/admin/extensions.php?install=\'.urlencode($ext_id), $lang_pun_repository[\'Download successful\']);
	}

	($hook = get_hook(\'pun_repository_download_and_install_end\')) ? eval($hook) : null;
}

// Handling the download and update extension action
if (isset($_GET[\'pun_repository_download_and_update\']))
{
	$ext_id = preg_replace(\'/[^0-9a-z_]/\', \'\', $_GET[\'pun_repository_download_and_update\']);

	// Validate CSRF token
	if (!isset($_POST[\'csrf_token\']) && (!isset($_GET[\'csrf_token\']) || $_GET[\'csrf_token\'] !== generate_form_token(\'pun_repository_download_and_update_\'.$ext_id)))
		csrf_confirm_form();

	if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/pun_repository.php\'))
		include $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/pun_repository.php\';
	else
		include $ext_info[\'path\'].\'/lang/English/pun_repository.php\';

	require_once $ext_info[\'path\'].\'/pun_repository.php\';

	$pun_repository_error = \'\';

	($hook = get_hook(\'pun_repository_download_and_update_start\')) ? eval($hook) : null;

	pun_repository_rm_recursive(FORUM_ROOT.\'extensions/\'.$ext_id.\'.old\');

	// Check dependancies
	$query = array(
		\'SELECT\'	=> \'e.id\',
		\'FROM\'		=> \'extensions AS e\',
		\'WHERE\'		=> \'e.disabled=0 AND e.dependencies LIKE \\\'%|\'.$forum_db->escape($ext_id).\'|%\\\'\'
	);

	($hook = get_hook(\'aex_qr_get_disable_dependencies\')) ? eval($hook) : null;
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);

	if ($forum_db->num_rows($result) != 0)
	{
		$dependency = $forum_db->fetch_assoc($result);
		$pun_repository_error = sprintf($lang_admin[\'Disable dependency\'], $dependency[\'id\']);
	}

	if ($pun_repository_error == \'\' && ($ext_id != $ext_info[\'id\']))
	{
		// Disable extension
		$query = array(
			\'UPDATE\'	=> \'extensions\',
			\'SET\'		=> \'disabled=1\',
			\'WHERE\'		=> \'id=\\\'\'.$forum_db->escape($ext_id).\'\\\'\'
		);

		($hook = get_hook(\'aex_qr_update_disabled_status\')) ? eval($hook) : null;
		$forum_db->query_build($query) or error(__FILE__, __LINE__);

		// Regenerate the hooks cache
		require_once FORUM_ROOT.\'include/cache.php\';
		generate_hooks_cache();
	}

	if ($pun_repository_error == \'\')
	{
		if ($ext_id == $ext_info[\'id\'])
		{
			// Hey! That\'s me!
			// All the necessary files should be included before renaming old directory
			// NOTE: Self-updating is to be tested more in real-life conditions
			if (!defined(\'PUN_REPOSITORY_TAR_EXTRACT_INCLUDED\'))
				require $ext_info[\'path\'].\'/pun_repository_tar_extract.php\';
		}

		$pun_repository_error = pun_repository_download_extension($ext_id, $ext_data, FORUM_ROOT.\'extensions/\'.$ext_id.\'.new\'); // Download the extension

		if ($pun_repository_error == \'\')
		{
			if (is_writable(FORUM_ROOT.\'extensions/\'.$ext_id))
				pun_repository_dir_copy(FORUM_ROOT.\'extensions/\'.$ext_id.\'.new/\'.$ext_id, FORUM_ROOT.\'extensions/\'.$ext_id);
			else
				$pun_repository_error = sprintf($lang_pun_repository[\'Copy fail\'], FORUM_ROOT.\'extensions/\'.$ext_id);
		}
	}

	if ($pun_repository_error == \'\')
	{
		// Do we have extension data at all? :-)
		if (empty($ext_data))
			$errors = array(true);

		// Validate manifest
		if (empty($errors))
			$errors = validate_manifest($ext_data, $ext_id);

		if (!empty($errors))
			$pun_repository_error = $lang_pun_repository[\'Incorrect manifest.xml\'];
	}

	if ($pun_repository_error == \'\')
	{
		($hook = get_hook(\'pun_repository_download_and_update_ok\')) ? eval($hook) : null;

		// Everything is OK. Start installation.
		pun_repository_rm_recursive(FORUM_ROOT.\'extensions/\'.$ext_id.\'.new\');
		redirect($base_url.\'/admin/extensions.php?install=\'.urlencode($ext_id), $lang_pun_repository[\'Download successful\']);
	}

	($hook = get_hook(\'pun_repository_download_and_update_error\')) ? eval($hook) : null;

	// Enable extension
	$query = array(
		\'UPDATE\'	=> \'extensions\',
		\'SET\'		=> \'disabled=0\',
		\'WHERE\'		=> \'id=\\\'\'.$forum_db->escape($ext_id).\'\\\'\'
	);

	($hook = get_hook(\'aex_qr_update_enabled_status\')) ? eval($hook) : null;
	$forum_db->query_build($query) or error(__FILE__, __LINE__);

	// Regenerate the hooks cache
	require_once FORUM_ROOT.\'include/cache.php\';
	generate_hooks_cache();

	($hook = get_hook(\'pun_repository_download_and_update_end\')) ? eval($hook) : null;
}

// Do we have some error?
if (!empty($pun_repository_error))
{
	// Setup breadcrumbs
	$forum_page[\'crumbs\'] = array(
		array($forum_config[\'o_board_title\'], forum_link($forum_url[\'index\'])),
		array($lang_admin_common[\'Forum administration\'], forum_link($forum_url[\'admin_index\'])),
		array($lang_admin_common[\'Extensions\'], forum_link($forum_url[\'admin_extensions_manage\'])),
		array($lang_admin_common[\'Manage extensions\'], forum_link($forum_url[\'admin_extensions_manage\'])),
		$lang_pun_repository[\'PunBB Repository\']
	);

	($hook = get_hook(\'pun_repository__pre_header_load\')) ? eval($hook) : null;

	define(\'FORUM_PAGE_SECTION\', \'extensions\');
	define(\'FORUM_PAGE\', \'admin-extensions-pun-repository\');
	require FORUM_ROOT.\'header.php\';

	// START SUBST - <!-- forum_main -->
	ob_start();

	($hook = get_hook(\'pun_repository_display_error_output_start\')) ? eval($hook) : null;

?>
	<div class="main-subhead">
		<h2 class="hn"><span><?php echo $lang_pun_repository[\'PunBB Repository\'] ?></span></h2>
	</div>
	<div class="main-content">
		<div class="ct-box warn-box">
			<p class="warn"><?php echo $pun_repository_error ?></p>
		</div>
	</div>
<?php

	($hook = get_hook(\'pun_repository_display_error_pre_ob_end\')) ? eval($hook) : null;

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace(\'<!-- forum_main -->\', $tpl_temp, $tpl_main);
	ob_end_clean();
	// END SUBST - <!-- forum_main -->

	require FORUM_ROOT.\'footer.php\';
}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($section == \'manage_tags\')
			{
				//Get some info about topics with tags
				$topic_info = array();
				if (!empty($pun_tags[\'topics\']))
				{
					$pun_tags_query = array(
						\'SELECT\'	=>	\'id, subject\',
						\'FROM\'		=>	\'topics\',
						\'WHERE\'		=>	\'id IN (\'.implode(\',\', array_keys($pun_tags[\'topics\'])).\')\'
					);
					$pun_tags_result = $forum_db->query_build($pun_tags_query) or error(__FILE__, __LINE__);
					while ($cur_topic = $forum_db->fetch_assoc($pun_tags_result))
						$topic_info[$cur_topic[\'id\']] = $cur_topic[\'subject\'];
				}

				if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
					require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
				else
					require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';
				require $ext_info[\'path\'].\'/pun_tags_url.php\';

				if (isset($_POST[\'change_tags\']) && !empty($_POST[\'line_tags\']) && !empty($pun_tags[\'topics\']))
				{
					foreach ($_POST[\'line_tags\'] as $topic_id => $tag_line)
					{
						if (intval($topic_id) < 1)
							break;
						$cur_tags_new = pun_tags_parse_string(utf8_trim($tag_line));

						//All tags was removed?
						if (empty($cur_tags_new))
						{
							$pun_tags_query = array(
								\'DELETE\'	=>	\'topic_tags\',
								\'WHERE\'		=>	\'topic_id = \'.$topic_id
							);
							$forum_db->query_build($pun_tags_query) or error(__FILE__, __LINE__);
							continue;
						}

						//Collect old tags
						$cur_tags_old = array();
						if (!empty($pun_tags[\'topics\'][$topic_id]))
						{
							foreach ($pun_tags[\'topics\'][$topic_id] as $old_tag_id)
								$cur_tags_old[$old_tag_id] = $pun_tags[\'index\'][$old_tag_id];
						}
						//Nothing changed
						if (implode(\', \', $cur_tags_new) == implode(\', \', array_values($cur_tags_old)))
							continue;
						//This array contain indexes of processed new tags
						$processed_tags = array();
						//The array with tags for removal
						$remove_tags_id = array();
						foreach ($cur_tags_old as $tag_old_id => $tag_old)
						{
							$srch_index = array_search($tag_old, $cur_tags_new);
							//Tag was not changed
							if ($srch_index !== FALSE)
							{
								$processed_tags[] = $srch_index;
								continue;
							}

							//Was tag edited?
							$not_found_edited = TRUE;
							foreach ($cur_tags_new as $cur_tag_new)
							{
								if (strcasecmp($cur_tag_new, $tag_old) == 0)
								{
									$not_found_edited = FALSE;
									$edited_tag_id = $tag_old_id;
									$edited_tag = $cur_tag_new;
									break;
								}
							}

							//Tag removed?
							if ($not_found_edited)
							{
								$remove_tags_id[] = $tag_old_id;
								$processed_tags[] = $tag_old_id;
							}
							else
							{
								//Is this tag already persist in the tag list?
								$edited_tag_id_new = tag_cache_index($edited_tag);
								if ($edited_tag_id_new !== FALSE)
								{
									$pun_tags_query = array(
										\'UPDATE\'	=>	\'topic_tags\',
										\'SET\'		=>	\'tag_id = \'.$edited_tag_id_new,
										\'WHERE\'		=>	\'topic_id = \'.$topic_id.\' AND tag_id = \'.$edited_tag_id
									);
									$forum_db->query_build($pun_tags_query) or error(__FILE__, __LINE__);
								}
								else
									pun_tags_add_new($edited_tag, $topic_id);

								$remove_tags_id[] = $tag_old_id;
								$processed_tags[] = $tag_old_id;
							}
						}

						//Is there some new tags
						if (count($processed_tags) != count($cur_tags_new))
						{
							foreach ($cur_tags_new as $cur_new_tag_id => $cur_new_tag)
							{
								if (in_array($cur_new_tag_id, $processed_tags))
									continue;
								$tag_exist_index = tag_cache_index($cur_new_tag);
								if ($tag_exist_index === FALSE)
									pun_tags_add_new($cur_new_tag, $topic_id);
								else
									pun_tags_add_existing_tag($tag_exist_index, $topic_id);
							}
						}

						if (!empty($remove_tags_id))
						{
							$pun_tags_query = array(
								\'DELETE\'	=>	\'topic_tags\',
								\'WHERE\'		=>	\'topic_id = \'.$topic_id.\' AND tag_id IN (\'.implode(\',\', $remove_tags_id).\')\'
							);
							$forum_db->query_build($pun_tags_query) or error(__FILE__, __LINE__);
						}
					}
					pun_tags_remove_orphans();
					pun_tags_generate_cache();

					$forum_flash->add_info($lang_pun_tags[\'Redirect with changes\']);

					redirect(forum_link($pun_tags_url[\'Section pun_tags\']), $lang_pun_tags[\'Redirect with changes\']);
				}

				$forum_page[\'form_action\'] = forum_link($pun_tags_url[\'Section tags\']);
				$forum_page[\'item_count\'] = 1;

				$forum_page[\'table_header\'] = array();
				$forum_page[\'table_header\'][\'name\'] = \'<th class="tc1" scope="col">\'.$lang_pun_tags[\'Name topic\'].\'</th>\';
				$forum_page[\'table_header\'][\'tags\'] = \'<th class="tc2" scope="col">\'.$lang_pun_tags[\'Tags of topic\'].\'</th>\';

				// Setup breadcrumbs
				$forum_page[\'crumbs\'] = array(
					array($forum_config[\'o_board_title\'], forum_link($forum_url[\'index\'])),
					array($lang_admin_common[\'Forum administration\'], forum_link($forum_url[\'admin_index\'])),
					array($lang_admin_common[\'Management\'], forum_link($forum_url[\'admin_reports\'])),
					array($lang_pun_tags[\'Section tags\'], forum_link($pun_tags_url[\'Section tags\']))
				);

				define(\'FORUM_PAGE_SECTION\', \'management\');
				define(\'FORUM_PAGE\', \'admin-management-manage_tags\');
				require FORUM_ROOT.\'header.php\';

				ob_start();

				if (!empty($topic_info))
				{
					// Load the userlist.php language file
					if (file_exists(FORUM_ROOT.\'lang/\'.$forum_user[\'language\'].\'/userlist.php\'))
						require FORUM_ROOT.\'lang/\'.$forum_user[\'language\'].\'/userlist.php\';
					else
						require FORUM_ROOT.\'lang/English/userlist.php\';

					?>
					<div class="main-subhead">
						<h2 class="hn">
							<span><?php echo $lang_pun_tags[\'Section tags\']; ?></span>
						</h2>
					</div>
					<div class="main-content main-forum">
						<form class="frm-form" id="afocus" method="post" accept-charset="utf-8" action="<?php echo $forum_page[\'form_action\'] ?>">
							<div class="hidden">
								<input type="hidden" name="form_sent" value="1" />
								<input type="hidden" name="csrf_token" value="<?php echo generate_form_token($forum_page[\'form_action\']) ?>" />
							</div>
							<div class="ct-group">
								<table id="pun_tags_table" summary="<?php echo $lang_ul[\'Table summary\'] ?>">
									<thead>
										<tr><?php echo implode("\\n\\t\\t\\t\\t\\t\\t", $forum_page[\'table_header\'])."\\n" ?></tr>
									</thead>
									<tbody>
									<?php
										foreach ($topic_info as $topic_id => $topic_subject)
										{
											$tags_arr = $pun_tags[\'topics\'][$topic_id];
											$cur_tags_arr = array();
											foreach ($tags_arr as $tag_id)
												$cur_tags_arr[] = $pun_tags[\'index\'][$tag_id];

											?>
												<tr class="<?php echo ($forum_page[\'item_count\'] % 2 != 0) ? \'odd\' : \'even\' ?><?php echo ($forum_page[\'item_count\'] == 1) ? \' row1\' : \'\' ?>">
													<td class="tc0" scope="col"><a class="permalink" rel="bookmark" href="<?php echo forum_link($forum_url[\'topic\'], $topic_id) ?>"><?php echo forum_htmlencode($topic_subject) ?></a></td>
													<td class="tc1" scope="col"><input id="fld<?php echo $forum_page[\'item_count\']; ?>" type="text" value="<?php echo forum_htmlencode(implode(\', \', $cur_tags_arr)) ?>" name="line_tags[<?php echo $topic_id; ?>]"/></td>
												</tr>
											<?php
										}
									?>
									</tbody>
								</table>
							</div>
							<div class="frm-buttons">
								<span class="submit"><input type="submit" name="change_tags" value="<?php echo $lang_pun_tags[\'Submit changes\'] ?>" /></span>
							</div>
						</form>
					</div>
					<?php
				}
				else
				{
					?>
						<div class="main-subhead">
							<h2 class="hn">
								<span><?php echo $lang_pun_tags[\'Section tags\']; ?></span>
							</h2>
						</div>
						<div class="main-content main-forum">
							<div class="ct-box">
								<h3 class="hn"><span><?php echo $lang_pun_tags[\'No tags\']; ?></span></h3>
							</div>
						</div>

					<?php
				}

				$tpl_pun_tags = trim(ob_get_contents());
				$tpl_main = str_replace(\'<!-- forum_main -->\', $tpl_pun_tags, $tpl_main);
				ob_end_clean();

				require FORUM_ROOT.\'footer.php\';
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'aex_section_manage_pre_header_load' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_repository\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_repository\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_repository\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/pun_repository.php\'))
	include $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/pun_repository.php\';
else
	include $ext_info[\'path\'].\'/lang/English/pun_repository.php\';

require_once $ext_info[\'path\'].\'/pun_repository.php\';

if (!defined(\'PUN_REPOSITORY_EXTENSIONS_LOADED\') && file_exists(FORUM_CACHE_DIR.\'cache_pun_repository.php\'))
	include FORUM_CACHE_DIR.\'cache_pun_repository.php\';

if (!defined(\'FORUM_EXT_VERSIONS_LOADED\') && file_exists(FORUM_CACHE_DIR.\'cache_ext_version_notifications.php\'))
	include FORUM_CACHE_DIR.\'cache_ext_version_notifications.php\';

// Regenerate cache only if automatic updates are enabled and if the cache is more than 12 hours old
if (!defined(\'PUN_REPOSITORY_EXTENSIONS_LOADED\') || !defined(\'FORUM_EXT_VERSIONS_LOADED\') || ($pun_repository_extensions_timestamp < $forum_ext_versions_update_cache))
{
	if (pun_repository_generate_cache($pun_repository_error))
		require FORUM_CACHE_DIR.\'cache_pun_repository.php\';
}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'aex_section_manage_pre_ext_actions' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_repository\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_repository\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_repository\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (defined(\'PUN_REPOSITORY_EXTENSIONS_LOADED\') && isset($pun_repository_extensions[$id]) && version_compare($ext[\'version\'], $pun_repository_extensions[$id][\'version\'], \'<\') && is_writable(FORUM_ROOT.\'extensions/\'.$id))
{
	// Check for unresolved dependencies
	if (isset($pun_repository_extensions[$id][\'dependencies\']))
		$pun_repository_extensions[$id][\'dependencies\'] = pun_repository_check_dependencies($inst_exts, $pun_repository_extensions[$id][\'dependencies\']);

	if (empty($pun_repository_extensions[$id][\'dependencies\'][\'unresolved\']))
		$forum_page[\'ext_actions\'][] = \'<span><a href="\'.$base_url.\'/admin/extensions.php?pun_repository_download_and_update=\'.$id.\'&amp;csrf_token=\'.generate_form_token(\'pun_repository_download_and_update_\'.$id).\'">\'.$lang_pun_repository[\'Download and update\'].\'</a></span>\';
}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'co_common' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_repository\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_repository\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_repository\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$pun_extensions_used = array_merge(isset($pun_extensions_used) ? $pun_extensions_used : array(), array($ext_info[\'id\']));

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\'))
				require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/\'.$ext_info[\'id\'].\'.php\';
			else
				require $ext_info[\'path\'].\'/lang/English/\'.$ext_info[\'id\'].\'.php\';

			define(\'PUN_TAGS_CACHE_UPDATE\', 12);
			require_once $ext_info[\'path\'].\'/functions.php\';

			if (file_exists(FORUM_CACHE_DIR.\'cache_pun_tags.php\'))
				include FORUM_CACHE_DIR.\'cache_pun_tags.php\';
			// Regenerate cache
			if ((!defined(\'PUN_TAGS_LOADED\') || $pun_tags[\'cached\'] < (time() - 3600 * PUN_TAGS_CACHE_UPDATE)))
			{
				pun_tags_generate_cache();
				require FORUM_CACHE_DIR.\'cache_pun_tags.php\';
			}

			if (file_exists(FORUM_CACHE_DIR.\'cache_pun_tags_groups_perms.php\'))
				include FORUM_CACHE_DIR.\'cache_pun_tags_groups_perms.php\';
			// Regenerate cache if the it is more than $pun_cache_period hours old
			if ((!defined(\'PUN_TAGS_GROUPS_PERMS\') || $pun_tags_groups_perms[\'cached\'] < (time() - 3600 * PUN_TAGS_CACHE_UPDATE)))
			{
				pun_tags_generate_forum_perms_cache();
				require FORUM_CACHE_DIR.\'cache_pun_tags_groups_perms.php\';
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    2 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'logo\',
\'path\'			=> FORUM_ROOT.\'extensions/logo\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/logo\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!isset($logo)) {
	if ($forum_user[\'language\'] != \'English\' && file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/lang.php\')) {
		require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/lang.php\';
	} else {
		require $ext_info[\'path\'].\'/lang/English/lang.php\';
	}
}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'hd_main_elements' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

//Output of search results
			if ($forum_config[\'o_pun_tags_show\'] == \'1\' && in_array(FORUM_PAGE, array(\'index\', \'viewforum\', \'viewtopic\', \'searchtopics\', \'searchposts\')))
			{
				$output_results = array();
				switch (FORUM_PAGE)
				{
					case \'index\':
						if (isset($pun_tags[\'forums\']))
						{
							foreach ($pun_tags[\'forums\'] as $forum_id => $tags_list)
							{
								//Can user read this forum?
								if (in_array($forum_id, $pun_tags_groups_perms[$forum_user[\'group_id\']]))
								{
									foreach ($tags_list as $tag_id => $tag_weight)
										if (!isset($output_results[$tag_id]))
											$output_results[$tag_id] = array(\'tag\' => $pun_tags[\'index\'][$tag_id], \'weight\' => $tag_weight);
										else
											$output_results[$tag_id][\'weight\'] += $tag_weight;
								}
							}
						}
						break;

					case \'viewforum\':
						if (isset($pun_tags[\'forums\'][$id]))
						{
							foreach ($pun_tags[\'forums\'][$id] as $tag_id => $tag_weight)
							{
								$output_results[$tag_id] = array(\'tag\' => $pun_tags[\'index\'][$tag_id], \'weight\' => $tag_weight);
								//Determine tag weight
								foreach ($pun_tags[\'forums\'] as $forum_id => $tags_list)
									if ($forum_id != $id && in_array($forum_id, $pun_tags_groups_perms[$forum_user[\'group_id\']]) && in_array($tag_id, array_keys($tags_list)))
										$output_results[$tag_id][\'weight\'] += $tags_list[$tag_id];
							}
						}
						break;

					case \'viewtopic\':
						if (isset($pun_tags[\'topics\'][$id]))
						{
							foreach ($pun_tags[\'topics\'][$id] as $tag_id)
							{
								$output_results[$tag_id] = array(\'tag\' => $pun_tags[\'index\'][$tag_id], \'weight\' => $pun_tags[\'forums\'][$cur_topic[\'forum_id\']][$tag_id]);
								//Determine tag weight
								foreach ($pun_tags[\'forums\'] as $forum_id => $tags_list)
									if ($forum_id != $cur_topic[\'forum_id\'] && in_array($forum_id, $pun_tags_groups_perms[$forum_user[\'group_id\']]) && in_array($tag_id, array_keys($tags_list)))
										$output_results[$tag_id][\'weight\'] += $tags_list[$tag_id];
							}
						}
						break;

					case \'searchtopics\':
					case \'searchposts\':
						//This string will be replaced after getting search results
						$main_elements[\'<!-- forum_crumbs_end -->\'] .= \'<div id="brd-pun_tags"></div>\';
						break;
				}

				if (!empty($output_results))
				{
					$minfontsize = 100;
					$maxfontsize = 200;
					list($min_pop, $max_pop) = min_max_tags_weights($output_results);
					if ($max_pop - $min_pop == 0)
						$step = $maxfontsize - $minfontsize;
					else
						$step = ($maxfontsize - $minfontsize) / ($max_pop - $min_pop);

					uasort($output_results, \'compare_tags\');
					$output_results = array_tags_slice($output_results);
					$results = array();
					foreach ($output_results as $tag_id => $tag_info)
					{
						$results[] = pun_tags_get_link(round(($tag_info[\'weight\'] - $min_pop) * $step + $minfontsize), $tag_id, $tag_info[\'weight\'], $tag_info[\'tag\']);
					}
					$main_elements[\'<!-- forum_crumbs_end -->\'] .= \'<div id="brd-pun_tags"><ul>\'.implode($forum_config[\'o_pun_tags_separator\'], $results).\'</ul></div>\';
					unset($minfontsize, $maxfontsize, $step, $results, $min_pop, $max_pop);
				}
				unset($output_results, $tags_weights);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'se_results_pre_header_load' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($action == \'tag\')
			{
				// Regenerate paging links
				$tag_id = isset($_GET[\'tag_id\']) ? intval($_GET[\'tag_id\']) : 0;
				if ($tag_id >= 1)
					$forum_page[\'page_post\'][\'paging\'] = \'<p class="paging"><span class="pages">\'.$lang_common[\'Pages\'].\'</span> \'.paginate($forum_page[\'num_pages\'], $forum_page[\'page\'], $forum_url[\'search_tag\'], $lang_common[\'Paging separator\'], $tag_id).\'</p>\';
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'mr_confirm_split_posts_form_submitted' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!empty($_POST[\'pun_tags\']) && $forum_user[\'g_pun_tags_allow\'])
				$new_tags = pun_tags_parse_string(utf8_trim($_POST[\'pun_tags\']));

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'fn_add_topic_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

global $new_tags, $pun_tags, $forum_user;

			// Add tags to DB
			if (!empty($new_tags) && $forum_user[\'g_pun_tags_allow\'])
			{
				$search_arr = isset($pun_tags[\'index\']) ? $pun_tags[\'index\'] : array();
				foreach ($new_tags as $pun_tag)
				{
					$tag_id = array_search($pun_tag, $search_arr);
					if ($tag_id !== FALSE)
						pun_tags_add_existing_tag($tag_id, $new_tid);
					else
						pun_tags_add_new($pun_tag, $new_tid);
				}
				pun_tags_generate_cache();
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'fn_delete_topic_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

// Remove topic tags
			pun_tags_remove_topic_tags($topic_id);
			pun_tags_remove_orphans();
			pun_tags_generate_cache();

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
    1 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_karma\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_karma\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_karma\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!empty($post_ids))
{
	$query = array(
		\'DELETE\'	=>	\'pun_karma\',
		\'WHERE\'		=>	\'post_id IN(\'.implode(\',\', $post_ids).\')\'
	);
	$forum_db->query_build($query) or error(__FILE__, __LINE__);
}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ed_pre_post_edited' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($can_edit_subject && $forum_user[\'g_pun_tags_allow\'])
			{
				//Parse the string
				if (isset($_POST[\'pun_tags\']))
					$new_tags = pun_tags_parse_string(utf8_trim($_POST[\'pun_tags\']));
				if (empty($new_tags))
				{
					if (isset($pun_tags[\'topics\'][$cur_post[\'tid\']]))
					{
						pun_tags_remove_topic_tags($cur_post[\'tid\']);
						$update_cache = TRUE;
					}
				}
				else
				{
					//Determine old tags
					$old_tags = array();
					if (!empty($pun_tags[\'topics\'][$cur_post[\'tid\']]))
					{
						foreach ($pun_tags[\'topics\'][$cur_post[\'tid\']] as $old_tagid)
							$old_tags[$old_tagid] = $pun_tags[\'index\'][$old_tagid];
					}

					//Tags for removing
					$remove_tags = array_diff($old_tags, $new_tags);
					if (!empty($remove_tags))
					{
						$pun_tags_query = array(
							\'DELETE\'	=>	\'topic_tags\',
							\'WHERE\'		=>	\'topic_id = \'.$cur_post[\'tid\'].\' AND tag_id IN (\'.implode(\',\', array_keys($remove_tags)).\')\'
						);
						$forum_db->query_build($pun_tags_query) or error(__FILE__, __LINE__);
						$update_cache = TRUE;
					}

					$search_arr = isset($pun_tags[\'index\']) ? $pun_tags[\'index\'] : array();
					foreach ($new_tags as $tag)
					{
						//Have we current tag?
						if (in_array($tag, $old_tags))
							continue;
						$tag_id = array_search($tag, $search_arr);
						if ($tag_id === FALSE)
							pun_tags_add_new($tag, $cur_post[\'tid\']);
						else
							pun_tags_add_existing_tag($tag_id, $cur_post[\'tid\']);
						$update_cache = TRUE;
					}
				}

				if (!empty($update_cache))
				{
					pun_tags_remove_orphans();
					pun_tags_generate_cache();
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ca_fn_prune_qr_prune_subscriptions' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$query_tags = array(
				\'DELETE\'	=>	\'topic_tags\',
				\'WHERE\'		=>	\'topic_id IN(\'.$topic_ids.\')\'
			);
			$forum_db->query_build($query_tags) or error(__FILE__, __LINE__);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'acg_del_cat_pre_redirect' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

pun_tags_remove_orphans();
			pun_tags_generate_cache();

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'afo_del_forum_pre_redirect' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

pun_tags_remove_orphans();
			pun_tags_generate_cache();
			require_once $ext_info[\'path\'].\'/functions.php\';
			pun_tags_generate_forum_perms_cache();

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'mr_confirm_move_topics_pre_redirect' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

pun_tags_generate_cache();

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'mr_confirm_split_posts_pre_confirm_checkbox' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($fid)
			{
				$res_tags = array();
				if (isset($pun_tags[\'topics\'][$tid]))
				{

					foreach ($pun_tags[\'topics\'][$tid] as $tag_id)
						foreach ($pun_tags[\'index\'] as $tag)
							if ($tag[\'tag_id\'] == $tag_id)
								$res_tags[] = $tag[\'tag\'];
				}

				?>
				<div class="sf-box text">
						<label for="fld<?php echo ++$forum_page[\'fld_count\'] ?>"><span><?php echo $lang_pun_tags[\'Topic tags\']; ?></span><small><?php echo $lang_pun_tags[\'Enter tags\']; ?></small></label><br />
						<span class="fld-input"><input id="fld<?php echo $forum_page[\'fld_count\'] ?>" type="text" name="pun_tags" value="<?php if (!empty($res_tags)) echo implode(\', \', $res_tags); else echo \'\';  ?>" size="70" maxlength="100"/></span>
				</div>
			<?php

			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'se_post_results_fetched' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!empty($search_set))
			{
				//Array with tags id
				$tags = array();
				//Array with processed topics
				$processed_topics = array();
				foreach ($search_set as $res)
				{
					if (!isset($pun_tags[\'topics\'][$res[\'tid\']]) || in_array($res[\'tid\'], $processed_topics))
						continue;

					$processed_topics[] = $res[\'tid\'];
					$tags = array_merge($tags, array_diff($pun_tags[\'topics\'][$res[\'tid\']], $tags));
				}
				//Array with tags and weights
				$tags_results = array();
				if (!empty($tags))
				{
					//Calculation of tags weight
					foreach ($pun_tags_groups_perms[$forum_user[\'group_id\']] as $forum_id)
					{
						if (!isset($pun_tags[\'forums\'][$forum_id]))
							continue;
						//Calcullate common keys in arrays
						$tmp = array_intersect($tags, array_keys($pun_tags[\'forums\'][$forum_id]));
						foreach ($tmp as $cur_tag)
						{
							if (!isset($tags_results[$cur_tag]))
								$tags_results[$cur_tag] = array(\'tag\' => $pun_tags[\'index\'][$cur_tag], \'weight\' => $pun_tags[\'forums\'][$forum_id][$cur_tag]);
							else
								$tags_results[$cur_tag][\'weight\'] += $pun_tags[\'forums\'][$forum_id][$cur_tag];
						}
					}
					unset($tmp);
				}
				unset($tags);
				if (!empty($tags_results))
				{
					$minfontsize = 100;
					$maxfontsize = 200;
					list($min_pop, $max_pop) = min_max_tags_weights($tags_results);
					if ($max_pop - $min_pop == 0)
						$step = $maxfontsize - $minfontsize;
					else
						$step = ($maxfontsize - $minfontsize) / ($max_pop - $min_pop);

					uasort($tags_results, \'compare_tags\');
					$tags_results = array_tags_slice($tags_results);
					$ouput_results = array();
					foreach ($tags_results as $tag_id => $tag_info)
						$ouput_results[] = pun_tags_get_link(round(($tag_info[\'weight\'] - $min_pop) * $step + $minfontsize), $tag_id, $tag_info[\'weight\'], $tag_info[\'tag\']);
					unset($minfontsize, $maxfontsize, $step, $tags_results, $min_pop, $max_pop);
				}
				unset($tags_results);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'sf_fn_generate_action_search_query_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($action == \'tag\')
			{
				$tag_id = isset($_GET[\'tag_id\']) ? intval($_GET[\'tag_id\']) : 0;
				if ($tag_id < 1)
					message($lang_common[\'Bad request\']);
				global $pun_tags;
				if (isset($pun_tags[\'topics\']))
				{
					foreach ($pun_tags[\'topics\'] as $topic_id => $tags)
						if (in_array($tag_id, $tags))
							$search_ids[] = $topic_id;
					if (empty($search_ids))
						message($lang_common[\'Bad request\']);
				}
				$query = array(
					\'SELECT\'	=> \'t.id AS tid, t.poster, t.subject, t.first_post_id, t.posted, t.last_post, t.last_post_id, t.last_poster, t.num_replies, t.closed, t.sticky, t.forum_id, f.forum_name\',
					\'FROM\'		=> \'topics AS t\',
					\'JOINS\'		=> array(
						array(
							\'INNER JOIN\'	=> \'forums AS f\',
							\'ON\'			=> \'f.id=t.forum_id\'
						),
						array(
							\'LEFT JOIN\'		=> \'forum_perms AS fp\',
							\'ON\'			=> \'(fp.forum_id=f.id AND fp.group_id=\'.$forum_user[\'g_id\'].\')\'
						)
					),
					\'WHERE\'		=> \'(fp.read_forum IS NULL OR fp.read_forum=1) AND t.id IN(\'.implode(\',\', $search_ids).\')\',
					\'ORDER BY\'	=> \'t.last_post DESC\'
				);
				// With "has posted" indication
				if (!$forum_user[\'is_guest\'] && $forum_config[\'o_show_dot\'] == \'1\')
				{
					$subquery = array(
						\'SELECT\'	=> \'COUNT(p.id)\',
						\'FROM\'		=> \'posts AS p\',
						\'WHERE\'		=> \'p.poster_id=\'.$forum_user[\'id\'].\' AND p.topic_id=t.id\'
					);

					$query[\'SELECT\'] .= \', (\'.$forum_db->query_build($subquery, true).\') AS has_posted\';
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ft_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($forum_config[\'o_pun_tags_show\'] == 1)
			{
				if (!empty($ouput_results))
					$tpl_main = str_replace(\'<div id="brd-pun_tags"></div>\', \'<div id="brd-pun_tags"><ul>\'.implode($forum_config[\'o_pun_tags_separator\'], $ouput_results).\'</ul></div>\', $tpl_main);
				else
					$tpl_main = str_replace(\'<div id="brd-pun_tags"></div>\', \'\', $tpl_main);
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'sf_fn_validate_actions_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$valid_actions[] = \'tag\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'afo_save_forum_pre_redirect' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

require_once $ext_info[\'path\'].\'/functions.php\';
			pun_tags_generate_forum_perms_cache();

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'afo_revert_perms_form_submitted' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

require_once $ext_info[\'path\'].\'/functions.php\';
			pun_tags_generate_forum_perms_cache();

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'agr_del_group_pre_redirect' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_tags\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_tags\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_tags\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

require_once $ext_info[\'path\'].\'/functions.php\';
			pun_tags_generate_forum_perms_cache();

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'es_essentials' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_jquery\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_jquery\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_jquery\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

define(\'PUN_JQUERY_INCLUDE_METHOD_LOCAL\', 0);
			define(\'PUN_JQUERY_INCLUDE_METHOD_GOOGLE_CDN\', 1);
			define(\'PUN_JQUERY_INCLUDE_METHOD_MICROSOFT_CDN\', 2);
			define(\'PUN_JQUERY_INCLUDE_METHOD_JQUERY_CDN\', 3);

			define(\'PUN_JQUERY_VERSION\', \'1.7.1\');

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'aop_features_gzip_fieldset_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_jquery\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_jquery\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_jquery\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!isset($lang_pun_jquery)) {
				if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/lang.php\')) {
					require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'/lang.php\';
				} else {
					require $ext_info[\'path\'].\'/lang/English/lang.php\';
				}
			}

			// Reset counter
			$forum_page[\'group_count\'] = $forum_page[\'item_count\'] = 0;
?>
			<div class="content-head">
				<h2 class="hn"><span><?php echo sprintf($lang_pun_jquery[\'Setup jquery\'], PUN_JQUERY_VERSION) ?></span></h2>
			</div>

			<fieldset class="frm-group group<?php echo ++$forum_page[\'group_count\'] ?>">
				<legend class="group-legend"><strong><?php echo sprintf($lang_pun_jquery[\'Setup jquery legend\'], PUN_JQUERY_VERSION) ?></strong></legend>
				<fieldset class="mf-set set<?php echo ++$forum_page[\'item_count\'] ?>">
					<legend><span><?php echo $lang_pun_jquery[\'Include method\'] ?></span></legend>
					<div class="mf-box">
						<div class="mf-item">
							<span class="fld-input"><input type="radio" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="form[pun_jquery_include_method]" value="<?php echo PUN_JQUERY_INCLUDE_METHOD_LOCAL; ?>"<?php if ($forum_config[\'o_pun_jquery_include_method\'] == PUN_JQUERY_INCLUDE_METHOD_LOCAL) echo \' checked="checked"\' ?> /></span>
							<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><?php echo $lang_pun_jquery[\'Include method local label\'] ?></label>
						</div>
						<div class="mf-item">
							<span class="fld-input"><input type="radio" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="form[pun_jquery_include_method]" value="<?php echo PUN_JQUERY_INCLUDE_METHOD_GOOGLE_CDN; ?>"<?php if ($forum_config[\'o_pun_jquery_include_method\'] == PUN_JQUERY_INCLUDE_METHOD_GOOGLE_CDN) echo \' checked="checked"\' ?> /></span>
							<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><?php echo $lang_pun_jquery[\'Include method google label\'] ?></label>
						</div>
						<div class="mf-item">
							<span class="fld-input"><input type="radio" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="form[pun_jquery_include_method]" value="<?php echo PUN_JQUERY_INCLUDE_METHOD_MICROSOFT_CDN; ?>"<?php if ($forum_config[\'o_pun_jquery_include_method\'] == PUN_JQUERY_INCLUDE_METHOD_MICROSOFT_CDN) echo \' checked="checked"\' ?> /></span>
							<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><?php echo $lang_pun_jquery[\'Include method microsoft label\'] ?></label>
						</div>
						<div class="mf-item">
							<span class="fld-input"><input type="radio" id="fld<?php echo ++$forum_page[\'fld_count\'] ?>" name="form[pun_jquery_include_method]" value="<?php echo PUN_JQUERY_INCLUDE_METHOD_JQUERY_CDN; ?>"<?php if ($forum_config[\'o_pun_jquery_include_method\'] == PUN_JQUERY_INCLUDE_METHOD_JQUERY_CDN) echo \' checked="checked"\' ?> /></span>
							<label for="fld<?php echo $forum_page[\'fld_count\'] ?>"><?php echo $lang_pun_jquery[\'Include method jquery label\'] ?></label>
						</div>
					</div>
				</fieldset>
			</fieldset>

<?php

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'vt_qr_get_posts' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_karma\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_karma\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_karma\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$query[\'SELECT\'] .= \', p.karma AS post_karma, u.karma AS user_karma\';
$pun_karma_posts = array();
$pun_karma_authors = array();

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'vt_row_pre_post_actions_merge' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_karma\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_karma\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_karma\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (!is_null($cur_post[\'user_karma\']) && !isset($user_data_cache[$cur_post[\'poster_id\']][\'author_info\']))
	$forum_page[\'author_info\'][\'karma\'] = \'<li><span>\'.$lang_pun_karma[\'User Karma\'].\' <strong>\'.forum_number_format($cur_post[\'user_karma\']).\'</strong></span></li>\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'vt_post_loop_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_karma\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_karma\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_karma\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$pun_karma_posts[$cur_post[\'id\']] = $cur_post[\'post_karma\'];
$pun_karma_authors[$cur_post[\'id\']] = $cur_post[\'poster_id\'];

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'vt_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_karma\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_karma\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_karma\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$pun_karma_query = array(
	\'SELECT\'	=>	\'post_id\',
	\'FROM\'		=>	\'pun_karma\',
	\'WHERE\'		=>	\'user_id = \'.$forum_user[\'id\'].\' AND post_id IN (\'.implode(\',\', array_keys($pun_karma_posts)).\')\'
);
$pun_karma_result = $forum_db->query_build($pun_karma_query) or error(__FILE__, __LINE__);

$user_karma_posts = array();
if ($forum_db->num_rows($pun_karma_result) > 0)
{
	while ($cur_id = $forum_db->fetch_assoc($pun_karma_result))
		$user_karma_posts[] = $cur_id[\'post_id\'];
}

$buffer = forum_trim(ob_get_contents());
$karma_matches = array();
preg_match_all(\'~<p class="post-karma">([0-9]+)</p>~\', $buffer, $karma_matches);
foreach ($karma_matches[0] as $match_index => $match_string)
{
	$post_karma = \'\';
	if (!is_null($pun_karma_posts[$karma_matches[1][$match_index]]))
		$post_karma = \'<strong>\'.($pun_karma_posts[$karma_matches[1][$match_index]] === \'0\' ? \'0\' : ($pun_karma_posts[$karma_matches[1][$match_index]] > 0 ? \'+\' : \'&minus;\').abs($pun_karma_posts[$karma_matches[1][$match_index]])).\'</strong>\';
	//Is user author of post?
	if ($pun_karma_authors[$karma_matches[1][$match_index]] == $forum_user[\'id\'])
		$post_karma = \'<p class="post-karma">\'.$post_karma.\'</p>\';
	else
	{
		//User vote for this post?
		if (in_array($karma_matches[1][$match_index], $user_karma_posts))
			$post_karma = \'<p class="post-karma">\'.$post_karma.\' <a href="\'.forum_link($forum_url[\'karmacancel\'], array($karma_matches[1][$match_index], generate_form_token(\'karmacancel\'.$karma_matches[1][$match_index]))).\'"><img src="\'.$ext_info[\'url\'].\'/icons/cancel.png" alt="\'.$lang_pun_karma[\'Alt cancel\'].\'" /></a></p>\';
		else
			$post_karma = \'<p class="post-karma"><a href="\'.forum_link($forum_url[\'karmaplus\'], array($karma_matches[1][$match_index], generate_form_token(\'karmaplus\'.$karma_matches[1][$match_index]))).\'"><img src="\'.$ext_info[\'url\'].\'/icons/rate_yes.png" alt="\'.$lang_pun_karma[\'Alt thumbs up\'].\'"/></a> \'.$post_karma.($forum_config[\'o_pun_karma_minus_cancel\'] == \'0\' ? \' <a href="\'.forum_link($forum_url[\'karmaminus\'], array($karma_matches[1][$match_index], generate_form_token(\'karmaminus\'.$karma_matches[1][$match_index]))).\'"><img src="\'.$ext_info[\'url\'].\'/icons/rate_no.png" alt="\'.$lang_pun_karma[\'Alt thumbs down\'].\'" /></a>\' : \'\').\'</p>\';
	}
	$buffer = str_replace($match_string, $post_karma, $buffer);
}
$tpl_main = str_replace(\'<!-- forum_main -->\', $buffer, $tpl_main);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'fn_delete_post_end' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'pun_karma\',
\'path\'			=> FORUM_ROOT.\'extensions/pun_karma\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/pun_karma\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$query = array(
	\'DELETE\'	=>	\'pun_karma\',
	\'WHERE\'		=>	\'post_id = \'.$post_id
);
$forum_db->query_build($query) or error(__FILE__, __LINE__);

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ps_preparse_tags_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'nya_hide\',
\'path\'			=> FORUM_ROOT.\'extensions/nya_hide\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/nya_hide\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

// add our tag to the list
			$tags[] = \'hide\';
			$tags_fix[] = \'hide\';
			$tags_block[] = \'hide\';

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'ps_parse_message_pre_split' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'nya_hide\',
\'path\'			=> FORUM_ROOT.\'extensions/nya_hide\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/nya_hide\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

global $forum_url;

			if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'.php\'))
				require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'.php\';
			else
				require $ext_info[\'path\'].\'/lang/English.php\';
		
			if (strpos($text, \'hide\') !== false && strpos($text, \'/hide\') !== false)
			{
				if ($forum_user[\'is_guest\'])
				{
					$text = preg_replace(\'#\\[hide\\](.*?)\\[\\/hide\\]#si\', \'[code]\'.sprintf($lang_hide[\'Hidden text guest\'], \'<a href="\'.forum_link($forum_url[\'login\']).\'">\'.$lang_hide[\'login\'].\'</a>\').\'[/code]\', $text);
					$text = preg_replace(\'#\\[hide=([0-9]*)](.*?)\\[/hide\\]#si\', \'[code]\'.sprintf($lang_hide[\'Hidden text guest\'], \'<a href="\'.forum_link($forum_url[\'login\']).\'">\'.$lang_hide[\'login\'].\'</a>\').\'[/code]\', $text);
				}
				else if ($forum_user[\'karma\']<$forum_config[\'o_nya_hide_treshold\'])
				{
					$text = preg_replace(\'#\\[hide\\](.*?)\\[\\/hide\\]#si\', \'[code]\'.sprintf($lang_hide[\'Hidden text low karma\'], \'<a href="\'.forum_link($forum_url[\'login\']).\'">\'.$lang_hide[\'login\'].\'</a>\').\'[/code]\', $text);
					$text = preg_replace(\'#\\[hide=([0-9]*)](.*?)\\[/hide\\]#si\', \'[code]\'.sprintf($lang_hide[\'Hidden text low karma\'], \'<a href="\'.forum_link($forum_url[\'login\']).\'">\'.$lang_hide[\'login\'].\'</a>\').\'[/code]\', $text);
				}
				else if ($forum_user[\'is_admmod\'])
				{
					$text = preg_replace(\'#\\[hide=([0-9]*)](.*?)\\[/hide\\]#si\', \'</p><div class="hidebox"><cite>\'.$lang_hide[\'Hidden text\'].\'[$1]:</cite><blockquote><p><i>$2</i></p></blockquote></div><p>\', $text);
					$text = preg_replace(\'#\\[hide](.*?)\\[/hide\\]#si\', \'</p><div class="hidebox"><cite>\'.$lang_hide[\'Hidden text\'].\':</cite><blockquote><p><i>$1</i></p></blockquote></div><p>\', $text);
				}
				else 
				{
					$text = preg_replace(\'#\\[hide](.*?)\\[/hide\\]#si\', \'</p><div class="hidebox"><cite>\'.$lang_hide[\'Hidden text\'].\':</cite><blockquote><p><i>$1</i></p></blockquote></div><p>\', $text);
					
					$occurances = preg_match_all("#\\[hide\\=(.+?)\\](.+?)\\[/hide\\]#si", $text, $temp);
					for($i=0;$i<$occurances;$i++) 
					{ 
						preg_match("#\\[hide\\=(.+?)\\](.+?)\\[/hide\\]#si", $temp[0][$i],$hide_count);
						if($forum_user[\'num_posts\'] >= $hide_count[1])
						{
							$text_hide = preg_replace(\'#\\[hide=([0-9]*)](.*?)\\[/hide\\]#si\', \'</p><div class="hidebox"><cite>\'.$lang_hide[\'Hidden text\'].\'[$1]:</cite><blockquote><p><i>$2</i></p></blockquote></div><p>\', $temp[0][$i]);
						}
						else
						{
							$text_hide = preg_replace("#\\[hide=([0-9]*)](.*?)\\[/hide\\]#si", \'<b>[\'.$lang_hide[\'Hidden count begin\'].\' \'.$hide_count[1].\' \'.$lang_hide[\'Hidden count end\'].\']</b>\', $temp[0][$i]);
							
						}
						if (isset($text_hide))
						{
							$text = str_replace($temp[0][$i], $text_hide, $text);
						}
					}
				}
				
				preg_match("#\\[hide\\=gr(.+?)\\](.+?)\\[/hide\\]#si", $text, $hide_group);
				if (strpos($text, \'hide=gr\') !== false && strpos($text, \'/hide\') !== false)
				{
					$occurances = preg_match_all("#\\[hide\\=gr(.+?)\\](.+?)\\[/hide\\]#si", $text, $temp);
					for($i=0;$i<$occurances;$i++) 
					{ 
						preg_match("#\\[hide\\=gr(.+?)\\](.+?)\\[/hide\\]#si", $temp[0][$i],$hide_group);
						if ($forum_user[\'is_guest\'])
						{
							$text_hide = preg_replace(\'#\\[hide\\=gr(.+?)\\](.+?)\\[/hide\\]#si\', \'[code]\'.sprintf($lang_hide[\'Hidden text guest\'], \'<a href="\'.forum_link($forum_url[\'login\']).\'">\'.$lang_hide[\'login\'].\'</a>\').\'[/code]\', $temp[0][$i]);
						}
						else if($forum_user[\'g_id\'] == $hide_group[1] || $forum_user[\'is_admmod\'])
						{
							$text_hide = preg_replace(\'#\\[hide\\=gr(.+?)\\](.+?)\\[/hide\\]#si\', \'</p><div class="hidebox"><cite>\'.$lang_hide[\'Hidden text group\'].\'[$1]:</cite><blockquote><p><i>$2</i></p></blockquote></div><p>\', $temp[0][$i]);
						}
						else
						{
							$text_hide = preg_replace("#\\[hide\\=gr(.+?)\\](.+?)\\[/hide\\]#si", \'<b>[\'.$lang_hide[\'Hidden text group\'].\' \'.$hide_group[1].\']</b>\', $temp[0][$i]);
						}
						if (isset($text_hide))
						{
							$text = str_replace($temp[0][$i], $text_hide, $text);
						}
					}
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'po_modify_quote_info' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'nya_hide\',
\'path\'			=> FORUM_ROOT.\'extensions/nya_hide\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/nya_hide\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$text = $quote_info[\'message\'];
			if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'.php\'))
				require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'.php\';
			else
				require $ext_info[\'path\'].\'/lang/English.php\';

			if (!$forum_user[\'is_admmod\'] && strpos($text, \'hide\') !== false && strpos($text, \'/hide\') !== false)
			{
				if ($forum_user[\'is_guest\'])
				{
					$text = preg_replace(\'#\\[hide\\](.*?)\\[\\/hide\\]#si\', $lang_hide[\'Hidden text\'], $text);
					$text = preg_replace(\'#\\[hide=([0-9]*)](.*?)\\[/hide\\]#si\', $lang_hide[\'Hidden text\'], $text);
				}
				else if ($forum_user[\'karma\']<=$forum_config[\'o_nya_hide_treshold\'])
				{
$text = preg_replace(\'#\\[hide\\](.*?)\\[\\/hide\\]#si\', $lang_hide[\'Hidden text low karma\'], $text);
					$text = preg_replace(\'#\\[hide=([0-9]*)](.*?)\\[/hide\\]#si\', $lang_hide[\'Hidden text low karma\'], $text);

				}
				else
				{
					$occurances = preg_match_all("#\\[hide\\=.+?\\](.+?)\\[/hide\\]#si", $text, $temp);
					for($i=0;$i<$occurances;$i++)
					{
						preg_match("#\\[hide\\=(.+?)\\].+?\\[/hide\\]#s", $temp[0][$i],$hide_count);

						if($forum_user[\'num_posts\'] < $hide_count[1])
						{
							$text_hide = preg_replace("#\\[hide=([0-9]*)](.*?)\\[/hide\\]#si", $lang_hide[\'Hidden text\'], $temp[0][$i]);
							$text = str_replace($temp[0][$i], $text_hide, $text);
						}
					}
				}

				preg_match("#\\[hide\\=gr(.+?)\\](.+?)\\[/hide\\]#si", $text, $hide_group);
				if (isset($hide_group[1]))
				{
					$occurances = preg_match_all("#\\[hide\\=gr(.+?)\\](.+?)\\[/hide\\]#si", $text, $temp);
					for($i=0;$i<$occurances;$i++)
					{
						preg_match("#\\[hide\\=gr(.+?)\\](.+?)\\[/hide\\]#si", $temp[0][$i],$hide_group);
						if($forum_user[\'g_id\'] != $hide_group[1])
						{
							$text_hide = preg_replace("#\\[hide\\=gr(.+?)\\](.+?)\\[/hide\\]#si", $lang_hide[\'Hidden text group\'].\' \'.$hide_group[1], $temp[0][$i]);
							$text = str_replace($temp[0][$i], $text_hide, $text);
						}
					}
				}
			}
			$quote_info[\'message\'] = $text;

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'fn_send_forum_subscriptions_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'nya_hide\',
\'path\'			=> FORUM_ROOT.\'extensions/nya_hide\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/nya_hide\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (isset($post_info[\'message\']))
				$text = $post_info[\'message\'];
			else
				$text = $topic_info[\'message\'];

			if (strpos($text, \'hide\') !== false && strpos($text, \'/hide\') !== false)
			{
				$text = preg_replace(\'#\\[hide\\](.*?)\\[\\/hide\\]#si\', \'Hidden text\', $text);
				$text = preg_replace(\'#\\[hide=([0-9]*)](.*?)\\[/hide\\]#si\', \'Hidden text\', $text);
				$text = preg_replace(\'#\\[hide\\=gr(.+?)\\](.+?)\\[/hide\\]#si\', \'Hidden text\', $text);
			}
			$post_info[\'message\'] = $text;

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'fn_send_subscriptions_start' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'nya_hide\',
\'path\'			=> FORUM_ROOT.\'extensions/nya_hide\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/nya_hide\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (isset($post_info[\'message\']))
				$text = $post_info[\'message\'];
			else
				$text = $topic_info[\'message\'];

			if (strpos($text, \'hide\') !== false && strpos($text, \'/hide\') !== false)
			{
				$text = preg_replace(\'#\\[hide\\](.*?)\\[\\/hide\\]#si\', \'Hidden text\', $text);
				$text = preg_replace(\'#\\[hide=([0-9]*)](.*?)\\[/hide\\]#si\', \'Hidden text\', $text);
				$text = preg_replace(\'#\\[hide\\=gr(.+?)\\](.+?)\\[/hide\\]#si\', \'Hidden text\', $text);
			}
			$post_info[\'message\'] = $text;

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'pun_bbcode_pre_buttons_output' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'nya_hide\',
\'path\'			=> FORUM_ROOT.\'extensions/nya_hide\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/nya_hide\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

$this->add_button(array(\'name\'  => \'hide\', \'title\' => \'hide\', \'tag\' => \'hide\', \'image\' => false));

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'he_new_bbcode_text_style' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'nya_hide\',
\'path\'			=> FORUM_ROOT.\'extensions/nya_hide\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/nya_hide\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if (file_exists($ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'.php\'))
				require $ext_info[\'path\'].\'/lang/\'.$forum_user[\'language\'].\'.php\';
			else
				require $ext_info[\'path\'].\'/lang/English.php\';
			?>
				<div class="entry-content">
					<code>[hide]<?php echo $lang_hide[\'Hidden text\'] ?>[/hide]</code> <span><?php echo $lang_help[\'produces\'] ?></span>
					<div class="hidebox"><cite><?php echo $lang_hide[\'Hidden text\'] ?></cite><blockquote><p><i><?php echo $lang_hide[\'Hidden text\'] ?></i></blockquote></p></div>
					<code>[hide=1]<?php echo $lang_hide[\'Hidden text\'] ?>[/hide]</code> <span><?php echo $lang_help[\'produces\'] ?></span>
					<div class="hidebox"><cite><?php echo $lang_hide[\'Hidden text\'] ?>[1]</cite><blockquote><p><i><?php echo $lang_hide[\'Hidden text\'] ?></i></blockquote></p></div>
					<code>[hide=gr1]<?php echo $lang_hide[\'Hidden text\'] ?>[/hide]</code> <span><?php echo $lang_help[\'produces\'] ?></span>
					<div class="hidebox"><cite><?php echo $lang_hide[\'Hidden text group\'] ?>[1]</cite><blockquote><p><i><?php echo $lang_hide[\'Hidden text group\'] ?>1</i></p></blockquote></div>
				</div>
			<?

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'pun_bbcode_styles_loaded' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'nya_hide\',
\'path\'			=> FORUM_ROOT.\'extensions/nya_hide\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/nya_hide\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if ($forum_user[\'pun_bbcode_use_buttons\'] == \'1\') {

				if (!isset($hide_styles_loaded )) {
					$hide_styles_loaded = TRUE;

					if ($forum_user[\'style\'] != \'Oxygen\' && file_exists($ext_info[\'path\'].\'/css/\'.$forum_user[\'style\'].\'/hide.css\')) {
						$forum_loader->add_css($ext_info[\'url\'].\'/css/\'.$forum_user[\'style\'].\'/hide.css\', array(\'type\' => \'url\', \'media\' => \'screen\'));
					} else {
						$forum_loader->add_css($ext_info[\'url\'].\'/css/Oxygen/hide.css\', array(\'type\' => \'url\', \'media\' => \'screen\'));
					}
				}
			}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
  'hd_gen_elements' => 
  array (
    0 => '$GLOBALS[\'ext_info_stack\'][] = array(
\'id\'				=> \'logo\',
\'path\'			=> FORUM_ROOT.\'extensions/logo\',
\'url\'			=> $GLOBALS[\'base_url\'].\'/extensions/logo\',
\'dependencies\'	=> array (
)
);
$ext_info = $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];

if( $forum_config[\'o_logo_enable\'] == \'1\' && $forum_config[\'o_logo_align\'] == \'left\' )
				{
					$gen_elements[\'<!-- forum_title -->\'] = \'<table class="logo">\';
					$gen_elements[\'<!-- forum_title -->\'] .= \'<td class="logo" id="left" ><div  id="left" class="logo">\';
					$gen_elements[\'<!-- forum_title -->\'] .= ($forum_config[\'o_logo_link\'] != \'\') ? \'<a class="logo" href="\'.$forum_config[\'o_logo_link\'].\'" title="\'.$forum_config[\'o_logo_link_title\'].\'"></a></div></td>\' : \'</div></td>\';
					$gen_elements[\'<!-- forum_title -->\'] .= \'<td class="title" style="vertical-align:\'.$forum_config[\'o_logo_title_vertical\'].\'">\';
					$gen_elements[\'<!-- forum_title -->\'] .= ($forum_config[\'o_logo_hide_forum_title\'] != \'1\') ? \'<p id="brd-title" style="text-align:\'.$forum_config[\'o_logo_title_align\'].\'"><a href="\'.forum_link($forum_url[\'index\']).\'">\'.forum_htmlencode($forum_config[\'o_board_title\']).\'</a></p>\' : \'\';
					$gen_elements[\'<!-- forum_desc -->\'] = ($forum_config[\'o_board_desc\'] != \'\') ? \'<p id="brd-desc" style="text-align:\'.$forum_config[\'o_logo_title_align\'].\'">\'.forum_htmlencode($forum_config[\'o_board_desc\']).\'</p></td>\' : \'</td>\';
					$gen_elements[\'<!-- forum_desc -->\'] .= (isset($ad)) ? "<td><div style=\'float:right;background:#999\'>{$ad}</div></td></table>" : \'</table>\';
				}
			if( $forum_config[\'o_logo_enable\'] == \'1\' && $forum_config[\'o_logo_align\'] == \'right\' )
				{
					$gen_elements[\'<!-- forum_title -->\'] = (isset($ad)) ? "<table class=\'logo\'><td><div style=\'background:#999\'>{$ad}</div></td>" : \'<table class="logo">\';
					$gen_elements[\'<!-- forum_title -->\'] .= \'<td class="title" style="vertical-align:\'.$forum_config[\'o_logo_title_vertical\'].\'">\';
					$gen_elements[\'<!-- forum_title -->\'] .= ($forum_config[\'o_logo_hide_forum_title\'] != \'1\') ? \'<p id="brd-title" style="text-align:\'.$forum_config[\'o_logo_title_align\'].\'"><a href="\'.forum_link($forum_url[\'index\']).\'">\'.forum_htmlencode($forum_config[\'o_board_title\']).\'</a></p>\' : \'\';
					$gen_elements[\'<!-- forum_desc -->\'] = ($forum_config[\'o_board_desc\'] != \'\') ? \'<p id="brd-desc" style="text-align:\'.$forum_config[\'o_logo_title_align\'].\'">\'.forum_htmlencode($forum_config[\'o_board_desc\']).\'</p></td>\' : \'</td>\';
					$gen_elements[\'<!-- forum_desc -->\'] .= \'<td class="logo" id="right"><div id="right" class="logo">\';
					$gen_elements[\'<!-- forum_desc -->\'] .= ($forum_config[\'o_logo_link\'] != \'\') ? \'<a class="logo" href="\'.$forum_config[\'o_logo_link\'].\'" title="\'.$forum_config[\'o_logo_link_title\'].\'"></a></div></td></table>\' : \'</div></td></table>\';
					
				}

array_pop($GLOBALS[\'ext_info_stack\']);
$ext_info = empty($GLOBALS[\'ext_info_stack\']) ? array() : $GLOBALS[\'ext_info_stack\'][count($GLOBALS[\'ext_info_stack\']) - 1];
',
  ),
);

?>