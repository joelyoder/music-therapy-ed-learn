<?php

get_header();

$description = get_field( 'description' );
$instructions = get_field ( 'instructions' );
$resources = get_field ( 'resources' );

?>

<div id="main-content">
	<a href="http://localhost/mte-learn/project-campfire"><i class="fas fa-fire-alt"></i> Project Campfire</a>

	<h1><?php echo get_the_title( $post_id ); ?></h1>
	<p><?php echo $description ?></p>

	<h2>Domain</h2>
	<?php
	$domain_attrs = get_the_terms( $post->ID, 'domain' );
	if (!empty($domain_attrs)){ ?>
		<ul class="meta">
			<?php 
			foreach($domain_attrs as $attr){
			echo '<li>' . $attr->name . '</li>';
			}    
			?>
		</ul>
	<?php } ?>
	<h2>Methods</h2>
	<?php
	$method_attrs = get_the_terms( $post->ID, 'method' );
	if (!empty($method_attrs)){ ?>
		<ul class="meta">
			<?php 
			foreach($method_attrs as $attr){
			echo '<li>' . $attr->name . '</li>';
			}    
			?>
		</ul>
	<?php } ?>
	<h2>Populations</h2>
	<?php
	$population_attrs = get_the_terms( $post->ID, 'population' );
	if (!empty($population_attrs)){ ?>
		<ul class="meta">
			<?php 
			foreach($population_attrs as $attr){
			echo '<li>' . $attr->name . '</li>';
			}    
			?>
		</ul>
	<?php } ?>
	<h2>Equipment</h2>
	<?php
	$equipment_attrs = get_the_terms( $post->ID, 'equipment' );
	if (!empty($equipment_attrs)){ ?>
		<ul class="meta">
			<?php 
			foreach($equipment_attrs as $attr){
			echo '<li>' . $attr->name . '</li>';
			}    
			?>
		</ul>
	<?php } ?>
	<h2>Instructions</h2>
	<p><?php echo $instructions ?></p>

	<h2>Resources</h2>
	<p><?php echo $resources ?></p>
</div> <!-- #main-content -->

<?php

get_footer();
