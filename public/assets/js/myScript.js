$( document ).ready(function() {

    $('.zoom-gallery').magnificPopup({
		delegate: 'a',
		type: 'image',
		closeOnContentClick: false,
		closeBtnInside: false,
		mainClass: 'mfp-with-zoom mfp-img-mobile',
		image: {
			verticalFit: true,
			/*titleSrc: function(item) {
				return item.el.attr('title') + ' &middot; <a class="image-source-link" + " target="_blank">image source</a>';
			}*/
		},
		gallery: {
			enabled: false
		},
		zoom: {
			enabled: true,
			duration: 300, // don't foget to change the duration also in CSS
			opener: function(element) {
				return element.find('img');
			}
		}
    });
    
    $('.nav-search-submit').on('click',function () {
        //$('.card').show();
        var filter = $(".nav-search").val(); // get the value of the input, which we filter on
        console.log(filter);
        $('.card').find(".card-title:not(:containsi(" + filter + "))").parent().parent().parent().parent().css('display','none');
        //$('#HomePage').filter(".card-title:contains(" + filter + ")").parent().parent().css('display', 'none');
    });

    $.extend($.expr[':'], {
    'containsi': function(elem, i, match, array)
    {
        return (elem.textContent || elem.innerText || '').toLowerCase()
        .indexOf((match[3] || "").toLowerCase()) >= 0;
    }
    });

    $(".btn-contact").on('click', function(){
        window.location.href = "contact.html";
    });

    ('.back-to-top').click(function(event) {
        //event.preventDefault();
        ScrollToHeading('.topOfPage');
    });

    $(document).scroll(function () {
        var y = $(this).scrollTop();
        if (y > 800) {
            $('.numberCircle').fadeIn();
        } else {
            $('.numberCircle').fadeOut();
        }
    });

    $('.popover-dismiss').popover({
        trigger: 'focus'
    })
});