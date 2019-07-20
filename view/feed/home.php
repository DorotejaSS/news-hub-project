		<!-- building a construction with data from $this->data['selected_news'] -->
		

		<?php $news = $this->data['selected_news']; ?>
		<?php $offset = isset($_GET['offset']) ? $_GET['offset'] : 0; ?>
		<?php $post_num = isset($_GET['post_num']) ? $_GET['post_num'] : 1; ?>

			<?php foreach (array_slice($news, $offset, 1) as  $value): ?>
					
				<div id="main">
					<main>
						<header>
							<h1><?= $value['title']; ?></h1>
							<p><?= $value['description']; ?></p>
							<span><?= $value['updated']; ?></span>
							<img src="<?= $value['image']; ?>">
						</header>
						<hr style="height: 5px; background-color: yellow;">

						<?php foreach ($value['articles'] as $article): ?>	

							<div class="articles">
								<article>
									<a href="<?php echo $article['link'];?>"><h3><?= $article['title']; ?></h3></a>
									<p><?= $article['description']; ?></p>
									<span><?= $article['pubdate'];?></span>
								</article>
								<br>
								<hr>
							</div>

						<?php endforeach ?>
										
					</main>
				</div>

			<?php endforeach ?>
	