<?php

class FeedController
{	
	public function __construct()
	{

	}
	// reaching the model , returning data and calling the View
	public function getChannels()
	{
		$channel = new Channel();
		$channels = $channel->index();

		$view = new View();
		$view->data['channels'] = $channels;
		$view->data['title'] = 'Homepage';
		var_dump($view->data);
		$view->loadPage('feed', 'index');
	}

	// writting the id-s into the $_SESSION and calling the Model 
	// who returns the urls of the channels with the forwarded id-s
	// calling the method fetchNewsByUrl(with $argument which holds the urls)
	public function updateChannels()
	{
		$_SESSION['selected_channel_ids'] = $_GET['channel'];
		$channel = new Channel();
		$channel_urls = $channel->getUrlsById($_SESSION['selected_channel_ids']);
		$fetched_news = $this->fetchNewsByUrl($channel_urls);
		
	}

	// preparing the urls for sending to the server
	private function fetchNewsByUrl($urls)
	{	
		$fetched_news = [];

		foreach ($urls as $url) {
			
			$ch = curl_init();

			// set URL and other appropriate options
			curl_setopt($ch, CURLOPT_URL, $url->url);	 // pandam open metodi u js
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);	// ignorise httpS
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		// ono sto nadjes, 
																// ne ehuj nego vrati u promenljivu


			// grab URL and pass it to the browser
			$result = curl_exec($ch);

			// close cURL resource, and free up system resources
			curl_close($ch);

			$xml = new SimpleXMLElement($result);
			// if (isset($_REQUEST['format']) && $_REQUEST['format'] === 'xml'){
			// 	header('Content-type: application/rss+xml');
			// 	echo $xml->asXML();
			// }

			$xml = $xml->channel;
			
			$output = array(
				'title' => $xml->title->__toString(),
				'description' => $xml->description->__toString(),
				'image' =>  $xml->image->url->__toString(),
				'updated' => $xml->pubDate->__toString(),
				'articles' => array()
			);
			
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
			array_push($fetched_news, $output);
		}
		return $fetched_news;
	}
		

	public function homePage()
	{
		$channel = new Channel();
		$channels = $channel->index();

		$view = new View();
		$view->data['channels'] = $channels;
		$view->data['title'] = 'Homepage';
		$view->loadPage('feed', 'home');
		var_dump($_GET);
		// find the channels with id from $_GET['channel'] 
		// and bring the url with the same id from database 
	}	
}