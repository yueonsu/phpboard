const profileContainer = document.querySelector('.profile-container');
if(profileContainer) {
    const imgInput = profileContainer.querySelector('input[name=img]');
    imgInput.addEventListener('change', () => {
        if(imgInput.files && imgInput.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                document.querySelector('.preview').src = e.target.result;
            };
            reader.readAsDataURL(imgInput.files[0]);
        } else {
            document.querySelector('.preview').src = "";
        }
    });

    const fileForm = document.querySelector('.file-form');
    fileForm.addEventListener('submit', (e) => {

        const fileInput = fileForm.querySelector('input[name=img]');
        if(fileInput.value.length === 0) {
            e.preventDefault();
            alert('이미지를 선택해주세요.');
        }
    });
    
    // 체크박스
    const allCheck = document.querySelector('.all-check');
    const checkArr = document.querySelectorAll('.check');
    const checkLeng = checkArr.length;
    let cnt = 0;

    allCheck.addEventListener('click', () => {
        if(allCheck.checked == true) {
            cnt = checkLeng;
            checkArr.forEach(item => {
                item.checked = true;
            });
        } else {
            cnt = 0;
            checkArr.forEach(item => {
                item.checked = false;
            });
        }
    });

    checkArr.forEach(item => {
        item.addEventListener('click', () => {
            if(item.checked == true) {
                cnt++;
            } else {
                cnt--;
            }
            if(cnt === checkLeng) {
                allCheck.checked = true;
            } else {
                allCheck.checked = false;
            }
        });
    });

    // 삭제
    const delBtn = document.querySelector('.del');
    delBtn.addEventListener('click', () => {
        const data = [];
        checkArr.forEach(item => {
            if(item.checked) {
                data.push(item.value);
            }
        });
        if(data.length === 0) {
            alert('이미지를 선택해주세요');
            return;
        }
        if(!confirm('정말로 삭제하시겠습니까?')) {return;}

        fetch('/test/ajax/mypage/delProfile.php', {
            method : "POST",
            headers : {"Content-Type" : "application/json"},
            body : JSON.stringify({result : data})
        })
            .then(res => res.json())
            .then(data => {
                if(data == 1) {
                    location.reload();
                } else {
                    alert('삭제에 실패했습니다.');
                }
            })
            .catch(e => {
                console.error(e);
            });
    });

    //대표설정
    const repreBtn = document.querySelector('.repre');
    repreBtn.addEventListener('click', () => {
        const data = [];
        checkArr.forEach(item => {
            if(item.checked) {
                data.push(item.value);
            }
        });

        if(data.length > 1) {
            alert('대표이미지 설정은 한개만 가능합니다.');
            return;
        }
        if (data.length == 0) {
            alert('대표이미지를 선택해주세요.');
            return;
        }
        if(!confirm('대표이미지를 설정하시겠습니까?')) {return;}
        fetch(`/test/ajax/mypage/repre.php?iphoto=${data[0]}&repre=1`)
            .then(res => res.json())
            .then(data => {
                if(data == 1) {
                    location.reload();
                } else {
                    alert('대표이미지 설정에 실패했습니다.');
                }
            })
            .catch(e => {
                console.error(e);
            });
    });

    //대표이미지 삭제
    const delRepreBtn = document.querySelector('.del-repre-btn');
    delRepreBtn.addEventListener('click', () => {
        if(!confirm("대표이미지를 삭제합니다.")) { return; }
        fetch(`/test/ajax/mypage/repre.php?repre=0`)
            .then(res => res.json())
            .then(data => {
                if(data == 1) {
                    location.reload();
                } else {
                    alert("대표이미지 삭제에 실패했습니다.");
                }
            })
            .catch(e => {
                console.error(e);
            });
    });
}
