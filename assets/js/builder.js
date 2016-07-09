/*! Bowser | Author: Dustin Diaz (https://github.com/ded/bowser) | License: MIT */
!function(e,t){typeof define=="function"?define(t):typeof module!="undefined"&&module.exports?module.exports.browser=t():this[e]=t()}("bowser",function(){function g(){return n?{name:"Internet Explorer",msie:t,version:e.match(/(msie |rv:)(\d+(\.\d+)?)/i)[2]}:l?{name:"Opera",opera:t,version:e.match(d)?e.match(d)[1]:e.match(/opr\/(\d+(\.\d+)?)/i)[1]}:r?{name:"Chrome",webkit:t,chrome:t,version:e.match(/(?:chrome|crios)\/(\d+(\.\d+)?)/i)[1]}:i?{name:"PhantomJS",webkit:t,phantom:t,version:e.match(/phantomjs\/(\d+(\.\d+)+)/i)[1]}:a?{name:"TouchPad",webkit:t,touchpad:t,version:e.match(/touchpad\/(\d+(\.\d+)?)/i)[1]}:o||u?(m={name:o?"iPhone":"iPad",webkit:t,mobile:t,ios:t,iphone:o,ipad:u},d.test(e)&&(m.version=e.match(d)[1]),m):f?{name:"Android",webkit:t,android:t,mobile:t,version:(e.match(d)||e.match(v))[1]}:s?{name:"Safari",webkit:t,safari:t,version:e.match(d)[1]}:h?(m={name:"Gecko",gecko:t,mozilla:t,version:e.match(v)[1]},c&&(m.name="Firefox",m.firefox=t),m):p?{name:"SeaMonkey",seamonkey:t,version:e.match(/seamonkey\/(\d+(\.\d+)?)/i)[1]}:{}}var e=navigator.userAgent,t=!0,n=/(msie|trident)/i.test(e),r=/chrome|crios/i.test(e),i=/phantom/i.test(e),s=/safari/i.test(e)&&!r&&!i,o=/iphone/i.test(e),u=/ipad/i.test(e),a=/touchpad/i.test(e),f=/android/i.test(e),l=/opera/i.test(e)||/opr/i.test(e),c=/firefox/i.test(e),h=/gecko\//i.test(e),p=/seamonkey\//i.test(e),d=/version\/(\d+(\.\d+)?)/i,v=/firefox\/(\d+(\.\d+)?)/i,m,y=g();return y.msie&&y.version>=8||y.chrome&&y.version>=10||y.firefox&&y.version>=4||y.safari&&y.version>=5||y.opera&&y.version>=10?y.a=t:y.msie&&y.version<8||y.chrome&&y.version<10||y.firefox&&y.version<4||y.safari&&y.version<5||y.opera&&y.version<10?y.c=t:y.x=t,y});
/*!
 * jScrollPane - v2.0.22 - 2015-04-25
 * http://jscrollpane.kelvinluck.com/
 *
 * Copyright (c) 2014 Kelvin Luck
 * Dual licensed under the MIT or GPL licenses.
 */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=a(require("jquery")):a(jQuery)}(function(a){a.fn.jScrollPane=function(b){function c(b,c){function d(c){var f,h,j,k,l,o,p=!1,q=!1;if(N=c,void 0===O)l=b.scrollTop(),o=b.scrollLeft(),b.css({overflow:"hidden",padding:0}),P=b.innerWidth()+ra,Q=b.innerHeight(),b.width(P),O=a('<div class="jspPane" />').css("padding",qa).append(b.children()),R=a('<div class="jspContainer" />').css({width:P+"px",height:Q+"px"}).append(O).appendTo(b);else{if(b.css("width",""),p=N.stickToBottom&&A(),q=N.stickToRight&&B(),k=b.innerWidth()+ra!=P||b.outerHeight()!=Q,k&&(P=b.innerWidth()+ra,Q=b.innerHeight(),R.css({width:P+"px",height:Q+"px"})),!k&&sa==S&&O.outerHeight()==T)return void b.width(P);sa=S,O.css("width",""),b.width(P),R.find(">.jspVerticalBar,>.jspHorizontalBar").remove().end()}O.css("overflow","auto"),S=c.contentWidth?c.contentWidth:O[0].scrollWidth,T=O[0].scrollHeight,O.css("overflow",""),U=S/P,V=T/Q,W=V>1,X=U>1,X||W?(b.addClass("jspScrollable"),f=N.maintainPosition&&($||ba),f&&(h=y(),j=z()),e(),g(),i(),f&&(w(q?S-P:h,!1),v(p?T-Q:j,!1)),F(),C(),L(),N.enableKeyboardNavigation&&H(),N.clickOnTrack&&m(),J(),N.hijackInternalLinks&&K()):(b.removeClass("jspScrollable"),O.css({top:0,left:0,width:R.width()-ra}),D(),G(),I(),n()),N.autoReinitialise&&!pa?pa=setInterval(function(){d(N)},N.autoReinitialiseDelay):!N.autoReinitialise&&pa&&clearInterval(pa),l&&b.scrollTop(0)&&v(l,!1),o&&b.scrollLeft(0)&&w(o,!1),b.trigger("jsp-initialised",[X||W])}function e(){W&&(R.append(a('<div class="jspVerticalBar" />').append(a('<div class="jspCap jspCapTop" />'),a('<div class="jspTrack" />').append(a('<div class="jspDrag" />').append(a('<div class="jspDragTop" />'),a('<div class="jspDragBottom" />'))),a('<div class="jspCap jspCapBottom" />'))),ca=R.find(">.jspVerticalBar"),da=ca.find(">.jspTrack"),Y=da.find(">.jspDrag"),N.showArrows&&(ha=a('<a class="jspArrow jspArrowUp" />').bind("mousedown.jsp",k(0,-1)).bind("click.jsp",E),ia=a('<a class="jspArrow jspArrowDown" />').bind("mousedown.jsp",k(0,1)).bind("click.jsp",E),N.arrowScrollOnHover&&(ha.bind("mouseover.jsp",k(0,-1,ha)),ia.bind("mouseover.jsp",k(0,1,ia))),j(da,N.verticalArrowPositions,ha,ia)),fa=Q,R.find(">.jspVerticalBar>.jspCap:visible,>.jspVerticalBar>.jspArrow").each(function(){fa-=a(this).outerHeight()}),Y.hover(function(){Y.addClass("jspHover")},function(){Y.removeClass("jspHover")}).bind("mousedown.jsp",function(b){a("html").bind("dragstart.jsp selectstart.jsp",E),Y.addClass("jspActive");var c=b.pageY-Y.position().top;return a("html").bind("mousemove.jsp",function(a){p(a.pageY-c,!1)}).bind("mouseup.jsp mouseleave.jsp",o),!1}),f())}function f(){da.height(fa+"px"),$=0,ea=N.verticalGutter+da.outerWidth(),O.width(P-ea-ra);try{0===ca.position().left&&O.css("margin-left",ea+"px")}catch(a){}}function g(){X&&(R.append(a('<div class="jspHorizontalBar" />').append(a('<div class="jspCap jspCapLeft" />'),a('<div class="jspTrack" />').append(a('<div class="jspDrag" />').append(a('<div class="jspDragLeft" />'),a('<div class="jspDragRight" />'))),a('<div class="jspCap jspCapRight" />'))),ja=R.find(">.jspHorizontalBar"),ka=ja.find(">.jspTrack"),_=ka.find(">.jspDrag"),N.showArrows&&(na=a('<a class="jspArrow jspArrowLeft" />').bind("mousedown.jsp",k(-1,0)).bind("click.jsp",E),oa=a('<a class="jspArrow jspArrowRight" />').bind("mousedown.jsp",k(1,0)).bind("click.jsp",E),N.arrowScrollOnHover&&(na.bind("mouseover.jsp",k(-1,0,na)),oa.bind("mouseover.jsp",k(1,0,oa))),j(ka,N.horizontalArrowPositions,na,oa)),_.hover(function(){_.addClass("jspHover")},function(){_.removeClass("jspHover")}).bind("mousedown.jsp",function(b){a("html").bind("dragstart.jsp selectstart.jsp",E),_.addClass("jspActive");var c=b.pageX-_.position().left;return a("html").bind("mousemove.jsp",function(a){r(a.pageX-c,!1)}).bind("mouseup.jsp mouseleave.jsp",o),!1}),la=R.innerWidth(),h())}function h(){R.find(">.jspHorizontalBar>.jspCap:visible,>.jspHorizontalBar>.jspArrow").each(function(){la-=a(this).outerWidth()}),ka.width(la+"px"),ba=0}function i(){if(X&&W){var b=ka.outerHeight(),c=da.outerWidth();fa-=b,a(ja).find(">.jspCap:visible,>.jspArrow").each(function(){la+=a(this).outerWidth()}),la-=c,Q-=c,P-=b,ka.parent().append(a('<div class="jspCorner" />').css("width",b+"px")),f(),h()}X&&O.width(R.outerWidth()-ra+"px"),T=O.outerHeight(),V=T/Q,X&&(ma=Math.ceil(1/U*la),ma>N.horizontalDragMaxWidth?ma=N.horizontalDragMaxWidth:ma<N.horizontalDragMinWidth&&(ma=N.horizontalDragMinWidth),_.width(ma+"px"),aa=la-ma,s(ba)),W&&(ga=Math.ceil(1/V*fa),ga>N.verticalDragMaxHeight?ga=N.verticalDragMaxHeight:ga<N.verticalDragMinHeight&&(ga=N.verticalDragMinHeight),Y.height(ga+"px"),Z=fa-ga,q($))}function j(a,b,c,d){var e,f="before",g="after";"os"==b&&(b=/Mac/.test(navigator.platform)?"after":"split"),b==f?g=b:b==g&&(f=b,e=c,c=d,d=e),a[f](c)[g](d)}function k(a,b,c){return function(){return l(a,b,this,c),this.blur(),!1}}function l(b,c,d,e){d=a(d).addClass("jspActive");var f,g,h=!0,i=function(){0!==b&&ta.scrollByX(b*N.arrowButtonSpeed),0!==c&&ta.scrollByY(c*N.arrowButtonSpeed),g=setTimeout(i,h?N.initialDelay:N.arrowRepeatFreq),h=!1};i(),f=e?"mouseout.jsp":"mouseup.jsp",e=e||a("html"),e.bind(f,function(){d.removeClass("jspActive"),g&&clearTimeout(g),g=null,e.unbind(f)})}function m(){n(),W&&da.bind("mousedown.jsp",function(b){if(void 0===b.originalTarget||b.originalTarget==b.currentTarget){var c,d=a(this),e=d.offset(),f=b.pageY-e.top-$,g=!0,h=function(){var a=d.offset(),e=b.pageY-a.top-ga/2,j=Q*N.scrollPagePercent,k=Z*j/(T-Q);if(0>f)$-k>e?ta.scrollByY(-j):p(e);else{if(!(f>0))return void i();e>$+k?ta.scrollByY(j):p(e)}c=setTimeout(h,g?N.initialDelay:N.trackClickRepeatFreq),g=!1},i=function(){c&&clearTimeout(c),c=null,a(document).unbind("mouseup.jsp",i)};return h(),a(document).bind("mouseup.jsp",i),!1}}),X&&ka.bind("mousedown.jsp",function(b){if(void 0===b.originalTarget||b.originalTarget==b.currentTarget){var c,d=a(this),e=d.offset(),f=b.pageX-e.left-ba,g=!0,h=function(){var a=d.offset(),e=b.pageX-a.left-ma/2,j=P*N.scrollPagePercent,k=aa*j/(S-P);if(0>f)ba-k>e?ta.scrollByX(-j):r(e);else{if(!(f>0))return void i();e>ba+k?ta.scrollByX(j):r(e)}c=setTimeout(h,g?N.initialDelay:N.trackClickRepeatFreq),g=!1},i=function(){c&&clearTimeout(c),c=null,a(document).unbind("mouseup.jsp",i)};return h(),a(document).bind("mouseup.jsp",i),!1}})}function n(){ka&&ka.unbind("mousedown.jsp"),da&&da.unbind("mousedown.jsp")}function o(){a("html").unbind("dragstart.jsp selectstart.jsp mousemove.jsp mouseup.jsp mouseleave.jsp"),Y&&Y.removeClass("jspActive"),_&&_.removeClass("jspActive")}function p(a,b){W&&(0>a?a=0:a>Z&&(a=Z),void 0===b&&(b=N.animateScroll),b?ta.animate(Y,"top",a,q):(Y.css("top",a),q(a)))}function q(a){void 0===a&&(a=Y.position().top),R.scrollTop(0),$=a||0;var c=0===$,d=$==Z,e=a/Z,f=-e*(T-Q);(ua!=c||wa!=d)&&(ua=c,wa=d,b.trigger("jsp-arrow-change",[ua,wa,va,xa])),t(c,d),O.css("top",f),b.trigger("jsp-scroll-y",[-f,c,d]).trigger("scroll")}function r(a,b){X&&(0>a?a=0:a>aa&&(a=aa),void 0===b&&(b=N.animateScroll),b?ta.animate(_,"left",a,s):(_.css("left",a),s(a)))}function s(a){void 0===a&&(a=_.position().left),R.scrollTop(0),ba=a||0;var c=0===ba,d=ba==aa,e=a/aa,f=-e*(S-P);(va!=c||xa!=d)&&(va=c,xa=d,b.trigger("jsp-arrow-change",[ua,wa,va,xa])),u(c,d),O.css("left",f),b.trigger("jsp-scroll-x",[-f,c,d]).trigger("scroll")}function t(a,b){N.showArrows&&(ha[a?"addClass":"removeClass"]("jspDisabled"),ia[b?"addClass":"removeClass"]("jspDisabled"))}function u(a,b){N.showArrows&&(na[a?"addClass":"removeClass"]("jspDisabled"),oa[b?"addClass":"removeClass"]("jspDisabled"))}function v(a,b){var c=a/(T-Q);p(c*Z,b)}function w(a,b){var c=a/(S-P);r(c*aa,b)}function x(b,c,d){var e,f,g,h,i,j,k,l,m,n=0,o=0;try{e=a(b)}catch(p){return}for(f=e.outerHeight(),g=e.outerWidth(),R.scrollTop(0),R.scrollLeft(0);!e.is(".jspPane");)if(n+=e.position().top,o+=e.position().left,e=e.offsetParent(),/^body|html$/i.test(e[0].nodeName))return;h=z(),j=h+Q,h>n||c?l=n-N.horizontalGutter:n+f>j&&(l=n-Q+f+N.horizontalGutter),isNaN(l)||v(l,d),i=y(),k=i+P,i>o||c?m=o-N.horizontalGutter:o+g>k&&(m=o-P+g+N.horizontalGutter),isNaN(m)||w(m,d)}function y(){return-O.position().left}function z(){return-O.position().top}function A(){var a=T-Q;return a>20&&a-z()<10}function B(){var a=S-P;return a>20&&a-y()<10}function C(){R.unbind(za).bind(za,function(a,b,c,d){ba||(ba=0),$||($=0);var e=ba,f=$,g=a.deltaFactor||N.mouseWheelSpeed;return ta.scrollBy(c*g,-d*g,!1),e==ba&&f==$})}function D(){R.unbind(za)}function E(){return!1}function F(){O.find(":input,a").unbind("focus.jsp").bind("focus.jsp",function(a){x(a.target,!1)})}function G(){O.find(":input,a").unbind("focus.jsp")}function H(){function c(){var a=ba,b=$;switch(d){case 40:ta.scrollByY(N.keyboardSpeed,!1);break;case 38:ta.scrollByY(-N.keyboardSpeed,!1);break;case 34:case 32:ta.scrollByY(Q*N.scrollPagePercent,!1);break;case 33:ta.scrollByY(-Q*N.scrollPagePercent,!1);break;case 39:ta.scrollByX(N.keyboardSpeed,!1);break;case 37:ta.scrollByX(-N.keyboardSpeed,!1)}return e=a!=ba||b!=$}var d,e,f=[];X&&f.push(ja[0]),W&&f.push(ca[0]),O.bind("focus.jsp",function(){b.focus()}),b.attr("tabindex",0).unbind("keydown.jsp keypress.jsp").bind("keydown.jsp",function(b){if(b.target===this||f.length&&a(b.target).closest(f).length){var g=ba,h=$;switch(b.keyCode){case 40:case 38:case 34:case 32:case 33:case 39:case 37:d=b.keyCode,c();break;case 35:v(T-Q),d=null;break;case 36:v(0),d=null}return e=b.keyCode==d&&g!=ba||h!=$,!e}}).bind("keypress.jsp",function(a){return a.keyCode==d&&c(),!e}),N.hideFocus?(b.css("outline","none"),"hideFocus"in R[0]&&b.attr("hideFocus",!0)):(b.css("outline",""),"hideFocus"in R[0]&&b.attr("hideFocus",!1))}function I(){b.attr("tabindex","-1").removeAttr("tabindex").unbind("keydown.jsp keypress.jsp"),O.unbind(".jsp")}function J(){if(location.hash&&location.hash.length>1){var b,c,d=escape(location.hash.substr(1));try{b=a("#"+d+', a[name="'+d+'"]')}catch(e){return}b.length&&O.find(d)&&(0===R.scrollTop()?c=setInterval(function(){R.scrollTop()>0&&(x(b,!0),a(document).scrollTop(R.position().top),clearInterval(c))},50):(x(b,!0),a(document).scrollTop(R.position().top)))}}function K(){a(document.body).data("jspHijack")||(a(document.body).data("jspHijack",!0),a(document.body).delegate("a[href*=#]","click",function(b){var c,d,e,f,g,h,i=this.href.substr(0,this.href.indexOf("#")),j=location.href;if(-1!==location.href.indexOf("#")&&(j=location.href.substr(0,location.href.indexOf("#"))),i===j){c=escape(this.href.substr(this.href.indexOf("#")+1));try{d=a("#"+c+', a[name="'+c+'"]')}catch(k){return}d.length&&(e=d.closest(".jspScrollable"),f=e.data("jsp"),f.scrollToElement(d,!0),e[0].scrollIntoView&&(g=a(window).scrollTop(),h=d.offset().top,(g>h||h>g+a(window).height())&&e[0].scrollIntoView()),b.preventDefault())}}))}function L(){var a,b,c,d,e,f=!1;R.unbind("touchstart.jsp touchmove.jsp touchend.jsp click.jsp-touchclick").bind("touchstart.jsp",function(g){var h=g.originalEvent.touches[0];a=y(),b=z(),c=h.pageX,d=h.pageY,e=!1,f=!0}).bind("touchmove.jsp",function(g){if(f){var h=g.originalEvent.touches[0],i=ba,j=$;return ta.scrollTo(a+c-h.pageX,b+d-h.pageY),e=e||Math.abs(c-h.pageX)>5||Math.abs(d-h.pageY)>5,i==ba&&j==$}}).bind("touchend.jsp",function(a){f=!1}).bind("click.jsp-touchclick",function(a){return e?(e=!1,!1):void 0})}function M(){var a=z(),c=y();b.removeClass("jspScrollable").unbind(".jsp"),O.unbind(".jsp"),b.replaceWith(ya.append(O.children())),ya.scrollTop(a),ya.scrollLeft(c),pa&&clearInterval(pa)}var N,O,P,Q,R,S,T,U,V,W,X,Y,Z,$,_,aa,ba,ca,da,ea,fa,ga,ha,ia,ja,ka,la,ma,na,oa,pa,qa,ra,sa,ta=this,ua=!0,va=!0,wa=!1,xa=!1,ya=b.clone(!1,!1).empty(),za=a.fn.mwheelIntent?"mwheelIntent.jsp":"mousewheel.jsp";"border-box"===b.css("box-sizing")?(qa=0,ra=0):(qa=b.css("paddingTop")+" "+b.css("paddingRight")+" "+b.css("paddingBottom")+" "+b.css("paddingLeft"),ra=(parseInt(b.css("paddingLeft"),10)||0)+(parseInt(b.css("paddingRight"),10)||0)),a.extend(ta,{reinitialise:function(b){b=a.extend({},N,b),d(b)},scrollToElement:function(a,b,c){x(a,b,c)},scrollTo:function(a,b,c){w(a,c),v(b,c)},scrollToX:function(a,b){w(a,b)},scrollToY:function(a,b){v(a,b)},scrollToPercentX:function(a,b){w(a*(S-P),b)},scrollToPercentY:function(a,b){v(a*(T-Q),b)},scrollBy:function(a,b,c){ta.scrollByX(a,c),ta.scrollByY(b,c)},scrollByX:function(a,b){var c=y()+Math[0>a?"floor":"ceil"](a),d=c/(S-P);r(d*aa,b)},scrollByY:function(a,b){var c=z()+Math[0>a?"floor":"ceil"](a),d=c/(T-Q);p(d*Z,b)},positionDragX:function(a,b){r(a,b)},positionDragY:function(a,b){p(a,b)},animate:function(a,b,c,d){var e={};e[b]=c,a.animate(e,{duration:N.animateDuration,easing:N.animateEase,queue:!1,step:d})},getContentPositionX:function(){return y()},getContentPositionY:function(){return z()},getContentWidth:function(){return S},getContentHeight:function(){return T},getPercentScrolledX:function(){return y()/(S-P)},getPercentScrolledY:function(){return z()/(T-Q)},getIsScrollableH:function(){return X},getIsScrollableV:function(){return W},getContentPane:function(){return O},scrollToBottom:function(a){p(Z,a)},hijackInternalLinks:a.noop,destroy:function(){M()}}),d(c)}return b=a.extend({},a.fn.jScrollPane.defaults,b),a.each(["arrowButtonSpeed","trackClickSpeed","keyboardSpeed"],function(){b[this]=b[this]||b.speed}),this.each(function(){var d=a(this),e=d.data("jsp");e?e.reinitialise(b):(a("script",d).filter('[type="text/javascript"],:not([type])').remove(),e=new c(d,b),d.data("jsp",e))})},a.fn.jScrollPane.defaults={showArrows:!1,maintainPosition:!0,stickToBottom:!1,stickToRight:!1,clickOnTrack:!0,autoReinitialise:!1,autoReinitialiseDelay:500,verticalDragMinHeight:0,verticalDragMaxHeight:99999,horizontalDragMinWidth:0,horizontalDragMaxWidth:99999,contentWidth:void 0,animateScroll:!1,animateDuration:300,animateEase:"linear",hijackInternalLinks:!1,verticalGutter:4,horizontalGutter:4,mouseWheelSpeed:3,arrowButtonSpeed:0,arrowRepeatFreq:50,arrowScrollOnHover:!1,trackClickSpeed:0,trackClickRepeatFreq:70,verticalArrowPositions:"split",horizontalArrowPositions:"split",enableKeyboardNavigation:!0,hideFocus:!1,keyboardSpeed:0,initialDelay:300,speed:30,scrollPagePercent:.8}});
/*! jQuery Color v@2.1.2 http://github.com/jquery/jquery-color | jquery.org/license */
(function(a,b){function m(a,b,c){var d=h[b.type]||{};return a==null?c||!b.def?null:b.def:(a=d.floor?~~a:parseFloat(a),isNaN(a)?b.def:d.mod?(a+d.mod)%d.mod:0>a?0:d.max<a?d.max:a)}function n(b){var c=f(),d=c._rgba=[];return b=b.toLowerCase(),l(e,function(a,e){var f,h=e.re.exec(b),i=h&&e.parse(h),j=e.space||"rgba";if(i)return f=c[j](i),c[g[j].cache]=f[g[j].cache],d=c._rgba=f._rgba,!1}),d.length?(d.join()==="0,0,0,0"&&a.extend(d,k.transparent),c):k[b]}function o(a,b,c){return c=(c+1)%1,c*6<1?a+(b-a)*c*6:c*2<1?b:c*3<2?a+(b-a)*(2/3-c)*6:a}var c="backgroundColor borderBottomColor borderLeftColor borderRightColor borderTopColor color columnRuleColor outlineColor textDecorationColor textEmphasisColor",d=/^([\-+])=\s*(\d+\.?\d*)/,e=[{re:/rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,parse:function(a){return[a[1],a[2],a[3],a[4]]}},{re:/rgba?\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,parse:function(a){return[a[1]*2.55,a[2]*2.55,a[3]*2.55,a[4]]}},{re:/#([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})/,parse:function(a){return[parseInt(a[1],16),parseInt(a[2],16),parseInt(a[3],16)]}},{re:/#([a-f0-9])([a-f0-9])([a-f0-9])/,parse:function(a){return[parseInt(a[1]+a[1],16),parseInt(a[2]+a[2],16),parseInt(a[3]+a[3],16)]}},{re:/hsla?\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,space:"hsla",parse:function(a){return[a[1],a[2]/100,a[3]/100,a[4]]}}],f=a.Color=function(b,c,d,e){return new a.Color.fn.parse(b,c,d,e)},g={rgba:{props:{red:{idx:0,type:"byte"},green:{idx:1,type:"byte"},blue:{idx:2,type:"byte"}}},hsla:{props:{hue:{idx:0,type:"degrees"},saturation:{idx:1,type:"percent"},lightness:{idx:2,type:"percent"}}}},h={"byte":{floor:!0,max:255},percent:{max:1},degrees:{mod:360,floor:!0}},i=f.support={},j=a("<p>")[0],k,l=a.each;j.style.cssText="background-color:rgba(1,1,1,.5)",i.rgba=j.style.backgroundColor.indexOf("rgba")>-1,l(g,function(a,b){b.cache="_"+a,b.props.alpha={idx:3,type:"percent",def:1}}),f.fn=a.extend(f.prototype,{parse:function(c,d,e,h){if(c===b)return this._rgba=[null,null,null,null],this;if(c.jquery||c.nodeType)c=a(c).css(d),d=b;var i=this,j=a.type(c),o=this._rgba=[];d!==b&&(c=[c,d,e,h],j="array");if(j==="string")return this.parse(n(c)||k._default);if(j==="array")return l(g.rgba.props,function(a,b){o[b.idx]=m(c[b.idx],b)}),this;if(j==="object")return c instanceof f?l(g,function(a,b){c[b.cache]&&(i[b.cache]=c[b.cache].slice())}):l(g,function(b,d){var e=d.cache;l(d.props,function(a,b){if(!i[e]&&d.to){if(a==="alpha"||c[a]==null)return;i[e]=d.to(i._rgba)}i[e][b.idx]=m(c[a],b,!0)}),i[e]&&a.inArray(null,i[e].slice(0,3))<0&&(i[e][3]=1,d.from&&(i._rgba=d.from(i[e])))}),this},is:function(a){var b=f(a),c=!0,d=this;return l(g,function(a,e){var f,g=b[e.cache];return g&&(f=d[e.cache]||e.to&&e.to(d._rgba)||[],l(e.props,function(a,b){if(g[b.idx]!=null)return c=g[b.idx]===f[b.idx],c})),c}),c},_space:function(){var a=[],b=this;return l(g,function(c,d){b[d.cache]&&a.push(c)}),a.pop()},transition:function(a,b){var c=f(a),d=c._space(),e=g[d],i=this.alpha()===0?f("transparent"):this,j=i[e.cache]||e.to(i._rgba),k=j.slice();return c=c[e.cache],l(e.props,function(a,d){var e=d.idx,f=j[e],g=c[e],i=h[d.type]||{};if(g===null)return;f===null?k[e]=g:(i.mod&&(g-f>i.mod/2?f+=i.mod:f-g>i.mod/2&&(f-=i.mod)),k[e]=m((g-f)*b+f,d))}),this[d](k)},blend:function(b){if(this._rgba[3]===1)return this;var c=this._rgba.slice(),d=c.pop(),e=f(b)._rgba;return f(a.map(c,function(a,b){return(1-d)*e[b]+d*a}))},toRgbaString:function(){var b="rgba(",c=a.map(this._rgba,function(a,b){return a==null?b>2?1:0:a});return c[3]===1&&(c.pop(),b="rgb("),b+c.join()+")"},toHslaString:function(){var b="hsla(",c=a.map(this.hsla(),function(a,b){return a==null&&(a=b>2?1:0),b&&b<3&&(a=Math.round(a*100)+"%"),a});return c[3]===1&&(c.pop(),b="hsl("),b+c.join()+")"},toHexString:function(b){var c=this._rgba.slice(),d=c.pop();return b&&c.push(~~(d*255)),"#"+a.map(c,function(a){return a=(a||0).toString(16),a.length===1?"0"+a:a}).join("")},toString:function(){return this._rgba[3]===0?"transparent":this.toRgbaString()}}),f.fn.parse.prototype=f.fn,g.hsla.to=function(a){if(a[0]==null||a[1]==null||a[2]==null)return[null,null,null,a[3]];var b=a[0]/255,c=a[1]/255,d=a[2]/255,e=a[3],f=Math.max(b,c,d),g=Math.min(b,c,d),h=f-g,i=f+g,j=i*.5,k,l;return g===f?k=0:b===f?k=60*(c-d)/h+360:c===f?k=60*(d-b)/h+120:k=60*(b-c)/h+240,h===0?l=0:j<=.5?l=h/i:l=h/(2-i),[Math.round(k)%360,l,j,e==null?1:e]},g.hsla.from=function(a){if(a[0]==null||a[1]==null||a[2]==null)return[null,null,null,a[3]];var b=a[0]/360,c=a[1],d=a[2],e=a[3],f=d<=.5?d*(1+c):d+c-d*c,g=2*d-f;return[Math.round(o(g,f,b+1/3)*255),Math.round(o(g,f,b)*255),Math.round(o(g,f,b-1/3)*255),e]},l(g,function(c,e){var g=e.props,h=e.cache,i=e.to,j=e.from;f.fn[c]=function(c){i&&!this[h]&&(this[h]=i(this._rgba));if(c===b)return this[h].slice();var d,e=a.type(c),k=e==="array"||e==="object"?c:arguments,n=this[h].slice();return l(g,function(a,b){var c=k[e==="object"?a:b.idx];c==null&&(c=n[b.idx]),n[b.idx]=m(c,b)}),j?(d=f(j(n)),d[h]=n,d):f(n)},l(g,function(b,e){if(f.fn[b])return;f.fn[b]=function(f){var g=a.type(f),h=b==="alpha"?this._hsla?"hsla":"rgba":c,i=this[h](),j=i[e.idx],k;return g==="undefined"?j:(g==="function"&&(f=f.call(this,j),g=a.type(f)),f==null&&e.empty?this:(g==="string"&&(k=d.exec(f),k&&(f=j+parseFloat(k[2])*(k[1]==="+"?1:-1))),i[e.idx]=f,this[h](i)))}})}),f.hook=function(b){var c=b.split(" ");l(c,function(b,c){a.cssHooks[c]={set:function(b,d){var e,g,h="";if(d!=="transparent"&&(a.type(d)!=="string"||(e=n(d)))){d=f(e||d);if(!i.rgba&&d._rgba[3]!==1){g=c==="backgroundColor"?b.parentNode:b;while((h===""||h==="transparent")&&g&&g.style)try{h=a.css(g,"backgroundColor"),g=g.parentNode}catch(j){}d=d.blend(h&&h!=="transparent"?h:"_default")}d=d.toRgbaString()}try{b.style[c]=d}catch(j){}}},a.fx.step[c]=function(b){b.colorInit||(b.start=f(b.elem,c),b.end=f(b.end),b.colorInit=!0),a.cssHooks[c].set(b.elem,b.start.transition(b.end,b.pos))}})},f.hook(c),a.cssHooks.borderColor={expand:function(a){var b={};return l(["Top","Right","Bottom","Left"],function(c,d){b["border"+d+"Color"]=a}),b}},k=a.Color.names={aqua:"#00ffff",black:"#000000",blue:"#0000ff",fuchsia:"#ff00ff",gray:"#808080",green:"#008000",lime:"#00ff00",maroon:"#800000",navy:"#000080",olive:"#808000",purple:"#800080",red:"#ff0000",silver:"#c0c0c0",teal:"#008080",white:"#ffffff",yellow:"#ffff00",transparent:[null,null,null,0],_default:"#ffffff"}})(jQuery);
/**
 * Table Of Contents
 *
 * 1) = UI - GENERAL =
 * 2) = UI - SCROLLER =
 * 3) = UI - ANIMATIONS =
 * 4) = UI - MODAL =
 * 5) = UI - PROMPT MODAL =
 * 6) = ROWS/SECTIONS =
 * 7) = AREAS ( MODULE AREAS ) =
 * 8) = MODULES =
 * 9) = TEMPLATES =
 * 10) = CODE GENERATION =
 * 11) = MODULE PRESETS =
 * 12) = OTHER =
 */

"use strict";

var dslcRegularFontsArray = DSLCFonts.regular;
var dslcGoogleFontsArray = DSLCFonts.google;
var dslcAllFontsArray = dslcRegularFontsArray.concat( dslcGoogleFontsArray );

// Set current/default icons set
var dslcIconsCurrentSet = DSLCIcons.fontawesome;

var dslcDebug = false;

/*********************************
 *
 * 1) = UI - GENERAL =
 *
 * - dslc_hide_composer ( Hides the composer elements )
 * - dslc_show_composer ( Shows the composer elements )
 * - dslc_show_publish_button ( Shows the publish button )
 * - dslc_show_section ( Show a specific section )
 * - dslc_generate_filters ( Generate origin filters )
 * - dslc_filter_origin ( Origin filtering for templates/modules listing )
 * - dslc_drag_and_drop ( Initiate drag and drop functionality )
 ***********************************/

 	/**
 	 * UI - GENERAL - Hide Composer
 	 */

	function dslc_hide_composer() {

		if ( dslcDebug ) console.log( 'dslc_hide_composer' );

		// Hide "hide" button and show "show" button
		jQuery('.dslca-hide-composer-hook').hide();
		jQuery('.dslca-show-composer-hook').show();

		// Add class to know it's hidden
		jQuery('body').addClass('dslca-composer-hidden');

		// Hide ( animation ) the main composer area ( at the bottom )
		jQuery('.dslca-container').css({ bottom : jQuery('.dslca-container').outerHeight() * -1 });

		// Hide the header  part of the main composer area ( at the bottom )
		jQuery('.dslca-header').hide();

	}

	/**
	 * UI - GENERAL - Show Composer
	 */

	function dslc_show_composer() {

		if ( dslcDebug ) console.log( 'dslc_show_composer' );

		// Hide the "show" button and show the "hide" button
		jQuery('.dslca-show-composer-hook').hide();
		jQuery('.dslca-hide-composer-hook').show();

		// Remove the class from the body so we know it's not hidden
		jQuery('body').removeClass('dslca-composer-hidden');

		// Show ( animate ) the main composer area ( at the bottom )
		jQuery('.dslca-container').css({ bottom : 0 });

		// Show the header of the main composer area ( at the bottom )
		jQuery('.dslca-header').show();

	}

	/**
	 * UI - GENERAL - Show Publish Button
	 */

	function dslc_show_publish_button() {

		if ( dslcDebug ) console.log( 'dslc_show_publish_button' );

		jQuery('.dslca-save-composer').show().addClass('dslca-init-animation');
		jQuery('.dslca-save-draft-composer').show().addClass('dslca-init-animation');

	}

	/**
	 * UI - GENERAL - Show Section
	 */

	function dslc_show_section( section ) {

		if ( dslcDebug ) console.log( 'dslc_show_section' );

		// Add class to body so we know it's in progress
		jQuery('body').addClass('dslca-anim-in-progress');

		// Get vars
		var sectionTitle = jQuery(section).data('title'),
		newColor = jQuery(section).data('bg');
			
		// Hide ( animate ) the container
		jQuery('.dslca-container').css({ bottom: -500 });	

		// Change the section color
		jQuery('.dslca-sections').animate({ backgroundColor : newColor }, 200);

		// Hide all sections and show specific section
		jQuery('.dslca-section').hide();
		jQuery(section).show();

		// Initiate row scrollbar if editing ar row
		if ( section == '.dslca-modules-section-edit' ) { dslc_row_edit_scrollbar_init(); }

		// Change "currently editing"
		if ( section == '.dslca-module-edit' ) { 
			jQuery('.dslca-currently-editing')
				.show()
				.css( 'background-color', newColor )
					.find('strong')
					.text( jQuery('.dslca-module-being-edited').attr('title') + ' module' );
		} else if ( section == '.dslca-modules-section-edit' ) {
			jQuery('.dslca-currently-editing')
				.show()
				.css( 'background-color', '#e5855f' )
					.find('strong')
					.text( 'Row' );
		} else {
			jQuery('.dslca-currently-editing')
				.hide()
					.find('strong')
					.text('');
		}

		// Filter module option tabs
		dslc_module_options_tab_filter();

		// Initiate scroller ( if not module options edit section )
		if ( section != '.dslca-module-edit' ) { dslc_scroller_init(); }

		// Show ( animate ) the container
		setTimeout( function() {
			jQuery('.dslca-container').css({ bottom : 0 });
		}, 300 );

		// Remove class from body so we know it's finished
		jQuery('body').removeClass('dslca-anim-in-progress');

	}

	/**
	 * UI - GENERAL - Generate Origin Filters
	 */

	function dslc_generate_filters() {

		if ( dslcDebug ) console.log( 'dslc_generate_filters' );

		// Vars
		var el, filters = [], filtersHTML = '<span data-origin="">ALL</span>', els = jQuery('.dslca-section:visible .dslca-origin');	
			
		// Go through each and generate the filters
		els.each(function(){
			el = jQuery(this);
			if ( jQuery.inArray( el.data('origin'), filters ) == -1 ) {
				filters.push( el.data('origin') );
				filtersHTML += '<span data-origin="' + el.data('origin') + '">' + el.data('origin').replace( '_', ' ' ) + '</span>';
			}
		});

		jQuery('.dslca-section:visible .dslca-section-title-filter-options').html( filtersHTML ).css( 'background', jQuery('.dslca-section:visible').data('bg') );

	}

	/**
	 * UI - GENERAL - Origin Filter
	 */

	function dslc_filter_origin( origin, section ) {	

		if ( dslcDebug ) console.log( 'dslc_filter_origin' );

		jQuery('.dslca-origin', section).hide();
		jQuery('.dslca-origin[data-origin="' + origin + '"]', section).show();

		if ( origin == '' ) {
			jQuery('.dslca-origin', section).show();
		}

		dslc_scroller_init();

	}

	/**
	 * UI - General - Initiate Drag and Drop Functonality 
	 */

	function dslc_drag_and_drop() {

		if ( dslcDebug ) console.log( 'dslc_drag_and_drop' );

		var modulesSection, modulesArea, moduleID, moduleOutput;

		// Modules Listing
		jQuery( '.dslca-modules .dslca-module' ).draggable({
			scroll : false,
			appendTo: "body",
			helper: "clone",
			cursor: 'default',
			cursorAt: { top: 50, left: 30 },
			containment: 'body',
			start: function(e, ui){
				jQuery('body').removeClass('dslca-new-module-drag-not-in-progress').addClass('dslca-new-module-drag-in-progress');
				jQuery('#dslc-header').addClass('dslca-header-low-z-index');
			},
			stop: function(e, ui){
				jQuery('body').removeClass('dslca-new-module-drag-in-progress').addClass('dslca-new-module-drag-not-in-progress');
				jQuery('#dslc-header').removeClass('dslca-header-low-z-index');
			}
		});

		// Modules Sections
		jQuery( '.dslc-content' ).sortable({
			items: ".dslc-modules-section",
			handle: '.dslca-move-modules-section-hook:not(".dslca-action-disabled")',
			placeholder: 'dslca-modules-section-placeholder',
			tolerance : 'pointer',
			cursorAt: { bottom: 10 },
			axis: 'y',
			scroll: true, 
			scrollSensitivity: 200,
			scrollSpeed : 10,
			sort: function() {
				jQuery( this ).removeClass( "ui-state-default" );			
			},
			update: function (e, ui) {
				dslc_generate_code();
				dslc_show_publish_button();
			},
			start: function(e, ui){
				jQuery('body').removeClass('dslca-drag-not-in-progress').addClass('dslca-drag-in-progress');
				ui.placeholder.html('<span class="dslca-placeholder-help-text"><span class="dslca-placeholder-help-text-inner">' + DSLCString.str_row_helper_text + '</span></span>');
				jQuery( '.dslc-content' ).sortable( "refreshPositions" );
			},
			stop: function(e, ui){
				jQuery('body').removeClass('dslca-drag-in-progress').addClass('dslca-drag-not-in-progress');
				jQuery('.dslca-anim-opacity-drop').removeClass('dslca-anim-opacity-drop');
				jQuery('.dslc-modules-section').css({ overflow : 'visible', 'max-height' : 'none' });
			}
		});

		// Modules Areas
		jQuery( '.dslc-modules-section-inner' ).sortable({
			connectWith: '.dslc-modules-section-inner',
			items: ".dslc-modules-area",
			handle: '.dslca-move-modules-area-hook:not(".dslca-action-disabled")',
			placeholder: 'dslca-modules-area-placeholder',
			cursorAt: { top: 0, left: 0 },
			tolerance : 'intersect',
			scroll: true, 
			scrollSensitivity: 100,
			scrollSpeed : 15,
			sort: function() {
				jQuery( this ).removeClass( "ui-state-default" );
			},
			over: function (e, ui) {

				var dslcSection = ui.placeholder.closest('.dslc-modules-section');

				jQuery(dslcSection).removeClass('dslc-modules-section-empty').addClass('dslc-modules-section-not-empty');

				dslcSection.siblings('.dslc-modules-section').each( function(){
					if ( jQuery('.dslc-modules-area:not(.ui-sortable-helper)', jQuery(this)).length ) {
						jQuery(this).removeClass('dslc-modules-section-empty').addClass('dslc-modules-section-not-empty');
					} else {
						jQuery(this).removeClass('dslc-modules-section-not-empty').addClass('dslc-modules-section-empty');
					}
				});
				

			},			
			update: function (e, ui) {
				dslc_generate_code();
				dslc_show_publish_button();
			},
			start: function(e, ui){

				// Placeholder
				ui.placeholder.html('<span class="dslca-placeholder-help-text"><span class="dslca-placeholder-help-text-inner">' + DSLCString.str_area_helper_text + '</span></span>');
				if ( ! jQuery(ui.item).hasClass('dslc-12-col') ) {
					ui.placeholder.width(ui.item.width() - 10)
				} else {
					ui.placeholder.width(ui.item.width()).css({ margin : 0 });
				}

				// Add drag in progress class
				jQuery('body').removeClass('dslca-drag-not-in-progress').addClass('dslca-drag-in-progress dslca-modules-area-drag-in-progress');

				// Refresh positions
				jQuery( '.dslc-modules-section-inner' ).sortable( "refreshPositions" );

			},
			stop: function(e, ui){

				jQuery('body').removeClass('dslca-drag-in-progress dslca-modules-area-drag-in-progress').addClass('dslca-drag-not-in-progress');
				jQuery('.dslca-anim-opacity-drop').removeClass('dslca-anim-opacity-drop');

			},
			change: function( e, ui ) {

			}
		});

		jQuery( '.dslc-modules-section' ).droppable({
			drop: function( event, ui ) {
				var modulesSection = jQuery(this).find('.dslc-modules-section-inner');
				var moduleID = ui.draggable.data( 'id' );
				if ( moduleID == 'DSLC_M_A' ) { 
					dslc_modules_area_add( modulesSection );
				}
			}
		});

		jQuery( '.dslc-modules-area' ).droppable({
			activeClass: "dslca-ui-state-default",
			hoverClass: "dslca-ui-state-hover",
			accept: ":not(.ui-sortable-helper)",
			drop: function( event, ui ) {

				// Vars
				modulesArea = jQuery(this);
				moduleID = ui.draggable.data( 'id' );

				if ( moduleID == 'DSLC_M_A' || jQuery('body').hasClass('dslca-module-drop-in-progress') || modulesArea.closest('#dslc-header').length || modulesArea.closest('#dslc-footer').length ) { 
 
					// nothing

				} else {

					jQuery('body').addClass('dslca-anim-in-progress dslca-module-drop-in-progress');

					// Add padding to modules area
					if ( modulesArea.hasClass('dslc-modules-area-not-empty') )
						modulesArea.animate({ paddingBottom : 50 }, 150);

					// Load Output
					dslc_module_output_default( moduleID, function( response ){

						// Append Content
						moduleOutput = response.output;

						// Finish loading and show
						jQuery('.dslca-module-loading-inner', modulesArea).stop().animate({ width : '100%' }, 300, 'linear', function(){

							// Remove extra padding from area
							modulesArea.css({ paddingBottom : 0 });

							// Hide loader
							jQuery('.dslca-module-loading', modulesArea ).hide();

							// Add output
							var dslcJustAdded = jQuery(moduleOutput).appendTo(modulesArea);
							dslcJustAdded.css({
								'-webkit-animation-name' : 'dslcBounceIn',
								'-moz-animation-name' : 'dslcBounceIn',
								'animation-name' : 'dslcBounceIn',
								'animation-duration' : '0.6s',
								'-webkit-animation-duration' : '0.6s'
							});

							setTimeout( function(){
								dslc_init_square();
								dslc_center();
								dslc_masonry( dslcJustAdded );
								jQuery('body').removeClass('dslca-anim-in-progress dslca-module-drop-in-progress');
							}, 700 );

							// "Show" no content text
							jQuery('.dslca-no-content-primary', modulesArea ).css({ opacity : 1 });

							// "Show" modules area management
							jQuery('.dslca-modules-area-manage', modulesArea).css ({ visibility : 'visible' });

							// Show publish 
							jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'visible' });
							jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'visible' });

							// Generete
							dslc_carousel();
							dslc_tabs();
							dslc_init_accordion();
							dslc_init_square();
							dslc_center();
							dslc_generate_code();
							dslc_show_publish_button();

						});

					});

					/**
					 * Loading animation
					 */

					// Show loader
					jQuery('.dslca-module-loading', modulesArea).show();

					// Hide no content text
					jQuery('.dslca-no-content-primary', modulesArea).css({ opacity : 0 });

					// Hide modules area management
					jQuery('.dslca-modules-area-manage', modulesArea).css ({ visibility : 'hidden' });

					// Animate loading
					var randomLoadingTime = Math.floor(Math.random() * (100 - 50 + 1) + 50) * 100;
					jQuery('.dslca-module-loading-inner', modulesArea).css({ width : 0 }).animate({
						width : '100%'
					}, randomLoadingTime, 'linear' );

				}

			}
		}).sortable({
			connectWith: '.dslc-modules-area',
			items: ".dslc-module-front",
			handle: '.dslca-move-module-hook:not(".dslca-action-disabled")',
			placeholder: 'dslca-module-placeholder',
			cursorAt: { top: 50, left : 30 },
			tolerance : 'pointer',
			scroll: true, 
			scrollSensitivity: 100,
			scrollSpeed : 15,
			start: function(e, ui) {

				ui.placeholder.html('<span class="dslca-placeholder-help-text"><span class="dslca-placeholder-help-text-inner">' + ui.item.find('.dslc-sortable-helper-icon').data('title') + '</span></span>');
				
				if ( ! jQuery(ui.item).hasClass('dslc-12-col') ) {
					ui.placeholder.width(ui.item.width() - 10)
				} else {
					ui.placeholder.width(ui.item.width()).css({ margin : 0 });
				}
				
				jQuery('body').removeClass('dslca-drag-not-in-progress').addClass('dslca-drag-in-progress');

				if ( jQuery('.dslc-module-front', this).length < 2 ) {

					jQuery(this).removeClass('dslc-modules-area-not-empty').addClass('dslc-modules-area-empty');

					jQuery('.dslca-no-content:not(:visible)', this).show().css({
						'-webkit-animation-name' : 'dslcBounceIn',
						'-moz-animation-name' : 'dslcBounceIn',
						'animation-name' : 'dslcBounceIn',
						'animation-duration' : '0.6s',
						'-webkit-animation-duration' : '0.6s',
						padding : 0
					}).animate({ padding : '35px 0' }, 300, function(){
						
					});

				}

				jQuery( '.dslc-modules-area' ).sortable( "refreshPositions" );

			},
			sort: function(e, ui) {

				/* Gets added unintentionally by droppable interacting with sortable */
				jQuery( this ).removeClass( "ui-state-default" );	

			},
			update: function (e, ui) {
				dslc_show_publish_button();
			},
			stop: function(e, ui) {

				dslc_generate_code();
				jQuery('body').removeClass('dslca-drag-in-progress').addClass('dslca-drag-not-in-progress');
				jQuery('.dslca-anim-opacity-drop').removeClass('dslca-anim-opacity-drop');
				ui.item.trigger('mouseleave');

			},
			change: function( e, ui ) { }
		});

	}

	/**
	 * Deprecated Functions and Fallbacks
	 */

	function dslc_option_changed() { dslc_show_publish_button(); }
	function dslc_module_dragdrop_init() { dslc_drag_and_drop(); } 

	/**
	 * UI - GENERAL - Document Ready
	 */

	jQuery(document).ready(function($) {

		if ( ! jQuery('body').hasClass('rtl') ) {
			jQuery('.dslca-module-edit-options-inner').jScrollPane();
		}
		$('body').addClass('dslca-enabled dslca-drag-not-in-progress');
		$('.dslca-invisible-overlay').hide();
		$('.dslca-section').eq(0).show();
		dslc_drag_and_drop();
		dslc_generate_code();

		/**
		 * Action - "Currently Editing" scroll on click
		 */

		$(document).on( 'click', '.dslca-currently-editing', function(){

			var activeElement = false,
			newOffset = false,
			outlineColor;

			if ( $('.dslca-module-being-edited').length ) {
				activeElement = $('.dslca-module-being-edited');
				outlineColor = '#5890e5';
			} else if ( $('.dslca-modules-section-being-edited').length ) {
				activeElement = $('.dslca-modules-section-being-edited');
				outlineColor = '#eabba9';
			}

			if ( activeElement ) {
				newOffset = activeElement.offset().top - 100;
				if ( newOffset < 0 ) { newOffset = 0; }
				$( 'html, body' ).animate({ scrollTop: newOffset }, 300, function(){
					activeElement.animate( { 'outline-color' : outlineColor }, 70, function(){
						activeElement.animate({ 'outline-color' : 'transparent' }, 70, function(){
							activeElement.animate( { 'outline-color' : outlineColor }, 70, function(){
								activeElement.animate({ 'outline-color' : 'transparent' }, 70, function(){
									activeElement.removeAttr('style');
								});
							});
						});
					});
				});
			}

		});

		/**
		 * Hook - Hide Composer
		 */

		$(document).on( 'click', '.dslca-hide-composer-hook', function(){

			dslc_hide_composer()

		});

		/**
		 * Hook - Show Composer
		 */

		$(document).on( 'click', '.dslca-show-composer-hook', function(){

			dslc_show_composer();

		});

		/**
		 * Hook - Section Show - Modules Listing
		 */

		$(document).on( 'click', '.dslca-go-to-modules-hook', function(e){

			e.preventDefault();
			dslc_show_section( '.dslca-modules' );

		});	

		/**
		 * Hook - Section Show - Dynamic
		 */

		$(document).on( 'click', '.dslca-go-to-section-hook', function(e){

			e.preventDefault();

			var sectionTitle = $(this).data('section');
			dslc_show_section( sectionTitle );

			$(this).addClass('dslca-active').siblings('.dslca-go-to-section-hook').removeClass('dslca-active');

		});

		/**
		 * Hook - Close Composer
		 */

		$(document).on( 'click', '.dslca-close-composer-hook', function(e){

			e.preventDefault();
			if ( ! $('body').hasClass('dslca-saving-in-progress') ) {
				dslc_js_confirm( 'disable_lc', '<span class="dslca-prompt-modal-title">' + DSLCString.str_exit_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_exit_descr + '</span>', $(this).attr('href') );
			}

		});

		/**
		 * Submit Form
		 */

		$(document).on( 'click', '.dslca-submit', function(){

			jQuery(this).closest('form').submit();

		});

		/**
		 * Hook - Show Origin Filters
		 */

		$(document).on( 'click', '.dslca-section-title', function(e){

			e.stopPropagation();

			if ( $('.dslca-section-title-filter', this).length ) {
				dslc_generate_filters();
				$('.dslca-section-title-filter-options').slideToggle(300);
			}

		});

		/**
		 * Hook - Apply Filter Origin
		 */

		$(document).on( 'click', '.dslca-section-title-filter-options span', function(e){

			e.stopPropagation();

			var origin = $(this).data('origin');
			var section = $(this).closest('.dslca-section');

			if ( section.hasClass('dslca-templates-load') ) {
				$('.dslca-section-title-filter-curr', section).text( $(this).text() + ' TEMPLATES' );
			} else {
				$('.dslca-section-title-filter-curr', section).text( $(this).text() + ' MODULES' );
			}

			$('.dslca-section-scroller-inner').css({ left : 0 });

			dslc_filter_origin( origin, section );

		});

	});


/*********************************
 *
 * 2) = UI - SCROLLER =
 *
 * - dslc_scroller_init ( Initiate )
 * - dslc_scroller_go_to ( Scroll To Specific Item )
 * - dslc_scroller_prev ( Scroll Back )
 * - dslc_scroller_next ( Scroll Forward )
 *
 ***********************************/

 	/**
 	 * SCROLLER - Initiate
 	 */

 	function dslc_scroller_init() {

		if ( dslcDebug ) console.log( 'dslc_scroller_init' );

		// Vars
		var scrollers = jQuery('.dslca-section-scroller');

		// If scroller exists
		if ( scrollers.length ) {

			// For each scroller
			scrollers.each(function(){

				// Vars
				var scrollerItem,
				scroller = jQuery(this),
				scrollerInner = jQuery('.dslca-section-scroller-inner', scroller),
				scrollerInnerOffset = scrollerInner.position(),
				scrollerContent = jQuery('.dslca-section-scroller-content', scroller),
				scrollerItems = jQuery('.dslca-scroller-item:visible', scroller),
				startingWidth = 0,
				scrollerWidth = scroller.width() + scrollerInnerOffset.left * -1,
				scrollerContentWidth = scrollerContent.width();

				// Remove last item class
				jQuery('.dslca-section-scroller-item-last', scroller).removeClass('dslca-section-scroller-item-last');

				// Each scroller item
				scrollerItems.each(function(){

					// The item
					scrollerItem = jQuery(this);

					// Increment width ( for complete width of all )
					startingWidth += scrollerItem.outerWidth();                    

					// If current item makes the width count over the max visible
					if ( startingWidth > scrollerWidth ) {

						// If no last item set yet
						if ( jQuery('.dslca-section-scroller-item-last', scroller).length < 1 ) {

							// Set current item as last item
							scrollerItem.addClass('dslca-section-scroller-item-last');

							// Set previous item as the currently fully visible one
							scroller.data( 'current', scrollerItem.prev('.dslca-scroller-item:visible').index() );

						}

					}

				});

			});

		}

	}

	/**
	 * SCROLLER - Scroll To Specific Item 
	 */

	function dslc_scroller_go_to( scrollerItemIndex, scroller ) {

		if ( dslcDebug ) console.log( 'dslc_scroller_go_to' );

		// Vars
		var scrollerInner = jQuery('.dslca-section-scroller-inner', scroller),
		scrollerContent = jQuery('.dslca-section-scroller-content', scroller),
		scrollerItems = jQuery('.dslca-scroller-item', scroller),
		scrollerItem = jQuery('.dslca-scroller-item:eq(' + scrollerItemIndex + ')', scroller);

		// If the item exists
		if ( scrollerItem.length ) {

			// Vars
			var scrollerWidth = scroller.width(),
			scrollerContentWidth = scrollerContent.width(),
			scrollerItemOffset = scrollerItem.position();

			// Needed offset to item
			var scrollerNewOffset = ( scrollerWidth - ( scrollerItemOffset.left + scrollerItem.outerWidth() ) );

			// If offset not less than 0
			if ( scrollerNewOffset < 0 ) {

				// Update the current item
				scroller.data( 'current', scrollerItemIndex );

				// Animate to the offset
				scrollerInner.css({ left : scrollerNewOffset });

			// If offset less than 0
			} else { 

				// Animate to beggining
				scrollerInner.css({ left : 0 });

			}

		}

	}

	/**
	 * SCROLLER - Scroll Back
	 */

	function dslc_scroller_prev( scroller ) {

		if ( dslcDebug ) console.log( 'dslc_scroller_prev' );

		// Vars
		var scrollerCurr = scroller.data('current');

		// Two places before current
		var scrollerNew = scroller.find('.dslca-scroller-item:eq(' + scrollerCurr +  ')').prevAll('.dslca-scroller-item:visible').eq(1).index();

		// One place before current
		var scrollerNewAlt = scroller.find('.dslca-scroller-item:eq(' + scrollerCurr +  ')').prevAll('.dslca-scroller-item:visible').eq(0).index();

		// If two before current exists scroll to it
		if ( scrollerNew !== -1 ) {
			dslc_scroller_go_to( scrollerNew, scroller );
		// Otherwise if one before current exists scroll to it
		} else if ( scrollerNewAlt !== -1 ) {
			dslc_scroller_go_to( scrollerNewAlt, scroller );
		}

	}

	/**
	 * SCROLLER - Scroll Forward
	 */

	function dslc_scroller_next( scroller ) {

		if ( dslcDebug ) console.log( 'dslc_scroller_next' );

		// Vars
		var scrollerCurr = scroller.data('current');
		
		// Two places after current
		var scrollerNew = scroller.find('.dslca-scroller-item:eq(' + scrollerCurr +  ')').nextAll('.dslca-scroller-item:visible').eq(1).index();
		
		// One place after current
		var scrollerNewAlt = scroller.find('.dslca-scroller-item:eq(' + scrollerCurr +  ')').nextAll('.dslca-scroller-item:visible').eq(0).index();

		// If two places after current exists scroll to it
		if ( scrollerNew !== -1 )
			dslc_scroller_go_to( scrollerNew, scroller );
		// Otherwise if one place after current exists scroll to it
		else if ( scrollerNewAlt !== -1 )
			dslc_scroller_go_to( scrollerNewAlt, scroller );

	}

	/**
	 * SCROLLER - Document Ready
	 */

	jQuery(document).ready(function($){

		/**
		 * Hook - Scroller Prev
		 */

		$(document).on( 'click', '.dslca-section-scroller-prev', function(e){

			e.preventDefault();
			dslc_scroller_prev( $(this).closest('.dslca-section').find('.dslca-section-scroller') );

		});

		/**
		 * Hook - Scroller Next
		 */

		$(document).on( 'click', '.dslca-section-scroller-next', function(e){

			e.preventDefault();
			dslc_scroller_next( $(this).closest('.dslca-section').find('.dslca-section-scroller') );

		});
		
	});

	/**
	 * SCROLLER - Window Load
	 */

	jQuery(window).load(function(){

		// Initiate scroller
		dslc_scroller_init();

		// Initiate scroller on window resize
		jQuery(window).resize(function(){
			dslc_scroller_init();
		});

	});


/*********************************
 *
 * 3) = UI - ANIMATIONS =
 *
 * - dslc_ui_animations ( Animations for the UI )
 *
 ***********************************/

	/**
	 * ANIMATIONS - Initiate
	 */

	function dslc_ui_animations() {

		if ( dslcDebug ) console.log( 'dslc_ui_animations' );

		// Mouse Enter/Leave - Module

		jQuery(document).on( 'mouseenter', '.dslca-modules-area-manage', function(){

			jQuery(this).closest('.dslc-modules-area').addClass('dslca-options-hovered');

			dslca_draggable_calc_center( jQuery(this).closest('.dslc-modules-area') );

		}).on( 'mouseleave', '.dslca-modules-area-manage', function(){

			jQuery(this).closest('.dslc-modules-area').removeClass('dslca-options-hovered');

		});

		// Mouse Enter/Leave - Module

		jQuery(document).on( 'mouseenter', '.dslca-drag-not-in-progress .dslc-module-front', function(e){

			 if ( ! jQuery('body').hasClass('dslca-composer-hidden' ) ) {

				if ( jQuery(this).height() < 190 ) 
					jQuery('.dslca-module-manage', this).addClass('dslca-horizontal');
				else 
					jQuery('.dslca-module-manage', this).removeClass('dslca-horizontal');

			}

		}).on( 'mouseleave', '.dslca-drag-not-in-progress .dslc-module-front', function(e){

			if ( ! jQuery('body').hasClass('dslca-composer-hidden' ) ) {

				jQuery(this).find('.dslca-change-width-module-options').hide();

			}
			
			// Hide "width change opts" 
			jQuery(this).find('.dslca-module-manage').removeClass('dslca-module-manage-change-width-active');

		});

		// Mouse Enter/Leave - Modules Area

		jQuery(document).on( 'mouseenter', '.dslca-drag-not-in-progress .dslc-modules-area', function(e){

			var _this = jQuery(this);

			 if ( ! jQuery('body').hasClass('dslca-composer-hidden' ) ) {

			 	jQuery('#dslc-header').addClass('dslca-header-low-z-index');

				if ( jQuery(this).height() < 130 ) 
					jQuery('.dslca-modules-area-manage', this).addClass('dslca-horizontal');
				else 
					jQuery('.dslca-modules-area-manage', this).removeClass('dslca-horizontal');

			}

		}).on( 'mouseleave', '.dslca-drag-not-in-progress .dslc-modules-area', function(e){

			var _this = jQuery(this);

			if ( ! jQuery('body').hasClass('dslca-composer-hidden' ) ) {

				jQuery('#dslc-header').removeClass('dslca-header-low-z-index');

			}

		});	

	}

	/**
	 * ANIMATIONS - Document Ready
	 */

	jQuery(document).ready(function(){

		dslc_ui_animations();

	});


/*********************************
 *
 * 4) = UI - MODAL =
 * Note: Used only for the templates save/export/import at the moment.
 *
 * - dslc_show_modal ( Show Modal )
 * - dslc_hide_modal ( Hide Modal )
 *
 ***********************************/

 	/**
 	 * MODAL - Show
 	 */

 	function dslc_show_modal( hook, modal ) {

		if ( dslcDebug ) console.log( 'dslc_show_modal' );

		// If a modal already visibile hide it
		dslc_hide_modal( '', jQuery('.dslca-modal:visible') );

		// Vars
		var modal = jQuery(modal);

		// Vars ( Calc Offset )
		var position = jQuery(hook).position(),
		diff = modal.outerWidth() / 2 - hook.outerWidth() / 2,
		offset = position.left - diff;

		// Show Modal
		modal.css({ left : offset }).show();

		// Animate Modal
		modal.css({
			'-webkit-animation-name' : 'dslcBounceIn',
			'-moz-animation-name' : 'dslcBounceIn',
			'animation-name' : 'dslcBounceIn',
			'animation-duration' : '0.6s',
			'-webkit-animation-duration' : '0.6s'
		}).fadeIn(600);

	}

	/** 
	 * MODAL - Hide
	 */

	function dslc_hide_modal( hook, modal ) {

		if ( dslcDebug ) console.log( 'dslc_hide_modal' );

		// Vars
		var modal = jQuery(modal);

		// Hide ( with animation )
		modal.css({
			'-webkit-animation-name' : 'dslcBounceOut',
			'-moz-animation-name' : 'dslcBounceOut',
			'animation-name' : 'dslcBounceOut',
			'animation-duration' : '0.6s',
			'-webkit-animation-duration' : '0.6s'
		}).fadeOut(600);

	}

	/**
	 * MODAL - Document Ready
	 */

	jQuery(document).ready(function($){

		/**
		 * Hook - Show Modal
		 */

		$(document).on( 'click', '.dslca-open-modal-hook', function(){

			var modal = $(this).data('modal');
			dslc_show_modal( $(this), modal );

		});

		/**
		 * Hook - Hide Modal
		 */

		$(document).on( 'click', '.dslca-close-modal-hook', function(){

			if ( ! $(this).hasClass('dslca-action-disabled') ) {

				var modal = $(this).data('modal');
				dslc_hide_modal( $(this), modal );

			}

		});
		
	});


/*********************************
 *
 * 5) = UI - PROMPT MODAL =
 *
 * - dslc_js_confirm
 * - dslc_js_confirm_close
 *
 ***********************************/

 	function dslc_js_confirm( dslcID, dslcContent, dslcTarget ) {

		if ( dslcDebug ) console.log( 'dslc_js_confirm' );
		  
		// Add "active" class
		jQuery('.dslca-prompt-modal').addClass('dslca-prompt-modal-active');

		// Add the ID of current event
		jQuery('.dslca-prompt-modal').data( 'id', dslcID );
		jQuery('.dslca-prompt-modal').data( 'target', dslcTarget );

		// Add modal content
		jQuery('.dslca-prompt-modal-msg').html( dslcContent );

		// Show modal
		jQuery('.dslca-prompt-modal').css({ opacity : 0 }).show().animate({
			opacity : 1,
		}, 400);

		// Animate modal
		jQuery('.dslca-prompt-modal-content').css({ top : '55%' }).animate({
			top : '50%'
		}, 400);
		
	}

	function dslc_js_confirm_close() {

		if ( dslcDebug ) console.log( 'dslc_js_confirm_close' );

		// Remove "active" class
		jQuery('.dslca-prompt-modal').removeClass('dslca-prompt-modal-active');

		// Hide modal
		jQuery('.dslca-prompt-modal').animate({
			opacity : 0,
		}, 400, function(){
			jQuery(this).hide();
			jQuery('.dslca-prompt-modal-cancel-hook').show();
			jQuery('.dslca-prompt-modal-confirm-hook').html('<span class="dslc-icon dslc-icon-ok"></span>' + DSLCString.str_confirm);
		});

		jQuery('.dslca-prompt-modal-content').animate({
			top : '55%'
		}, 400);
		
	}

	/**
	 * UI - PROMPT MODAL - Document Ready
	 */

	jQuery(document).ready(function($){

		$(document).on( 'click', '.dslca-prompt-modal-cancel-hook', function(e){
		
			e.preventDefault();

			var dslcAction = jQuery('.dslca-prompt-modal').data('id');
			var dslcTarget = jQuery('.dslca-prompt-modal').data('target');

			if ( dslcAction == 'edit_in_progress' ) {

				dslc_module_options_cancel_changes( function(){
					dslcTarget.trigger('click');
				});

			} else if ( dslcAction == 'delete_module' ) {



			}

			dslc_js_confirm_close();
			jQuery('.dslca-prompt-modal').data( 'id', '' );

		});

		$(document).on( 'click', '.dslca-prompt-modal-confirm-hook', function(e){

			e.preventDefault();

			var dslcAction = jQuery('.dslca-prompt-modal').data('id');
			var dslcTarget = jQuery('.dslca-prompt-modal').data('target');
			var closeAtEnd = true;
			
			if (  dslcAction == 'edit_in_progress' ) {

				dslc_module_options_confirm_changes( function(){
					dslcTarget.trigger('click');
				});

			} else if ( dslcAction == 'disable_lc' ) {

				window.location = dslcTarget;

			} else if ( dslcAction == 'delete_module' ) {

				var module = dslcTarget.closest('.dslc-module-front');
				dslc_delete_module( module );

			} else if ( dslcAction == 'delete_modules_area' ) {

				var modulesArea = dslcTarget.closest('.dslc-modules-area');
				dslc_modules_area_delete( modulesArea );

			} else if ( dslcAction == 'delete_modules_section' ) {

				dslc_row_delete( dslcTarget.closest('.dslc-modules-section') );

			} else if ( dslcAction == 'export_modules_section' ) {

			} else if ( dslcAction == 'import_modules_section' ) {

				dslc_row_import( $('.dslca-prompt-modal textarea').val() );
				$('.dslca-prompt-modal-confirm-hook span').css({ opacity : 0 });
				$('.dslca-prompt-modal-confirm-hook .dslca-loading').show();
				closeAtEnd = false;

			}

			if ( closeAtEnd )
				dslc_js_confirm_close();

			jQuery('.dslca-prompt-modal').data( 'id', '' );

		});

		/**
		 * Hook - Confirm on Enter, Cancel on Esc
		 */

		$(window).on( 'keydown', function(e) {

			// Enter ( confirm )	
			if( e.which == 13 ) {
				if ( $('.dslca-prompt-modal-active').length ) {
					$('.dslca-prompt-modal-confirm-hook').trigger('click');
				}

			// Escape ( cancel )
			} else if ( e.which == 27 ) {
				if ( $('.dslca-prompt-modal-active').length ) {
					$('.dslca-prompt-modal-cancel-hook').trigger('click');
				}
			}

		});

	});


/*********************************
 *
 * 6) = ROWS/SECTIONS =
 *
 * - dslc_row_add ( Add New )
 * - dslc_row_delete ( Delete )
 * - dslc_row_edit ( Edit )
 * - dslc_row_edit_colorpicker_init ( Edit - Initiate Colorpicker )
 * - dslc_row_edit_slider_init ( Edit - Initiate Slider )
 * - dslc_row_edit_scrollbar_init ( Edit - Initiate Scrollbar )
 * - dslc_row_edit_cancel ( Edit - Cancel Changes )
 * - dslc_row_edit_confirm ( Edit - Confirm Changes )
 * - dslc_row_copy ( Copy )
 * - dslc_row_import ( Import )
 *
 ***********************************/

 	/**
 	 * Row - Add New
 	 */

	function dslc_row_add( callback ) {

		if ( dslcDebug ) console.log( 'dslc_row_add' );

		callback = typeof callback !== 'undefined' ? callback : false;

		// AJAX Request
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-add-modules-section',
				dslc : 'active'
			},
			function( response ) {
				
				// Append new row
				jQuery( response.output ).appendTo('#dslc-main');

				// Call other functions
				dslc_drag_and_drop();
				dslc_generate_code();
				dslc_show_publish_button();

				if ( callback ) { callback(); }

			}

		);

	}

	/**
	 * Row - Delete
	 */

	function dslc_row_delete( row ) {

		if ( dslcDebug ) console.log( 'dslc_row_delete' );

		// If the row is being edited
		if ( row.find('.dslca-module-being-edited') ) {
			
			// Hide the filter hooks
			jQuery('.dslca-header .dslca-options-filter-hook').hide();		

			// Hide the save/cancel actions
			jQuery('.dslca-module-edit-actions').hide();

			// Show the section hooks
			jQuery('.dslca-header .dslca-go-to-section-hook').show();

			dslc_show_section('.dslca-modules');

		}

		// Remove row
		row.trigger('mouseleave').remove();

		// Call other functions
		dslc_generate_code();
		dslc_show_publish_button();

	}

	/**
	 * Row - Edit
	 */

	function dslc_row_edit( row ) {

		if ( dslcDebug ) console.log( 'dslc_row_edit' );

		// Vars we will use
		var dslcModulesSectionOpts, dslcVal;

		// Set editing class
		jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');
		jQuery('.dslca-modules-section-being-edited').removeClass('dslca-modules-section-being-edited').removeClass('dslca-modules-section-change-made');
		row.addClass('dslca-modules-section-being-edited');

		// Hide the section hooks
		jQuery('.dslca-header .dslca-go-to-section-hook').hide();

		// Show the styling/responsive tabs
		jQuery('.dslca-row-options-filter-hook[data-section="styling"], .dslca-row-options-filter-hook[data-section="responsive"]').show();
		jQuery('.dslca-row-options-filter-hook[data-section="styling"]').trigger('click');

		// Hide the filter hooks
		jQuery('.dslca-header .dslca-options-filter-hook').hide();		

		// Hide the save/cancel actions
		jQuery('.dslca-module-edit-actions').hide();

		// Show the save/cancel actions
		jQuery('.dslca-row-edit-actions').show();

		// Set current values
		jQuery('.dslca-modules-section-edit-field').each(function(){

			if ( jQuery(this).data('id') == 'border-top' ) {

				if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="border"]').val().indexOf('top') >= 0 ) {
					jQuery(this).prop('checked', true);
					jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
				} else {
					jQuery(this).prop('checked', false);
					jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
				}

			} else if ( jQuery(this).data('id') == 'border-right' ) {

				if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="border"]').val().indexOf('right') >= 0 ) {
					jQuery(this).prop('checked', true);
					jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
				} else {
					jQuery(this).prop('checked', false);
					jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
				}

			} else if ( jQuery(this).data('id') == 'border-bottom' ) {

				if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="border"]').val().indexOf('bottom') >= 0 ) {
					jQuery(this).prop('checked', true);
					jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
				} else {
					jQuery(this).prop('checked', false);
					jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
				}

			} else if ( jQuery(this).data('id') == 'border-left' ) {

				if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="border"]').val().indexOf('left') >= 0 ) {
					jQuery(this).prop('checked', true);
					jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
				} else {
					jQuery(this).prop('checked', false);
					jQuery(this).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
				}

			} else if ( jQuery(this).hasClass('dslca-modules-section-edit-field-checkbox') ) {

				if ( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="' + jQuery(this).data('id') + '"]').val().indexOf( jQuery(this).data('val') ) >= 0 ) {
					jQuery( this ).prop('checked', true);
					jQuery( this ).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
				} else {
					jQuery( this ).prop('checked', false);
					jQuery( this ).siblings('.dslca-modules-section-edit-option-checkbox-hook').find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
				}

			} else {

				jQuery(this).val( jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input[data-id="' + jQuery(this).data('id') + '"]').val() );

				if ( jQuery( this ).hasClass( 'dslca-modules-section-edit-field-colorpicker' ) ) {
					var _this = jQuery( this );
					jQuery( this ).closest( '.dslca-modules-section-edit-option' ).find( '.sp-preview-inner' ).removeClass('sp-clear-display').css({ 'background-color' : _this.val() });
				}

			}

		});

		jQuery('.dslca-modules-section-edit-field-upload').each(function(){

			var dslcParent = jQuery(this).closest('.dslca-modules-section-edit-option');

			if ( jQuery(this).val() && jQuery(this).val() !== 'disabled' ) {

				jQuery('.dslca-modules-section-edit-field-image-add-hook', dslcParent ).hide();
				jQuery('.dslca-modules-section-edit-field-image-remove-hook', dslcParent ).show();

			} else {

				jQuery('.dslca-modules-section-edit-field-image-remove-hook', dslcParent ).hide();
				jQuery('.dslca-modules-section-edit-field-image-add-hook', dslcParent ).show();

			}

		});

		// Initiate numeric option sliders
		dslc_row_edit_slider_init();

		// Show options management
		dslc_show_section('.dslca-modules-section-edit');

		// Hide the publish butotn
		jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'hidden' });
		jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'hidden' });

	}

	/**
	 * Row - Edit - Initiate Colorpicker
	 */

	function dslc_row_edit_colorpicker_init() {

		if ( dslcDebug ) console.log( 'dslc_row_edit_colorpicker_init' );

		var dslcField, 
		dslcFieldID, 
		dslcEl, 
		dslcModulesSection, 
		dslcVal, 
		dslcRule, 
		dslcSetting, 
		dslcTargetEl,
		dslcCurrColor;

		/**
		 * Color Pallete
		 */

		var dslcColorPallete = [],
		currStorage,
		index;

		dslcColorPallete[0] = [];
		dslcColorPallete[1] = [];
		dslcColorPallete[2] = [];
		dslcColorPallete[3] = [];

		if ( localStorage['dslcColorpickerPalleteStorage'] == undefined ) {
		} else {
			currStorage = JSON.parse( localStorage['dslcColorpickerPalleteStorage'] );
			for	( index = 0; index < currStorage.length; index++ ) {
				var key = Math.floor( index / 3 );
				if ( key < 4 ) {
					dslcColorPallete[key].push( currStorage[index] );
				}
			}
		}

		jQuery('.dslca-modules-section-edit-field-colorpicker').each( function(){

			dslcCurrColor = jQuery(this).val();

			jQuery(this).spectrum({
				color: dslcCurrColor,
				showInput: true,
				allowEmpty: true,
				showAlpha: true,
				clickoutFiresChange: true,
				cancelText: '',
				chooseText: '',
				preferredFormat: 'rgb',
				showPalette: true,
				palette: dslcColorPallete,
				move: function( color ) {
					
					dslcField = jQuery(this);
					dslcFieldID = dslcField.data('id');
					
					if ( color == null )
						dslcVal = 'transparent';
					else
						dslcVal = color.toRgbString();

					dslcRule = dslcField.data('css-rule');
					dslcEl = jQuery('.dslca-modules-section-being-edited');
					dslcTargetEl = dslcEl;
					dslcSetting = jQuery('.dslca-modules-section-settings input[data-id="' + dslcFieldID + '"]', dslcEl );

					dslcEl.addClass('dslca-modules-section-change-made');

					if ( dslcField.data('css-element') ) {
						dslcTargetEl = jQuery( dslcField.data('css-element'), dslcEl );
					}

					dslcTargetEl.css(dslcRule, dslcVal);
					dslcSetting.val( dslcVal );

				},
				change: function( color ) {
					
					dslcField = jQuery(this);
					dslcFieldID = dslcField.data('id');
					
					if ( color == null )
						dslcVal = 'transparent';
					else
						dslcVal = color.toRgbString();
					
					// Update pallete local storage
					if ( localStorage['dslcColorpickerPalleteStorage'] == undefined ) {
						var newStorage = [ dslcVal ];
						localStorage['dslcColorpickerPalleteStorage'] = JSON.stringify(newStorage);
					} else {
						var newStorage = JSON.parse( localStorage['dslcColorpickerPalleteStorage'] );
						if ( newStorage.indexOf( dslcVal ) == -1 ) {
							newStorage.unshift( dslcVal );
						}
						localStorage['dslcColorpickerPalleteStorage'] = JSON.stringify(newStorage);
					}

				},
				show: function( color ) {
					jQuery('body').addClass('dslca-disable-selection');
					jQuery(this).spectrum( 'set', jQuery(this).val() );
				},
				hide: function() {
					jQuery('body').removeClass('dslca-disable-selection');
				}

			});

		});

	}

	/**
	 * Row - Edit - Initiate Slider
	 */

	function dslc_row_edit_slider_init() {

		if ( dslcDebug ) console.log( 'dslc_row_edit_slider_init' );

		jQuery('.dslca-modules-section-edit-field-slider').each(function(){

			var dslcSlider, dslcSliderField, dslcSliderInput, dslcSliderVal, dslcAffectOnChangeRule, dslcAffectOnChangeEl,
			dslcSliderTooltip, dslcSliderTooltipOffset, dslcSliderHandle, dslcSliderTooltipPos, dslcSection, dslcOptionID, dslcSliderExt = '',
			dslcAffectOnChangeRules, dslcSliderMin = 0, dslcSliderMax = 300, dslcSliderIncr = 1;

			dslcSlider = jQuery(this);
			dslcSliderInput = dslcSlider.siblings('.dslca-modules-section-edit-field');
			dslcSliderTooltip = dslcSlider.siblings('.dslca-modules-section-edit-field-slider-tooltip');

			if ( dslcSlider.data('min') ) {
				dslcSliderMin = dslcSlider.data('min');
			}

			if ( dslcSlider.data('max') ) {
				dslcSliderMax = dslcSlider.data('max');
			}

			if ( dslcSlider.data('incr') ) {
				dslcSliderIncr = dslcSlider.data('incr');
			}

			if ( dslcSlider.data('ext') ) {
				dslcSliderExt = dslcSlider.data('ext');
			}

			dslcSlider.slider({
				min : dslcSliderMin,
				max : dslcSliderMax,
				step: dslcSliderIncr,
				value: dslcSliderInput.val(),
				slide: function(event, ui) {  

					dslcSliderVal = ui.value + dslcSliderExt;
					dslcSliderInput.val( dslcSliderVal );

					// Live change
					dslcAffectOnChangeEl = jQuery('.dslca-modules-section-being-edited');

					if ( dslcSliderInput.data('css-element') ) {
						dslcAffectOnChangeEl = jQuery( dslcSliderInput.data('css-element'), dslcAffectOnChangeEl );
					}

					dslcAffectOnChangeRule = dslcSliderInput.data('css-rule').replace(/ /g,'');
					dslcAffectOnChangeRules = dslcAffectOnChangeRule.split( ',' );

					// Loop through rules (useful when there are multiple rules)
					for ( var i = 0; i < dslcAffectOnChangeRules.length; i++ ) {
						jQuery( dslcAffectOnChangeEl ).css( dslcAffectOnChangeRules[i] , dslcSliderVal );
					}

					// Update option
					dslcSection = jQuery('.dslca-modules-section-being-edited');
					dslcOptionID = dslcSliderInput.data('id');
					jQuery('.dslca-modules-section-settings input[data-id="' + dslcOptionID + '"]', dslcSection).val( ui.value );

					dslcSection.addClass('dslca-modules-section-change-made');

					// Tooltip
					dslcSliderTooltip.text( dslcSliderVal );
					dslcSliderHandle = dslcSlider.find('.ui-slider-handle');
					dslcSliderTooltipOffset = dslcSliderHandle[0].style.left;
					dslcSliderTooltip.css({ left : dslcSliderTooltipOffset });

				},
				stop: function( event, ui ) {

					dslcSliderTooltip.hide();

					var scrollOffset = jQuery( window ).scrollTop();
					dslc_masonry();
					jQuery( window ).scrollTop( scrollOffset );

				},
				start: function( event, ui ) {

					dslcSliderVal = ui.value;

					dslcSliderTooltip.show();
					
					// Tooltip
					dslcSliderTooltip.text( dslcSliderVal );
					dslcSliderHandle = dslcSlider.find('.ui-slider-handle');
					dslcSliderTooltipOffset = dslcSliderHandle[0].style.left;
					dslcSliderTooltip.css({ left : dslcSliderTooltipOffset });

				}

			});

		});

	}

	/**
	 * Row - Edit - Initiate Scrollbar
	 */

	function dslc_row_edit_scrollbar_init() {

		if ( dslcDebug ) console.log( 'dslc_row_edit_scrollbar_init' );

		var dslcWidth = 0;

		jQuery('.dslca-modules-section-edit-option').each(function(){
			dslcWidth += jQuery(this).outerWidth(true) + 1;
		});		

		if ( dslcWidth > jQuery( '.dslca-modules-section-edit-options' ).width() ) {
			jQuery('.dslca-modules-section-edit-options-wrapper').width( dslcWidth );
		} else {
			jQuery('.dslca-modules-section-edit-options-wrapper').width( 'auto' );
		}

		if ( ! jQuery('body').hasClass('rtl') ) {

			if ( jQuery('.dslca-modules-section-edit-options-inner').data('jsp') ) {
				jQuery('.dslca-modules-section-edit-options-inner').data('jsp').destroy();
			}

			jQuery('.dslca-modules-section-edit-options-inner').jScrollPane();

		}

	}

	/**
	 * Row - Edit - Cancel Changes
	 */

	function dslc_row_edit_cancel( callback ) {

		if ( dslcDebug ) console.log( 'dslc_row_cancel_changes' );

		callback = typeof callback !== 'undefined' ? callback : false;

		jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input').each(function(){

			jQuery(this).val( jQuery(this).data('def') );
			jQuery('.dslca-modules-section-edit-field[data-id="' + jQuery(this).data('id') + '"]').val( jQuery(this).data('def') ).trigger('change');

		});

		dslc_show_section('.dslca-modules');

		// Hide the save/cancel actions
		jQuery('.dslca-row-edit-actions').hide();

		// Hide the styling/responsive tabs
		jQuery('.dslca-row-options-filter-hook').hide();

		// Show the section hooks
		jQuery('.dslca-header .dslca-go-to-section-hook').show();

		// Show the publish button
		jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'visible' });
		jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'visible' });

		// Remove being edited class
		jQuery('.dslca-modules-section-being-edited').removeClass('dslca-modules-section-being-edited dslca-modules-section-change-made');

		if ( callback ) { callback(); }

		// Show the publish button
		jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'visible' });
		jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'visible' });

	}

	/**
	 * Row - Edit - Confirm Changes
	 */

	function dslc_row_edit_confirm( callback ) {

		if ( dslcDebug ) console.log( 'dslc_confirm_row_changes' );

		callback = typeof callback !== 'undefined' ? callback : false;

		jQuery('.dslca-modules-section-being-edited .dslca-modules-section-settings input').each(function(){

			jQuery(this).data( 'def', jQuery(this).val() );

		});

		dslc_show_section('.dslca-modules');

		// Hide the save/cancel actions
		jQuery('.dslca-row-edit-actions').hide();

		// Hide the styling/responsive tabs
		jQuery('.dslca-row-options-filter-hook').hide();

		// Show the section hooks
		jQuery('.dslca-header .dslca-go-to-section-hook').show();

		// Show the publish button
		jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'visible' });
		jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'visible' });

		// Remove being edited class
		jQuery('.dslca-modules-section-being-edited').removeClass('dslca-modules-section-being-edited dslca-modules-section-change-made');

		dslc_generate_code();
		dslc_show_publish_button();

		if ( callback ) { callback(); }

		// Show the publish button
		jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'visible' });
		jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'visible' });

	}

	/**
	 * Row - Copy
	 */

	function dslc_row_copy( row ) {

		if ( dslcDebug ) console.log( 'dslc_row_copy' );

		// Vars that will be used
		var dslcModuleID,
		dslcModulesSectionCloned,
		dslcModule;

		// Clone the row
		dslcModulesSectionCloned = row.clone().appendTo('#dslc-main');

		// Go through each area of the new row and apply correct data-size
		dslcModulesSectionCloned.find('.dslc-modules-area').each(function(){
			var dslcIndex = jQuery(this).index();
			jQuery(this).data('size', row.find('.dslc-modules-area:eq( ' + dslcIndex + ' )').data('size') );
		});

		// Remove animations and temporary hide modules
		dslcModulesSectionCloned.find('.dslc-module-front').css({
			'-webkit-animation-name' : 'none',
			'-moz-animation-name' : 'none',
			'animation-name' : 'none',
			'animation-duration' : '0',
			'-webkit-animation-duration' : '0',
			opacity : 0

		// Go through each module
		}).each(function(){

			// Current module
			dslcModule = jQuery(this);

			// Reguest new ID
			jQuery.ajax({
				type: 'POST',
				method: 'POST',
				url: DSLCAjax.ajaxurl,
				data: { action : 'dslc-ajax-get-new-module-id' },
				async: false
			}).done(function( response ) {

				// Remove "being-edited" class
				jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');

				// Get new ID
				dslcModuleID = response.output;				

				// Apply new ID and append "being-edited" class
				dslcModule.data( 'module-id', dslcModuleID ).attr( 'id', 'dslc-module-' + dslcModuleID ).addClass('dslca-module-being-edited');

				// Reload the module, remove "being-edited" class and show module
				dslc_module_output_altered( function(){
					jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited').animate({
						opacity : 1
					}, 300);
				});

			});

		});

		// Call additional functions
		dslc_drag_and_drop();
		dslc_generate_code();
		dslc_show_publish_button();

	}

	/**
	 * Row - Import
	 */

	function dslc_row_import( rowCode ) {	

		if ( dslcDebug ) console.log( 'dslc_row_import' );

		// AJAX Call
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-import-modules-section',
				dslc : 'active',
				dslc_modules_section_code : rowCode
			},
			function( response ) {
				
				// Close the import popup/modal
				dslc_js_confirm_close();

				// Add the new section
				jQuery('#dslc-main').append( response.output );

				// Call other functions
				dslc_bg_video();
				dslc_carousel();
				dslc_masonry( jQuery('#dslc-main').find('.dslc-modules-section:last-child') );
				dslc_drag_and_drop();
				dslc_show_publish_button();
				dslc_generate_code();

			}

		);

	}

	/**
	 * Deprecated Functions and Fallbacks
	 */

	function dslc_add_modules_section() { dslc_row_add(); }
	function dslc_delete_modules_section( row  ) { dslc_row_delete( row ); }
	function dslc_edit_modules_section( row ) { dslc_row_edit( row ); }
	function dslc_edit_modules_section_colorpicker() { dslc_row_edit_colorpicker_init(); }
	function dslc_edit_modules_section_slider() { dslc_row_edit_slider_init(); }
	function dslc_edit_modules_section_scroller() { dslc_row_edit_scrollbar_init(); }
	function dslc_copy_modules_section( row ) { dslc_row_copy( row ); }
	function dslc_import_modules_section( rowCode ) { dslc_row_import( rowCode ); }

	/**
	 * Row - Document Ready Actions
	 */

	jQuery(document).ready(function($){

		/**
		 * Initialize
		 */

		dslc_row_edit_colorpicker_init();
		dslc_row_edit_slider_init();

		/**
		 * Action - Automatically Add a Row if Empty
		 */

		if ( ! $( '#dslc-main .dslc-modules-section' ).length && ! $( '#dslca-tut-page' ).length ) {
			dslc_row_add();
		}

		/**
		 * Hook - Add Row
		 */

		$(document).on( 'click', '.dslca-add-modules-section-hook', function(){

			var button = $(this);

			if ( ! $(this).hasClass('dslca-action-disabled') ) {

				// Add a loading animation
				button.find('.dslca-icon').removeClass('dslc-icon-align-justify').addClass('dslc-icon-spinner dslc-icon-spin');

				// Add a row
				dslc_row_add( function(){
					button.find('.dslca-icon').removeClass('dslc-icon-spinner dslc-icon-spin').addClass('dslc-icon-align-justify');
				});

			}

		});

		/**
		 * Hook - Edit Row
		 */

		$(document).on( 'click', '.dslca-edit-modules-section-hook', function(){

			// If not disabled ( disabling used for tutorial )
			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				
				// If a module is being edited
				if ( jQuery('.dslca-module-being-edited.dslca-module-change-made').length ) {

					// Ask to confirm or cancel
					dslc_js_confirm( 'edit_in_progress', '<span class="dslca-prompt-modal-title">' + DSLCString.str_module_curr_edit_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_module_curr_edit_descr + '</span>', jQuery(this) );

				// If another section is being edited
				} else if ( jQuery('.dslca-modules-section-being-edited.dslca-modules-section-change-made').length ) {

					// Ask to confirm or cancel
					dslc_js_confirm( 'edit_in_progress', '<span class="dslca-prompt-modal-title">' + DSLCString.str_row_curr_edit_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_row_curr_edit_descr + '</span>', jQuery(this) );	

				// All good to proceed
				} else {
					
					// Trigger the function to edit
					dslc_row_edit( $(this).closest('.dslc-modules-section') );

				}

			}

		});		

		/**
		 * Hook - Confirm Row Changes
		 */

		$(document).on( 'click', '.dslca-row-edit-save', function(){

			dslc_row_edit_confirm();
			$('.dslca-row-options-filter-hook.dslca-active').removeClass('dslca-active');
			dslc_responsive_classes( true );

		});

		/**
		 * Hook - Cancel Row Changes
		 */

		$(document).on( 'click', '.dslca-row-edit-cancel', function(){

			dslc_row_edit_cancel();
			$('.dslca-row-options-filter-hook.dslca-active').removeClass('dslca-active');
			dslc_responsive_classes( true );

		});

		/**
		 * Hook - Copy Row
		 */

		$(document).on( 'click', '.dslca-copy-modules-section-hook', function() {

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				dslc_row_copy( $(this).closest('.dslc-modules-section') );	
			}

		});

		/**
		 * Hook - Import Row
		 */

		$(document).on( 'click', '.dslca-import-modules-section-hook', function(e) {

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				$('.dslca-prompt-modal-confirm-hook').html('<span class="dslc-icon dslc-icon-ok"></span><span>' + DSLCString.str_import + '</span><div class="dslca-loading followingBallsGWrap"><div class="followingBallsG_1 followingBallsG"></div><div class="followingBallsG_2 followingBallsG"></div><div class="followingBallsG_3 followingBallsG"></div><div class="followingBallsG_4 followingBallsG"></div></div>');
				dslc_js_confirm( 'import_modules_section', '<span class="dslca-prompt-modal-title">' + DSLCString.str_import_row_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_import_row_descr + ' <br><br><textarea></textarea></span>', $(this) );
			}

		});


		/**
		 * Hook - Delete Row
		 */

		$(document).on( 'click', '.dslca-delete-modules-section-hook', function(e){

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				dslc_js_confirm( 'delete_modules_section', '<span class="dslca-prompt-modal-title">' + DSLCString.str_del_row_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_del_row_descr + '</span>', $(this) );
			}

		});

		/**
		 * Hook - Export Row
		 */

		$(document).on( 'click', '.dslca-export-modules-section-hook', function(e) {

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				$('.dslca-prompt-modal-cancel-hook').hide();
				$('.dslca-prompt-modal-confirm-hook').html('<span class="dslc-icon dslc-icon-ok"></span>' + DSLCString.str_ok);
				dslc_js_confirm( 'export_modules_section', '<span class="dslca-prompt-modal-title">' + DSLCString.str_export_row_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_export_row_descr + ' <br><br><textarea></textarea></span>', $(this) );
				$('.dslca-prompt-modal textarea').val( dslc_generate_section_code( $(this).closest('.dslc-modules-section') ) );
			}

		});

	});


