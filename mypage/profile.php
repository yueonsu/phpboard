<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/test/libs/Db.php";
use libs\Db;

$iuser = $_GET['iuser'] != null ? $_GET['iuser'] : 0;
if($iuser == 0) {
    header("Location:/test/user/login.php");
}

$defaultImg = mysqli_fetch_assoc(Db::query("SELECT img FROM photos WHERE repre = true AND iuser = $iuser"));
$defaultImg = $defaultImg['img'] == null ? 'default.png' : $iuser . "/" . $defaultImg['img'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="/test/static/css/profile.css?ver=3">
    <script defer src="/test/static/js/profile.js?ver=1"></script>

    <title>Document</title>
</head>
<body>
<div class="header">
    <a href="./mypage.php?iuser=<?php echo $iuser ?>">마이페이지</a>
</div>
<div class="profile-container">

    <div class="img-bg">
        <div class="img-wrap">
            <img class="preview" src="/test/static/img/<?php echo $defaultImg; ?>">
        </div>
    </div>
    
    <div class="upload-bg">
        <div>
            <form action="./file.php" class="file-form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="iuser" value="<?php echo $iuser; ?>"
                <div>
                    <input type="file" name="img">
                </div>
                <div>
                    <div class="insert-img">
                        <button class="btn btn-secondary">이미지 등록</button>
                    </div>
                    <div>
                        <button type="button" class="del-repre-btn btn btn-secondary">대표이미지 삭제</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="history-bg">
        <div class="history-scroll">
            <table>
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="all-check">
                        </th>
                        <th>이미지</th>
                        <th>업로드 날짜</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $result = Db::query("SELECT * FROM photos WHERE iuser = $iuser");
                while($rows = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td>
                            <input type="checkbox" class="check" value="<?php echo $rows['iphoto'];?>">
                        </td>
                        <td>
                           <div>
                               <img src="/test/static/img/<?php echo $iuser; ?>/<?php echo $rows['img'];?>">
                           </div>
                        </td>
                        <td><?php echo $rows['rdt']; ?></td>
                    </tr>
                <?php
                }
                if(mysqli_num_rows($result) == 0) {
                ?>
                    <tr>
                        <td class="no-img" colspan="3">
                            <strong>프로필 사진이 없습니다.</strong>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <div>
            <div class="utils">
                <button class="del btn btn-secondary">삭제</button>
                <button class="repre btn btn-secondary">설정</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
