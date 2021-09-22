<?php

get_header();

// Set type of intervention
$type = get_field( 'type' );

// Pull in the population attributes used to style the page
if ( $population_attrs = get_the_terms( $post->ID, 'population' ) ) {

	// Grab the last name & ID and format the ID for ACF
	foreach( $population_attrs as $attr ){
        $population = $attr->name;
		$population_id = $attr->term_id;
		$population_tax_id = 'population_' . $population_id;
	}

	// Pull in the population-specific design elements
	if ( !empty( $population_tax_id ) ) {
		$population_image = get_field( 'image', $population_tax_id );
		$population_color = get_field( 'color', $population_tax_id );
	}
}

?>

<div id="main-content">

	<div class="intervention-grid-container">

		<div class="intervention-subnav">
			<a href="/project-campfire" class="intervention-mobile-nav"><i class="far fa-chevron-left"></i>&nbsp;&nbsp;<strong>Project</strong> Campfire</a>
		</div><!-- .intervention-subnav -->

		<div class="content-shadow">
			<!-- Funky workaround to have shadow behind multiple grid elements without overlap -->
		</div>

		<div class="intervention-header">

			<?php
			// Set the image to the population unless it's a Jam Along
			if ( $population_image && $type != 'jam-along' ) :
				echo wp_get_attachment_image( $population_image, 'large' );
			// Set the image to Jam Along
			elseif ( $type == 'jam-along' ) :
				$jam_along_image = get_field( 'jam_along_image', 'option' );
				echo wp_get_attachment_image( $jam_along_image, 'large' );
			// Otherwise just use the default image from the theme settings
			else :
				$default_procamp_image = get_field( 'default_procamp_image', 'option' );
				echo wp_get_attachment_image( $default_procamp_image, 'large' );
			endif;
			?>

			<h1><?php echo get_the_title( $post_id ); ?></h1>

			<?php echo ( $description = get_field( 'description' ) ) ? '<p>' . $description . '</p>' : '' ; ?>

		</div><!-- .intervention-header -->

		<div class="intervention-sidebar">

			<div class="sticky-container">
				
				<a href="/project-campfire" class="intervention-sidebar-nav"><i class="fas fa-fire-alt"></i>&nbsp;&nbsp;<strong>Project</strong> Campfire</a>
				
				<?php if ( $population_attrs = get_the_terms( $post->ID, 'population' ) ) : ?>
					<h2>Population</h2>
					<ul class="meta">
						<li><?php echo $population; ?></li>
					</ul>
				<?php endif; ?>

				<?php if ( $domain_attrs = get_the_terms( $post->ID, 'domain' ) ) : ?>
					<h2>Domains</h2>
					<ul class="meta">
						<?php 
						foreach( $domain_attrs as $attr ){
						echo '<li>' . $attr->name . '</li>';
						}    
						?>
					</ul>
				<?php endif; ?>

				<?php if ( $method_attrs = get_the_terms( $post->ID, 'method' ) ) : ?>
					<h2>Methods</h2>
					<ul class="meta">
						<?php 
						foreach( $method_attrs as $attr ){
						echo '<li>' . $attr->name . '</li>';
						}    
						?>
					</ul>
				<?php endif; ?>

				<?php if ( $equipment_attrs = get_the_terms( $post->ID, 'equipment' ) ) : ?>
					<h2>Equipment</h2>
					<ul class="meta">
						<?php 
						foreach( $equipment_attrs as $attr ){
						echo '<li>' . $attr->name . '</li>';
						}    
						?>
					</ul>
				<?php endif; ?>

				<?php if( get_field( 'button_visibility' ) ) : ?>
					<a class="button navy" href="<?php the_field( 'button_url' ); ?>" target="_blank" rel="noopener"><?php the_field( 'button_text' ); ?></a>
				<?php endif; ?>

			</div>

		</div><!-- .intervention-sidebar -->

		<div class="intervention-content">

			<?php if( $instructions = get_field( 'instructions' ) ) : ?>
				<h2>Instructions</h2>
				<?php echo $instructions ?>
			<?php endif; ?>

			<?php
			// Declare these now for cleaner if checks
			$resources = get_field( 'resources' );
			$video = get_field( 'video' );
			?>


			<?php if( $resources || $video || have_rows('video_repeater') ) : ?>
				<h2>Resources</h2>
				<?php echo $resources ?>
				
				<?php if( have_rows('video_repeater') ) : // Check rows exists ?>
					<?php while( have_rows('video_repeater') ) : the_row(); ?>
						<?php $video_embed = get_sub_field('video_embed'); ?>
						<br />
						<div class="embed-container">
							<?php echo $video_embed ?>
						</div><!-- .embed-container -->
					<?php endwhile; ?>
				<?php endif; ?>

				<?php if( $video ) : ?>
					<br />
					<div class="embed-container">
						<?php echo $video ?>
					</div><!-- .embed-container -->
				<?php endif; ?>

			<?php endif; ?>

		</div><!-- .intervention-content -->
	</div><!-- .intervention-grid-container -->
</div> <!-- #main-content -->

<?php

get_footer();