/*********************************
 *
 * 7) = AREAS ( MODULE AREAS ) =
 *
 * - dslc_modules_area_add ( Adds a new modules area )
 * - dslc_modules_area_delete ( Deletes modules area )
 * - dslc_modules_area_width_set ( Sets specific width to the modules area )
 * - dslc_copy_modules_area ( Copies modules area )
 *
 ***********************************/

 	/**
 	 * AREAS - Add New
 	 */

 	function dslc_modules_area_add( row ) {

		if ( dslcDebug ) console.log( 'dslc_add_modules_area' );

		// Add class to body so we know it's in progress
		jQuery('body').addClass('dslca-anim-in-progress');

		// AJAX call to add new area
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-add-modules-area',
				dslc : 'active'
			},
			function( response ) {
				
				// Loading Animation
				jQuery('.dslca-modules-area-loading .dslca-module-loading-inner', row.closest('.dslc-modules-section') ).stop().animate({
					width : '100%'
				}, 200, 'linear', function(){
					row.css({ paddingBottom : 0 });
					jQuery(this).closest('.dslca-modules-area-loading').hide();
				});
				
				// Handle adding after animation done
				setTimeout( function(){

					// Append new area and animate
					jQuery( response.output ).appendTo( row ).css({ height : 0 }).animate({
						height : 99
					}, 300, function(){
						jQuery(this).css({ height : 'auto' })
					}).addClass('dslca-init-animation');

					// Call other functions
					dslc_drag_and_drop();
					dslc_generate_code();
					dslc_show_publish_button();

					// Remove class from body so we know it's done
					jQuery('body').removeClass('dslca-anim-in-progress');

				}, 250 );

			}

		);

		// Animate loading
		var randomLoadingTime = Math.floor(Math.random() * (100 - 50 + 1) + 50) * 100;
		row.animate({ paddingBottom : 50 }, 150);
		jQuery('.dslca-modules-area-loading', row.closest('.dslc-modules-section') ).show();
		jQuery('.dslca-modules-area-loading .dslca-module-loading-inner', row.closest('.dslc-modules-section') ).css({ width : 0 }).animate({
			width : '100%'
		}, randomLoadingTime, 'linear' );

	}

	/** 
	 * AREAS - Delete
	 */

	function dslc_modules_area_delete( area ) {

		if ( dslcDebug ) console.log( 'dslc_delete_modules_area' );

		// Vars
		var modulesSection = area.closest('.dslc-modules-section').find('.dslc-modules-section-inner'),
		dslcAddNew = false;

		// Add a class to the area so we know it's being deleted
		area.addClass('dslca-modules-area-being-deleted');
			
		// If it's the last area in the row add a new one after deletion
		if ( modulesSection.find('.dslc-modules-area').length < 2 )
			dslcAddNew = true;

		// If a module in the area is being edited
		if ( area.find('.dslca-module-being-edited').length ) {
			
			// Hide the filter hooks
			jQuery('.dslca-header .dslca-options-filter-hook').hide();		

			// Hide the save/cancel actions
			jQuery('.dslca-module-edit-actions').hide();

			// Show the section hooks
			jQuery('.dslca-header .dslca-go-to-section-hook').show();

			// Show the modules listing
			dslc_show_section('.dslca-modules');

		}

		// Set a timeout so we handle deletion after animation ends
		setTimeout( function(){

			// Remove the area
			area.remove();

			// Call other functions
			dslc_generate_code();
			dslc_show_publish_button();

			// Add new modules are if the row is now empty
			if ( dslcAddNew ) dslc_modules_area_add( modulesSection );

		}, 900 );

		// Animation
		area.css({
			'-webkit-animation-name' : 'dslcBounceOut',
			'-moz-animation-name' : 'dslcBounceOut',
			'animation-name' : 'dslcBounceOut',
			'animation-duration' : '0.6s',
			'-webkit-animation-duration' : '0.6s',
			'overflow' : 'hidden'
		}).animate({
			opacity : 0
		}, 600).animate({
			height : 0,
			marginBottom : 0
		}, 300, function(){
			area.remove();
			dslc_generate_code();
			dslc_show_publish_button();
		});

	}

	/**
	 * AREAS - Copy
	 */

	function dslc_modules_area_copy( area ) {

		if ( dslcDebug ) console.log( 'dslc_copy_modules_area' );

		// Vars
		var dslcModuleID,
		modulesSection = area.closest('.dslc-modules-section').find('.dslc-modules-section-inner');

		// Copy the area and append to the row
		var dslcModulesAreaCloned = area.clone().appendTo(modulesSection);

		// Trigger mouseleave ( so the actions that show on hover go away )
		dslcModulesAreaCloned.find('.dslca-modules-area-manage').trigger('mouseleave');

		// Apply correct data size and get rid of animations
		dslcModulesAreaCloned.data('size', area.data('size') ).find('.dslc-module-front').css({ 
			'-webkit-animation-name' : 'none',
			'-moz-animation-name' : 'none',
			'animation-name' : 'none',
			'animation-duration' : '0',
			'-webkit-animation-duration' : '0',
			opacity : 0 

		// Go through each module in the area
		}).each(function(){

			var dslcModule = jQuery(this);

			// Reguest new ID
			jQuery.ajax({
				type: 'POST',
				method: 'POST',
				url: DSLCAjax.ajaxurl,
				data: { action : 'dslc-ajax-get-new-module-id' },
				async: false
			}).done(function( response ) {

				// Remove being edited class
				jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');

				// Store the new ID
				dslcModuleID = response.output;				

				// Apply the new ID and add being edited class
				dslcModule.data( 'module-id', dslcModuleID ).attr( 'id', 'dslc-module-' + dslcModuleID ).addClass('dslca-module-being-edited');

				// Reload the module
				dslc_module_output_altered( function(){

					// Remove being edited class and show the module
					jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited').animate({
						opacity : 1
					}, 300);

				});

			});

		});

		// Call other functions
		dslc_drag_and_drop();
		dslc_generate_code();
		dslc_show_publish_button();

	}

	/**
	 * AREAS - Set Width
	 */

	function dslc_modules_area_width_set( area, newWidth ) {

		if ( dslcDebug ) console.log( 'dslc_modules_area_width_set' );

		// Generate new class based on width
		var newClass = 'dslc-' + newWidth + '-col';

		// Remove width classes, add new width class and set the data-size attr
		area
			.removeClass('dslc-1-col dslc-2-col dslc-3-col dslc-4-col dslc-5-col dslc-6-col dslc-7-col dslc-8-col dslc-9-col dslc-10-col dslc-11-col dslc-12-col')
			.addClass(newClass)
			.data('size', newWidth);

		// Call other functions
		dslc_init_square();
		dslc_center();
		dslc_generate_code();
		dslc_show_publish_button();
		dslc_masonry();

	}

	/**
	 * Deprecated Functions and Fallbacks
	 */

	function dslc_add_modules_area( row ) { dslc_modules_area_add( row ); }
	function dslc_delete_modules_area( area ) { dslc_modules_area_delete( area ); }
	function dslc_copy_modules_area( area ) { dslc_modules_area_copy( area ); }

	/**
	 * AREAS - Document Ready
	 */

	jQuery(document).ready(function($){

		/**
		 * Hook - Add Area
		 */

		$(document).on( 'click', '.dslca-add-modules-area-hook', function(e){

			e.preventDefault();

			dslc_modules_area_add( jQuery(this).closest('.dslc-modules-section').find('.dslc-modules-section-inner') );

		});

		/**
		 * Hook - Delete Area
		 */

		$(document).on( 'click', '.dslca-delete-modules-area-hook', function(e){

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				dslc_js_confirm( 'delete_modules_area', '<span class="dslca-prompt-modal-title">' + DSLCString.str_del_area_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_del_area_descr + '</span>', $(this) );
			}

		});

		/**
		 * Hook - Copy Area
		 */

		$(document).on( 'click', '.dslca-copy-modules-area-hook', function(e){

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				var modulesArea = $(this).closest('.dslc-modules-area');
				dslc_copy_modules_area( modulesArea );
			}

		});

		/**
		 * Hook - Set Width
		 */

		$(document).on( 'click', '.dslca-change-width-modules-area-options span', function(){

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				dslc_modules_area_width_set( jQuery(this).closest('.dslc-modules-area'), jQuery(this).data('size') );
			}

		});

		/**
		 * Action - Show/Hide Width Options
		 */

		$(document).on( 'click', '.dslca-change-width-modules-area-hook', function(e){

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
					
				// Is visible
				if ( $('.dslca-change-width-modules-area-options:visible', this).length ) {
					
					// Hide
					$('.dslca-change-width-modules-area-options', this).hide();

				// Is hidden
				} else {
						
					// Set active
					$('.dslca-change-width-modules-area-options .dslca-active-width').removeClass('dslca-active-width');
					var currSize = $(this).closest('.dslc-modules-area').data('size');
					$('.dslca-change-width-modules-area-options span[data-size="' + currSize + '"]').addClass('dslca-active-width');

					// Show
					$('.dslca-change-width-modules-area-options', this).show();

				}
				
			}

		});
		

	});


