<?php
include_once 'libs/Utils.php';
include_once 'libs/Db.php';
include_once 'libs/Crypt.php';
use libs\Crypt;
use libs\Db;
use libs\Utils;
session_start();


$ip = $_SERVER["REMOTE_ADDR"];
$iboard = $_GET['iboard'];
$iuser = $_SESSION['iuser'];
$c = new Crypt();

$bool = mysqli_fetch_assoc(Db::query("SELECT * FROM hit WHERE iboard = $iboard"));
if($c->Decrypt($bool['ip']) != $ip) {
	$ip = $c->Encrypt($ip);
	Db::query("INSERT INTO hit (iboard, ip) VALUES ($iboard, '$ip')");

}

$rows = mysqli_fetch_assoc(Db::query("select A.*, B.nm, (select count(*) from `like` where iboard = $iboard AND iuser = $iuser) as `like`, (select count(*) from hit where iboard = $iboard) as hit from board A inner join user B on A.iuser = B.iuser where A.iboard = $iboard"));

?>
<html>
	<head>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
		<script src="https://kit.fontawesome.com/185cb4ce4e.js" crossorigin="anonymous"></script>
		
		<link rel="stylesheet" href="/test/static/css/detail.css?ver=11">
		<script defer src="/test/static/js/detail.js?ver=59"></script>
	</head>
	<body>
		<div id="iboard" data-iboard="<?php echo $_GET['iboard']?>">
			<div id="iuser" data-iuser="<?php echo $_SESSION['iuser']?>"></div>
		</div>
		<div class="detail-container">
			<div>
				<a href="./main.php?page=1">
					처음으로
				</a>
			</div>
			
			<div class="content-wrap">
				<div class="top">
					<div class="title">
						<div>
							<h2><?php echo Utils::preventScript($rows['title']);?></h2>
						</div>
						<div>
							<?php
							if($iuser == $rows['iuser']) {
							?>
							<div>
								<a href="./write.php?iboard=<?php echo $iboard;?>&iuser=<?php echo $iuser;?>">수정</a>
								<span class="del">삭제</span>
							</div>
							<?php
							}?>
						</div>
					</div>
				</div>
				
				<div class="content">
					<div class="board-info">
						<div>
							<?php 
							if(isset($_SESSION['iuser'])) {
								if($rows['like'] == 0) {
								?>
								<i class="fa-regular fa-heart like"></i>
								<?php 
								} else if ($rows['like'] > 0) {?>
								<i class="fa-solid fa-heart like"></i>
								<?php 
								}
							}?>
						</div>
						<div>
							<span><?php echo $rows['nm']?></span>
							
							<span><?php echo $rows['rdt']?></span>
							
							<span>조회: </span>
							<span><?php echo $rows['hit'];?></span>
						</div>
					</div>
					<div><?php echo $rows['content'];?></div>
				</div>
			</div>
			
			<div class="comment">
				<?php if(isset($_SESSION['iuser'])) {?>
				<div class="comment-write-wrap">
					<form class="comment-write" method="post" action="./ajax/comment/write.php">
						<input type="hidden" name="iuser" value="<?php echo $_SESSION['iuser'];?>">
						<input type="hidden" name="iboard" value="<?php echo $iboard;?>">
						<textarea name="content"></textarea>
						<div>
							<button class="btn btn-secondary">댓글쓰기</button>
						</div>
					</form>
				</div>
				<?php }?>
			</div>
			<div class="comment-content-wrap">
				<div class="comment-list">
				
				</div>
			</div>
			<div class="comment-pagination">
				<nav aria-label="Page navigation example">
				  <ul class="pagination">
				    <li class="page-item comment-prev">
				      <a class="page-link" href="#" aria-label="Previous">
				        <span aria-hidden="true">&laquo;</span>
				      </a>
				    </li>
				    <div style="display: flex;" class="page-list">
				    
				    </div>
				    <li class="page-item comment-next">
				      <a class="page-link" href="#" aria-label="Next">
				        <span aria-hidden="true">&raquo;</span>
				      </a>
				    </li>
				  </ul>
				</nav>
			</div>
		</div>
	</body>
	<script>
		const del = document.querySelector('.del');
		if(del) {
			del.addEventListener('click', (e) => {
				if(confirm('정말로 삭제하시겠습니까?')) {
					location.replace('./del.php?iboard=<?php echo $iboard;?>&prev=<?php echo $_SERVER['HTTP_REFERER']?>');
				}
			});
		}
	</script>
</html>