<div align="center">

<img align="center" src="https://i.imgur.com/FylVZzy.png" />

<p>🚀 Sendy PHP API Wrapper: Complete API interfacing.</p>

[![emoji-log](https://cdn.rawgit.com/ahmadawais/stuff/ca97874/emoji-log/flat-round.svg)](https://github.com/ahmadawais/Emoji-Log/)

</div>

## 📨 SENDY API

With this `Sendy PHP API Wrapper` you can do the following:

 **SUBSCRIBERS** | **LISTS** | **CAMPAIGNS**
--- | --- | ---
Subscribe | Set List | Create
Unsubscribe | Get List | Draft
Delete subscriber | Active subscriber count | Send
Subscription status | List Segments handling | Assign to brands


## Getting Started

Getting started is easy. Here's how you do it. You can check the example.php file as well. Obviously, you'll have to download the wrapper to your current setup. Several ways to do that.

### **#1** MANUAL INSTALL:

Git clone this repo and include `./src/Sendy.php` in your project.

### **#2** COMPOSER INSTALL:

Composer Install is the prefered method.

```php
composer require ahmadawais/sendy-php-api
```

#### Step 0. Require the wrapper

```php
require_once( 'Sendy.php' );
```

#### Step 1. Configure it

```php
// 2. Configuration.
$config = [
	'sendyUrl' => 'https://send_installation_url.com', // Your Sendy installation URL (without trailing slash).
	'apiKey'   => 'XXXXXXXXXXXXXXXX', // Your API key. Available in Sendy Settings.
	'listId'   => 'XXXXXXXXXXXXXXXX',
];
```

#### Step 2. Init

```php
$sendy = new \SENDY\API( $config );
```

## API KEY METHODS

1. Method: `subscribe()`.
2. Method: `unsubscribe()`.
3. Method: `subStatus()`.
4. Method: `delete()`.
5. Method: `subCount()`.
6. Method: `campaign()`.

### Method #1: Subscribe

```php
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

```

### Method #2: Unsubscribe

```php
$responseArray = $sendy->unsubscribe( 'your@email.com' );
```

### Method #3: Subscriber Status

```php
$responseArray = $sendy->subStatus( 'your@email.com' );

```

### Method #4: Delete Subscriber

```php
$responseArray = $sendy->delete( 'your@email.com' );

```

### Method #5: Subscriber Count of a list

```php
$responseArray = $sendy->subCount();
```

### Method #6: Campaign — Draft And/Or Send as well

```php
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
```

### Method #7: Set List ID

```php
// Method #7: Change the `XXXXXXX` you are referring to at any point.
$sendy->setListId( 'XXXXXXX' );
```

### Method #8: Get List ID

```php
// Method #7: Get the `XXXXXXX` you are referring to at any point.
$sendy->getListId();
```

## Response

The response of this PHP wrapper is custom built. At the moment, it always returns a PHP Array. This array has the `status` of your action and an appropriate `message` in the response.

- `status` is either `true` or `false`.
- `message` is based on the type of action being performed

```php
    // E.g. SUCCESS response.
    [
        'status'  => true,
        'message' => 'Already Subscribed'
    ];

    // E.g. FAIL response.
    [
        'status'  => false,
        'message' => 'Some fields are missing.'
    ];
```

## Change log

Changes to the "Sendy-PHP-API" for Sendy.

> [Automated release notes can be found here →](https://github.com/ahmadawais/Sendy-PHP-API/releases)

## License & Credits

The code is licensed under MIT and a huge props to Jacob Bennett for his initial work on the lib.
Requires at least PHP 5.3.0 (otherwise remove the namespace).

---

### 🙌 [WPCOUPLE PARTNERS](https://WPCouple.com/partners):

This open source project is maintained by the help of awesome businesses listed below. What? [Read more about it →](https://WPCouple.com/partners)

<table width='100%'>
	<tr>
		<td width='333.33'><a target='_blank' href='https://www.gravityforms.com/?utm_source=WPCouple&utm_medium=Partner'><img src='https://on.ahmda.ws/mtrE/c' /></a></td>
		<td width='333.33'><a target='_blank' href='https://ahmda.ws/USE_KINSTA'><img src='https://on.ahmda.ws/mu5O/c' /></a></td>
		<td width='333.33'><a target='_blank' href='https://wpengine.com/?utm_source=WPCouple&utm_medium=Partner'><img src='https://on.ahmda.ws/mto3/c' /></a></td>
	</tr>
	<tr>
		<td width='333.33'><a target='_blank' href='https://www.sitelock.com/?utm_source=WPCouple&utm_medium=Partner'><img src='https://on.ahmda.ws/mtyZ/c' /></a></td>
		<td width='333.33'><a target='_blank' href='https://wp-rocket.me/?utm_source=WPCouple&utm_medium=Partner'><img src='https://on.ahmda.ws/mtrv/c' /></a></td>
		<td width='333.33'><a target='_blank' href='https://blogvault.net/?utm_source=WPCouple&utm_medium=Partner'><img src='https://on.ahmda.ws/mtph/c' /></a></td>
	</tr>
	<tr>
		<td width='333.33'><a target='_blank' href='http://cridio.com/?utm_source=WPCouple&utm_medium=Partner'><img src='https://on.ahmda.ws/mtmy/c' /></a></td>
		<td width='333.33'><a target='_blank' href='http://wecobble.com/?utm_source=WPCouple&utm_medium=Partner'><img src='https://on.ahmda.ws/mtrW/c' /></a></td>
		<td width='333.33'><a target='_blank' href='https://www.cloudways.com/?utm_source=WPCouple&utm_medium=Partner'><img src='https://on.ahmda.ws/mu0C/c' /></a></td>
	</tr>
	<tr>
		<td width='333.33'><a target='_blank' href='https://www.cozmoslabs.com/?utm_source=WPCouple&utm_medium=Partner'><img src='https://on.ahmda.ws/mu9W/c' /></a></td>
		<td width='333.33'><a target='_blank' href='https://wpgeodirectory.com/?utm_source=WPCouple&utm_medium=Partner'><img src='https://on.ahmda.ws/mtwv/c' /></a></td>
		<td width='333.33'><a target='_blank' href='https://www.wpsecurityauditlog.com/?utm_source=WPCouple&utm_medium=Partner'><img src='https://on.ahmda.ws/mtkh/c' /></a></td>
	</tr>
	<tr>
		<td width='333.33'><a target='_blank' href='https://mythemeshop.com/?utm_source=WPCouple&utm_medium=Partner'><img src='https://on.ahmda.ws/n3ug/c' /></a></td>
		<td width='333.33'><a target='_blank' href='https://www.liquidweb.com/?utm_source=WPCouple&utm_medium=Partner'><img src='https://on.ahmda.ws/mtnt/c' /></a></td>
		<td width='333.33'><a target='_blank' href='https://WPCouple.com/contact?utm_source=WPCouple&utm_medium=Partner'><img src='https://on.ahmda.ws/mu3F/c' /></a></td>
	</tr>
</table>
