<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="robots" content="noindex, nofollow">
</head>
<body <?php body_class() ?>>

	<div id="wrapper">
		<main>
			<section>

				<?php if (have_posts()): while (have_posts()) : the_post(); ?>

					<!-- article -->
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<!-- post thumbnail -->
						<?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<?php the_post_thumbnail(); ?>
							</a>
						<?php endif; ?>
						<!-- /post thumbnail -->

						<!-- post title -->
						<h2>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h2>
						<!-- /post title -->
						
						<!-- post content -->
						<?php the_content(); ?>

						<!-- post details -->
						<span class="date">
							<time datetime="<?php the_time('Y-m-d'); ?> <?php the_time('H:i'); ?>">
								<?php the_date(); ?> <?php the_time(); ?>
							</time>
						</span>
						<span class="author">Published by: <?php the_author_posts_link(); ?></span>
						<!-- /post details -->

						<?php edit_post_link(); ?>

					</article>
					<!-- /article -->

				<?php endwhile; ?>

				<?php else: ?>

					<!-- article -->
					<article>
						<h2>Sorry, nothing to display.</h2>
					</article>
					<!-- /article -->

				<?php endif; ?>

				<?php posts_nav_link(); ?>

			</section>
		</main>
	</div> <!-- /#wrapper -->
</body>
</html>