<form role="search" method="get" id="searchform" class="searchform" action="<?php esc_url( home_url( '/' ) ); ?>">
	<div>
		<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="Type your word here..."/>
		<i class="fa fa-search" ></i>
		<button type="submit">
			<i class="fa fa-search" ></i>
		</button>
	</div>
</form>
