<?php
// Defining constant
define("SITE_URL", "https://uk.rs-online.com/");

require 'simple_html_dom.php';

$maindom = @file_get_html('https://uk.rs-online.com/web/op/all-products/');


$ret = $maindom->find('div[class=productHierarchyDiv] ul li a'); 
echo "<pre>";


$output = fopen("data",'w') or die("Can't open php://output");
header("Content-Type:application/csv"); 
header("Content-Disposition:attachment;filename=data.csv"); 
fputcsv($output, array('id','name','description'));
$p = [];
foreach ($ret as $k1 => $value) {
	echo "Level 1 -><br> ";
	print_r($value->attr['href']);
	echo "<br>";
	$level2 = @file_get_html($value->attr['href']);

	if (!$level2) {
		continue;
	}
	$catlevel2 = $level2->find('td[class=brLeftTd] ul li a');
	
	echo "Level 2 -><br> ";
	 
	foreach ($catlevel2 as $k2 => $cat2Lvl2Val) {
		 
		print_r($cat2Lvl2Val->attr['href']);
		echo "<br>";
		
		echo "Level 3 -> <br>";
		$level3 = @file_get_html($cat2Lvl2Val->attr['href']);	

		if (!$level3) {
			continue;
		}	
		$productL1 = $level3->find('tr[class=resultRow] td figure a');
		echo "<br>";	
		$proCount1 = 0;
		foreach ($productL1 as $key => $proVaId) {
				// print_r($proVaId->find());
			 $proCount1++;
			echo "Level 4 -> <br>";
			$prohref = $proVaId->attr['href'];
			$prohref = SITE_URL.$prohref;

			$productPage = @file_get_html($prohref);

			if (!$productPage) {
				continue;
			}	

			$product = [];
			$product['name'] = $productPage;
			$product['name'] = $product['name']->find('h1[class=main-page-header]');
			$product['name'] = $product['name'][0]->innertext;
			// print_r('Name = '.$product['name']);

			$product['prodDetailsContainer'] = $productPage;
			$product['prodDetailsContainer'] = $product['prodDetailsContainer']->find('div[class=prodDetailsContainer]');
			if ($product['prodDetailsContainer'][0]) {
				$product['prodDetailsContainer'] = $product['prodDetailsContainer'][0]->innertext; 
			}else{
				$product['prodDetailsContainer'] = ' ';
			}
			// $product['mainImage'] = $product['mainImage'][0]->innertext; 
			// print_r('Image = '.$product['mainImage']);
 

			$product['price'] = $productPage->find('span[class=price]');
			$product['price'] = $product['price'][0]->innertext;    

    		fputcsv($output, $product);
			$p[] = $product;

		} 
		echo "<br>";	
	}
	echo "<br>";

		// die;/*to limit to 1 loop of level 2 of category page*/
	 
	// die;/*to limit to 1 loop of level 1*/
}
 
fclose($output) or die("Can't close php://output");

// print_r($product);
echo "</pre>";

?>
