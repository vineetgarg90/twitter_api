<?php
require_once('start.php');

$twitter_feed = new Feed;

//check if user is connected to twitter otherwise redirect to connect page
$twitter_feed->check_connection();

//fetch user
$user = $twitter_feed->get_user();

//show view
include('view/tweets_view.php');

	