/*********************************
 *
 * 8) = MODULES =
 *
 * - dslc_module_delete ( Deletes a module )
 * - dslc_module_copy ( Copies a module )
 * - dslc_module_width_set ( Sets a width to module )
 * - dslc_module_options_show ( Show module options )
 * - dslc_module_options_scrollbar ( Scrollbar for options )
 * - dslc_module_options_section_filter ( Filter options section )
 * - dslc_module_options_tab_filter ( Filter options tab )
 * - dslc_module_options_hideshow_tabs ( Hide show tabs based on option choices )
 * - dslc_module_options_confirm_changes ( Confirm changes )
 * - dslc_module_options_cancel_changes ( Cancel changes )
 * - dslc_module_options_tooltip ( Helper tooltips for options )
 * - dslc_module_options_font ( Actions for font option type )
 * - dslc_module_options_icon ( Actions for icon font option type )
 * - dslc_module_options_text_align ( Actions for text align option type )
 * - dslc_module_options_checkbox ( Actions for checkbox option type )
 * - dslc_module_options_box_shadow ( Actions for box shadow option type )
 * - dslc_modules_options_box_shadow_color ( Initiate colorpicker for box shadow)
 * - dslc_module_options_text_shadow ( Actions for text shadow option type )
 * - dslc_modules_options_text_shadow_color ( Initiate colorpicker for text shadow)
 * - dslc_module_options_color ( Actions for color option type )
 * - dslc_module_output_default ( Get module output with default settings )
 * - dslc_module_output_altered ( Get module output when settings altered )

 ***********************************/

 	/**
 	 * MODULES - Delete a Module
 	 */

 	function dslc_module_delete( module ) {

		if ( dslcDebug ) console.log( 'dslc_delete_module' );

		// Add class to module so we know it's being deleted
		module.addClass('dslca-module-being-deleted');

		// If the module is being edited switch to modules listing
		if ( module.hasClass('dslca-module-being-edited') ) {
			dslc_show_section( '.dslca-modules' );
		}

		// Handle deletion with a delay ( for animations to finish )
		setTimeout( function(){

			// Remove module, regenerate code, show publish button
			module.remove();
			dslc_generate_code();
			dslc_show_publish_button();

		}, 1000 );

		// Animations ( bounce out + invisible )
		module.css({
			'-webkit-animation-name' : 'dslcBounceOut2',
			'-moz-animation-name' : 'dslcBounceOut2',
			'animation-name' : 'dslcBounceOut2',
			'animation-duration' : '0.6s',
			'-webkit-animation-duration' : '0.6s'
		}).animate({ opacity : 0 }, 500, function(){

			// Animations ( height to 0 for a slide effect )
			module.css({ marginBottom : 0 }).animate({ height: 0 }, 400, 'easeOutQuart');

		});

	}

	/**
	 * Modules - Copy a Module
	 */

	function dslc_module_copy( module ) {

		if ( dslcDebug ) console.log( 'dslc_copy_module' );

		// Vars
		var dslcModuleID;

		// AJX reguest new ID
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-get-new-module-id',
			},
			function( response ) {

				// Remove being edited class if some module is being edited
				jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');

				// Store the new ID
				dslcModuleID = response.output;

				// Duplicate the module and append it to the same area
				module.clone().appendTo( module.closest( '.dslc-modules-area' ) ).css({ 
					'-webkit-animation-name' : 'none',
					'-moz-animation-name' : 'none',
					'animation-name' : 'none',
					'animation-duration' : '0',
					'-webkit-animation-duration' : '0',
					opacity : 0 
				}).data( 'module-id', dslcModuleID ).attr( 'id', 'dslc-module-' + dslcModuleID ).addClass('dslca-module-being-edited');

				// Reload module
				dslc_module_output_altered( function(){

					// Fade in the module
					jQuery('.dslca-module-being-edited').css({ opacity : 0 }).removeClass('dslca-module-being-edited').animate({ opacity : 1 }, 300);

				});

			}

		);

	}

	/**
	 * MODULES - Set Width
	 */

	function dslc_module_width_set( module, newWidth ) {

		if ( dslcDebug ) console.log( 'dslc_module_width_set' );

		// Generate new column class
		var newClass = 'dslc-' + newWidth + '-col';

		// Add new column class and change size "data"
		module
			.removeClass('dslc-1-col dslc-2-col dslc-3-col dslc-4-col dslc-5-col dslc-6-col dslc-7-col dslc-8-col dslc-9-col dslc-10-col dslc-11-col dslc-12-col')
			.addClass(newClass)
			.data('dslc-module-size', newWidth)
			.addClass('dslca-module-being-edited');

		// Change the module size field
		jQuery( '.dslca-module-option-front[data-id="dslc_m_size"]', module ).val( newWidth );

		// Preview Change
		dslc_module_output_altered( function(){
			jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');
		});

	}	

	/**
	 * MODULES - Show module options
	 */

	function dslc_module_options_show( moduleID ) {

		if ( dslcDebug ) console.log( 'dslc_module_options_show' );

		// Vars
		var dslcModule = jQuery('.dslca-module-being-edited'),
		dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule ),
		dslcDefaultSection = jQuery('.dslca-header').data('default-section');
			
		// Settings array
		var dslcSettings = {};
		dslcSettings['action'] = 'dslc-ajax-display-module-options';
		dslcSettings['dslc'] = 'active';
		dslcSettings['dslc_module_id'] = moduleID;
		dslcSettings['dslc_post_id'] = jQuery('.dslca-container').data('data-post-id');

		// Go through each option
		dslcModuleOptions.each(function(){

			// Vars
			var dslcOption = jQuery(this),
			dslcOptionID = dslcOption.data('id'),
			dslcOptionValue = dslcOption.val();

			// Add option ID and value to the settings array
			dslcSettings[dslcOptionID] = dslcOptionValue;

		});

		// Hide the save/cancel actions for text editor and show notification
		jQuery('.dslca-wp-editor-actions').hide();
		jQuery('.dslca-wp-editor-notification').show();

		// AJAX call to get options HTML
		jQuery.post(
			DSLCAjax.ajaxurl, 
			dslcSettings,
			function( response ) {
				
				// Hide the publish button
				jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'hidden' });	
				jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'hidden' });

				// Show edit section
				dslc_show_section('.dslca-module-edit');

				// Add the options
				if ( ! jQuery('body').hasClass('rtl') ) {
					jQuery('.dslca-module-edit-options-inner .jspPane').html( response.output );
				} else {
					jQuery('.dslca-module-edit-options-inner').html( response.output );
				}
				jQuery('.dslca-module-edit-options-tabs').html( response.output_tabs );

				// Show the filter hooks
				jQuery('.dslca-header .dslca-options-filter-hook').show();

				// Trigger click on first filter hook
				if ( jQuery('.dslca-module-edit-option[data-section="' + dslcDefaultSection + '"]').length ) {
					jQuery('.dslca-header .dslca-options-filter-hook[data-section="' + dslcDefaultSection + '"]').show();
					jQuery('.dslca-header .dslca-options-filter-hook[data-section="' + dslcDefaultSection + '"]').trigger('click');
				} else {
					jQuery('.dslca-header .dslca-options-filter-hook:first').hide();
					jQuery('.dslca-header .dslca-options-filter-hook:first').next('.dslca-options-filter-hook').trigger('click');
				}

				// Show the save/cancel actions
				jQuery('.dslca-module-edit-actions').show();

				// Show the save/cancel actions for text editor and hide notification
				jQuery('.dslca-wp-editor-notification').hide();
				jQuery('.dslca-wp-editor-actions').show();

				// Hide the section hooks
				jQuery('.dslca-header .dslca-go-to-section-hook').hide();

				// Hide the row save/cancel actions
				jQuery('.dslca-row-edit-actions').hide();

				// Initiate Colorpicker
				dslc_module_options_color();
				dslc_modules_options_box_shadow_color();
				dslc_modules_options_text_shadow_color();
				dslc_module_options_numeric();

				// Set up backup
				var moduleBackup = jQuery('.dslca-module-options-front', '.dslca-module-being-edited').children().clone();
				jQuery('.dslca-module-options-front-backup').html('').append(moduleBackup);

			}

		);

	}

	/**
	 * MODULES - Options Scrollbar
	 */

	function dslc_module_options_scrollbar() {

		if ( dslcDebug ) console.log( 'dslc_module_options_scrollbar' );

		var dslcWidth = 0;		

		jQuery('.dslca-module-edit-option:visible').each(function(){
			dslcWidth += jQuery(this).outerWidth(true) + 1;
		});	

		if ( dslcWidth > jQuery( '.dslca-module-edit-options' ).width() ) {
			jQuery('.dslca-module-edit-options-wrapper').width( dslcWidth );
		} else {
			jQuery('.dslca-module-edit-options-wrapper').width( 'auto' );
		}		

		if ( ! jQuery('body').hasClass('rtl') ) {

			if ( jQuery('.dslca-module-edit-options-inner').data('jsp') ) {
				var scroller = jQuery('.dslca-module-edit-options-inner').data('jsp');
				scroller.reinitialise();
			}

		}		

	}

	/**
	 * MODULES - Filter Module Options
	 */

	function dslc_module_options_section_filter( sectionID ) {

		if ( dslcDebug ) console.log( 'dslc_module_options_section_filter' );

		// Hide all options
		jQuery('.dslca-module-edit-option').hide();

		// Show options for current section
		jQuery('.dslca-module-edit-option[data-section="' + sectionID + '"]').show();

		// Recall module options tab
		dslc_module_options_tab_filter();

	}

	/**
	 * MODULES - Show module options tab
	 */

	function dslc_module_options_tab_filter( dslcTab ) {

		if ( dslcDebug ) console.log( 'dslc_module_options_tab_filter' );

		// Get currently active section
		var dslcSectionID = jQuery('.dslca-options-filter-hook.dslca-active').data('section');

		// If tab not supplied set to first
		dslcTab = typeof dslcTab !== 'undefined' ? dslcTab : jQuery('.dslca-module-edit-options-tab-hook[data-section="' + dslcSectionID + '"]:first');

		// Get the tab ID
		var dslcTabID = dslcTab.data('id');

		// Set active class on tab
		jQuery('.dslca-module-edit-options-tab-hook').removeClass('dslca-active');
		dslcTab.addClass('dslca-active');

		// Show tabs container
		jQuery('.dslca-module-edit-options-tabs').show();

		// Hide/Show tabs hooks
		jQuery('.dslca-module-edit-options-tab-hook').hide();
		jQuery('.dslca-module-edit-options-tab-hook[data-section="' + dslcSectionID + '"]').show();

		if ( dslcTabID ) {

			// Hide/Show options
			jQuery('.dslca-module-edit-option').hide();
			jQuery('.dslca-module-edit-option[data-tab="' + dslcTabID + '"]').show();

			// Recreate scrollbar
			dslc_module_options_scrollbar();

			// Hide/Show Tabs
			dslc_module_options_hideshow_tabs();

			// If only one tab hide the tabs container
			if ( jQuery('.dslca-module-edit-options-tab-hook:visible').length < 2 ) {
				jQuery('.dslca-module-edit-options-tabs').hide();
			} else {
				jQuery('.dslca-module-edit-options-tabs').show();
			}

			/**
			 * If responsive tab, change the width of the dslc-content div
			 */

			// Tablet
			if ( dslcTabID == DSLCString.str_res_tablet + '_responsive' ) {
				jQuery('body').removeClass('dslc-res-big dslc-res-smaller-monitor dslc-res-phone dslc-res-tablet');
				jQuery('body').addClass('dslc-res-tablet');
			}

			// Phone
			if ( dslcTabID == DSLCString.str_res_phone + '_responsive' ) {
				jQuery('body').removeClass('dslc-res-big dslc-res-smaller-monitor dslc-res-phone dslc-res-tablet');
				jQuery('body').addClass('dslc-res-phone');
			}

			// If responsive reload module
			if ( dslcTabID == DSLCString.str_res_tablet + '_responsive' || dslcTabID == DSLCString.str_res_phone + '_responsive' ) {

				// Show the loader
				jQuery('.dslca-container-loader').show();

				// Reload Module
				dslc_module_output_altered(function(){

					// Hide the loader
					jQuery('.dslca-container-loader').hide();

				});

			}

		}

	}

	/**
	 * MODULES - Hide show tabs based on option choices
	 */

	function dslc_module_options_hideshow_tabs() {

		if ( dslcDebug ) console.log( 'dslc_module_options_hideshow_tabs' );

		var dslcSectionID = jQuery('.dslca-options-filter-hook.dslca-active').data('section');

		if ( dslcSectionID == 'styling' ) {

			// Vars
			var dslcContainer = jQuery('.dslca-module-edit'),
			dslcHeading = true,
			dslcFilters = true,
			dslcCarArrows = true,
			dslcCarCircles = true,
			dslcPagination = true,
			dslcElThumb = true,
			dslcElTitle = true,
			dslcElExcerpt = true,
			dslcElMeta = true,
			dslcElButton = true,
			dslcElCats = true,
			dslcElCount = true,
			dslcElSeparator = true,
			dslcElTags = true,
			dslcElSocial = true,
			dslcElPosition = true,
			dslcElIcon = true,
			dslcElContent = true,
			dslcElPrice = true,
			dslcElPriceSec = true,
			dslcElAddCart = true,
			dslcElDetails = true,
			dslcElQuote = true,
			dslcElAuthorName = true,
			dslcElAuthorPos = true;

			
			// Is heading selected?
			if ( ! jQuery('.dslca-module-edit-field[value="main_heading"]').is(':checked') )
				dslcHeading = false;

			// Are filters selected?
			if ( ! jQuery('.dslca-module-edit-field[value="filters"]').is(':checked') )
				dslcFilters = false;

			// Are arrows selected?
			if ( ! jQuery('.dslca-module-edit-field[value="arrows"]').is(':checked') )
				dslcCarArrows = false;

			// Are circles selected?
			if ( ! jQuery('.dslca-module-edit-field[value="circles"]').is(':checked') )
				dslcCarCircles = false;	

			// Is it a carousel?
			if ( jQuery('.dslca-module-edit-field[data-id="type"]').val() != 'carousel' ) {
				dslcCarArrows = false;
				dslcCarCircles = false;	
			}

			// Is pagination enabled?
			if ( jQuery('.dslca-module-edit-field[data-id="pagination_type"]').val() == 'disabled' ) {
				dslcPagination = false;
			}

			// Is thumb enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="thumbnail"]').is(':checked') ) {
				dslcElThumb = false;
			}

			// Is title enabled?
			if ( jQuery('.dslca-module-edit-field[data-id*="elements"][value="content"]').length && ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="title"]').is(':checked') ) {
				dslcElTitle = false;
			}

			// Is excerpt enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="excerpt"]').is(':checked') ) {
				dslcElExcerpt = false;
			}

			// Is meta enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="meta"]').is(':checked') ) {
				dslcElMeta = false;
			}

			// Is button enabled?
			if ( jQuery('.dslca-module-edit-field[data-id*="elements"][value="button"]').length && ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="button"]').is(':checked') ) {
				dslcElButton = false;
			}

			// Are cats enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="categories"]').is(':checked') ) {
				dslcElCats = false;
			}

			// Is separator enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="separator"]').is(':checked') ) {
				dslcElSeparator = false;
			}

			// Is count enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="count"]').is(':checked') ) {
				dslcElCount = false;
			}

			// Are tags enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="tags"]').is(':checked') ) {
				dslcElTags = false;
			}

			// Are social link enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="social"]').is(':checked') ) {
				dslcElSocial = false;
			}

			// Is position enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="position"]').is(':checked') ) {
				dslcElPosition = false;
			}

			// Is icon enabled?
			if ( jQuery('.dslca-module-edit-field[data-id*="elements"][value="icon"]').length && ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="icon"]').is(':checked') ) {
				dslcElIcon = false;
			}

			// Is content enabled?
			if (  jQuery('.dslca-module-edit-field[data-id*="elements"][value="content"]').length && ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="content"]').is(':checked') ) {
				dslcElContent = false;
			}

			// Is price enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="price"]').is(':checked') ) {
				dslcElPrice = false;
			}

			// Is price secondary enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="price_2"]').is(':checked') ) {
				dslcElPriceSec = false;
			}

			// Is add to cart enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="addtocart"]').is(':checked') ) {
				dslcElAddCart = false;
			}

			// Is add to cart enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="details"]').is(':checked') ) {
				dslcElDetails = false;
			}

			// Is quote enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="quote"]').is(':checked') ) {
				dslcElQuote = false;
			}

			// Is author name enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="author_name"]').is(':checked') ) {
				dslcElAuthorName = false;
			}

			// Is author position enabled?
			if ( ! jQuery('.dslca-module-edit-field[data-id*="elements"][value="author_position"]').is(':checked') ) {
				dslcElAuthorPos = false;
			}

			
			// Show/Hide Heading
			if ( dslcHeading )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="heading_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="heading_styling"]').hide();

			// Show/Hide Filters
			if ( dslcFilters )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="filters_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="filters_styling"]').hide();

			// Show/Hide Carousel Arrows
			if ( dslcCarArrows )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="carousel_arrows_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="carousel_arrows_styling"]').hide();

			// Show/Hide Carousel Circles
			if ( dslcCarCircles )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="carousel_circles_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="carousel_circles_styling"]').hide();

			// Show/Hide Pagination
			if ( dslcPagination )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="pagination_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="pagination_styling"]').hide();

			// Show/Hide Thumb
			if ( dslcElThumb )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="thumbnail_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="thumbnail_styling"]').hide();

			// Show/Hide Title
			if ( dslcElTitle )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="title_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="title_styling"]').hide();

			// Show/Hide Excerpt
			if ( dslcElExcerpt )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="excerpt_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="excerpt_styling"]').hide();

			// Show/Hide Meta
			if ( dslcElMeta )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="meta_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="meta_styling"]').hide();

			// Show/Hide Button
			if ( dslcElButton )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="button_styling"], .dslca-module-edit-options-tab-hook[data-id="primary_button_styling"], .dslca-module-edit-options-tab-hook[data-id="secondary_button_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="button_styling"], .dslca-module-edit-options-tab-hook[data-id="primary_button_styling"], .dslca-module-edit-options-tab-hook[data-id="secondary_button_styling"]').hide();

			// Show/Hide Cats
			if ( dslcElCats )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="categories_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="categories_styling"]').hide();

			// Show/Hide Separator
			if ( dslcElSeparator )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="separator_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="separator_styling"]').hide();

			// Show/Hide Count
			if ( dslcElCount )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="count_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="count_styling"]').hide();

			// Show/Hide Tags
			if ( dslcElTags )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="tags_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="tags_styling"]').hide();

			// Show/Hide Tags
			if ( dslcElPosition )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="position_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="position_styling"]').hide();

			// Show/Hide Tags
			if ( dslcElSocial )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="social_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="social_styling"]').hide();

			// Show/Hide Icon
			if ( dslcElIcon )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="icon_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="icon_styling"]').hide();

			// Show/Hide Content
			if ( dslcElContent )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="content_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="content_styling"]').hide();

			// Show/Hide Price
			if ( dslcElPrice )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="price_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="price_styling"]').hide();

			// Show/Hide Price Sec
			if ( dslcElPriceSec )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="price_secondary_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="price_secondary_styling"]').hide();

			// Show/Hide Add to Cart
			if ( dslcElAddCart || dslcElDetails )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="other_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="other_styling"]').hide();

			// Show/Hide Quote
			if ( dslcElQuote )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="quote_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="quote_styling"]').hide();

			// Show/Hide Author Name
			if ( dslcElAuthorName )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="author_name_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="author_name_styling"]').hide();

			// Show/Hide Author Position
			if ( dslcElAuthorPos )
				jQuery('.dslca-module-edit-options-tab-hook[data-id="author_position_styling"]').show();
			else
				jQuery('.dslca-module-edit-options-tab-hook[data-id="author_position_styling"]').hide();

		}

		/**
		 * Text Module
		 */

		if ( jQuery('.dslca-options-filter-hook[data-section="styling"]').hasClass('dslca-active') ) {

			if ( jQuery('.dslca-module-being-edited').data('dslc-module-id') == 'DSLC_Text_Simple' || jQuery('.dslca-module-being-edited').data('dslc-module-id') == 'DSLC_TP_Content' || jQuery('.dslca-module-being-edited').data('dslc-module-id') == 'DSLC_Html' ) {

				var dslcCustomCSS = jQuery('.dslca-module-edit-option[data-id="css_custom"]'),
				dslcCustomCSSVal = dslcCustomCSS.find('select').val();

				if ( dslcCustomCSSVal == 'enabled' ) {
					jQuery('.dslca-module-edit-option[data-section="styling"]').css({ visibility : 'visible' });
					jQuery('.dslca-module-edit-options-tabs').show();
				} else {
					jQuery('.dslca-module-edit-option[data-section="styling"]').css({ visibility : 'hidden' });
					jQuery('.dslca-module-edit-options-tabs').hide();
					dslcCustomCSS.css({ visibility : 'visible' });
				}

			}

		} else {
			jQuery('.dslca-module-edit-options-tabs').show();
		}

		if ( jQuery('select.dslca-module-edit-field[data-id="css_res_t"]').val() == 'disabled' ) {
			jQuery('.dslca-module-edit-option[data-id*="css_res_t"]').css( 'visibility', 'hidden' );
		} else {
			jQuery('.dslca-module-edit-option[data-id*="css_res_t"]').css( 'visibility', 'visible' );
		}

		if ( jQuery('select.dslca-module-edit-field[data-id="css_res_p"]').val() == 'disabled' ) {
			jQuery('.dslca-module-edit-option[data-id*="css_res_p"]').css( 'visibility', 'hidden' );
		} else {
			jQuery('.dslca-module-edit-option[data-id*="css_res_p"]').css( 'visibility', 'visible' );
		}

		jQuery('.dslca-module-edit-option[data-id="css_res_p"], .dslca-module-edit-option[data-id="css_res_t"]').css( 'visibility', 'visible' );

	}

	/**
	 * MODULES - Confirm module options changes
	 */

	function dslc_module_options_confirm_changes( callback ) {

		if ( dslcDebug ) console.log( 'dslc_module_options_confirm_changes' );

		// Callback
		callback = typeof callback !== 'undefined' ? callback : false;

		// If slider module
		if ( jQuery('.dslca-module-being-edited').hasClass('dslc-module-DSLC_Sliders') ) {

			jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');
		
		// If not slider module
		} else {

			// Add class so we know saving is in progress
			jQuery('body').addClass('dslca-module-saving-in-progress');

			// Reload module with new settings
			dslc_module_output_altered( function(){

				// Update preset
				dslc_update_preset();

				// Remove classes so we know saving finished
				jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');
				jQuery('body').removeClass('dslca-module-saving-in-progress');
				
				// Clean up options container
				if ( ! jQuery('body').hasClass('rtl') ) {
					jQuery('.dslca-module-edit-options-inner .jspPane').html('');
				} else {
					jQuery('.dslca-module-edit-options-inner').html('');
				}
				jQuery('.dslca-module-edit-options-tabs').html('');

				// Callback if there's one
				if ( callback ) { callback(); }

			});

		}

		// Show modules listing
		dslc_show_section('.dslca-modules');

		// Hide the filter hooks
		jQuery('.dslca-header .dslca-options-filter-hook').hide();		

		// Hide the save/cancel actions
		jQuery('.dslca-module-edit-actions').hide();

		// Show the section hooks
		jQuery('.dslca-header .dslca-go-to-section-hook').show();

		// Show the publish button
		jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'visible' });
		jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'visible' });

	}

	/**
	 * MODULES - Cancel module options changes 
	 */

	function dslc_module_options_cancel_changes( callback ) {

		if ( dslcDebug ) console.log( 'dslc_module_options_cancel_changes' );

		// Callback
		callback = typeof callback !== 'undefined' ? callback : false;

		// Vars
		var editedModule = jQuery('.dslca-module-being-edited'),
		originalOptions = jQuery('.dslca-module-options-front-backup').children().clone();

		// Add backup option values
		jQuery('.dslca-module-options-front', editedModule).html('').append(originalOptions);

		// Reload module
		dslc_module_output_altered( function(){

			jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');

			// Clean up options container
			if ( ! jQuery('body').hasClass('rtl') ) {
				jQuery('.dslca-module-edit-options-inner .jspPane').html('');
			} else {
				jQuery('.dslca-module-edit-options-inner').html('');
			}
			jQuery('.dslca-module-edit-options-tabs').html('');

			if ( callback ) { callback(); }

		});

		// Show modules listing
		dslc_show_section('.dslca-modules');

		// Hide the filter hooks
		jQuery('.dslca-header .dslca-options-filter-hook').hide();		

		// Hide the save/cancel actions
		jQuery('.dslca-module-edit-actions').hide();

		// Show the section hooks
		jQuery('.dslca-header .dslca-go-to-section-hook').show();

		// Show the publish button
		jQuery('.dslca-save-composer-hook').css({ 'visibility' : 'visible' });
		jQuery('.dslca-save-draft-composer-hook').css({ 'visibility' : 'visible' });


	}

	/**
	 * MODULES - Option Tooltips
	 */

	function dslc_module_options_tooltip() {

		// Close Tooltip

		jQuery(document).on( 'click', '.dslca-module-edit-field-ttip-close', function(){
			jQuery('.dslca-module-edit-field-ttip, .dslca-module-edit-field-icon-ttip').hide();
		});

		// Show Tooltip

		jQuery(document).on( 'click', '.dslca-module-edit-field-ttip-hook', function(){

			var dslcTtip = jQuery('.dslca-module-edit-field-ttip'),
			dslcTtipInner = dslcTtip.find('.dslca-module-edit-field-ttip-inner'),
			dslcHook = jQuery(this),
			dslcTtipContent = dslcHook.closest('.dslca-module-edit-option').find('.dslca-module-edit-field-ttip-content').html();

			if ( dslcTtip.is(':visible') ) {

				jQuery('.dslca-module-edit-field-ttip').hide();

			} else {

				dslcTtipInner.html( dslcTtipContent );

				var dslcOffset = dslcHook.offset();
				var dslcTtipHeight = dslcTtip.outerHeight();
				var dslcTtipWidth = dslcTtip.outerWidth();
				var dslcTtipLeft = dslcOffset.left - ( dslcTtipWidth / 2 ) + 6;
				var dslcTtipArrLeft = '50%';

				if ( dslcTtipLeft < 0 ) {
					dslcTtipArrLeft = ( dslcTtipWidth / 2 ) + dslcTtipLeft + 'px';
					dslcTtipLeft = 0;
				}           

				jQuery('.dslca-module-edit-field-ttip').show().css({
					top : dslcOffset.top - dslcTtipHeight - 20,
					left: dslcTtipLeft
				});

				jQuery("head").append(jQuery('<style>.dslca-module-edit-field-ttip:after, .dslca-module-edit-field-ttip:before { left: ' + dslcTtipArrLeft + ' }</style>'));

			}

		});

		// Show Tooltip ( Icon Options )

		jQuery(document).on( 'click', '.dslca-module-edit-field-icon-ttip-hook', function(){

			var dslcTtip = jQuery('.dslca-module-edit-field-icon-ttip');
			var dslcHook = jQuery(this);

			if ( dslcTtip.is(':visible') ) {

				jQuery('.dslca-module-edit-field-icon-ttip').hide();

			} else {

				var dslcOffset = dslcHook.offset();
				var dslcTtipHeight = dslcTtip.outerHeight();
				var dslcTtipWidth = dslcTtip.outerWidth();
				var dslcTtipLeft = dslcOffset.left - ( dslcTtipWidth / 2 ) + 6;
				var dslcTtipArrLeft = '50%';

				if ( dslcTtipLeft < 0 ) {
					dslcTtipArrLeft = ( dslcTtipWidth / 2 ) + dslcTtipLeft + 'px';
					dslcTtipLeft = 0;
				}			

				jQuery('.dslca-module-edit-field-icon-ttip').show().css({
					top : dslcOffset.top - dslcTtipHeight - 20,
					left: dslcTtipLeft
				});

				jQuery("head").append(jQuery('<style>.dslca-module-edit-field-icon-ttip:after, .dslca-module-edit-field-icon-ttip:before { left: ' + dslcTtipArrLeft + ' }</style>'));

			}

		});

	}

	/**
	 * MODULES - Font option type
	 */

	function dslc_module_options_font() {

		// Next Font

		jQuery(document).on( 'click', '.dslca-module-edit-field-font-next',  function(e){

			e.preventDefault();

			if ( ! jQuery(this).hasClass('dslca-font-loading') && ! jQuery(this).siblings('.dslca-font-loading').length ) {

				var dslcOption = jQuery(this).closest('.dslca-module-edit-option-font');
				var dslcField = jQuery( '.dslca-module-edit-field-font', dslcOption );
				var dslcCurrIndex = dslcAllFontsArray.indexOf( dslcField.val() );
				var dslcNewIndex = dslcCurrIndex + 1;
				
				jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text('');

				dslcField.val( dslcAllFontsArray[dslcNewIndex] ).trigger('change');

				jQuery(this).addClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-chevron-right').addClass('dslc-icon-refresh dslc-icon-spin');

			}

		});

		// Previous Font

		jQuery(document).on( 'click', '.dslca-module-edit-field-font-prev',  function(e){

			e.preventDefault();

			if ( ! jQuery(this).hasClass('dslca-font-loading') && ! jQuery(this).siblings('.dslca-font-loading').length ) {

				var dslcOption = jQuery(this).closest('.dslca-module-edit-option-font');
				var dslcField = jQuery( '.dslca-module-edit-field-font', dslcOption );
				var dslcCurrIndex = dslcAllFontsArray.indexOf( dslcField.val() );
				var dslcNewIndex = dslcCurrIndex - 1;

				jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text('');

				if ( dslcNewIndex < 0 ) {
					dslcNewIndex = dslcAllFontsArray.length - 1
				}
				
				dslcField.val( dslcAllFontsArray[dslcNewIndex] ).trigger('change');

				jQuery(this).addClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-chevron-left').addClass('dslc-icon-refresh dslc-icon-spin');

			}

		});

		// Keyup ( left arrow, right arrow, else )

		jQuery(document).on( 'keyup', '.dslca-module-edit-field-font', function(e) {

			var dslcField, dslcOption, dslcVal, dslcMatchingFont = false, dslcFont;

			dslcField = jQuery(this);
			dslcOption = dslcField.closest('.dslca-module-edit-option');

			if ( e.which == 38 ) {
				jQuery('.dslca-module-edit-field-font-prev', dslcOption).click();
			}

			if ( e.which == 40 ) {
				jQuery('.dslca-module-edit-field-font-next', dslcOption).click();
			}

			if ( e.which != 13 && e.which != 38 && e.which != 40 ) {

				dslcVal = dslcField.val();

				var search = [];
				var re = new RegExp('^' + dslcVal, 'i');
				var dslcFontsAmount = dslcAllFontsArray.length;
				var i = 0;
				do {
					
					if (re.test(dslcAllFontsArray[i])) {
						if ( ! dslcMatchingFont ) {
							var dslcMatchingFont = dslcAllFontsArray[i];
						}
					}
					
				i++; } while (i < dslcFontsAmount);

				if ( ! dslcMatchingFont ) {
					dslcFont = dslcVal;
					jQuery('.dslca-module-edit-field-font-suggest', dslcOption).hide();				
				} else {
					dslcFont = dslcMatchingFont;
					jQuery('.dslca-module-edit-field-font-suggest', dslcOption).show();
				}

				jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text( dslcFont );
				
				if ( dslcFont.length )
					dslcField.val( dslcFont.substring( 0 , dslcField.val().length ) );

			}

		});

		// Key press ( enter )

		jQuery(document).on( 'keypress', '.dslca-module-edit-field-font', function(e) {

			if ( e.which == 13 ) {

				e.preventDefault();

				var dslcField, dslcOption, dslcVal, dslcMatchingFont, dslcFont;

				dslcField = jQuery(this);
				dslcOption = dslcField.closest('.dslca-module-edit-option');

				jQuery(this).val( jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text() ).trigger('change');

				jQuery('.dslca-module-edit-field-font-suggest', dslcOption).text('');

			}

		});

	}

	/**
	 * MODULES - Icon option type
	 */

	function dslc_module_options_icon() {

		// Next Icon	

		jQuery(document).on( 'click', '.dslca-module-edit-field-icon-next',  function(e){

			e.preventDefault();

			var dslcOption = jQuery(this).closest('.dslca-module-edit-option-icon');
			var dslcField = jQuery( '.dslca-module-edit-field-icon', dslcOption );
			var dslcCurrIndex = dslcIconsCurrentSet.indexOf( dslcField.val() );
			var dslcNewIndex = dslcCurrIndex + 1;
			
			jQuery('.dslca-module-edit-field-icon-suggest', dslcOption).text('');

			dslcField.val( dslcIconsCurrentSet[dslcNewIndex] ).trigger('change');

		});

		// Previous Icon

		jQuery(document).on( 'click', '.dslca-module-edit-field-icon-prev',  function(e){

			e.preventDefault();

			var dslcOption = jQuery(this).closest('.dslca-module-edit-option-icon');
			var dslcField = jQuery( '.dslca-module-edit-field-icon', dslcOption );
			var dslcCurrIndex = dslcIconsCurrentSet.indexOf( dslcField.val() );
			var dslcNewIndex = dslcCurrIndex - 1;

			jQuery('.dslca-module-edit-field-icon-suggest', dslcOption).text('');

			if ( dslcNewIndex < 0 ) {
				dslcNewIndex = dslcIconsCurrentSet.length - 1
			}
			
			dslcField.val( dslcIconsCurrentSet[dslcNewIndex] ).trigger('change');

		});

		// Key Up ( arrow up, arrow down, else )

		jQuery(document).on( 'keyup', '.dslca-module-edit-field-icon', function(e) {

			var dslcField, dslcOption, dslcVal, dslcIconsArrayGrep, dslcIcon;

			dslcField = jQuery(this);
			dslcOption = dslcField.closest('.dslca-module-edit-option');

			if ( e.which == 38 ) {
				jQuery('.dslca-module-edit-field-icon-prev', dslcOption).click();
			}

			if ( e.which == 40 ) {
				jQuery('.dslca-module-edit-field-icon-next', dslcOption).click();
			}

			if ( e.which != 13 && e.which != 38 && e.which != 40 ) {

				dslcVal = dslcField.val().toLowerCase();
				dslcField.val( dslcVal );

				dslcIconsArrayGrep = jQuery.grep(dslcIconsCurrentSet, function(value, i) {
					return ( value.indexOf( dslcVal ) == 0 );
				});

				dslcIcon = dslcIconsArrayGrep[0];

				jQuery('.dslca-module-edit-field-icon-suggest', dslcOption).text( dslcIcon );

			}

		});

		// Key Press ( Enter )

		jQuery(document).on( 'keypress', '.dslca-module-edit-field-icon', function(e) {

			if ( e.which == 13 ) {

				e.preventDefault();

				var dslcField, dslcOption, dslcVal, dslcIconsArrayGrep, dslcIcon;

				dslcField = jQuery(this);
				dslcOption = dslcField.closest('.dslca-module-edit-option');

				jQuery(this).val( jQuery('.dslca-module-edit-field-icon-suggest', dslcOption).text() ).trigger('change');

				jQuery('.dslca-module-edit-field-icon-suggest', dslcOption).text('');

			}

		});

	}

	/**
	 * MODULES - Text align option type
	 */

	function dslc_module_options_text_align() {

		jQuery(document).on( 'click', '.dslca-module-edit-option-text-align-hook', function(){

			var newOpt = jQuery(this),
			otherOpt = jQuery(this).closest('.dslca-module-edit-option-text-align-wrapper').find('.dslca-module-edit-option-text-align-hook'),
			newVal = newOpt.data('val'),
			realOpt = jQuery(this).closest('.dslca-module-edit-option-text-align-wrapper').siblings('input.dslca-module-edit-field');
			
			otherOpt.removeClass('dslca-active');
			newOpt.addClass('dslca-active');

			realOpt.val( newVal ).trigger('change');

		});

	}

	/**
	 * MODULES - Checkbox Option Type
	 */

	function dslc_module_options_checkbox() {

		jQuery(document).on( 'click', '.dslca-module-edit-option-checkbox-hook, .dslca-modules-section-edit-option-checkbox-hook', function(){

			var checkFake = jQuery(this);
			var checkReal = checkFake.siblings('input[type="checkbox"]');

			if ( checkReal.prop('checked') ) {
				checkReal.prop('checked', false);
				checkFake.find('.dslca-icon').removeClass('dslc-icon-check').addClass('dslc-icon-check-empty');
			} else {
				checkReal.prop('checked', true);
				checkFake.find('.dslca-icon').removeClass('dslc-icon-check-empty').addClass('dslc-icon-check');
			}

			checkReal.change();

		});

	}

	/**
	 * MODULES - Box Shadow Option Type
	 */

	function dslc_module_options_box_shadow() {

		if ( dslcDebug ) console.log( 'dslc_module_options_box_shadow' );

		/**
		 * Value Change
		 */

		jQuery(document).on( 'change', '.dslca-module-edit-option-box-shadow-hor, .dslca-module-edit-option-box-shadow-ver, .dslca-module-edit-option-box-shadow-blur, .dslca-module-edit-option-box-shadow-spread, .dslca-module-edit-option-box-shadow-color, .dslca-module-edit-option-box-shadow-inset', function(){

			var boxShadowWrapper = jQuery(this).closest('.dslca-module-edit-option'),
			boxShadowInput = boxShadowWrapper.find('.dslca-module-edit-field'),
			boxShadowHor = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-hor').val(),
			boxShadowVer = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-ver').val(),
			boxShadowBlur = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-blur').val(),
			boxShadowSpread = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-spread').val(),
			boxShadowColor = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-color').val(),
			boxShadowInset = boxShadowWrapper.find('.dslca-module-edit-option-box-shadow-inset').is(':checked');
			
			if ( boxShadowInset ) { boxShadowInset = ' inset'; } else { boxShadowInset = ''; }			

			var boxShadowVal = boxShadowHor + 'px ' + boxShadowVer + 'px ' + boxShadowBlur + 'px ' + boxShadowSpread + 'px ' + boxShadowColor + boxShadowInset;

			boxShadowInput.val( boxShadowVal ).trigger('change');

		});

	}

	/**
	 * MODULES - Box Shadow Color Picker
	 */

	function dslc_modules_options_box_shadow_color() {

		/**
		 * Color Pallete
		 */

		var dslcColorPallete = [],
		currStorage,
		index;

		dslcColorPallete[0] = [];
		dslcColorPallete[1] = [];
		dslcColorPallete[2] = [];
		dslcColorPallete[3] = [];

		if ( localStorage['dslcColorpickerPalleteStorage'] == undefined ) {
		} else {
			currStorage = JSON.parse( localStorage['dslcColorpickerPalleteStorage'] );
			for	( index = 0; index < currStorage.length; index++ ) {
				var key = Math.floor( index / 3 );
				if ( key < 4 ) {
					dslcColorPallete[key].push( currStorage[index] );
				}
			}
		}

		jQuery('.dslca-module-edit-option-box-shadow-color').each( function(){

			var inputField = jQuery(this),
			currColor = inputField.val(),
			dslcColorField, dslcColorFieldVal;

			jQuery(this).spectrum({
				color: currColor,
				showInput: true,
				allowEmpty: true,
				showAlpha: true,
				clickoutFiresChange: true,
				cancelText: '',
				chooseText: '',
				preferredFormat: 'rgb',
				showPalette: true,
				palette: dslcColorPallete,
				move: function( color ) {
					
					// The option field
					dslcColorField = jQuery(this);

					// The new color
					if ( color == null )
						dslcColorFieldVal = 'transparent';
					else
						dslcColorFieldVal = color.toRgbString().replace(/ /g,'');

					// Change current value of option
					dslcColorField.val( dslcColorFieldVal ).trigger('change');

				},
				change: function( color ) {

					// The option field
					dslcColorField = jQuery(this);

					// The new color
					if ( color == null )
						dslcColorFieldVal = 'transparent';
					else
						dslcColorFieldVal = color.toRgbString().replace(/ /g,'');

					// Change current value of option
					dslcColorField.val( dslcColorFieldVal ).trigger('change');

					// Update pallete local storage
					if ( localStorage['dslcColorpickerPalleteStorage'] == undefined ) {
						var newStorage = [ dslcColorFieldVal ];
						localStorage['dslcColorpickerPalleteStorage'] = JSON.stringify(newStorage);
					} else {
						var newStorage = JSON.parse( localStorage['dslcColorpickerPalleteStorage'] );
						if ( newStorage.indexOf( dslcColorFieldVal ) == -1 ) {
							newStorage.unshift( dslcColorFieldVal );
						}
						localStorage['dslcColorpickerPalleteStorage'] = JSON.stringify(newStorage);
					}

				},
				show: function( color ) {
					jQuery('body').addClass('dslca-disable-selection');
				},
				hide: function() {
					jQuery('body').removeClass('dslca-disable-selection');
				}
			});

		});

	}

	/**
	 * MODULES - Text Shadow Option Type
	 */

	function dslc_module_options_text_shadow() {

		if ( dslcDebug ) console.log( 'dslc_module_options_text_shadow' );

		/**
		 * Value Change
		 */

		jQuery(document).on( 'change', '.dslca-module-edit-option-text-shadow-hor, .dslca-module-edit-option-text-shadow-ver, .dslca-module-edit-option-text-shadow-blur, .dslca-module-edit-option-text-shadow-color', function(){

			var textShadowWrapper = jQuery(this).closest('.dslca-module-edit-option'),
			textShadowInput = textShadowWrapper.find('.dslca-module-edit-field'),
			textShadowHor = textShadowWrapper.find('.dslca-module-edit-option-text-shadow-hor').val(),
			textShadowVer = textShadowWrapper.find('.dslca-module-edit-option-text-shadow-ver').val(),
			textShadowBlur = textShadowWrapper.find('.dslca-module-edit-option-text-shadow-blur').val(),
			textShadowColor = textShadowWrapper.find('.dslca-module-edit-option-text-shadow-color').val();

			var textShadowVal = textShadowHor + 'px ' + textShadowVer + 'px ' + textShadowBlur + 'px ' + textShadowColor;

			textShadowInput.val( textShadowVal ).trigger('change');

		});

	}

	/**
	 * MODULES - Text Shadow Color Picker
	 */

	function dslc_modules_options_text_shadow_color() {

		jQuery('.dslca-module-edit-option-text-shadow-color').each( function(){

			var inputField = jQuery(this),
			currColor = inputField.val(),
			dslcColorField, dslcColorFieldVal;

			jQuery(this).spectrum({
				color: currColor,
				showInput: true,
				allowEmpty: true,
				showAlpha: true,
				clickoutFiresChange: true,
				cancelText: '',
				chooseText: '',
				preferredFormat: 'rgb',
				move: function( color ) {
					
					// The option field
					dslcColorField = jQuery(this);

					// The new color
					if ( color == null )
						dslcColorFieldVal = 'transparent';
					else
						dslcColorFieldVal = color.toRgbString().replace(/ /g,'');

					// Change current value of option
					dslcColorField.val( dslcColorFieldVal ).trigger('change');

				},
				change: function( color ) {

					// The option field
					dslcColorField = jQuery(this);

					// The new color
					if ( color == null )
						dslcColorFieldVal = 'transparent';
					else
						dslcColorFieldVal = color.toRgbString().replace(/ /g,'');

					// Change current value of option
					dslcColorField.val( dslcColorFieldVal ).trigger('change');

				},
				show: function( color ) {
					jQuery('body').addClass('dslca-disable-selection');
				},
				hide: function() {
					jQuery('body').removeClass('dslca-disable-selection');
				}
			});

		});

	}

	/**
	 * MODULES - Color Option Type
	 */

	function dslc_module_options_color() {

		if ( dslcDebug ) console.log( 'dslc_module_options_color' );

		var dslcColorField,
		dslcAffectOnChangeEl,
		dslcAffectOnChangeRule,
		dslcColorFieldVal,
		dslcModule,
		dslcOptionID,
		dslcCurrColor;

		/**
		 * Color Pallete
		 */

		var dslcColorPallete = [],
		currStorage,
		index;

		dslcColorPallete[0] = [];
		dslcColorPallete[1] = [];
		dslcColorPallete[2] = [];
		dslcColorPallete[3] = [];

		if ( localStorage['dslcColorpickerPalleteStorage'] == undefined ) {
		} else {
			currStorage = JSON.parse( localStorage['dslcColorpickerPalleteStorage'] );
			for	( index = 0; index < currStorage.length; index++ ) {
				var key = Math.floor( index / 3 );
				if ( key < 4 ) {
					dslcColorPallete[key].push( currStorage[index] );
				}
			}
		}

		jQuery('.dslca-module-edit-field-colorpicker').each( function(){

			dslcCurrColor = jQuery(this).val();

			jQuery(this).spectrum({
				color: dslcCurrColor,
				showInput: true,
				allowEmpty: true,
				showAlpha: true,
				clickoutFiresChange: true,
				cancelText: '',
				chooseText: '',
				preferredFormat: 'rgb',
				showPalette: true,
				palette: dslcColorPallete,
				move: function( color ) {
					
					// The option field
					dslcColorField = jQuery(this);

					// The new color
					if ( color == null )
						dslcColorFieldVal = 'transparent';
					else
						dslcColorFieldVal = color.toRgbString();

					// Change current value of option
					dslcColorField.val( dslcColorFieldVal );

					// Live change
					dslcAffectOnChangeEl = dslcColorField.data('affect-on-change-el');
					dslcAffectOnChangeRule = dslcColorField.data('affect-on-change-rule');
					jQuery( dslcAffectOnChangeEl ,'.dslca-module-being-edited' ).css( dslcAffectOnChangeRule , dslcColorFieldVal );

					// Update option
					dslcModule = jQuery('.dslca-module-being-edited');
					dslcOptionID = dslcColorField.data('id');
					jQuery('.dslca-module-option-front[data-id="' + dslcOptionID + '"]', dslcModule).val( dslcColorFieldVal );

					// Add changed class
					dslcModule.addClass('dslca-module-change-made');

				},
				change: function( color ) {

					// The option field
					dslcColorField = jQuery(this);

					// The new color
					if ( color == null )
						dslcColorFieldVal = 'transparent';
					else
						dslcColorFieldVal = color.toRgbString();

					// Change current value of option
					dslcColorField.val( dslcColorFieldVal );

					// Live change
					dslcAffectOnChangeEl = dslcColorField.data('affect-on-change-el');
					dslcAffectOnChangeRule = dslcColorField.data('affect-on-change-rule');
					jQuery( dslcAffectOnChangeEl ,'.dslca-module-being-edited' ).css( dslcAffectOnChangeRule , dslcColorFieldVal );

					// Update option
					dslcModule = jQuery('.dslca-module-being-edited');
					dslcOptionID = dslcColorField.data('id');
					jQuery('.dslca-module-option-front[data-id="' + dslcOptionID + '"]', dslcModule).val( dslcColorFieldVal );

					// Add changed class
					dslcModule.addClass('dslca-module-change-made');

					// Update pallete local storage
					if ( localStorage['dslcColorpickerPalleteStorage'] == undefined ) {
						var newStorage = [ dslcColorFieldVal ];
						localStorage['dslcColorpickerPalleteStorage'] = JSON.stringify(newStorage);
					} else {
						var newStorage = JSON.parse( localStorage['dslcColorpickerPalleteStorage'] );
						if ( newStorage.indexOf( dslcColorFieldVal ) == -1 ) {
							newStorage.unshift( dslcColorFieldVal );
						}
						localStorage['dslcColorpickerPalleteStorage'] = JSON.stringify(newStorage);
					}

				},
				show: function( color ) {
					jQuery('body').addClass('dslca-disable-selection');
				},
				hide: function() {
					jQuery('body').removeClass('dslca-disable-selection');
				}
			});

		});

		// Revert to default
		jQuery('.dslca-sp-revert').click(function(){

			var defValue = jQuery('.sp-replacer.sp-active').closest('.dslca-module-edit-option').find('.dslca-module-edit-field').data('default');

			jQuery(this).closest('.sp-container').find('.sp-input').val( defValue ).trigger('change');

		});

	}

	/**
	 * MODULES - Numeric Option Type
	 */

	function dslc_module_options_numeric() {

		if ( dslcDebug ) console.log( 'dslc_module_options_numeric' );

		jQuery('.dslca-module-edit-field-slider').each(function(){

			var dslcSlider, dslcSliderField, dslcSliderInput, dslcSliderVal, dslcAffectOnChangeRule, dslcAffectOnChangeEl,
			dslcSliderTooltip, dslcSliderTooltipOffset, dslcSliderTooltipPos, dslcModule, dslcOptionID, dslcSliderExt,
			dslcAffectOnChangeRules;

			dslcSlider = jQuery(this);
			dslcSliderInput = dslcSlider.siblings('.dslca-module-edit-field');			

			dslcSliderTooltip = dslcSlider.closest('.dslca-module-edit-option-slider').find('.dslca-module-edit-field-slider-tooltip');

			dslcSlider.slider({
				min : dslcSliderInput.data('min'),
				max : dslcSliderInput.data('max'),
				step: dslcSliderInput.data('increment'),
				value: dslcSliderInput.val(),
				slide: function(event, ui) {  

					dslcSliderExt = dslcSliderInput.data('ext');
					dslcSliderVal = ui.value + dslcSliderExt;
					dslcSliderInput.val( dslcSliderVal );

					// Live change
					dslcAffectOnChangeEl = dslcSliderInput.data('affect-on-change-el');
					dslcAffectOnChangeRule = dslcSliderInput.data('affect-on-change-rule').replace(/ /g,'');
					dslcAffectOnChangeRules = dslcAffectOnChangeRule.split( ',' );

					// Loop through rules (useful when there are multiple rules)
					for ( var i = 0; i < dslcAffectOnChangeRules.length; i++ ) {
						jQuery( dslcAffectOnChangeEl ,'.dslca-module-being-edited' ).css( dslcAffectOnChangeRules[i] , dslcSliderVal );
					}

					// Update option
					dslcModule = jQuery('.dslca-module-being-edited');
					dslcOptionID = dslcSliderInput.data('id');
					jQuery('.dslca-module-option-front[data-id="' + dslcOptionID + '"]', dslcModule).val( ui.value );

					// Add changed class
					dslcModule.addClass('dslca-module-change-made');

					// Tooltip
					dslcSliderTooltip.text( dslcSliderVal );
					var dslcSliderHandle = dslcSlider.find('.ui-slider-handle');
					dslcSliderTooltipOffset = dslcSliderHandle[0].style.left;
					dslcSliderTooltip.css({ left : dslcSliderTooltipOffset });

					dslc_masonry( dslcModule );
					dslc_init_square();
					dslc_center();
					dslc_init_square( dslcModule );

				},
				stop: function( event, ui ) {

					dslcSliderTooltip.hide();

				},
				start: function( event, ui ) {

					dslcSliderTooltip.show();
					
					// Tooltip
					dslcSliderTooltip.text( dslcSliderVal );
					dslcSliderTooltipOffset = ui.handle.style.left;
					dslcSliderTooltip.css({ left : dslcSliderTooltipOffset });

				}

			});

		});

	}

	/**
	 * MODULES - Module output default settings
	 */

	function dslc_module_output_default( dslcModuleID, callback ) {

		if ( dslcDebug ) console.log( 'dslc_module_output_default' );

		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-add-module',
				dslc : 'active',
				dslc_module_id : dslcModuleID,
				dslc_post_id : jQuery('.dslca-container').data('post-id')
			},
			function( response ) {
				
				callback(response);

			}

		);

	}

	/**
	 * MODULES - Module output when settings altered
	 */

	function dslc_module_output_altered( callback ) {

		if ( dslcDebug ) console.log( 'dslc_module_output_altered' );

		callback = typeof callback !== 'undefined' ? callback : false;

		var dslcModule = jQuery('.dslca-module-being-edited'),
		dslcModuleID = dslcModule.data('dslc-module-id'),
		dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule ),
		dslcModuleInstanceID = dslcModule.data('module-id');

		/**
		 * Generate code
		 */

		var dslcSettings = {};

		dslcSettings['action'] = 'dslc-ajax-add-module';
		dslcSettings['dslc'] = 'active';
		dslcSettings['dslc_module_id'] = dslcModuleID;
		dslcSettings['dslc_module_instance_id'] = dslcModuleInstanceID;
		dslcSettings['dslc_post_id'] = jQuery('.dslca-container').data('post-id');
		
		if ( dslcModule.hasClass('dslca-preload-preset') )
			dslcSettings['dslc_preload_preset'] = 'enabled';
		else
			dslcSettings['dslc_preload_preset'] = 'disabled';

		dslcModule.removeClass('dslca-preload-preset');

		dslcModuleOptions.each(function(){

			var dslcOption = jQuery(this);
			var dslcOptionID = dslcOption.data('id');
			var dslcOptionValue = dslcOption.val();

			dslcSettings[dslcOptionID] = dslcOptionValue;

		});

		/**
		 * Call AJAX for preview
		 */
		jQuery.post(

			DSLCAjax.ajaxurl, dslcSettings,
			function( response ) {

				dslcModule.after(response.output).next().addClass('dslca-module-being-edited');
				dslcModule.remove();
				dslc_generate_code();
				dslc_show_publish_button();
					
				dslc_carousel();
				dslc_masonry( jQuery('.dslca-module-being-edited') );
				jQuery( '.dslca-module-being-edited img' ).load( function(){
					dslc_masonry( jQuery('.dslca-module-being-edited') );
					dslc_center();
				});
				dslc_tabs();
				dslc_init_accordion();
				dslc_init_square();
				dslc_center();

				if ( callback ) {
					callback( response );
				}

			}

		);

	}

	/**
	 * MODULES - Reload a specific module
	 */

	function dslc_module_output_reload( dslcModule, callback ) {

		if ( dslcDebug ) console.log( 'dslc_module_output_reload' );

		callback = typeof callback !== 'undefined' ? callback : false;

		var dslcModuleID = dslcModule.data('dslc-module-id'),
		dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule ),
		dslcModuleInstanceID = dslcModule.data('module-id');

		/**
		 * Generate code
		 */

		var dslcSettings = {};

		dslcSettings['action'] = 'dslc-ajax-add-module';
		dslcSettings['dslc'] = 'active';
		dslcSettings['dslc_module_id'] = dslcModuleID;
		dslcSettings['dslc_module_instance_id'] = dslcModuleInstanceID;
		dslcSettings['dslc_post_id'] = jQuery('.dslca-container').data('post-id');
		dslcSettings['dslc_preload_preset'] = 'enabled';
		dslcModule.removeClass('dslca-preload-preset');

		dslcModuleOptions.each(function(){

			var dslcOption = jQuery(this);
			var dslcOptionID = dslcOption.data('id');
			var dslcOptionValue = dslcOption.val();

			dslcSettings[dslcOptionID] = dslcOptionValue;

		});

		/**
		 * Loader
		 */

		dslcModule.append('<div class="dslca-module-reloading"><span class="dslca-icon dslc-icon-spin dslc-icon-refresh"></span></div>');

		/**
		 * Call AJAX for preview
		 */
		jQuery.post(

			DSLCAjax.ajaxurl, dslcSettings,
			function( response ) {

				dslcModule.after(response.output).next().addClass('dslca-module-being-edited');
				dslcModule.remove();
				dslc_generate_code();
				dslc_show_publish_button();
					
				dslc_carousel();
				dslc_masonry( jQuery('.dslca-module-being-edited') );
				jQuery( '.dslca-module-being-edited img' ).load( function(){
					dslc_masonry( jQuery('.dslca-module-being-edited') );
					dslc_center();
				});
				dslc_tabs();
				dslc_init_accordion();
				dslc_init_square();
				dslc_center();

				if ( callback ) {
					callback( response );
				}

				jQuery('.dslca-module-being-edited').removeClass('dslca-module-being-edited');

			}

		);

	}

	/**
	 * Deprecated Functions and Fallbacks
	 */

	function dslc_delete_module( module ) { dslc_module_delete( module ); }
	function dslc_copy_module( module ) { dslc_module_copy( module ); }
	function dslc_display_module_options( moduleID ) { dslc_module_options_show( moduleID ); }
	function dslc_filter_module_options( sectionID ) { dslc_module_options_section_filter( sectionID ); }
	function dslc_show_module_options_tab( tab ) { dslc_module_options_tab_filter( tab ); }
	function dslc_confirm_changes( callback ) { dslc_module_options_confirm_changes( callback ); }
	function dslc_cancel_changes( callback ) { dslc_module_options_cancel_changes( callback ); }
	function dslc_init_colorpicker() { dslc_module_options_color(); }
	function dslc_init_options_slider() { dslc_module_options_numeric(); }
	function dslc_init_options_scrollbar() { dslc_module_options_scrollbar(); }
	function dslc_module_edit_options_hideshow_tabs() { dslc_module_options_hideshow_tabs(); }
	function dslc_get_module_output( moduleID, callback ) { dslc_module_output_default( moduleID, callback ); }
	function dslc_preview_change( callback ) { dslc_module_output_altered( callback ); }
	function dslc_reload_module( moduleID, callback ) { dslc_module_output_reload( moduleID, callback ); }


	/**
	 * Modules - Document Ready
	 */

	jQuery(document).ready(function($){

		dslc_module_options_tooltip();
		dslc_module_options_font();
		dslc_module_options_icon();
		dslc_module_options_text_align();
		dslc_module_options_checkbox();
		dslc_module_options_box_shadow();
		dslc_module_options_text_shadow();

		/**
		 * Hook - Submit
		 */

		$('.dslca-module-edit-form').submit( function(e){

			e.preventDefault();
			dslc_module_output_altered();

		});

		/**
		 * Hook - Copy Module
		 */

		$(document).on( 'click', '.dslca-copy-module-hook', function(e){

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				dslc_module_copy( $(this).closest('.dslc-module-front') );
			}

		});

		/**
		 * Hook - Module Delete
		 */

		 $(document).on( 'click', '.dslca-delete-module-hook', function(e){

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {

				dslc_js_confirm( 'delete_module', '<span class="dslca-prompt-modal-title">' + DSLCString.str_del_module_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_del_module_descr + '</span>', $(this) );

			}

		});

		/**
		 * Action - Show/Hide Width Options
		 */

		$(document).on( 'click', '.dslca-change-width-module-hook', function(e){

			e.preventDefault();

			if ( ! $(this).hasClass('dslca-action-disabled') ) {
				$('.dslca-change-width-module-options', this).toggle();
				$(this).closest('.dslca-module-manage').toggleClass('dslca-module-manage-change-width-active');
			}

		});

		/**
		 * Hook - Set Module Width
		 */

		$(document).on( 'click', '.dslca-change-width-module-options span', function(){

			dslc_module_width_set( jQuery(this).closest('.dslc-module-front'), jQuery(this).data('size') );

		});

		/**
		 * Hook - Module Edit ( Display Options )
		 */

		$(document).on( 'click', '.dslca-module-edit-hook', function(e){

			e.preventDefault();

			// If composer not hidden 
			if ( ! $('body').hasClass( 'dslca-composer-hidden' ) ) {

				// If another module being edited and has changes
				if ( $('.dslca-module-being-edited.dslca-module-change-made').length ) {

					dslc_js_confirm( 'edit_in_progress', '<span class="dslca-prompt-modal-title">' + DSLCString.str_module_curr_edit_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_module_curr_edit_descr + '</span>', $(this) );

				// If a section is being edited and has changes
				} else if ( $('.dslca-modules-section-being-edited.dslca-modules-section-change-made').length ) {

					dslc_js_confirm( 'edit_in_progress', '<span class="dslca-prompt-modal-title">' + DSLCString.str_row_curr_edit_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_row_curr_edit_descr + '</span>', $(this) );

				// All good, proceed
				} else {

					// If a module section is being edited but has no changes, cancel it
					if ( $('.dslca-modules-section-being-edited').length ) {
						$('.dslca-module-edit-cancel').trigger('click');
					}
					
					// Vars
					var dslcModule = $(this).closest('.dslc-module-front'),
					dslcModuleID = dslcModule.data('dslc-module-id'),
					dslcModuleCurrCode = dslcModule.find('.dslca-module-code').val();

					// If a module is bening edited remove the "being edited" class from it
					$('.dslca-module-being-edited').removeClass('dslca-module-being-edited');

					// Add the "being edited" class to current module
					dslcModule.addClass('dslca-module-being-edited');

					// Call the function to display options
					dslc_module_options_show( dslcModuleID );

				}

			}

		}); 

		/**
		 * Hook - Tab Switch
		 */

		$(document).on( 'click', '.dslca-module-edit-options-tab-hook', function(){
			dslc_module_options_tab_filter( $(this) );
		});

		/**
		 * Hook - Option Section Switch
		 */

		$(document).on( 'click', '.dslca-options-filter-hook', function(e){

			var dslcPrev = jQuery('.dslca-options-filter-hook.dslca-active').data('section');

			$('.dslca-options-filter-hook.dslca-active').removeClass('dslca-active');
			$(this).addClass('dslca-active');

			dslc_module_options_section_filter( jQuery(this).data('section') );

			// If previous was responsive reload module
			if ( dslcPrev == 'responsive' ) {

				// Show the loader
				jQuery('.dslca-container-loader').show();

				// Reset the responsive classes
				dslc_responsive_classes();

				// Reload Module
				dslc_module_output_altered(function(){

					// Hide the loader
					jQuery('.dslca-container-loader').hide();

				});

			}

		});

		/**
		 * Hook - Confirm Changes
		 */

		$(document).on( 'click', '.dslca-module-edit-save', function(){

			dslc_module_options_confirm_changes();
			$('.dslca-options-filter-hook.dslca-active').removeClass('dslca-active');
			dslc_responsive_classes( true );

		});

		/**
		 * Hook - Cancel Changes
		 */

		$(document).on( 'click', '.dslca-module-edit-cancel', function(){

			dslc_module_options_cancel_changes();
			$('.dslca-options-filter-hook.dslca-active').removeClass('dslca-active');
			dslc_responsive_classes( true );

		});

		/**
		 * Hook - Show/Hide Icon Set Switch
		 */

		jQuery(document).on( 'click', '.dslca-module-edit-field-icon-switch-set', function(){

			var dslcTtip = jQuery('.dslca-module-edit-field-icon-switch-sets');
			var dslcHook = jQuery(this);

			// Add/Remo active classes
			jQuery('.dslca-module-edit-field-icon-switch-set.dslca-active').removeClass('dslca-active');
			dslcHook.addClass('dslca-active');

			if ( dslcTtip.is(':visible') ) {

				jQuery('.dslca-module-edit-field-icon-switch-sets').hide();

			} else {

				// Icon vars
				var currIconSet = dslcHook.find('.dslca-module-edit-field-icon-curr-set').text();

				jQuery('.dslca-module-edit-field-icon-switch-sets span.dslca-active').removeClass('dslca-active');
				jQuery('.dslca-module-edit-field-icon-switch-sets span[data-set="' + currIconSet + '"]').addClass('dslca-active');

				// Positioning vars
				var dslcOffset = dslcHook.offset(),
				dslcTtipHeight = dslcTtip.outerHeight(),
				dslcTtipWidth = dslcTtip.outerWidth(),
				dslcTtipLeft = dslcOffset.left - ( dslcTtipWidth / 2 ) + 6,
				dslcTtipArrLeft = '50%';

				if ( dslcTtipLeft < 0 ) {
					dslcTtipArrLeft = ( dslcTtipWidth / 2 ) + dslcTtipLeft + 'px';
					dslcTtipLeft = 0;
				}			

				jQuery('.dslca-module-edit-field-icon-switch-sets').show().css({
					top : dslcOffset.top - dslcTtipHeight - 20,
					left: dslcTtipLeft
				});

				jQuery("head").append(jQuery('<style>.dslca-module-edit-field-icon-switch-sets:after, .dslca-module-edit-field-icon-switch-sets:before { left: ' + dslcTtipArrLeft + ' }</style>'));

			}

		});

		/**
		 * Hook - Switch Icon Set
		 */

		jQuery(document).on( 'click', '.dslca-module-edit-field-icon-switch-sets span', function(){

			var iconSet = $(this).data('set');

			// Change current icon set
			dslcIconsCurrentSet = DSLCIcons[iconSet];

			// Change active states
			$(this).addClass('dslca-active').siblings('.dslca-active').removeClass('dslca-active');

			// Change current text
			$('.dslca-module-edit-field-icon-switch-set.dslca-active .dslca-module-edit-field-icon-curr-set').text( iconSet );

			// Go to next icon
			$('.dslca-module-edit-field-icon-switch-set.dslca-active').closest('.dslca-module-edit-option').find('.dslca-module-edit-field-icon-next').trigger('click');

			// Hide sets
			$('.dslca-module-edit-field-icon-switch-sets').hide();

		});

		/**
		 * Action - Change current set on mouse enter of icon option
		 */

		jQuery(document).on( 'mouseenter', '.dslca-module-edit-option-icon', function(){

			var iconSet = $(this).find('.dslca-module-edit-field-icon-curr-set').text();

			// Change current icon set
			dslcIconsCurrentSet = DSLCIcons[iconSet];

		});

	});


