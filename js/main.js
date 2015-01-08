  $('document').ready(function(){
      //load tweets on document load
      //show loader
       $('.loader').show();
        $.ajax({
          'url' : 'load_tweets.php',
          'method' : 'get',
          'dataType' : 'html',
          success: function(data){
            $('#tweet_container').html(data);
          }
        });      

      //load older tweet button click
      $('body').on('click','#load_old_tweets',function(){
        var url = $(this).data('href');
        //show loader
        $('#older_tweet_link_cont').find('.loader').show();
          $.ajax({
            'url' : 'load_tweets.php' + url,
            'method' : 'get',
            'dataType' : 'html',
            success: function(data){
              $('#older_tweet_link_cont').remove();
              //append tweets at begining of list
              $('#tweet_container').append(data);
            }
          });
      });    

      //load newer tweet button click
      $('body').on('click','#load_new_tweets',function(){
        var url = $(this).data('href');
        //show loader
        $('#new_tweet_link_cont').find('.loader').show();
        $.ajax({
            'url' : 'load_tweets.php' + url,
            'method' : 'get',
            'dataType' : 'html',
            success: function(data){
              $('#new_tweet_link_cont').remove();
              //append tweets at end of list
              $('#tweet_container').prepend(data);
            }
          });
      });    

  });