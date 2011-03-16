<?php
	function getTags($items){
		$tagslist = array(
			'money' => array('make money', 'making money'),
			'web' => array('make money web'),
			'ads' => array('make money with ads'),
			'guaranteed' => array('make money guaranteed'),
			'young' => array('make money young'),
			'opportunities' => array('opportunities money'),
			'writing' => array('make money writing'),
			'blog' => array('money online blog'),
			'program' => array('money making program'),
			//'adsense' => array('make money with google adsense', 'make money with adsense'),
			'teenager' => array('ways to make money as a teenager'),
			'mail' => array('make money mail'),
			'easier' => array('easier way to make money'),
			'instantly' => array('earn money online instantly'),
			'blogging' => array('make money blogging'),
			'earn' => array('earn online','earn money'),
			'affiliate' => array('affiliate make money'),
			'twitter' => array('make money with twitter',),
			'techniques' => array('money making techniques'),
			'envelopes' => array('make money stuffing envelopes'),
			'internet' => array('make money internet'),
			'jobs' => array('internet jobs'),
			'business' => array('business make money online','make money business'),
			'marketing' => array('make money marketing'),
			'residual' => array('residual income'),
			'legit' => array('legit make money online ways', 'legit way to make money online', 'legit ways to make money online'),
			'great' => array('make great money online'),
			'boards' => array('money making message boards'),
			'package' => array('making money package'),
			'secrets' => array('money making secrets'),
			'advertising' => array('make money advertising'),
			'software' => array('money making software'),
			'schemes' => array('money making schemes'),
			'actually' => array('actually make money online'),
			'forums' => array('money making forums'),
			'millions' => array('make millions', 'make money millions'),
			'surveys' => array('make money taking surveys', 'paid surveys', 'make money surveys', 'make money online surveys'),
			'online' => array('easy make money onlines'),
			'system' => array('money making system', 'online money making system'),
			'articles' => array('make money online articles'),
			'investing' => array('how to make money online without investing'),
			'learn' => array('learn how to make money', 'learn to make money online', 'learn how to make money online', 'learn to make money'),
			'stuffing' => array('make money stuffing envelopes'),
			'investment' => array('make money online no investment', 'make money online without investment'),
			'income' => array('earn income online', 'earn income', 'extra income from home', 'residual income', 'make extra income', 'earn extra income', 'extra income'),
			'opportunity' => array('home business opportunity'),
			'youtube' => array('make money youtube', 'youtube downloader'),
			'website' => array('ways make money websites',),
		);
		$tagarray = array();
		for($k = 0, $l = count($items); $k < $l; ++$k){
			$long = trim($items[$k]);
			if(array_key_exists($long, $tagslist)){
				$tagarray =  array_merge($tagarray, $tagslist[$long]);
			}
		}
		return $tagarray;
	}
	
?>