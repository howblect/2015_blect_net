<?php
if ( ! isset( $module_query_args ) ) return;
$the_query = new WP_query( $module_query_args );
if ( $the_query->have_posts() ) : 
	$counter = 0;
?>
	<div class="module">
		<?php  
		if ( isset( $module_query_args['fw_heading']['title'] ) )
		{	
			$module_title = $module_query_args['fw_heading']['title'];
			if ( isset( $module_query_args['fw_heading']['link'] ) ) 
			{
				$module_title = '<a href="' . $module_query_args['fw_heading']['link'] . '">' . $module_title . '<i class="skin-icon skin-icon-plus"></i></a>';
			}
			echo 	'<div class="module-heading">' . '<h3 class="module-title">' . $module_title . '</h3>' . '</div>';
		}
		?>
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 
			/**
			 * Exclude these post in home page listing
			 */
			if ( ! in_array( $post->ID, $post_to_exclude ) ) $post_to_exclude[] = $post->ID;
			$counter++;
		?>
		<div <?php post_class( 'media' ); ?>>
			<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
			<a class="entry-thumbnail <?php echo ( $counter == 1 ) ? 'entry-thumbnail-medium media-top' : 'entry-thumbnail-thumbnail media-left' ?>" href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'medium' ); ?>
			</a>
			<?php endif; ?>
			<div class="media-body">
				<h3 class="media-heading entry-title <?php echo ( $counter == 1 ) ? 'title-md' : 'title-sm' ?>"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
				<span class="entry-meta"><?php $helper->t_entry_date(); ?></span>
			</div>
		</div>
		<?php endwhile; ?>
	</div>
	<?php wp_reset_postdata(); ?>
<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.', FW_TEXTDOMAIN ); ?></p>
<?php endif; 

/**
 * Cleanup query array for the next user.
 */
unset( $module_args );