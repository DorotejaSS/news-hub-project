<?php $news = $_SESSION['fetched_news']; ?>

			<main>
				<header>
					<?php foreach ($news as $key => $value): ?>
						<h1><?= $value['title']; ?></h1>
						<p><?= $value['description']; ?></p>
						<span><?= $value['updated']; ?></span>
						<img src="<?= $value['image']; ?>">
						<?php foreach ($value['articles'] as $article): ?>	
				</header>
				<hr>
				<div class="articles">
					<article>
						<a href="<?php echo $article['link'];?>"><h3><?= $article['title']; ?></h3></a>
						<p><?= $article['description']; ?></p>
						<span><?= $article['pubdate'];?></span>
					</article>
				</div>
						<?php endforeach ?>
						
					<?php endforeach ?>
					
			</main>
	