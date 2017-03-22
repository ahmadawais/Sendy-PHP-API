<?php
/**
 * Sendy PHP API Wrapper
 *
 * Sendy's API is not RESTful so having this wrapper is great.
 *
 * @version 1.0.1
 */

// Namespace FTW.
namespace SENDY;

// Exit if accessed directly.
if ( ! defined( 'Sendy_PHP_API_Wrapper' ) ) {
	echo '<h1>Nothing to see here!</h1>';
	exit;
}

// Helps with the CORS issues.
header( 'Access-Control-Allow-Origin: *' );
header( 'Access-Control-Allow-Methods: POST, GET' );
header( 'Access-Control-Allow-Credentials: true' );

// Make sure class is unique.
if ( ! class_exists( 'Sendy_PHP_API' ) ) {
	/**
	 * Sendy_PHP_API.
	 *
	 * Sendy PHP API Class.
	 *
	 * @since 1.0.0
	 */
	class Sendy_PHP_API {
		// Installation URL.
		protected $installation_url;

		// API key.
		protected $api_key;

		// List ID>
		protected $list_id;

		/**
		 * Constructor.
		 *
		 * @param array     $config
		 * @since  1.0.0
		 */
		public function __construct( array $config ) {
			// Error checking.
			$installation_url = @$config['installation_url'];
			$list_id          = @$config['list_id'];
			$api_key          = @$config['api_key'];

			// Bail if empty.
			if ( empty( $list_id ) ) {
				throw new \Exception( 'Required config parameter [list_id] is not set or empty', 1 );
			}

			// Bail if empty.
			if ( empty( $installation_url ) ) {
				throw new \Exception( 'Required config parameter [installation_url] is not set or empty', 1 );
			}

			// Bail if empty.
			if ( empty( $api_key ) ) {
				throw new \Exception( 'Required config parameter [api_key] is not set or empty', 1 );
			}

			// Define the class vars.
			$this->installation_url = $installation_url;
			$this->list_id          = $list_id;
			$this->api_key          = $api_key;
		}

		/**
		 * Set List ID.
		 *
		 * @param string    $list_id List ID.
		 * @since  1.0.0
		 */
		public function set_list_id( $list_id ) {
			// Bail if empty.
			if ( empty( $list_id ) ) {
				throw new \Exception( "Required config parameter [list_id] is not set", 1 );
			}

			// Set the ID.
			$this->list_id = $list_id;
		}

		/**
		 * Get List ID.
		 *
		 * @return string ID.
		 * @since  1.0.0
		 */
		public function get_list_id() {
			return $this->list_id;
		}

		/**
		 * Subscribe.
		 *
		 * @param  array     $values
		 * @return array
		 * @since  1.0.0
		 */
		public function subscribe( array $values ) {
			// Route.
			$route = 'subscribe';

			// Send the subscribe command.
			$result = strval( $this->query( $route, $values ) );

			// Handle results.
			switch ( $result ) {
				case '1':
					return array(
						'status'  => true,
						'message' => 'Subscribed!',
						 );
					break;

				case 'Already subscribed.':
					return array(
						'status'  => true,
						'message' => 'Already subscribed.',
						 );
					break;

				default:
					return array(
						'status'  => false,
						'message' => $result,
						 );
					break;
			}
		}

		/**
		 * Unsubscribe
		 *
		 * @param  string    $email Email ID.
		 * @return array
		 * @since  1.0.0
		 */
		public function unsubscribe( $email ) {
			// Route.
			$route = 'unsubscribe';

			// Send the unsubscribe.
			$result = strval( $this->query( $route, array( 'email' => $email ) ) );

			// Handle results.
			switch ( $result ) {
				case '1':
					return array(
						'status'  => true,
						'message' => 'Unsubscribed',
						 );
					break;

				default:
					return array(
						'status'  => false,
						'message' => $result,
						 );
					break;
			}
		}

		/**
		 * Delete Subsriber
		 *
		 * @param  string    $email
		 * @return array
		 * @since  1.0.0
		 */
		public function delete( $email ) {
			// Route.
			$route = 'api/subscribers/delete.php';

			// Send the delete subscriber.
			$result = strval( $this->query( $route, array(
				'email'   => $email,
				'api_key' => $this->api_key,
				'list_id' => $this->list_id,
			 ) ) );

			// Handle the results.
			switch ( $result ) {
				case 'true':
				case '1':
					return array(
						'status' => true,
						'message' => $result,
						 );
					break;

				case 'No data passed':
				case 'API key not passed':
				case 'Invalid API key':
				case 'List ID not passed':
				case 'List does not exist':
				case 'Email address not passed':
				case 'Subscriber does not exist':
				default:
					return array(
						'status'  => false,
						'message' => $result,
						 );
					break;
			} // End switch.
		} // End delete().


		/**
		 * Subscriber Status
		 *
		 * @param  string    $email Email ID.
		 * @return array
		 * @since  1.0.0
		 */
		public function substatus( $email ) {
			// Route.
			$route = 'api/subscribers/subscription-status.php';

			// Send the request for status.
			$result = $this->query( $route, array(
				'email'   => $email,
				'api_key' => $this->api_key,
				'list_id' => $this->list_id,
			 ) );

			// Handle the results.
			switch ( $result ) {
				case 'Subscribed!':
				case 'Unsubscribed':
				case 'Unconfirmed':
				case 'Bounced':
				case 'Soft bounced':
				case 'Complained':
					return array(
						'status' => true,
						'message' => $result,
						 );
					break;

				default:
					return array(
						'status' => false,
						'message' => $result,
						 );
					break;
			} // End switch.
		} // End substatus().

		/**
		 * Subscriber Count.
		 *
		 * @param  string    $list List ID.
		 * @return array
		 * @since  1.0.0
		 */
		public function subcount( $list = '' ) {
			// Route.
			$route = 'api/subscribers/active-subscriber-count.php';

			// If a list is passed in use it, otherwise use $this->list_id.
			if ( empty( $list ) ) {
				$list = $this->list_id;
			}

			// Handle exceptions.
			if ( empty( $list ) ) {
				throw new \Exception( "method [subcount] requires parameter [list] or [$this->list_id] to be set.", 1 );
			}

			// Send request for subcount.
			$result = $this->query( $route, array(
				'api_key' => $this->api_key,
				'list_id' => $list,
			 ) );

			// Handle the results.
			if ( is_numeric( $result ) ) {
				return array(
					'status'  => true,
					'message' => $result,
				 );
			}

			// Error.
			return array(
				'status'  => false,
				'message' => $result,
			 );
		} // End subcount().

		/**
		 * Create Campaign
		 *
		 * @param  array     $values
		 * @return array
		 * @since  1.0.0
		 */
		public function campaign( array $values ) {
			// Route.
			$route = 'api/campaigns/create.php';

			// Global options.
			$global_options = array(
				'api_key' => $this->api_key
			 );

			// Merge the passed in values with the global options.
			$values = array_merge( $global_options, $values );

			// Send request for campaign.
			$result = $this->query( $route, $values );

			// Handle the results.
			switch ( $result ) {
				case 'Campaign created':
				case 'Campaign created and now sending':
					return array(
						'status' => true,
						'message' => $result,
					 );
					break;

				default:
					return array(
						'status' => false,
						'message' => $result,
					 );
					break;
			}
		}

		/**
		 * Query
		 *
		 * Build and Send the query via CURL.
		 *
		 * @param  string    $route 	API Route.
		 * @param  array     $values	Parameters.
		 * @return string
		 * @since  1.0.0
		 */
		private function query( $route, array $values ) {
			// Baild if empty.
			if ( empty( $route ) ) {
				throw new \Exception( "Required config parameter [type] is not set or empty", 1 );
			}

			// Baild if empty.
			if ( empty( $values ) ) {
				throw new \Exception( "Required config parameter [values] is not set or empty", 1 );
			}

			// Global options for return.
			$return_options = array(
				'list'    => $this->list_id,
				'boolean' => 'true',
			 );

			// Merge the passed in values with the options for return.
			$content = array_merge( $values, $return_options );

			// Build a query using the $content.
			$postdata = http_build_query( $content );

			// Let's CURL ;).
			$ch = curl_init( $this->installation_url . '/' . $route );

			// Settings to disable SSL verification for testing ( leave commented for production use )
			// curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
			// curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );

			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/x-www-form-urlencoded' ) );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $postdata );
			$result = curl_exec( $ch );
			curl_close( $ch );

			// API Result.
			return $result;
		}
	} // End class.
} // End if().
