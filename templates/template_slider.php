<?php 
	/* Template Name: Slider */
?>

<?php get_header(); ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/slider.css">
<section id="main-content">


<div id="slider" class="sixteen columns">
	<a href="#" class="prev" title="View the previous site">Prev</a>
	<a href="#" class="next" title="View the next site">Next</a>
	<div class="crossfade">
		<div class="item"><h1>Content Slider One</h1></div>	
		<div class="item"><h1>Content Slider Two</h1></div>	
		<div class="item"><h1>Content Slider Three</h1></div>	
	</div>


	<div class="clear"></div>
	<ul class="slide-nav">
		<li><a href="#" title="" class="selected" rel="0">One</a></li>
		<li><a href="#" title="" rel="1">Two</a></li>
		<li><a href="#" title="" rel="2">Three</a></li>
	</ul>

</div>

</section>

</div><!-- END Main -->

<?php get_footer(); ?>