$(document).on('click','#btn-more',function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    var published = $(this).data('id');
    $('#btn-more').html('Loading....');
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
        url: '/about/usecases/usecases_loadmore',
        type: 'POST',
        data: {published: published},
        success: function (data)
        {
            if(data!="")
            {
                $('#remove-row').remove();
                $('#load-data').append(data);
            }
            else
            {
                $('#btn-more').html('No Articles');
            }
        },
        error: function (data)
        {
            console.log(data);
            window.alert("Oops! An error occurred, please try again later.");
        }
    });
});

$(document).on('change','#geocommunity',function(){

    var communityIdx = $('#geocommunity').val();
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
        url: '/about/usecases/filter_usecases',
        type: 'POST',
        data: {communityIdx: communityIdx},
        success: function (data)
        {
            if(data!="")
            {
                $('#remove-row').remove();
                $('#load-data').html(data);
            }
            else
            {
                $('#load-data').html('');   
                $('#remove-row').remove();             
                $('#load-data').html("<p style='text-align:center;font-size:20px;margin:0 auto'>No Usecases Found</p>");
            }
        },
        error: function (data)
        {
            console.log(data);
            window.alert("Oops! An error occurred, please try again later.");
        }
    });
});