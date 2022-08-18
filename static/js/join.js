const joinContainer = document.querySelector('.join-container');
if(joinContainer) {
	const nm = joinContainer.querySelector("input[name='nm']"); // length : 5
	const nmRegExp = /^([가-힣]{2,5})$/;
	const id = joinContainer.querySelector("input[name='id']"); // length : 20
	const idRegExp = /^([a-zA-Z0-9]{5,20})$/;
	const pw = joinContainer.querySelector('.pw'); // length : 100
	const pwRegExp = /^(?=.*[a-zA-Z])(?=.*[_~!@#])(?=.*[0-9]).{6,20}$/;
	
	const pwCheck = joinContainer .querySelector('.pw-check');
	const idCheckBtn= joinContainer.querySelector(".id-check-btn");
	const pwCheckBtn = joinContainer.querySelector(".pw-check-btn");
	const frm = joinContainer.querySelector('.join-frm');
	const showPw = joinContainer.querySelector('.show-pw');
	const emailSendBtn = joinContainer.querySelector('.email-send-btn');
	const emailCheckBtn = joinContainer.querySelector('.email-check-btn');
	const email = joinContainer.querySelector('.email');
	const emailCheck = joinContainer.querySelector('.email-check');
	
	let checkObj = {
		cid : false,
		cpw : false,
		id : false,
		pw : false,
		email : false,
		nm : false
	};
	
	//nm
	nm.addEventListener("keyup", () => {
		const isMsg = document.querySelector('.nm-msg');
		if(isMsg) {
			isMsg.remove();
		}
		const nmVal = nm.value;
		const div = document.createElement('div');
		div.classList.add('nm-msg');
		if(nmRegExp.test(nmVal)) {
			checkObj.nm = true;
			console.log("true");
		} else {
			checkObj.nm = false;
			div.innerHTML = `
				<strong>이름은 한글 2~5자로 작성해주세요.</strong>
			`;
		}
		nm.after(div);
	});
	
	// ID
	id.addEventListener('keyup', () => {
		const isMsg = document.querySelector('.id-msg');
		if(isMsg) {
			isMsg.remove();
		}
		const idVal = id.value;
		const div = document.createElement('div');
		div.classList.add('id-msg');
		if(!idRegExp.test(idVal)) {
			checkObj.cid = false;
			div.innerHTML = `
				<strong>영어, 숫자 5~20자 이내로 작성해주세요.</strong>
			`;
		} else {
			checkObj.cid = true;
			div.innerHTML =`
				<strong>사용할 수 있는 아이디입니다.</strong>
			`;
		}
		id.after(div);
	});
	idCheckBtn.addEventListener('click', () => {
		if(checkObj.cid) {
			const idVal = id.value;
			isId(idVal);
		} else {
			
		}
	});
	
	// Password
	showPw.addEventListener('click', () => {
		if(showPw.value == '보이기') {
			showPw.value = '숨기기';
			pw.type = 'text';
			pwCheck.type = 'text';
		} else {
			showPw.value= '보이기';
			pw.type = 'password';
			pwCheck.type = 'password';
		}
	});
	pwCheck.addEventListener('keyup', () => {
		const isMsg = document.querySelector('.pw-msg');
		if(isMsg) {
			isMsg.remove();
		}
		const div = document.createElement('div')
		div.classList.add('pw-msg');
		if(pw.value === pwCheck.value && pw.value.length > 0) {
			div.innerHTML = `
				<strong>비밀번호가 일치합니다.</strong>
			`;
			checkObj.pw = true;
		} else if(pw.value != pwCheck.value && pw.value.length > 0) {
			div.innerHTML = `
				<strong>비밀번호가 일치하지 않습니다.</strong>
			`;
			checkObj.pw = false;
		}
		pwCheck.after(div);
	});
	pwCheckBtn.addEventListener('click', () => {
		isPw();
	});
	pw.addEventListener('keyup', () => {
		
		if(pwRegExp.test(pw.value)) {
			checkObj.cid = true;
		} else {
			checkObj.cid = false;
		}
		if(checkObj.cid) {
			pwCheck.readOnly = false;
			pwCheck.classList.remove('disabled');
		} else {
			pwCheck.readOnly = true;
			pwCheck.classList.add('disabled');
			pwCheck.value = null;
		}
		
		const isMsg = document.querySelector('.pw-msg');
		if(isMsg) {
			isMsg.remove();
		}
		if(!pwRegExp.test(pw.value)) {
			const div = document.createElement('div');
			div.classList.add('pw-msg');
			div.innerHTML = `
				<strong>특수문자 ~!@#_, 문자, 숫자를 한개 이상 포함해서 6~20자로 작성해주세요.</strong>
			`;
			pw.after(div);
		}
	});
	
	// Email
	emailCheckBtn.addEventListener('click', () => {
		const checkNum = document.querySelector('.email-check').value;
		fetch(`/test/ajax/join/emailCheck.php?num=${checkNum}`)
			.then(res => res.json())
			.then(data => {
				console.log(data);
				if(data) {
					email.readOnly = true;
					emailCheck.readOnly = true;
					email.classList.add('disabled');
					emailCheck.classList.add('disabled');
					checkObj.email = true;
				}
			})
			.catch(e => {
				console.error(e);
			});
	});
	emailSendBtn.addEventListener('click', () => {
		const email = document.querySelector('.email');
		const emailVal = email.value;
		console.log(emailVal);
		fetch(`/test/ajax/join/emailSend.php?email=${emailVal}`)
			.then(res => res.json())
			.then(data => {
				if(data == 1) {
					email.classList.add('disabled');
					email.readOnly = true;
					emailCheck.classList.remove('dis-none');
					emailSendBtn.classList.add('dis-none');
					emailCheckBtn.classList.remove('dis-none');
				} else if(data == 0) {
					alert('가입된 이메일 존재');
				} else if (data == 2) {
					alrt('인증번호 발송 실패');
				}
			})
			.catch(e => {
				console.error(e);
			});
	});
	
	// Submit
	frm.addEventListener('submit', (e) => {
		e.preventDefault();
		isJoin();
	});
	
	// Method
	const isId = (idVal) => {
		fetch(`/test/ajax/join/id.php?id=${idVal}`)
			.then(res => res.json())
			.then(data => {
				const isMsg = document.querySelector('.id-msg');
				if(isMsg) {
					isMsg.remove();
				}
				
				
				if(data) {
					if(confirm("사용가능한 아이디입니다. 사용하시겠습니까?")) {
						checkObj.id = true;
						id.classList.add('disabled');
						id.readOnly = true;
					}
				} else {
					const div = document.createElement('div');
					div.classList.add('id-msg');
					div.innerHTML = `
						<strong>이미 존재하는 아이디입니다.</strong>
					`;
					checkObj.id = false;
					id.after(div);
				}
			})
			.catch(e => {
				console.error(e);
			});
	}
	
	const isPw = () => {
		const pwVal = pw.value;
		const pwCheckVal = pwCheck.value;
		
		if(pwVal === pwCheckVal && pwVal.length > 5) {
			checkObj.pw = true;
			pw.readOnly = true;
			pwCheck.readOnly = true;
			pw.classList.add('disabled');
			pwCheck.classList.add('disabled');
		} else {
			checkObj.pw = false;
			alert('비밀번호를 확인해주세요.');
		}
	}
	
	// 유효성 검사
	const valid = () => {
		let nm = document.querySelector("input[name='nm']").value;
		let id = document.querySelector("input[name='id']").value;
		let pw = document.querySelector('.pw').value;
		
		nm = nmRegExp.test(nm) ? true : false;
		id = idRegExp.test(id) ? true : false;
		pw = pwRegExp.test(pw) ? true : false;
		
		if(nm && id && pw) {
			return true;
		} else {
			return false;
		}
	}
	
	const isJoin = () => {
		const keys = Object.keys(checkObj);
		
		let message = "";
		if(!checkObj.id) {
			message += "아이디";
		}
		if(!checkObj.pw) {
			if(message.length > 1) {
				message += ", ";
			}
			message += "비밀번호";
		}
		if(!checkObj.email) {
			if(message.length > 1) {
				message += ", ";
			}
			message += "이메일";
		}
		if(!checkObj.nm) {
			if(message.length > 1) {
				message += ", ";
			}
			message += "이름"
		}
		
		if(checkObj.id && checkObj.pw && checkObj.email && valid()) {
			frm.submit();
		} else {
			alert(message + " 확인을 해주세요");
		}
	}
}