/*********************************
 *
 * 9) = TEMPLATES =
 *
 * - dslc_load_template ( Load Template )
 * - dslc_import_template ( Import Template )
 * - dslc_save_template ( Save TEmplate )
 * - dslc_delete_template ( Delete Template )
 *
 ***********************************/

 	/**
 	 * TEMPLATES - Load
 	 */

 	function dslc_template_load( template ) {

		if ( dslcDebug ) console.log( 'dslc_load_template' );

		// Vars
		var dslcModule, dslcModuleID;

		// Ajax call to get template's HTML
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-load-template',
				dslc : 'active',
				dslc_template_id : template
			},
			function( response ) {
				
				// Apply the template's HTML
				jQuery('#dslc-main').html( response.output );

				// Call other functions
				dslc_carousel();
				dslc_drag_and_drop();
				dslc_show_publish_button();
				dslc_generate_code();

			}

		);

	}

	/**
	 * TEMPLATES - Import
	 */

	function dslc_template_import() {

		if ( dslcDebug ) console.log( 'dslc_import_template' );

		// Vars
		var dslcModule, dslcModuleID;

		// Hide the title on the button and show loading animation
		jQuery('.dslca-modal-templates-import .dslca-modal-title').css({ opacity : 0 });
		jQuery('.dslca-modal-templates-import .dslca-loading').show();

		// Ajax call to load template's HTML
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-import-template',
				dslc : 'active',
				dslc_template_code : jQuery('#dslca-import-code').val()
			},
			function( response ) {
				
				// Apply the template's HTML
				jQuery('#dslc-main').html( response.output );

				// Hide the loading on the button and show the title
				jQuery('.dslca-modal-templates-import .dslca-loading').hide();
				jQuery('.dslca-modal-templates-import .dslca-modal-title').css({ opacity : 1 });

				// Hide the modal
				dslc_hide_modal( '', '.dslca-modal-templates-import' );

				// Call other functions
				dslc_bg_video();
				dslc_center();
				dslc_drag_and_drop();
				dslc_show_publish_button();
				dslc_generate_code();

			}

		);

	}

	/**
	 * TEMPLATES - SAVE
	 */

	function dslc_template_save() {	

		if ( dslcDebug ) console.log( 'dslc_save_template' );

		// AJAX call to save the template
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-save-template',
				dslc : 'active',
				dslc_template_code : jQuery('#dslca-code').val(),
				dslc_template_title : jQuery('#dslca-save-template-title').val()
			},
			function( response ) {
				
				// Hide the modal
				dslc_hide_modal( '', '.dslca-modal-templates-save' );

			}

		);

	}

	/**
	 * TEMPLATES - DELETE
	 */

	function dslc_template_delete( template ) {

		if ( dslcDebug ) console.log( 'dslc_delete_template' );

		// AJAX call to delete template
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-delete-template',
				dslc : 'active',
				dslc_template_id : template
			},
			function( response ) {
				
				// Remove template from the template listing
				jQuery('.dslca-template[data-id="' + template + '"]').fadeOut(200, function(){
					jQuery(this).remove();
				});

			}

		);

	}

	/**
	 * Deprecated Functions and Fallbacks
	 */

	 function dslc_load_template( template ) { dslc_template_load( template ); }
	 function dslc_import_template() { dslc_template_import(); }
	 function dslc_save_template() { dslc_template_save(); }
	 function dslc_delete_template( template ) { dslc_template_delete( template ); }

	 /**
	  * TEMPLATES - Document Ready
	  */

	jQuery(document).ready(function($) {

		/**
		 * Hook - Load Template
		 */
		
		$(document).on( 'click', '.dslca-template', function(){

			dslc_template_load( jQuery(this).data('id') );

		});

		/**
		 * Hook - Import Template
		 */
		
		$('.dslca-template-import-form').submit(function(e){

			e.preventDefault();
			dslc_template_import();

		});

		/**
		 * Hook - Save Template
		 */

		$('.dslca-template-save-form').submit(function(e){

			e.preventDefault();
			dslc_template_save();

		});

		/**
		 * Hook - Delete Template
		 */
		
		$(document).on( 'click', '.dslca-delete-template-hook', function(e){

			e.stopPropagation();
			dslc_template_delete( $(this).data('id') );

		});
		
	});


