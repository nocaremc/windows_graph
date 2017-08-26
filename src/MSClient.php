<?php namespace nocare\windows_graph;

use ReflectionException;
use \GuzzleHttp\Client;
use JsonMapper;
use nocare\windows_graph\EmailList;

/**
*  MSClient
*
*  Uses configuration data to authenticate and interact with microsoft's graph api.
*
*  @author Joshua Rodarte
*/
class MSClient extends Client {
    
    /**  @var string $token Client Credentials token generated in getClientCredentialsToken */
    private $token;
    
    /**  @var string $client_id Microsoft Graph App ID */
    private $client_id;

    /**  @var string $client_secret Microsoft Graph App Secret (Generate one) */
    private $client_secret;

    /**  @var string $user_id This library currently works with a single specified 365 user */
    private $user_id;

    /**  @var string $tenant_id This app requires a 365 admin to authorize it.
    *  You'll find a tenant id in the return url during authorization.
    */
    private $tenant_id;
    
    public function __construct($client_id, $client_secret, $tenant_id, $user_id) {
        
        parent::__construct();
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->tenant_id = $tenant_id;
        $this->user_id = $user_id;
    }

    /**
    * init
    *
    * Gets itself a client_credentials token and sets up headers to use it.
    *
    * @return void
    */
    public function init() {
        // Authorize our app with microsoft graph
        $this->token = $this->getClientCredentialsToken();
        // Save authorization token for requests
        $this->headers = [
            'headers' => [
                'Authorization' => $this->token->__toString(),
                'Accept' => 'application/json'
            ]
        ];
    }

    /**
    * getClientCredientialsToken
    *
    * Authorizes with the windows graph and a client_credentials grant
    *
    * @throws Exception(fishtacos) Failed to authenticate or something
    *
    * @return nocare\windows_graph\Token client_credentials token
    */
    private function getClientCredentialsToken() {

        $url = "https://login.microsoftonline.com/{$this->tenant_id}/oauth2/v2.0/token";
        $options = [
            'form_params' => [
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'scope' => 'https://graph.microsoft.com/.default',
                'grant_type' => 'client_credentials'
            ]
        ];

        try {

            $res = $this->post($url, $options);
        } catch(Exception $e) {

            var_dump($e->getResponse()->getbody()->getcontents());
        }

        $data = $res->getBody()->getContents();
        $mapper = new JsonMapper();
        $object = $mapper->map(json_decode($data), new Token());

        return $object;
    }

    /**
    * getUserMessageIds
    *
    * Fetches the user's messages.
    * As I only needed message ids and certain subjecs to target attachments,
    * message data will be incomplete
    *
    * @throws ReflectionException
    *
    * @return EmailList List of users emails
    */
    public function getUserMessageIds($search_subject) {

        $url = "https://graph.microsoft.com/v1.0/users/{$this->user_id}/messages";
        $res = null;

        try {

            $res = $this->get($url, $this->headers);

        } catch(\Exception $e) {

            var_dump($e->getResponse()->getbody()->getcontents());
        }

        $data = $res->getBody()->getContents();
        $mapper = new JsonMapper();

      //  try {
            $data = json_decode($data);
            $data->search_subject = $search_subject;
            $object = $mapper->map($data, new EmailList());
            $object->init();

            return $object;

    //    } catch(ReflectionException $e) {

  //          var_dump("MSClient::getUserMessageIds[128]: " . $e->getMessage());
//        }

        return [];
    }

    /**
    * getUserMessageAttachments
    *
    * Gets a list of attachments on an email
    *
    * @param string $email_id ID of an email
    *
    * @return AttachmentList List of attachments
    */
    public function getUserMessageAttachments($email_id) {

        $url = "https://graph.microsoft.com/v1.0/users/{$this->user_id}/messages/{$email_id}/attachments";
        $res = null;

        try {
            
            $res = $this->get($url, $this->headers);
        } catch(Exception $e) {
            
            var_dump($e->getResponse()->getbody()->getcontents());
        }

        $data = $res->getBody()->getContents();
        $mapper = new JsonMapper();
        $object = $mapper->map(json_decode($data), new AttachmentList());
        $object->init();

        return $object;
    }

    /**
    * getUsers
    *
    * Return a list of users this app has access to
    *
    * @return UserList List of users
    */
    /*
    public function getUsers() {
        
        $object = null;

        try {

            $response = $this->get('https://graph.microsoft.com/v1.0/users', $this->headers);
            $data = $response->getBody()->getContents();
            $mapper = new JsonMapper();
            //$object = $mapper->map(json_decode($data), new Token());
        } catch (Exception $e) {

            var_dump($e->getResponse()->getbody()->getcontents());
        }

        return $object;
    }
    incomplete
    */
}