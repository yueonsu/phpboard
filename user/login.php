<html>
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>

    <script defer src="/test/static/js/login.js?ver=4"></script>
    <link rel="stylesheet" href="/test/static/css/login.css?ver=5">
</head>
<body>
<div class="login-container">
    <div class="login-bg">
        <h1>로그인</h1>
        <form action="./loginProc.php" method="post">
            <input type="hidden" name="prevUrl" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" name="id" id="floatingInput" placeholder="name@example.com">
              <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
              <input type="password" class="form-control" name="pw" id="floatingPassword" placeholder="Password">
              <label for="floatingPassword">Password</label>
            </div>
            <div class="error-msg dis-none">

            </div>
            <div class="text-center">
                <div>
                    <button type="submit" class="btn btn-secondary btn-sm p-3 w-25 mt-3">로그인</button>
                </div>
                <div>
                    <a href="./join.php"><button type="button" class="btn btn-secondary btn-sm p-3 w-25 mt-3">회원가입</button></a>
                </div>
                <div>
                    <a href="/test/board/main.php"><button type="button" class="btn btn-secondary btn-sm p-3 w-25 mt-3">메인</button></a>
                </div>

                <div class="find-wrap">
                    <span class="find-id">아이디찾기</span>
                    <span>/</span>
                    <span class="find-pw">비밀번호 찾기</span>
                </div>
            </div>
        </form>
    </div>

    <div class="modal-disabled id-modal">
        <div class="modal-content">
            <div>
                <input type="text" class="form-control" name="nm" id="floatingPassword" placeholder="이름">
            </div>
            <div>
                <input type="text" class="form-control" name="email" id="floatingPassword" placeholder="이메일">
            </div>
            <div>
                <button class="find-id-submit-btn btn btn-secondary">확인</button>
                <button class="find-id-cancel-btn btn btn-secondary">취소</button>
            </div>
        </div>
    </div>

    <div class="modal-disabled pw-modal">
        <div class="modal-content">
            <div>
                <input type="text" class="form-control" name="id" id="floatingPassword2" placeholder="아이디">
            </div>
            <div>
                <input type="text" class="form-control" name="email" id="floatingPassword2" placeholder="이메일">
            </div>
            <div class="msg-wrap">
                <strong class="msg"></strong>
            </div>
            <div>
                <button class="find-pw-submit-btn btn btn-secondary">확인</button>
                <button class="find-pw-cancel-btn btn btn-secondary">취소</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>