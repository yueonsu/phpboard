const writeFrm = document.querySelector('.writeFrm');
if(writeFrm) {
	writeFrm.addEventListener('submit', (e) => {
		const title = writeFrm.querySelector('.title').value;
		const content = writeFrm.querySelector('.ck-editor__editable').innerText;
		
		console.log(content);
		if(title.length < 1) {
			e.preventDefault();
			alert('제목을 입력해주세요');
		}
		if(content.length <= 1) {
			e.preventDefault();
			alert('내용을 입력해주세요');
		}
	});
}