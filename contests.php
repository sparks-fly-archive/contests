<?php

define("IN_MYBB", 1);
define('THIS_SCRIPT', 'contests.php');

require_once "./global.php";
$uid = $mybb->user['uid'];

// Header-Navigation
add_breadcrumb("Contests", "contests.php");
switch($mybb->input['action'])
{
	case "options":
		add_breadcrumb("Einstellungen hinzufügen");
	break;
	case "add_contest":
		add_breadcrumb("Contest hinzufügen");
    break;
	case "drafts":
		add_breadcrumb("Entwürfe ansehen");
	break;
	case "view":
		add_breadcrumb("Contest ansehen");
    break;
	case "browse":
		add_breadcrumb("Contests durchsuchen");
    break;
	case "pinned":
		add_breadcrumb("Gemerkte Contests");
    break;
	case "participate":
		add_breadcrumb("An Contest teilnehmen");
	break;
}

// User-Optionen
$sql = "SELECT * FROM mybb_contests_user_options WHERE uid = '$uid'";
$query = $db->query($sql);
$options = $db->fetch_array($query);

// Seiten-Navigation
if($mybb->usergroup['cancp'] == "1") {
    eval("\$contests_nav_team = \"".$templates->get("contests_nav_team")."\";");
} else { $contests_nav_team = ""; }
eval("\$contests_nav = \"".$templates->get("contests_nav")."\";");

// Contest-Hauptseite
if(!$mybb->input['action']) {

  eval("\$page = \"".$templates->get("contests")."\";");
  output_page($page);

}

elseif($mybb->input['action'] == "options") {

    $category_bit = "";
    $categories = array("graphics" => "Grafik", "coding" => "Coding", "writing" => "Writing");
    foreach($categories as $key => $value) {
        $sql = "SELECT uoid FROM mybb_contests_user_options WHERE uid = '$uid' AND categories LIKE '%$key%'";
        $uoid = $db->fetch_field($db->query($sql), "uoid");
        $checked = "";
        if($uoid) {
            $checked = "checked";
        }
        $category_bit .= "<input type=\"checkbox\" name=\"category[]\" value=\"{$key}\" {$checked}> {$value} ";
    }    

    eval("\$page = \"".$templates->get("contests_user_options")."\";");
    output_page($page);
}

elseif($mybb->input['action'] == "do_options") {
    $tags = $mybb->get_input('tags');
    $categories = $mybb->input['category'];
    $cats = implode(", ", $categories);
    $newest = $mybb->get_input('newest');
    $insert_array = array(
        "uid" => (int)$mybb->user['uid'],
        "tags" => $db->escape_string($tags),
        "categories" => $cats,
        "newest" => $newest
    );
    $db->delete_query("contests_user_options", "uid = '$uid'");
    $db->insert_query("contests_user_options", $insert_array);
    redirect("contests.php?action=options");
}

elseif($mybb->input['action'] == "add_contest") {
    if($mybb->usergroup['cancp'] != "1") { error_no_permission(); }
    $cid = (int)$mybb->input['cid'];
    $sql = "SELECT * FROM mybb_contests WHERE cid = '$cid'";
    $query = $db->query($sql);
    $contest = $db->fetch_array($query);

    $categories = array("graphics" => "Grafik", "coding" => "Coding", "writing" => "Writing");
    foreach($categories as $key => $value) {
        $checked_cat = "";
        if($contest['category'] == $key) {
            $checked_cat = "selected";
        }
        $category_bit .= "<option value=\"{$key}\" {$checked_cat}>{$value}</option>";
    }

    // Dropdown für Datum
    $contest['day'] = date("d", $contest['endtime']);
    for($i=1 ; $i <=31; $i++) {
        $checked_day = "";
        if($contest['day'] == $i) {
            $checked_day = "selected";
        }
        $day_bit .= "<option value=\"{$i}\" {$checked_day}>{$i}</option>";
    }  

    $months = array("January" => "Januar", "February" => "Februar", "March" => "März", "April" => "April", "May" => "Mai", "June" => "Juni", "July" => "Juli", "August" => "August", "September" => "September", "October" => "Oktober", "November" => "November", "December" => "Dezember");
    foreach($months as $key => $value) {
        $checked_month = "";
        $contest['month'] = date("F", $contest['endtime']);
        if($contest['month'] == $key) {
            $checked_month = "selected";
        }
        $month_bit .= "<option value=\"{$key}\" {$checked_month}>{$value}</option>";
    }

    $timestamp = TIME_NOW;
    $year = date("Y", $timestamp);
    $next_year = $year++;
    for($i=2018; $i <=2019; $i++) {
        $checked_year = "";
        $contest['year'] = date("Y", $contest['endtime']);
        if($contest['year'] == $i) {
            $checked_year = "selected";
        }
        $year_bit .= "<option value=\"{$i}\" {$checked_year}>{$i}</option>";
    }

    eval("\$page = \"".$templates->get("contests_team_add")."\";");
    output_page($page);    
}

