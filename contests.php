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

    eval("\$page = \"".$templates->get("contests_user_options")."\";");
    output_page($page);
}

elseif($mybb->input['action'] == "do_options") {
    $tags = $mybb->get_input('tags');
    $insert_array = array(
        "uid" => (int)$mybb->user['uid'],
        "tags" => $db->escape_string($tags)
    );
    $db->delete_query("contests_user_options", "uid = '$uid'");
    $db->insert_query("contests_user_options", $insert_array);
    redirect("contests.php?action=options");
}

elseif($mybb->input['action'] == "add_contest") {
    if($mybb->usergroup['cancp'] != "1") { error_no_permission(); }

    // Dropdown für Datum
    for($i=1 ; $i <=31; $i++) {
        $day_bit .= "<option value=\"{$i}\">{$i}</option>";
    }  

    $timestamp = TIME_NOW;
    $year = date("Y", $timestamp);
    $next_year = $year++;
    for($i=2018; $i <=2019; $i++) {
        $year_bit .= "<option value=\"{$i}\">{$i}</option>";
    }

    eval("\$page = \"".$templates->get("contests_team_add")."\";");
    output_page($page);    
}

elseif($mybb->input['action'] == "do_add_contest") {
    $category = $mybb->get_input('section'); 
    $type = $mybb->get_input('type');
    $title = $mybb->get_input('title');
    $description = $mybb->get_input('description');
    $tags = $mybb->get_input('tags');
    if(!$mybb->get_input('savedraft')) {
        $visibility = 1;
    } else { $visibility = 0; }
    
	// Ende
	$end_day = (int)$mybb->get_input('end_day');
	$end_month = $db->escape_string($mybb->get_input('end_month'));
	$end_year = (int)$mybb->get_input('end_year');
    $end = strtotime("$end_day $end_month $end_year");
    
	$insert_array = array(
        "uid" => (int)$mybb->user['uid'],
        "category" => $db->escape_string($category),
		"type" => $db->escape_string($type),
		"name" => $db->escape_string($title),
		"description" => $db->escape_string($description),
		"tags" => $db->escape_string($mybb->get_input('tags')),
		"starttime" => TIME_NOW,
        "endtime" => (int)$end,
        "visibility" => (int)$visibility
    );

    $sql = "SELECT cid FROM mybb_contests LIMIT 1 ORDER BY cid DESC";
    $cid = $db->fetch_field($db->query($sql), "cid");
    $cid = $cid + 1;
    
    // Verschicke einen Alert an User mit entsprechendem Tag
    if(!$mybb->get_input('savedraft')) {
        $taglist = explode(", ", $tags);
        foreach($taglist as $tag) {
            $tag = $db->escape_string($tag);
            $sql = "SELECT uid FROM mybb_contests_user_options WHERE tags LIKE '%$tag%'";
            $query = $db->query($sql);
            while($uids = $db->fetch_array($query)) {
                // alert
                $alertType = MybbStuff_MyAlerts_AlertTypeManager::getInstance()->getByCode('tags');
                if ($alertType != NULL && $alertType->getEnabled()) {
                    $alert = new MybbStuff_MyAlerts_Entity_Alert((int)$uids['uid'], $alertType, (int)$cid);
                    $alert->setExtraDetails([
                        'tags' => $tag
                    ]); 
                    MybbStuff_MyAlerts_AlertManager::getInstance()->addAlert($alert);
                } 
            }
        }
    }

	$db->insert_query("contests", $insert_array);
    redirect("contests.php?action=add_contest");
    
}