//手机端响应式设计rem
(function(doc,win){
    var docEl = doc.documentElement,
            resizeEvt = "orientationchange" in window ? "orientationchange" : "resize",
            recalc = function() {
                var clientWidth = docEl.clientWidth;
                if(!clientWidth)return;
                if( clientWidth >= 640 ){
                    var clientWidth = 640;
                }
                docEl.style.fontSize = clientWidth/20 + "px";
                //alert(docEl.style.fontSize);
            };
    if(!doc.addEventListener)return;

    win.addEventListener(resizeEvt,recalc,false);
    doc.addEventListener("DOMContentLoaded",recalc,false);
})(document,window);
