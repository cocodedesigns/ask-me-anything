/*!
	Autosize 1.18.15
	license: MIT
	http://www.jacklmoore.com/autosize
*/
!function(e){var t,o={className:"autosizejs",id:"autosizejs",append:"\n",callback:!1,resizeDelay:10,placeholder:!0},i='<textarea tabindex="-1" style="position:absolute; top:-999px; left:0; right:auto; bottom:auto; border:0; padding: 0; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden; transition:none; -webkit-transition:none; -moz-transition:none;"/>',n=["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent","whiteSpace"],a=e(i).data("autosize",!0)[0];a.style.lineHeight="99px","99px"===e(a).css("lineHeight")&&n.push("lineHeight"),a.style.lineHeight="",e.fn.autosize=function(i){return this.length?(i=e.extend({},o,i||{}),a.parentNode!==document.body&&e(document.body).append(a),this.each(function(){function o(){var t,o=window.getComputedStyle?window.getComputedStyle(u,null):!1;o?(t=u.getBoundingClientRect().width,(0===t||"number"!=typeof t)&&(t=parseFloat(o.width)),e.each(["paddingLeft","paddingRight","borderLeftWidth","borderRightWidth"],function(e,i){t-=parseFloat(o[i])})):t=p.width(),a.style.width=Math.max(t,0)+"px"}function s(){var s={};if(t=u,a.className=i.className,a.id=i.id,d=parseFloat(p.css("maxHeight")),e.each(n,function(e,t){s[t]=p.css(t)}),e(a).css(s).attr("wrap",p.attr("wrap")),o(),window.chrome){var r=u.style.width;u.style.width="0px";{u.offsetWidth}u.style.width=r}}function r(){var e,n;t!==u?s():o(),a.value=!u.value&&i.placeholder?p.attr("placeholder")||"":u.value,a.value+=i.append||"",a.style.overflowY=u.style.overflowY,n=parseFloat(u.style.height),a.scrollTop=0,a.scrollTop=9e4,e=a.scrollTop,d&&e>d?(u.style.overflowY="scroll",e=d):(u.style.overflowY="hidden",c>e&&(e=c)),e+=w,n!==e&&(u.style.height=e+"px",a.className=a.className,f&&i.callback.call(u,u),p.trigger("autosize.resized"))}function l(){clearTimeout(h),h=setTimeout(function(){var e=p.width();e!==g&&(g=e,r())},parseInt(i.resizeDelay,10))}var d,c,h,u=this,p=e(u),w=0,f=e.isFunction(i.callback),z={height:u.style.height,overflow:u.style.overflow,overflowY:u.style.overflowY,wordWrap:u.style.wordWrap,resize:u.style.resize},g=p.width(),y=p.css("resize");p.data("autosize")||(p.data("autosize",!0),("border-box"===p.css("box-sizing")||"border-box"===p.css("-moz-box-sizing")||"border-box"===p.css("-webkit-box-sizing"))&&(w=p.outerHeight()-p.height()),c=Math.max(parseFloat(p.css("minHeight"))-w||0,p.height()),p.css({overflow:"hidden",overflowY:"hidden",wordWrap:"break-word"}),"vertical"===y?p.css("resize","none"):"both"===y&&p.css("resize","horizontal"),"onpropertychange"in u?"oninput"in u?p.on("input.autosize keyup.autosize",r):p.on("propertychange.autosize",function(){"value"===event.propertyName&&r()}):p.on("input.autosize",r),i.resizeDelay!==!1&&e(window).on("resize.autosize",l),p.on("autosize.resize",r),p.on("autosize.resizeIncludeStyle",function(){t=null,r()}),p.on("autosize.destroy",function(){t=null,clearTimeout(h),e(window).off("resize",l),p.off("autosize").off(".autosize").css(z).removeData("autosize")}),r())})):this}}(jQuery||$);



var ask_me_anything = (function($){
	//Fire validation on each form
	function validateActiveForm(form_id){
		$('.ama_modal_window[data-id="' + form_id + '"] form').validate({
			//Handle submissions.
			submitHandler: function(form) {
				var orig_submit_value = $(form).find('input[type="submit"]').val();
				$(form).find('input[type="submit"]').val('One Moment...');
				
				var url_base = window.location.origin + window.location.pathname;
				$.post(url_base + 'wp-admin/admin-ajax.php', {action:'submitClientForm', payload: $(form).serialize()}, function(data) {
	                    if (data) {
	                    	if (!data.redirect) {
	                    		//No redirect
	                    		closeModal();
	                    	} else if(data.redirect.indexOf(window.location.host) === -1) {
	                    		//External URL
	                  			window.location.href = data.redirect;
	                    	} else {
	                    		//POST
	                    		window.location.href = data.redirect;
	                    	}
	                    } else {
	                    	alert('Sorry but there was an error while sending your form. Please contact the site administrator.');
	                    }
	                    $(form).find('input[type="submit"]').val(orig_submit_value);
	                    form.reset();
	                });
				return false;
			}
		});
	}
	

	$('.ama_modal_window textarea').autosize();

	//Add phone validation method if required
	jQuery.validator.addMethod('valid_phone', function(phone_number, element) {
	    phone_number = phone_number.replace(/\s+/g, ''); 
	    return this.optional(element) || phone_number.length > 9 &&
	        phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
	}, 'Please enter a valid phone number.');

	//Center the absolutely positioned Modal window within the viewport. Has to fire each time the viewport changes size or orientation
	$(window).on('load resize orientationChanged', function() {
		var active_modal = $('.ama_modal_window:visible');
		$(active_modal).css({
			'left': '50%',
			'marginLeft': '-' + $(active_modal).width() / 2 + 'px' 
		});
	});

	function openModal(modal_id){
		$('#ama_page_overlay').fadeIn('fast', function(){
			var this_modal = $('.ama_modal_window[data-id="' + modal_id + '"]');
			
			$(this_modal).css({
				'left': '50%',
				'marginLeft': '-' + $(this_modal).width() / 2 + 'px',
				'position': ($(this_modal).css('position') !== 'fixed' ? $(this_modal).css('marginTop', window.pageYOffset + 50) : 'block') 
			});

			$(this_modal).css({
				'left': '50%',
				'marginLeft': '-' + $(this_modal).width() / 2 + 'px' 
			});

			$(this_modal).fadeIn(function(){
				validateActiveForm(modal_id);
			});
		});
	}

	function closeModal(){
		$('.ama_modal_window, #ama_page_overlay').fadeOut('fast');
	}

	//Open the modal window when trigger is fired	
	$('.ama_trigger').click(function(){
		openModal($(this).data('modal-target'));
	});

	//Close the modal window when trigger is fired
	$('.close_ama_modal').click(function(){
		closeModal();
	});

	//Close modal on escape key
	$(document).keyup(function(e) {
		if (e.keyCode == 27) { 
			closeModal(); 
		}
	});
})(jQuery);