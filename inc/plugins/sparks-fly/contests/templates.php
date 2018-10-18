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
                                    <option value="coding">Coding</option>
                                    <option value="graphics">Graphics</option>
                                    <option value="writing">Writing</option>
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
                                  <input type="text" name="type" size="25" />
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
                        <input type="text" name="title" size="25" />
                    </td>
                </tr>
                <tr>
                    <td class="tcat" colspan="2"><strong>Aufgabentext</strong></td>
                </tr>
                <tr>
                    <td class="trow2" colspan="2" align="center">
                        <textarea rows="7" cols="100" name="description"> 
                        </textarea>
                    </td>
                </tr>
                    <td class="tcat" colspan="2"><strong>Contest mit Tags versehen</strong></td>
                </tr>
                <tr>
                    <td class="trow1" width="50%">
                        <strong>Tags:</strong>
                    </td>
                    <td class="trow1" width="60%" align="center">
                        <input type="text" name="tags" size="25" />
                    </td>
                </tr>
                <tr>
                    <td class="tcat" colspan="2"><strong>Zeit & Fristen</strong></td>
                </tr>
                <tr>
                    <td class="trow2" width="50%">
                        <strong>Start-Datum:</strong>
                    </td>
                    <td class="trow2" width="60%" align="center">
                        <select name="start_day">{$day_bit}</select> <select name="start_month">
                        <option value="january">Januar</option>
                        <option value="february">Februar</option>
                        <option value="march">März</option>
                        <option value="april">April</option>
                        <option value="may">Mai</option>
                        <option value="june">Juni</option>
                        <option value="july">Juli</option>
                        <option value="august">August</option>
                        <option value="september">September</option>
                        <option value="october">Oktober</option>
                        <option value="november">November</option>
                        <option value="december">Dezember</option></select> <select name="start_year">{$year_bit}</select> 
                    </td>
                </tr>
                <tr>
                    <td class="trow1" width="50%">
                        <strong>End-Datum:</strong>
                    </td>
                    <td class="trow1" width="60%" align="center">
                        <select name="end_day">{$day_bit}</select> <select name="end_month">
                        <option value="january">Januar</option>
                        <option value="february">Februar</option>
                        <option value="march">März</option>
                        <option value="april">April</option>
                        <option value="may">Mai</option>
                        <option value="june">Juni</option>
                        <option value="july">Juli</option>
                        <option value="august">August</option>
                        <option value="september">September</option>
                        <option value="october">Oktober</option>
                        <option value="november">November</option>
                        <option value="december">Dezember</option></select> <select name="end_year">{$year_bit}</select> 
                    </td>
                </tr>
            </table>
    <input type="hidden" name="my_post_key" value="{$mybb->post_code}" />
    <br />
    <center>
    <input type="hidden" name="action" value="do_add_contest" />
    <input type="submit" class="button" name="submit" value="Contest hinzufügen" />
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
                                <td width="50%"><strong>Tags:</strong><br />
									<span class="smalltext">Contests mit welchen Tags interessieren dich besonders?</span>
                                </td>
                                <td class="trow1" width="60%" align="center">
                                  <input type="text" name="tags" size="25" value="{$options[\'tags\']}" />
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
    $db->delete_query('templates', "title LIKE 'contests_%'");
}