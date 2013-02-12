(function(e){var t={defaults:{animation:"horizontal-push",animationSpeed:600,timer:true,advanceSpeed:4e3,pauseOnHover:false,startClockOnMouseOut:false,startClockOnMouseOutAfter:1e3,directionalNav:true,captions:true,captionAnimation:"fade",captionAnimationSpeed:600,captionHover:false,bullets:false,bulletThumbs:false,bulletThumbLocation:"",afterSlideChange:e.noop,centerBullets:true,navOpacity:.2,sideThumbs:false,preloader:5,thumbWidth:80,respExtra:0,alwaysPlayBtn:false},activeSlide:0,numberSlides:0,orbitWidth:null,orbitHeight:null,locked:null,timerRunning:null,degrees:0,wrapperHTML:'<div class="satl-wrapper" />',wrapThumbHTML:'<div class="thumbholder" />',timerHTML:'<div class="timer"><span class="mask"><span class="rotator"></span></span><span class="pause"></span></div>',captionHTML:'<div class="orbit-caption"></div>',directionalNavHTML:'<div class="satl-nav"><span class="right">Right</span><span class="left">Left</span></div>',directionalThumbHTML:'<span id="slideleft">Left</span><span id="slideright">Right</span>',bulletHTML:'<ul class="orbit-bullets"></ul>',thumbHTML:'<ul class="orbit-thumbnails"></ul>',init:function(t,n){var r,i=0,s=this;this.clickTimer=e.proxy(this.clickTimer,this);this.addBullet=e.proxy(this.addBullet,this);this.resetAndUnlock=e.proxy(this.resetAndUnlock,this);this.stopClock=e.proxy(this.stopClock,this);this.startTimerAfterMouseLeave=e.proxy(this.startTimerAfterMouseLeave,this);this.clearCaptionAfterMouseLeave=e.proxy(this.clearCaptionAfterMouseLeave,this);this.setCaptionAfterMouseHover=e.proxy(this.setCaptionAfterMouseHover,this);this.clearClockMouseLeaveTimer=e.proxy(this.clearClockMouseLeaveTimer,this);this.rotateTimer=e.proxy(this.rotateTimer,this);this.options=e.extend({},this.defaults,n);if(this.options.timer==="false")this.options.timer=false;if(this.options.captions==="false")this.options.captions=false;if(this.options.directionalNav==="false")this.options.directionalNav=false;this.$element=e(t);this.$wrapper=this.$element.wrap(this.wrapperHTML).parent();this.$slides=this.$element.children("img, a, div");var o=new Array;var u=new Array;this.$slides.each(function(){o.push(e(this).find("img").attr("src"))});if(o.length===0){s.loaded()}else{if(this.options.bulletThumbs&&this.options.bullets){this.$slides.each(function(){u.push(e(this).attr("data-thumb"));if(u.length==20){return false}})}var a=this.options.preloader+u.length;u.push.apply(u,o);s.preload(u,a,true)}},loaded:function(){this.$element.addClass("orbit").css("background","none");this.setDimensionsFromLargestSlide(this.options.bullets,this.options.thumbWidth);this.updateOptionsIfOnlyOneSlide();this.setupFirstSlide();this.setupClicks();if(this.options.timer){this.setupTimer();this.startClock()}else if(this.options.alwaysPlayBtn){this.setupTimer();this.stopClock()}if(this.options.captions){this.setupCaptions()}if(this.options.directionalNav){this.setupDirectionalNav()}if(this.options.bullets){this.setupBulletNav();this.setActiveBullet()}if(this.options.bulletThumbs&&this.options.bullets){this.setupDirectionalThumb(this.options.thumbWidth)}this.$slides.css("opacity",0)},currentSlide:function(){return this.$slides.eq(this.activeSlide)},setSideThumbSize:function(e,t){var n=this;if(!e){e=n.$element.width()}if(!t){t=n.$wrapper.parent().parent().width()}var r=t-e;if(r<this.options.thumbWidth){n.$wrapper.find(".thumbholder").css("width",this.options.thumbWidth+10);n.$wrapper.find(".thumbholder").css("margin-left",e);return this.options.thumbWidth}else if(r<n.options.respExtra){n.$wrapper.find(".thumbholder").css("width",r+10);n.$wrapper.find(".thumbholder").css("margin-left",e);this.$element.css("margin-left",r);this.setLeftMargin(r);return r}return n.options.respExtra},setDimensionsFromLargestSlide:function(t,n){var r=this;var i=0;var s=0;this.$slides.each(function(){var t=e(this),n=t.width(),o=t.height();if(n>i){r.$element.add(r.$wrapper).width(n);r.$element.add(r.$wrapper).css("max-width",n);r.orbitWidth=r.$element.width();i=r.orbitWidth}if(o>s){r.$element.add(r.$wrapper).height(o);r.orbitHeight=r.$element.height();s=r.orbitHeight}r.numberSlides+=1});this.beResponsive(i,s)},beResponsive:function(e,t){var n=this;var r=1;var i=n.options.respExtra;var s=n.$wrapper.parent().parent().width();var o=parseInt(n.$wrapper.css("max-width"));var u=false;if(this.options.sideThumbs){i=this.setSideThumbSize(e,s)}if(e>=s||s<=o){i=0}if(e+i>s||e<o&&s<o){if(this.options.sideThumbs){u=s-(n.options.thumbWidth+5)}else if(!i){u=s}if(!n.$wrapper.parent().hasClass("shrunk")){n.$wrapper.parent().addClass("shrunk");n.$wrapper.parent().parent().parent().addClass("shrunk")}}else if(e<=o&&e+i<s){u=o;if(n.$wrapper.parent().hasClass("shrunk")){n.$wrapper.parent().removeClass("shrunk");n.$wrapper.parent().parent().parent().removeClass("shrunk")}}if(u){r=u/e;n.$element.add(n.$wrapper).width(u);n.$element.add(n.$wrapper).height(t*r);n.$wrapper.find(".thumbholder").css("padding-top",t*r+"px")}},lock:function(){this.locked=true},unlock:function(){this.locked=false},updateOptionsIfOnlyOneSlide:function(){if(this.$slides.length===1){this.options.directionalNav=false;this.options.timer=false;this.options.bullets=false}},setupFirstSlide:function(){var e=this;this.$slides.first().css({"z-index":3}).fadeIn(function(){e.$slides.css({display:"block"})})},setupClicks:function(){var e=this;var t=this.currentSlide();t.click(function(){e.stopClock()})},handleResize:function(t,n){this.options=e.extend({},this.defaults,n);this.$element=e(t);this.$wrapper=this.$element.parent();if(this.$element.hasClass("processing"))return;this.$element.addClass("processing");var r=parseInt(this.$wrapper.css("width"));var i=parseInt(this.$wrapper.css("height"));this.beResponsive(r,i);this.$element.removeClass("processing")},startClock:function(){var e=this;if(this.$timer.is(":hidden")){this.clock=setInterval(function(){e.shift("next")},this.options.advanceSpeed)}else{this.timerRunning=true;this.$pause.removeClass("active");this.clock=setInterval(this.rotateTimer,this.options.advanceSpeed/180)}},rotateTimer:function(){var e="rotate("+this.degrees+"deg)";this.degrees+=2;this.$rotator.css({"-webkit-transform":e,"-moz-transform":e,"-o-transform":e});if(this.degrees>180){this.$rotator.addClass("move");this.$mask.addClass("move")}if(this.degrees>360){this.$rotator.removeClass("move");this.$mask.removeClass("move");this.degrees=0;this.shift("next")}},stopClock:function(){this.timerRunning=false;clearInterval(this.clock);if(this.$pause)this.$pause.addClass("active")},setupTimer:function(){this.$timer=e(this.timerHTML);this.$wrapper.append(this.$timer);this.$rotator=this.$timer.find(".rotator");this.$mask=this.$timer.find(".mask");this.$pause=this.$timer.find(".pause");this.$timer.click(this.clickTimer);if(this.options.startClockOnMouseOut){this.$wrapper.mouseleave(this.startTimerAfterMouseLeave);this.$wrapper.mouseenter(this.clearClockMouseLeaveTimer)}if(this.options.pauseOnHover){this.$wrapper.mouseenter(this.stopClock)}},startTimerAfterMouseLeave:function(){var e=this;this.outTimer=setTimeout(function(){if(!e.timerRunning){e.startClock()}},this.options.startClockOnMouseOutAfter)},clearClockMouseLeaveTimer:function(){clearTimeout(this.outTimer)},clickTimer:function(){if(!this.timerRunning){this.startClock()}else{this.stopClock()}},setupCaptions:function(){this.$caption=e(this.captionHTML);this.$wrapper.append(this.$caption);this.setCaption(true)},clearCaptionAfterMouseLeave:function(){jQuery(this.$caption).fadeOut(this.options.captionAnimationSpeed)},setCaptionAfterMouseHover:function(){jQuery(this.$caption).fadeIn(this.options.captionAnimationSpeed)},setCaption:function(t){var n=this.currentSlide().attr("data-caption"),r;if(!this.options.captions){return false}if(n&&t){r=e(n).html();this.$caption.attr("id",n).html(r);captionClass=e(n).attr("class");this.$caption.attr("class",captionClass);$hovering=this.$wrapper.is(":hover");if(this.options.captionHover){this.$wrapper.mouseleave(this.clearCaptionAfterMouseLeave);this.$wrapper.mouseenter(this.setCaptionAfterMouseHover);if(!$hovering){return}}switch(this.options.captionAnimation){case"none":this.$caption.show();break;case"fade":this.$caption.fadeIn(this.options.captionAnimationSpeed);break;case"slideOpen":this.$caption.slideDown(this.options.captionAnimationSpeed);break}}else{switch(this.options.captionAnimation){case"none":this.$caption.hide().remove();break;case"fade":this.$caption.fadeOut(this.options.captionAnimationSpeed,function(){e(this).remove()});break;case"slideOpen":this.$caption.slideUp(this.options.captionAnimationSpeed,function(){e(this).remove()});break}}},setupDirectionalNav:function(){var e=this;this.$wrapper.append(this.directionalNavHTML);if(this.options.captionHover){this.$wrapper.find(".left").css("display","none");this.$wrapper.find(".right").css("display","none");this.$wrapper.hover(function(){e.$wrapper.find(".left").css({opacity:e.options.navOpacity,display:"block"});e.$wrapper.find(".right").css({opacity:e.options.navOpacity,display:"block"})},function(){e.$wrapper.find(".left").css("display","none");e.$wrapper.find(".right").css("display","none")})}else{this.$wrapper.find(".left").css("opacity",e.options.navOpacity);this.$wrapper.find(".right").css("opacity",e.options.navOpacity)}if(this.options.sideThumbs){this.setLeftMargin(e.$wrapper.find(".thumbholder").width())}e.$wrapper.find(".left").hover(function(){jQuery(".satl-nav .left").fadeTo("fast",.75)},function(){jQuery(".satl-nav .left").fadeTo("fast",e.options.navOpacity)});e.$wrapper.find(".right").hover(function(){jQuery(".satl-nav .right").fadeTo("fast",.75)},function(){jQuery(".satl-nav .right").fadeTo("fast",e.options.navOpacity)});this.$wrapper.find(".left").click(function(){e.stopClock();e.shift("prev")});this.$wrapper.find(".right").click(function(){e.stopClock();e.shift("next")})},setLeftMargin:function(e){var t=this;var n=parseInt(t.$wrapper.find(".left").css("left"))+t.$element.width();t.$wrapper.find(".left").css("left",e);t.$wrapper.find(".right").css("left",n-t.$wrapper.find(".right").width());this.$wrapper.find(".orbit-caption").css("left",e);t.$wrapper.find(".timer").css("left",n-t.$wrapper.find(".timer").width())},setupDirectionalThumb:function(e){var t=this;var n=e*3;this.$wrapper.append(this.directionalThumbHTML);this.$wrapper.find("#slideleft").click(function(){t.$wrapper.find(".thumbholder").animate({scrollLeft:"-="+n},"slow")});this.$wrapper.find("#slideright").click(function(){t.$wrapper.find(".thumbholder").animate({scrollLeft:"+="+n},"slow")})},setupBulletNav:function(){if(this.options.bulletThumbs){this.$bullets=e(this.thumbHTML);if(!this.options.sideThumbs){this.$thumbwidth=this.$slides.length*this.options.thumbWidth;this.$bullets.css("width",this.$thumbwidth)}else{this.$bullets.css("min-width",this.options.thumbWidth)}this.$wrapper.append(this.$bullets);this.$bullets.wrap(this.wrapThumbHTML);this.$wrapper.find(".thumbholder").css("padding-top",this.$wrapper.height()+"px");if(this.options.sideThumbs){this.setSideThumbSize(null,null);this.$wrapper.find(".thumbholder").hover(function(){e("body").css({height:e(window).height()-1+"px",overflow:"hidden"});e("html").css("overflow-y","scroll")},function(){jQuery("body").css("overflow","visible");e("html").css("overflow-y","auto")})}}else{this.$bullets=e(this.bulletHTML);this.$wrapper.append(this.$bullets)}this.$slides.each(this.addBullet);if(this.options.centerBullets&&this.options.bulletThumbs==false){$bwidth=this.$bullets.width();this.$bullets.css("margin-left",-$bwidth/2);this.$bullets.css("margin-right",$bwidth/2)}},addBullet:function(t,n){var r=e("<li></li>"),i,s=this;if(this.options.bulletThumbs){i=e(n).attr("data-thumb");if(i){r.append("<img class='orbit-thumb' src='"+this.options.bulletThumbLocation+i+"' />")}}this.$bullets.append(r);r.data("index",t);r.click(function(){s.stopClock();s.shift(r.data("index"))})},setActiveBullet:function(){if(!this.options.bullets){return false}else{this.$bullets.find("li").removeClass("active").eq(this.activeSlide).addClass("active")}},resetAndUnlock:function(){this.$slides.eq(this.prevActiveSlide).css({"z-index":1}).animate({opacity:0},this.options.animationSpeed);this.unlock();this.setupClicks();this.setupCaptions();this.options.afterSlideChange.call(this,this.$slides.eq(this.prevActiveSlide),this.$slides.eq(this.activeSlide))},preload:function(t,n,r){var i=this;var s=[],o,u,a=0;if(typeof t!="undefined"){if(e.isArray(t)){u=t.length;if(u>n)u=n;for(o=0;o<u;o++){s[o]=new Image;s[o].onload=function(){a++;if(a==u&&r){i.loaded()}};s[o].src=t[o]}}else{s[0]=new Image;s[0].src=t;i.loaded()}}},shift:function(e){var t=e;this.prevActiveSlide=this.activeSlide;if(this.prevActiveSlide==t){return false}if(this.$slides.length=="1"){return false}if(!this.locked){this.lock();if(e=="next"){this.activeSlide++;if(this.activeSlide==this.numberSlides){this.activeSlide=0}}else if(e=="prev"){this.activeSlide--;if(this.activeSlide<0){this.activeSlide=this.numberSlides-1}}else{this.activeSlide=e;if(this.prevActiveSlide<this.activeSlide){t="next"}else if(this.prevActiveSlide>this.activeSlide){t="prev"}}this.setActiveBullet();this.$slides.eq(this.prevActiveSlide).css({"z-index":2});if(this.options.animation=="none"){this.$slides.eq(this.prevActiveSlide).animate({opacity:0},3);this.$slides.eq(this.activeSlide).animate({opacity:1},3,this.resetAndUnlock)}if(this.options.animation=="fade-empty"){this.$slides.eq(this.prevActiveSlide).animate({opacity:0},this.options.animationSpeed);this.$slides.eq(this.activeSlide).css({opacity:0,"z-index":3}).delay("500").animate({opacity:1},this.options.animationSpeed,this.resetAndUnlock)}else if(this.options.animation=="fade-blend"){this.$slides.eq(this.activeSlide).css({opacity:0,"z-index":3}).animate({opacity:1},this.options.animationSpeed,this.resetAndUnlock)}else if(this.options.animation=="pullout"){this.$slides.eq(this.activeSlide).transition({opacity:.4,scale:1.6,rotate:"-5deg"})}else if(this.options.animation=="horizontal-slide"){if(t=="next"){this.$slides.eq(this.activeSlide).css({opacity:1,left:this.orbitWidth,"z-index":3}).animate({left:0},this.options.animationSpeed,this.resetAndUnlock)}if(t=="prev"){this.$slides.eq(this.activeSlide).css({opacity:1,left:-this.orbitWidth,"z-index":3}).animate({left:0},this.options.animationSpeed,this.resetAndUnlock)}}else if(this.options.animation=="vertical-slide"){if(t=="prev"){this.$slides.eq(this.activeSlide).css({top:this.orbitHeight,"z-index":3,opacity:1}).animate({top:0},this.options.animationSpeed,this.resetAndUnlock)}if(t=="next"){this.$slides.eq(this.activeSlide).css({top:-this.orbitHeight,"z-index":3,opacity:1}).animate({top:0},this.options.animationSpeed,this.resetAndUnlock)}}else if(this.options.animation=="horizontal-push"){if(t=="next"){this.$slides.eq(this.activeSlide).css({left:this.orbitWidth,"z-index":3,opacity:1}).animate({left:0},this.options.animationSpeed,this.resetAndUnlock);this.$slides.eq(this.prevActiveSlide).animate({left:-this.orbitWidth*2},this.options.animationSpeed)}if(t=="prev"){this.$slides.eq(this.activeSlide).css({left:-this.orbitWidth*4,"z-index":3,opacity:1}).animate({left:0},this.options.animationSpeed,this.resetAndUnlock);this.$slides.eq(this.prevActiveSlide).animate({left:this.orbitWidth},this.options.animationSpeed)}}else if(this.options.animation=="vertical-push"){if(t=="next"){this.$slides.eq(this.activeSlide).css({top:-this.orbitHeight,"z-index":3,opacity:1}).animate({top:0},this.options.animationSpeed,this.resetAndUnlock);this.$slides.eq(this.prevActiveSlide).animate({top:this.orbitHeight},this.options.animationSpeed)}if(t=="prev"){this.$slides.eq(this.activeSlide).css({top:this.orbitHeight,"z-index":3,opacity:1}).animate({top:0},this.options.animationSpeed,this.resetAndUnlock);this.$slides.eq(this.prevActiveSlide).animate({top:-this.orbitHeight},this.options.animationSpeed)}}this.setCaption()}}};e.fn.wait=function(e){jQuery(this).animate({opacity:"+=0"},e);return this};e.fn.satlorbit=function(n){return this.each(function(){var r=e.extend({},t);r.init(this,n)})};e.fn.satlresponse=function(n){return this.each(function(){var r=e.extend({},t);r.handleResize(this,n)})}})(jQuery)