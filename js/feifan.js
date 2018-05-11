function getByClass(oParent, sClass) {
	var aEle = oParent.getElementsByTagName('*');
	var aResult = [];

	for(var i = 0; i < aEle.length; i++) {
		if(aEle[i].className == sClass) {
			aResult.push(aEle[i]);
		}
	}

	return aResult;
}

window.onload = function() {
	var oDiv = document.getElementById('playimages');
	var oBtnPrev = getByClass(oDiv, 'prev')[0];
	var oBtnNext = getByClass(oDiv, 'next')[0];
	var oMarkLeft = getByClass(oDiv, 'mark_left')[0];
	var oMarkRight = getByClass(oDiv, 'mark_right')[0];

	var oDivSmall = getByClass(oDiv, 'small_pic')[0];
	var oUlSmall = oDivSmall.getElementsByTagName('ul')[0];
	var aLiSmall = oDivSmall.getElementsByTagName('li');

	var oUlBig = getByClass(oDiv, 'big_pic')[0];
	var aLiBig = oUlBig.getElementsByTagName('li');

	var nowZIndex = 1;

	var now = 0;
	console.log('fff'++aLiSmall[0].offsetWidth);
	oUlSmall.style.width = aLiSmall.length * aLiSmall[0].offsetWidth + 'px';

	//左右按钮
	oBtnPrev.onmouseover = oMarkLeft.onmouseover = function() {
		startMove(oBtnPrev, 'opacity', 100);
	};
	oBtnPrev.onmouseout = oMarkLeft.onmouseout = function() {
		startMove(oBtnPrev, 'opacity', 0);
	};
	oBtnNext.onmouseover = oMarkRight.onmouseover = function() {
		startMove(oBtnNext, 'opacity', 100);
	};
	oBtnNext.onmouseout = oMarkRight.onmouseout = function() {
		startMove(oBtnNext, 'opacity', 0);
	};

	//大图切换
	for(var i = 0; i < aLiSmall.length; i++) {
		aLiSmall[i].index = i;
		aLiSmall[i].onclick = function() {
			if(this.index == now) return;

			now = this.index;

			tab();
		};

		aLiSmall[i].onmouseover = function() {
			startMove(this, 'opacity', 100);
		};
		aLiSmall[i].onmouseout = function() {
			if(this.index != now) {
				startMove(this, 'opacity', 60);
			}
		};
	}

	function tab() {
		aLiBig[now].style.zIndex = nowZIndex++;

		for(var i = 0; i < aLiSmall.length; i++) {
			startMove(aLiSmall[i], 'opacity', 60);
		}

		startMove(aLiSmall[now], 'opacity', 100);

		// 让图片从上到下播放
		aLiBig[now].style.height = 0;
		startMove(aLiBig[now], 'height', 450);

		if(now == 0) {
			startMove(oUlSmall, 'left', 0);
		} else if(now == aLiSmall.length - 1) {
			startMove(oUlSmall, 'left', -(now - 2) * aLiSmall[0].offsetWidth);
		} else {
			startMove(oUlSmall, 'left', -(now - 1) * aLiSmall[0].offsetWidth);
		}
	}

	oBtnPrev.onclick = function() {
		now--;
		if(now == -1) {
			now = aLiSmall.length - 1;
		}

		tab();
	};

	oBtnNext.onclick = function() {
		now++;
		if(now == aLiSmall.length) {
			now = 0;
		}

		tab();
	};

	// 开个定时器 自动播放
	var timer = setInterval(oBtnNext.onclick, 2000);

	oDiv.onmouseover = function() {
		clearInterval(timer);
	};
	oDiv.onmouseout = function() {
		timer = setInterval(oBtnNext.onclick, 2000);
	};
};