/*********************************
 *
 * = 10) = CODE GENERATION =
 *
 * - dslc_save_composer ( Save the Page Changes )
 * - dslc_save_draft_composer ( Save the changes as draft, not publish )
 * - dslc_generate_code ( Generates Page's LC data )
 * - dslc_generate_section_code ( Generate LC data for a specific row/section )
 *
 ***********************************/
 	
 	/**
 	 * CODE GENERATION - Save Page Changes
 	 */

 	function dslc_save_composer() {

		if ( dslcDebug ) console.log( 'dslc_save_composer' );

		// Vars
		var composerCode = jQuery('#dslca-code').val(),
		contentForSearch = jQuery('#dslca-content-for-search').val(),
		postID = jQuery('.dslca-container').data('post-id');

		// Apply class to body to know saving is in progress
		jQuery('body').addClass('dslca-saving-in-progress');

		// Replace the check in publish button with a loading animation
		jQuery('.dslca-save-composer .dslca-icon').removeClass('dslc-icon-ok').addClass('dslc-icon-spin dslc-icon-spinner');

		// Ajax call to save the new content
		jQuery.ajax({
			method: 'POST',
			type: 'POST',
			url: DSLCAjax.ajaxurl,
			data: {
				action : 'dslc-ajax-save-composer',
				dslc : 'active',
				dslc_post_id : postID,
				dslc_code : composerCode,
				dslc_content_for_search : contentForSearch
			},
			timeout: 10000
		}).done(function( response ) {

			// On success hide the publish button 
			if ( response.status == 'success' ) {
				jQuery('.dslca-save-composer').fadeOut(250);
				jQuery('.dslca-save-draft-composer').fadeOut(250);
			// On fail show an alert message
			} else {
				alert( 'Something went wrong, please try to save again.' );
			}

		}).fail(function( response ) {

			if ( response.statusText == 'timeout' ) {
				alert( 'The request timed out after 10 seconds. Please try again.' );
			} else {
				alert( 'Something went wrong. Please try again.' );
			}

		}).always(function( reseponse ) {

			// Replace the loading animation with a check icon
			jQuery('.dslca-save-composer .dslca-icon').removeClass('dslc-icon-spin dslc-icon-spinner').addClass('dslc-icon-ok')

			// Remove the class previously added so we know saving is finished
			jQuery('body').removeClass('dslca-saving-in-progress');

		});

	}

	/**
 	 * CODE GENERATION - Save Draft
 	 */

 	function dslc_save_draft_composer() {

		if ( dslcDebug ) console.log( 'dslc_save_draft_composer' );

		// Vars
		var composerCode = jQuery('#dslca-code').val(),
		postID = jQuery('.dslca-container').data('post-id');

		// Apply class to body to know saving is in progress
		jQuery('body').addClass('dslca-saving-in-progress');

		// Replace the check in publish button with a loading animation
		jQuery('.dslca-save-draft-composer .dslca-icon').removeClass('dslc-icon-ok').addClass('dslc-icon-spin dslc-icon-spinner');

		// Ajax call to save the new content
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-save-draft-composer',
				dslc : 'active',
				dslc_post_id : postID,
				dslc_code : composerCode,
			},
			function( response ) {

				// Replace the loading animation with a check icon
				jQuery('.dslca-save-draft-composer .dslca-icon').removeClass('dslc-icon-spin dslc-icon-spinner').addClass('dslc-icon-save')

				// On success hide the publish button 
				if ( response.status == 'success' ) {
					jQuery('.dslca-save-draft-composer').fadeOut(250);

				// On fail show an alert message
				} else {
					alert( 'Something went wrong, please try to save again.' );
				}
				
				// Remove the class previously added so we know saving is finished
				jQuery('body').removeClass('dslca-saving-in-progress');

			}

		);

	}

	/**
	 * CODE GENERATION - Generate LC Data
	 */

	function dslc_generate_code() {

		if ( dslcDebug ) console.log( 'dslc_generate_code' );

		// Vars
		var moduleCode,
		moduleSize,
		composerCode = '',
		maxPerRow = 12,
		maxPerRowA = 12,
		currPerRow = 0,
		currPerRowA = 0,
		modulesAreaSize,
		modulesArea,
		modulesAreaLastState,
		modulesAreaFirstState,
		modulesSection,
		modulesSectionAtts = '';

		/**
		 * Go through module areas (empty or not empty)
		 */

		jQuery('#dslc-main .dslc-modules-area').each(function(){		

			if ( jQuery('.dslc-module-front', this).length ) {
				jQuery(this).removeClass('dslc-modules-area-empty').addClass('dslc-modules-area-not-empty');
				jQuery('.dslca-no-content', this).hide();
			} else {
				jQuery(this).removeClass('dslc-modules-area-not-empty').addClass('dslc-modules-area-empty');
				jQuery('.dslca-no-content:not(:visible)', this).show().css({
					'-webkit-animation-name' : 'dslcBounceIn',
					'-moz-animation-name' : 'dslcBounceIn',
					'animation-name' : 'dslcBounceIn',
					'animation-duration' : '0.6s',
					'-webkit-animation-duration' : '0.6s',
					padding : 0
				}).animate({ padding : '35px 0' }, 300);
			}

		});

		/**
		 * Go through module sections (empty or not empty)
		 */
		 
		jQuery('#dslc-main .dslc-modules-section').each(function(){		

			if ( jQuery('.dslc-modules-area', this).length ) {
				jQuery(this).removeClass('dslc-modules-section-empty').addClass('dslc-modules-section-not-empty');
			} else {
				jQuery(this).removeClass('dslc-modules-section-not-empty').addClass('dslc-modules-section-empty');
			}

		});

		// Remove last and first classes
		jQuery('#dslc-main .dslc-modules-area.dslc-last-col, .dslc-modules-area.dslc-first-col').removeClass('dslc-last-col dslc-first-col');
		jQuery('#dslc-main .dslc-module-front.dslc-last-col, .dslc-module-front.dslc-first-col').removeClass('dslc-last-col dslc-first-col');

		/**
		 * Go through each row
		 */

		jQuery('#dslc-main .dslc-modules-section').each(function(){

			// Vars
			currPerRowA = 0;
			modulesSection = jQuery(this);

			// Generate attributes for row shortcode
			modulesSectionAtts = '';
			jQuery('.dslca-modules-section-settings input', modulesSection).each(function(){
				modulesSectionAtts = modulesSectionAtts + jQuery(this).data('id') + '="' + jQuery(this).val() + '" ';
			});

			// Open the module section ( row ) shortcode
			composerCode = composerCode + '[dslc_modules_section ' + modulesSectionAtts + '] ';

			/**
			 * Go through each column of current row
			 */

			jQuery('.dslc-modules-area', modulesSection).each(function(){

				// Vars
				modulesArea = jQuery(this);
				modulesAreaSize = parseInt( modulesArea.data('size') );
				modulesAreaLastState = 'no';
				modulesAreaFirstState = 'no';

				// Increment area column counter
				currPerRowA += modulesAreaSize;

				// If area column counter same as maximum
				if ( currPerRowA == maxPerRowA ) {

					// Apply classes to current and next column
					jQuery(this).addClass('dslc-last-col').next('.dslc-modules-area').addClass('dslc-first-col');

					// Reset area column counter
					currPerRowA = 0;

					// Set shortcode's "last" attribute to "yes"
					modulesAreaLastState = 'yes';

				// If area column counter bigger than maximum
				} else if ( currPerRowA > maxPerRowA ) {

					// Apply classes to current and previous column
					jQuery(this).removeClass('dslc-last-col').addClass('dslc-first-col');

					// Set area column counter to the size of the current area
					currPerRowA = modulesAreaSize;

					// Set shortcode's "first" attribute to yes
					modulesAreaFirstState = 'yes';

				}

				// If area column counter same as current area size
				if ( currPerRowA == modulesAreaSize ) {
					// Set shortcode's "first" attribute to yes
					modulesAreaFirstState = 'yes';	
				}

				// Open the modules area ( area ) shortcode
				composerCode = composerCode + '[dslc_modules_area last="' + modulesAreaLastState + '" first="' + modulesAreaFirstState + '" size="' + modulesAreaSize + '"] ';

				/**
				 * Go through each module of current area
				 */

				jQuery('.dslc-module-front', modulesArea).each(function(){

					// Vars
					moduleSize = parseInt( jQuery(this).data('dslc-module-size') );
					var moduleLastState = 'no';
					var moduleFirstState = 'no';

					// Increment modules column counter
					currPerRow += moduleSize;

					// If modules column counter same as maximum
					if ( currPerRow == maxPerRow ) {

						// Add classes to current and next module
						jQuery(this).addClass('dslc-last-col').next('.dslc-module-front').addClass('dslc-first-col');

						// Reset modules column counter
						currPerRow = 0;

						// Set shortcode's "last" state to "yes"
						moduleLastState = 'yes';

					// If modules column counter bigger than maximum
					} else if ( currPerRow > maxPerRow ) {

						// Add classes to current and previous module
						jQuery(this).removeClass('dslc-last-col').addClass('dslc-first-col');

						// Set modules column counter to the size of current module
						currPerRow = moduleSize;

						// Set shortcode's "first" state to "yes"
						moduleFirstState = 'yes';

					}

					// If modules column counter same as maximum
					if ( currPerRow == maxPerRow ) {

						// Set shorcode's "first" state to "yes"
						moduleFirstState = 'yes';	

						// Add classes for current and next module
						jQuery(this).addClass('dslc-last-col').next('.dslc-module-front').addClass('dslc-first-col');

						// Resest modules column counter
						currPerRow = 0;
					}					

					// Get module's LC data
					moduleCode = jQuery(this).find('.dslca-module-code').val();

					// Add the module shortcode containing the data
					composerCode = composerCode + '[dslc_module last="' + moduleLastState + '"]' + moduleCode + '[/dslc_module] ';

				});
				
				// Close area shortcode
				composerCode = composerCode + '[/dslc_modules_area] ';

			});
	
			// Close row ( section ) shortcode
			composerCode = composerCode + '[/dslc_modules_section] ';

		});
	
		// Apply the new code values to the setting containers
		jQuery('#dslca-code').val(composerCode);
		jQuery('#dslca-export-code').val(composerCode);

		// Generate content for search
		dslca_gen_content_for_search();

	}

	/**
	 * CODE GENERATION - Generate LC Data for Section
	 */

	function dslc_generate_section_code( theModulesSection ) {

		if ( dslcDebug ) console.log( 'dslc_generate_section_code' );

		var moduleCode,
		moduleSize,
		composerCode = '',
		maxPerRow = 12,
		maxPerRowA = 12,
		currPerRow = 0,
		currPerRowA = 0,
		modulesAreaSize,
		modulesArea,
		modulesAreaLastState,
		modulesAreaFirstState,
		modulesSection,
		modulesSectionAtts = '';

		currPerRowA = 0;

		var modulesSection = theModulesSection;

		jQuery('.dslca-modules-section-settings input', modulesSection).each(function(){

			modulesSectionAtts = modulesSectionAtts + jQuery(this).data('id') + '="' + jQuery(this).val() + '" ';

		});

		composerCode = composerCode + '[dslc_modules_section ' + modulesSectionAtts + '] ';

		// Go through each modules area
		jQuery('.dslc-modules-area', modulesSection).each(function(){

			modulesArea = jQuery(this);
			modulesAreaSize = parseInt( modulesArea.data('size') );
			modulesAreaLastState = 'no';
			modulesAreaFirstState = 'no';

			currPerRowA += modulesAreaSize;
			if ( currPerRowA == maxPerRowA ) {
				jQuery(this).addClass('dslc-last-col').next('.dslc-modules-area').addClass('dslc-first-col');
				currPerRowA = 0;
				modulesAreaLastState = 'yes';
			} else if ( currPerRowA > maxPerRowA ) {
				jQuery(this).removeClass('dslc-last-col').addClass('dslc-first-col');
				currPerRowA = modulesAreaSize;
				modulesAreaFirstState = 'yes';
			}

			if ( currPerRowA == modulesAreaSize ) {
				modulesAreaFirstState = 'yes';	
			}

			composerCode = composerCode + '[dslc_modules_area last="' + modulesAreaLastState + '" first="' + modulesAreaFirstState + '" size="' + modulesAreaSize + '"] ';

			// Go through each module in the area
			jQuery('.dslc-module-front', modulesArea).each(function(){

				moduleSize = parseInt( jQuery(this).data('dslc-module-size') );
				currPerRow += moduleSize;

				if ( currPerRow == modulesAreaSize ) {
					jQuery(this).addClass('dslc-last-col').next('.dslc-module-front').addClass('dslc-first-col');
					currPerRow = 0;
				}		

				moduleCode = jQuery(this).find('.dslca-module-code').val();
				composerCode = composerCode + '[dslc_module]' + moduleCode + '[/dslc_module] ';

			});

			composerCode = composerCode + '[/dslc_modules_area] ';

		});

		composerCode = composerCode + '[/dslc_modules_section] ';

		return composerCode;

	}

	/**
	 * CODE GENERATION - Document Ready
	 */

	jQuery(document).ready(function($){

		/**
		 * Hook - Save Page
		 */

		$(document).on( 'click', '.dslca-save-composer-hook', function(){

			// If some saving action not already in progress
			if ( ! $('body').hasClass('dslca-module-saving-in-progress') && ! $('body').hasClass('dslca-saving-in-progress') ) {
				// Call the function to save
				dslc_save_composer();
			}

		});

		/**
		 * Hook - Save Draft
		 */

		$(document).on( 'click', '.dslca-save-draft-composer-hook', function(){

			// If some saving action not already in progress
			if ( ! $('body').hasClass('dslca-module-saving-in-progress') && ! $('body').hasClass('dslca-saving-in-progress') ) {
				// Call the function to save
				dslc_save_draft_composer();
			}

		});
		
	});



