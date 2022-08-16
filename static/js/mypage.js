const url = new URL(location.href);
const iuser = url.searchParams.get('iuser');
	
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
		fetch(`./ajax/mypage/checkPassword.php`, {
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
						<strong>비밀번호가 일치하지 않습니다.</strong>
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
				<strong>특수문자 ~!@#_, 문자, 숫자를 한개 이상 포함해서 6~20자로 작성해주세요.</strong>
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
				<strong>비밀번호가 일치합니다.</strong>
			`;
			isPw = true;
		} else {
			div.innerHTML = `
				<strong>비밀번호가 일치하지 않습니다.</strorng>
			`;
			iwPw = false;
		}
		changePasswordCheckInput.after(div);
	});
	
	const changePasswordBtn = info.querySelector('.change-password-btn');
	changePasswordBtn.addEventListener('click', () => {
		if(isPw) {
			const data = {
				iuser : iuser,
				pw : changePasswordInput.value
			}
			fetch(`./ajax/mypage/changePassword.php`, {
				method : 'POST',
				headers : {"Content-Type" : "application/json"},
				body : JSON.stringify(data)
			})
				.then(res => res.json())
				.then(data => {
					if(data) {
						alert('비밀번호 변경이 완료 됐습니다 !');
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
			alert('비밀번호가 일치하지 않습니다.');
		}
	});
}

const changeEmail = document.querySelector('.change-email');
if(changeEmail) {
	const emailSendBtn = changeEmail.querySelector('.email-send-btn');
	const emailInputWrap = changeEmail.querySelector('.email-input-wrap');
	const changeEmailInputWrap = changeEmail.querySelector('.change-email-input-wrap');
	emailSendBtn.addEventListener('click', () => {
		const emailInput = changeEmail.querySelector('.email-input');
		const email = emailInput.value;
		console.log(email);
		fetch(`./ajax/join/emailSend.php?email=${email}`)
			.then(res => res.json())
			.then(data => {
				const isMsg = document.querySelector('.email-msg');
				if(isMsg) {
					isMsg.remove();
				}
				if(data == 0) {
					const div = document.createElement('div');
					div.classList.add('email-msg');
					div.innerHTML = `
						<strong>이미 존재하는 이메일입니다.</strong>
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
		fetch(`./ajax/join/emailCheck.php?num=${certificationNum}`)
			.then(res => res.json())
			.then(data => {
				if(data == 1) {
					const emailInput = changeEmail.querySelector('.email-input');
					const email = emailInput.value;
					const emailData = {
						email : email,
						iuser : iuser
					}
					
					fetch(`./ajax/mypage/changeEmail.php`, {
						method: "post",
						headers : {'Content-Type' : 'application/json'},
						body : JSON.stringify(emailData)
					})
						.then(res => res.json())
						.then(data => {
							alert('이메일 변경에 성공했습니다.');
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