$( document ).ready(function() {

    /*$('#orderTable').DataTable({
        "pagingType": "simple_numbers", // "simple" option for 'Previous' and 'Next' buttons only
        "searching": false
    });
    $('.dataTables_length').addClass('bs-select');*/


    function createTable() {
        $('#orderTable').DataTable({
            "pagingType": "simple_numbers", // "simple" option for 'Previous' and 'Next' buttons only
            "searching": false,
            "processing": true,
            "serverSide": true,
            "ajax": '../../../resources/orders.php',
        });
    }

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