<!DOCTYPE html>
<html lang="en">
<head>
    <title>HTACCESS Comparing Tool</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<?php
$old_htaccess = file_get_contents('files/htaccess_old.txt');
$new_htaccess = file_get_contents('files/htaccess_new.txt');
$new_htaccess = str_replace('  ' . PHP_EOL, PHP_EOL, $new_htaccess);
$old_htaccess_draft = $old_htaccess;
$new_htaccess_draft = $new_htaccess;
// Pattern to get blocks between the comments
// # site_name start.
// # site_name end.
$sites_new_htaccess_pattern = '/\s\s\#\s([a-z_]*?)\sstart\.\n(.*?)\s\s\s\#\s([a-z_]*?)\send\./si';
preg_match_all($sites_new_htaccess_pattern, $new_htaccess, $matches);
if (!empty($matches)) {
  $full_matched_htaccess_block = $matches[0]; 'include comments # site_name start. and # site_name end.';
  $sites  = $matches[1];
  $sites_rules = $matches[2];
  $invalid_sites = array();
  $mixed_htaccess = '';
  foreach ($sites_rules as $sites_rule_number => $site_rule ) {
    if (strpos($old_htaccess, $site_rule) !== FALSE) {
      $old_htaccess_draft = str_replace($site_rule, '[MATCHED]', $old_htaccess_draft);
      $new_htaccess_draft = str_replace($full_matched_htaccess_block[$sites_rule_number], '[MATCHED]', $new_htaccess_draft);
    } else {
      $invalid_sites[] = $matches[1][$sites_rule_number];
    }
  }
  // Replace lines with [MATCHED] string.
  $old_htaccess_draft = str_replace('[MATCHED]' . PHP_EOL, '', $old_htaccess_draft);
  $new_htaccess_draft = str_replace('[MATCHED]' . PHP_EOL, '', $new_htaccess_draft);

  $old_htaccess_draft_file = 'files/old_htaccess_draft.txt';
  $new_htaccess_draft_file = 'files/new_htaccess_draft.txt';
  unlink($old_htaccess_draft);
  unlink($new_htaccess_draft);
  file_put_contents($old_htaccess_draft_file, $old_htaccess_draft);
  file_put_contents($new_htaccess_draft_file, $new_htaccess_draft);
}
?>
<div class="container">
    <div class="jumbotron">
        <h1>Htaccess Comparisson Result</h1>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            New htaccess file path: <i>files/htaccess_new.txt</i><br>
            Old htaccess file path: <i>files/htaccess_old.txt</i></br>
        </div>
    </div>
    <div class="panel panel-<?php !empty($matches[1]) ? print 'success' : print 'danger'?> ">
        <div class="panel-heading"><h3 class="panel-title">1. Amount of matched sites</h3></div>
        <div class="panel-body"><?php !empty($matches[1]) ? print count($matches[1]) . ' Sites found' : print 'No Sites Found';?></div>
    </div>
    <div class="panel panel-info">
        <div class="panel-heading"><h3 class="panel-title">2. Sites with not matched htaccess blocks</h3></div>
        <div class="panel-body">
            <?php foreach ($invalid_sites as $site_name): ?>
            <?php print $site_name . '<br>'?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="panel panel-info">
        <div class="panel-heading"><h3 class="panel-title">3. Htaccess Diff Files</h3></div>
        <div class="panel-body">
        New htaccess diff path: <i>files/new_htaccess_draft.txt</i><br>
        Old htaccess diff path: <i>files/old_htaccess_draft.txt</i></br>
        </div>
    </div>
</div>

</body>
</html>
