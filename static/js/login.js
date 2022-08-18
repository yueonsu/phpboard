const url = new URL(location.href);
const error = url.searchParams.get("error");
console.log(error);
if(error == 1) {
    const errorMsg = document.querySelector('.error-msg');
    errorMsg.innerHTML = `
        <strong>아이디 또는 비밀번호가 일치하지 않습니다.</strong>
    `;
    errorMsg.classList.remove('dis-none');
} else if(error == 2) {
    const errorMsg = document.querySelector('.error-msg');
    errorMsg.innerHTML = `
        <strong>아이디와 비밀번호를 입력해주세요.</strong>
    `;
    errorMsg.classList.remove('dis-none');
}

const idModal = document.querySelector('.id-modal');
const pwModal = document.querySelector('.pw-modal');

const findIdElem = document.querySelector('.find-id');
findIdElem.addEventListener('click', () => {
    idModal.classList.replace("modal-disabled", "modal-active");
});

const findPwElem = document.querySelector('.find-pw');
findPwElem.addEventListener('click', () => {
    pwModal.classList.replace('modal-disabled', 'modal-active');
});

if(idModal) {
    const findIdCancelBtn = document.querySelector('.find-id-cancel-btn');
    findIdCancelBtn.addEventListener('click', () => {
        idModal.classList.replace("modal-active", "modal-disabled");
    });
    const findIdSubmitBtn = document.querySelector('.find-id-submit-btn');
    findIdSubmitBtn.addEventListener('click', () => {
        const nmInput = idModal.querySelector('input[name=nm]');
        const emailInput = idModal.querySelector('input[name=email]');
        const data = {
            nm : nmInput.value,
            email : emailInput.value
        }

        fetch('/test/ajax/login/findId.php', {
            method : "POST",
            headers : {"Content-Type" : "application/json"},
            body : JSON.stringify(data)
        })
            .then(res => res.json())
            .then(data => {
                if(data > 0) {
                    const modalContentElem = document.querySelector('.modal-content');
                    modalContentElem.innerHTML = `
                        <div>
                            <input type="text" class="form-control" name="num" id="floatingPassword" placeholder="인증코드">
                        </div>
                        <div>
                            <button class="code-btn btn btn-secondary">인증완료</button>
                        </div>
                    `;
                    const codeBtn = modalContentElem.querySelector('.code-btn');
                    codeBtn.addEventListener('click', () => {
                        const num = modalContentElem.querySelector('input[name=num]');
                        fetch(`/test/ajax/login/codeCheck.php?num=${num.value}&email=${emailInput.value}`)
                            .then(res => res.json())
                            .then(data => {
                                if(data != false) {
                                    modalContentElem.innerHTML = `
                                           <div>
                                                <strong>${data}</strong>
                                           </div>
                                           <div>
                                                <button class="cancel btn btn-secondary">확인</button>
                                           </div>
                                    `;
                                    const cancel = modalContentElem.querySelector('.cancel');
                                    cancel.addEventListener('click', () => {
                                        location.reload();
                                    });
                                }
                            })
                            .catch(e => {
                                console.error(e);
                            });
                    })
                }
            })
            .catch(e => {
                console.error(e);
            });
    });
}


if(pwModal) {
    const findPwSubmitBtn = pwModal.querySelector('.find-pw-submit-btn');
    const findPwCancelBtn = pwModal.querySelector('.find-pw-cancel-btn');
    findPwSubmitBtn.addEventListener('click', () => {
        const idInput = pwModal.querySelector('input[name=id]');
        const emailInput = pwModal.querySelector('input[name=email]');

        const data = {
            id : idInput.value,
            email : emailInput.value
        }

        fetch('/test/ajax/login/findPw.php', {
            method : "POST",
            headers : {"Content-Type" : "application/json"},
            body : JSON.stringify(data)
        })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                const msg = pwModal.querySelector('.msg');
                msg.innerText = null;
                if(data == 0) {
                    msg.innerText = '가입되어 있지 않습니다.';
                } else if(data){
                    const modalContentElem = pwModal.querySelector('.modal-content');
                    modalContentElem.innerHTML = `
                        <strong>${emailInput.value}로 임시비밀번호를 전송했습니다.</strong>
                        <div>
                            <button class="cancel btn btn-secondary">확인</button>
                        </div>
                    `;
                    const cancelBtn = modalContentElem.querySelector('.cancel');
                    cancelBtn.addEventListener('click', () => {
                        pwModal.classList.replace('modal-active', 'modal-disabled');
                    });
                } else if(data == 2) {
                    msg.innerText = '이메일 전송에 실패했습니다.';
                }
            })
            .catch(e => {
                console.error(e);
            });
    });

    findPwCancelBtn.addEventListener('click', () => {
        pwModal.classList.replace('modal-active', 'modal-disabled');
    });
}