/*********************************
 *
 * 11) = MODULE PRESETS =
 *
 * - dslc_update_preset ( Update Styling Preset )
 *
 ***********************************/

 	/**
 	 * Module Presets - Update
 	 */

	function dslc_update_preset() {

		if ( dslcDebug ) console.log( 'dslc_update_preset' );

		// Vars
		var module = jQuery('.dslca-module-being-edited'),
		presetName = module.find('.dslca-module-option-front[data-id="css_load_preset"]').val(),
		presetCode = module.find('.dslca-module-code').val(),
		moduleID = module.data('dslc-module-id');

		// If preset value not "none"
		if ( presetName !== 'none' ) {

			// AJAX Call to Save Preset
			jQuery.post(

				DSLCAjax.ajaxurl,
				{
					action : 'dslc-ajax-save-preset',
					dslc_preset_name : presetName,
					dslc_preset_code : presetCode,
					dslc_module_id : moduleID
				},
				function( response ) {

					// Reload all modules with the same preset
					jQuery('.dslc-module-front:not(#' + module.attr('id') + ')[data-dslc-module-id="' + module.data('dslc-module-id') + '"][data-dslc-preset="' + module.data('dslc-preset') + '"]').each(function(){
						dslc_module_output_reload( jQuery(this) );
					});

				}

			);

		}

	}

	/**
	 * Module Presets - Document Ready
	 */

	jQuery(document).ready(function($){

		/**
		 * Action - Save preset
		 */

		$(document).on( 'keypress', '.dslca-module-edit-field[name="css_save_preset"]', function(e){
			
			// Enter Key Pressed
			if ( e.which == 13 ) {

				// Vars
				var presetName = $(this).val(),
				presetID = presetName.toLowerCase().replace(/\s/g, '-');	

				// Add class to body that a new preset is added
				$('body').addClass('dslca-new-preset-added');

				// Append the new preset to the "Load Preset" option and trigger change
				$('.dslca-module-edit-field[name="css_load_preset"]').append('<option value="' + presetID + '">' + presetID + '</option>').val( presetID ).trigger('change');

				// Erase value from the "Save Preset" option
				$(this).val('');

			}

		});

		/**
		 * Action - Preset value changed
		 */

		$(document).on( 'change', '.dslca-module-edit-field[name="css_load_preset"]', function(e){
			$('.dslca-module-being-edited').addClass('dslca-preload-preset');
		});
		
	});


/*********************************
 *
 * 12) = OTHER =
 *
 * - dslc_dm_get_defaults ( Get Alter Module Defaults Code )
 * - dslca_gen_content_for_search ( Generate Readable Content For Search )
 * - dslca_draggable_calc_center ( Recalculate drag and drop centering )
 * - dslc_editable_content_gen_code ( Generate code of editable content )
 *
 ***********************************/

 	/**
 	 * Other - Get Alter Module Defaults Code
 	 */

 	function dslc_dm_get_defaults( module ) {

		if ( dslcDebug ) console.log( 'dslc_dm_get_defaults' );

		// The module code value
		var optionsCode = module.find('.dslca-module-code').val();

		// Ajax call to get the plain PHP code
		jQuery.post(

			DSLCAjax.ajaxurl,
			{
				action : 'dslc-ajax-dm-module-defaults',
				dslc : 'active',
				dslc_modules_options : optionsCode
			},
			function( response ) {

				// Apply the plain PHP code to the textarea
				jQuery('.dslca-prompt-modal textarea').val( response.output );

			}

		);

	}

	/**
	* Other - Generate Readable Content For Search
	*/

	function dslca_gen_content_for_search() {

		if ( dslcDebug ) console.log( 'dslca_gen_content_for_search' );
		
		// Vars
		var holder = jQuery('#dslca-content-for-search'),
		prevContent = holder.val(),
		content = '';

		// Go through each content element
		jQuery('#dslc-main .dslca-editable-content').each(function(){
			// Append the content to the variable
			content += jQuery(this).html().replace(/\s+/g, ' ').trim() + ' ';
		});

		// Set the value of the content field
		holder.val( content );

		// Used to show the publish button for pages made before this feature
		if ( prevContent !== content ) {
			dslc_show_publish_button();
		}

	}

	/**
	 * Other - Recalculate drag and drop centering
	 */

	function dslca_draggable_calc_center( dslcArea ) {

		if ( dslcDebug ) console.log( 'dslca_draggable_calc_center' );

		jQuery( ".dslc-modules-section-inner" ).sortable( "option", "cursorAt", { top: dslcArea.outerHeight() / 2, left: dslcArea.outerWidth() / 2 } );	

	}

	/** 
	 * Other - Generate code of editable content
	 */

	function dslc_editable_content_gen_code( dslcField ) {

		if ( dslcDebug ) console.log( 'dslc_editable_content_gen_code' );

		var dslcModule, dslcContent, dslcFieldID;

		dslcModule = dslcField.closest('.dslc-module-front'); 
		dslcContent = dslcField.html().trim().replace(/<textarea/g, '<lctextarea').replace(/<\/textarea/g, '</lctextarea');		
		dslcFieldID = dslcField.data('id');

		jQuery('.dslca-module-option-front[data-id="' + dslcFieldID + '"]', dslcModule).val( dslcContent );

		dslc_show_publish_button();

	}

	/**
	 * Other - Document Ready
	 */

	jQuery(document).ready(function($){

		/**
	 	 * Action - Show code for altering module's defaults
	 	 */

	 	$(document).on( 'click', '.dslca-module-get-defaults-hook', function(){

	 		// Vars
			var module = jQuery(this).closest('.dslc-module-front');
			var code = dslc_dm_get_defaults( module );

			// Generate modal's text
			var message = '<span class="dslca-prompt-modal-title">Module Defaults</span>' 
				+ '<span class="dslca-prompt-modal-descr">The code bellow is used to alter the defaults.</span>'
				+ '<textarea></textarea><br><br>';

			// Hide modal's cancel button
			$('.dslca-prompt-modal-cancel-hook').hide();

			// Show confirm button and change it to "OK"
			$('.dslca-prompt-modal-confirm-hook').html('<span class="dslc-icon dslc-icon-ok"></span>OK');

			// Show the modal prompt
			dslc_js_confirm( 'dev_mode_get_default', message, module );

		});

		/**
		 * Action - Disable links from going anywhere
		 */

		$(document).on( 'click', 'a:not(.dslca-link)', function(e){
			e.preventDefault();
		});

		/**
		 * Action - Prevent backspace from navigating back
		 */

		$(document).unbind('keydown').bind('keydown', function (event) {

			var doPrevent = false;
			if (event.keyCode === 8) {
				var d = event.srcElement || event.target;
				if ((d.tagName.toUpperCase() === 'INPUT' && (d.type.toUpperCase() === 'TEXT' || d.type.toUpperCase() === 'PASSWORD' || d.type.toUpperCase() === 'FILE')) 
					 || d.tagName.toUpperCase() === 'TEXTAREA' || $(d).hasClass('dslca-editable-content') || $(d).hasClass('dslc-tabs-nav-hook-title') || $(d).hasClass('dslc-accordion-title') ) {
					doPrevent = d.readOnly || d.disabled;
				} else {
					doPrevent = true;
				}
			}

			if (doPrevent) {
				event.preventDefault();
			}

		});

		/**
		 * Actions - Prompt Modal on F5
		 */

		$(document).on( 'keydown', function(e){
			if ( ( e.which || e.keyCode ) == 116 ) {
				if ( jQuery('.dslca-save-composer-hook').is(':visible') || jQuery('.dslca-module-edit-save').is(':visible') ) {
					e.preventDefault();
					dslc_js_confirm( 'disable_lc', '<span class="dslca-prompt-modal-title">' + DSLCString.str_refresh_title + '</span><span class="dslca-prompt-modal-descr">' + DSLCString.str_refresh_descr + '</span>', document.URL );
				}
			}
		});

		/**
		 * Hook - Refresh Module 
		 */

		$(document).on( 'click', '.dslca-refresh-module-hook', function(e){

			$(this).css({ 
				'-webkit-animation-name' : 'dslcRotate',
				'-moz-animation-name' : 'dslcRotate',
				'animation-name' : 'dslcRotate',
				'animation-duration' : '0.6s',
				'-webkit-animation-duration' : '0.6s',
				'animation-iteration-count' : 'infinite',
				'-webkit-animation-iteration-count' : 'infinite'
			});
			$(this).closest('.dslc-module-front').addClass('dslca-module-being-edited');
			dslc_module_output_altered( function() {
				$('.dslca-module-being-edited').removeClass('dslca-module-being-edited');
			});

		});

	});

	// Disable the prompt ( are you sure ) on refresh
	window.onbeforeunload = function () { return; };

