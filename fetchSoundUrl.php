<?php
header('Content-type: application/json; charset=utf-8');

$baseUrl='http://www.51voa.com';

$html_line_array = file($baseUrl); 
foreach ($html_line_array as $l)
{
	if(stripos($l, '<ul><li><a') !== false)
	{
		$selected_line  = $l;
		break;
	}
}

preg_match_all('/href="(.+?)"/', $selected_line, $selected_array); // get href value
$selected_array = preg_grep('/.*English.*/', $selected_array[1]); // filter href value by word 'English'
$selected_array = array_values($selected_array); // indexes numerically the array
$index = rand(0, count($selected_array)-1); // generate a random number

$articleUrl = $baseUrl.$selected_array[$index];
$sub_html_line_array = file($articleUrl); // get a random page

foreach ($sub_html_line_array as $l)
{
	if(stripos($l, '/images/icon/mp3.gif') !== false)
	{
		preg_match('/http\:\/\/(.+?)\.mp3/', $l, $m); // get href value
		$soundUrl = str_replace('down.51voa.com', 'player.51voa.com', $m[0]);
		break;
	}
}

//return result
if(isset($soundUrl))
{
	$response = json_encode(array("soundUrl"=> $soundUrl, "articleUrl" => $articleUrl));
	echo $response;
}
else
{
	echo "failed";
}
?>
