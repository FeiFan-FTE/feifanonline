$.fn.drag = function(options) {
    var x, drag = this, isMove = false, defaults = {
    };
    var options = $.extend(defaults, options);
    var handler = drag.find('.handler');
    var drag_bg = drag.find('.drag_bg');
    var text = drag.find('.drag_text');
    var maxWidth = drag.width() - handler.width();  //能滑动的最大间距

    //触摸屏幕时候的x轴的位置
    handler.on('touchstart',function(e) {
        e.preventDefault();
        isMove = true;
        var _touch = e.originalEvent.targetTouches[0];// 把元素放在手指所在的位置
        x = _touch.pageX - parseInt(handler.css('left'), 10);

    })
    //滑块在移动时，移动距离大于0小于最大间距，滑块x轴位置等于滑块移动距离
    .on('touchmove',function(e) {
            e.preventDefault();
            var _touch = e.originalEvent.changedTouches[0];
            var _x = _touch.pageX - x;// _x = e.pageX - (e.pageX - parseInt(handler.css('left'), 10)) = x
            if (isMove) {
            if (_x > 0 && _x <= maxWidth) {
                handler.css({'left': _x});
                drag_bg.css({'width': _x});
            } else if (_x > maxWidth) {  //鼠标指针移动距离达到最大时清空事件
                dragOk();
            }
        }
    })
    //离开触摸屏幕时，判断位置
    .on('touchend', function(e) {
            e.preventDefault();
            isMove = false;
            var _touch = e.originalEvent.changedTouches[0];
            var _x = _touch.pageX - x;
            if (_x < maxWidth) { //松开滑块时，如果没有达到最大距离位置，滑块就返回初始位置
            handler.css({'left': 0});
            drag_bg.css({'width': 0});
        }
    });

    //清空事件
    function dragOk() {
        handler.removeClass('handler_bg').addClass('handler_ok_bg');
        text.removeClass('slidetounlock').text('验证通过').css({'color':'#fff'});       //modify
        // drag.css({'color': '#fff !important'});

        handler.css({'left': maxWidth});                   // add
        drag_bg.css({'width': maxWidth});                  // add

        //注意取消绑定的事件
        handler.off('touchstart');
        handler.off('touchmove');
        handler.off('touchend');
    }
};    