/*********************************
 * 
 * = PENDING CLEANUP
 *
 *********************************/

	 jQuery(document).ready(function($) {

	 	// Option changes

		$(document).on( 'change', '.dslca-modules-section-edit-field', function() {

			var dslcField, dslcFieldID, dslcEl, dslcModulesSection, dslcVal, dslcValReal, dslcRule, dslcSetting, dslcTargetEl, dslcImgURL;

			dslcField = $(this);
			dslcFieldID = dslcField.data('id');
			dslcVal = dslcField.val();
			dslcValReal = dslcVal;
			dslcRule = dslcField.data('css-rule');

			dslcEl = $('.dslca-modules-section-being-edited');
			dslcTargetEl = dslcEl;
			dslcSetting = $('.dslca-modules-section-settings input[data-id="' + dslcFieldID + '"]', dslcEl );

			dslcEl.addClass('dslca-modules-section-change-made');

			// If image/upload field alter the value ( use from data )
			if ( dslcField.hasClass('dslca-modules-section-edit-field-upload') ) {
				if ( dslcVal && dslcVal.length )
					dslcVal = dslcField.data('dslca-img-url');
			}

			if ( dslcRule == 'background-image' ) {
				 dslcVal = 'url("' + dslcVal + '")';
				 dslc_bg_video();
			}

			if ( dslcFieldID == 'bg_image_attachment' ) {
				dslcEl.removeClass('dslc-init-parallax');
			}

			if ( dslcFieldID == 'border-top' || dslcFieldID == 'border-right' || dslcFieldID == 'border-bottom' || dslcFieldID == 'border-left' ) {

				var dslcBorderStyle = $('.dslca-modules-section-settings input[data-id="border_style"]').val();
				dslcSetting = $('.dslca-modules-section-settings input[data-id="border"]', dslcEl );

				dslcValReal = '';

				var dslcChecboxesWrap = dslcField.closest('.dslca-modules-section-edit-option-checkbox-wrapper');
				dslcChecboxesWrap.find('.dslca-modules-section-edit-field-checkbox').each(function(){
					if ( $(this).is(':checked') ) {

						if ( $(this).data('id') == 'border-top' ) {
							dslcValReal += 'top ';
						} else if ( $(this).data('id') == 'border-right' ) {
							dslcValReal += 'right ';
						} else if ( $(this).data('id') == 'border-bottom' ) {
							dslcValReal += 'bottom ';
						} else if ( $(this).data('id') == 'border-left' ) {
							dslcValReal += 'left ';
						}

					}
				});

				if ( dslcField.is(':checked') ) {

					if ( dslcField.data('id') == 'border-top' ) {
						dslcEl.css({ 'border-top-style' : dslcBorderStyle });
					} else if ( dslcField.data('id') == 'border-right' ) {
						dslcEl.css({ 'border-right-style' : dslcBorderStyle });
					} else if ( dslcField.data('id') == 'border-bottom' ) {
						dslcEl.css({ 'border-bottom-style' : dslcBorderStyle });
					} else if ( dslcField.data('id') == 'border-left' ) {
						dslcEl.css({ 'border-left-style' : dslcBorderStyle });
					}

				} else {

					if ( dslcField.data('id') == 'border-top' ) {
						dslcEl.css({ 'border-top-style' : 'hidden' });
					} else if ( dslcField.data('id') == 'border-right' ) {
						dslcEl.css({ 'border-right-style' : 'hidden' });
					} else if ( dslcField.data('id') == 'border-bottom' ) {
						dslcEl.css({ 'border-bottom-style' : 'hidden' });
					} else if ( dslcField.data('id') == 'border-left' ) {
						dslcEl.css({ 'border-left-style' : 'hidden' });
					}

				}
			} else if ( dslcField.hasClass( 'dslca-modules-section-edit-field-checkbox' ) ) {

				var checkboxes = $(this).closest('.dslca-modules-section-edit-option-checkbox-wrapper').find('.dslca-modules-section-edit-field-checkbox');
				var checkboxesVal = '';
				checkboxes.each(function(){
					if ( $(this).prop('checked') ) {
						checkboxesVal += $(this).data('val') + ' ';
					}
				});
				var dslcValReal = checkboxesVal;

				/* Show On */
				if ( dslcField.data('id') == 'show_on' ) {
					
					console.log( checkboxesVal );

					if ( checkboxesVal.indexOf( 'desktop' ) !== -1 ) {
						$('.dslca-modules-section-being-edited').removeClass('dslc-hide-on-desktop');
					} else {
						$('.dslca-modules-section-being-edited').addClass('dslc-hide-on-desktop');
					}

					if ( checkboxesVal.indexOf( 'tablet' ) !== -1 ) {
						$('.dslca-modules-section-being-edited').removeClass('dslc-hide-on-tablet');
					} else {
						$('.dslca-modules-section-being-edited').addClass('dslc-hide-on-tablet');
					}

					if ( checkboxesVal.indexOf( 'phone' ) !== -1 ) {
						$('.dslca-modules-section-being-edited').removeClass('dslc-hide-on-phone');
					} else {
						$('.dslca-modules-section-being-edited').addClass('dslc-hide-on-phone');
					}

				}

			} else if ( ( dslcFieldID == 'bg_image_attachment' && dslcVal == 'parallax' ) || dslcFieldID == 'type' ) {
				
				if ( dslcFieldID == 'bg_image_attachment' ) {
					dslcEl.addClass( 'dslc-init-parallax' );
					dslc_parallax();
				} else if ( dslcFieldID == 'type' ) {

					if ( dslcVal == 'full' )
						dslcEl.addClass('dslc-full');
					else
						dslcEl.removeClass('dslc-full');

					dslc_masonry();

				}
			} else if ( dslcFieldID == 'columns_spacing' ) {

				if ( dslcVal == 'nospacing' ) {
					dslcEl.addClass('dslc-no-columns-spacing');
				} else {
					dslcEl.removeClass('dslc-no-columns-spacing');
				}
			} else if ( dslcFieldID == 'custom_class' ) {

			} else if ( dslcFieldID == 'custom_id' ) {

			} else if ( dslcFieldID == 'bg_video' ) {

				jQuery('.dslc-bg-video video', dslcEl).remove();

				if ( dslcVal && dslcVal.length ) {
					var dslcVideoVal = dslcVal;
					dslcVideoVal = dslcVideoVal.replace( '.webm', '' );
					dslcVideoVal = dslcVideoVal.replace( '.mp4', '' );
					jQuery('.dslc-bg-video-inner', dslcEl).html('<video><source type="video/mp4" src="' + dslcVideoVal + '.mp4" /><source type="video/webm" src="' + dslcVideoVal + '.webm" /></video>');
					dslc_bg_video();
				}

			} else if ( dslcFieldID == 'bg_image_thumb' ) {

				if ( dslcValReal == 'enabled' ) {

					if ( jQuery('#dslca-post-data-thumb').length ) {
						var dslcThumbURL = "url('" + jQuery('#dslca-post-data-thumb').val() + "')";
						dslcTargetEl.css(dslcRule, dslcThumbURL );
					}

				} else if ( dslcValReal == 'disabled' ) {
					dslcTargetEl.css(dslcRule, 'none' );
				}

			} else {

				if ( dslcField.data('css-element') ) {
					dslcTargetEl = jQuery( dslcField.data('css-element'), dslcEl );
				}
				dslcTargetEl.css(dslcRule, dslcVal);

			}

			dslcSetting.val( dslcValReal );

			dslc_generate_code();
			dslc_show_publish_button();

		});

		// Editable Content

		jQuery(document).on('blur', '.dslca-editable-content', function() {
			
			if ( ! jQuery('body').hasClass( 'dslca-composer-hidden' ) && jQuery(this).data('type') == 'simple' ) {

				dslc_editable_content_gen_code( jQuery(this) );

			}

		}).on( 'paste', '.dslca-editable-content', function(){

			if ( ! jQuery('body').hasClass( 'dslca-composer-hidden' )  && jQuery(this).data('type') == 'simple' ) {

				var dslcRealInput = jQuery(this);

				setTimeout(function(){

					if ( dslcRealInput.data('type') == 'simple' ) {
						dslcRealInput.html( dslcRealInput.text() );
					}

					dslc_editable_content_gen_code( jQuery(this) );

				}, 1);		

			}

		}).on('focus', '.dslca-editable-content', function() {

			if (  jQuery(this).data('type') == 'simple' ) {

				if ( ! jQuery('body').hasClass( 'dslca-composer-hidden' ) ) {

					if ( ! jQuery(this).closest('.dslc-module-front').hasClass('dslca-module-being-edited') ) {
						jQuery(this).closest('.dslc-module-front').find('.dslca-module-edit-hook').trigger('click');
					}

				} else {

					$(this).trigger('blur');

				}

			}

		}).on('keyup', '.dslca-editable-content', function(){

			if ( jQuery(this).data('type') == 'simple' ) {
				jQuery(this).closest('.dslc-module-front').addClass('dslca-module-change-made');
			}
			
		});


		$(document).on( 'blur', '.dslc-editable-area', function(e){

			var module = $(this).closest('.dslc-module-front');
			var optionID = $(this).data('dslc-option-id');
			var optionVal = $(this).html();

			jQuery( '.dslca-module-options-front textarea[data-id="' + optionID + '"]', module ).val(optionVal);

			dslc_module_output_altered();

		});

		// Preview Module Settings

		$(document).on( 'change', '.dslca-module-edit-field', function(){

			// Hide/Show tabs
			dslc_module_options_hideshow_tabs();

			var dslcOptionValue = '',
				dslcOptionValueOrig = '',
				dslcOption = $(this),
				dslcOptionID = dslcOption.data('id'),
				dslcOptionWrap = dslcOption.closest('.dslca-module-edit-option'),
				dslcModule = $('.dslca-module-being-edited'),
				dslcModuleID = dslcModule.data('dslc-module-id'),
				dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule );

			// Add changed class
			dslcModule.addClass('dslca-module-change-made');

			if ( jQuery(this).closest('.dslca-module-edit-option').data('refresh-on-change') == 'active' ) {

				/**
				 * Get the new value
				 */

				if ( dslcOptionWrap.find('.dslca-module-edit-option-checkbox-wrapper').length ) {

					var dslcOptionChoices = $('input[type="checkbox"]', dslcOptionWrap);

					dslcOptionChoices.each(function(){

						if ( $(this).prop('checked') ) {
							dslcOptionValue = dslcOptionValue + $(this).val() + ' ';
						}

					});

				} else if ( dslcOption.hasClass('dslca-module-edit-option-radio') ) {
					var dslcOptionValue = $('.dslca-module-edit-field:checked', dslcOption).val();				
				} else {

					var dslcOptionValue = dslcOption.val();

					// Orientation change
					if ( dslcOptionID == 'orientation' && dslcOptionValue == 'horizontal' ) {
						var dslcSliderEl = jQuery('.dslca-module-edit-option-thumb_width .dslca-module-edit-field-slider');
						dslcSliderEl.slider({ value: 40 }).slider('option', 'slide')(null, { value: dslcSliderEl.slider('value') })
					} else if ( dslcOptionID == 'orientation' && dslcOptionValue == 'vertical' ) {
						var dslcSliderEl = jQuery('.dslca-module-edit-option-thumb_width .dslca-module-edit-field-slider');
						dslcSliderEl.slider({ value: 100 }).slider('option', 'slide')(null, { value: dslcSliderEl.slider('value') })
					}

				}

				/**
				 * Change old value with new value
				 */

				jQuery( '.dslca-module-options-front textarea[data-id="' + dslcOptionID + '"]', dslcModule ).val(dslcOptionValue);

				jQuery('.dslca-container-loader').show();

				dslc_module_output_altered( function(){
					jQuery('.dslca-module-being-edited').addClass('dslca-module-change-made');
					if ( dslcOptionID == 'css_load_preset' && ! jQuery('body').hasClass('dslca-new-preset-added') ) {
						dslc_module_options_show( dslcModuleID );
						jQuery('.dslca-container-loader').hide();
					} else {
						jQuery('.dslca-container-loader').hide();
					}
					jQuery('body').removeClass('dslca-new-preset-added');
				});

			} else {

				/**
				 * Live Preview
				 */

				if ( dslcOption.hasClass('dslca-module-edit-field-font') ) {

					var dslcFontsToLoad = dslcOption.val();
					dslcFontsToLoad = dslcFontsToLoad + ':400,100,200,300,500,600,700,800,900';

					var dslcAffectOnChangeEl = dslcOption.data('affect-on-change-el');
					var dslcAffectOnChangeRule = dslcOption.data('affect-on-change-rule');
					var dslcAffectOnChangeVal = dslcOption.val();
					var dslcAffectOnChangeValOrig = dslcAffectOnChangeVal;

					if ( dslcOption.val().length && dslcGoogleFontsArray.indexOf( dslcOption.val() ) !== -1  ) {

						WebFont.load({
								google: { 
									families: [ dslcFontsToLoad ] 
								},
								active : function(familyName, fvd) {
									if ( jQuery( '.dslca-font-loading' ).closest('.dslca-module-edit-field-font-next').length )
										jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-right');
									else
										jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-left');
									jQuery( dslcAffectOnChangeEl ,'.dslca-module-being-edited' ).css( dslcAffectOnChangeRule , dslcAffectOnChangeVal );
								},
								inactive : function ( familyName, fvd ) {
									if ( jQuery( '.dslca-font-loading' ).closest('.dslca-module-edit-field-font-next').length )
										jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-right');
									else
										jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-left');
								}
							}
						);
		
					} else { 

						setTimeout( function(){

							if ( jQuery( '.dslca-font-loading.dslca-module-edit-field-font-next' ).length )
								jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-right');
							else
								jQuery('.dslca-font-loading').removeClass('dslca-font-loading').find('.dslca-icon').removeClass('dslc-icon-spin').addClass('dslc-icon-chevron-left');

							jQuery( dslcAffectOnChangeEl ,'.dslca-module-being-edited' ).css( dslcAffectOnChangeRule , dslcAffectOnChangeVal );

						}, 100);

					}

				} else if ( dslcOption.hasClass('dslca-module-edit-field-checkbox') ) {

					var dslcOptionChoices = $('input[type="checkbox"]', dslcOptionWrap);

					dslcOptionChoices.each(function(){

						if ( $(this).prop('checked') ) {
							dslcOptionValue = dslcOptionValue + 'solid ';
							dslcOptionValueOrig = dslcOptionValueOrig + $(this).val() + ' ';
						} else {
							dslcOptionValue = dslcOptionValue + 'none ';
						}

					});

				}

				if ( ! dslcOption.hasClass('dslca-module-edit-field-font') ) {

					var dslcAffectOnChangeEl = dslcOption.data('affect-on-change-el');
					var dslcAffectOnChangeRule = dslcOption.data('affect-on-change-rule');
					var dslcAffectOnChangeVal = dslcOption.val();
					var dslcAffectOnChangeValOrig = dslcAffectOnChangeVal;

					if ( dslcOption.hasClass('dslca-module-edit-field-checkbox') ) {
						dslcAffectOnChangeVal = dslcOptionValue;
						dslcAffectOnChangeValOrig = dslcOptionValueOrig;
					}

					if ( dslcOption.hasClass('dslca-module-edit-field-image') ) {
						dslcAffectOnChangeVal = 'url("' + dslcAffectOnChangeVal + '")';
					}

					if ( dslcAffectOnChangeVal.length < 1 && ( dslcAffectOnChangeRule == 'background-color' || dslcAffectOnChangeRule == 'background' ) ) {
						dslcAffectOnChangeVal = 'transparent';
					}

					jQuery( dslcAffectOnChangeEl ,'.dslca-module-being-edited' ).css( dslcAffectOnChangeRule , dslcAffectOnChangeVal );

				}

				/**
				 * Update option
				 */

				jQuery( '.dslca-module-option-front[data-id="' + dslcOptionID + '"]', dslcModule ).val( dslcAffectOnChangeValOrig );
				
			}

		});

		
		// Preview Module Opt Change - Numeric

		$(document).on( 'keyup, blur', '.dslca-module-edit-field-numeric', function(){

			var dslcOptionValue = '',
				dslcOption = $(this),
				dslcOptionID = dslcOption.data('id'),
				dslcOptionWrap = dslcOption.closest('.dslca-module-edit-option'),
				dslcModule = $('.dslca-module-being-edited'),
				dslcModuleID = dslcModule.data('dslc-module-id'),
				dslcModuleOptions = jQuery( '.dslca-module-options-front textarea', dslcModule ),
				dslcAffectOnChangeEl = dslcOption.data('affect-on-change-el'),
				dslcAffectOnChangeRule = dslcOption.data('affect-on-change-rule'),
				dslcAffectOnChangeValOrig = dslcOption.val(),
				dslcAffectOnChangeVal = dslcAffectOnChangeValOrig + dslcOption.data('ext'),
				dslcAffectOnChangeRules;

			// Add changed class
			dslcModule.addClass('dslca-module-change-made');

			if ( jQuery(this).closest('.dslca-module-edit-option').data('refresh-on-change') != 'active' ) {

				/**
				 * Live Preview
				 */

				dslcAffectOnChangeRules = dslcAffectOnChangeRule.replace(/ /g,'').split( ',' );

				// Loop through rules (useful when there are multiple rules)
				for ( var i = 0; i < dslcAffectOnChangeRules.length; i++ ) {
					jQuery( dslcAffectOnChangeEl ,'.dslca-module-being-edited' ).css( dslcAffectOnChangeRules[i] , dslcAffectOnChangeVal );
				}

				/**
				 * Update option
				 */

				jQuery( '.dslca-module-option-front[data-id="' + dslcOptionID + '"]', dslcModule ).val( dslcAffectOnChangeValOrig );
				
			}

		});

	
		//Preview Module Section Opt Change - Numeric

		$(document).on( 'keyup', '.dslca-modules-section-edit-field-numeric', function(){

			var dslcOptionValue = '',
				dslcOption = $(this),
				dslcOptionID = dslcOption.data('id'),
				dslcOptionWrap = dslcOption.closest('.dslca-modules-section-edit-option'),
				dslcModulesSection = $('.dslca-modules-section-being-edited'),
				dslcAffectOnChangeRule = dslcOption.data('css-rule'),
				dslcAffectOnChangeValOrig = dslcOption.val(),
				dslcAffectOnChangeVal = dslcAffectOnChangeValOrig + dslcOption.data('ext'),
				dslcAffectOnChangeRules;

			// Add changed class
			dslcModulesSection.addClass('dslca-modules-section-change-made');

			/**
			 * Live Preview
			 */

			dslcAffectOnChangeRules = dslcAffectOnChangeRule.replace(/ /g,'').split( ',' );

			// Loop through rules (useful when there are multiple rules)
			for ( var i = 0; i < dslcAffectOnChangeRules.length; i++ ) {
				dslcModulesSection.css( dslcAffectOnChangeRules[i] , dslcAffectOnChangeVal );
			}

			/**
			 * Update option
			 */

			jQuery( '.dslca-modules-section-settings input[data-id="' + dslcOptionID + '"]', dslcModulesSection ).val( dslcAffectOnChangeValOrig );
				
		});

	});


	jQuery(document).ready(function($){

		// Uploading files
		var file_frame;

		jQuery(document).on('click', '.dslca-module-edit-field-image-add-hook, .dslca-modules-section-edit-field-image-add-hook', function(){

			var hook = jQuery(this);

			if ( hook.hasClass( 'dslca-module-edit-field-image-add-hook' ) ) {

				var field = hook.siblings('.dslca-module-edit-field-image');
				var removeHook = hook.siblings('.dslca-module-edit-field-image-remove-hook');

			} else {

				var field = hook.siblings('.dslca-modules-section-edit-field-upload');
				var removeHook = hook.siblings('.dslca-modules-section-edit-field-image-remove-hook');

			}

			// Whether or not multiple files are allowed
			var multiple = false;

			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: {
					text: 'Confirm',
				},
				multiple: multiple
			});

			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {			

				var attachment = file_frame.state().get('selection').first().toJSON();			
				field.val( attachment.id ).data( 'dslca-img-url', attachment.url ).trigger('change');
				hook.hide();
				removeHook.show();

			});

			// Finally, open the modal
			file_frame.open();

		});

		jQuery(document).on('click', '.dslca-module-edit-field-image-remove-hook, .dslca-modules-section-edit-field-image-remove-hook', function(){

			var hook = jQuery(this);

			if ( hook.hasClass( 'dslca-module-edit-field-image-remove-hook' ) ) {

				var field = hook.siblings('.dslca-module-edit-field-image');
				var addHook = hook.siblings('.dslca-module-edit-field-image-add-hook');

			} else {

				var field = hook.siblings('.dslca-modules-section-edit-field-upload');
				var addHook = hook.siblings('.dslca-modules-section-edit-field-image-add-hook');

			}

			field.val('').trigger('change');
			hook.hide();
			addHook.show();

		});

		/**
		 * Show WYSIWYG
		 */

		$(document).on( 'click', '.dslca-wysiwyg-actions-edit-hook', function(){

			var editable = $(this).parent().siblings('.dslca-editable-content');
			var module = editable.closest('.dslc-module-front');
			
			if ( module.hasClass('dslc-module-handle-like-accordion') ) {

				dslc_accordion_generate_code( module.find('.dslc-accordion') );
				var full_content = module.find( '.dslca-module-option-front[data-id="accordion_content"]' ).val();
				var full_content_arr = full_content.split('(dslc_sep)');
				var key_value = editable.closest('.dslc-accordion-item').index();
				var content = full_content_arr[key_value].trim().replace(/<lctextarea/g, '<textarea').replace(/<\/lctextarea/g, '</textarea');

			} else if ( module.hasClass('dslc-module-handle-like-tabs') ) {
				
				dslc_tabs_generate_code( module.find('.dslc-tabs') );
				var full_content = module.find( '.dslca-module-option-front[data-id="tabs_content"]' ).val();
				var full_content_arr = full_content.split('(dslc_sep)');
				var key_value = editable.closest('.dslc-tabs-tab-content').index();
				var content = full_content_arr[key_value].trim().replace(/<lctextarea/g, '<textarea').replace(/<\/lctextarea/g, '</textarea');

			} else {

				var content = module.find( '.dslca-module-option-front[data-id="' + editable.data('id') + '"]' ).val().replace(/<lctextarea/g, '<textarea').replace(/<\/lctextarea/g, '</textarea');

			}

			if( typeof tinymce != "undefined" ) {

				var editor = tinymce.get( 'dslcawpeditor' );
				if ( $('#wp-dslcawpeditor-wrap').hasClass('tmce-active') ) {
					editor.setContent( content, {format : 'html'} );
				} else {
					jQuery('textarea#dslcawpeditor').val( content );
				}

				if ( ! module.hasClass('dslca-module-being-edited') ) {
					module.find('.dslca-module-edit-hook').trigger('click');
				}

				$('.dslca-wp-editor').show();
				editable.addClass('dslca-wysiwyg-active');

				$('#dslcawpeditor_ifr, #dslcawpeditor').css({ height : $('.dslca-wp-editor').height() - 350 });

			}

		});

		/**
		 * Confirm WYSIWYG
		 */

		$(document).on( 'click', '.dslca-wp-editor-save-hook', function(){

			var module = $('.dslca-wysiwyg-active').closest('.dslc-module-front');

			if( typeof tinymce != "undefined" ) {

				if ( $('#wp-dslcawpeditor-wrap').hasClass('tmce-active') ) {
					var editor = tinymce.get( 'dslcawpeditor' );
					var content = editor.getContent();	
				} else {
					var content = $('#dslcawpeditor').val();
				}

				$('.dslca-wp-editor').hide();
				$('.dslca-wysiwyg-active').html( content );

				if ( module.hasClass('dslc-module-handle-like-accordion') ) {
					$('.dslca-wysiwyg-active').siblings('.dslca-accordion-plain-content').val( content );
					var dslcAccordion = module.find('.dslc-accordion');
					dslc_accordion_generate_code( dslcAccordion );
				} else if ( module.hasClass('dslc-module-handle-like-tabs') ) {
					$('.dslca-wysiwyg-active').siblings('.dslca-tab-plain-content').val( content );
					var dslcTabs = module.find('.dslc-tabs');
					dslc_tabs_generate_code( dslcTabs );
				}


				dslc_editable_content_gen_code( $('.dslca-wysiwyg-active') );
				$('.dslca-wysiwyg-active').removeClass('dslca-wysiwyg-active');

			}

		});

		/**
		 * Cancel WYSIWYG
		 */

		$(document).on( 'click', '.dslca-wp-editor-cancel-hook', function(){

			$('.dslca-wp-editor').hide();
			$('.dslca-wysiwyg-active').removeClass('dslca-wysiwyg-active');

		});

	});
