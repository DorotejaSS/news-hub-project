<?php
require('../db.php');

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

	// taking * from table sources and nesting it in the sources array() as objects
	public function getAll()
	{
		global $conn;
		$query = 'select * from sources';
		$res = $conn->query($query);
		$sources = [];
		while ($channels = $res->fetch_object()){
			$sources[] = $channels;
		}
		return $sources;
	}

	// grabbing the urls by $ids from $_SESSION['selected_channel_ids']
	// and nesting it into the $urls[] , then returnig it to updateChannels
	public function getUrlsById($ids)
	{
		$ids_str = implode(',', $ids);
		$query = 'select url from sources where id in ('.$ids_str.')';

		global $conn;
		$res = $conn->query($query);
		$urls = [];
		while($url = $res->fetch_object()){
			$urls[] = $url;
		}
		return $urls;
	}
}