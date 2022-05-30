<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'simple_html_dom.php';
// Defining constant
define("BASE_URL", "https://www.sourcecodester.com/");
define("SITE_URL", BASE_URL."php-project/");
define("DOWNLOAD_PAGE", '');

$classes = ['primary', 'warning', 'success', 'danger', 'light', 'info'];
$alphabet = 't';
if (isset($_GET['q'])) {
	$alphabet = $_GET['q'];
}
define("ALPHABET", $alphabet);


$url = SITE_URL;
$maindom = file_get_html($url);

// $opfile = 'toxicwap.csv';
// $output = fopen($opfile,'w') or die("Can't open php://output");
// header("Content-Type:application/csv");
// header("Content-Disposition:attachment;filename=".$opfile);
// fputcsv($output, array('id','name','description'));
$p = [];
$count = 0;

// var_dump($url);
$nextUrl = '';
echo "<pre>";
$fp = fopen('sourcecodester.csv', 'w');
fputcsv($fp, ['id', 'client_id','views', 'title', 'short_description', 'url', 'image']);
$id = $page = 0;
while(true){

	if (!$maindom) {
		break;
	}
	$page++;
	var_dump("Processing page $page.:===============================================================================================");
	$ret = $maindom->find('#block-newsplus-lite-content .view-content .views-row');

	$nextUrl = '';
	// var_dump($nextUrl);
	foreach ($ret as $k1 => $value) {

		fputcsv(
			$fp,
			[
				$id++,
				current($value->find('article'))->attr['data-history-node-id'],
				current($value->find('li.statistics-counter'))->innertext,
				current($value->find('.node-content h2.node__title a span.field--name-title'))->innertext,
				current($value->find('.node-content div.field--name-body'))->innertext,
				BASE_URL.current($value->find('.node-content h2.node__title a'))->href,
				BASE_URL.current($value->find('.node-content div.field--type-image img'))->src
			]
		);
		var_dump('===============================================================================================');
		print_r([
			$id,
			current($value->find('article'))->attr['data-history-node-id'],
			current($value->find('.node-content h2.node__title a span.field--name-title'))->innertext,
			current($value->find('.node-content div.field--name-body'))->innertext,
			BASE_URL.current($value->find('.node-content h2.node__title a'))->href,
			BASE_URL.current($value->find('.node-content div.field--type-image img'))->src
		]);
	}
	if(!empty($nextElm = $maindom->find('nav.pager li.pager__item--next a'))){
		$nextUrl = current($nextElm)->href;
		if ($nextUrl == '') {
			$maindom = false;
			break;
		}else{
			$maindom = @file_get_html(BASE_URL.$nextUrl);
		}
	} else{
		$maindom = false;
		break;
	}
	/*if ($count++ >= 20) {
		break;
	}*/
}
fclose($fp);
// fclose($output) or die("Can't close php://output");

echo "DONE";

?>
