<?php
/**
 * Example
 *
 * Sendy PHP API Interfacing Example.
 *
 * @since 	1.0.0
 */

// 1. Require the wrapper.
require_once( 'class-sendy-php-api.php' );

// 2. Configuration.
$config = array(
	'installation_url' => 'http://send.yourdomain.com',  // Your Sendy installation URL (without trailing slash).
	'api_key'          => 'XXXXXXXXXXXXXXXXXXXXXXXXXX', // Your API key. Aavailable in Sendy Settings.
	'list_id'          => 'XXXXXXXXXXXXXXXXXXXXXXXXXX',
);

// 3. Init.
$sendy = new \SENDY\Sendy_PHP_API( $config );


/**
 * API KEY METHODS.
 */

// Method #1: Subscribe.
$result_array = $sendy->subscribe( array(
	'name'   => 'Name',
	'email'  => 'your@email.com', // This is the only field required by sendy.
	'custom' => 'field' // You can custom fields as well.
));

// Method #2: Unsubscribe.
$result_array = $sendy->unsubscribe( 'your@email.com' );

// Method #3: Subscriber Status.
$result_array = $sendy->substatus( 'your@email.com' );

// Method #4: Delete Subscriber.
$result_array = $sendy->delete( 'your@email.com' );

// Method #5: Subscriber Count of a list.
$result_array = $sendy->subcount();

// Method #6: Campaing — Draft And/Or Send as well.
$result_array = $sendy->campaign( array(
	'from_name'     => 'Your Name',
	'from_email'    => 'your@email.com',
	'reply_to'      => 'your@email.com',
	'subject'       => 'Your Subject',
	'plain_text'    => 'An Amazing campaign', // (optional).
	'html_text'     => '<h1>Amazing campaign</h1>',
	'brand_id'      => 0, // Required only if you are creating a 'Draft' campaign.
	'send_campaign' => 0 // Set to 1 if you want to send the campaign as well and not just create a draft. Default is 0.
	'list_ids'      => 'your_list_id', // Required only if you set send_campaign to 1.
	'query_string'  => 'some', // Eg. Google Analytics tags.
) );

// Method #7: Change the `list_id` you are referring to at any point.
$sendy->set_list_id( "XXXXXXX" );

// Method #8: Get the `list_id` you are referring to at any point.
$sendy->get_list_id( "XXXXXXX" );
