const url = new URL(location.href);
const iboard= url.searchParams.get('iboard');
const iuser = document.querySelector('#iuser').dataset.iuser;

const commentWrite = document.querySelector('.comment-write');
if(commentWrite) {
	commentWrite.addEventListener('submit', (e) => {
		e.preventDefault();
		const commentCtnt = commentWrite.querySelector("textarea[name='content']").value;
		if(commentCtnt.length < 1) {
			alert('한 글자 이상 작성해주세요.');
			return;
		}
		if(commentCtnt.length > 100) {
			alert('100글자 이내로 작성해주세요.');
			return;
		}
		commentWrite.submit();
	});
}

const like = document.querySelector('.like');
if(like) {
	like.addEventListener('click', () => {
		const iboard = document.querySelector('#iboard').dataset.iboard;
		const iuser= document.querySelector('#iuser').dataset.iuser;
		
		fetch(`/test/ajax/board/like.php?iboard=${iboard}&iuser=${iuser}`)
			.then(res => res.json())
			.then(data => {
				
			})
			.catch(e => {
				console.error(e);
			});
		
		if(like.classList.contains("fa-regular")) {
			like.classList.replace("fa-regular", "fa-solid");
		} else {
			like.classList.replace("fa-solid", "fa-regular");
		}
	});
}

