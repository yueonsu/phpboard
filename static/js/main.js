const clickToDetailPage = (iboard) => {
	location.href = `./detail.php?iboard=${iboard}`;
}

const noBoard = document.querySelector('.no-board');
if(noBoard) {
	noBoard.addEventListener('click', () => {
		location.href = './main.php';
	});
}