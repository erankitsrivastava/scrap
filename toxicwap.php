<?php
include('main.php');
// Defining constant
define("BASE_URL", "http://toxicwap.com/");
define("SITE_URL", BASE_URL."TV_Series/");
define("DOWNLOAD_PAGE", 'http://toxicwap.com/areyouhuman5.php?fid=');

$classes = ['primary', 'warning', 'success', 'danger', 'light', 'info'];
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
echo '<div class="container">';
		echo '<h1> Serch URL'.$url.'</h1>';

// var_dump($url);
$nextUrl = '';
 
while(true){

	if (!$maindom) {
		break;
	}
	$ret = $maindom->find('ul li a'); 
	$nextUrl = '';
	// var_dump($nextUrl);
	foreach ($ret as $k1 => $value) {
		echo '<div class="card-columns">';
		if ($value->innertext == 'Next') {
			$nextUrl = $value->href; 
			break;
		}
		echo '<h2>'.$value->outertext.'</h2>';
		// echo($value->outertext.'<==>'.$value->href);
		// echo('<br>');
		$seriesPage = @file_get_html($value->href);
		if (!$seriesPage) {
			echo "</div>";
			break;
		}
		$series = $seriesPage->find('ul li a'); 

		foreach ($series as $s_k => $s_v) {
			$s_url = BASE_URL.$s_v->href;
			// var_dump($s_url);
			$episodePage = @file_get_html($s_url);
			if (!$episodePage) {
				continue;
			}
			$episode = $episodePage->find('ul li a'); 
			foreach ($episode as $e_k => $e_v) {
			 
				$e_url = BASE_URL.$e_v->href;
				$href_explode = explode('/new/', $e_v->href);
				$fid = explode('/', $href_explode[1]);
				$download = DOWNLOAD_PAGE.$fid[0];
				 

				// var_dump($e_url);

				 echo '<div class="card bg-'.$classes[rand(0,6)].'">
				   <div class="card-body text-center">
				     <p class="card-text">'.$fid[2].'</p>
				     <b><p><a href="'.$download.'" target="_blank">Downaload</a></p></b>
				     <b><p><a href="'.$e_url.'" target="_blank">View Page</a></p></b>
				   </div>
				 </div>';  

			}
		}
		// echo('<br>');
		// echo('<br>'); 
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
 
echo "</div>";
 
?>
 