<?php

class FeedController
{	
	public function __construct()
	{}

	// reaching the model , returning 'id' and 'title' 
	// writing the returned values in data property['channels']
	// and calling the View
	public function getChannels()
	{
		$channel = new Channel();
		$channels = $channel->index();

		$view = new View();
		$view->data['channels'] = $channels;
		$view->data['title'] = 'Homepage';

		$view->loadPage('feed', 'index');
	}

	// writting the id-s from $_GET into the $_SESSION['selected_channel_ids'] and calling the Model 
	// who returns the urls of the channels with the forwarded id-s
	// writting channel urls into the $_SESSION	
	// calling the method fetchNewsByUrl(with $argument which holds the urls)	
	public function updateChannels()
	{	
		$_SESSION['selected_channel_ids'] = $_GET['channel'];
		$channel = new Channel();
		$channel_urls = $channel->getUrlsById($_SESSION['selected_channel_ids']);

		$_SESSION['selected_channel_urls'] = $channel_urls;
		
		$fetched_news = $this->fetchNewsByUrl($channel_urls);
		$display_selected = $this->displaySelected();
	}

	// preparing the urls for sending to the server
	// this method returns array fetched_news
	private function fetchNewsByUrl($urls)
	{	
		$fetched_news = [];

		foreach ($urls as $url) {
			
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, $url->url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);	
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			// grab URL and pass it to the browser
			$result = curl_exec($ch);

			// close cURL resource, and free up system resources
			curl_close($ch);

			$xml = new SimpleXMLElement($result);
			$xml = $xml->channel;

			if(!$xml->image->url){
				$image = 'https://villagevoice.freetls.fastly.net/wp-content/uploads/2012/03/hp_twitter_avatar_128x128.png';
			} else {
				$image = $xml->image->url->__toString();
			}

			if (strpos($xml->image->url, 'gif')){
				$image = 'http://i2.cdn.turner.com/cnn/2015/images/09/24/cnn.digital.png';
			}
			
			$output = array(
				'title' => $xml->title->__toString(),
				'description' => $xml->description->__toString(),
				'image' =>  $image,
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

	// fetch news by url, writting in into property of $view data['selected_news'] 
	// and displaying it on home	
	public function displaySelected()
	{
		$channel = new Channel();
		$channels = $channel->index();

		$view = new View();
		$view->data['channels'] = $channels;
		$view->data['title'] = 'Homepage';

		$channel_urls = $_SESSION['selected_channel_urls'];
		
		$view->data['selected_news'] = $this->fetchNewsByUrl($channel_urls);
		$view->loadPage('feed', 'home');
	}
}