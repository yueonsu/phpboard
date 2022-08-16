<?php 
include_once 'libs/Db.php';
use libs\Db;

$iuser = $_GET['iuser'];
$row = mysqli_fetch_assoc(Db::query("SELECT A.*, (SELECT COUNT(*) FROM board WHERE iuser = $iuser) AS board, (SELECT count(*) FROM comment WHERE iuser = $iuser) as comment, B.nm, (SELECT count(*) FROM `like` WHERE iuser = $iuser) as `like` FROM board A INNER JOIN user B ON A.iuser = B.iuser WHERE A.iuser = $iuser"));
?>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

	<link rel="stylesheet" href="./static/css/mypage.css?ver=3">
	<script defer src="./static/js/mypage.js?ver=1"></script>
	<title>마이페이지</title>
</head>
<body>
	<div class="mypage-container">
		<div class="mypage-header">
			<div>
				<div>
					<a href="./main.php"><button class="btn btn-secondary">메인</button></a>
				</div>
				<div>
					<strong><?php echo $row['nm']?></strong>
				</div>
			</div>
		</div>
		<div class="mypage-body">
			<div class="my-history-wrap">
				<div>
					<strong>History</strong>
				</div>
				<div class="my-history">
					<div class="comment">
						<div><strong><?php echo $row['comment']?></strong></div>
						<div><span>댓글</span></div>
					</div>
					<div class="write">
						<div><strong><?php echo $row['board']?></strong></div>
						<div><span>내가 쓴 글</span></div>
					</div>
					<div class="like">
						<div><strong><?php echo $row['like']?></strong></div>
						<div><span>좋아요</span></div>
					</div>
				</div>
			</div>
			<div class="info">
				<div class="accordion" id="accordionPanelsStayOpenExample">
				  <div class="accordion-item">
				    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
				      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
				        비밀번호 변경
				      </button>
				    </h2>
				    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
				      <div class="accordion-body">
				        <div>
				        	<div class="current-password-wrap">
				        		<div>
				        			<strong>현재 비밀번호</strong>
				        		</div>
				        		<div>
				        			<div class="input-group mb-3">
									  <input type="password" class="form-control current-password-input" placeholder="Password" aria-label="Recipient's username" aria-describedby="button-addon2">
									  <button class="btn btn-outline-secondary current-password-btn" type="button" id="button-addon2">입력</button>
									</div>
				        		</div>
				        	</div>
				        	
				        	<div class="change-password-wrap dis-none">
				        		<div>
				        			<strong>변경할 비밀번호</strong>
				        		</div>
				        		<div>
						        	<div class="password">
						        		<input type="password" class="form-control change-password-input" placeholder="Password" aria-label="Recipient's username" aria-describedby="button-addon2">
						        	</div>
						        	<div>
						        		<input readonly type="password" class="form-control change-password-check-input disabled" placeholder="Password" aria-label="Recipient's username" aria-describedby="button-addon2">
						        	</div>
						        	<div>
						        		<button class="btn btn-secondary change-password-btn">변경</button>
						        	</div>
						        </div>
					        </div>
				        </div>
				      </div>
				    </div>
				  </div>
				  <div class="accordion-item change-email">
				    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
				      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
				        이메일 변경
				      </button>
				    </h2>
				    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
				      <div class="accordion-body">
				        <div>
				        	<div class="input-group mb-3 email-input-wrap">
							  <input type="email" class="form-control email-input" placeholder="Email" aria-label="Recipient's username" aria-describedby="button-addon2">
							  <button class="btn btn-outline-secondary email-send-btn" type="button" id="button-addon2">인증번호 전송</button>
							</div>
							<div class="input-group mb-3 change-email-input-wrap dis-none">
							  <input type="text" class="form-control certification-input" placeholder="인증번호" aria-label="Recipient's username" aria-describedby="button-addon2">
							  <button class="btn btn-outline-secondary certification-btn" type="button" id="button-addon2">인증</button>
							</div>
				        </div>
				      </div>
				    </div>
				  </div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>