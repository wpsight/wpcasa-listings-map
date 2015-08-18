<div class="wpsight-infobox" id="wpsight-infobox-<?php echo get_the_ID() ?>">
	<div class="infobox-image">
		<?php the_post_thumbnail() ?>
		<h3 class="infobox-title"><a class="infox-title-link" href="<?php echo get_permalink() ?>"><?php the_title() ?></a></h3>
	</div>
	<div class="infobox-content">
		<?php the_excerpt() ?>
	</div>
	<div class="infobox-footer">
		<p><a href="<?php echo get_permalink() ?>"><?php _e( 'View details', 'wpsight-listings-map' ) ?></a></p>
	</div>
</div>