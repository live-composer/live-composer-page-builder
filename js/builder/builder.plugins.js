
'use strict';

/*! Spectrum Colorpicker v1.3.1 | Author: Brian Grinstead (https://github.com/bgrins/spectrum) | License: MIT */
(function(e,t,n){function l(e,t,n){var r=[];for(var i=0;i<e.length;i++){var s=e[i];if(s){var u=tinycolor(s);var a=u.toHsl().l<.5?"sp-thumb-el sp-thumb-dark":"sp-thumb-el sp-thumb-light";a+=tinycolor.equals(t,s)?" sp-thumb-active":"";var f=o?"background-color:"+u.toRgbString():"filter:"+u.toFilter();r.push('<span title="'+u.toRgbString()+'" data-color="'+u.toRgbString()+'" class="'+a+'"><span class="sp-thumb-inner" style="'+f+';" /></span>')}else{var l="sp-clear-display";r.push('<span title="No Color Selected" data-color="" style="background-color:transparent;" class="'+l+'"></span>')}}return"<div class='sp-cf "+n+"'>"+r.join("")+"</div>"}function c(){for(var e=0;e<i.length;e++){if(i[e]){i[e].hide()}}}function h(e,n){var i=t.extend({},r,e);i.callbacks={move:g(i.move,n),change:g(i.change,n),show:g(i.show,n),hide:g(i.hide,n),beforeShow:g(i.beforeShow,n)};return i}function p(r,p){function St(){if(v.showPaletteOnly){v.showPalette=true}if(v.palette){F=v.palette.slice(0);I=t.isArray(F[0])?F:[F]}K.toggleClass("sp-flat",g);K.toggleClass("sp-input-disabled",!v.showInput);K.toggleClass("sp-alpha-enabled",v.showAlpha);K.toggleClass("sp-clear-enabled",Et);K.toggleClass("sp-buttons-disabled",!v.showButtons);K.toggleClass("sp-palette-disabled",!v.showPalette);K.toggleClass("sp-palette-only",v.showPaletteOnly);K.toggleClass("sp-initial-disabled",!v.showInitial);K.addClass(v.className);Ut()}function xt(){function o(e){if(e.data&&e.data.ignore){Ht(t(this).data("color"));Ft()}else{Ht(t(this).data("color"));Rt(true);Ft();Dt()}return false}if(s){K.find("*:not(input)").attr("unselectable","on")}St();if(ct){V.after(ht).hide()}if(!Et){ut.hide()}if(g){V.after(K).hide()}else{var n=v.appendTo==="parent"?V.parent():t(v.appendTo);if(n.length!==1){n=t("body")}n.append(K)}if(E&&e.localStorage){try{var r=e.localStorage[E].split(",#");if(r.length>1){delete e.localStorage[E];t.each(r,function(e,t){Tt(t)})}}catch(i){}try{q=e.localStorage[E].split(";")}catch(i){}}pt.bind("click.spectrum touchstart.spectrum",function(e){if(!J){Mt()}e.stopPropagation();if(!t(e.target).is("input")){e.preventDefault()}});if(V.is(":disabled")||v.disabled===true){Vt()}K.click(m);rt.change(Ot);rt.bind("paste",function(){setTimeout(Ot,1)});rt.keydown(function(e){if(e.keyCode==13){Ot()}});ot.text(v.cancelText);ot.bind("click.spectrum",function(e){e.stopPropagation();e.preventDefault();Dt("cancel")});ut.attr("title",v.clearText);ut.bind("click.spectrum",function(e){e.stopPropagation();e.preventDefault();wt=true;Ft();if(g){Rt(true)}});at.text(v.chooseText);at.bind("click.spectrum",function(e){e.stopPropagation();e.preventDefault();if(jt()){Rt(true);Dt()}});y(tt,function(e,t,n){j=e/M;wt=false;if(n.shiftKey){j=Math.round(j*10)/10}Ft()},Lt,At);y(Y,function(e,t){P=parseFloat(t/A);wt=false;if(!v.showAlpha){j=1}Ft()},Lt,At);y(Q,function(e,t,n){if(!n.shiftKey){z=null}else if(!z){var r=H*C;var i=k-B*k;var s=Math.abs(e-r)>Math.abs(t-i);z=s?"x":"y"}var o=!z||z==="x";var u=!z||z==="y";if(o){H=parseFloat(e/C)}if(u){B=parseFloat((k-t)/k)}wt=false;if(!v.showAlpha){j=1}Ft()},Lt,At);if(!!vt){Ht(vt);It();yt=gt||tinycolor(vt).format;Tt(vt)}else{It()}if(g){_t()}var u=s?"mousedown.spectrum":"click.spectrum touchstart.spectrum";it.delegate(".sp-thumb-el",u,o);st.delegate(".sp-thumb-el:nth-child(1)",u,{ignore:true},o)}function Tt(n){if(w){var r=tinycolor(n).toRgbString();if(t.inArray(r,q)===-1){q.push(r);while(q.length>R){q.shift()}}if(E&&e.localStorage){try{e.localStorage[E]=q.join(";")}catch(i){}}}}function Nt(){var e=[];var t=q;var n={};var r;if(v.showPalette){for(var i=0;i<I.length;i++){for(var s=0;s<I[i].length;s++){r=tinycolor(I[i][s]).toRgbString();n[r]=true}}for(i=0;i<t.length;i++){r=tinycolor(t[i]).toRgbString();if(!n.hasOwnProperty(r)){e.push(t[i]);n[r]=true}}}return e.reverse().slice(0,v.maxSelectionSize)}function Ct(){var e=Bt();var n=t.map(I,function(t,n){return l(t,e,"sp-palette-row sp-palette-row-"+n)});if(q){n.push(l(Nt(),e,"sp-palette-row sp-palette-row-selection"))}it.html(n.join(""))}function kt(){if(v.showInitial){var e=mt;var t=Bt();st.html(l([e,t],t,"sp-palette-row-initial"))}}function Lt(){if(k<=0||C<=0||A<=0){Ut()}K.addClass(U);z=null;V.trigger("dragstart.spectrum",[Bt()])}function At(){K.removeClass(U);V.trigger("dragstop.spectrum",[Bt()])}function Ot(){var e=rt.val();if((e===null||e==="")&&Et){Ht(null);Rt(true)}else{var t=tinycolor(e);if(t.ok){Ht(t);Rt(true)}else{rt.addClass("sp-validation-error")}}}function Mt(){if(N){Dt()}else{_t()}}function _t(){var n=t.Event("beforeShow.spectrum");if(N){Ut();return}V.trigger(n,[Bt()]);if(x.beforeShow(Bt())===false||n.isDefaultPrevented()){return}c();N=true;t(W).bind("click.spectrum",Dt);t(e).bind("resize.spectrum",T);ht.addClass("sp-active");K.removeClass("sp-hidden");Ut();It();mt=Bt();kt();x.show(mt);V.trigger("show.spectrum",[mt])}function Dt(n){if(n&&n.type=="click"&&n.button==2){return}if(!N||g){return}N=false;t(W).unbind("click.spectrum",Dt);t(e).unbind("resize.spectrum",T);ht.removeClass("sp-active");K.addClass("sp-hidden");var r=!tinycolor.equals(Bt(),mt);if(r){if(bt&&n!=="cancel"){Rt(true)}else{Pt()}}x.hide(Bt());V.trigger("hide.spectrum",[Bt()])}function Pt(){Ht(mt,true);x.change(mt);V.trigger("change",[mt])}function Ht(e,t){if(tinycolor.equals(e,Bt())){It();return}var n,r;if(!e&&Et){wt=true}else{wt=false;n=tinycolor(e);r=n.toHsv();P=r.h%360/360;H=r.s;B=r.v;j=r.a}It();if(n&&n.ok&&!t){yt=gt||n.format}}function Bt(e){e=e||{};if(Et&&wt){return null}return tinycolor.fromRatio({h:P,s:H,v:B,a:Math.round(j*100)/100},{format:e.format||yt})}function jt(){return!rt.hasClass("sp-validation-error")}function Ft(){It();x.move(Bt());V.trigger("move.spectrum",[Bt()])}function It(){rt.removeClass("sp-validation-error");qt();var e=tinycolor.fromRatio({h:P,s:1,v:1});Q.css("background-color",e.toHexString());var t=yt;if(j<1&&!(j===0&&t==="name")){if(t==="hex"||t==="hex3"||t==="hex6"||t==="name"){t="rgb"}}var n=Bt({format:t}),r="";dt.removeClass("sp-clear-display");dt.css("background-color","transparent");if(!n&&Et){dt.addClass("sp-clear-display")}else{var i=n.toHexString(),u=n.toRgbString();if(o||n.alpha===1){dt.css("background-color",u)}else{dt.css("background-color","transparent");dt.css("filter",n.toFilter())}if(v.showAlpha){var a=n.toRgb();a.a=0;var f=tinycolor(a).toRgbString();var l="linear-gradient(left, "+f+", "+i+")";if(s){et.css("filter",tinycolor(f).toFilter({gradientType:1},i))}else{et.css("background","-webkit-"+l);et.css("background","-moz-"+l);et.css("background","-ms-"+l);et.css("background",l)}}r=n.toString(t)}if(v.showInput){rt.val(r)}if(v.showPalette){Ct()}kt()}function qt(){var e=H;var t=B;if(Et&&wt){nt.hide();Z.hide();G.hide()}else{nt.show();Z.show();G.show();var n=e*C;var r=k-t*k;n=Math.max(-L,Math.min(C-L,n-L));r=Math.max(-L,Math.min(k-L,r-L));G.css({top:r+"px",left:n+"px"});var i=j*M;nt.css({left:i-_/2+"px"});var s=P*A;Z.css({top:s-D+"px"})}}function Rt(e){var t=Bt(),n="",r=!tinycolor.equals(t,mt);if(t){n=t.toString(yt);Tt(t)}if(ft){V.val(n)}mt=t;if(e&&r){x.change(t);V.trigger("change",[t])}}function Ut(){C=Q.width();k=Q.height();L=G.height();O=Y.width();A=Y.height();D=Z.height();M=tt.width();_=nt.width();if(!g){K.css("position","absolute");K.offset(d(K,pt))}qt();if(v.showPalette){Ct()}V.trigger("reflow.spectrum")}function zt(){V.show();pt.unbind("click.spectrum touchstart.spectrum");K.remove();ht.remove();i[$t.id]=null}function Wt(e,r){if(e===n){return t.extend({},v)}if(r===n){return v[e]}v[e]=r;St()}function Xt(){J=false;V.attr("disabled",false);pt.removeClass("sp-disabled")}function Vt(){Dt();J=true;V.attr("disabled",true);pt.addClass("sp-disabled")}var v=h(p,r),g=v.flat,w=v.showSelectionPalette,E=v.localStorageKey,S=v.theme,x=v.callbacks,T=b(Ut,10),N=false,C=0,k=0,L=0,A=0,O=0,M=0,_=0,D=0,P=0,H=0,B=0,j=1,F=[],I=[],q=v.selectionPalette.slice(0),R=v.maxSelectionSize,U="sp-dragging",z=null;var W=r.ownerDocument,X=W.body,V=t(r),J=false,K=t(f,W).addClass(S),Q=K.find(".sp-color"),G=K.find(".sp-dragger"),Y=K.find(".sp-hue"),Z=K.find(".sp-slider"),et=K.find(".sp-alpha-inner"),tt=K.find(".sp-alpha"),nt=K.find(".sp-alpha-handle"),rt=K.find(".sp-input"),it=K.find(".sp-palette"),st=K.find(".sp-initial"),ot=K.find(".sp-cancel"),ut=K.find(".sp-clear"),at=K.find(".sp-choose"),ft=V.is("input"),lt=ft&&u&&V.attr("type")==="color",ct=ft&&!g,ht=ct?t(a).addClass(S).addClass(v.className):t([]),pt=ct?ht:V,dt=ht.find(".sp-preview-inner"),vt=v.color||ft&&V.val(),mt=false,gt=v.preferredFormat,yt=gt,bt=!v.showButtons||v.clickoutFiresChange,wt=!vt,Et=v.allowEmpty&&!lt;xt();var $t={show:_t,hide:Dt,toggle:Mt,reflow:Ut,option:Wt,enable:Xt,disable:Vt,set:function(e){Ht(e);Rt()},get:Bt,destroy:zt,container:K};$t.id=i.push($t)-1;return $t}function d(e,n){var r=0;var i=e.outerWidth();var s=e.outerHeight();var o=n.outerHeight();var u=e[0].ownerDocument;var a=u.documentElement;var f=a.clientWidth+t(u).scrollLeft();var l=a.clientHeight+t(u).scrollTop();var c=n.offset();c.top+=o;c.left-=Math.min(c.left,c.left+i>f&&f>i?Math.abs(c.left+i-f):0);c.top-=Math.min(c.top,c.top+s>l&&l>s?Math.abs(s+o-r):r);return c}function v(){}function m(e){e.stopPropagation()}function g(e,t){var n=Array.prototype.slice;var r=n.call(arguments,2);return function(){return e.apply(t,r.concat(n.call(arguments)))}}function y(n,r,i,o){function d(e){if(e.stopPropagation){e.stopPropagation()}if(e.preventDefault){e.preventDefault()}e.returnValue=false}function v(e){if(a){if(s&&document.documentMode<9&&!e.button){return g()}var t=e.originalEvent.touches;var i=t?t[0].pageX:e.pageX;var o=t?t[0].pageY:e.pageY;var u=Math.max(0,Math.min(i-f.left,c));var p=Math.max(0,Math.min(o-f.top,l));if(h){d(e)}r.apply(n,[u,p,e])}}function m(e){var r=e.which?e.which==3:e.button==2;var s=e.originalEvent.touches;if(!r&&!a){if(i.apply(n,arguments)!==false){a=true;l=t(n).height();c=t(n).width();f=t(n).offset();t(u).bind(p);t(u.body).addClass("sp-dragging");if(!h){v(e)}d(e)}}}function g(){if(a){t(u).unbind(p);t(u.body).removeClass("sp-dragging");o.apply(n,arguments)}a=false}r=r||function(){};i=i||function(){};o=o||function(){};var u=n.ownerDocument||document;var a=false;var f={};var l=0;var c=0;var h="ontouchstart"in e;var p={};p["selectstart"]=d;p["dragstart"]=d;p["touchmove mousemove"]=v;p["touchend mouseup"]=g;t(n).bind("touchstart mousedown",m)}function b(e,t,n){var r;return function(){var i=this,s=arguments;var o=function(){r=null;e.apply(i,s)};if(n)clearTimeout(r);if(n||!r)r=setTimeout(o,t)}}function w(){if(e.console){if(Function.prototype.bind)w=Function.prototype.bind.call(console.log,console);else w=function(){Function.prototype.apply.call(console.log,console,arguments)};w.apply(this,arguments)}}var r={beforeShow:v,move:v,change:v,show:v,hide:v,color:false,flat:false,showInput:false,allowEmpty:false,showButtons:true,clickoutFiresChange:false,showInitial:false,showPalette:false,showPaletteOnly:false,showSelectionPalette:true,localStorageKey:false,appendTo:"body",maxSelectionSize:7,cancelText:"cancel",chooseText:"choose",clearText:"Clear Color Selection",preferredFormat:false,className:"",showAlpha:false,theme:"sp-light",palette:["fff","000"],selectionPalette:[],disabled:false},i=[],s=!!/msie/i.exec(e.navigator.userAgent),o=function(){function e(e,t){return!!~(""+e).indexOf(t)}var t=document.createElement("div");var n=t.style;n.cssText="background-color:rgba(0,0,0,.5)";return e(n.backgroundColor,"rgba")||e(n.backgroundColor,"hsla")}(),u=function(){var e=t("<input type='color' value='!' />")[0];return e.type==="color"&&e.value!=="!"}(),a=["<div class='sp-replacer'>","<div class='sp-preview'><div class='sp-preview-inner'></div></div>","<div class='sp-dd'>&#9660;</div>","</div>"].join(""),f=function(){var e="";if(s){for(var t=1;t<=6;t++){e+="<div class='sp-"+t+"'></div>"}}return["<div class='sp-container sp-hidden'>","<div class='sp-palette-container'>","<div class='sp-palette sp-thumb sp-cf'></div>","</div>","<div class='sp-picker-container'>","<div class='sp-top sp-cf'>","<div class='sp-fill'></div>","<div class='sp-top-inner'>","<div class='sp-color'>","<div class='sp-sat'>","<div class='sp-val'>","<div class='sp-dragger'></div>","</div>","</div>","</div>","<div class='sp-clear sp-clear-display'>","</div>","<div class='sp-hue'>","<div class='sp-slider'></div>",e,"</div>","</div>","<div class='sp-alpha'><div class='sp-alpha-inner'><div class='sp-alpha-handle'></div></div></div>","</div>","<div class='sp-input-container sp-cf'>","<input class='sp-input' type='text' spellcheck='false'  />","</div>","<div class='sp-initial sp-thumb sp-cf'></div>","<div class='sp-button-container sp-cf'>","<span class='dslca-sp-revert dslc-icon dslc-icon-undo' title='Revert to default'></span>","<span class='sp-cancel dslc-icon dslc-icon-remove' title='Cancel'></span>","<span class='sp-choose dslc-icon dslc-icon-ok' title='Confirm'></span>","</div>","</div>","</div>"].join("")}();var E="spectrum.id";t.fn.spectrum=function(e,n){if(typeof e=="string"){var r=this;var s=Array.prototype.slice.call(arguments,1);this.each(function(){var n=i[t(this).data(E)];if(n){var o=n[e];if(!o){throw new Error("Spectrum: no such method: '"+e+"'")}if(e=="get"){r=n.get()}else if(e=="container"){r=n.container}else if(e=="option"){r=n.option.apply(n,s)}else if(e=="destroy"){n.destroy();t(this).removeData(E)}else{o.apply(n,s)}}});return r}return this.spectrum("destroy").each(function(){var n=t.extend({},e,t(this).data());var r=p(this,n);t(this).data(E,r.id)})};t.fn.spectrum.load=true;t.fn.spectrum.loadOpts={};t.fn.spectrum.draggable=y;t.fn.spectrum.defaults=r;t.spectrum={};t.spectrum.localization={};t.spectrum.palettes={};t.fn.spectrum.processNativeColorInputs=function(){if(!u){t("input[type=color]").spectrum({preferredFormat:"hex6"})}};(function(){function f(e,t){e=e?e:"";t=t||{};if(typeof e=="object"&&e.hasOwnProperty("_tc_id")){return e}var n=l(e);var i=n.r,o=n.g,u=n.b,a=n.a,c=s(100*a)/100,p=t.format||n.format;if(i<1){i=s(i)}if(o<1){o=s(o)}if(u<1){u=s(u)}return{ok:n.ok,format:p,_tc_id:r++,alpha:a,getAlpha:function(){return a},setAlpha:function(e){a=E(e);c=s(100*a)/100},toHsv:function(){var e=d(i,o,u);return{h:e.h*360,s:e.s,v:e.v,a:a}},toHsvString:function(){var e=d(i,o,u);var t=s(e.h*360),n=s(e.s*100),r=s(e.v*100);return a==1?"hsv("+t+", "+n+"%, "+r+"%)":"hsva("+t+", "+n+"%, "+r+"%, "+c+")"},toHsl:function(){var e=h(i,o,u);return{h:e.h*360,s:e.s,l:e.l,a:a}},toHslString:function(){var e=h(i,o,u);var t=s(e.h*360),n=s(e.s*100),r=s(e.l*100);return a==1?"hsl("+t+", "+n+"%, "+r+"%)":"hsla("+t+", "+n+"%, "+r+"%, "+c+")"},toHex:function(e){return m(i,o,u,e)},toHexString:function(e){return"#"+this.toHex(e)},toHex8:function(){return g(i,o,u,a)},toHex8String:function(){return"#"+this.toHex8()},toRgb:function(){return{r:s(i),g:s(o),b:s(u),a:a}},toRgbString:function(){return a==1?"rgb("+s(i)+", "+s(o)+", "+s(u)+")":"rgba("+s(i)+", "+s(o)+", "+s(u)+", "+c+")"},toPercentageRgb:function(){return{r:s(S(i,255)*100)+"%",g:s(S(o,255)*100)+"%",b:s(S(u,255)*100)+"%",a:a}},toPercentageRgbString:function(){return a==1?"rgb("+s(S(i,255)*100)+"%, "+s(S(o,255)*100)+"%, "+s(S(u,255)*100)+"%)":"rgba("+s(S(i,255)*100)+"%, "+s(S(o,255)*100)+"%, "+s(S(u,255)*100)+"%, "+c+")"},toName:function(){if(a===0){return"transparent"}return b[m(i,o,u,true)]||false},toFilter:function(e){var n="#"+g(i,o,u,a);var r=n;var s=t&&t.gradientType?"GradientType = 1, ":"";if(e){var l=f(e);r=l.toHex8String()}return"progid:DXImageTransform.Microsoft.gradient("+s+"startColorstr="+n+",endColorstr="+r+")"},toString:function(e){var t=!!e;e=e||this.format;var n=false;var r=!t&&a<1&&a>0;var i=r&&(e==="hex"||e==="hex6"||e==="hex3"||e==="name");if(e==="rgb"){n=this.toRgbString()}if(e==="prgb"){n=this.toPercentageRgbString()}if(e==="hex"||e==="hex6"){n=this.toHexString()}if(e==="hex3"){n=this.toHexString(true)}if(e==="hex8"){n=this.toHex8String()}if(e==="name"){n=this.toName()}if(e==="hsl"){n=this.toHslString()}if(e==="hsv"){n=this.toHsvString()}if(i){return this.toRgbString()}return n||this.toHexString()}}}function l(e){var t={r:0,g:0,b:0};var n=1;var r=false;var i=false;if(typeof e=="string"){e=_(e)}if(typeof e=="object"){if(e.hasOwnProperty("r")&&e.hasOwnProperty("g")&&e.hasOwnProperty("b")){t=c(e.r,e.g,e.b);r=true;i=String(e.r).substr(-1)==="%"?"prgb":"rgb"}else if(e.hasOwnProperty("h")&&e.hasOwnProperty("s")&&e.hasOwnProperty("v")){e.s=L(e.s);e.v=L(e.v);t=v(e.h,e.s,e.v);r=true;i="hsv"}else if(e.hasOwnProperty("h")&&e.hasOwnProperty("s")&&e.hasOwnProperty("l")){e.s=L(e.s);e.l=L(e.l);t=p(e.h,e.s,e.l);r=true;i="hsl"}if(e.hasOwnProperty("a")){n=e.a}}n=E(n);return{ok:r,format:e.format||i,r:o(255,u(t.r,0)),g:o(255,u(t.g,0)),b:o(255,u(t.b,0)),a:n}}function c(e,t,n){return{r:S(e,255)*255,g:S(t,255)*255,b:S(n,255)*255}}function h(e,t,n){e=S(e,255);t=S(t,255);n=S(n,255);var r=u(e,t,n),i=o(e,t,n);var s,a,f=(r+i)/2;if(r==i){s=a=0}else{var l=r-i;a=f>.5?l/(2-r-i):l/(r+i);switch(r){case e:s=(t-n)/l+(t<n?6:0);break;case t:s=(n-e)/l+2;break;case n:s=(e-t)/l+4;break}s/=6}return{h:s,s:a,l:f}}function p(e,t,n){function o(e,t,n){if(n<0)n+=1;if(n>1)n-=1;if(n<1/6)return e+(t-e)*6*n;if(n<1/2)return t;if(n<2/3)return e+(t-e)*(2/3-n)*6;return e}var r,i,s;e=S(e,360);t=S(t,100);n=S(n,100);if(t===0){r=i=s=n}else{var u=n<.5?n*(1+t):n+t-n*t;var a=2*n-u;r=o(a,u,e+1/3);i=o(a,u,e);s=o(a,u,e-1/3)}return{r:r*255,g:i*255,b:s*255}}function d(e,t,n){e=S(e,255);t=S(t,255);n=S(n,255);var r=u(e,t,n),i=o(e,t,n);var s,a,f=r;var l=r-i;a=r===0?0:l/r;if(r==i){s=0}else{switch(r){case e:s=(t-n)/l+(t<n?6:0);break;case t:s=(n-e)/l+2;break;case n:s=(e-t)/l+4;break}s/=6}return{h:s,s:a,v:f}}function v(e,t,n){e=S(e,360)*6;t=S(t,100);n=S(n,100);var r=i.floor(e),s=e-r,o=n*(1-t),u=n*(1-s*t),a=n*(1-(1-s)*t),f=r%6,l=[n,u,o,o,a,n][f],c=[a,n,n,u,o,o][f],h=[o,o,a,n,n,u][f];return{r:l*255,g:c*255,b:h*255}}function m(e,t,n,r){var i=[k(s(e).toString(16)),k(s(t).toString(16)),k(s(n).toString(16))];if(r&&i[0].charAt(0)==i[0].charAt(1)&&i[1].charAt(0)==i[1].charAt(1)&&i[2].charAt(0)==i[2].charAt(1)){return i[0].charAt(0)+i[1].charAt(0)+i[2].charAt(0)}return i.join("")}function g(e,t,n,r){var i=[k(A(r)),k(s(e).toString(16)),k(s(t).toString(16)),k(s(n).toString(16))];return i.join("")}function w(e){var t={};for(var n in e){if(e.hasOwnProperty(n)){t[e[n]]=n}}return t}function E(e){e=parseFloat(e);if(isNaN(e)||e<0||e>1){e=1}return e}function S(e,t){if(N(e)){e="100%"}var n=C(e);e=o(t,u(0,parseFloat(e)));if(n){e=parseInt(e*t,10)/100}if(i.abs(e-t)<1e-6){return 1}return e%t/parseFloat(t)}function x(e){return o(1,u(0,e))}function T(e){return parseInt(e,16)}function N(e){return typeof e=="string"&&e.indexOf(".")!=-1&&parseFloat(e)===1}function C(e){return typeof e==="string"&&e.indexOf("%")!=-1}function k(e){return e.length==1?"0"+e:""+e}function L(e){if(e<=1){e=e*100+"%"}return e}function A(e){return Math.round(parseFloat(e)*255).toString(16)}function O(e){return T(e)/255}function _(e){e=e.replace(t,"").replace(n,"").toLowerCase();var r=false;if(y[e]){e=y[e];r=true}else if(e=="transparent"){return{r:0,g:0,b:0,a:0,format:"name"}}var i;if(i=M.rgb.exec(e)){return{r:i[1],g:i[2],b:i[3]}}if(i=M.rgba.exec(e)){return{r:i[1],g:i[2],b:i[3],a:i[4]}}if(i=M.hsl.exec(e)){return{h:i[1],s:i[2],l:i[3]}}if(i=M.hsla.exec(e)){return{h:i[1],s:i[2],l:i[3],a:i[4]}}if(i=M.hsv.exec(e)){return{h:i[1],s:i[2],v:i[3]}}if(i=M.hex8.exec(e)){return{a:O(i[1]),r:T(i[2]),g:T(i[3]),b:T(i[4]),format:r?"name":"hex8"}}if(i=M.hex6.exec(e)){return{r:T(i[1]),g:T(i[2]),b:T(i[3]),format:r?"name":"hex"}}if(i=M.hex3.exec(e)){return{r:T(i[1]+""+i[1]),g:T(i[2]+""+i[2]),b:T(i[3]+""+i[3]),format:r?"name":"hex"}}return false}var t=/^[\s,#]+/,n=/\s+$/,r=0,i=Math,s=i.round,o=i.min,u=i.max,a=i.random;f.fromRatio=function(e,t){if(typeof e=="object"){var n={};for(var r in e){if(e.hasOwnProperty(r)){if(r==="a"){n[r]=e[r]}else{n[r]=L(e[r])}}}e=n}return f(e,t)};f.equals=function(e,t){if(!e||!t){return false}return f(e).toRgbString()==f(t).toRgbString()};f.random=function(){return f.fromRatio({r:a(),g:a(),b:a()})};f.desaturate=function(e,t){t=t===0?0:t||10;var n=f(e).toHsl();n.s-=t/100;n.s=x(n.s);return f(n)};f.saturate=function(e,t){t=t===0?0:t||10;var n=f(e).toHsl();n.s+=t/100;n.s=x(n.s);return f(n)};f.greyscale=function(e){return f.desaturate(e,100)};f.lighten=function(e,t){t=t===0?0:t||10;var n=f(e).toHsl();n.l+=t/100;n.l=x(n.l);return f(n)};f.darken=function(e,t){t=t===0?0:t||10;var n=f(e).toHsl();n.l-=t/100;n.l=x(n.l);return f(n)};f.complement=function(e){var t=f(e).toHsl();t.h=(t.h+180)%360;return f(t)};f.triad=function(e){var t=f(e).toHsl();var n=t.h;return[f(e),f({h:(n+120)%360,s:t.s,l:t.l}),f({h:(n+240)%360,s:t.s,l:t.l})]};f.tetrad=function(e){var t=f(e).toHsl();var n=t.h;return[f(e),f({h:(n+90)%360,s:t.s,l:t.l}),f({h:(n+180)%360,s:t.s,l:t.l}),f({h:(n+270)%360,s:t.s,l:t.l})]};f.splitcomplement=function(e){var t=f(e).toHsl();var n=t.h;return[f(e),f({h:(n+72)%360,s:t.s,l:t.l}),f({h:(n+216)%360,s:t.s,l:t.l})]};f.analogous=function(e,t,n){t=t||6;n=n||30;var r=f(e).toHsl();var i=360/n;var s=[f(e)];for(r.h=(r.h-(i*t>>1)+720)%360;--t;){r.h=(r.h+i)%360;s.push(f(r))}return s};f.monochromatic=function(e,t){t=t||6;var n=f(e).toHsv();var r=n.h,i=n.s,s=n.v;var o=[];var u=1/t;while(t--){o.push(f({h:r,s:i,v:s}));s=(s+u)%1}return o};f.readability=function(e,t){var n=f(e).toRgb();var r=f(t).toRgb();var i=(n.r*299+n.g*587+n.b*114)/1e3;var s=(r.r*299+r.g*587+r.b*114)/1e3;var o=Math.max(n.r,r.r)-Math.min(n.r,r.r)+Math.max(n.g,r.g)-Math.min(n.g,r.g)+Math.max(n.b,r.b)-Math.min(n.b,r.b);return{brightness:Math.abs(i-s),color:o}};f.readable=function(e,t){var n=f.readability(e,t);return n.brightness>125&&n.color>500};f.mostReadable=function(e,t){var n=null;var r=0;var i=false;for(var s=0;s<t.length;s++){var o=f.readability(e,t[s]);var u=o.brightness>125&&o.color>500;var a=3*(o.brightness/125)+o.color/500;if(u&&!i||u&&i&&a>r||!u&&!i&&a>r){i=u;r=a;n=f(t[s])}}return n};var y=f.names={aliceblue:"f0f8ff",antiquewhite:"faebd7",aqua:"0ff",aquamarine:"7fffd4",azure:"f0ffff",beige:"f5f5dc",bisque:"ffe4c4",black:"000",blanchedalmond:"ffebcd",blue:"00f",blueviolet:"8a2be2",brown:"a52a2a",burlywood:"deb887",burntsienna:"ea7e5d",cadetblue:"5f9ea0",chartreuse:"7fff00",chocolate:"d2691e",coral:"ff7f50",cornflowerblue:"6495ed",cornsilk:"fff8dc",crimson:"dc143c",cyan:"0ff",darkblue:"00008b",darkcyan:"008b8b",darkgoldenrod:"b8860b",darkgray:"a9a9a9",darkgreen:"006400",darkgrey:"a9a9a9",darkkhaki:"bdb76b",darkmagenta:"8b008b",darkolivegreen:"556b2f",darkorange:"ff8c00",darkorchid:"9932cc",darkred:"8b0000",darksalmon:"e9967a",darkseagreen:"8fbc8f",darkslateblue:"483d8b",darkslategray:"2f4f4f",darkslategrey:"2f4f4f",darkturquoise:"00ced1",darkviolet:"9400d3",deeppink:"ff1493",deepskyblue:"00bfff",dimgray:"696969",dimgrey:"696969",dodgerblue:"1e90ff",firebrick:"b22222",floralwhite:"fffaf0",forestgreen:"228b22",fuchsia:"f0f",gainsboro:"dcdcdc",ghostwhite:"f8f8ff",gold:"ffd700",goldenrod:"daa520",gray:"808080",green:"008000",greenyellow:"adff2f",grey:"808080",honeydew:"f0fff0",hotpink:"ff69b4",indianred:"cd5c5c",indigo:"4b0082",ivory:"fffff0",khaki:"f0e68c",lavender:"e6e6fa",lavenderblush:"fff0f5",lawngreen:"7cfc00",lemonchiffon:"fffacd",lightblue:"add8e6",lightcoral:"f08080",lightcyan:"e0ffff",lightgoldenrodyellow:"fafad2",lightgray:"d3d3d3",lightgreen:"90ee90",lightgrey:"d3d3d3",lightpink:"ffb6c1",lightsalmon:"ffa07a",lightseagreen:"20b2aa",lightskyblue:"87cefa",lightslategray:"789",lightslategrey:"789",lightsteelblue:"b0c4de",lightyellow:"ffffe0",lime:"0f0",limegreen:"32cd32",linen:"faf0e6",magenta:"f0f",maroon:"800000",mediumaquamarine:"66cdaa",mediumblue:"0000cd",mediumorchid:"ba55d3",mediumpurple:"9370db",mediumseagreen:"3cb371",mediumslateblue:"7b68ee",mediumspringgreen:"00fa9a",mediumturquoise:"48d1cc",mediumvioletred:"c71585",midnightblue:"191970",mintcream:"f5fffa",mistyrose:"ffe4e1",moccasin:"ffe4b5",navajowhite:"ffdead",navy:"000080",oldlace:"fdf5e6",olive:"808000",olivedrab:"6b8e23",orange:"ffa500",orangered:"ff4500",orchid:"da70d6",palegoldenrod:"eee8aa",palegreen:"98fb98",paleturquoise:"afeeee",palevioletred:"db7093",papayawhip:"ffefd5",peachpuff:"ffdab9",peru:"cd853f",pink:"ffc0cb",plum:"dda0dd",powderblue:"b0e0e6",purple:"800080",red:"f00",rosybrown:"bc8f8f",royalblue:"4169e1",saddlebrown:"8b4513",salmon:"fa8072",sandybrown:"f4a460",seagreen:"2e8b57",seashell:"fff5ee",sienna:"a0522d",silver:"c0c0c0",skyblue:"87ceeb",slateblue:"6a5acd",slategray:"708090",slategrey:"708090",snow:"fffafa",springgreen:"00ff7f",steelblue:"4682b4",tan:"d2b48c",teal:"008080",thistle:"d8bfd8",tomato:"ff6347",turquoise:"40e0d0",violet:"ee82ee",wheat:"f5deb3",white:"fff",whitesmoke:"f5f5f5",yellow:"ff0",yellowgreen:"9acd32"};var b=f.hexNames=w(y);var M=function(){var e="[-\\+]?\\d+%?";var t="[-\\+]?\\d*\\.\\d+%?";var n="(?:"+t+")|(?:"+e+")";var r="[\\s|\\(]+("+n+")[,|\\s]+("+n+")[,|\\s]+("+n+")\\s*\\)?";var i="[\\s|\\(]+("+n+")[,|\\s]+("+n+")[,|\\s]+("+n+")[,|\\s]+("+n+")\\s*\\)?";return{rgb:new RegExp("rgb"+r),rgba:new RegExp("rgba"+i),hsl:new RegExp("hsl"+r),hsla:new RegExp("hsla"+i),hsv:new RegExp("hsv"+r),hex3:/^([0-9a-fA-F]{1})([0-9a-fA-F]{1})([0-9a-fA-F]{1})$/,hex6:/^([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/,hex8:/^([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/}}();e.tinycolor=f})();t(function(){if(t.fn.spectrum.load){t.fn.spectrum.processNativeColorInputs()}})})(window,jQuery);

/*! Sortable 1.4.2 - MIT | git://github.com/rubaxa/Sortable.git */
!function(a){"use strict";"function"==typeof define&&define.amd?define(a):"undefined"!=typeof module&&"undefined"!=typeof module.exports?module.exports=a():"undefined"!=typeof Package?Sortable=a():window.Sortable=a()}(function(){"use strict";function F(a,b){if(!a||!a.nodeType||1!==a.nodeType)throw"Sortable: `el` must be HTMLElement, and not "+{}.toString.call(a);this.el=a,this.options=b=X({},b),a[t]=this;var c={group:Math.random(),sort:!0,disabled:!1,store:null,handle:null,scroll:!0,scrollSensitivity:30,scrollSpeed:10,draggable:/[uo]l/i.test(a.nodeName)?"li":">*",ghostClass:"sortable-ghost",chosenClass:"sortable-chosen",ignore:"a, img",filter:null,animation:0,setData:function(a,b){a.setData("Text",b.textContent)},dropBubble:!1,dragoverBubble:!1,dataIdAttr:"data-id",delay:0,forceFallback:!1,fallbackClass:"sortable-fallback",fallbackOnBody:!1};for(var d in c)!(d in b)&&(b[d]=c[d]);E(b);for(var e in this)"_"===e.charAt(0)&&(this[e]=this[e].bind(this));this.nativeDraggable=!b.forceFallback&&x,J(a,"mousedown",this._onTapStart),J(a,"touchstart",this._onTapStart),this.nativeDraggable&&(J(a,"dragover",this),J(a,"dragenter",this)),C.push(this._onDragOver),b.store&&this.sort(b.store.get(this))}function G(b){d&&d.state!==b&&(M(d,"display",b?"none":""),!b&&d.state&&e.insertBefore(d,a),d.state=b)}function H(a,b,c){if(a){c=c||v;do if(">*"===b&&a.parentNode===c||V(a,b))return a;while(a!==c&&(a=a.parentNode))}return null}function I(a){a.dataTransfer&&(a.dataTransfer.dropEffect="move"),a.preventDefault()}function J(a,b,c){a.addEventListener(b,c,!1)}function K(a,b,c){a.removeEventListener(b,c,!1)}function L(a,b,c){if(a)if(a.classList)a.classList[c?"add":"remove"](b);else{var d=(" "+a.className+" ").replace(s," ").replace(" "+b+" "," ");a.className=(d+(c?" "+b:"")).replace(s," ")}}function M(a,b,c){var d=a&&a.style;if(d){if(void 0===c)return v.defaultView&&v.defaultView.getComputedStyle?c=v.defaultView.getComputedStyle(a,""):a.currentStyle&&(c=a.currentStyle),void 0===b?c:c[b];b in d||(b="-webkit-"+b),d[b]=c+("string"==typeof c?"":"px")}}function N(a,b,c){if(a){var d=a.getElementsByTagName(b),e=0,f=d.length;if(c)for(;e<f;e++)c(d[e],e);return d}return[]}function O(a,b,c,e,f,g,h){var i=v.createEvent("Event"),j=(a||b[t]).options,k="on"+c.charAt(0).toUpperCase()+c.substr(1);i.initEvent(c,!0,!0),i.to=b,i.from=f||b,i.item=e||b,i.clone=d,i.oldIndex=g,i.newIndex=h,b.dispatchEvent(i),j[k]&&j[k].call(a,i)}function P(a,b,c,d,e,f){var g,j,h=a[t],i=h.options.onMove;return g=v.createEvent("Event"),g.initEvent("move",!0,!0),g.to=b,g.from=a,g.dragged=c,g.draggedRect=d,g.related=e||b,g.relatedRect=f||b.getBoundingClientRect(),a.dispatchEvent(g),i&&(j=i.call(h,g)),j}function Q(a){a.draggable=!1}function R(){z=!1}function S(a,b){var c=a.lastElementChild,d=c.getBoundingClientRect();return(b.clientY-(d.top+d.height)>5||b.clientX-(d.right+d.width)>5)&&c}function T(a){for(var b=a.tagName+a.className+a.src+a.href+a.textContent,c=b.length,d=0;c--;)d+=b.charCodeAt(c);return d.toString(36)}function U(a,b){var c=0;if(!a||!a.parentNode)return-1;for(;a&&(a=a.previousElementSibling);)"TEMPLATE"!==a.nodeName.toUpperCase()&&V(a,b)&&c++;return c}function V(a,b){if(a){b=b.split(".");var c=b.shift().toUpperCase(),d=new RegExp("\\s("+b.join("|")+")(?=\\s)","g");return!(""!==c&&a.nodeName.toUpperCase()!=c||b.length&&((" "+a.className+" ").match(d)||[]).length!=b.length)}return!1}function W(a,b){var c,d;return function(){void 0===c&&(c=arguments,d=this,setTimeout(function(){1===c.length?a.call(d,c[0]):a.apply(d,c),c=void 0},b))}}function X(a,b){if(a&&b)for(var c in b)b.hasOwnProperty(c)&&(a[c]=b[c]);return a}if("undefined"==typeof window||"undefined"==typeof window.document)return function(){throw new Error("Sortable.js requires a window with a document")};var a,b,c,d,e,f,g,h,i,j,k,l,m,n,p,q,r,o={},s=/\s+/g,t="Sortable"+(new Date).getTime(),u=window,v=u.document,w=u.parseInt,x=!!("draggable"in v.createElement("div")),y=function(a){return a=v.createElement("x"),a.style.cssText="pointer-events:auto","auto"===a.style.pointerEvents}(),z=!1,A=Math.abs,C=([].slice,[]),D=W(function(a,b,c){if(c&&b.scroll){var d,e,n,p,f=b.scrollSensitivity,i=b.scrollSpeed,j=a.clientX,k=a.clientY,l=window.innerWidth,m=window.innerHeight;if(h!==c&&(g=b.scroll,h=c,g===!0)){g=c;do if(g.offsetWidth<g.scrollWidth||g.offsetHeight<g.scrollHeight)break;while(g=g.parentNode)}g&&(d=g,e=void 0==g.parentNode?g.document.body.getBoundingClientRect():g.getBoundingClientRect(),n=(A(e.right-j)<=f)-(A(e.left-j)<=f),p=(A(e.bottom-k)<=f)-(A(e.top-k)<=f)),n||p||(n=(l-j<=f)-(j<=f),p=(m-k<=f)-(k<=f),(n||p)&&(d=u)),o.vx===n&&o.vy===p&&o.el===d||(o.el=d,o.vx=n,o.vy=p,clearInterval(o.pid),d&&(o.pid=setInterval(function(){d===u?u.scrollTo(u.pageXOffset+n*i,u.pageYOffset+p*i):(p&&(d.scrollTop+=p*i),n&&(d.scrollLeft+=n*i))},24)))}},30),E=function(a){var b=a.group;b&&"object"==typeof b||(b=a.group={name:b}),["pull","put"].forEach(function(a){a in b||(b[a]=!0)}),a.groups=" "+b.name+(b.put.join?" "+b.put.join(" "):"")+" "};return F.prototype={constructor:F,_onTapStart:function(a){var b=this,c=this.el,d=this.options,e=a.type,f=a.touches&&a.touches[0],g=(f||a).target,h=g,i=d.filter;if(!("mousedown"===e&&0!==a.button||d.disabled)&&(g=H(g,d.draggable,c))){if(l=U(g,d.draggable),"function"==typeof i){if(i.call(this,a,g,this))return O(b,h,"filter",g,c,l),void a.preventDefault()}else if(i&&(i=i.split(",").some(function(a){if(a=H(h,a.trim(),c))return O(b,a,"filter",g,c,l),!0})))return void a.preventDefault();d.handle&&!H(h,d.handle,c)||this._prepareDragStart(a,f,g)}},_prepareDragStart:function(c,d,g){var l,h=this,i=h.el,j=h.options,k=i.ownerDocument;g&&!a&&g.parentNode===i&&(p=c,e=i,a=g,b=a.parentNode,f=a.nextSibling,n=j.group,a.style["will-change"]="transform",l=function(){h._disableDelayedDrag(),a.draggable=!0,L(a,h.options.chosenClass,!0),h._triggerDragStart(d)},j.ignore.split(",").forEach(function(b){N(a,b.trim(),Q)}),J(k,"mouseup",h._onDrop),J(k,"touchend",h._onDrop),J(k,"touchcancel",h._onDrop),j.delay?(J(k,"mouseup",h._disableDelayedDrag),J(k,"touchend",h._disableDelayedDrag),J(k,"touchcancel",h._disableDelayedDrag),J(k,"mousemove",h._disableDelayedDrag),J(k,"touchmove",h._disableDelayedDrag),h._dragStartTimer=setTimeout(l,j.delay)):l())},_disableDelayedDrag:function(){var a=this.el.ownerDocument;clearTimeout(this._dragStartTimer),K(a,"mouseup",this._disableDelayedDrag),K(a,"touchend",this._disableDelayedDrag),K(a,"touchcancel",this._disableDelayedDrag),K(a,"mousemove",this._disableDelayedDrag),K(a,"touchmove",this._disableDelayedDrag)},_triggerDragStart:function(b){b?(p={target:a,clientX:b.clientX,clientY:b.clientY},this._onDragStart(p,"touch")):this.nativeDraggable?(J(a,"dragend",this),J(e,"dragstart",this._onDragStart)):this._onDragStart(p,!0);try{v.selection?setTimeout(function(){v.selection.empty()}):window.getSelection().removeAllRanges()}catch(a){}},_dragStarted:function(){e&&a&&(L(a,this.options.ghostClass,!0),F.active=this,O(this,e,"start",a,e,l))},_emulateDragOver:function(){if(q){if(this._lastX===q.clientX&&this._lastY===q.clientY)return;this._lastX=q.clientX,this._lastY=q.clientY,y||M(c,"display","none");var a=v.elementFromPoint(q.clientX,q.clientY),b=a,d=" "+this.options.group.name,e=C.length;if(b)do{if(b[t]&&b[t].options.groups.indexOf(d)>-1){for(;e--;)C[e]({clientX:q.clientX,clientY:q.clientY,target:a,rootEl:b});break}a=b}while(b=b.parentNode);y||M(c,"display","")}},_onTouchMove:function(a){if(p){F.active||this._dragStarted(),this._appendGhost();var b=a.touches?a.touches[0]:a,d=b.clientX-p.clientX,e=b.clientY-p.clientY,f=a.touches?"translate3d("+d+"px,"+e+"px,0)":"translate("+d+"px,"+e+"px)";r=!0,q=b,M(c,"webkitTransform",f),M(c,"mozTransform",f),M(c,"msTransform",f),M(c,"transform",f),a.preventDefault()}},_appendGhost:function(){if(!c){var g,b=a.getBoundingClientRect(),d=M(a),f=this.options;c=a.cloneNode(!0),L(c,f.ghostClass,!1),L(c,f.fallbackClass,!0),M(c,"top",b.top-w(d.marginTop,10)),M(c,"left",b.left-w(d.marginLeft,10)),M(c,"width",b.width),M(c,"height",b.height),M(c,"opacity","0.8"),M(c,"position","fixed"),M(c,"zIndex","100000"),M(c,"pointerEvents","none"),f.fallbackOnBody&&v.body.appendChild(c)||e.appendChild(c),g=c.getBoundingClientRect(),M(c,"width",2*b.width-g.width),M(c,"height",2*b.height-g.height)}},_onDragStart:function(b,c){var f=b.dataTransfer,g=this.options;this._offUpEvents(),"clone"==n.pull&&(d=a.cloneNode(!0),M(d,"display","none"),e.insertBefore(d,a)),c?("touch"===c?(J(v,"touchmove",this._onTouchMove),J(v,"touchend",this._onDrop),J(v,"touchcancel",this._onDrop)):(J(v,"mousemove",this._onTouchMove),J(v,"mouseup",this._onDrop)),this._loopId=setInterval(this._emulateDragOver,50)):(f&&(f.effectAllowed="move",g.setData&&g.setData.call(this,f,a)),J(v,"drop",this),setTimeout(this._dragStarted,0))},_onDragOver:function(g){var l,m,o,h=this.el,p=this.options,q=p.group,s=q.put,u=n===q,v=p.sort;if(void 0!==g.preventDefault&&(g.preventDefault(),!p.dragoverBubble&&g.stopPropagation()),r=!0,n&&!p.disabled&&(u?v||(o=!e.contains(a)):n.pull&&s&&(n.name===q.name||s.indexOf&&~s.indexOf(n.name)))&&(void 0===g.rootEl||g.rootEl===this.el)){if(D(g,p,this.el),z)return;if(l=H(g.target,p.draggable,h),m=a.getBoundingClientRect(),o)return G(!0),void(d||f?e.insertBefore(a,d||f):v||e.appendChild(a));if(0===h.children.length||h.children[0]===c||h===g.target&&(l=S(h,g))){if(l){if(l.animated)return;w=l.getBoundingClientRect()}G(u),P(e,h,a,m,l,w)!==!1&&(a.contains(h)||(h.appendChild(a),b=h),this._animate(m,a),l&&this._animate(w,l))}else if(l&&!l.animated&&l!==a&&void 0!==l.parentNode[t]){i!==l&&(i=l,j=M(l),k=M(l.parentNode));var J,w=l.getBoundingClientRect(),x=w.right-w.left,y=w.bottom-w.top,A=/left|right|inline/.test(j.cssFloat+j.display)||"flex"==k.display&&0===k["flex-direction"].indexOf("row"),B=l.offsetWidth>a.offsetWidth,C=l.offsetHeight>a.offsetHeight,E=(A?(g.clientX-w.left)/x:(g.clientY-w.top)/y)>.5,F=l.nextElementSibling,I=P(e,h,a,m,l,w);if(I!==!1){if(z=!0,setTimeout(R,30),G(u),1===I||I===-1)J=1===I;else if(A){var K=a.offsetTop,L=l.offsetTop;J=K===L?l.previousElementSibling===a&&!B||E&&B:l.previousElementSibling===a||a.previousElementSibling===l?(g.clientY-w.top)/y>.5:L>K}else J=F!==a&&!C||E&&C;a.contains(h)||(J&&!F?h.appendChild(a):l.parentNode.insertBefore(a,J?F:l)),b=a.parentNode,this._animate(m,a),this._animate(w,l)}}}},_animate:function(a,b){var c=this.options.animation;if(c){var d=b.getBoundingClientRect();M(b,"transition","none"),M(b,"transform","translate3d("+(a.left-d.left)+"px,"+(a.top-d.top)+"px,0)"),b.offsetWidth,M(b,"transition","all "+c+"ms"),M(b,"transform","translate3d(0,0,0)"),clearTimeout(b.animated),b.animated=setTimeout(function(){M(b,"transition",""),M(b,"transform",""),b.animated=!1},c)}},_offUpEvents:function(){var a=this.el.ownerDocument;K(v,"touchmove",this._onTouchMove),K(a,"mouseup",this._onDrop),K(a,"touchend",this._onDrop),K(a,"touchcancel",this._onDrop)},_onDrop:function(g){var h=this.el,i=this.options;clearInterval(this._loopId),clearInterval(o.pid),clearTimeout(this._dragStartTimer),K(v,"mousemove",this._onTouchMove),this.nativeDraggable&&(K(v,"drop",this),K(h,"dragstart",this._onDragStart)),this._offUpEvents(),g&&(r&&(g.preventDefault(),!i.dropBubble&&g.stopPropagation()),c&&c.parentNode.removeChild(c),a&&(this.nativeDraggable&&K(a,"dragend",this),Q(a),a.style["will-change"]="",L(a,this.options.ghostClass,!1),L(a,this.options.chosenClass,!1),e!==b?(m=U(a,i.draggable),m>=0&&(O(null,b,"sort",a,e,l,m),O(this,e,"sort",a,e,l,m),O(null,b,"add",a,e,l,m),O(this,e,"remove",a,e,l,m))):(d&&d.parentNode.removeChild(d),a.nextSibling!==f&&(m=U(a,i.draggable),m>=0&&(O(this,e,"update",a,e,l,m),O(this,e,"sort",a,e,l,m)))),F.active&&(null!=m&&m!==-1||(m=l),O(this,e,"end",a,e,l,m),this.save()))),this._nulling()},_nulling:function(){(F.active===this||!F.active)&&(e=a=b=c=f=d=g=h=p=q=r=m=i=j=n=F.active=null)},handleEvent:function(b){var c=b.type;"dragover"===c||"dragenter"===c?a&&(this._onDragOver(b),I(b)):"drop"!==c&&"dragend"!==c||this._onDrop(b)},toArray:function(){for(var b,a=[],c=this.el.children,d=0,e=c.length,f=this.options;d<e;d++)b=c[d],H(b,f.draggable,this.el)&&a.push(b.getAttribute(f.dataIdAttr)||T(b));return a},sort:function(a){var b={},c=this.el;this.toArray().forEach(function(a,d){var e=c.children[d];H(e,this.options.draggable,c)&&(b[a]=e)},this),a.forEach(function(a){b[a]&&(c.removeChild(b[a]),c.appendChild(b[a]))})},save:function(){var a=this.options.store;a&&a.set(this)},closest:function(a,b){return H(a,b||this.options.draggable,this.el)},option:function(a,b){var c=this.options;return void 0===b?c[a]:(c[a]=b,void("group"===a&&E(c)))},destroy:function(){var a=this.el;a[t]=null,K(a,"mousedown",this._onTapStart),K(a,"touchstart",this._onTapStart),this.nativeDraggable&&(K(a,"dragover",this),K(a,"dragenter",this)),Array.prototype.forEach.call(a.querySelectorAll("[draggable]"),function(a){a.removeAttribute("draggable")}),C.splice(C.indexOf(this._onDragOver),1),this._onDrop(),this.el=a=null}},F.utils={on:J,off:K,css:M,find:N,is:function(a,b){return!!H(a,b,a)},extend:X,throttle:W,closest:H,toggleClass:L,index:U},F.create=function(a,b){return new F(a,b)},F.version="1.4.2",F});
/**
 * If update sortable library test:
 * – bug when inner content disappear in sortable while dragging
 * – errors in IE
 */


/**
 * Mutation observer library written by Alexey Petlenko
 *
 * @author Alexey Petlenko(Massique)
 */

;(function(){

	'use strict';

	var observerClass = function(element, callback, config) {

		if ( ! window.MutationObserver ) {

			console.error('mq_mutation_obs:: Browser does not support mutations! Please, install IE11+ or update your current browser to newest version.' );
			return false;
		}

		if( ! element || typeof callback != 'function' || ( typeof config != 'object' && config ) ) {

			console.error('mq_mutation_obs:: invalid arguments in class constructor');
			return false;
		}

		// create an observer instance
		var observer = new MutationObserver(function(mutations) {

		    mutations.forEach(callback);
		});

		// configuration of the observer:
		var configFinal = config || { attributes: true, childList: true, characterData: true };

		// pass in the target node, as well as the observer options
		observer.observe(element, configFinal);

		return observer;
	}

	window.mqMutationObserver = observerClass;
}());


/**
 * Hide element when click on another element on the page
 *
 * @author Alexey Petlenko
 */
jQuery.fn.outerHide = function(params)
{
    var $ = jQuery;
    params = params ? params : {};

    var self = this;

    if ( 'destroy' == params ) {

        $(document).unbind('click.outer_hide');
        return false;
    }

    $(document).bind('click.outer_hide', function(e) {

        if ($(e.target).closest(self).length == 0 &&
            e.target != self &&
            $.inArray($(e.target)[0], $(params.clickObj)) == -1 &&
            $(self).css('display') != 'none'
        )
        {
            if(params.clbk)
            {
                params.clbk();
            }else{
                $(self).hide();
            }
        }
    });
}


function dslc_serialize (mixedValue) {
	'use strict';

  //  discuss at: http://locutus.io/php/serialize/
  // original by: Arpad Ray (mailto:arpad@php.net)
  // improved by: Dino
  // improved by: Le Torbi (http://www.letorbi.de/)
  // improved by: Kevin van Zonneveld (http://kvz.io/)
  // bugfixed by: Andrej Pavlovic
  // bugfixed by: Garagoth
  // bugfixed by: Russell Walker (http://www.nbill.co.uk/)
  // bugfixed by: Jamie Beck (http://www.terabit.ca/)
  // bugfixed by: Kevin van Zonneveld (http://kvz.io/)
  // bugfixed by: Ben (http://benblume.co.uk/)
  // bugfixed by: Codestar (http://codestarlive.com/)
  //    input by: DtTvB (http://dt.in.th/2008-09-16.string-length-in-bytes.html)
  //    input by: Martin (http://www.erlenwiese.de/)
  //      note 1: We feel the main purpose of this function should be to ease
  //      note 1: the transport of data between php & js
  //      note 1: Aiming for PHP-compatibility, we have to translate objects to arrays
  //   example 1: serialize(['Kevin', 'van', 'Zonneveld'])
  //   returns 1: 'a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}'
  //   example 2: serialize({firstName: 'Kevin', midName: 'van'})
  //   returns 2: 'a:2:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";}'

  var val, key, okey
  var ktype = ''
  var vals = ''
  var count = 0

  var _utf8Size = function (str) {
    var size = 0
    var i = 0
    var l = str.length
    var code = ''
    for (i = 0; i < l; i++) {
      code = str.charCodeAt(i)
      if (code < 0x0080) {
        size += 1
      } else if (code < 0x0800) {
        size += 2
      } else {
        size += 3
      }
    }
    return size
  }

  var _getType = function (inp) {
    var match
    var key
    var cons
    var types
    var type = typeof inp

    if (type === 'object' && !inp) {
      return 'null'
    }

    if (type === 'object') {
      if (!inp.constructor) {
        return 'object'
      }
      cons = inp.constructor.toString()
      match = cons.match(/(\w+)\(/)
      if (match) {
        cons = match[1].toLowerCase()
      }
      types = ['boolean', 'number', 'string', 'array']
      for (key in types) {
        if (cons === types[key]) {
          type = types[key]
          break
        }
      }
    }
    return type
  }

  var type = _getType(mixedValue)

  switch (type) {
    case 'function':
      val = ''
      break
    case 'boolean':
      val = 'b:' + (mixedValue ? '1' : '0')
      break
    case 'number':
      val = (Math.round(mixedValue) === mixedValue ? 'i' : 'd') + ':' + mixedValue
      break
    case 'string':
      val = 's:' + _utf8Size(mixedValue) + ':"' + mixedValue + '"'
      break
    case 'array':
    case 'object':
      val = 'a'
      /*
      if (type === 'object') {
        var objname = mixedValue.constructor.toString().match(/(\w+)\(\)/);
        if (objname === undefined) {
          return;
        }
        objname[1] = serialize(objname[1]);
        val = 'O' + objname[1].substring(1, objname[1].length - 1);
      }
      */

      for (key in mixedValue) {
        if (mixedValue.hasOwnProperty(key)) {
          ktype = _getType(mixedValue[key])
          if (ktype === 'function') {
            continue
          }

          okey = (key.match(/^[0-9]+$/) ? parseInt(key, 10) : key)
          vals += dslc_serialize(okey) + dslc_serialize(mixedValue[key])
          count++
        }
      }
      val += ':' + count + ':{' + vals + '}'
      break
    case 'undefined':
    default:
      // Fall-through
      // if the JS object has a property which contains a null value,
      // the string cannot be unserialized by PHP
      val = 'N'
      break
  }
  if (type !== 'object' && type !== 'array') {
    val += ';'
  }

  return val
}

function dslc_unserialize(data) {

	'use strict';

   //  discuss at: http://locutus.io/php/unserialize/
   // original by: Arpad Ray (mailto:arpad@php.net)
   // improved by: Pedro Tainha (http://www.pedrotainha.com)
   // improved by: Kevin van Zonneveld (http://kvz.io)
   // improved by: Kevin van Zonneveld (http://kvz.io)
   // improved by: Chris
   // improved by: James
   // improved by: Le Torbi
   // improved by: Eli Skeggs
   // bugfixed by: dptr1988
   // bugfixed by: Kevin van Zonneveld (http://kvz.io)
   // bugfixed by: Brett Zamir (http://brett-zamir.me)
   //  revised by: d3x
   //    input by: Brett Zamir (http://brett-zamir.me)
   //    input by: Martin (http://www.erlenwiese.de/)
   //    input by: kilops
   //    input by: Jaroslaw Czarniak
   //      note 1: We feel the main purpose of this function should be
   //      note 1: to ease the transport of data between php & js
   //      note 1: Aiming for PHP-compatibility, we have to translate objects to arrays
   //   example 1: unserialize('a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}')
   //   returns 1: ['Kevin', 'van', 'Zonneveld']
   //   example 2: unserialize('a:2:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";}')
   //   returns 2: {firstName: 'Kevin', midName: 'van'}

   var $global = (typeof window !== 'undefined' ? window : GLOBAL)

   var utf8Overhead = function (chr) {
     // http://locutus.io/php/unserialize:571#comment_95906
     var code = chr.charCodeAt(0)
     var zeroCodes = [
       338,
       339,
       352,
       353,
       376,
       402,
       8211,
       8212,
       8216,
       8217,
       8218,
       8220,
       8221,
       8222,
       8224,
       8225,
       8226,
       8230,
       8240,
       8364,
       8482
     ]
     if (code < 0x0080 || code >= 0x00A0 && code <= 0x00FF || zeroCodes.indexOf(code) !== -1) {
       return 0
     }
     if (code < 0x0800) {
       return 1
     }
     return 2
   }
   var error = function (type,
     msg, filename, line) {
     throw new $global[type](msg, filename, line)
   }
   var readUntil = function (data, offset, stopchr) {
     var i = 2
     var buf = []
     var chr = data.slice(offset, offset + 1)

     while (chr !== stopchr) {
       if ((i + offset) > data.length) {
         error('Error', 'Invalid')
       }
       buf.push(chr)
       chr = data.slice(offset + (i - 1), offset + i)
       i += 1
     }
     return [buf.length, buf.join('')]
   }
   var readChrs = function (data, offset, length) {
     var i, chr, buf

     buf = []
     for (i = 0; i < length; i++) {
       chr = data.slice(offset + (i - 1), offset + i)
       buf.push(chr)
       length -= utf8Overhead(chr)
     }
     return [buf.length, buf.join('')]
   }
   var _unserialize = function (data, offset) {
     var dtype
     var dataoffset
     var keyandchrs
     var keys
     var contig
     var length
     var array
     var readdata
     var readData
     var ccount
     var stringlength
     var i
     var key
     var kprops
     var kchrs
     var vprops
     var vchrs
     var value
     var chrs = 0
     var typeconvert = function (x) {
       return x
     }

     if (!offset) {
       offset = 0
     }
     dtype = (data.slice(offset, offset + 1)).toLowerCase()

     dataoffset = offset + 2

     switch (dtype) {
       case 'i':
         typeconvert = function (x) {
           return parseInt(x, 10)
         }
         readData = readUntil(data, dataoffset, ';')
         chrs = readData[0]
         readdata = readData[1]
         dataoffset += chrs + 1
         break
       case 'b':
         typeconvert = function (x) {
           return parseInt(x, 10) !== 0
         }
         readData = readUntil(data, dataoffset, ';')
         chrs = readData[0]
         readdata = readData[1]
         dataoffset += chrs + 1
         break
       case 'd':
         typeconvert = function (x) {
           return parseFloat(x)
         }
         readData = readUntil(data, dataoffset, ';')
         chrs = readData[0]
         readdata = readData[1]
         dataoffset += chrs + 1
         break
       case 'n':
         readdata = null
         break
       case 's':
         ccount = readUntil(data, dataoffset, ':')
         chrs = ccount[0]
         stringlength = ccount[1]
         dataoffset += chrs + 2

         readData = readChrs(data, dataoffset + 1, parseInt(stringlength, 10))
         chrs = readData[0]
         readdata = readData[1]
         dataoffset += chrs + 2
         if (chrs !== parseInt(stringlength, 10) && chrs !== readdata.length) {
           error('SyntaxError', 'String length mismatch')
         }
         break
       case 'a':
         readdata = {}

         keyandchrs = readUntil(data, dataoffset, ':')
         chrs = keyandchrs[0]
         keys = keyandchrs[1]
         dataoffset += chrs + 2

         length = parseInt(keys, 10)
         contig = true

         for (i = 0; i < length; i++) {
           kprops = _unserialize(data, dataoffset)
           kchrs = kprops[1]
           key = kprops[2]
           dataoffset += kchrs

           vprops = _unserialize(data, dataoffset)
           vchrs = vprops[1]
           value = vprops[2]
           dataoffset += vchrs

           if (key !== i) {
             contig = false
           }

           readdata[key] = value
         }

         if (contig) {
           array = new Array(length)
           for (i = 0; i < length; i++) {
             array[i] = readdata[i]
           }
           readdata = array
         }

         dataoffset += 1
         break
       default:
         error('SyntaxError', 'Unknown / Unhandled data type(s): ' + dtype)
         break
     }
     return [dtype, dataoffset - offset, typeconvert(readdata)]
   }

   return _unserialize((data + ''), 0)[2]
}