<?php

if (!defined('FORUM')) exit;
define('FORUM_QJ_LOADED', 1);
$forum_id = isset($forum_id) ? $forum_id : 0;

?><form id="qjump" method="get" accept-charset="utf-8" action="http://nco5ranerted3nkt.onion/forum/viewforum.php">
	<div class="frm-fld frm-select">
		<label for="qjump-select"><span><?php echo $lang_common['Jump to'] ?></span></label><br />
		<span class="frm-input"><select id="qjump-select" name="id">
			<optgroup label="ToRepublika">
				<option value="2"<?php echo ($forum_id == 2) ? ' selected="selected"' : '' ?>>O ToRepublice</option>
				<option value="5"<?php echo ($forum_id == 5) ? ' selected="selected"' : '' ?>>HydePark</option>
			</optgroup>
			<optgroup label="Wiadomości">
				<option value="3"<?php echo ($forum_id == 3) ? ' selected="selected"' : '' ?>>Napisali o nas</option>
				<option value="10"<?php echo ($forum_id == 10) ? ' selected="selected"' : '' ?>>Warto zobaczyć</option>
			</optgroup>
			<optgroup label="Anonimowość i Bezpieczeństwo">
				<option value="11"<?php echo ($forum_id == 11) ? ' selected="selected"' : '' ?>>Anonimowość w internecie</option>
				<option value="12"<?php echo ($forum_id == 12) ? ' selected="selected"' : '' ?>>Anonimowość fizyczna</option>
				<option value="31"<?php echo ($forum_id == 31) ? ' selected="selected"' : '' ?>>Bezpieczeństwo</option>
			</optgroup>
			<optgroup label="Hacking, Cracking, Botnets">
				<option value="37"<?php echo ($forum_id == 37) ? ' selected="selected"' : '' ?>>Cracking</option>
				<option value="15"<?php echo ($forum_id == 15) ? ' selected="selected"' : '' ?>>Hacking</option>
				<option value="17"<?php echo ($forum_id == 17) ? ' selected="selected"' : '' ?>>Socjotechnika</option>
				<option value="36"<?php echo ($forum_id == 36) ? ' selected="selected"' : '' ?>>Botnets</option>
				<option value="19"<?php echo ($forum_id == 19) ? ' selected="selected"' : '' ?>>Bazy danych</option>
				<option value="20"<?php echo ($forum_id == 20) ? ' selected="selected"' : '' ?>>Dokumenty i dane</option>
			</optgroup>
			<optgroup label="Finanse">
				<option value="28"<?php echo ($forum_id == 28) ? ' selected="selected"' : '' ?>>Finanse</option>
				<option value="34"<?php echo ($forum_id == 34) ? ' selected="selected"' : '' ?>>Virtual Carding</option>
				<option value="16"<?php echo ($forum_id == 16) ? ' selected="selected"' : '' ?>>Physical Carding</option>
				<option value="29"<?php echo ($forum_id == 29) ? ' selected="selected"' : '' ?>>Allegro</option>
				<option value="35"<?php echo ($forum_id == 35) ? ' selected="selected"' : '' ?>>Oszustwa</option>
			</optgroup>
			<optgroup label="Tematyczne">
				<option value="44"<?php echo ($forum_id == 44) ? ' selected="selected"' : '' ?>>Informatyka</option>
				<option value="30"<?php echo ($forum_id == 30) ? ' selected="selected"' : '' ?>>Telekomunikacja</option>
				<option value="27"<?php echo ($forum_id == 27) ? ' selected="selected"' : '' ?>>Broń i taktyka</option>
				<option value="23"<?php echo ($forum_id == 23) ? ' selected="selected"' : '' ?>>Chemia</option>
				<option value="39"<?php echo ($forum_id == 39) ? ' selected="selected"' : '' ?>>Kradzieże i włamania</option>
				<option value="42"<?php echo ($forum_id == 42) ? ' selected="selected"' : '' ?>>Przekręty małe i duże</option>
				<option value="40"<?php echo ($forum_id == 40) ? ' selected="selected"' : '' ?>>Motoryzacja i transport</option>
				<option value="41"<?php echo ($forum_id == 41) ? ' selected="selected"' : '' ?>>Prawo i porachunki</option>
			</optgroup>
			<optgroup label="Handel i społeczność">
				<option value="7"<?php echo ($forum_id == 7) ? ' selected="selected"' : '' ?>>Kupię</option>
				<option value="6"<?php echo ($forum_id == 6) ? ' selected="selected"' : '' ?>>Sprzedam i czasem oszukam</option>
				<option value="9"<?php echo ($forum_id == 9) ? ' selected="selected"' : '' ?>>Współpraca</option>
				<option value="43"<?php echo ($forum_id == 43) ? ' selected="selected"' : '' ?>>Reputacja i spory</option>
				<option value="47"<?php echo ($forum_id == 47) ? ' selected="selected"' : '' ?>>Tutoriale, artykuły i materiały od nowych forumowiczów</option>
			</optgroup>
			<optgroup label="Profile">
				<option value="32"<?php echo ($forum_id == 32) ? ' selected="selected"' : '' ?>>Profile &gt;&gt;&gt;</option>
				<option value="33"<?php echo ($forum_id == 33) ? ' selected="selected"' : '' ?>>E-szantaż i nie tylko.</option>
			</optgroup>
			<optgroup label="Pozostałe">
				<option value="49"<?php echo ($forum_id == 49) ? ' selected="selected"' : '' ?>>Z kamerą wsród niezarejestrowanych</option>
				<option value="59"<?php echo ($forum_id == 59) ? ' selected="selected"' : '' ?>>English subforum</option>
				<option value="45"<?php echo ($forum_id == 45) ? ' selected="selected"' : '' ?>>Kosz, jak to kosz.</option>
			</optgroup>
			<optgroup label="Market">
				<option value="50"<?php echo ($forum_id == 50) ? ' selected="selected"' : '' ?>>Dane i informacje</option>
				<option value="51"<?php echo ($forum_id == 51) ? ' selected="selected"' : '' ?>>Bankowość</option>
				<option value="52"<?php echo ($forum_id == 52) ? ' selected="selected"' : '' ?>>Elektronika</option>
				<option value="53"<?php echo ($forum_id == 53) ? ' selected="selected"' : '' ?>>Narkotyki</option>
				<option value="54"<?php echo ($forum_id == 54) ? ' selected="selected"' : '' ?>>Broń</option>
				<option value="55"<?php echo ($forum_id == 55) ? ' selected="selected"' : '' ?>>Edukacja</option>
				<option value="56"<?php echo ($forum_id == 56) ? ' selected="selected"' : '' ?>>Chemia</option>
				<option value="57"<?php echo ($forum_id == 57) ? ' selected="selected"' : '' ?>>Usługi</option>
				<option value="58"<?php echo ($forum_id == 58) ? ' selected="selected"' : '' ?>>Inne</option>
			</optgroup>
		</select>
		<input type="submit" id="qjump-submit" value="<?php echo $lang_common['Go'] ?>" /></span>
	</div>
