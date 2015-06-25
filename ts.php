<?php
/*
 * ts.php
 * Kikyou Akino <bellflower@web4u.jp>
 *
 * Please put this in the same folder with tyranoscript's root folder
 */

echo preg_replace(
    '/<!--\s*<input type="hidden" id="first_scenario_file".*?>\s*-->/ms',
    '<input type="hidden" id="first_scenario_file" value="http://'
    . $_SERVER['HTTP_HOST']
    . dirname($_SERVER['SCRIPT_NAME'])
    . '/ks.php?ks='
    . htmlspecialchars($_REQUEST['ks'], ENT_QUOTES)
    . '">',
    file_get_contents('./index.html')
);
