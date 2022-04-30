<?php

// Defining constant
define("BASE_URL", "http://toxicunrated.com/new/1/Downloads/TV-Series/Merlin.html");
define("SITE_URL", BASE_URL."TV_Series/");
 
 require 'simple_html_dom.php';
$url = BASE_URL;
$maindom = @file_get_html($url);
 
// $opfile = 'toxicwap.csv';
// $output = fopen($opfile,'w') or die("Can't open php://output");
// header("Content-Type:application/csv"); 
// header("Content-Disposition:attachment;filename=".$opfile); 
// fputcsv($output, array('id','name','description'));
$p = [];
$count = 0;
echo "<pre>";
var_dump($url);
$nextUrl = '';
while(true){

	if (!$maindom) {
		break;
	}
	$ret = $maindom->find('ul li a'); 
	$nextUrl = '';
	var_dump($nextUrl);
	foreach ($ret as $k1 => $value) {
		if ($value->innertext == 'Next') {
			$nextUrl = $value->href;
			break;
		}
		echo($value->outertext.'<==>'.$value->href);
		echo('<br>');
		$seriesPage = @file_get_html($value->href);
		if (!$seriesPage) {
			break;
		}
		$series = $seriesPage->find('ul li a'); 

		foreach ($series as $s_k => $s_v) {
			$s_url = BASE_URL.$s_v->href;
			var_dump($s_url);
			$episodePage = @file_get_html($s_url);
			if (!$episodePage) {
				continue;
			}
			$episode = $episodePage->find('ul li a'); 
			foreach ($episode as $e_k => $e_v) {
				$e_url = BASE_URL.$e_v->href;
				// preg_match('/new//(.*?)//Videos//', $e_url, $fid);
				// var_dump('2.');var_dump($fid);
				// var_dump('3.');
				var_dump($e_url);

			}
		}
		echo('<br>');
		echo('<br>'); 
	}
	if ($nextUrl == '') {
		break;
	}else{ 
		$maindom = @file_get_html($nextUrl);
	}
	if ($count++ >= 20) {
		break;
	}
}
 
// fclose($output) or die("Can't close php://output");
 
echo "</pre>";
 
?>
 