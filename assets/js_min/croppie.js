!function(e,t){"function"==typeof define&&define.amd?define(["exports"],t):t("object"==typeof exports&&"string"!=typeof exports.nodeName?exports:e.commonJsStrict={})}(this,function(e){function t(e){if(e in O)return e;for(var t=e[0].toUpperCase()+e.slice(1),n=W.length;n--;)if(e=W[n]+t,e in O)return e}function n(e,t){e=e||{};for(var i in t)t[i]&&t[i].constructor&&t[i].constructor===Object?(e[i]=e[i]||{},n(e[i],t[i])):e[i]=t[i];return e}function i(e,t,n){var i;return function(){var o=this,r=arguments,a=function(){i=null,n||e.apply(o,r)},s=n&&!i;clearTimeout(i),i=setTimeout(a,t),s&&e.apply(o,r)}}function o(e){if("createEvent"in document){var t=document.createEvent("HTMLEvents");t.initEvent("change",!1,!0),e.dispatchEvent(t)}else e.fireEvent("onchange")}function r(e,t,n){if("string"==typeof t){var i=t;t={},t[i]=n}for(var o in t)e.style[o]=t[o]}function a(e,t){e.classList?e.classList.add(t):e.className+=" "+t}function s(e,t){e.classList?e.classList.remove(t):e.className=e.className.replace(t,"")}function l(e,t){var n,i=t||new Image;return i.src===e?n=new Promise(function(e,t){e(i)}):(n=new Promise(function(t,n){"http"===e.substring(0,4).toLowerCase()&&i.setAttribute("crossOrigin","anonymous"),i.onload=function(){setTimeout(function(){t(i)},1)}}),i.src=e),i.style.opacity=0,n}function u(e,t){window.EXIF||t(0),EXIF.getData(e,function(){var e=EXIF.getTag(this,"Orientation");t(e)})}function c(e,t,n){var i=t.width,o=t.height,r=e.getContext("2d");switch(e.width=t.width,e.height=t.height,r.save(),n){case 2:r.translate(i,0),r.scale(-1,1);break;case 3:r.translate(i,o),r.rotate(180*Math.PI/180);break;case 4:r.translate(0,o),r.scale(1,-1);break;case 5:e.width=o,e.height=i,r.rotate(90*Math.PI/180),r.scale(1,-1);break;case 6:e.width=o,e.height=i,r.rotate(90*Math.PI/180),r.translate(0,-o);break;case 7:e.width=o,e.height=i,r.rotate(-90*Math.PI/180),r.translate(-i,o),r.scale(1,-1);break;case 8:e.width=o,e.height=i,r.translate(0,i),r.rotate(-90*Math.PI/180)}r.drawImage(t,0,0,i,o),r.restore()}function p(){var e,t,n,i,o=this,s="croppie-container",l=o.options.viewport.type?"cr-vp-"+o.options.viewport.type:null;o.options.useCanvas=o.options.enableOrientation||h.call(o),o.data={},o.elements={},e=o.elements.boundary=document.createElement("div"),n=o.elements.viewport=document.createElement("div"),t=o.elements.img=document.createElement("img"),i=o.elements.overlay=document.createElement("div"),o.options.useCanvas?(o.elements.canvas=document.createElement("canvas"),o.elements.preview=o.elements.canvas):o.elements.preview=o.elements.img,a(e,"cr-boundary"),r(e,{width:o.options.boundary.width+"px",height:o.options.boundary.height+"px"}),a(n,"cr-viewport"),l&&a(n,l),r(n,{width:o.options.viewport.width+"px",height:o.options.viewport.height+"px"}),n.setAttribute("tabindex",0),a(o.elements.preview,"cr-image"),a(i,"cr-overlay"),o.element.appendChild(e),e.appendChild(o.elements.preview),e.appendChild(n),e.appendChild(i),a(o.element,s),o.options.customClass&&a(o.element,o.options.customClass),w.call(this),o.options.enableZoom&&m.call(o)}function h(){return this.options.enableExif&&window.EXIF}function d(e){if(this.options.enableZoom){var t=this.elements.zoomer,n=F(e,4);t.value=Math.max(t.min,Math.min(t.max,n))}}function m(){function e(){f.call(n,{value:parseFloat(o.value),origin:new D(n.elements.preview),viewportRect:n.elements.viewport.getBoundingClientRect(),transform:T.parse(n.elements.preview)})}function t(t){var i,o;i=t.wheelDelta?t.wheelDelta/1200:t.deltaY?t.deltaY/1060:t.detail?t.detail/-60:0,o=n._currentZoom+i,t.preventDefault(),d.call(n,o),e.call(n)}var n=this,i=n.elements.zoomerWrap=document.createElement("div"),o=n.elements.zoomer=document.createElement("input");a(i,"cr-slider-wrap"),a(o,"cr-slider"),o.type="range",o.step="0.0001",o.value=1,o.style.display=n.options.showZoomer?"":"none",n.element.appendChild(i),i.appendChild(o),n._currentZoom=1,n.elements.zoomer.addEventListener("input",e),n.elements.zoomer.addEventListener("change",e),n.options.mouseWheelZoom&&(n.elements.boundary.addEventListener("mousewheel",t),n.elements.boundary.addEventListener("DOMMouseScroll",t))}function f(e){function t(){var e={};e[z]=i.toString(),e[k]=a.toString(),r(n.elements.preview,e)}var n=this,i=e?e.transform:T.parse(n.elements.preview),o=e?e.viewportRect:n.elements.viewport.getBoundingClientRect(),a=e?e.origin:new D(n.elements.preview);if(n._currentZoom=e?e.value:n._currentZoom,i.scale=n._currentZoom,t(),n.options.enforceBoundary){var s=v.call(n,o),l=s.translate,u=s.origin;i.x>=l.maxX&&(a.x=u.minX,i.x=l.maxX),i.x<=l.minX&&(a.x=u.maxX,i.x=l.minX),i.y>=l.maxY&&(a.y=u.minY,i.y=l.maxY),i.y<=l.minY&&(a.y=u.maxY,i.y=l.minY)}t(),N.call(n),b.call(n)}function v(e){var t=this,n=t._currentZoom,i=e.width,o=e.height,r=t.options.boundary.width/2,a=t.options.boundary.height/2,s=t.elements.preview.getBoundingClientRect(),l=s.width,u=s.height,c=i/2,p=o/2,h=-1*(c/n-r),d=h-(l*(1/n)-i*(1/n)),m=-1*(p/n-a),f=m-(u*(1/n)-o*(1/n)),v=1/n*c,g=l*(1/n)-v,w=1/n*p,y=u*(1/n)-w;return{translate:{maxX:h,minX:d,maxY:m,minY:f},origin:{maxX:g,minX:v,maxY:y,minY:w}}}function g(){var e=this,t=e._currentZoom,n=e.elements.preview.getBoundingClientRect(),i=e.elements.viewport.getBoundingClientRect(),o=T.parse(e.elements.preview.style[z]),a=new D(e.elements.preview),s=i.top-n.top+i.height/2,l=i.left-n.left+i.width/2,u={},c={};u.y=s/t,u.x=l/t,c.y=(u.y-a.y)*(1-t),c.x=(u.x-a.x)*(1-t),o.x-=c.x,o.y-=c.y;var p={};p[k]=u.x+"px "+u.y+"px",p[z]=o.toString(),r(e.elements.preview,p)}function w(){function e(e,t){var n=m.elements.preview.getBoundingClientRect(),i=h.y+t,o=h.x+e;m.options.enforceBoundary?(p.top>n.top+t&&p.bottom<n.bottom+t&&(h.y=i),p.left>n.left+e&&p.right<n.right+e&&(h.x=o)):(h.y=i,h.x=o)}function t(e){function t(e){switch(e){case i:return[1,0];case o:return[0,1];case r:return[-1,0];case a:return[0,-1]}}var i=37,o=38,r=39,a=40;if(!e.shiftKey||e.keyCode!=o&&e.keyCode!=a){if(e.keyCode>=37&&e.keyCode<=40){e.preventDefault();var s=t(e.keyCode);h=T.parse(m.elements.preview),document.body.style[P]="none",p=m.elements.viewport.getBoundingClientRect(),n(s)}}else{var l=0;l=e.keyCode==o?parseFloat(m.elements.zoomer.value,10)+parseFloat(m.elements.zoomer.step,10):parseFloat(m.elements.zoomer.value,10)-parseFloat(m.elements.zoomer.step,10),m.setZoom(l)}}function n(t){var n=t[0],i=t[1],o={};e(n,i),o[z]=h.toString(),r(m.elements.preview,o),y.call(m),document.body.style[P]="",g.call(m),b.call(m),c=0}function i(e){if(e.preventDefault(),!f){if(f=!0,l=e.pageX,u=e.pageY,e.touches){var t=e.touches[0];l=t.pageX,u=t.pageY}h=T.parse(m.elements.preview),window.addEventListener("mousemove",a),window.addEventListener("touchmove",a),window.addEventListener("mouseup",s),window.addEventListener("touchend",s),document.body.style[P]="none",p=m.elements.viewport.getBoundingClientRect()}}function a(t){t.preventDefault();var n=t.pageX,i=t.pageY;if(t.touches){var a=t.touches[0];n=a.pageX,i=a.pageY}var s=n-l,p=i-u,f={};if("touchmove"==t.type&&t.touches.length>1){var v=t.touches[0],g=t.touches[1],w=Math.sqrt((v.pageX-g.pageX)*(v.pageX-g.pageX)+(v.pageY-g.pageY)*(v.pageY-g.pageY));c||(c=w/m._currentZoom);var b=w/c;return d.call(m,b),void o(m.elements.zoomer)}e(s,p),f[z]=h.toString(),r(m.elements.preview,f),y.call(m),u=i,l=n}function s(){f=!1,window.removeEventListener("mousemove",a),window.removeEventListener("touchmove",a),window.removeEventListener("mouseup",s),window.removeEventListener("touchend",s),document.body.style[P]="",g.call(m),b.call(m),c=0}var l,u,c,p,h,m=this,f=!1;m.elements.overlay.addEventListener("mousedown",i),m.elements.viewport.addEventListener("keydown",t),m.elements.overlay.addEventListener("touchstart",i)}function y(){var e=this,t=e.elements.boundary.getBoundingClientRect(),n=e.elements.preview.getBoundingClientRect();r(e.elements.overlay,{width:n.width+"px",height:n.height+"px",top:n.top-t.top+"px",left:n.left-t.left+"px"})}function b(){var e,t=this,n=t.get();if(x.call(t))if(t.options.update.call(t,n),t.$)t.$(t.element).trigger("update",n);else{var e;window.CustomEvent?e=new CustomEvent("update",{detail:n}):(e=document.createEvent("CustomEvent"),e.initCustomEvent("update",!0,!0,n)),t.element.dispatchEvent(e)}}function x(){return this.elements.preview.offsetHeight>0&&this.elements.preview.offsetWidth>0}function C(){var e,t,n,i,a,s=this,l=0,u=1.5,c=1,p={},h=s.elements.preview,m=s.elements.zoomer,f=new T(0,0,c),v=new D,w=x.call(s);if(w&&!s.data.bound){if(s.data.bound=!0,p[z]=f.toString(),p[k]=v.toString(),p.opacity=1,r(h,p),e=h.getBoundingClientRect(),t=s.elements.viewport.getBoundingClientRect(),n=s.elements.boundary.getBoundingClientRect(),s._originalImageWidth=e.width,s._originalImageHeight=e.height,s.options.enableZoom){s.options.enforceBoundary&&(i=t.width/e.width,a=t.height/e.height,l=Math.max(i,a)),l>=u&&(u=l+1),m.min=F(l,4),m.max=F(u,4);var b=Math.max(n.width/e.width,n.height/e.height);c=null!==s.data.boundZoom?s.data.boundZoom:b,d.call(s,c),o(m)}else s._currentZoom=c;f.scale=s._currentZoom,p[z]=f.toString(),r(h,p),s.data.points.length?E.call(s,s.data.points):_.call(s),g.call(s),y.call(s)}}function E(e){if(4!=e.length)throw"Croppie - Invalid number of points supplied: "+e;var t=this,n=e[2]-e[0],i=t.elements.viewport.getBoundingClientRect(),o=t.elements.boundary.getBoundingClientRect(),a={left:i.left-o.left,top:i.top-o.top},s=i.width/n,l=e[1],u=e[0],c=-1*e[1]+a.top,p=-1*e[0]+a.left,h={};h[k]=u+"px "+l+"px",h[z]=new T(p,c,s).toString(),r(t.elements.preview,h),d.call(t,s),t._currentZoom=s}function _(){var e=this,t=e.elements.preview.getBoundingClientRect(),n=e.elements.viewport.getBoundingClientRect(),i=e.elements.boundary.getBoundingClientRect(),o=n.left-i.left,a=n.top-i.top,s=o-(t.width-n.width)/2,l=a-(t.height-n.height)/2,u=new T(s,l,e._currentZoom);r(e.elements.preview,z,u.toString())}function R(e){var t=this,n=t.elements.canvas,i=t.elements.img,o=n.getContext("2d"),r=h.call(t),e=t.options.enableOrientation&&e;o.clearRect(0,0,n.width,n.height),n.width=i.width,n.height=i.height,r?u(i,function(t){c(n,i,parseInt(t)),e&&c(n,i,e)}):e&&c(n,i,e)}function I(e){var t=e.points,n=document.createElement("div"),i=document.createElement("img"),o=t[2]-t[0],s=t[3]-t[1];return a(n,"croppie-result"),n.appendChild(i),r(i,{left:-1*t[0]+"px",top:-1*t[1]+"px"}),i.src=e.url,r(n,{width:o+"px",height:s+"px"}),n}function Z(e,t){var n=t.points,i=n[0],o=n[1],r=n[2]-n[0],a=n[3]-n[1],s=t.circle,l=document.createElement("canvas"),u=l.getContext("2d"),c=r,p=a;return t.outputWidth&&t.outputHeight&&(c=t.outputWidth,p=t.outputHeight),l.width=c,l.height=p,t.backgroundColor&&(u.fillStyle=t.backgroundColor,u.fillRect(0,0,c,p)),u.drawImage(e,i,o,r,a,0,0,c,p),s&&(u.fillStyle="#fff",u.globalCompositeOperation="destination-in",u.beginPath(),u.arc(c/2,p/2,c/2,0,2*Math.PI,!0),u.closePath(),u.fill()),l.toDataURL(t.format,t.quality)}function B(e,t){var n,i=this,o=[],r=null;if("string"==typeof e)n=e,e={};else if(Array.isArray(e))o=e.slice();else{if("undefined"==typeof e&&i.data.url)return C.call(i),b.call(i),null;n=e.url,o=e.points||[],r="undefined"==typeof e.zoom?null:e.zoom}i.data.bound=!1,i.data.url=n||i.data.url,i.data.points=(o||i.data.points).map(function(e){return parseFloat(e)}),i.data.boundZoom=r;var a=l(n,i.elements.img);return a.then(function(){i.options.useCanvas&&(i.elements.img.exifdata=null,R.call(i,e.orientation||1)),C.call(i),b.call(i),t&&t()}),a}function F(e,t){return parseFloat(e).toFixed(t||0)}function L(){var e=this,t=e.elements.preview.getBoundingClientRect(),n=e.elements.viewport.getBoundingClientRect(),i=n.left-t.left,o=n.top-t.top,r=(n.width-e.elements.viewport.offsetWidth)/2,a=(n.height-e.elements.viewport.offsetHeight)/2,s=i+e.elements.viewport.offsetWidth+r,l=o+e.elements.viewport.offsetHeight+a,u=e._currentZoom;(u===1/0||isNaN(u))&&(u=1);var c=e.options.enforceBoundary?0:Number.NEGATIVE_INFINITY;return i=Math.max(c,i/u),o=Math.max(c,o/u),s=Math.max(c,s/u),l=Math.max(c,l/u),{points:[F(i),F(o),F(s),F(l)],zoom:u}}function X(e){var t,i=this,o=L.call(i),r=n(q,n({},e)),a="string"==typeof e?e:r.type||"viewport",s=r.size,l=r.format,u=r.quality,c=r.backgroundColor,p="boolean"==typeof r.circle?r.circle:"circle"===i.options.viewport.type,h=i.elements.viewport.getBoundingClientRect(),d=h.width/h.height;return"viewport"===s?(o.outputWidth=h.width,o.outputHeight=h.height):"object"==typeof s&&(s.width&&s.height?(o.outputWidth=s.width,o.outputHeight=s.height):s.width?(o.outputWidth=s.width,o.outputHeight=s.width/d):s.height&&(o.outputWidth=s.height*d,o.outputHeight=s.height)),$.indexOf(l)>-1&&(o.format="image/"+l,o.quality=u),o.circle=p,o.url=i.data.url,o.backgroundColor=c,t=new Promise(function(e,t){e("canvas"===a?Z.call(i,i.elements.preview,o):I.call(i,o))})}function M(){C.call(this)}function Y(e){if(!this.options.useCanvas)throw"Croppie: Cannot rotate without enableOrientation";var t=this,n=t.elements.canvas,i=(t.elements.img,document.createElement("canvas")),o=1;i.width=n.width,i.height=n.height;var r=i.getContext("2d");r.drawImage(n,0,0),(90===e||-270===e)&&(o=6),(-90===e||270===e)&&(o=8),(180===e||-180===e)&&(o=3),c(n,i,o),f.call(t)}function S(){var e=this;e.element.removeChild(e.elements.boundary),s(e.element,"croppie-container"),e.options.enableZoom&&e.element.removeChild(e.elements.zoomerWrap),delete e.elements}function j(e,t){if(this.element=e,this.options=n(n({},j.defaults),t),p.call(this),this.options.url){var i={url:this.options.url,points:this.options.points};delete this.options.url,delete this.options.points,B.call(this,i)}}"function"!=typeof Promise&&!function(e){function t(e,t){return function(){e.apply(t,arguments)}}function n(e){if("object"!=typeof this)throw new TypeError("Promises must be constructed via new");if("function"!=typeof e)throw new TypeError("not a function");this._state=null,this._value=null,this._deferreds=[],l(e,t(o,this),t(r,this))}function i(e){var t=this;return null===this._state?void this._deferreds.push(e):void c(function(){var n=t._state?e.onFulfilled:e.onRejected;if(null===n)return void(t._state?e.resolve:e.reject)(t._value);var i;try{i=n(t._value)}catch(o){return void e.reject(o)}e.resolve(i)})}function o(e){try{if(e===this)throw new TypeError("A promise cannot be resolved with itself.");if(e&&("object"==typeof e||"function"==typeof e)){var n=e.then;if("function"==typeof n)return void l(t(n,e),t(o,this),t(r,this))}this._state=!0,this._value=e,a.call(this)}catch(i){r.call(this,i)}}function r(e){this._state=!1,this._value=e,a.call(this)}function a(){for(var e=0,t=this._deferreds.length;t>e;e++)i.call(this,this._deferreds[e]);this._deferreds=null}function s(e,t,n,i){this.onFulfilled="function"==typeof e?e:null,this.onRejected="function"==typeof t?t:null,this.resolve=n,this.reject=i}function l(e,t,n){var i=!1;try{e(function(e){i||(i=!0,t(e))},function(e){i||(i=!0,n(e))})}catch(o){if(i)return;i=!0,n(o)}}var u=setTimeout,c="function"==typeof setImmediate&&setImmediate||function(e){u(e,1)},p=Array.isArray||function(e){return"[object Array]"===Object.prototype.toString.call(e)};n.prototype["catch"]=function(e){return this.then(null,e)},n.prototype.then=function(e,t){var o=this;return new n(function(n,r){i.call(o,new s(e,t,n,r))})},n.all=function(){var e=Array.prototype.slice.call(1===arguments.length&&p(arguments[0])?arguments[0]:arguments);return new n(function(t,n){function i(r,a){try{if(a&&("object"==typeof a||"function"==typeof a)){var s=a.then;if("function"==typeof s)return void s.call(a,function(e){i(r,e)},n)}e[r]=a,0===--o&&t(e)}catch(l){n(l)}}if(0===e.length)return t([]);for(var o=e.length,r=0;r<e.length;r++)i(r,e[r])})},n.resolve=function(e){return e&&"object"==typeof e&&e.constructor===n?e:new n(function(t){t(e)})},n.reject=function(e){return new n(function(t,n){n(e)})},n.race=function(e){return new n(function(t,n){for(var i=0,o=e.length;o>i;i++)e[i].then(t,n)})},n._setImmediateFn=function(e){c=e},"undefined"!=typeof module&&module.exports?module.exports=n:e.Promise||(e.Promise=n)}(this),"function"!=typeof window.CustomEvent&&!function(){function e(e,t){t=t||{bubbles:!1,cancelable:!1,detail:void 0};var n=document.createEvent("CustomEvent");return n.initCustomEvent(e,t.bubbles,t.cancelable,t.detail),n}e.prototype=window.Event.prototype,window.CustomEvent=e}();var k,z,P,W=["Webkit","Moz","ms"],O=document.createElement("div").style;z=t("transform"),k=t("transformOrigin"),P=t("userSelect");var A="translate3d",H=", 0px",T=function(e,t,n){this.x=parseFloat(e),this.y=parseFloat(t),this.scale=parseFloat(n)};T.parse=function(e){return e.style?T.parse(e.style[z]):e.indexOf("matrix")>-1||e.indexOf("none")>-1?T.fromMatrix(e):T.fromString(e)},T.fromMatrix=function(e){var t=e.substring(7).split(",");return t.length&&"none"!==e||(t=[1,0,0,1,0,0]),new T(parseInt(t[4],10),parseInt(t[5],10),parseFloat(t[0]))},T.fromString=function(e){var t=e.split(") "),n=t[0].substring(A.length+1).split(","),i=t.length>1?t[1].substring(6):1,o=n.length>1?n[0]:0,r=n.length>1?n[1]:0;return new T(o,r,i)},T.prototype.toString=function(){return A+"("+this.x+"px, "+this.y+"px"+H+") scale("+this.scale+")"};var D=function(e){if(!e||!e.style[k])return this.x=0,void(this.y=0);var t=e.style[k].split(" ");this.x=parseFloat(t[0]),this.y=parseFloat(t[1])};D.prototype.toString=function(){return this.x+"px "+this.y+"px"};var N=i(y,500),q={type:"canvas",format:"png",quality:1},$=["jpeg","webp","png"];if(window.jQuery){var Q=window.jQuery;Q.fn.croppie=function(e){var t=typeof e;if("string"===t){var n=Array.prototype.slice.call(arguments,1),i=Q(this).data("croppie");return"get"===e?i.get():"result"===e?i.result.apply(i,n):"bind"===e?i.bind.apply(i,n):this.each(function(){var t=Q(this).data("croppie");if(t){var i=t[e];if(!Q.isFunction(i))throw"Croppie "+e+" method not found";i.apply(t,n),"destroy"===e&&Q(this).removeData("croppie")}})}return this.each(function(){var t=new j(this,e);t.$=Q,Q(this).data("croppie",t)})}}j.defaults={viewport:{width:100,height:100,type:"square"},boundary:{width:300,height:300},orientationControls:{enabled:!0,leftClass:"",rightClass:""},customClass:"",showZoomer:!0,enableZoom:!0,mouseWheelZoom:!0,enableExif:!1,enforceBoundary:!0,enableOrientation:!1,update:function(){}},n(j.prototype,{bind:function(e,t){return B.call(this,e,t)},get:function(){return L.call(this)},result:function(e){return X.call(this,e)},refresh:function(){return M.call(this)},setZoom:function(e){d.call(this,e),o(this.elements.zoomer)},rotate:function(e){Y.call(this,e)},destroy:function(){return S.call(this)}}),e.Croppie=window.Croppie=j,"object"==typeof module&&module.exports&&(module.exports=j)});