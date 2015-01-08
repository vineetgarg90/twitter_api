<?php
require_once('start.php');

$twitter_feed = new Feed;

//check if user is connected to twitter otherwise redirect to connect page
$twitter_feed->check_connection();

//fetch tweets with given hashtag
$op = $twitter_feed->get_tweets_by_hashtag('#custserv');

//convert array indexes to variables
extract($op);

//show tweets feed
include('view/tweets_feed_view.php');

