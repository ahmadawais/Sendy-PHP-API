<?php
/**
 * Sendy PHP API Wrapper
 *
 * Sendy's API is not RESTful so having this wrapper is great.
 *
 * @version 2.3.0
 * @package Sendy
 * @since 1.0.0
 */

namespace SENDY;

use Requests;


// Helps with the CORS issues.
header( 'Access-Control-Allow-Origin: *' );
header( 'Access-Control-Allow-Methods: POST, GET' );
header( 'Access-Control-Allow-Credentials: true' );

/**
 * API Class.
 *
 * Sendy PHP API Class.
 *
 * @since 1.0.0
 */
class API {

	/**
	 * Console Log.
	 *
	 * Log the response to console for better readability.
	 *
	 * @param String $context Context.
	 * @param Mixed  $data Any data.
	 * @since 1.0.0
	 */
	public static function it( $data, $context = 'LOGGED: ' ) {
		header( 'Content-Type: text/html' );
		ob_start();
		$output  = "console.log('%c $context ', 'background: #bada55; color: #222; padding: 10px;');";
		$output .= 'console.log(' . json_encode( $data ) . ');';
		$output  = sprintf( '<script>%s</script>', $output );
		echo $output;
		ob_end_flush();
	}
	/**
	 * Installation URL.
	 *
	 * @var String
	 * @since 1.0.0
	 */
	protected $sendyUrl;

	/**
	 * API key.
	 *
	 * @var String
	 * @since 1.0.0
	 */
	protected $apiKey;

	/**
	 * List ID.
	 *
	 * @var String
	 * @since 1.0.0
	 */
	protected $listId;

	/**
	 * Constructor.
	 *
	 * @param Array $config Configuration.
	 * @throws Exception PHP Exceptions.
	 * @since  1.0.0
	 */
	public function __construct( array $config ) {
		$this->sendyUrl = isset( $config['sendyUrl'] ) ? $config['sendyUrl'] : false;
		$this->apiKey   = isset( $config['apiKey'] ) ? $config['apiKey'] : false;
		$this->listId   = isset( $config['listId'] ) ? $config['listId'] : false;

		// Bail if empty.
		if ( empty( $this->sendyUrl ) || empty( $this->apiKey ) || empty( $this->listId ) ) {
			throw new Exception( 'Required config parameters [sendyUrl, listId, apiKey] is not set or empty', 1 );
		}
	}

	/**
	 * Set List ID.
	 *
	 * @param String $listId List ID.
	 * @throws Exception PHP Exceptions.
	 * @since  1.0.0
	 */
	public function setListId( $listId ) {
		// Bail if empty.
		if ( empty( $listId ) ) {
			throw new Exception( 'Required config parameter [listId] is not set', 1 );
		}

		// Set the ID.
		$this->listId = $listId;
	}

	/**
	 * Get List ID.
	 *
	 * @return String
	 * @since  1.0.0
	 */
	public function getListId() {
		return $this->listId;
	}


	/**
	 * Response from this API.
	 *
	 * @param Boolean $status Status.
	 * @param String  $msg Response msg.
	 * @return Array
	 * @since 2.0.0
	 */
	private function response( $status = false, $msg = 'Something went wrong!' ) {
		return [
			'status'  => $status,
			'message' => $msg,
		];
	}

	/**
	 * Subscribe.
	 *
	 * @param  Array $values Values.
	 * @return Array
	 * @since  1.0.0
	 */
	public function subscribe( array $values ) {
		// Route.
		$route = 'subscribe';

		// Send the subscribe command.
		$apiResponse = strval( $this->query( $route, $values ) );

		// Handle API Responses.
		switch ( $apiResponse ) {
			case 'true':
			case '1':
				return $this->response( true, 'Subscribed!' );

			case 'Already subscribed.':
				return $this->response( true, 'Already subscribed!' );

			default:
				return $this->response( false, $apiResponse );
		}
	}

	/**
	 * Unsubscribe.
	 *
	 * @param  String $email Email ID.
	 * @return Array
	 * @since  1.0.0
	 */
	public function unsubscribe( $email ) {
		// Route.
		$route = 'unsubscribe';

		// Send the unsubscribe.
		$apiResponse = strval( $this->query( $route, [ 'email' => $email ] ) );

		// Handle API Responses.
		switch ( $apiResponse ) {
			case 'true':
			case '1':
				return $this->response( true, 'Unsubscribed!' );

			default:
				return $this->response( false, $apiResponse );
		}
	}

