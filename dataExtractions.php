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
		$html = file_get_html($uri);

		foreach($html->find('strong.votes') as $element){
			$number_of_ratings = $element;
			$num = strip_tags($number_of_ratings);
		}
		foreach($html->find('span.average') as $element){ 
			$ave =  strip_tags($element);
			$aveee = $ave;
		}
		foreach($html->find('span#csReviewCount') as $element){
			$num_rev = strip_tags($element);
			$numb = $num_rev;
		}
		foreach($html->find('p.description') as $element){
			$r  = $element->plaintext."|"."<br/>";
			$ar = array("'");
			$r2 = str_replace($ar, "", $r);
			
		}	
	break;
	
	case 'InsiderPages':
		
		# URL example http://www.insiderpages.com/b/15240030746/athar-restaurant-elmhurst
		$uri = $_GET['url'];
		$html = file_get_html($uri);

		foreach($html->find('span.count') as $element){
			$number_of_reviews = $element;
			echo $number_of_reviews;
		}
		foreach($html->find('abbr.average') as $element){
			$average_ratings = $element;
			echo strlen($average_ratings);
		}
		foreach($html->find('p.description') as $element){
			$reviews = $element;
			echo $reviews;
		}
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