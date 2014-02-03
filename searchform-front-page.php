<?php
/**
 * Display search form for front page.
 *
 * @package Origin
 */
?>
<form role="search" method="get" class="article-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php _e( 'Search for:', 'stag' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Type a keyword to search&hellip;', 'Front page search bar placeholder text', 'origin' ) ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" role="textbox" maxlength="100">
	</label>
	<input type="hidden" name="post_type" value="article">
	<!-- <input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'origin' ); ?>"> -->
</form>