const cmtPagination = document.querySelector('.comment-pagination');
if(cmtPagination) {
	let rowCnt = 5;
	let pageCnt = 5;
	let currentPage = 1;
	
	let totalPage = 0;
	let lastPage = Math.ceil(currentPage / pageCnt) * pageCnt;
	let startPage = lastPage == pageCnt ? 1 : (lastPage - pageCnt) + 1;
	let maxPage = lastPage >= totalPage ? totalPage : lastPage;
	
	let iboard = new URL(location.href).searchParams.get('iboard');
	
	const commentNext = document.querySelector('.comment-next');
	const commentPrev = document.querySelector('.comment-prev');
	
	const makeReplyForm = (mod) => {
		const div = document.createElement('div');
		div.classList.add('reply-write');
		div.innerHTML = `
			<div>
				<i class="fa-solid fa-right-long"></i>
			</div>
			<div>
				<textarea class="reply-content"></textarea>
				<button class="btn btn-secondary reply-submit">답변달기</button>
			</div>
		`;
		
		const replyContent = div.querySelector('.reply-content');
		if(mod) {
			replyContent.value = mod;
		}
		
		
		return div;
	}
	
	const commentDel = (icmt, elem) => {
		fetch(`/test/ajax/board/comment/del.php?icmt=${icmt}`)
			.then(res => res.json())
			.then(data => {
				if(data == 1) {
					elem.remove();
				}
			})
			.catch(e => {  
				console.error(e);
			});
	}
	
	const writeReply = (obj, elem) => {
		fetch('/test/ajax/board/comment/reply.php', {
			method : 'post',
			headers : {'Content-Type' : 'application/json'},
			body : JSON.stringify(obj)
		})
			.then(res => res.json(obj))
			.then(data => {
				if(!Object.keys(obj).includes('icmt')) {
					if(data[0].result == 1) {
						
						replySuccess(data[0]);
						elem.style.borderBottom = '1px solid grey';
					}
				} else {
					const ctnt = elem.querySelector('.comment-ctnt');
					replySuccess(data[0], ctnt);
					elem.style.borderBottom = '1px solid grey';
				}
			})
			.catch(e => {
				console.error(e);
			});
	}
	
	const commentMod = (icmt, elem) => {
		const commentCtnt = elem.querySelector('.comment-ctnt');		
		const isElem = document.querySelector('.reply-write');
		if(!isElem) {
			elem.after(makeReplyForm(commentCtnt.innerText));
			elem.style.borderBottom = 'none';
			
			const btn = document.querySelector('.reply-submit');
			btn.addEventListener('click', () => {
				const writeElem = document.querySelector('.reply-write');
				const ctnt = writeElem.querySelector('.reply-content').value;
				const obj = {
					reply : icmt,
					content : ctnt,
					iboard : iboard,
					icmt : icmt
				}
				writeReply(obj, elem);
			});
		} else {
			isElem.remove();
			elem.style.borderBottom = '1px solid grey';
		}
	}
	
	const makeReplyElem = (obj) => {
		const div = document.createElement('div');
		div.classList.add('comment-content');
		div.classList.add('comment-reply');
		div.innerHTML = `
			<div>
				<i class="fa-solid fa-right-long"></i>
				<span>${obj.nm}</span>
			</div>
			<div class="comment-ctnt-wrap">
				<span class="comment-secret"></span>
				<span class="comment-ctnt">${obj.content}</span>
			</div>
			<div>${obj.rdt}</div>
			<div class="comment-menu"></div>
			<div class="user-data" data-iuser="${obj.iuser}"></div>
		`;
		
		
		
		if(iuser == obj.iuser) {
			const commentMenu = div.querySelector('.comment-menu');
			commentMenu.innerHTML = `
				<span class="comment-mod">수정</span>
				<span class="comment-del">삭제</span>
			`;
			
			const mod = commentMenu.querySelector('.comment-mod');
			mod.addEventListener('click', () => {
				commentMod(obj.icmt, div);
			});
			
			const del = commentMenu.querySelector('.comment-del');
			del.addEventListener('click', () => {
				if(!confirm('정말로 삭제하시겠습니까?')) {
					return;
				}
				commentDel(obj.icmt, div);
			});
		}
		return div;
	}
	
	const makeCommentElem = (obj) => {
		const div = document.createElement('div');
		div.classList.add('comment-content');
		div.innerHTML = `
			<div>
				<span>${obj.nm}</span>
			</div>
			<div class="comment-ctnt-wrap">
				<span class="secret-status"></span>
				<span class="comment-ctnt">${obj.content}</span>
			</div>
			<div>${obj.rdt}</div>
			<div class="comment-menu"></div>
			<div class="user-data" data-iuser="${obj.iuser}"></div>
		`;
		const ctnt = div.querySelector('.comment-ctnt');
		
		if(iuser == obj.iuser) {
			const commentMenu = div.querySelector('.comment-menu');
			commentMenu.innerHTML = `
				<span class="comment-mod">수정</span>
				<span class="comment-del del-all">삭제</span>
			`;
			
			const mod = commentMenu.querySelector('.comment-mod');
			mod.addEventListener('click', () => {
				commentMod(obj.icmt, div);
			});
			
			const del = commentMenu.querySelector('.comment-del');
			del.addEventListener('click', () => {
				if(!confirm('정말로 삭제하시겠습니까?')) {
					return;
				}
				
				commentDel(obj.icmt, div);
				
				if(del.classList.contains('del-all')) {
					location.reload();
				}
			});
		}
		
		return div;
	}

	const getList = () => {
		const startIdx = (currentPage - 1) * rowCnt;
		
		fetch(`/test/ajax/board/comment/getList.php?iboard=${iboard}&startIdx=${startIdx}&rowCnt=${rowCnt}`)
			.then(res => res.json())
			.then(data => {
				setList(data.result);
			})
			.catch(e => {
				console.error(e);
			});
	}
	
	const setReply = (list, elem) => {
		for(i=0; i<list.length; i++) {
			const result = list[i];
			const div = makeReplyElem(result);
			elem.after(div);
			//isReplyCheck(result.icmt, div);
		}
	}
	
	const isReplyCheck = (icmt, div) => {
		fetch(`/test/ajax/board/comment/replyCheck.php?icmt=${icmt}`)
			.then(res => res.json())
			.then(data => {
				if(data.result.length > 0) {
					setReply(data.result, div);
				}
			})
			.catch(e => {
				console.error(e);
			});
	}
	
	const setList = (list) => {
		const commentList = document.querySelector('.comment-list');
		commentList.innerHTML = null;
		if(list.length == 0) {
			const commentWriteWrap = document.querySelector('.comment-write-wrap');
			if(commentWriteWrap) {
				commentWriteWrap.style.borderBottom = 'none';
			}
			commentList.innerHTML = `
				<div style="text-align: center; padding: 10px;">
					<strong>댓글이 없습니다.</strong>
				</div>
			`;
		}
		
		for(i=0; i<list.length; i++) {
			const result = list[i];
			const div = makeCommentElem(result);
			
			commentList.appendChild(div);
			
			const commentIuser = div.querySelector('.user-data').dataset.iuser;
			
			
			const commentCtnt = div.querySelector('.comment-ctnt-wrap');
			if(iuser) {
				const replySpan = document.createElement('span');
				replySpan.classList.add('comment-reply-write-btn');
				replySpan.innerText = '답변';
				commentCtnt.appendChild(replySpan);
				replySpan.addEventListener('click', () => {
					const commentContent = replySpan.closest('.comment-content');
					const isElem = document.querySelector('.reply-write');
					if(isElem) { 
						isElem.remove(); 
						commentContent.style.borderBottom = '1px solid grey';
					} else {
						commentContent.style.borderBottom = 'none';
						const div = makeReplyForm();
						commentContent.after(div);
						
						const replySubmit = div.querySelector('.reply-submit');
						if(replySubmit) {
							replySubmit.addEventListener('click', () => {
								
								const ctnt = document.querySelector('.reply-content').value;
								if(ctnt.length < 1) {
									alert("asd");
									return;
								}
								const obj = {
									reply : result.icmt,
									content : ctnt,
									iboard : iboard
								}
								
								fetch('/test/ajax/board/comment/reply.php', {
									method : 'post',
									headers : {'Content-Type' : 'application/json'},
									body : JSON.stringify(obj)
								})
									.then(res => res.json(obj))
									.then(data => {
										if(data[0].result == 1) {
											replySuccess(data[0]);
											commentContent.style.borderBottom = '1px solid grey';
										}
									})
									.catch(e => {
										console.error(e);
									});
							});
						}
					}
				});
			}
			isReplyCheck(result.icmt, div);
		}
	}
	
	const replySuccess = (obj, modElem) => {
		const replyWrite = document.querySelector('.reply-write');
		if(modElem) {
			modElem.innerText = obj.content;
		} else {
			const div = makeReplyElem(obj);
			replyWrite.after(div);
		}
		replyWrite.remove();
	}
	
	const getTotalPage = () => {
		fetch(`/test/ajax/board/comment/totalPage.php?iboard=${iboard}&rowCnt=${rowCnt}`)
			.then(res => res.json())
			.then(data => {
				makePage(data);
			})
			.catch(e => {
				console.error(e);
			});
	}
	
	const makePage = (data) => {
		const pageList = document.querySelector('.page-list');
		pageList.innerHTML = null;
		
		totalPage = data;
		lastPage = Math.ceil(currentPage / pageCnt) * pageCnt;
		startPage = lastPage == pageCnt ? 1 : (lastPage - pageCnt) + 1;
		maxPage = lastPage >= totalPage ? totalPage : lastPage;
		
		for(i=startPage; i<=maxPage; i++) {
			const num = i;
			const li = document.createElement('li');
			li.classList.add('page-item');
			li.classList.add('cur-pointer');
			const a = document.createElement('a');
			li.appendChild(a);
			a.classList.add('page-link');
			a.innerText = num;
			pageList.appendChild(li);
			
			if(currentPage == num) {
				li.classList.add('disabled');
				li.classList.replace('cur-pointer', 'cur-default');
				
			}
			if(currentPage != num) {
				li.addEventListener('click', () => {
					currentPage = num;
					makePage(totalPage);
					getList();
				});
			}
		}
		if(startPage <= 1) {
			commentPrev.classList.add('disabled');
			commentNext.classList.remove('disabled');
		}
		if(totalPage <= maxPage) {
			commentNext.classList.add('disabled');
			commentPrev.classList.remove('disabled');
		}
		if(startPage == 1 && totalPage <= maxPage) {
			commentNext.classList.add('disabled');
			commentPrev.classList.add('disabled');
		}
		if(startPage > 1 && totalPage > maxPage) {
			commentNext.classList.remove('disabled');
			commentPrev.classList.remove('disabled');
		}
	}
	
	commentNext.addEventListener('click', () => {
		if(totalPage > lastPage) {
			currentPage = lastPage + 1;
			makePage(totalPage);
			getList();
		}
	});
	
	commentPrev.addEventListener('click', () => {
		if(startPage > 1) {
			currentPage = startPage - 1;
			makePage(totalPage);
			getList();
		}
	});
	
	getTotalPage();
	getList();
}