<?php

// Disallow direct access to this file for security reasons
if(!defined("IN_MYBB")) {
    die("Direct initialization of this file is not allowed.");
}

# $plugins->add_hook("global_intermediate", "contests_global");

function contests_info(){
    return array(
        "name"			=> "Contest-System",
        "description"	=> "Erweitert das Forum um ein Contest-System.",
        "website"		=> "http://github.com/user/its-sparks-fly",
        "author"		=> "sparks fly",
        "authorsite"	=> "http://github.com/user/its-sparks-fly",
        "version"		=> "1.0",
        "compatibility" => "*"
    );
}

function contests_install() {
    global $mybb, $db;

    if(!$db->table_exists("contests")) {
        $db->query("CREATE TABLE `mybb_contests` (
            `cid` int(11) NOT NULL AUTO_INCREMENT,
            `uid` int(11) NOT NULL,
            `category` text NOT NULL,
            `name` text NOT NULL,
            `type` text NOT NULL,
            `description` text NOT NULL,
            `tags` text NOT NULL,
            `starttime` text NOT NULL,
            `endtime` text NOT NULL,
            PRIMARY KEY (`cid`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
    }

    #TODO: Tabelle für User-Einstellungen 
    #TODO: Tabelle für Contest-Beiträge
    #TODO: Tabelle für Contest-Umfragen
    #TODO: Tabelle für Contest-Votes

}

function contests_is_installed() {
    global $db;

    if($db->table_exists("contests")) {
        return true;
    }
    return false;
}

function contests_uninstall() {
    global $db;  

    if($db->table_exists("contests")) {
        $db->query("DROP TABLE `mybb_events`");
    }
}

function contests_activate() {
    global $mybb, $db;

}

function contests_deactivate() {
    global $mybb, $db;

}
