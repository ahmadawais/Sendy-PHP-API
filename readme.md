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

Composer Install is the preferred method.

```php
composer require ahmadawais/sendy-php-api
```

#### Step 0. Require the wrapper

```php
// New way using PSR4 Standard autoloader. Recommended
require_once . '/vendor/autoload.php';

// Old way of requiring all files manually. Not recommended.
require_once( 'API.php' );
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

The response of this PHP wrapper is custom-built. At the moment, it always returns a PHP Array. This array has the `status` of your action and an appropriate `message` in the response.

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

<br>

[![📝](https://raw.githubusercontent.com/ahmadawais/stuff/master/images/git/log.png)](changelog.md)

## Changelog

[❯ Read the changelog here →](changelog.md)

<br>

<small>**KEY**: `📦 NEW`, `👌 IMPROVE`, `🐛 FIX`, `📖 DOC`, `🚀 RELEASE`, and `✅ TEST`

> _I use [Emoji-log](https://github.com/ahmadawais/Emoji-Log), you should try it and simplify your git commits._

</small>

<br>

[![📃](https://raw.githubusercontent.com/ahmadawais/stuff/master/images/git/license.png)](./../../)

## License & Conduct

- MIT © [Ahmad Awais](https://twitter.com/MrAhmadAwais/)
- [Code of Conduct](code-of-conduct.md)
- Props to Jacob Bennett for his initial work on the lib.
- Requires at least PHP 5.3.0 (otherwise remove the namespaces).

<br>

[![🙌](https://raw.githubusercontent.com/ahmadawais/stuff/master/images/git/connect.png)](./../../)

## Connect

<div align="left">
    <p><a href="https://github.com/ahmadawais"><img alt="GitHub @AhmadAwais" align="center" src="https://img.shields.io/badge/GITHUB-gray.svg?colorB=6cc644&style=flat" /></a>&nbsp;<small><strong>(follow)</strong> To stay up to date on free & open-source software</small></p>
    <p><a href="https://twitter.com/MrAhmadAwais/"><img alt="Twitter @MrAhmadAwais" align="center" src="https://img.shields.io/badge/TWITTER-gray.svg?colorB=1da1f2&style=flat" /></a>&nbsp;<small><strong>(follow)</strong> To get #OneDevMinute daily hot tips & trolls</small></p>
    <p><a href="https://www.youtube.com/AhmadAwais"><img alt="YouTube AhmadAwais" align="center" src="https://img.shields.io/badge/YOUTUBE-gray.svg?colorB=ff0000&style=flat" /></a>&nbsp;<small><strong>(subscribe)</strong> To tech talks & #OneDevMinute videos</small></p>
    <p><a href="https://AhmadAwais.com/"><img alt="Blog: AhmadAwais.com" align="center" src="https://img.shields.io/badge/MY%20BLOG-gray.svg?colorB=4D2AFF&style=flat" /></a>&nbsp;<small><strong>(read)</strong> In-depth & long form technical articles</small></p>
    <p><a href="https://www.linkedin.com/in/MrAhmadAwais/"><img alt="LinkedIn @MrAhmadAwais" align="center" src="https://img.shields.io/badge/LINKEDIN-gray.svg?colorB=0077b5&style=flat" /></a>&nbsp;<small><strong>(connect)</strong> On the LinkedIn profile y'all</small></p>
</div>

<br>

[![👌](https://raw.githubusercontent.com/ahmadawais/stuff/master/images/git/sponsor.png)](./../../)

## Sponsor

Me ([Ahmad Awais](https://twitter.com/mrahmadawais/)) and my incredible wife ([Maedah Batool](https://twitter.com/MaedahBatool/)) are two engineers who fell in love with open source and then with each other. You can read more [about me here](https://ahmadawais.com/about). If you or your company use any of my projects or like what I’m doing then consider backing me. I'm in this for the long run. An open-source developer advocate.

[![Ahmad on Twitter](https://img.shields.io/twitter/follow/mrahmadawais.svg?style=social&label=Follow%20@MrAhmadAwais)](https://twitter.com/mrahmadawais/)

[![Ahmad on Twitter](https://raw.githubusercontent.com/ahmadawais/stuff/master/sponsor/sponsor.jpg)](https://github.com/AhmadAwais/sponsor)
