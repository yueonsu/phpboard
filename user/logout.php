<?php
	session_start();
	session_destroy();
    unset($_SESSION['mypage_key']);
?>
<script>
	location.replace('<?php echo $_SERVER['HTTP_REFERER'];?>');
</script>