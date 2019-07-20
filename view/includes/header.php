<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie-edge">
		<title><?php echo $this->data['title']; ?></title>
		<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
		<script type="text/javascript" src="/assets/js/main.js"></script>
	</head>
	<body>
		<nav class="navbar">
			<span class="open-slide">
				<a href="#" onclick="openSlideMenu()">
					<svg width="30" height="30">
						<path d="M0,5 30,5" stroke="#fff" stroke-width="5"/>
						<path d="M0,14 30,14" stroke="#fff" stroke-width="5"/>
						<path d="M0,23 30,23" stroke="#fff" stroke-width="5"/>
					</svg>
				</a>
			</span>
			<div class="nav">
				<ul class="navbar-nav">

					<?php foreach ($this->data['channels'] as $channel): ?>
						<?php if (isset($_GET['channel']) && in_array($channel['id'], $_GET['channel'])) : ?>
							<li><a href="#" class="click"><?php echo strtoupper($channel['title']); ?></a></li>
						<?php endif; ?>
					<?php endforeach ?>
						
					<li id="logo"><a href="#"><img src="../../assets/images/logo2.png"></a></li>
				</ul>
			</div>

		</nav>
		<form action="/feed/update-channels" method="get">
			<div id="side-menu" class="side-nav">
				<a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
				<span>Choose the news you want to see</span>

					<?php foreach ($this->data['channels'] as $channel): ?>
						<p>
							<label>
								<input type="checkbox" name="channel[]" value="<?php echo $channel['id']; ?>"
								<?php echo (isset($_GET['channel']) && in_array($channel['id'], $_GET['channel'])) ? 'checked' : ''; ?>>
								<span><?php echo strtoupper($channel['title']); ?></span>
							</label>
						</p>
					<?php endforeach; ?>
					
				<input type="submit" name="filter" value="Submit">
			</div>
		</form>