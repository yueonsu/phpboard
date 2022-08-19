<?php
//css




require_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/test/libs/Utils.php';
use libs\Utils;
use libs\Db;
session_start();

?>
<html>
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" href="/test/static/css/main.css?ver=7">
	<script defer src="/test/static/js/main.js?ver=7"></script>
</head>
<body>
	<div class="board-container">
        <div>
            <a href="/test/board/main.php">메인</a>
        </div>
		<div class="menu">
			
			<?php if(isset($_SESSION['iuser'])) { ?>
			<div>
				<span>
					<?php
					$iuser = $_SESSION['iuser'];
					echo mysqli_fetch_assoc(Db::query("SELECT nm FROM user WHERE iuser = $iuser"))['nm'];
					?>
				</span>
				<span>님</span>
			</div>
			<a href="/test/mypage/mypage.php?iuser=<?php echo $iuser?>">마이페이지</a>
			<a href="/test/user/logout.php"><span>로그아웃</span></a>
			<?php } else {?>
			<a href="../user/login.php">로그인</a>
			<a href="../user/join.php">회원가입</a>
			<?php } ?>
		</div>
		
		
		<div style="min-height: 513px;">
			<table class="table">
			  <colgroup>
			  	<col width="5%">
			  	<col width="35%">
			  	<col width="10%">
			  	<col width="20%">
			  	<col width="10%">
			  	<col width="10%">
			  	<col width="5%">
			  </colgroup>
			  <thead>
			    <tr class="table-head">
			      <th scope="col">번호</th>
			      <th scope="col">제목</th>
			      <th scope="col">작성자</th>
			      <th scope="col">날짜</th>
			      <th scope="col">조회수</th>
			      <th scope="col">좋아요</th>
			      <th scope="col">댓글</th>
			    </tr>
			  </thead>
			  <tbody>
			  <?php
				$page = $_GET['page'];
				$rowCnt = 10;
				$startIdx = ($page * $rowCnt) - $rowCnt;
				$result = Db::query("select A.*,(select count(*) from comment where iboard = A.iboard AND reply is null) as comment 
                                 ,(select count(*) from hit where iboard = A.iboard) as hit, (select count(*) from `like` where iboard = A.iboard) as `like`
                                 , B.nm from board A inner join user B on A.iuser = B.iuser order by rdt desc LIMIT $startIdx, $rowCnt");
				$totalPage = ceil(mysqli_fetch_assoc(Db::query("SELECT COUNT(*) AS cnt FROM board"))['cnt'] / $rowCnt);
				
				$s = $_GET['sel'];
				$t = $_GET['text'];
				
				if($s || $t) {
					$add = "";
					switch ($s) {
						case 1 :
							$add = "where (title like '%$t%') OR (content like '%$t%') OR (B.nm like '%$t%')";
							break;
						case 2:
							$add = "where (title like '%$t%')";
							break;
						case 3: 
							$add = "where (B.nm like '%$t%')";
							break;
						case 4:
							$add = "where (content like '%$t%')";
							break;
					}
					$result = Db::query($result = "select A.*,(select count(*) from comment where iboard = A.iboard AND reply is null) as comment 
                                     ,(select count(*) from hit where iboard = A.iboard) as hit, (select count(*) from `like` where iboard = A.iboard) as `like`
                                     , B.nm from board A inner join user B on A.iuser = B.iuser $add order by rdt desc LIMIT $startIdx, $rowCnt");
					$totalPage = ceil(mysqli_fetch_assoc(Db::query("SELECT COUNT(A.iboard) AS cnt FROM board A INNER JOIN user B ON A.iuser = B.iuser $add"))['cnt'] / $rowCnt);
				}	
				
				if(mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_assoc($result)) {
					?>
				    <tr class="table-body" onClick="clickToDetailPage(<?php echo $row['iboard'];?>)">
				      <th scope="row"><?php echo $row['iboard'];?></th>
				      <td><?php echo Utils::title($row['title']);?></td>
				      <td><?php echo $row['nm'];?></td>
				      <td><?php echo $row['rdt'];?></td>
				      <td><?php echo $row['hit']?></td>
				      <td><?php echo $row['like']?></td>
				      <td><?php echo $row['comment']?></td>
				    </tr>
				    <?php 
					} 
				} else {?>
				<tr>
					<td colspan="7" style="text-align: center;" class="no-board">
						<strong>글이 없습니다.</strong>
					</td>
				</tr>
				<?php }?>
			  </tbody>
			</table>
		</div>
		<?php if($_SESSION['iuser']) {?>
		<div class="menu"><a href="write.php">글쓰기</a></div>
		<?php }?>
		<div class="search-container">
			<form method="get" action="./main.php">
				<div>
					<input type="hidden" value="1" name="page">
					<select class="form-select" name="sel" style="width: 150px;" aria-label="Default select example">
					  <option value="1" <?php echo $s == 1 ? 'selected' : ''?>>전체검색</option>
					  <option value="2" <?php echo $s == 2 ? 'selected' : ''?>>제목</option>
					  <option value="3" <?php echo $s == 3 ? 'selected' : ''?>>작성자</option>
					  <option value="4" <?php echo $s == 4 ? 'selected' : ''?>>내용</option>
					</select>
				</div>
				<div>
					<div class="input-group mb-3">
					  <input type="text" value="<?php echo $_GET['text']?>" class="form-control" name="text" placeholder="검색" aria-label="Recipient's username" aria-describedby="button-addon2">
					  <button class="btn btn-outline-secondary" id="button-addon2">검색</button>
					</div>
				</div>
			</form>
		</div>
		<?php 
		
		$pageCnt = 10;
		
		if($totalPage > 0) {
		
			$lastPage = ceil($page / $pageCnt) * $pageCnt;
			$startPage = $lastPage - $pageCnt + 1;
			$maxPage = (($lastPage < $totalPage) ? $lastPage : $totalPage);
			
			$prevPage = $startPage - 1;
			$nextPage = $lastPage + 1;
			
			if($page == 0 || $page == NULL) {
				header("Location:./main.php?page=1");
			} else if($page > $totalPage) {
				header("Location:./main.php?page=$maxPage");
			}
			?>
			<nav aria-label="Page navigation example" style="display:flex; justify-content:center;">
			  <ul class="pagination">
			  
			 	<?php
			 	if($startPage != 1) { ?>
			    <li class="page-item"><a class="page-link" href="./main.php?page=<?php echo $prevPage;?>">Previous</a></li>
			    <?php 
				} ?>
			    
			    <?php
			    for($i=$startPage; $i<=$maxPage; $i++) { 
			    	$result = $i;
			    	if($s | $t) {
			    		$result = $i . '&sel=' . $s . '&text=' . $t;
			    	}
			    ?>
			    <li class="page-item <?php if($i == $page) { echo "disabled"; }?>"><a class="page-link" href="./main.php?page=<?php echo $result?>"><?php echo $i;?></a></li>
			    <?php
			    } ?>
			    
			    <?php
			    if($totalPage != $maxPage) { ?>
			    <li class="page-item"><a class="page-link" href="./main.php?page=<?php echo $nextPage?>">Next</a></li>
			    <?php 
			    }
			}
		    ?>
		  </ul>
		</nav>
		
	</div>
	
</body>
</html>