elseif($mybb->input['action'] == "drafts") {
    $draft_bit = "";

    // Multipage
    $query = $db->simple_select("contests", "COUNT(*) AS numcontests", "visibility = '0'");
    $contestcount = $db->fetch_field($query, "numcontests");
    $perpage = 10;
    $page = intval($mybb->input['page']);
    if($page) {
        $start = ($page-1) *$perpage;
    }
    else {
        $start = 0;
        $page = 1;
    }
    $end = $start + $perpage;
    $lower = $start+1;
    $upper = $end;
    if($upper > $contestcount) {
        $upper = $contestcount;
    }

    $multipage = multipage($contestcount, $perpage, $page, $_SERVER['PHP_SELF']."?action=drafts");
    $sql = "SELECT * FROM mybb_contests WHERE visibility = '0' ORDER BY category ASC LIMIT $start, $perpage";
    $query = $db->query($sql);
    while($draft = $db->fetch_array($query)) {
        $savedate = date("d.m.Y", $draft['starttime']);
        eval("\$draft_bit .= \"".$templates->get("contests_team_drafts_bit")."\";");
    }

    eval("\$page = \"".$templates->get("contests_team_drafts")."\";");
    output_page($page);      
}

elseif($mybb->input['action'] == "do_add_contest") {

    $category = $mybb->get_input('section'); 
    $type = $mybb->get_input('type');
    $title = $mybb->get_input('title');
    $description = $mybb->get_input('description');
    $tags = $mybb->get_input('tags');
	// Ende
	$end_day = (int)$mybb->get_input('end_day');
	$end_month = $db->escape_string($mybb->get_input('end_month'));
	$end_year = (int)$mybb->get_input('end_year');
    $end = strtotime("$end_day $end_month $end_year");
    if(!$mybb->get_input('savedraft')) {
        $visibility = 1;
         // Error Handling
        if(empty($category)) { 
            $errormessages = "Du musst eine <strong>Kategorie</strong> auswählen!<br />";
        } 
        if(empty($type)) { $errormessages .= "Du musst einen <strong>Art des Contests</strong> angeben!<br />"; }
        if(empty($title)) { $errormessages .= "Du musst einen <strong>Contestnamen</strong> angeben! <br />"; }
        if(empty($description)) { $errormessages .= "Du musst einen <strong>Aufgabentext</strong> angeben! <br />"; }
        if(empty($tags)) { $errormessages .= "Du musst den Contest mit <strong>Tags</strong> versehen! <br />"; }
        if($end < TIME_NOW) { $errormessages .= "Die <strong>Deadline</strong> muss nach dem heutigen Datum liegen!<br />"; }
        if($errormessages) {
            error($errormessages."<strong>Nutze den Zurück-Button deines Browsers</strong>, um zur Contest-Erstellung zurückzukehren.");
            return false;
        }
    } else { $visibility = 0; }


    if($mybb->get_input('cid')) {
        $cid = $mybb->get_input('cid');
        $db->delete_query("contests", "cid = '$cid'");
    }
    
	$insert_array = array(
        "cid" => $cid,
        "uid" => (int)$mybb->user['uid'],
        "category" => $db->escape_string($category),
		"type" => $db->escape_string($type),
		"name" => $db->escape_string($title),
		"description" => $db->escape_string($description),
		"tags" => $db->escape_string($tags),
		"starttime" => TIME_NOW,
        "endtime" => (int)$end,
        "visibility" => (int)$visibility
    );
    $db->insert_query("contests", $insert_array);
    
    // Verschicke einen Alert an User mit entsprechendem Tag
    if(!$mybb->get_input('savedraft')) {
        $sql = "SELECT cid FROM mybb_contests ORDER BY cid DESC LIMIT 1";
        $cid = $db->fetch_field($db->query($sql), "cid");
        $taglist = explode(", ", $tags);
        foreach($taglist as $tag) {
            $sql = "SELECT uid FROM mybb_contests_user_options WHERE tags LIKE '%$tag%'";
            $query = $db->query($sql);
            while($uids = $db->fetch_array($query)) {
                // alert
                $alertType = MybbStuff_MyAlerts_AlertTypeManager::getInstance()->getByCode('tags');
                if ($alertType != NULL && $alertType->getEnabled()) {
                    $alert = new MybbStuff_MyAlerts_Entity_Alert((int)$uids['uid'], $alertType, (int)$cid);
                    $alert->setExtraDetails([
                        'tags' => $tags
                    ]); 
                    MybbStuff_MyAlerts_AlertManager::getInstance()->addAlert($alert);
                } 
            }
        }
    }

    redirect("contests.php?action=add_contest");
    
}