/*! mouseWheel v3.1.3 | Author: Brandon Aaron (http://brandonaaron.net), 2013 | License: MIT */
(function(e){if(typeof define==="function"&&define.amd){define(["jquery"],e)}else if(typeof exports==="object"){module.exports=e}else{e(jQuery)}})(function(e){function o(t){var n=t||window.event,s=[].slice.call(arguments,1),o=0,u=0,a=0,f=0,l=0,c;t=e.event.fix(n);t.type="mousewheel";if(n.wheelDelta){o=n.wheelDelta}if(n.detail){o=n.detail*-1}if(n.deltaY){a=n.deltaY*-1;o=a}if(n.deltaX){u=n.deltaX;o=u*-1}if(n.wheelDeltaY!==undefined){a=n.wheelDeltaY}if(n.wheelDeltaX!==undefined){u=n.wheelDeltaX*-1}f=Math.abs(o);if(!r||f<r){r=f}l=Math.max(Math.abs(a),Math.abs(u));if(!i||l<i){i=l}c=o>0?"floor":"ceil";o=Math[c](o/r);u=Math[c](u/i);a=Math[c](a/i);s.unshift(t,o,u,a);return(e.event.dispatch||e.event.handle).apply(this,s)}var t=["wheel","mousewheel","DOMMouseScroll","MozMousePixelScroll"];var n="onwheel"in document||document.documentMode>=9?["wheel"]:["mousewheel","DomMouseScroll","MozMousePixelScroll"];var r,i;if(e.event.fixHooks){for(var s=t.length;s;){e.event.fixHooks[t[--s]]=e.event.mouseHooks}}e.event.special.mousewheel={setup:function(){if(this.addEventListener){for(var e=n.length;e;){this.addEventListener(n[--e],o,false)}}else{this.onmousewheel=o}},teardown:function(){if(this.removeEventListener){for(var e=n.length;e;){this.removeEventListener(n[--e],o,false)}}else{this.onmousewheel=null}}};e.fn.extend({mousewheel:function(e){return e?this.bind("mousewheel",e):this.trigger("mousewheel")},unmousewheel:function(e){return this.unbind("mousewheel",e)}})});
/*! Spectrum Colorpicker v1.3.1 | Author: Brian Grinstead (https://github.com/bgrins/spectrum) | License: MIT */
(function(e,t,n){function l(e,t,n){var r=[];for(var i=0;i<e.length;i++){var s=e[i];if(s){var u=tinycolor(s);var a=u.toHsl().l<.5?"sp-thumb-el sp-thumb-dark":"sp-thumb-el sp-thumb-light";a+=tinycolor.equals(t,s)?" sp-thumb-active":"";var f=o?"background-color:"+u.toRgbString():"filter:"+u.toFilter();r.push('<span title="'+u.toRgbString()+'" data-color="'+u.toRgbString()+'" class="'+a+'"><span class="sp-thumb-inner" style="'+f+';" /></span>')}else{var l="sp-clear-display";r.push('<span title="No Color Selected" data-color="" style="background-color:transparent;" class="'+l+'"></span>')}}return"<div class='sp-cf "+n+"'>"+r.join("")+"</div>"}function c(){for(var e=0;e<i.length;e++){if(i[e]){i[e].hide()}}}function h(e,n){var i=t.extend({},r,e);i.callbacks={move:g(i.move,n),change:g(i.change,n),show:g(i.show,n),hide:g(i.hide,n),beforeShow:g(i.beforeShow,n)};return i}function p(r,p){function St(){if(v.showPaletteOnly){v.showPalette=true}if(v.palette){F=v.palette.slice(0);I=t.isArray(F[0])?F:[F]}K.toggleClass("sp-flat",g);K.toggleClass("sp-input-disabled",!v.showInput);K.toggleClass("sp-alpha-enabled",v.showAlpha);K.toggleClass("sp-clear-enabled",Et);K.toggleClass("sp-buttons-disabled",!v.showButtons);K.toggleClass("sp-palette-disabled",!v.showPalette);K.toggleClass("sp-palette-only",v.showPaletteOnly);K.toggleClass("sp-initial-disabled",!v.showInitial);K.addClass(v.className);Ut()}function xt(){function o(e){if(e.data&&e.data.ignore){Ht(t(this).data("color"));Ft()}else{Ht(t(this).data("color"));Rt(true);Ft();Dt()}return false}if(s){K.find("*:not(input)").attr("unselectable","on")}St();if(ct){V.after(ht).hide()}if(!Et){ut.hide()}if(g){V.after(K).hide()}else{var n=v.appendTo==="parent"?V.parent():t(v.appendTo);if(n.length!==1){n=t("body")}n.append(K)}if(E&&e.localStorage){try{var r=e.localStorage[E].split(",#");if(r.length>1){delete e.localStorage[E];t.each(r,function(e,t){Tt(t)})}}catch(i){}try{q=e.localStorage[E].split(";")}catch(i){}}pt.bind("click.spectrum touchstart.spectrum",function(e){if(!J){Mt()}e.stopPropagation();if(!t(e.target).is("input")){e.preventDefault()}});if(V.is(":disabled")||v.disabled===true){Vt()}K.click(m);rt.change(Ot);rt.bind("paste",function(){setTimeout(Ot,1)});rt.keydown(function(e){if(e.keyCode==13){Ot()}});ot.text(v.cancelText);ot.bind("click.spectrum",function(e){e.stopPropagation();e.preventDefault();Dt("cancel")});ut.attr("title",v.clearText);ut.bind("click.spectrum",function(e){e.stopPropagation();e.preventDefault();wt=true;Ft();if(g){Rt(true)}});at.text(v.chooseText);at.bind("click.spectrum",function(e){e.stopPropagation();e.preventDefault();if(jt()){Rt(true);Dt()}});y(tt,function(e,t,n){j=e/M;wt=false;if(n.shiftKey){j=Math.round(j*10)/10}Ft()},Lt,At);y(Y,function(e,t){P=parseFloat(t/A);wt=false;if(!v.showAlpha){j=1}Ft()},Lt,At);y(Q,function(e,t,n){if(!n.shiftKey){z=null}else if(!z){var r=H*C;var i=k-B*k;var s=Math.abs(e-r)>Math.abs(t-i);z=s?"x":"y"}var o=!z||z==="x";var u=!z||z==="y";if(o){H=parseFloat(e/C)}if(u){B=parseFloat((k-t)/k)}wt=false;if(!v.showAlpha){j=1}Ft()},Lt,At);if(!!vt){Ht(vt);It();yt=gt||tinycolor(vt).format;Tt(vt)}else{It()}if(g){_t()}var u=s?"mousedown.spectrum":"click.spectrum touchstart.spectrum";it.delegate(".sp-thumb-el",u,o);st.delegate(".sp-thumb-el:nth-child(1)",u,{ignore:true},o)}function Tt(n){if(w){var r=tinycolor(n).toRgbString();if(t.inArray(r,q)===-1){q.push(r);while(q.length>R){q.shift()}}if(E&&e.localStorage){try{e.localStorage[E]=q.join(";")}catch(i){}}}}function Nt(){var e=[];var t=q;var n={};var r;if(v.showPalette){for(var i=0;i<I.length;i++){for(var s=0;s<I[i].length;s++){r=tinycolor(I[i][s]).toRgbString();n[r]=true}}for(i=0;i<t.length;i++){r=tinycolor(t[i]).toRgbString();if(!n.hasOwnProperty(r)){e.push(t[i]);n[r]=true}}}return e.reverse().slice(0,v.maxSelectionSize)}function Ct(){var e=Bt();var n=t.map(I,function(t,n){return l(t,e,"sp-palette-row sp-palette-row-"+n)});if(q){n.push(l(Nt(),e,"sp-palette-row sp-palette-row-selection"))}it.html(n.join(""))}function kt(){if(v.showInitial){var e=mt;var t=Bt();st.html(l([e,t],t,"sp-palette-row-initial"))}}function Lt(){if(k<=0||C<=0||A<=0){Ut()}K.addClass(U);z=null;V.trigger("dragstart.spectrum",[Bt()])}function At(){K.removeClass(U);V.trigger("dragstop.spectrum",[Bt()])}function Ot(){var e=rt.val();if((e===null||e==="")&&Et){Ht(null);Rt(true)}else{var t=tinycolor(e);if(t.ok){Ht(t);Rt(true)}else{rt.addClass("sp-validation-error")}}}function Mt(){if(N){Dt()}else{_t()}}function _t(){var n=t.Event("beforeShow.spectrum");if(N){Ut();return}V.trigger(n,[Bt()]);if(x.beforeShow(Bt())===false||n.isDefaultPrevented()){return}c();N=true;t(W).bind("click.spectrum",Dt);t(e).bind("resize.spectrum",T);ht.addClass("sp-active");K.removeClass("sp-hidden");Ut();It();mt=Bt();kt();x.show(mt);V.trigger("show.spectrum",[mt])}function Dt(n){if(n&&n.type=="click"&&n.button==2){return}if(!N||g){return}N=false;t(W).unbind("click.spectrum",Dt);t(e).unbind("resize.spectrum",T);ht.removeClass("sp-active");K.addClass("sp-hidden");var r=!tinycolor.equals(Bt(),mt);if(r){if(bt&&n!=="cancel"){Rt(true)}else{Pt()}}x.hide(Bt());V.trigger("hide.spectrum",[Bt()])}function Pt(){Ht(mt,true);x.change(mt);V.trigger("change",[mt])}function Ht(e,t){if(tinycolor.equals(e,Bt())){It();return}var n,r;if(!e&&Et){wt=true}else{wt=false;n=tinycolor(e);r=n.toHsv();P=r.h%360/360;H=r.s;B=r.v;j=r.a}It();if(n&&n.ok&&!t){yt=gt||n.format}}function Bt(e){e=e||{};if(Et&&wt){return null}return tinycolor.fromRatio({h:P,s:H,v:B,a:Math.round(j*100)/100},{format:e.format||yt})}function jt(){return!rt.hasClass("sp-validation-error")}function Ft(){It();x.move(Bt());V.trigger("move.spectrum",[Bt()])}function It(){rt.removeClass("sp-validation-error");qt();var e=tinycolor.fromRatio({h:P,s:1,v:1});Q.css("background-color",e.toHexString());var t=yt;if(j<1&&!(j===0&&t==="name")){if(t==="hex"||t==="hex3"||t==="hex6"||t==="name"){t="rgb"}}var n=Bt({format:t}),r="";dt.removeClass("sp-clear-display");dt.css("background-color","transparent");if(!n&&Et){dt.addClass("sp-clear-display")}else{var i=n.toHexString(),u=n.toRgbString();if(o||n.alpha===1){dt.css("background-color",u)}else{dt.css("background-color","transparent");dt.css("filter",n.toFilter())}if(v.showAlpha){var a=n.toRgb();a.a=0;var f=tinycolor(a).toRgbString();var l="linear-gradient(left, "+f+", "+i+")";if(s){et.css("filter",tinycolor(f).toFilter({gradientType:1},i))}else{et.css("background","-webkit-"+l);et.css("background","-moz-"+l);et.css("background","-ms-"+l);et.css("background",l)}}r=n.toString(t)}if(v.showInput){rt.val(r)}if(v.showPalette){Ct()}kt()}function qt(){var e=H;var t=B;if(Et&&wt){nt.hide();Z.hide();G.hide()}else{nt.show();Z.show();G.show();var n=e*C;var r=k-t*k;n=Math.max(-L,Math.min(C-L,n-L));r=Math.max(-L,Math.min(k-L,r-L));G.css({top:r+"px",left:n+"px"});var i=j*M;nt.css({left:i-_/2+"px"});var s=P*A;Z.css({top:s-D+"px"})}}function Rt(e){var t=Bt(),n="",r=!tinycolor.equals(t,mt);if(t){n=t.toString(yt);Tt(t)}if(ft){V.val(n)}mt=t;if(e&&r){x.change(t);V.trigger("change",[t])}}function Ut(){C=Q.width();k=Q.height();L=G.height();O=Y.width();A=Y.height();D=Z.height();M=tt.width();_=nt.width();if(!g){K.css("position","absolute");K.offset(d(K,pt))}qt();if(v.showPalette){Ct()}V.trigger("reflow.spectrum")}function zt(){V.show();pt.unbind("click.spectrum touchstart.spectrum");K.remove();ht.remove();i[$t.id]=null}function Wt(e,r){if(e===n){return t.extend({},v)}if(r===n){return v[e]}v[e]=r;St()}function Xt(){J=false;V.attr("disabled",false);pt.removeClass("sp-disabled")}function Vt(){Dt();J=true;V.attr("disabled",true);pt.addClass("sp-disabled")}var v=h(p,r),g=v.flat,w=v.showSelectionPalette,E=v.localStorageKey,S=v.theme,x=v.callbacks,T=b(Ut,10),N=false,C=0,k=0,L=0,A=0,O=0,M=0,_=0,D=0,P=0,H=0,B=0,j=1,F=[],I=[],q=v.selectionPalette.slice(0),R=v.maxSelectionSize,U="sp-dragging",z=null;var W=r.ownerDocument,X=W.body,V=t(r),J=false,K=t(f,W).addClass(S),Q=K.find(".sp-color"),G=K.find(".sp-dragger"),Y=K.find(".sp-hue"),Z=K.find(".sp-slider"),et=K.find(".sp-alpha-inner"),tt=K.find(".sp-alpha"),nt=K.find(".sp-alpha-handle"),rt=K.find(".sp-input"),it=K.find(".sp-palette"),st=K.find(".sp-initial"),ot=K.find(".sp-cancel"),ut=K.find(".sp-clear"),at=K.find(".sp-choose"),ft=V.is("input"),lt=ft&&u&&V.attr("type")==="color",ct=ft&&!g,ht=ct?t(a).addClass(S).addClass(v.className):t([]),pt=ct?ht:V,dt=ht.find(".sp-preview-inner"),vt=v.color||ft&&V.val(),mt=false,gt=v.preferredFormat,yt=gt,bt=!v.showButtons||v.clickoutFiresChange,wt=!vt,Et=v.allowEmpty&&!lt;xt();var $t={show:_t,hide:Dt,toggle:Mt,reflow:Ut,option:Wt,enable:Xt,disable:Vt,set:function(e){Ht(e);Rt()},get:Bt,destroy:zt,container:K};$t.id=i.push($t)-1;return $t}function d(e,n){var r=0;var i=e.outerWidth();var s=e.outerHeight();var o=n.outerHeight();var u=e[0].ownerDocument;var a=u.documentElement;var f=a.clientWidth+t(u).scrollLeft();var l=a.clientHeight+t(u).scrollTop();var c=n.offset();c.top+=o;c.left-=Math.min(c.left,c.left+i>f&&f>i?Math.abs(c.left+i-f):0);c.top-=Math.min(c.top,c.top+s>l&&l>s?Math.abs(s+o-r):r);return c}function v(){}function m(e){e.stopPropagation()}function g(e,t){var n=Array.prototype.slice;var r=n.call(arguments,2);return function(){return e.apply(t,r.concat(n.call(arguments)))}}function y(n,r,i,o){function d(e){if(e.stopPropagation){e.stopPropagation()}if(e.preventDefault){e.preventDefault()}e.returnValue=false}function v(e){if(a){if(s&&document.documentMode<9&&!e.button){return g()}var t=e.originalEvent.touches;var i=t?t[0].pageX:e.pageX;var o=t?t[0].pageY:e.pageY;var u=Math.max(0,Math.min(i-f.left,c));var p=Math.max(0,Math.min(o-f.top,l));if(h){d(e)}r.apply(n,[u,p,e])}}function m(e){var r=e.which?e.which==3:e.button==2;var s=e.originalEvent.touches;if(!r&&!a){if(i.apply(n,arguments)!==false){a=true;l=t(n).height();c=t(n).width();f=t(n).offset();t(u).bind(p);t(u.body).addClass("sp-dragging");if(!h){v(e)}d(e)}}}function g(){if(a){t(u).unbind(p);t(u.body).removeClass("sp-dragging");o.apply(n,arguments)}a=false}r=r||function(){};i=i||function(){};o=o||function(){};var u=n.ownerDocument||document;var a=false;var f={};var l=0;var c=0;var h="ontouchstart"in e;var p={};p["selectstart"]=d;p["dragstart"]=d;p["touchmove mousemove"]=v;p["touchend mouseup"]=g;t(n).bind("touchstart mousedown",m)}function b(e,t,n){var r;return function(){var i=this,s=arguments;var o=function(){r=null;e.apply(i,s)};if(n)clearTimeout(r);if(n||!r)r=setTimeout(o,t)}}function w(){if(e.console){if(Function.prototype.bind)w=Function.prototype.bind.call(console.log,console);else w=function(){Function.prototype.apply.call(console.log,console,arguments)};w.apply(this,arguments)}}var r={beforeShow:v,move:v,change:v,show:v,hide:v,color:false,flat:false,showInput:false,allowEmpty:false,showButtons:true,clickoutFiresChange:false,showInitial:false,showPalette:false,showPaletteOnly:false,showSelectionPalette:true,localStorageKey:false,appendTo:"body",maxSelectionSize:7,cancelText:"cancel",chooseText:"choose",clearText:"Clear Color Selection",preferredFormat:false,className:"",showAlpha:false,theme:"sp-light",palette:["fff","000"],selectionPalette:[],disabled:false},i=[],s=!!/msie/i.exec(e.navigator.userAgent),o=function(){function e(e,t){return!!~(""+e).indexOf(t)}var t=document.createElement("div");var n=t.style;n.cssText="background-color:rgba(0,0,0,.5)";return e(n.backgroundColor,"rgba")||e(n.backgroundColor,"hsla")}(),u=function(){var e=t("<input type='color' value='!' />")[0];return e.type==="color"&&e.value!=="!"}(),a=["<div class='sp-replacer'>","<div class='sp-preview'><div class='sp-preview-inner'></div></div>","<div class='sp-dd'>&#9660;</div>","</div>"].join(""),f=function(){var e="";if(s){for(var t=1;t<=6;t++){e+="<div class='sp-"+t+"'></div>"}}return["<div class='sp-container sp-hidden'>","<div class='sp-palette-container'>","<div class='sp-palette sp-thumb sp-cf'></div>","</div>","<div class='sp-picker-container'>","<div class='sp-top sp-cf'>","<div class='sp-fill'></div>","<div class='sp-top-inner'>","<div class='sp-color'>","<div class='sp-sat'>","<div class='sp-val'>","<div class='sp-dragger'></div>","</div>","</div>","</div>","<div class='sp-clear sp-clear-display'>","</div>","<div class='sp-hue'>","<div class='sp-slider'></div>",e,"</div>","</div>","<div class='sp-alpha'><div class='sp-alpha-inner'><div class='sp-alpha-handle'></div></div></div>","</div>","<div class='sp-input-container sp-cf'>","<input class='sp-input' type='text' spellcheck='false'  />","</div>","<div class='sp-initial sp-thumb sp-cf'></div>","<div class='sp-button-container sp-cf'>","<span class='dslca-sp-revert dslc-icon dslc-icon-undo' title='Revert to default'></span>","<span class='sp-cancel dslc-icon dslc-icon-remove' title='Cancel'></span>","<span class='sp-choose dslc-icon dslc-icon-ok' title='Confirm'></span>","</div>","</div>","</div>"].join("")}();var E="spectrum.id";t.fn.spectrum=function(e,n){if(typeof e=="string"){var r=this;var s=Array.prototype.slice.call(arguments,1);this.each(function(){var n=i[t(this).data(E)];if(n){var o=n[e];if(!o){throw new Error("Spectrum: no such method: '"+e+"'")}if(e=="get"){r=n.get()}else if(e=="container"){r=n.container}else if(e=="option"){r=n.option.apply(n,s)}else if(e=="destroy"){n.destroy();t(this).removeData(E)}else{o.apply(n,s)}}});return r}return this.spectrum("destroy").each(function(){var n=t.extend({},e,t(this).data());var r=p(this,n);t(this).data(E,r.id)})};t.fn.spectrum.load=true;t.fn.spectrum.loadOpts={};t.fn.spectrum.draggable=y;t.fn.spectrum.defaults=r;t.spectrum={};t.spectrum.localization={};t.spectrum.palettes={};t.fn.spectrum.processNativeColorInputs=function(){if(!u){t("input[type=color]").spectrum({preferredFormat:"hex6"})}};(function(){function f(e,t){e=e?e:"";t=t||{};if(typeof e=="object"&&e.hasOwnProperty("_tc_id")){return e}var n=l(e);var i=n.r,o=n.g,u=n.b,a=n.a,c=s(100*a)/100,p=t.format||n.format;if(i<1){i=s(i)}if(o<1){o=s(o)}if(u<1){u=s(u)}return{ok:n.ok,format:p,_tc_id:r++,alpha:a,getAlpha:function(){return a},setAlpha:function(e){a=E(e);c=s(100*a)/100},toHsv:function(){var e=d(i,o,u);return{h:e.h*360,s:e.s,v:e.v,a:a}},toHsvString:function(){var e=d(i,o,u);var t=s(e.h*360),n=s(e.s*100),r=s(e.v*100);return a==1?"hsv("+t+", "+n+"%, "+r+"%)":"hsva("+t+", "+n+"%, "+r+"%, "+c+")"},toHsl:function(){var e=h(i,o,u);return{h:e.h*360,s:e.s,l:e.l,a:a}},toHslString:function(){var e=h(i,o,u);var t=s(e.h*360),n=s(e.s*100),r=s(e.l*100);return a==1?"hsl("+t+", "+n+"%, "+r+"%)":"hsla("+t+", "+n+"%, "+r+"%, "+c+")"},toHex:function(e){return m(i,o,u,e)},toHexString:function(e){return"#"+this.toHex(e)},toHex8:function(){return g(i,o,u,a)},toHex8String:function(){return"#"+this.toHex8()},toRgb:function(){return{r:s(i),g:s(o),b:s(u),a:a}},toRgbString:function(){return a==1?"rgb("+s(i)+", "+s(o)+", "+s(u)+")":"rgba("+s(i)+", "+s(o)+", "+s(u)+", "+c+")"},toPercentageRgb:function(){return{r:s(S(i,255)*100)+"%",g:s(S(o,255)*100)+"%",b:s(S(u,255)*100)+"%",a:a}},toPercentageRgbString:function(){return a==1?"rgb("+s(S(i,255)*100)+"%, "+s(S(o,255)*100)+"%, "+s(S(u,255)*100)+"%)":"rgba("+s(S(i,255)*100)+"%, "+s(S(o,255)*100)+"%, "+s(S(u,255)*100)+"%, "+c+")"},toName:function(){if(a===0){return"transparent"}return b[m(i,o,u,true)]||false},toFilter:function(e){var n="#"+g(i,o,u,a);var r=n;var s=t&&t.gradientType?"GradientType = 1, ":"";if(e){var l=f(e);r=l.toHex8String()}return"progid:DXImageTransform.Microsoft.gradient("+s+"startColorstr="+n+",endColorstr="+r+")"},toString:function(e){var t=!!e;e=e||this.format;var n=false;var r=!t&&a<1&&a>0;var i=r&&(e==="hex"||e==="hex6"||e==="hex3"||e==="name");if(e==="rgb"){n=this.toRgbString()}if(e==="prgb"){n=this.toPercentageRgbString()}if(e==="hex"||e==="hex6"){n=this.toHexString()}if(e==="hex3"){n=this.toHexString(true)}if(e==="hex8"){n=this.toHex8String()}if(e==="name"){n=this.toName()}if(e==="hsl"){n=this.toHslString()}if(e==="hsv"){n=this.toHsvString()}if(i){return this.toRgbString()}return n||this.toHexString()}}}function l(e){var t={r:0,g:0,b:0};var n=1;var r=false;var i=false;if(typeof e=="string"){e=_(e)}if(typeof e=="object"){if(e.hasOwnProperty("r")&&e.hasOwnProperty("g")&&e.hasOwnProperty("b")){t=c(e.r,e.g,e.b);r=true;i=String(e.r).substr(-1)==="%"?"prgb":"rgb"}else if(e.hasOwnProperty("h")&&e.hasOwnProperty("s")&&e.hasOwnProperty("v")){e.s=L(e.s);e.v=L(e.v);t=v(e.h,e.s,e.v);r=true;i="hsv"}else if(e.hasOwnProperty("h")&&e.hasOwnProperty("s")&&e.hasOwnProperty("l")){e.s=L(e.s);e.l=L(e.l);t=p(e.h,e.s,e.l);r=true;i="hsl"}if(e.hasOwnProperty("a")){n=e.a}}n=E(n);return{ok:r,format:e.format||i,r:o(255,u(t.r,0)),g:o(255,u(t.g,0)),b:o(255,u(t.b,0)),a:n}}function c(e,t,n){return{r:S(e,255)*255,g:S(t,255)*255,b:S(n,255)*255}}function h(e,t,n){e=S(e,255);t=S(t,255);n=S(n,255);var r=u(e,t,n),i=o(e,t,n);var s,a,f=(r+i)/2;if(r==i){s=a=0}else{var l=r-i;a=f>.5?l/(2-r-i):l/(r+i);switch(r){case e:s=(t-n)/l+(t<n?6:0);break;case t:s=(n-e)/l+2;break;case n:s=(e-t)/l+4;break}s/=6}return{h:s,s:a,l:f}}function p(e,t,n){function o(e,t,n){if(n<0)n+=1;if(n>1)n-=1;if(n<1/6)return e+(t-e)*6*n;if(n<1/2)return t;if(n<2/3)return e+(t-e)*(2/3-n)*6;return e}var r,i,s;e=S(e,360);t=S(t,100);n=S(n,100);if(t===0){r=i=s=n}else{var u=n<.5?n*(1+t):n+t-n*t;var a=2*n-u;r=o(a,u,e+1/3);i=o(a,u,e);s=o(a,u,e-1/3)}return{r:r*255,g:i*255,b:s*255}}function d(e,t,n){e=S(e,255);t=S(t,255);n=S(n,255);var r=u(e,t,n),i=o(e,t,n);var s,a,f=r;var l=r-i;a=r===0?0:l/r;if(r==i){s=0}else{switch(r){case e:s=(t-n)/l+(t<n?6:0);break;case t:s=(n-e)/l+2;break;case n:s=(e-t)/l+4;break}s/=6}return{h:s,s:a,v:f}}function v(e,t,n){e=S(e,360)*6;t=S(t,100);n=S(n,100);var r=i.floor(e),s=e-r,o=n*(1-t),u=n*(1-s*t),a=n*(1-(1-s)*t),f=r%6,l=[n,u,o,o,a,n][f],c=[a,n,n,u,o,o][f],h=[o,o,a,n,n,u][f];return{r:l*255,g:c*255,b:h*255}}function m(e,t,n,r){var i=[k(s(e).toString(16)),k(s(t).toString(16)),k(s(n).toString(16))];if(r&&i[0].charAt(0)==i[0].charAt(1)&&i[1].charAt(0)==i[1].charAt(1)&&i[2].charAt(0)==i[2].charAt(1)){return i[0].charAt(0)+i[1].charAt(0)+i[2].charAt(0)}return i.join("")}function g(e,t,n,r){var i=[k(A(r)),k(s(e).toString(16)),k(s(t).toString(16)),k(s(n).toString(16))];return i.join("")}function w(e){var t={};for(var n in e){if(e.hasOwnProperty(n)){t[e[n]]=n}}return t}function E(e){e=parseFloat(e);if(isNaN(e)||e<0||e>1){e=1}return e}function S(e,t){if(N(e)){e="100%"}var n=C(e);e=o(t,u(0,parseFloat(e)));if(n){e=parseInt(e*t,10)/100}if(i.abs(e-t)<1e-6){return 1}return e%t/parseFloat(t)}function x(e){return o(1,u(0,e))}function T(e){return parseInt(e,16)}function N(e){return typeof e=="string"&&e.indexOf(".")!=-1&&parseFloat(e)===1}function C(e){return typeof e==="string"&&e.indexOf("%")!=-1}function k(e){return e.length==1?"0"+e:""+e}function L(e){if(e<=1){e=e*100+"%"}return e}function A(e){return Math.round(parseFloat(e)*255).toString(16)}function O(e){return T(e)/255}function _(e){e=e.replace(t,"").replace(n,"").toLowerCase();var r=false;if(y[e]){e=y[e];r=true}else if(e=="transparent"){return{r:0,g:0,b:0,a:0,format:"name"}}var i;if(i=M.rgb.exec(e)){return{r:i[1],g:i[2],b:i[3]}}if(i=M.rgba.exec(e)){return{r:i[1],g:i[2],b:i[3],a:i[4]}}if(i=M.hsl.exec(e)){return{h:i[1],s:i[2],l:i[3]}}if(i=M.hsla.exec(e)){return{h:i[1],s:i[2],l:i[3],a:i[4]}}if(i=M.hsv.exec(e)){return{h:i[1],s:i[2],v:i[3]}}if(i=M.hex8.exec(e)){return{a:O(i[1]),r:T(i[2]),g:T(i[3]),b:T(i[4]),format:r?"name":"hex8"}}if(i=M.hex6.exec(e)){return{r:T(i[1]),g:T(i[2]),b:T(i[3]),format:r?"name":"hex"}}if(i=M.hex3.exec(e)){return{r:T(i[1]+""+i[1]),g:T(i[2]+""+i[2]),b:T(i[3]+""+i[3]),format:r?"name":"hex"}}return false}var t=/^[\s,#]+/,n=/\s+$/,r=0,i=Math,s=i.round,o=i.min,u=i.max,a=i.random;f.fromRatio=function(e,t){if(typeof e=="object"){var n={};for(var r in e){if(e.hasOwnProperty(r)){if(r==="a"){n[r]=e[r]}else{n[r]=L(e[r])}}}e=n}return f(e,t)};f.equals=function(e,t){if(!e||!t){return false}return f(e).toRgbString()==f(t).toRgbString()};f.random=function(){return f.fromRatio({r:a(),g:a(),b:a()})};f.desaturate=function(e,t){t=t===0?0:t||10;var n=f(e).toHsl();n.s-=t/100;n.s=x(n.s);return f(n)};f.saturate=function(e,t){t=t===0?0:t||10;var n=f(e).toHsl();n.s+=t/100;n.s=x(n.s);return f(n)};f.greyscale=function(e){return f.desaturate(e,100)};f.lighten=function(e,t){t=t===0?0:t||10;var n=f(e).toHsl();n.l+=t/100;n.l=x(n.l);return f(n)};f.darken=function(e,t){t=t===0?0:t||10;var n=f(e).toHsl();n.l-=t/100;n.l=x(n.l);return f(n)};f.complement=function(e){var t=f(e).toHsl();t.h=(t.h+180)%360;return f(t)};f.triad=function(e){var t=f(e).toHsl();var n=t.h;return[f(e),f({h:(n+120)%360,s:t.s,l:t.l}),f({h:(n+240)%360,s:t.s,l:t.l})]};f.tetrad=function(e){var t=f(e).toHsl();var n=t.h;return[f(e),f({h:(n+90)%360,s:t.s,l:t.l}),f({h:(n+180)%360,s:t.s,l:t.l}),f({h:(n+270)%360,s:t.s,l:t.l})]};f.splitcomplement=function(e){var t=f(e).toHsl();var n=t.h;return[f(e),f({h:(n+72)%360,s:t.s,l:t.l}),f({h:(n+216)%360,s:t.s,l:t.l})]};f.analogous=function(e,t,n){t=t||6;n=n||30;var r=f(e).toHsl();var i=360/n;var s=[f(e)];for(r.h=(r.h-(i*t>>1)+720)%360;--t;){r.h=(r.h+i)%360;s.push(f(r))}return s};f.monochromatic=function(e,t){t=t||6;var n=f(e).toHsv();var r=n.h,i=n.s,s=n.v;var o=[];var u=1/t;while(t--){o.push(f({h:r,s:i,v:s}));s=(s+u)%1}return o};f.readability=function(e,t){var n=f(e).toRgb();var r=f(t).toRgb();var i=(n.r*299+n.g*587+n.b*114)/1e3;var s=(r.r*299+r.g*587+r.b*114)/1e3;var o=Math.max(n.r,r.r)-Math.min(n.r,r.r)+Math.max(n.g,r.g)-Math.min(n.g,r.g)+Math.max(n.b,r.b)-Math.min(n.b,r.b);return{brightness:Math.abs(i-s),color:o}};f.readable=function(e,t){var n=f.readability(e,t);return n.brightness>125&&n.color>500};f.mostReadable=function(e,t){var n=null;var r=0;var i=false;for(var s=0;s<t.length;s++){var o=f.readability(e,t[s]);var u=o.brightness>125&&o.color>500;var a=3*(o.brightness/125)+o.color/500;if(u&&!i||u&&i&&a>r||!u&&!i&&a>r){i=u;r=a;n=f(t[s])}}return n};var y=f.names={aliceblue:"f0f8ff",antiquewhite:"faebd7",aqua:"0ff",aquamarine:"7fffd4",azure:"f0ffff",beige:"f5f5dc",bisque:"ffe4c4",black:"000",blanchedalmond:"ffebcd",blue:"00f",blueviolet:"8a2be2",brown:"a52a2a",burlywood:"deb887",burntsienna:"ea7e5d",cadetblue:"5f9ea0",chartreuse:"7fff00",chocolate:"d2691e",coral:"ff7f50",cornflowerblue:"6495ed",cornsilk:"fff8dc",crimson:"dc143c",cyan:"0ff",darkblue:"00008b",darkcyan:"008b8b",darkgoldenrod:"b8860b",darkgray:"a9a9a9",darkgreen:"006400",darkgrey:"a9a9a9",darkkhaki:"bdb76b",darkmagenta:"8b008b",darkolivegreen:"556b2f",darkorange:"ff8c00",darkorchid:"9932cc",darkred:"8b0000",darksalmon:"e9967a",darkseagreen:"8fbc8f",darkslateblue:"483d8b",darkslategray:"2f4f4f",darkslategrey:"2f4f4f",darkturquoise:"00ced1",darkviolet:"9400d3",deeppink:"ff1493",deepskyblue:"00bfff",dimgray:"696969",dimgrey:"696969",dodgerblue:"1e90ff",firebrick:"b22222",floralwhite:"fffaf0",forestgreen:"228b22",fuchsia:"f0f",gainsboro:"dcdcdc",ghostwhite:"f8f8ff",gold:"ffd700",goldenrod:"daa520",gray:"808080",green:"008000",greenyellow:"adff2f",grey:"808080",honeydew:"f0fff0",hotpink:"ff69b4",indianred:"cd5c5c",indigo:"4b0082",ivory:"fffff0",khaki:"f0e68c",lavender:"e6e6fa",lavenderblush:"fff0f5",lawngreen:"7cfc00",lemonchiffon:"fffacd",lightblue:"add8e6",lightcoral:"f08080",lightcyan:"e0ffff",lightgoldenrodyellow:"fafad2",lightgray:"d3d3d3",lightgreen:"90ee90",lightgrey:"d3d3d3",lightpink:"ffb6c1",lightsalmon:"ffa07a",lightseagreen:"20b2aa",lightskyblue:"87cefa",lightslategray:"789",lightslategrey:"789",lightsteelblue:"b0c4de",lightyellow:"ffffe0",lime:"0f0",limegreen:"32cd32",linen:"faf0e6",magenta:"f0f",maroon:"800000",mediumaquamarine:"66cdaa",mediumblue:"0000cd",mediumorchid:"ba55d3",mediumpurple:"9370db",mediumseagreen:"3cb371",mediumslateblue:"7b68ee",mediumspringgreen:"00fa9a",mediumturquoise:"48d1cc",mediumvioletred:"c71585",midnightblue:"191970",mintcream:"f5fffa",mistyrose:"ffe4e1",moccasin:"ffe4b5",navajowhite:"ffdead",navy:"000080",oldlace:"fdf5e6",olive:"808000",olivedrab:"6b8e23",orange:"ffa500",orangered:"ff4500",orchid:"da70d6",palegoldenrod:"eee8aa",palegreen:"98fb98",paleturquoise:"afeeee",palevioletred:"db7093",papayawhip:"ffefd5",peachpuff:"ffdab9",peru:"cd853f",pink:"ffc0cb",plum:"dda0dd",powderblue:"b0e0e6",purple:"800080",red:"f00",rosybrown:"bc8f8f",royalblue:"4169e1",saddlebrown:"8b4513",salmon:"fa8072",sandybrown:"f4a460",seagreen:"2e8b57",seashell:"fff5ee",sienna:"a0522d",silver:"c0c0c0",skyblue:"87ceeb",slateblue:"6a5acd",slategray:"708090",slategrey:"708090",snow:"fffafa",springgreen:"00ff7f",steelblue:"4682b4",tan:"d2b48c",teal:"008080",thistle:"d8bfd8",tomato:"ff6347",turquoise:"40e0d0",violet:"ee82ee",wheat:"f5deb3",white:"fff",whitesmoke:"f5f5f5",yellow:"ff0",yellowgreen:"9acd32"};var b=f.hexNames=w(y);var M=function(){var e="[-\\+]?\\d+%?";var t="[-\\+]?\\d*\\.\\d+%?";var n="(?:"+t+")|(?:"+e+")";var r="[\\s|\\(]+("+n+")[,|\\s]+("+n+")[,|\\s]+("+n+")\\s*\\)?";var i="[\\s|\\(]+("+n+")[,|\\s]+("+n+")[,|\\s]+("+n+")[,|\\s]+("+n+")\\s*\\)?";return{rgb:new RegExp("rgb"+r),rgba:new RegExp("rgba"+i),hsl:new RegExp("hsl"+r),hsla:new RegExp("hsla"+i),hsv:new RegExp("hsv"+r),hex3:/^([0-9a-fA-F]{1})([0-9a-fA-F]{1})([0-9a-fA-F]{1})$/,hex6:/^([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/,hex8:/^([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/}}();e.tinycolor=f})();t(function(){if(t.fn.spectrum.load){t.fn.spectrum.processNativeColorInputs()}})})(window,jQuery);
/*! Viewport | Author: Mika Tuupola (http://www.appelsiini.net/projects/viewport) | License: MIT */
(function($){$.belowthefold=function(element,settings){var fold=$(window).height()+$(window).scrollTop();return fold<=$(element).offset().top-settings.threshold;};$.abovethetop=function(element,settings){var top=$(window).scrollTop();return top>=$(element).offset().top+$(element).height()-settings.threshold;};$.rightofscreen=function(element,settings){var fold=$(window).width()+$(window).scrollLeft();return fold<=$(element).offset().left-settings.threshold;};$.leftofscreen=function(element,settings){var left=$(window).scrollLeft();return left>=$(element).offset().left+$(element).width()-settings.threshold;};$.inviewport=function(element,settings){return!$.rightofscreen(element,settings)&&!$.leftofscreen(element,settings)&&!$.belowthefold(element,settings)&&!$.abovethetop(element,settings);};$.extend($.expr[':'],{"below-the-fold":function(a,i,m){return $.belowthefold(a,{threshold:0});},"above-the-top":function(a,i,m){return $.abovethetop(a,{threshold:0});},"left-of-screen":function(a,i,m){return $.leftofscreen(a,{threshold:0});},"right-of-screen":function(a,i,m){return $.rightofscreen(a,{threshold:0});},"in-viewport":function(a,i,m){return $.inviewport(a,{threshold:0});}});})(jQuery);