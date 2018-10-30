<?php

// Disallow direct access to this file for security reasons
if(!defined("IN_MYBB")) {
    die("Direct initialization of this file is not allowed.");
}

$plugins->add_hook("global_intermediate", "contests_global");
if(class_exists('MybbStuff_MyAlerts_AlertTypeManager')) {
	$plugins->add_hook("global_start", "contests_alerts");
}

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
    require_once MYBB_ROOT."/inc/plugins/sparks-fly/contests/templates.php";

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
            `visibility` tinyint,
            PRIMARY KEY (`cid`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
    }

    if(!$db->table_exists("contests_user_options")) {
        $db->query("CREATE TABLE `mybb_contests_user_options` ( 
            `uoid` int(11) NOT NULL AUTO_INCREMENT,
            `uid` int(11) NOT NULL,
            `tags` text NOT NULL,
            `categories` text NOT NULL,
            `newest` tinyint(1) NOT NULL,
            PRIMARY KEY (`uoid`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
    }

    if(!$db->table_exists("contests_user_pinned")) {
        $db->query("CREATE TABLE `mybb_contests_user_pinned` ( 
            `upid` int(11) NOT NULL AUTO_INCREMENT,
            `uid` int(11) NOT NULL,
            `cid` int(11) NOT NULL,
            PRIMARY KEY (`upid`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
    }

    contests_templates_install();

	// myalerts integration
	if (class_exists('MybbStuff_MyAlerts_AlertTypeManager')) {
    	$alertTypeManager = MybbStuff_MyAlerts_AlertTypeManager::getInstance();

    	if (!$alertTypeManager) {
    	    $alertTypeManager = MybbStuff_MyAlerts_AlertTypeManager::createInstance($db, $cache);
    	}

   	 	$alertType = new MybbStuff_MyAlerts_Entity_AlertType();
   		$alertType->setCode('tags');
   		$alertType->setEnabled(true);
   		$alertType->setCanBeUserDisabled(true);

        $alertTypeManager->add($alertType);
            
        $alertType = new MybbStuff_MyAlerts_Entity_AlertType();
   		$alertType->setCode('pinned');
   		$alertType->setEnabled(true);
   		$alertType->setCanBeUserDisabled(true);

   		$alertTypeManager->add($alertType);
    }

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
    require_once MYBB_ROOT."/inc/plugins/sparks-fly/contests/templates.php";  

    if($db->table_exists("contests")) {
        $db->query("DROP TABLE `mybb_contests`");
    }

    if($db->table_exists("contests_user_options")) {
        $db->query("DROP TABLE `mybb_contests_user_options`");
    }

    if($db->table_exists("contests_user_pinned")) {
        $db->query("DROP TABLE `mybb_contests_user_pinned`");
    }

    contests_templates_uninstall();

	if (class_exists('MybbStuff_MyAlerts_AlertTypeManager')) {
		$alertTypeManager = MybbStuff_MyAlerts_AlertTypeManager::getInstance();
		if (!$alertTypeManager) {
			$alertTypeManager = MybbStuff_MyAlerts_AlertTypeManager::createInstance($db, $cache);
		}
		$alertTypeManager->deleteByCode('tags');
	}
}

function contests_activate() {
    global $mybb, $db;

}

function contests_deactivate() {
    global $mybb, $db;

}

function contests_alerts() {
    global $mybb, $lang;
    $lang->load('contests');
    /**
     * Alert formatter for my custom alert type.
     */
    class MybbStuff_MyAlerts_Formatter_TagsFormatter extends MybbStuff_MyAlerts_Formatter_AbstractFormatter
    {
        /**
         * Format an alert into it's output string to be used in both the main alerts listing page and the popup.
         *
         * @param MybbStuff_MyAlerts_Entity_Alert $alert The alert to format.
         *
         * @return string The formatted alert string.
         */
        public function formatAlert(MybbStuff_MyAlerts_Entity_Alert $alert, array $outputAlert)
        {
            $alertContent = $alert->getExtraDetails();
            return $this->lang->sprintf(
                $this->lang->contests_alert_tags,
                $outputAlert['from_user'],
                $alertContent['tags'],
                $outputAlert['dateline']
            );
        }

        /**
         * Init function called before running formatAlert(). Used to load language files and initialize other required
         * resources.
         *
         * @return void
         */
        public function init()
        {
            if (!$this->lang->contests) {
                $this->lang->load('contests');
            }
        }

        /**
         * Build a link to an alert's content so that the system can redirect to it.
         *
         * @param MybbStuff_MyAlerts_Entity_Alert $alert The alert to build the link for.
         *
         * @return string The built alert, preferably an absolute link.
         */
        public function buildShowLink(MybbStuff_MyAlerts_Entity_Alert $alert)
        {
            return $this->mybb->settings['bburl'] . '/' . 'contests.php?action=view&cid=' . $alert->getObjectId();
        }
    }

    if (class_exists('MybbStuff_MyAlerts_AlertFormatterManager')) {
        $formatterManager = MybbStuff_MyAlerts_AlertFormatterManager::getInstance();

        if (!$formatterManager) {
            $formatterManager = MybbStuff_MyAlerts_AlertFormatterManager::createInstance($mybb, $lang);
        }

        $formatterManager->registerFormatter(
                new MybbStuff_MyAlerts_Formatter_TagsFormatter($mybb, $lang, 'tags')
        );
    }

  /**
     * Alert formatter for my custom alert type.
     */
    class MybbStuff_MyAlerts_Formatter_PinnedFormatter extends MybbStuff_MyAlerts_Formatter_AbstractFormatter
    {
        /**
         * Format an alert into it's output string to be used in both the main alerts listing page and the popup.
         *
         * @param MybbStuff_MyAlerts_Entity_Alert $alert The alert to format.
         *
         * @return string The formatted alert string.
         */
        public function formatAlert(MybbStuff_MyAlerts_Entity_Alert $alert, array $outputAlert)
        {
            $alertContent = $alert->getExtraDetails();
            return $this->lang->sprintf(
                $this->lang->contests_alert_pinned,
                $outputAlert['from_user'],
                $alertContent['name'],
                $outputAlert['dateline']
            );
        }

        /**
         * Init function called before running formatAlert(). Used to load language files and initialize other required
         * resources.
         *
         * @return void
         */
        public function init()
        {
            if (!$this->lang->contests) {
                $this->lang->load('contests');
            }
        }

        /**
         * Build a link to an alert's content so that the system can redirect to it.
         *
         * @param MybbStuff_MyAlerts_Entity_Alert $alert The alert to build the link for.
         *
         * @return string The built alert, preferably an absolute link.
         */
        public function buildShowLink(MybbStuff_MyAlerts_Entity_Alert $alert)
        {
            return $this->mybb->settings['bburl'] . '/' . 'contests.php?action=view&cid=' . $alert->getObjectId();
        }
    }

    if (class_exists('MybbStuff_MyAlerts_AlertFormatterManager')) {
        $formatterManager = MybbStuff_MyAlerts_AlertFormatterManager::getInstance();

        if (!$formatterManager) {
            $formatterManager = MybbStuff_MyAlerts_AlertFormatterManager::createInstance($mybb, $lang);
        }

        $formatterManager->registerFormatter(
                new MybbStuff_MyAlerts_Formatter_PinnedFormatter($mybb, $lang, 'pinned')
        );
    }

}

function contests_global() {
    global $db, $mybb, $templates, $contests_bit, $pinned_bit, $contests;

    $contest_bit = "";
    $timestamp = TIME_NOW;
    $uid = $mybb->user['uid'];
    $sql = "SELECT newest FROM mybb_contests_user_options WHERE uid = '$uid'";
    $newest = $db->fetch_field($db->query($sql), "newest");
    if($newest == 1 or !$newest) {
        $sql = "SELECT * FROM mybb_contests_user_pinned INNER JOIN mybb_contests ON mybb_contests.cid = mybb_contests_user_pinned.cid WHERE mybb_contests_user_pinned.uid = '{$uid}'";
        $query = $db->query($sql);
        $i = 0;
        while($pinned = $db->fetch_array($query)) {
            $i++;
            $pinned['deadline'] = date("d.m.Y", $pinned['endtime']);
            $pinned['link'] = "<a href=\"contests.php?action=view&cid={$pinned['cid']}\" target=\"_blank\">{$pinned['name']}</a>";
            eval("\$pinned_bit .= \"".$templates->get("header_contests_pinned_bit")."\";");  
        }

        $uid = $mybb->user['uid'];
    
        $sql = "SELECT categories FROM mybb_contests_user_options WHERE uid = '$uid'";
        $categories = $db->fetch_field($db->query($sql), "categories");
        $cats = explode(", ", $categories);
        foreach($cats as $cat) {
            $catview .= "'$cat',";
        }
        $catview = rtrim($catview,',');
        if(!$categories) {
            $catview = "'coding', 'graphics', 'writing'";
        }

        $sql = "SELECT cid, type, name, endtime FROM mybb_contests WHERE visibility = '1'  AND category IN({$catview}) AND endtime > '$timestamp' ORDER by cast(endtime AS signed) DESC";
        $query = $db->query($sql);
        while($newest_contest = $db->fetch_array($query)) {
            $newest_contest['deadline'] = date("d.m.Y", $newest_contest['endtime']);
            $newest_contest['url'] = "<a href=\"contests.php?action=view&cid={$newest_contest['cid']}\">{$newest_contest['name']}</a>";
            eval("\$contests_bit .= \"".$templates->get("header_contests_newest_contests")."\";");    
        }
        eval("\$contests = \"".$templates->get("header_contests")."\";"); 
    }
}