elseif($mybb->input['action'] == "view") {
    require_once MYBB_ROOT."inc/class_parser.php";
    $parser = new postParser;
    $timestamp = TIME_NOW;
    // Contest-Informationen
    $cid = (int)$mybb->get_input(cid);
    $sql = "SELECT * FROM mybb_contests WHERE cid = '$cid'";
    $query = $db->query($sql);
    $contest = $db->fetch_array($query);
    $author = get_user($contest['uid']);
    $author['avatarlink'] = "<a href=\"member.php?action=profile&uid={$author['uid']}\" target=\"_blank\"><img src=\"{$author['avatar']}\" width=\"100px\"/></a>";
    $contest['deadline'] = date("d.m.Y", $contest['endtime']);

    $options = array(
		"allow_html" => 1,
		"allow_mycode" => 1,
		"allow_smilies" => 1,
		"allow_imgcode" => 1,
		"filter_badwords" => 0,
		"nl2br" => 1,
		"allow_videocode" => 1,
	);
	
    $contest['description'] = $parser->parse_message($contest['description'], $options);
    
    if($mybb->usergroup['cancp'] == "1") {
        eval("\$team_options = \"".$templates->get("contests_team_contest_options")."\";");
    }

    $uid = $mybb->user['uid'];
    $sql = "SELECT upid FROM mybb_contests_user_pinned WHERE cid = '{$cid}' AND uid = '{$uid}'";
    $upid = $db->fetch_field($db->query($sql), "upid");
    if($upid) {
        eval("\$contest_pin = \"".$templates->get("contests_view_contest_unpin")."\";");
    } else { eval("\$contest_pin = \"".$templates->get("contests_view_contest_pin")."\";"); }

    if($contest['endtime'] > $timestamp && $uid) {
        eval("\$participate = \"".$templates->get("contests_view_contest_participate")."\";");
    }

    eval("\$page = \"".$templates->get("contests_view_contest")."\";");
    output_page($page);   
}

