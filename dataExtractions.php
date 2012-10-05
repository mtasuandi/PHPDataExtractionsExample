<?php
# Get Data Extraction from Yp.com, CitySearch.com and InsiderPages.com using Simple HTML DOM.
# @Author  : M Teguh A Suandi
# @Website : http://mtasuandi.wordpress.com

require_once('simple_html_dom.php');

switch($_GET['Action']){
	
	case 'YellowPages':
	
		#URL example http://www.yellowpages.com/denver-co/mip/japon-restaurant-21955055?lid=21955055
		$uri = $_GET['url'];
		$html = file_get_html($uri);

		foreach($html->find('a.url') as $element){
			$url = $element->href;
		}
		foreach($html->find('span#average-rating-count') as $element){
			$number_of_ratings = $element;
			$num = preg_replace("/[^0-9]/", '', $number_of_ratings);
		}
		foreach($html->find('div.average-rating') as $element){ 
			$ave =  strip_tags($element);
		}
		$av = substr($ave, 0, 4);
		$avee = explode(" ",$av);
		$aveee = $avee[1];
		foreach($html->find('a.count') as $element){
			$num_rev = strip_tags($element);
			$numb = preg_replace("/[^0-9]/", '', $num_rev);
		}
		foreach($html->find('li#review-1') as $element){
			$rev = $element;
			$rev1 = GetBetween($rev,'<p class="review-text truncated">','</p>');
			$revi1 = str_replace("'", "", $rev1);
			$review1 = strip_tags($revi1);
		}
		foreach($html->find('li#review-2') as $element){
			$rev = $element;
			$rev2 = GetBetween($rev,'<p class="review-text truncated">','</p>');
			$revi2 = str_replace("'", "", $rev2);
			$review2 = strip_tags($revi2);
		}
		foreach($html->find('li#review-3') as $element){
			$rev = $element;
			$rev3 = GetBetween($rev,'<p class="review-text truncated">','</p>');
			$revi3 = str_replace("'", "", $rev3);
			$review3 = strip_tags($revi3);
		}
		foreach($html->find('li#review-4') as $element){
			$rev = $element;
			$rev4 = GetBetween($rev,'<p class="review-text truncated">','</p>');
			$revi4 = str_replace("'", "", $rev4);
			$review4 = strip_tags($revi4);
		}
		foreach($html->find('li#review-5') as $element){
			$rev = $element;
			$rev5 = GetBetween($rev,'<p class="review-text truncated">','</p>');
			$revi5 = str_replace("'", "", $rev5);
			$review5 = strip_tags($revi5);
		}

	break;
	
	case 'CitySearch':
	
		# URL example http://denver.citysearch.com/profile/1782729/arvada_co/namiko_s.html
		$uri = $_GET['url'];
		$content = file_get_contents($uri);
		$content = str_replace("review.description.","reviewdescription",$content);
		
		$html = new simple_html_dom();
		$html->load($content);
		$url = $uri;
		
		foreach($html->find('strong.votes') as $element){
		    $number_of_ratings = $element;
			$num = strip_tags($number_of_ratings);
			
		}
		foreach($html->find('span.average') as $element){ 
		    $ave =  strip_tags($element);
			$average = $ave;
			$av = $num * ($average/100);
		}
		foreach($html->find('span#csReviewCount') as $element){
		    $num_rev = strip_tags($element);
			$numb = $num_rev;
		}
		foreach($html->find('p#reviewdescription1') as $element){
			$review1  = $element->plaintext;
			$rev1 = str_replace("'","",$review1);
		}
		foreach($html->find('p#reviewdescription2') as $element){
			$review2  = $element->plaintext;
			$rev2 = str_replace("'","",$review2);
		}
		foreach($html->find('p#reviewdescription3') as $element){
			$review3  = $element->plaintext;
			$rev3 = str_replace("'","",$review3);
		}
		foreach($html->find('p#reviewdescription4') as $element){
			$review4  = $element->plaintext;
			$rev4 = str_replace("'","",$review4);
		}
		foreach($html->find('p#reviewdescription5') as $element){
			$review5  = $element->plaintext;
			$rev5 = str_replace("'","",$review5);
		}
	break;
	
	case 'InsiderPages':
		
		# URL example http://www.insiderpages.com/b/15240030746/athar-restaurant-elmhurst
		$uri = $_GET['url'];
		$html = file_get_html($uri);
		$url = $uri;
		
		foreach($html->find('span.count') as $element){
		    $number_of_reviews = $element->plaintext;
		}
		foreach($html->find('div.rating_box') as $element){
		    $average_ratings = GetBetween($element, 'title="', '">');
		}
		$reviews = array();
		foreach($html->find('p.description') as $element){
		    $reviews[] = $element->plaintext;
		}
		
		$rev1 = "";
		if(count($reviews) >0) $rev1 = str_replace("'","",$reviews[0]);
		
		$rev2 = "";
		if(count($reviews) >1) $rev2 = str_replace("'","",$reviews[1]);
		
		$rev3 = "";
		if(count($reviews) >2) $rev3 = str_replace("'","",$reviews[2]);
		
		$rev4 = "";
		if(count($reviews) >3) $rev4 = str_replace("'","",$reviews[3]);
		
		$rev5 = "";
		if(count($reviews) >4) $rev5 = str_replace("'","",$reviews[4]);

	break;
	
	case 'Yelp':
		$uri = $_GET['url'];
		$url = $uri;
		$html = file_get_html($uri);
		
		foreach($html->find('span.review-count') as $element){
		    $number_of_reviews = $element;
			$num = preg_replace("/[^0-9]/", '', $number_of_reviews);
			
		}
		foreach($html->find('div#bizRating') as $element){ 
		    $ave =  GetBetween($element,'<meta itemprop="ratingValue" content="','.0">');
		}
		
		foreach($html->find('p.review_comment') as $element){
			$reviews[] = $element->plaintext;
		}
		
		$rev1 = "";
		if(count($reviews) >0) $rev1 = str_replace("'","",$reviews[0]);
		
		$rev2 = "";
		if(count($reviews) >1) $rev2 = str_replace("'","",$reviews[1]);
		
		$rev3 = "";
		if(count($reviews) >2) $rev3 = str_replace("'","",$reviews[2]);
		
		$rev4 = "";
		if(count($reviews) >3) $rev4 = str_replace("'","",$reviews[3]);
		
		$rev5 = "";
		if(count($reviews) >4) $rev5 = str_replace("'","",$reviews[4]);	
	break;
	
	case 'GooglePlaces':
		$uri = $_GET['url'];
		$url = $uri;
		$html = file_get_html($uri);
		
		foreach($html->find('span.qja') as $element){
		    $number_of_reviews = $element;
			$num = preg_replace("/[^0-9]/", '', $number_of_reviews);	
		}
		
		foreach($html->find('span.ix') as $element){ 
			$num_rate[] = $element; //GetBetween($element,'<span class="Vy">OVERALL','</span>');
		}
		$num_r = "";
		if(count($num_rate) > 0) $num_r = $num_rate[0];
		
		foreach($html->find('span.aza') as $element){
			$reviews[] = $element->plaintext;
		}
		
		$rev1 = "";
		if(count($reviews) >0) $rev1 = str_replace("'","",$reviews[0]);
		
		$rev2 = "";
		if(count($reviews) >1) $rev2 = str_replace("'","",$reviews[1]);
		
		$rev3 = "";
		if(count($reviews) >2) $rev3 = str_replace("'","",$reviews[2]);
		
		$rev4 = "";
		if(count($reviews) >3) $rev4 = str_replace("'","",$reviews[3]);
		
		$rev5 = "";
		if(count($reviews) >4) $rev5 = str_replace("'","",$reviews[4]);
	break;
}
function GetBetween($content,$start,$end){
	$r = explode($start, $content);
	if (isset($r[1])){
		$r = explode($end, $r[1]);
		return $r[0];
	}
	return '';
}