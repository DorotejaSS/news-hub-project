<?php 

$news_channel_urls = array(
	'www.google.com',
	'www.111.com',
	'www.kurir.com'
);

$news_channel_url = $_REQUEST['url'];
$news_channel_url = 'http://blic.rs';
// var_dump($_REQUEST);

// create a new cURL resource

// upucujemo GET poziv na udaljeni url i raspakujemo odgovor
$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, $news_channel_url);	 // pandam open metodi u js
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);	// ignorise httpS
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		//ono sto nadjes, ne ehuj nego vrati u promenljivu


// grab URL and pass it to the browser
$result = curl_exec($ch);

// close cURL resource, and free up system resources
curl_close($ch);

$xml = new SimpleXMLElement($result);
if (isset($_REQUEST['format']) && $_REQUEST['format'] === 'xml'){
	header('Content-type: application/xml');
	echo $xml->asXML();
}

$xml = $xml->channel;
// var_dump($xml);

$output = array(
	'title' => $xml->title->__toString(),
	'description' => $xml->description->__toString(), 		//adaptiranje sadrzaja u niz koji nama odgovara
	'image' =>  $xml->image->url->__toString(),
	'updated' => $xml->pubDate->__toString(),
	'articles' => array()
);

var_dump($output['image']);

// var_dump($output);

foreach ($xml->children() as $key => $node) {
	if ($key === 'item') {
		$output['articles'][] = array(
			'title' => $node->title->__toString(),
			'description' => $node->description->__toString(),
			'link' => $node->link->__toString(),
			'pubdate' => $node->pubDate->__toString()
		);

	}
}
	var_dump($output);

echo json_encode($output);