elseif($mybb->input['action'] == "browse") {
    require_once MYBB_ROOT."inc/class_parser.php";
    $parser = new postParser;
    // Filter vorbereiten
    $category = $mybb->get_input('category');
    $type = $mybb->get_input('type');
    $tag = $mybb->get_input('tag');
    if(empty($type)) {
        $type = "%";
    } if(empty($category)) { $category = "%"; }
    if(empty($tag)) { $tag = "%"; }
    $timestamp = TIME_NOW;

    // Multipage
    $query = $db->simple_select("contests", "COUNT(*) AS numcontests", "category LIKE '%$category%' AND type LIKE '%$type%' AND tags LIKE '%$tag%' AND endtime > '$timestamp'");
    $contestcount = $db->fetch_field($query, "numcontests");
    $perpage = 5;
    $page = intval($mybb->input['page']);
    if($page) {
        $start = ($page-1) *$perpage;
    }
    else {
        $start = 0;
        $page = 1;
    }
    $end = $start + $perpage;
    $lower = $start+1;
    $upper = $end;
    if($upper > $contestcount) {
        $upper = $contestcount;
    }

    $multipage = multipage($contestcount, $perpage, $page, $_SERVER['PHP_SELF']."?action=browse&category={$category}&type={$type}&tag={$tag}");

    $sql = "SELECT * FROM mybb_contests WHERE category LIKE '%$category%' AND type LIKE '%$type%' AND tags LIKE '%$tag%' AND endtime > '$timestamp' ORDER BY endtime ASC LIMIT $start, $perpage";
    $query = $db->query($sql);
    while($contest = $db->fetch_array($query)) {
        $options = array(
            "allow_html" => 1,
            "allow_mycode" => 1,
            "allow_smilies" => 0,
            "allow_imgcode" => 0,
            "filter_badwords" => 0,
            "nl2br" => 0,
            "allow_videocode" => 0,
        );       
        $contest['description'] = $parser->parse_message($contest['description'], $options);
        $contest['deadline'] = date("d.m.Y", $contest['endtime']);
        $end_day = date("d", $contest['endtime']);
        $end_month = date("F", $contest['endtime']);
        if($mybb->usergroup['cancp'] == "1") {
            eval("\$team_options = \"".$templates->get("contests_team_contest_options")."\";");
        }
    
        $uid = $mybb->user['uid'];
        $sql = "SELECT upid FROM mybb_contests_user_pinned WHERE cid = '$contest[cid]' AND uid = '{$uid}'";
        $upid = $db->fetch_field($db->query($sql), "upid");
        if($upid) {
            eval("\$contest_pin = \"".$templates->get("contests_view_contest_unpin")."\";");
        } else { eval("\$contest_pin = \"".$templates->get("contests_view_contest_pin")."\";"); }
        eval("\$contest_bit .= \"".$templates->get("contests_view_contests_bit")."\";");
    }

    $sql = "SELECT DISTINCT type FROM mybb_contests WHERE endtime > '$timestamp' AND category LIKE '%$category%' ORDER BY type ASC";
    $query = $db->query($sql);
    while($types = $db->fetch_array($query)) {
        $types_checked = "";
        if($type == $types['type']) {
            $types_checked = "selected";
        }
        $types_bit .= "<option value=\"{$types['type']}\" {$types_checked}>{$types['type']}</option>";
    }

    $query = $db->query("SELECT tags FROM mybb_contests
    WHERE tags != ''
    AND category LIKE '%$category%'");

    while($tag_query = $db->fetch_array($query)) {
            $tag_array .= $tag_query['tags'].", ";
    }

    $tags = explode(", ", $tag_array);
    sort($tags);
    $tags = array_unique(array_map("StrToLower", $tags));
    $tags = array_map("ucwords", $tags);
    foreach($tags as $tag_contest) {
        $tag_checked = "";
        if(!empty($tag_contest)) {
            if($tag == $tag_contest) {
                $tag_checked = "selected";
            }
        $tag_bit .= "<option value=\"$tag_contest\" {$tag_checked}>$tag_contest</option>";
        }
    }

    $categories = array("graphics" => "Grafik", "coding" => "Coding", "writing" => "Writing");
    foreach($categories as $key => $value) {
        $checked_cat = "";
        if($category == $key) {
            $checked_cat = "selected";
        }
        $category_bit .= "<option value=\"{$key}\" {$checked_cat}>{$value}</option>";
    }
    
    eval("\$page = \"".$templates->get("contests_view_contests")."\";");
    output_page($page);  
}

elseif($mybb->input['action'] == "pin") {
    $cid = $mybb->get_input('cid');

    $insert_array = array(
        "uid" => $mybb->user['uid'],
        "cid" => (int)$cid
    );

    $author = $db->fetch_field($db->query("SELECT uid FROM mybb_contests WHERE cid = '{$cid}'"), "uid");
    $name = $db->fetch_field($db->query("SELECT name FROM mybb_contests WHERE cid = '{$cid}'"), "name");

    // alert
    $alertType = MybbStuff_MyAlerts_AlertTypeManager::getInstance()->getByCode('pinned');
    if ($alertType != NULL && $alertType->getEnabled()) {
        $alert = new MybbStuff_MyAlerts_Entity_Alert((int)$author, $alertType, (int)$cid);
        $alert->setExtraDetails([
            'name' => $name
        ]); 
        MybbStuff_MyAlerts_AlertManager::getInstance()->addAlert($alert);
    } 

    $db->insert_query("contests_user_pinned", $insert_array);
    redirect("contests.php?action=view&cid={$cid}");
}

elseif($mybb->input['action'] == "unpin") {
    $cid = $mybb->get_input('cid');
    $uid = $mybb->user['uid'];
    $sql = "SELECT uid FROM mybb_contests_user_pinned WHERE cid = '{$cid}' AND uid = '{$userid}'";
    $userid = $db->fetch_field($db->query($sql), "uid");
    if($uid == $mybb->user['uid']) {
        $db->delete_query("contests_user_pinned", "cid = '{$cid}' AND uid = '{$uid}'");
    }
    redirect("contests.php?action=view&cid={$cid}");
}

#TODO: Gepinnte Contests werden bei Erstellung der Umfrage gelöscht!
elseif($mybb->input['action'] == "pinned") {
    // Multipage
    $uid = $mybb->user['uid'];
    $query = $db->simple_select("contests_user_pinned", "COUNT(*) AS numcontests", "uid = '$uid'");
    $contestcount = $db->fetch_field($query, "numcontests");
    $perpage = 10;
    $page = intval($mybb->input['page']);
    if($page) {
        $start = ($page-1)*$perpage;
    }
    else {
        $start = 0;
        $page = 1;
    }
    $end = $start + $perpage;
    $lower = $start+1;
    $upper = $end;
    if($upper > $contestcount) {
        $upper = $contestcount;
    }
    $multipage = multipage($contestcount, $perpage, $page, $_SERVER['PHP_SELF']."?action=pinned");
    $timestamp = TIME_NOW;
    $sql = "SELECT * FROM mybb_contests_user_pinned INNER JOIN mybb_contests ON mybb_contests.cid = mybb_contests_user_pinned.cid WHERE mybb_contests_user_pinned.uid = '{$uid}' AND endtime > '$timestamp'";
    $query = $db->query($sql);
    $contest_bit = "";
    while($contest = $db->fetch_array($query)) {
        $contest['deadline'] = date("d.m.Y", $contest['endtime']);
        $end_day = date("d", $contest['endtime']);
        $end_month = date("F", $contest['endtime']);
        if($mybb->usergroup['cancp'] == "1") {
            eval("\$team_options = \"".$templates->get("contests_team_contest_options")."\";");
        }
    
        $sql = "SELECT upid FROM mybb_contests_user_pinned WHERE cid = '$contest[cid]' AND uid = '{$uid}'";
        $upid = $db->fetch_field($db->query($sql), "upid");
        if($upid) {
            eval("\$contest_pin = \"".$templates->get("contests_view_contest_unpin")."\";");
        } else { eval("\$contest_pin = \"".$templates->get("contests_view_contest_pin")."\";"); }
        eval("\$contest_bit .= \"".$templates->get("contests_view_contests_bit")."\";");        
    }
    eval("\$page = \"".$templates->get("contests_view_pinned")."\";");
    output_page($page);     
}