<?php

require('./db.php');

class Channel
{	
	// calling the method getAll() and mapping the 'id' and 'title'
	public function index()
	{
		$all_channels = $this->getAll();
		return array_map(function($channel){
			return array(
				'id' => $channel->id,
				'title' => $channel->title
			);
		}, $all_channels);
	}

	// taking everything from sources and nesting it in sources array
	public function getAll()
	{
		global $conn;
		$query = 'select * from sources';
		$res = $conn->query($query);
		$sources = [];
		while ($news = $res->fetch_object()){
			$sources[] = $news;
		}

		return $sources;
	}

	// grabbing the urls by $ids from $_SESSION
	// and nesting it into the $url[] , then returnig it to updateChannels
	public function getUrlsById($ids)
	{
		$ids_str = implode(',', $ids);

		global $conn;
		$query = 'select url from sources where id in ('.$ids_str.')';
		$res = $conn->query($query);
		$urls = [];
		while($url = $res->fetch_object()){
			$urls[] = $url;
		}
		return $urls;
	}


}