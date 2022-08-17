const idModal = document.querySelector('.id-modal');

if(idModal) {
    const findIdElem = document.querySelector('.find-id');
    findIdElem.addEventListener('click', () => {
        idModal.classList.replace("modal-disabled", "modal-active");
    });
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
                            <input type="text" name="num" placeholder="인증코드">
                        </div>
                        <div>
                            <button class="code-btn">인증완료</button>
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
                                                <button class="cancel">확인</button>
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