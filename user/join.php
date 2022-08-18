<html>
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="../static/css/join.css?ver=3">
	<script defer src="../static/js/join.js?ver=4"></script>
</head>
<body>
<div class="join-container">
	<div>
		<h2>회원가입</h2>
	</div>
	<form method="post" action="/test/user/joinProc.php" class="join-frm">
		<div>
			<input name="nm" class="form-control" type="text" placeholder="이름" aria-label="default input example">
		</div>
		<div>
			<input name="id" class="form-control" type="text" placeholder="아이디" aria-label="default input example">
			<div class="id-check-wrap"><button class="btn btn-secondary id-check-btn" type="button">사용</button></div>
		</div>
		
		<div class="pw-wrap">
			<input name="pw" class="form-control pw" type="password" placeholder="비밀번호" aria-label="default input example">
		</div>
		
		<div class="pw-wrap">
			<input class="form-control pw-check disabled" readonly type="password" placeholder="비밀번호 재입력" aria-label="default input example">
			
			<div class="pw-check-wrap">
				<input class="show-pw btn btn-secondary" type="button" value="보이기">
				<button class="pw-check-btn btn btn-secondary" type="button">확인</button>
			</div>
		</div>
		
		<div>
			<input class="form-control email" type="text" name="email" placeholder="이메일" aria-label="default input example">
			<input class="form-control email-check dis-none" type="text" placeholder="인증번호" aria-label="default input example">
			<div class="certification-num">
				<button type="button" class="btn btn-secondary email-send-btn">인증번호 발송</button>
				<button type="button" class="btn btn-secondary email-check-btn dis-none">확인</button>
			</div>
		</div>
		<div class="utils">
			<a href="/test/board/main.php"><button class="btn btn-secondary" type="button">메인으로</button></a>
			<button class="join-submit btn btn-secondary">가입</button>
			<div></div>
		</div>
	</form>
</div>
</body>
</html>