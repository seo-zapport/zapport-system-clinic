<footer id="zp-footer" class="py-5 bg-dark">
	<div class="footer-socket">
		<div class="container">
			<p class="m-0 text-center text-white">Copyright © Zapport Web Developer Team 2019</p>
		</div>
	</div>
</footer>

<script src="{{ asset('/js/app.js') }}"></script>
<script src="{{ asset('/js/slick.js') }}"></script>
<script src="{{ asset('/js/jquery.easing.min.js') }}"></script>

<script type="application/javascript">
	jQuery(document).ready(function($) {
		/** remove hashtag parameter */
		
		window.history.replaceState('', '/', window.location.pathname) 
		
		/**slick*/
		{{--  $('.slick-posts').slick({
		  slidesToShow: 3,
		  slidesToScroll: 1,
		  autoplay: true,
		  autoplaySpeed: 2000,
		});  --}}
		
		$('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
			if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
				if (target.length) {
					$('html, body').animate({
						scrollTop: (target.offset().top - 56)
					}, 1000, "easeInOutExpo");
					return false;
				}
			}
		});

		  // Closes responsive menu when a scroll trigger link is clicked
		  $('.js-scroll-trigger').click(function() {
		    $('.navbar-collapse').collapse('hide');
		  });

		$('body').scrollspy({
		    target: '#mainNav',
		    offset: 56
		});

		/**Modal-Status*/
		var postModalStatus = $('#page-top').data('postmodal');

		/**bootstrap-load*/
		if( postModalStatus == 1 ){
			$(window).on('load', function(){
				$('#frontModal').modal('show', {
					backdrop: 'static',
					keyboard: false
				});
			});
		}


		/**scroll-load*/
		var page = 1;
		$(window).scroll(function(){
			if($(window).scrollTop() + $(window).height() >= $(document).height()){
				page++;
				scrollLoadData(page);
			}
		});

		function scrollLoadData(page){
			$.ajax({
				type: 'get',
				url: '?page=' + page,
				beforeSend:function(){
					$('#ajaxLoad').show();
				},
				success: function(res){
					if(res.data === ''){
						$('#ajaxLoad').html('<p class="text-muted">No more posts to be load.</p>');
						return ;
					}
					$('#ajaxLoad').hide();
					$('#loadPosts').append(res.data);
				}
			});
		}



		/**load-more*/

		var _token = $('input[name="_token"]').val();
		load_data('', _token);
		function load_data(id="", _token){
			$.ajax({
				url: "{{route('frnt.load_data')}}",
				method: 'POST',
				data: {id:id, _token:_token},
				success: function(data){
					$('#load_more').remove();
					$('#listData').append(data);
				}
			});
		}	

		$(document).on('click', '#loadMore', function(){
			var id = $(this).data('id');
			$('#loadMore').html('loading');
			load_data(id, _token);
		});
	});
</script>