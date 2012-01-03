<?= '<?xml version="1" encoding="utf-8"?>' . PHP_EOL ?>
<wow>
<?php
$mysql['host']	="localhost";
$mysql['user']	="tvnotici_jo161";
$mysql['pass']	="lG{UF9rk2V2z";
$mysql['db']	="tvnotici_jo161";
@$db = mysql_pconnect($mysql['host'], $mysql['user'], $mysql['pass']);
if (!$db)
{
  die("error");
}
mysql_select_db($mysql['db']);
//video random selection
$query = "SELECT * FROM jos_videos ORDER BY RAND() LIMIT 1";
$result = mysql_query($query);

//Pre roll video random selection
$preroll = "SELECT * FROM jos_prerolls ORDER BY RAND() LIMIT 1";
$preroll_result = mysql_query($preroll);

//$text_add = "SELECT * FROM text_ads ORDER BY RAND() LIMIT 1";
//$text_add_result = mysql_query($text_add);

header ("Content-Type: application/xml");
$main = mysql_fetch_array($result);
$ad = mysql_fetch_array($preroll_result);
$text = mysql_fetch_array($text_add_result);
//var_dump($main);
//var_dump($ad);
//var_dump($_GET);
$output = ' <video>' . PHP_EOL;
$output .= '    <file>images/stories/videos/' . $ad['video'] . '</file>' . PHP_EOL;
$output .= '    <file2>videos/' . $main['video'] . '</file2>' . PHP_EOL;
$output .= '  </video>' . PHP_EOL;
$output .= '  <video>' . PHP_EOL;
$output .= '    <headline>FlashDen.net</headline>' . PHP_EOL;
$output .= '    <desc>Buy & sell exclusive flash components and movie clips!</desc>' . PHP_EOL;
$output .= '    <link>http://www.flashden.net</link>' . PHP_EOL;
$output .= '  </video>' . PHP_EOL;
?>
 <?= $output ?>
</wow>