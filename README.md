![Sendy PHP API Wrapper](https://i.imgur.com/FylVZzy.png)

---

# Sendy PHP API Wrapper
🚀 Sendy PHP API Wrapper: Complete API interfacing.

## API Wrapper For Sendy API
With this `Sendy PHP API Wrapper` you can do the following:

**SUBSCRIBERS**
- Subscribe.
- Unsubscribe.
- Delete subscriber.
- Subscription status.

**LISTS**
- Active subscriber count.

**CAMPAIGNS**
- Create.

## Get Started!
Getting started is easy. Here's how you do it. You can check the example.php file as well.

## Download ⚡️
Obviously, you'll have to download the wrapper to your current setup. Several ways to do that.

- Download the library [class-sendy-php-api.php](https://github.com/ahmadawais/Sendy-PHP-API/blob/master/src/class-sendy-php-api.php)
`curl -O https://git.io/vyFbs`

- Composer Install
`composer require ahmadawais/sendy-php-api`

#### Step 0. Define SENDY_API.
```php
// Define the global var to avoid direct access to the library class.
define( 'Sendy_PHP_API_Wrapper', TRUE );
```

#### Step 1. Require the wrapper.
```php
require_once( 'class-sendy-php-api.php' );
```

#### Step 2. Configure it.
```php
$config = array(
    'installation_url' => 'http://send.yourdomain.com',  // Your Sendy installation URL (without trailing slash).
    'api_key'          => 'XXXXXXXXXXXXXXXXXXXXXXXXXX', // Your API key. Aavailable in Sendy Settings.
    'list_id'          => 'XXXXXXXXXXXXXXXXXXXXXXXXXX',
);
```

#### Step 3. Init.
```php
$sendy = new \SENDY\Sendy_PHP_API( $config );
```

## API KEY METHODS.
### Method #1: Subscribe.
```php
// Method #1: Subscribe.
$result_array = $sendy->subscribe( array(
    'name'   => 'Name',
    'email'  => 'your@email.com', // This is the only field required by sendy.
    'custom' => 'field' // You can custom fields as well.
));
```

### Method #2: Unsubscribe.
```php
// Method #2: Unsubscribe.
$result_array = $sendy->unsubscribe( 'your@email.com' );
```

### Method #3: Subscriber Status.
```php
// Method #3: Subscriber Status.
$result_array = $sendy->substatus( 'your@email.com' );
```

### Method #4: Delete Subscriber.
```php
// Method #4: Delete Subscriber.
$result_array = $sendy->delete( 'your@email.com' );
```

### Method #5: Subscriber Count of a list.
```php
// Method #5: Subscriber Count of a list.
$result_array = $sendy->subcount();
```

### Method #6: Campaign — Draft And/Or Send as well.
```php
// Method #6: Campaign — Draft And/Or Send as well.
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
```

### Method #7: Set List ID.
```php
// Method #7: Change the `list_id` you are referring to at any point.
$sendy->set_list_id( "XXXXXXX" );
```

### Method #8: Get List ID.
```php
// Method #7: Get the `list_id` you are referring to at any point.
$sendy->get_list_id( "XXXXXXX" );
```

## Response
The response of this PHP wrapper is custom built. At the moment, it always returns a PHP Array. This array has the `status` of your action and an appropriate `message` in the response. 

- `status` is either `true` or `false`.
- `message` is based on the type of action being performed

```php
    // E.g. SUCCESS response.
    array(
        'status'  => true,
        'message' => 'Already Subscribed'
    )
    
    // E.g. FAIL response.
    array(
        'status'  => false,
        'message' => 'Some fields are missing.'
    )
```


## Changelog

### Version 1.0.0 2017-03-20
- First version
- Basic methods for all API routes.

## License & Credits
The code is licensed under MIT and a huge props to Jacob Bennett for his initial work on the lib.
Requires at least PHP 5.3.0 (otherwise remove the namespace).