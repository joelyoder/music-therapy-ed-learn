<?php

get_header();

$description = get_field( 'description' );
$instructions = get_field( 'instructions');
$resources = get_field( 'resources' );
$video = get_field( 'video' );

$domain_attrs = get_the_terms( $post->ID, 'domain' );
if (!empty($domain_attrs)){
	foreach($domain_attrs as $attr){
	$domain = $attr->slug;
	}
}

?>

<div id="main-content">
	<div class="intervention-grid-container">
		<div class="intervention-subnav">
			<a href="/project-campfire" class="intervention-mobile-nav"><i class="far fa-chevron-left"></i>&nbsp;&nbsp;<strong>Project</strong> Campfire</a>
		</div><!-- .intervention-subnav -->
		<div class="intervention-header">
			<?php
			if ( !empty($domain)) :
				switch ($domain) :
					case "cognitive":
						echo '<img src="https://learn.musictherapyed.com/wp-content/uploads/2019/11/Cognitive-Intervention-Cover.png" alt="" />';
						break;
					case "communicative":
						echo '<img src="https://learn.musictherapyed.com/wp-content/uploads/2019/11/Communication-Intervention-Cover.png" alt="" />';
						break;
					case "emotional":
						echo '<img src="https://learn.musictherapyed.com/wp-content/uploads/2019/11/Emotional-Intervention-Cover.png" alt="" />';
						break;
					case "musical":
						echo '<img src="https://learn.musictherapyed.com/wp-content/uploads/2019/11/Musical-Intervention-Cover.png" alt="" />';
						break;
					case "psychosocial":
						echo '<img src="https://learn.musictherapyed.com/wp-content/uploads/2019/11/Pscyhosocial-Intervention-Cover.png" alt="" />';
						break;
					case "sensorimotor":
						echo '<img src="https://learn.musictherapyed.com/wp-content/uploads/2019/11/Sensorimotor-Intervention-Cover.png" alt="" />';
						break;
					case "spiritual":
						echo '<img src="https://learn.musictherapyed.com/wp-content/uploads/2019/11/Spiritual-Intervention-Cover.png" alt="" />';
						break;
				endswitch;
			endif; ?>
			<h1><?php echo get_the_title( $post_id ); ?></h1>
			<p><?php echo $description ?></p>
		</div><!-- .intervention-header -->
		<div class="intervention-sidebar">
			<a href="/project-campfire" class="intervention-sidebar-nav"><i class="fas fa-fire-alt"></i>&nbsp;&nbsp;<strong>Project</strong> Campfire</a>
			<h2>Domain</h2>
			<?php
			if (!empty($domain_attrs)) : ?>
				<ul class="meta">
					<?php 
					foreach($domain_attrs as $attr){
					echo '<li>' . $attr->name . '</li>';
					}    
					?>
				</ul>
			<?php endif; ?>
			<h2>Methods</h2>
			<?php
			$method_attrs = get_the_terms( $post->ID, 'method' );
			if (!empty($method_attrs)) : ?>
				<ul class="meta">
					<?php 
					foreach($method_attrs as $attr){
					echo '<li>' . $attr->name . '</li>';
					}    
					?>
				</ul>
			<?php endif; ?>
			<h2>Populations</h2>
			<?php
			$population_attrs = get_the_terms( $post->ID, 'population' );
			if (!empty($population_attrs)) : ?>
				<ul class="meta">
					<?php 
					foreach($population_attrs as $attr){
					echo '<li>' . $attr->name . '</li>';
					}    
					?>
				</ul>
			<?php endif; ?>
			<h2>Equipment</h2>
			<?php
			$equipment_attrs = get_the_terms( $post->ID, 'equipment' );
			if (!empty($equipment_attrs)) : ?>
				<ul class="meta">
					<?php 
					foreach($equipment_attrs as $attr){
					echo '<li>' . $attr->name . '</li>';
					}    
					?>
				</ul>
			<?php endif; ?>
			<?php if(get_field('button_visibility')) : ?>
				<a class="button navy" href="<?php the_field('button_url') ?>" <?php echo get_field('button_new_tab') ? 'target="_blank" rel="noopener"' : ''; ?>><?php the_field('button_text') ?></a>
			<?php endif; ?>
		</div><!-- .intervention-sidebar -->
		<div class="intervention-content">
			<h2>Instructions</h2>
			<?php echo $instructions ?>

			<h2>Resources</h2>
			<?php echo $resources ?>
			<?php if( get_field('video') ) : ?>
				<br >
				<div class="embed-container">
					<?php echo $video ?>
				</div><!-- .embed-container -->
			<?php endif; ?>
		</div><!-- .intervention-content -->
	</div><!-- .intervention-grid-container -->
</div> <!-- #main-content -->

<?php

get_footer();
