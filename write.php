<html>
<head>
	<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="/test/static/css/write.css?ver=1">
	<script defer src="/test/static/js/write.js"></script>
</head>
<body>
	<?php 
	
	require_once 'libs/Db.php';
	require_once 'libs/Utils.php';
	use libs\Utils;
	use libs\Db;
	
	$iboard = $_GET['iboard'];
	
	$result = mysqli_fetch_assoc(Db::query("SELECT * FROM board WHERE iboard = $iboard"));
	
	
	?>
	<div class="write-container">
		<form action="./writeProc.php" method="POST" class="writeFrm">
			<input type="hidden" name="iboard" value="<?php echo $iboard?>">
	    	<div class="mb-3">
			  <label for="exampleFormControlInput1" class="form-label">제목</label>
			  <input type="text" class="form-control title" name="title" id="title exampleFormControlInput1" value="<?php echo Utils::preventScript($result['title']); ?>">
			</div>
	      	<textarea id="editor" name="content" class="content"><?php echo $result['content'];?></textarea>
	      	<div class="write_menu">
	      		<div><button type="submit" class="btn btn-secondary">저장</button></div>
	      		<div><a class="btn btn-secondary" href="./main.php">메인</a></div>
	    	</div>
	    </form>
	</div>
    
    <script>
      ClassicEditor.create( document.querySelector( '#editor' ) );
    </script>
</body>
</html>