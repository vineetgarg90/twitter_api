    <!-- display only where max_id is not coming in url 
    i.e shown only at time of fisrt page load and when requesting for newer tweets
    -->
    <?php if(!isset($_GET['max_id'])){ ?>
    <div id='new_tweet_link_cont'>
      <?php if(isset($metadata->refresh_url)){ ?>
        <!-- link to load newer tweets -->
        <a id='load_new_tweets' class='btn' data-href='<?php echo $metadata->refresh_url; ?>' href="javascript:void(0)"> Load newer tweets</a>
      <?php } ?>
        <img class='loader' src="images/ajax-loader.gif">
    </div>
    <?php } ?>

    <?php 
      $tweet_count = sizeof($tweets);
      for ($i=0; $i < $tweet_count ; $i++) {  
        //show tweets which have been retweeted atleast once
        if($tweets[$i]->retweet_count == 0) continue; 
        ?>
        <!-- single tweet container -->
        <div class='tweet_box'>
          <div class='user'>
            <img src="<?php echo $tweets[$i]->user->profile_image_url_https; ?>">
            <label>
              <?php echo $tweets[$i]->user->name; ?> 
              <small>
                <a href='<?php echo "http://twitter.com/".$tweets[$i]->user->screen_name; ?>'>
                @<?php echo $tweets[$i]->user->screen_name; ?>
                </a>
              </small>
            </label>
          </div>

          <label><?php echo $tweets[$i]->text; ?></label> 
          <br>
          <small>Souce: <?php echo $tweets[$i]->source; ?></small>
          <br>
          <small> 
            <span><strong>retweets[<?php echo $tweets[$i]->retweet_count; ?>]</strong></span>
            | 
            <span><?php echo $tweets[$i]->created_at; ?></span>
          </small>           
        </div>  
    <?php  } ?>

      <!-- display only where since_id is not coming in url 
        i.e shown only at time of first page load and when requesting for older tweets
      -->
      <?php if(!isset($_GET['since_id'])){ ?>
      <div id='older_tweet_link_cont'>
          <?php if(isset($metadata->next_results)){ ?>
            <!-- link to load older tweets -->
            <a id='load_old_tweets' class='btn' data-href="<?php echo $metadata->next_results; ?>" href="javascript:void(0)">Load older tweets</a>
          <?php } ?>
          <img class='loader' src="images/ajax-loader.gif">
      </div>
      <?php } ?>