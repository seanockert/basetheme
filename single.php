<?php get_header(); ?>

<section id="main-content">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		<header>
			<h1><?php the_title(); ?></h1>
			<p class="small">
				<time datetime="<?php the_time('Y-m-d')?>">Posted <?php the_time('F jS, Y') ?></time>
				<span class="author">by <?php the_author() ?></span>.
				<?php if ( comments_open() ) : ?><a class="comment" href="<?php the_permalink(); ?>#comments"><?php comments_number('0 Comments', '1 Comment', '% Comments'); ?></a><?php endif; ?>
			</p>
		</header>

		<?php the_content(''); ?>

		<div class="social clearfix">
			<a href="http://twitter.com/share" class="socialite twitter" data-text="Check out <?php echo $post->post_title ?> on Hey Siri" data-url="<?php the_permalink(); ?>" data-count="horizontal" data-via="_heysiri" rel="nofollow" target="_blank"><span>Tweet</span></a>

			<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" class="socialite facebook" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="60" data-show-faces="false" rel="nofollow" target="_blank"><span>Like</span></a>

			<a href="https://plusone.google.com/_/+1/confirm?hl=en&amp;url=<?php the_permalink(); ?>" class="socialite googleplus" data-size="medium" data-href="<?php the_permalink(); ?>" rel="nofollow" target="_blank"><span>Plus+</span></a>

		</div>

		<footer class="small">
			<span class="category">Posted in <?php if (function_exists('parentless_categories')) parentless_categories(','); else the_category( ', ', 'multiple' ); ?></span>
			<?php the_tags('<span class="tags">Tagged as ', ', ', '</span>'); ?>
		</footer>
	</article>

	<?php comments_template(); ?>

<?php endwhile; endif; ?>

</section>

</div><!-- END Main -->
<?php get_sidebar_blog(); ?>

<?php get_footer(); ?>