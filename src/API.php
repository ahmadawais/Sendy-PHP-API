<?php
/**
 * Sendy PHP API Wrapper
 *
 * Sendy's API is not RESTful so having this wrapper is great.
 *
 * @version 6.0.0
 * @package Sendy
 * @since 1.0.0
 */

namespace AhmadAwais\Sendy;

use GuzzleHttp\Client;
use Exception;

// Helps with the CORS issues.
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Credentials: true');

/**
 * API Class.
 *
 * Sendy PHP API Class.
 *
 * @since 1.0.0
 */
class API
{
    /**
     * Console Log.
     *
     * Log the response to console for better readability.
     *
     * @param Mixed  $data Any data.
     * @param String $context Context.
     * @since 1.0.0
     */
    public static function it($data, $context = 'LOGGED: ')
    {
        header('Content-Type: text/html');
        ob_start();
        $output  = "console.log('%c $context ', 'background: #bada55; color: #222; padding: 10px;');";
        $output .= 'console.log(' . json_encode($data) . ');';
        $output  = sprintf('<script>%s</script>', $output);
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
     * @throws \Exception Without config params.
     * @since  1.0.0
     */
    public function __construct(array $config)
    {
        $this->sendyUrl = isset($config['sendyUrl']) ? $config['sendyUrl'] : false;
        $this->apiKey   = isset($config['apiKey']) ? $config['apiKey'] : false;
        $this->listId   = isset($config['listId']) ? $config['listId'] : false;

        // Bail if empty.
        if (empty($this->sendyUrl) || empty($this->apiKey) || empty($this->listId)) {
            throw new \Exception('Required config parameters [sendyUrl, listId, apiKey] is not set or empty', 1);
        }
    }

    /**
     * Set List ID.
     *
     * @param String $listId List ID.
     * @throws \Exception On missing List ID.
     * @since  1.0.0
     */
    public function setListId($listId)
    {
        // Bail if empty.
        if (empty($listId)) {
            throw new \Exception('Required config parameter [listId] is not set', 1);
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
    public function getListId()
    {
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
    private function response($status = false, $msg = 'Something went wrong!')
    {
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
    public function subscribe(array $values)
    {
        // Route.
        $route = 'subscribe';

        // Send the subscribe command.
        $apiResponse = strval($this->query($route, $values));

        // Handle API Responses.
        switch ($apiResponse) {
            case 'true':
            case '1':
                return $this->response(true, 'Subscribed!');

            case 'Already subscribed.':
                return $this->response(true, 'Already subscribed!');

            default:
                return $this->response(false, $apiResponse);
        }
    }

    /**
     * Unsubscribe.
     *
     * @param  String $email Email ID.
     * @return Array
     * @since  1.0.0
     */
    public function unsubscribe($email)
    {
        // Route.
        $route = 'unsubscribe';

        // Send the unsubscribe.
        $apiResponse = strval($this->query($route, [ 'email' => $email ]));

        // Handle API Responses.
        switch ($apiResponse) {
            case 'true':
            case '1':
                return $this->response(true, 'Unsubscribed!');

            default:
                return $this->response(false, $apiResponse);
        }
    }

    /**
     * Subscriber Status.
     *
     * @param  String $email Email ID.
     * @return Array
     * @since  1.0.0
     */
    public function subStatus($email)
    {
        // Route.
        $route = 'api/subscribers/subscription-status.php';

        // Send the request for status.
        $apiResponse = $this->query(
            $route,
            [
                'email'   => $email,
                'list_id' => $this->listId,
            ]
        );

        // Handle the API Responses.
        switch ($apiResponse) {
            case 'Subscribed!':
            case 'Subscribed':
            case 'Unsubscribed':
            case 'Unconfirmed':
            case 'Bounced':
            case 'Soft bounced':
            case 'Complained':
                return $this->response(true, $apiResponse);

            default:
                return $this->response(false, $apiResponse);
        }
    }

    /**
     * Delete Subscriber.
     *
     * @param String $email Email.
     * @return Array
     * @since  1.0.0
     */
    public function delete($email)
    {
        // Route.
        $route = 'api/subscribers/delete.php';

        // Send the delete subscriber.
        $apiResponse = strval(
            $this->query(
                $route,
                [
                    'email'   => $email,
                    'list_id' => $this->listId,
                ]
            )
        );

        // Handle the API Responses.
        switch ($apiResponse) {
            case 'true':
            case '1':
                return $this->response(true, 'Deleted!');

            default:
                return $this->response(false, $apiResponse);

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
    public function subCount($list = '')
    {
        // Route.
        $route = 'api/subscribers/active-subscriber-count.php';

        // If a list is passed in use it, otherwise use $this->listId.
        if (empty($list)) {
            $list = $this->listId;
        }

        // Handle exceptions.
        if (empty($list)) {
            throw new \Exception("Method [subCount] requires parameter [list] or [$this->listId] to be set.", 1);
        }

        // Send request for subCount.
        $apiResponse = $this->query(
            $route,
            [
                'list_id' => $list,
            ]
        );

        // Handle the API Responses.
        if (is_numeric($apiResponse)) {
            return $this->response(true, $apiResponse);
        }

        // Error.
        return $this->response(false, $apiResponse);
    }

    /**
     * Create a campaign.
     *
     * @param  Array $values Values.
     * @return Array
     * @since  1.0.0
     */
    public function campaign(array $values)
    {
        // Route.
        $route = 'api/campaigns/create.php';

        // Send request for campaign.
        $apiResponse = $this->query($route, $values);

        // Handle the API Responses.
        switch ($apiResponse) {
            case 'Campaign created':
            case 'Campaign created and now sending':
                return $this->response(true, $apiResponse);

            default:
                return $this->response(false, $apiResponse);
        }
    }

    /**
     * Query.
     *
     * Build and Send the query via CURL.
     *
     * @param  String $route API Route.
     * @param  Array  $values Parameters.
     * @throws \Exception On missing params.
     * @return String
     * @since  1.0.0
     */
    private function query($route, array $values)
    {
        // Bail if empty.
        if (empty($route) || empty($values)) {
            throw new \Exception('Required config parameter [route, values] is not set or empty', 1);
        }

        // Global options for return.
        $returnOptions = array(
            'api_key' => $this->apiKey,
            'list'    => $this->listId,
            'boolean' => 'true',
        );

        // Merge $values with the global options $returnOptions (overwrites default $values).
        $content = array_merge($values, $returnOptions);

        // URL to send POST to.
        $postUrl = $this->sendyUrl . '/' . $route;

        // Send POST.
        $client = new Client();
        $response = $client->request('POST', $postUrl, [
            'form_params' => $content
        ]);
        $apiResponse = (string) $response->getBody();


        // API apiResponse.
        return $apiResponse;
    }
}