</form>
<?php

$forum_javascript_quickjump_code = <<<EOL
(function () {
	var forum_quickjump_url = "http://nco5ranerted3nkt.onion/forum/viewforum.php?id=$1";
	var sef_friendly_url_array = new Array(45);
	sef_friendly_url_array[2] = "o-torepublice";
	sef_friendly_url_array[5] = "hydepark";
	sef_friendly_url_array[3] = "napisali-o-nas";
	sef_friendly_url_array[10] = "warto-zobaczyc";
	sef_friendly_url_array[11] = "anonimowosc-w-internecie";
	sef_friendly_url_array[12] = "anonimowosc-fizyczna";
	sef_friendly_url_array[31] = "bezpieczenstwo";
	sef_friendly_url_array[37] = "cracking";
	sef_friendly_url_array[15] = "hacking";
	sef_friendly_url_array[17] = "socjotechnika";
	sef_friendly_url_array[36] = "botnets";
	sef_friendly_url_array[19] = "bazy-danych";
	sef_friendly_url_array[20] = "dokumenty-i-dane";
	sef_friendly_url_array[28] = "finanse";
	sef_friendly_url_array[34] = "virtual-carding";
	sef_friendly_url_array[16] = "physical-carding";
	sef_friendly_url_array[29] = "allegro";
	sef_friendly_url_array[35] = "oszustwa";
	sef_friendly_url_array[44] = "informatyka";
	sef_friendly_url_array[30] = "telekomunikacja";
	sef_friendly_url_array[27] = "bron-i-taktyka";
	sef_friendly_url_array[23] = "chemia";
	sef_friendly_url_array[39] = "kradzieze-i-wlamania";
	sef_friendly_url_array[42] = "przekrety-male-i-duze";
	sef_friendly_url_array[40] = "motoryzacja-i-transport";
	sef_friendly_url_array[41] = "prawo-i-porachunki";
	sef_friendly_url_array[7] = "kupie";
	sef_friendly_url_array[6] = "sprzedam-i-czasem-oszukam";
	sef_friendly_url_array[9] = "wspolpraca";
	sef_friendly_url_array[43] = "reputacja-i-spory";
	sef_friendly_url_array[47] = "tutoriale-artykuly-i-materialy-od-nowych-forumowiczow";
	sef_friendly_url_array[32] = "profile";
	sef_friendly_url_array[33] = "eszantaz-i-nie-tylko";
	sef_friendly_url_array[49] = "z-kamera-wsrod-niezarejestrowanych";
	sef_friendly_url_array[59] = "english-subforum";
	sef_friendly_url_array[45] = "kosz-jak-to-kosz";
	sef_friendly_url_array[50] = "dane-i-informacje";
	sef_friendly_url_array[51] = "bankowosc";
	sef_friendly_url_array[52] = "elektronika";
	sef_friendly_url_array[53] = "narkotyki";
	sef_friendly_url_array[54] = "bron";
	sef_friendly_url_array[55] = "edukacja";
	sef_friendly_url_array[56] = "chemia";
	sef_friendly_url_array[57] = "uslugi";
	sef_friendly_url_array[58] = "inne";

	PUNBB.common.addDOMReadyEvent(function () { PUNBB.common.attachQuickjumpRedirect(forum_quickjump_url, sef_friendly_url_array); });
}());
EOL;

$forum_loader->add_js($forum_javascript_quickjump_code, array('type' => 'inline', 'weight' => 60, 'group' => FORUM_JS_GROUP_SYSTEM));
?>