	/**
	 * Subscriber Status.
	 *
	 * @param  String $email Email ID.
	 * @return Array
	 * @since  1.0.0
	 */
	public function subStatus( $email ) {
		// Route.
		$route = 'api/subscribers/subscription-status.php';

		// Send the request for status.
		$apiResponse = $this->query(
			$route, [
				'email'   => $email,
				'api_key' => $this->apiKey,
				'list_id' => $this->listId,
			]
		);

		// Handle the API Responses.
		switch ( $apiResponse ) {
			case 'Subscribed!':
			case 'Subscribed':
			case 'Unsubscribed':
			case 'Unconfirmed':
			case 'Bounced':
			case 'Soft bounced':
			case 'Complained':
				return $this->response( true, $apiResponse );

			default:
				return $this->response( false, $apiResponse );
		}
	}

	/**
	 * Delete Subscriber.
	 *
	 * @param String $email Email.
	 * @return Array
	 * @since  1.0.0
	 */
	public function delete( $email ) {
		// Route.
		$route = 'api/subscribers/delete.php';

		// Send the delete subscriber.
		$apiResponse = strval(
			$this->query(
				$route, [
					'email'   => $email,
					'api_key' => $this->apiKey,
					'list_id' => $this->listId,
				]
			)
		);

		// Handle the API Responses.
		switch ( $apiResponse ) {
			case 'true':
			case '1':
				return $this->response( true, 'Deleted!' );

			default:
				return $this->response( false, $apiResponse );

		}
	}

	/**
	 * Subscriber Count.
	 *
	 * @throws Exception PHP Exceptions.
	 * @param  String $list List ID.
	 * @return Array
	 * @since  1.0.0
	 */
	public function subCount( $list = '' ) {
		// Route.
		$route = 'api/subscribers/active-subscriber-count.php';

		// If a list is passed in use it, otherwise use $this->listId.
		if ( empty( $list ) ) {
			$list = $this->listId;
		}

		// Handle exceptions.
		if ( empty( $list ) ) {
			throw new Exception( "Method [subCount] requires parameter [list] or [$this->listId] to be set.", 1 );
		}

		// Send request for subCount.
		$apiResponse = $this->query(
			$route, [
				'api_key' => $this->apiKey,
				'list_id' => $list,
			]
		);

		// Handle the API Responses.
		if ( is_numeric( $apiResponse ) ) {
			return $this->response( true, $apiResponse );
		}

		// Error.
		return $this->response( false, $apiResponse );
	}

	/**
	 * Create a campaign.
	 *
	 * @param  Array $values Values.
	 * @return Array
	 * @since  1.0.0
	 */
	public function campaign( array $values ) {
		// Route.
		$route = 'api/campaigns/create.php';

		// Global options.
		$defualtOptions = [
			'api_key' => $this->apiKey,
		];

		// Merge the passed in values with the global options.
		$values = array_merge( $defualtOptions, $values );

		// Send request for campaign.
		$apiResponse = $this->query( $route, $values );

		// Handle the API Responses.
		switch ( $apiResponse ) {
			case 'Campaign created':
			case 'Campaign created and now sending':
				return $this->response( true, $apiResponse );

			default:
				return $this->response( false, $apiResponse );
		}
	}

	/**
	 * Query.
	 *
	 * Build and Send the query via CURL.
	 *
	 * @throws Exception PHP Exceptions.
	 * @param  String $route API Route.
	 * @param  Array  $values Parameters.
	 * @return String
	 * @since  1.0.0
	 */
	private function query( $route, array $values ) {
		// Bail if empty.
		if ( empty( $route ) || empty( $values ) ) {
			throw new Exception( 'Required config parameter [route, values] is not set or empty', 1 );
		}

		// Global options for return.
		$returnOptions = array(
			'list'    => $this->listId,
			'boolean' => 'true',
		);

		// Merge the passed in values with the options for return.
		$content = array_merge( $values, $returnOptions );

		// Build a query using the $content.
		$postData = http_build_query( $content );

		// URL to send POST to.
		$postUrl = $this->sendyUrl . '/' . $route;

		if ( class_exists( 'Requests' ) ) {
			// Send POST.
			$request     = Requests::post( $postUrl, [], $postData );
			$apiResponse = $request->body;
		} else {
			// Let's cURL.
			// phpcs:disable -- not WP.
			$ch = curl_init( $postUrl );
			// Settings to disable SSL verification for testing.
			// curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
			// curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/x-www-form-urlencoded' ) );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $postData );
			$apiResponse = curl_exec( $ch );
			curl_close( $ch );
		}

		// API apiResponse.
		return $apiResponse;
	}
}
