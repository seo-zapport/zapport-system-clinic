<footer id="zp-footer" class="py-5 bg-dark">
	<div class="footer-socket">
		<div class="container">
			<p class="m-0 text-center text-white">Copyright © Your Website 2019</p>
		</div>
	</div>
</footer>

<!-- Modal -->
<div class="modal fade" id="frontModal" tabindex="-1" role="dialog" aria-labelledby="frontModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="frontModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<p>Cras ultricies ligula sed magna dictum porta. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Curabitur aliquet quam id dui posuere blandit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Curabitur aliquet quam id dui posuere blandit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.</p>

				<p>Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Curabitur aliquet quam id dui posuere blandit. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Pellentesque in ipsum id orci porta dapibus. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Cras ultricies ligula sed magna dictum porta. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi.</p>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('/js/app.js') }}"></script>
<script src="{{ asset('/js/slick.js') }}"></script>
<script src="{{ asset('/js/jquery.easing.min.js') }}"></script>
<script type="application/javascript">
	jQuery(document).ready(function($) {


		/**slick*/
		$('.slick-posts').slick({
		  slidesToShow: 3,
		  slidesToScroll: 1,
		  autoplay: true,
		  autoplaySpeed: 2000,
		});
		
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

		/**bootstrap-load*/
		$(window).on('load', function(){
			$('#frontModal').modal('show');
		});
	});
</script>