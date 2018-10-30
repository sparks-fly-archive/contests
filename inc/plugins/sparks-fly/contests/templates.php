<?php
function contests_templates_install() {
  global $db, $templates, $mybb;

  $contests = array(
    'title'		=> 'contests',
    'template'	=> $db->escape_string('<html>
    <head>
    <title>Storming Gates - Contests</title>
    {$headerinclude}
    </head>
    <body>
    {$header}
    <table width="100%" border="0" align="center">
    <tr>
    <td width="23%" valign="top">
    {$contests_nav}
    </td>
    <td valign="top">
    <table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
    <tr>
    <td class="thead" colspan="{$colspan}"><strong>Storming Gates - Contests</strong></td>
    </tr>
    <tr>
    <td class="trow2" style="padding: 10px; text-align: justify;">
    <div style="width: 95%; margin: auto; padding: 8px;  font-size: 12px; line-height: 1.5em;" class="trow1">
        <img src="images/contests/003-information.png" align="left" style="margin: 10px;" /> Herzlich Willkommen bei den <strong>Storming Gates-Contests!</strong> [...] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna.<br /><br />
        
        <center>
            <div class="contest_link"><img src="images/contests/011-html.png" /></div>
            <div class="contest_link"><img src="images/contests/012-paint-brush.png" /></div>
            <div class="contest_link"><img src="images/contests/002-edit-1.png" /></div>
        </center>
        
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    {$footer}
    </body>
    </html>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $contests);

  $contests_nav = array(
    'title'		=> 'contests_nav',
    'template'	=> $db->escape_string('<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder con-nav">
    <tbody>
        <tr>
            <td class="thead"><strong>Navigation</strong></td>
        </tr>
        <tr>
            <td class="trow1 smalltext"><img src="images/contests/013-house.png" style="width: 12px;" /> <a href="contests.php">Contest-Startseite</a></td>
        </tr>
        <tr>
            <td class="trow2 smalltext"><img src="images/contests/011-html.png" style="width: 12px;" /> <a href="contests.php?action=browse&category=coding">Coding-Contests</a></td>
        </tr>
        <tr>
            <td class="trow1 smalltext"><img src="images/contests/012-paint-brush.png" style="width: 12px;" /> <a href="contests.php?action=browse&category=graphics">Graphics-Contests</a></td>
        </tr>
        <tr>
            <td class="trow2 smalltext"><img src="images/contests/002-edit-1.png" style="width: 12px;" /> <a href="contests.php?action=browse&category=writing">Writing-Contests</a></td>
        </tr>
        <tr>
            <td class="tcat">User-Optionen</td>
        </tr>
        <tr>
            <td class="trow1 smalltext"><img src="images/contests/002-edit-1.png" style="width: 12px;" /> <a href="contests.php?action=options">Einstellungen</a></td>
        </tr>
        <tr>
            <td class="trow2 smalltext"><img src="images/contests/007-push-pin.png" style="width: 12px;" /> <a href="contests.php?action=pinned">Gemerkte Contests</a></td>
        </tr>
        {$contests_nav_team}
    </tbody>
    </table>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $contests_nav);  

  $contests_nav_team = array(
    'title'		=> 'contests_nav_team',
    'template'	=> $db->escape_string('	<tr>
    <td class="tcat">Team-Optionen</td>
</tr>
<tr>
    <td class="trow2 smalltext"><img src="images/contests/009-add.png" style="width: 11px;" />  <a href="contests.php?action=add_contest">Contest hinzufügen</a></td>
</tr>
<tr>
    <td class="trow2 smalltext"><img src="images/contests/009-add.png" style="width: 11px;" />  <a href="contests.php?action=drafts">Entwürfe</a></td>
</tr>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $contests_nav_team);

  $contests_team_add = array(
    'title'		=> 'contests_team_add',
    'template'	=> $db->escape_string('<html>
    <head>
    <title>Storming Gates - Contest hinzufügen</title>
    {$headerinclude}
    </head>
    <body>
    {$header}
    <table width="100%" border="0" align="center">
    <tr>
    <td width="23%" valign="top">
    {$contests_nav}
    </td>
    <td valign="top">
    <table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
    <tr>
    <td class="thead" colspan="{$colspan}"><strong>Storming Gates - Contest hinzufügen</strong></td>
    </tr>
    <tr>
    <td class="trow2" style="padding: 10px; text-align: justify;">
    <div style="width: 95%; margin: auto; padding: 8px;" class="trow1">
        
        <form action="contests.php?action=add_contest" method="post">
            <table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder" style="text-align: justify;">
                <tr>
                    <td class="thead" colspan="2"><strong>Hinzufügen</strong></td>
                </tr>
                <tr>
                    <td class="tcat" colspan="2"><strong>Allgemeines</strong></td>
                </tr>
                <tr>
                    <td class="trow1" colspan="2">
                        <table cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td width="50%"><strong>Bereich auswählen:</strong>
                                </td>
                                <td align="center"><select name="section">
                                    <option value="">Bereich auswählen</option>
        							{$category_bit}
                                    </select></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="trow2" colspan="2">
                        <table cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td width="50%"><strong>Art des Contest:</strong>
                                </td>
                                <td class="trow1" width="60%" align="center">
                                  <input type="text" name="type" size="25" value="{$contest[\'type\']}"/>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="trow2" width="50%">
                        <strong>Contest-Name:</strong>
                    </td>
                    <td class="trow2" width="60%" align="center">
                        <input type="text" name="title" size="25" value="{$contest[\'name\']}" />
                    </td>
                </tr>
                <tr>
                    <td class="tcat" colspan="2"><strong>Aufgabentext</strong></td>
                </tr>
                <tr>
                    <td class="trow2" colspan="2" align="center">
                        <textarea rows="7" cols="100" name="description">{$contest[\'description\']}</textarea>
                    </td>
                </tr>
                    <td class="tcat" colspan="2"><strong>Contest mit Tags versehen</strong></td>
                </tr>
                <tr>
                    <td class="trow1" width="50%">
                        <strong>Tags:</strong>
                    </td>
                    <td class="trow1" width="60%" align="center">
                        <input type="text" name="tags" size="25" value="{$contest[\'tags\']}" />
                    </td>
                </tr>
                <tr>
                    <td class="tcat" colspan="2"><strong>Zeit & Fristen</strong></td>
                </tr>
                <tr>
                    <td class="trow1" width="50%">
                        <strong>End-Datum:</strong>
                    </td>
                    <td class="trow1" width="60%" align="center">
                        <select name="end_day">
							{$day_bit}
						</select> 
						<select name="end_month">
							{$month_bit}
						</select> 
						<select name="end_year">
							{$year_bit}
						</select> 
                    </td>
                </tr>
            </table>
    <input type="hidden" name="my_post_key" value="{$mybb->post_code}" />
    <br />
    <center>
    <input type="hidden" name="action" value="do_add_contest" />
		<input type="hidden" name="cid" value="{$cid}" />
    <input type="submit" class="button" name="savedraft" value="Entwurf speichern" /> <input type="submit" class="button" name="submit" value="Contest hinzufügen" />
    </center>
        </form>
            
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    {$footer}
    </body>
    </html>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $contests_team_add);

  $contests_user_options = array(
    'title'		=> 'contests_user_options',
    'template'	=> $db->escape_string('<html>
    <head>
    <title>Storming Gates - Contests - Einstellungen hinzufügen</title>
    {$headerinclude}
    </head>
    <body>
    {$header}
    <table width="100%" border="0" align="center">
    <tr>
    <td width="23%" valign="top">
    {$contests_nav}
    </td>
    <td valign="top">
    <table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
    <tr>
    <td class="thead" colspan="{$colspan}"><strong>Storming Gates - Contests - Einstellungen hinzufügen</strong></td>
    </tr>
    <tr>
    <td class="trow2" style="padding: 10px; text-align: justify;">
    <div style="width: 95%; margin: auto; padding: 8px;" class="trow1">
        
        <form action="contests.php?action=add_contest" method="post">
            <table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder" style="text-align: justify;">
                <tr>
                    <td class="thead" colspan="2"><strong>Einstellungen hinzufügen</strong></td>
                </tr>
                <tr>
                    <td class="trow2" colspan="2">
                        <table cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td width="50%" class="trow2"><strong>Tags:</strong><br />
									<span class="smalltext">Contests mit welchen Tags interessieren dich besonders?</span>
                                </td>
                                <td class="trow2" width="60%" align="center">
                                  <input type="text" name="tags" size="25" value="{$options[\'tags\']}" />
                                </td>
                            </tr>
							<tr>
								<td class="tcat" colspan="2">Contest-Übersicht</td>
							</tr>
                            <tr>
                                <td width="50%" class="trow1"><strong>Neueste Contests auf dem Index:</strong><br />
									<span class="smalltext">Sollen die Contest-Inhalte auf dem Index/dem Header angezeigt werden?</span>
                                </td>
                                <td class="trow1" width="60%" align="center">
									<select name="newest">
										<option value="">Auswählen</option>
										<option value="1">Ja</option>
										<option value="0">Nein</option>
									</select>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" class="trow2"><strong>Bereiche auf dem Index:</strong><br />
									<span class="smalltext">Offene Contests welcher Bereiche sollen auf dem Index angezeigt werden?</span>
                                </td>
                                <td class="trow2" width="60%" align="center">
									{$category_bit}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
    <input type="hidden" name="my_post_key" value="{$mybb->post_code}" />
    <br />
    <center>
    <input type="hidden" name="action" value="do_options" />
    <input type="submit" class="button" name="submit" value="Einstellungen speichern" />
    </center>
        </form>
            
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    {$footer}
    </body>
    </html>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $contests_user_options);

  $contests_team_drafts = array(
    'title'		=> 'contests_team_drafts',
    'template'	=> $db->escape_string('<html>
    <head>
    <title>Storming Gates - Contests - Entwürfe</title>
    {$headerinclude}
    </head>
    <body>
    {$header}
    <table width="100%" border="0" align="center">
    <tr>
    <td width="23%" valign="top">
    {$contests_nav}
    </td>
    <td valign="top">
    <table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
    <tr>
    <td class="thead" colspan="{$colspan}"><strong>Storming Gates - Contests - Entwürfe</strong></td>
    </tr>
    <tr>
    <td class="trow2" style="padding: 10px; text-align: justify;">
    <div style="width: 95%; margin: auto; padding: 8px;" class="trow1">
            {$multipage}
		<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
		<tr>
		<td class="thead" colspan="4"><strong>Entwürfe ($contestcount)</strong></td>
		</tr>
		<tr>
		<td width="30%" class="tcat"><span class="smalltext"><strong>Contest-Name</strong></span></td>
		<td class="tcat" align="center" width="30%"><span class="smalltext"><strong>Gespeichert</strong></span></td>
		<td class="tcat" align="center" width="40%"><span class="smalltext"><strong>Optionen</strong></span></td>
		</tr>
		{$draft_bit}
		</table>
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    {$footer}
    </body>
    </html>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $contests_team_drafts);

  $contests_team_drafts_bit = array(
    'title'		=> 'contests_team_drafts_bit',
    'template'	=> $db->escape_string('<tr>
    <td class="{$trow}"><strong>{$draft[\'name\']}</strong><br /><span class="smalltext">{$draft[\'category\']}</span></td>
    <td class="{$trow}" align="center">{$savedate}</td>
    <td class="{$trow}" align="center"><a href="contests.php?action=add_contest&cid={$draft[\'cid\']}">Entwurf bearbeiten</a></td>
    </tr>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $contests_team_drafts_bit);

  $contests_view_contest = array(
    'title'		=> 'contests_view_contest',
    'template'	=> $db->escape_string('<html>
    <head>
    <title>Storming Gates - Contests - {$contest[\'name\']}</title>
    {$headerinclude}
    </head>
    <body>
    {$header}
    <table width="100%" border="0" align="center">
    <tr>
    <td width="23%" valign="top">
    {$contests_nav}
    </td>
    <td valign="top">
    <table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
    <tr>
    <td class="thead" colspan="{$colspan}"><strong>{$contest[\'name\']} - {$contest[\'type\']}</strong></td>
    </tr>
    <tr>
    <td class="trow2" style="padding: 10px; text-align: justify;">
    <div style="width: 95%; margin: auto; padding: 8px;" class="trow1">
	<table border="0" cellspacing="5" cellpadding="{$theme[\'tablespace\']}"  class="tborder">
		<tr>
			<td class="trow2" colspan="2">
				<div class="contest_options contests_buttons">{$contest_pin} {$team_options}</div>
			</td>
		</tr>
		<tr>
			<td class="trow2" id="sg-profile-avatar" valign="middle">
				{$author[\'avatarlink\']}
			</td>
			<td class="trow2 sg-profile-data" valign="middle">
				    <li><span><i class="fa fa-bars" aria-hidden="true"></i> Kategorie</span> <data>{$contest[\'category\']}</data>
					<li><span><i class="fa fa-question" aria-hidden="true"></i> Contest-Art</span> <data>{$contest[\'type\']}</data>
					<li><span>&bull; Tags</span> <data>{$contest[\'tags\']}</data>
				<li><span><i class="fa fa-calendar" aria-hidden="true"></i> Deadline</span> <data>{$contest[\'deadline\']}</data>
			</td>
		</tr>
		<tr>
			<td class="trow2" colspan="2">
				<div id="contest_content">
					{$contest[\'description\']}
				</div>
			</td>
		</tr>
	</table>            
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    {$footer}
    </body>
    </html>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $contests_view_contest);

  $contests_view_contests = array(
    'title'		=> 'contests_view_contests',
    'template'	=> $db->escape_string('<html>
    <head>
    <title>Storming Gates - Contests</title>
    {$headerinclude}
    </head>
    <body>
    {$header}
    <table width="100%" border="0" align="center">
    <tr>
    <td width="23%" valign="top">
    {$contests_nav}
    </td>
    <td valign="top">
    <table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
    <tr>
    <td class="thead" colspan="{$colspan}"><strong>Storming Gates - Contests</strong></td>
    </tr>
    <tr>
    <td class="trow2" style="padding: 10px; text-align: justify;">
    <div style="width: 95%; margin: auto; padding: 8px;" class="trow1">
		<form action="contests.php" method="get">
		<input type="hidden" name="action" value="browse" />
		<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder" width="70%">
			<tr>
				<td class="tcat">Kategorie</td>
				<td class="tcat">Art</td>	
				<td class="tcat">Tags</td>
			</tr>
			<tr>
				<td class="trow1"><select name="category"><option value="">Kategorie auswählen</option>{$category_bit}</select></td>
				<td class="trow1"><select name="type"><option value="">Art auswählen</option>{$types_bit}</select></td>	
				<td class="trow1"><select name="tag"><option value="">Tag auswählen</option>{$tag_bit}</select></td>
			</tr>
			<tr>
				<td class="trow2" colspan="3">
				</td>
			</tr>
		</table>
		<center>
		<input type="submit" class="button" value="Contests suchen" /><br /><br />
		</center>
		</form>
            {$multipage}
			{$contest_bit}
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    {$footer}
    </body>
    </html>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $contests_view_contests);

  $contests_view_contests_bit = array(
    'title'		=> 'contests_view_contests_bit',
    'template'	=> $db->escape_string('<table cellpadding="5" cellspacing="5" class="tborder">
	<tr class="trow2">
		<td width="60%" valign="top" align="center">
			<div class="contestname"><a href="contests.php?action=view&cid={$contest[\'cid\']}">{$contest[\'name\']}</a></div>
			<div class="contest_detail">Bereich: {$contest[\'category\']}</div>
			<div class="contest_detail">Art: {$contest[\'type\']}</div>
			<div style="clear: both;"></div>
		</td>
		<td width="15%" valign="top">
			<div class="end_date_cal">
				<div class="end_date_top">Endet am
				</div>
				<div class="end_date_day">
					{$end_day}.
				</div>
				<div class="end_date_month">
					{$end_month}
				</div>
			</div>
		</td>
		<td valign="top">
			<div class="contest_description">
			{$contest[\'description\']}
			</div>
		</td>
	</tr>
</table>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $contests_view_contests_bit);

  $contests_team_contest_options = array(
    'title'		=> '$contests_team_contest_options',
    'template'	=> $db->escape_string('<a href="contests.php?action=add_contest&cid={$contest[\'cid\']}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Contest bearbeiten</a>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $contests_team_contest_options);

  $contests_view_contest_pin = array(
    'title'		=> '$contests_view_contest_pin',
    'template'	=> $db->escape_string('<a href="contests.php?action=pin&cid={$contest[\'cid\']}"><i class="fa fa-thumb-tack" aria-hidden="true"></i> Contest Merken</a>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $contests_view_contest_pin);

  $contests_view_contest_unpin = array(
    'title'		=> '$contests_view_contest_unpin',
    'template'	=> $db->escape_string('<a href="contests.php?action=unpin&cid={$contest[\'cid\']}"><i class="fa fa-thumb-tack" aria-hidden="true"></i> Nicht weiter merken</a>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $contests_view_contest_unpin);

  $contests_view_pinned = array(
    'title'		=> 'contests_view_pinned',
    'template'	=> $db->escape_string('<html>
    <head>
    <title>Storming Gates - Gemerkte Contests</title>
    {$headerinclude}
    </head>
    <body>
    {$header}
    <table width="100%" border="0" align="center">
    <tr>
    <td width="23%" valign="top">
    {$contests_nav}
    </td>
    <td valign="top">
    <table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">
    <tr>
    <td class="thead" colspan="{$colspan}"><strong>Storming Gates - Gemerkte Contests</strong></td>
    </tr>
    <tr>
    <td class="trow2" style="padding: 10px; text-align: justify;">
    <div style="width: 95%; margin: auto; padding: 8px;" class="trow1">
            {$multipage}
			{$contest_bit}
    </div>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    {$footer}
    </body>
    </html>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $contests_view_pinned);

  $header_contests_pinned_bit = array(
    'title'		=> 'header_contests_pinned_bit',
    'template'	=> $db->escape_string('<tr>
	<td class="trow1 smalltext">{$pinned[\'link\']}</td>
	<td class="trow1 smalltext">{$pinned[\'deadline\']}</td>
	<td class="trow1 smalltext"><a href="contests.php?action=unpin&cid={$pinned[\'cid\']}">Nicht weiter merken</a></td>
</tr>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $header_contests_pinned_bit);

  $header_contests = array(
    'title'		=> 'header_contests',
    'template'	=> $db->escape_string('	<tr>
    <td style="width: 25%" class="td1">Offene Contests</td>
    <td style="width: 25%" class="td2">5 Neueste Contest-Teilnahmen</td>
    <td style="width: 25%" class="td1">5 Neueste Abstimmungen</td>
    <td style="width: 25%" class="td2">Deine gemerkten Contests</td>
    </tr>
    <tr>
        <td><div class="td3"><table border="0" cellspacing="3" cellpadding="5" class="tborder newest" style="width: 100%;">{$contests_bit}</table></div></td>
        <td><div class="td3"><table border="0" cellspacing="3" cellpadding="5" class="tborder newest" style="width: 100%;"></table></div></td>
        <td><div class="td3"><table border="0" cellspacing="3" cellpadding="5" class="tborder newest" style="width: 100%;"></table></div></td>
        <td><div class="td3"><table border="0" cellspacing="3" cellpadding="5" class="tborder newest" style="width: 100%;">{$contests_pinned}</table></div>
        </td>
        </tr>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $header_contests);

  $contests_view_contest_participate = array(
    'title'		=> 'contests_view_contest_participate',
    'template'	=> $db->escape_string('<a href="contests.php?action=participate&cid={$contest[\'cid\']}"><i class="fa fa-reply" aria-hidden="true"></i> Teilnehmen</a>'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $contests_view_contest_participate);

  /* $template_name = array(
    'title'		=> 'template_name',
    'template'	=> $db->escape_string('INHALT'),
    'sid'		=> '-1',
    'version'	=> '',
    'dateline'	=> TIME_NOW
  );
  $db->insert_query("templates", $template_name); */

}

function contests_templates_uninstall() {
    global $db;
    $db->delete_query('templates', "title LIKE 'contests%'");
}