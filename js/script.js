/* 
Author: Sean Ockert
*/

/* Normalized hide address bar for iOS & Android (c) Scott Jehl, scottjehl.com MIT License */
(function(a){var b=a.document;if(!location.hash&&a.addEventListener){window.scrollTo(0,1);var c=1,d=function(){return a.pageYOffset||b.compatMode==="CSS1Compat"&&b.documentElement.scrollTop||b.body.scrollTop||0},e=setInterval(function(){if(b.body){clearInterval(e);c=d();a.scrollTo(0,c===1?0:1)}},15);a.addEventListener("load",function(){setTimeout(function(){if(d()<20){a.scrollTo(0,c===1?0:1)}},0)})}})(this);


$(document).ready(function() {


	$('article.post').one('mouseenter', function() {
		Socialite.load($(this)[0]);
	});


	//For adding images to types of links
	$("a[href$=pdf]").addClass("pdf");
	$("a[href$=zip]").addClass("zip");
	
	
	$(".collapse").collapse();
	
	// Fancybox modal/lightbox plugin
	$("a.fancybox, ul.gallery li a").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'titlePosition'	:	'over'
	});	


	//var index = 0;
	// Homepage Crossfader
	var options = {
		'slideType':'slidehorizontal',
		'fadeInOut':true,
		'transitionTime':400,
		'showTime':5000,
		'index':0,
		'slideDirection':'right',
		slideChange : function (currentSlideIndex) { 
			$('.slide-nav li a').removeClass('selected');
			index = '.slide-nav li a[rel="'+currentSlideIndex+'"]';
			$(index).addClass('selected');
		} 		
	}; 
	$('.crossfade .item').dumbCrossFade(options);

	
	$('.prev').click(function()  {
		$('.crossfade .item').dumbCrossFade('previous') 
		return false;
	});	
	
	$('.next').click(function() {
		$('.crossfade .item').dumbCrossFade('next');
		return false;
	});	

	$('.slide-nav li a').click(function(e) {	
		e.preventDefault();
		index = $(this).attr('rel');
		$('.crossfade .item').dumbCrossFade('jump',index,function() {
			$('.slide-nav a').removeClass('selected');
			$(this).addClass('selected');		
		});

		return false;
	});				
	
});



// For toggling input boxes
jQuery.fn.toggleVal=function(focusClass){this.each(function(){$(this).focus(function()
{if($(this).val()==this.defaultValue){$(this).val("")}if(focusClass)
{$(this).addClass(focusClass)}}).blur(function(){if($(this).val()=="")
{$(this).val(this.defaultValue)}if(focusClass){$(this).removeClass(focusClass)}})})}


















