<div class="posts">
	<?php if (isset($GLOBALS['single-post']) || isset($GLOBALS['search-result'])){ ?>
		<div class="blog-back-link">
			<a class="ease" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">Back</a>
		</div>
	<?php } ?>
	<?php if(isset($GLOBALS['search-result'])){
		$no_posts_message='';
		$results_term = 'results';
		if ($wp_query -> found_posts == 0){
			$no_posts_message=', so here are some recent posts instead';
		} elseif ($wp_query->found_posts == 1){
			$results_term='result';
		}
		?>
		<h1>You searched for <span><?php echo esc_html( get_search_query( false ) ); ?></span>. We found <?php echo $wp_query->found_posts; ?> <?php echo $results_term; ?><?php echo $no_posts_message; ?>.</h1>
	<?php } ?>
	<?php
	$no_posts=!have_posts();
	if( $no_posts ){
		$args=array(
			'post_type'=>'post',
			'post_status'=>'publish',
			'posts_per_page'=> -1,
			'order'=>'DESC',
			'orderby'=>'date'
		);
		global $wp_query;
		$original_query = $wp_query;
		$wp_query = null;
		$wp_query = new WP_Query( $args );
	}
	while ( have_posts() ) : the_post();
		?>
		<div class="post">
			<?php if (isset($GLOBALS['single-post'])){ ?>

				<h1><?php the_title(); ?></h1>
			<?php }else{ ?>
				<a class="title ease" href="<?php the_permalink(); ?>">
					<h2><?php the_title(); ?></h2>
				</a>
			<?php } ?>
			<div class="post-content-wrapper<?php echo isset($GLOBALS['single-post']) ? ' full' : ''; ?>">
				<?php
				if ( has_post_thumbnail() ) {
					$tn_id = get_post_thumbnail_id( get_the_ID() );
					$img = wp_get_attachment_image_src( $tn_id, 'blog' );
					$alt = get_post_meta( $tn_id, '_wp_attachment_image_alt', true );
					if (isset($GLOBALS['single-post'])){
						?>
						<div class="post-image">
							<img src="<?php echo $img[0]; ?>" alt="<?php echo $alt; ?>" />
						</div>
					<?php } else { ?>
						<a class="post-image" href="<?php the_permalink(); ?>" class="post-image" style="background-image:url(<?php echo $img[0]; ?>);">
							<img src="<?php echo $img[0]; ?>" alt="<?php echo $alt; ?>" />
						</a>
						<?php
					}
				}
				?>
				<div class="post-content-container">
					<div class="post-attribution">
						<?php
						if ($author = get_author_full_name()){
							echo '<span>'.$author.'</span>';
						}
						echo '<span>'.the_date('F j, Y','','',false).'</span>';
						?>
					</div>
					<?php if (isset($GLOBALS['single-post'])){ ?>
						<div class="post-content">
							<?php // the_content(); ?>
						</div>
					<?php } else { ?>
							<div class="post-excerpt">
								<?php echo custom_ACF_excerpt(); ?>
							</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php
	endwhile;
	if ($no_posts){
		$wp_query = null;
		$wp_query = $original_query;
		wp_reset_postdata();
	}
	?>
</div>
