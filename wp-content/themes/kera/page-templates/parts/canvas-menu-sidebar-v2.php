<?php 

$sidebar_id = 'canvas-menu';
	
if( !is_active_sidebar($sidebar_id) ) return;

?>

<div class="canvas-menu-sidebar">
	<a href="javascript:void(0);" class="btn-canvas-menu"><?php esc_html_e( 'Menu', 'kera' ) ?><i class="zmdi zmdi-format-align-right"></i></a>
</div>