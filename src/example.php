<?php
/**
 * Example Sendy API
 *
 * Sendy PHP API Interfacing Example.
 *
 * TEST:
 *      0. Change the API Keys and data below.
 *      1. Open this folder in the terminal and run a simple PHP server
 *      2. Run this command → php -S localhost:8000
 *      3. Open in your browser this link → localhost:8000
 *
 * @package SENDY
 * @since   1.0.0
 */

// 1. Require the wrapper. | Better yet use composer and autoloader.
require_once './Sendy.php';

// 2. Configuration.
$config = [
	'sendyUrl' => 'https://send_installation_url.com', // Your Sendy installation URL (without trailing slash).
	'apiKey'   => 'XXXXXXXXXXXXXXXX', // Your API key. Available in Sendy Settings.
	'listId'   => 'XXXXXXXXXXXXXXXX',
];

// 3. Init.
$sendy = new \SENDY\API( $config );

/**
 * API KEY METHODS.
 *
 * 1. subscribe().
 * 2. unsubscribe().
 * 3. subStatus().
 * 4. delete().
 * 5. subCount().
 * 6. campaign().
 */

// Method #1: Subscribe.
$responseArray = $sendy->subscribe(
	[
		'email'     => 'your@email.com', // This is the only field required by sendy.
		'name'      => 'Name', // User name (optional).
		'custom'    => 'Field Value', // You can custom fields as well (optional).
		'country'   => 'US', // User 2 letter country code (optional).
		'ipaddress' => 'XX.XX.XX.XXX', // User IP address (optional).
		'referrer'  => 'https://AhmadAwais.com/', // URL where the user signed up from (optional).
		'gdpr'      => true, // GDPR compliant? Set this to "true" (optional).
	]
);

// Method #2: Unsubscribe.
$responseArray = $sendy->unsubscribe( 'your@email.com' );

// Method #3: Subscriber Status.
$responseArray = $sendy->subStatus( 'your@email.com' );

// Method #4: Delete Subscriber.
$responseArray = $sendy->delete( 'your@email.com' );

// Method #5: Subscriber Count of a list.
$responseArray = $sendy->subCount();

// Method #6: Campaign — Draft And/Or Send as well.
$responseArray = $sendy->campaign(
	array(
		'from_name'            => 'Your Name',
		'from_email'           => 'your@email.com',
		'reply_to'             => 'your@email.com',
		'title'                => 'Title', // the title of your campaign.
		'subject'              => 'Your Subject',
		'plain_text'           => 'An Amazing campaign', // Optional.
		'html_text'            => '<h1>Amazing campaign</h1>',
		'brand_id'             => 1, // Required only if you are creating a 'Draft' campaign. That is `send_campaign` set to 0.
		'send_campaign'        => 0, // SET: Draft = 0 and Send = 1 for the campaign.
		// Required only if you set send_campaign to 1 and no `segment_ids` are passed in.. List IDs should be single or comma-separated.
		'list_ids'             => 'XXXXXXXX, XXXXXXXX',
		// Required only if you set send_campaign to 1 and no `list_ids` are passed in. Segment IDs should be single or comma-separated.
		'segment_ids'          => '1',
		// Lists to exclude. List IDs should be single or comma-separated. (optional).
		'exclude_list_ids'     => '',
		// Segments to exclude. Segment IDs should be single or comma-separated. (optional).
		'exclude_segments_ids' => '',
		'query_string'         => 'XXXXXXXX', // Eg. Google Analytics tags.
	)
);

// If you want JSON Response.
header( 'Content-Type: application/json' );
header( 'Access-Control-Allow-Origin: *' );
header( 'Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With' );
header( 'Access-Control-Allow-Methods: POST, GET' ); // OPTIONS, PUT, DELETE.
header( 'Access-Control-Allow-Credentials: true' );
// Get JSON printed for you.
print_r( json_encode( $responseArray ) );

// Method #7: Change the list ID `XXXXXXX` you are referring to at any point.
$sendy->setListId( 'XXXXXXX' );

// Method #8: Get the list id you are referring to at any point.
$sendy->getListId();
