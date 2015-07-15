<?php

require('/etc/fdroid/api-config.php');

// Valid repo names
$repos = array('mainline', 'nightly');

// Errors codes
$status_codes= array(
   0 => 'Command complete.',
   1 => 'No SECRET_KEY found in POST parameters.',
   2 => 'No REPO found in POST parameters. Value: ' . implode(' or ', $repos) . '.',
   3 => 'Bad SECRET_KEY.',
   4 => 'Bad REPO. Must be ' . implode(' or ', $repos) . '.',
   5 => 'Failed to update the repo.',
);

if (! isset($_POST['SECRET_KEY'])) {
   returnJson(1);
}

if (! isset($_POST['REPO'])) {
   returnJson(2);
}

if ($_POST['SECRET_KEY'] != $SECRET_KEY) {
   returnJson(3);
}

if (! in_array($_POST['REPO'], $repos, TRUE)) {
   returnJson(4);
}

// All seems good so far
// Launching repo update

$result = shell_exec("/usr/local/bin/fdroid-update.sh " . $_POST['REPO'] . " 2>&1 && echo ' ' || echo ''");
if ($result === NULL) {
   returnJson(5);
}

returnJson(0);

// Render the response
function returnJson($code) {
   global $status_codes;

   header('Content-Type: application/json');
   print json_encode(array('status' => $code, 'message' => $status_codes[$code]));
   exit;
}
