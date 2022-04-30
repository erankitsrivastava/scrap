<?php

// Defining constant
define("BASE_URL", "http://toxicwap.com/");
define("SITE_URL", BASE_URL."TV_Series/");
$alphabet = 't';
if (isset($_GET['q'])) {
	$alphabet = $_GET['q'];
} 
define("ALPHABET", $alphabet);

echo('<h2>alphabet search for key is => '.$alphabet.'</h2>');
require 'simple_html_dom.php';
$url = SITE_URL.ALPHABET.'.php/';

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
	$fianlData = [];
	var_dump($nextUrl);
	foreach ($ret as $k1 => $value) {
		$data = [];
		if ($value->innertext == 'Next') {
			$nextUrl = $value->href;
			break;
		}
		$data['outertext'] = $value->outertext;
		$data['main_href'] = $value->href;
		 
		$seriesPage = @file_get_html($value->href);
		if (!$seriesPage) {
			break;
		}
		$series = $seriesPage->find('ul li a'); 

		foreach ($series as $s_k => $s_v) {
			var_dump($s_k);
			var_dump($s_v);die;
			$s_url = BASE_URL.$s_v->href;

			$data[]['href'] = $value->href;
		 
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
 