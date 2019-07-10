<?php 

require_once('./db.php');

class Source
{	
	public function getTheNews()
	{
		global $conn;
		$query = 'select * from sources';
		$res = $conn->query($query);
		$sources = [];
		while ($news = $res->fetch_object()){
			$sources[] = $news;
		}
		// var_dump($sources);
		foreach ($sources as $index => $innerArray) {
			$innerArray = (array)$innerArray;
			$id[] = $innerArray['id'];
			$title[] = $innerArray['title'];
			$url[] = $innerArray['url'];

			$big_array = array(
				'id' => $id,
				'title' => $title,
				'url' => $url
			);
		}
		var_dump($big_array);
		return $big_array;
	}
}

