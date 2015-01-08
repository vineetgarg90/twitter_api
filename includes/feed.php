<?php 

session_start();
require_once('twitteroauth/twitteroauth.php');

/**
* Feed Class  
*/	
class Feed {
	protected $consumer_key = CONSUMER_KEY;
	protected $consumer_secret = CONSUMER_SECRET;
	protected $connection;

	/**
	* check if api consumer key and secret are set otherwise show message
	*/	
	public function __construct(){
		if ($this->consumer_key === '' || $this->consumer_secret === '' || $this->consumer_key === 'CONSUMER_KEY_HERE' || $this->consumer_secret === 'CONSUMER_SECRET_HERE') {
		  echo 'You need to set consumer key and secret to proceed.';
		  exit;
		}		
	}

	/**
	* shows screen to connect with twitter for authorization and save connection if connected
	*/	
	public function check_connection(){
		if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
		    header('Location: ./connect.php');
		}
		/* Get user access tokens out of the session. */
		$access_token = $_SESSION['access_token'];

		/* Create a TwitterOauth object with consumer/user tokens. */
		$this->connection =  new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	}

	/**
	* get connected user details
	*/
	public function get_user(){
		$content = $this->connection->get('account/verify_credentials');	
		$op['name'] = $content->name;
		$op['screen_name'] = $content->screen_name;
		$op['profile_image_url'] = $content->profile_image_url;
		return $op;
	}	

	/**
	* connects with twitter
	*/
	public function connect(){
		/* Get temporary credentials. */
		$this->connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
		$request_token = $this->connection->getRequestToken(OAUTH_CALLBACK);

		/* Save temporary credentials to session. */
		$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
		 
		/* If last connection failed don't display authorization link. */
		switch ($this->connection->http_code) {
		  case 200:
		    /* Build authorize URL and redirect user to Twitter. */
		    $url = $this->connection->getAuthorizeURL($token);
		    header('Location: ' . $url); 
		    break;
		  default:
		    /* Show notification if something went wrong. */
		    echo 'Could not connect to Twitter. Refresh the page or try again later.';
		}
	}

	public function callback(){
		//if the oauth_token is old redirect to the disconnect page.
		if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
		  $_SESSION['oauth_status'] = 'oldtoken';
		  header('Location: ./disconnect.php');
		}

		//create TwitteroAuth object with app key/secret and token key/secret from default phase
		$this->connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

		//request access tokens from twitter
		$access_token = $this->connection->getAccessToken($_REQUEST['oauth_verifier']);

		//save the access tokens
		$_SESSION['access_token'] = $access_token;

		//remove no longer needed request tokens
		unset($_SESSION['oauth_token']);
		unset($_SESSION['oauth_token_secret']);

		//if HTTP response is 200 continue otherwise send to connect page to retry
		if (200 == $this->connection->http_code) {
		  //the user has been verified and the access tokens can be saved for future use
		  $_SESSION['status'] = 'verified';
		  header('Location: ./index.php');
		} else {
		  header('Location: ./disconnect.php');
		}

	}


	/**
	* fetches all the tweets with given hashtag and have been retweeted atleast once.
	* @param string $hashtag
	* @return mixed array
	*
	*/
	public function get_tweets_by_hashtag($hashtag){
		//-RT: will omit retweets from results
		$parameters['q'] = $hashtag . ' -RT';

		//number of tweets to fetch at a time
		$parameters['count'] = 100;

		if(!empty($_GET['since_id']))
		$parameters['since_id'] = $_GET['since_id'];

		if(!empty($_GET['max_id']))
		$parameters['max_id'] = $_GET['max_id'];

		//make api call
		$content = $this->connection->get('search/tweets', $parameters);

		$op['hashtag'] = $hashtag;
		$op['tweets'] = $content->statuses;
		$op['metadata'] = $content->search_metadata;
		return $op;		
	}

	/**
	* disconnect from twitter by clearing sessions
	*/
	public function disconnect(){
		//clear sessions
		session_destroy();

		unset($this->connection);

		//redirect to login page
		header('Location: ./connect.php');		
	}
}

 ?>