<?php
	session_start();
	session_destroy();
?>
<script>
	location.replace('<?php echo $_SERVER['HTTP_REFERER'];?>');
</script>