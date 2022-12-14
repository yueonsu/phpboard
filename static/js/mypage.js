const url = new URL(location.href);
const iuser = url.searchParams.get('iuser');

const authenticationElem = document.querySelector('.authentication');
if(authenticationElem) {
	const authPasswordBtn = authenticationElem.querySelector('.auth-password-btn');
	authPasswordBtn.addEventListener('click', () => {
		const mypageContainerElem = document.querySelector('.mypage-container');

		const passwordInput = authenticationElem.querySelector('.auth-password');
		const data = {
			pw : passwordInput.value
		}

		fetch('/test/ajax/mypage/checkPassword.php', {
			method: 'POST',
			headers: {'Content-Type': "application/json"},
			body: JSON.stringify(data)
		})
			.then(res => res.json())
			.then(data => {
				const authMsg = authenticationElem.querySelector('.auth-msg');
				if(data) {
					authMsg.classList.add('dis-none');
					authenticationElem.classList.add('dis-none');
					mypageContainerElem.classList.remove('dis-none');
				} else {
					authMsg.classList.remove('dis-none');
				}
			})
			.catch(e => {
				console.error(e);
			});
	});
}
	
const info = document.querySelector('.info');
if(info) {
	const pwRegExp = /^(?=.*[a-zA-Z])(?=.*[_~!@#])(?=.*[0-9]).{6,20}$/;
	
	const currentPasswordBtn = info.querySelector('.current-password-btn');
	const currentPasswordInput = info.querySelector('.current-password-input');
	const changePasswordWrap = info.querySelector('.change-password-wrap');
	const currentPasswordWrap = info.querySelector('.current-password-wrap');
	
	let isPw = false;
	let isEmail = false;
	currentPasswordBtn.addEventListener('click', () => {
		const passwordValue = currentPasswordInput.value;
		
		const data = {
			pw : passwordValue,
			iuser : iuser
		}
		fetch(`/test/ajax/mypage/checkPassword.php`, {
			method : 'post',
			headers : {'Content-Type' : 'application/json'},
			body : JSON.stringify(data)
		})
			.then(res => res.json())
			.then(data => {
				const isMsg = document.querySelector('.pw-msg');
				if(isMsg) {
					isMsg.remove();
				}
				
				if(data) {
					currentPasswordWrap.classList.add('dis-none');
					changePasswordWrap.classList.remove('dis-none');
				} else {
					const div = document.createElement('div');
					div.classList.add('pw-msg');
					div.innerHTML = `
						<strong>??????????????? ???????????? ????????????.</strong>
					`;
					currentPasswordWrap.after(div);
				}
			})
			.catch(e => {
				console.error(e);
			});
	});
	
	const changePasswordInput = info.querySelector('.change-password-input');
	const changePasswordCheckInput = info.querySelector('.change-password-check-input');
	changePasswordInput.addEventListener('keyup', () => {
		const changePasswordVal = changePasswordInput.value;

		const isMsg = document.querySelector('.pw-msg');
		if(isMsg) {
			isMsg.remove();
		}
		if(!pwRegExp.test(changePasswordVal)) {
			const div = document.createElement('div');
			div.classList.add('pw-msg');
			div.innerHTML = `
				<strong>???????????? ~!@#_, ??????, ????????? ?????? ?????? ???????????? 6~20?????? ??????????????????.</strong>
			`;
			changePasswordCheckInput.classList.add('disabled');
			changePasswordCheckInput.readOnly = true;
			changePasswordInput.after(div);
			return;
		}
		changePasswordCheckInput.classList.remove('disabled');
		changePasswordCheckInput.readOnly = false;
	});
	
	changePasswordCheckInput.addEventListener('keyup', () => {
		const prev = changePasswordInput.value;
		const next = changePasswordCheckInput.value;
		
		const isMsg = document.querySelector('.pw-msg');
		if(isMsg) {
			isMsg.remove();
		}
		const div = document.createElement('div');
		div.classList.add('pw-msg');
		if(prev == next) {
			div.innerHTML = `
				<strong>??????????????? ???????????????.</strong>
			`;
			isPw = true;
		} else {
			div.innerHTML = `
				<strong>??????????????? ???????????? ????????????.</strorng>
			`;
			iwPw = false;
		}
		changePasswordCheckInput.after(div);
	});
	
	const changePasswordBtn = info.querySelector('.change-password-btn');
	changePasswordBtn.addEventListener('click', () => {
		const changePasswordCheckInput = info.querySelector('.change-password-check-input').value;
		if(changePasswordCheckInput != changePasswordInput.value) {
			alert('??????????????? ???????????? ????????????.');
			return;
		}
		if(isPw) {
			const data = {
				iuser : iuser,
				pw : changePasswordInput.value
			}
			fetch(`/test/ajax/mypage/changePassword.php`, {
				method : 'POST',
				headers : {"Content-Type" : "application/json"},
				body : JSON.stringify(data)
			})
				.then(res => res.json())
				.then(data => {
					if(data) {
						alert('???????????? ????????? ?????? ???????????? !');
						changePasswordCheckInput.value = null;
						changePasswordInput.value = null;
						currentPasswordInput.value = null;
						changePasswordWrap.classList.add('dis-none');
						currentPasswordWrap.classList.remove('dis-none');
						document.querySelector('.accordion-button').click();
					}
				})
				.catch(e => {
					console.error(e);
				});
		} else {
			alert('??????????????? ???????????? ????????????.');
		}
	});
}

const changeEmail = document.querySelector('.change-email');
if(changeEmail) {
	const emailSendBtn = changeEmail.querySelector('.email-send-btn');
	const emailInputWrap = changeEmail.querySelector('.email-input-wrap');
	const changeEmailInputWrap = changeEmail.querySelector('.change-email-input-wrap');
	emailSendBtn.addEventListener('click', () => {
		const emailRegex = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
		const emailInput = changeEmail.querySelector('.email-input');
		const email = emailInput.value;
		if(!emailRegex.test(email)) {
			alert("???????????? ???????????? ??????????????????.");
			return;
		}
		fetch(`/test/ajax/join/emailSend.php?email=${email}`)
			.then(res => res.json())
			.then(data => {
				console.log(data);
				const isMsg = document.querySelector('.email-msg');
				if(isMsg) {
					isMsg.remove();
				}
				if(data == 0) {
					const div = document.createElement('div');
					div.classList.add('email-msg');
					div.innerHTML = `
						<strong>?????? ???????????? ??????????????????.</strong>
					`;
					emailInputWrap.after(div);
				} else if(data == 1) {
					emailInput.classList.add('disabled');
					emailInput.readOnly = true;
					changeEmailInputWrap.classList.remove('dis-none');
				}
			})
			.catch(e => {
				console.error(e);
			});
	});
	
	const certificationBtn = document.querySelector('.certification-btn');
	certificationBtn.addEventListener('click', () => {
		const certificationInput = document.querySelector('.certification-input');
		const certificationNum = certificationInput.value;
		fetch(`/test/ajax/join/emailCheck.php?num=${certificationNum}`)
			.then(res => res.json())
			.then(data => {
				if(data == 1) {
					const emailInput = changeEmail.querySelector('.email-input');
					const email = emailInput.value;
					const emailData = {
						email : email,
						iuser : iuser
					}
					
					fetch(`/test/ajax/mypage/changeEmail.php`, {
						method: "post",
						headers : {'Content-Type' : 'application/json'},
						body : JSON.stringify(emailData)
					})
						.then(res => res.json())
						.then(data => {
							alert('????????? ????????? ??????????????????.');
							emailInput.value = null;
							emailInput.readOnly = false;
							emailInput.classList.remove('disabled');
							certificationInput.value = null;
							changeEmailInputWrap.classList.add('dis-none');
						})
						.catch(e => {
							console.error(e);
						});
				}
			})
			.catch(e => {
				console.error(e);
			});
	});
}