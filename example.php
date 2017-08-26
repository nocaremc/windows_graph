<?php namespace nocare\windows_graph;

require "vendor/autoload.php";

/************************
    Before a new app can use this the 365 admin must consent
    https://login.microsoftonline.com/common/adminconsent?client_id=client_id&redirect_uri=https://example.com/redirect
*/
$client_id = '';
$client_secret = '';
$user_id = '';
$tenant_id = '';
$search_subject = '';
$client = new MSClient($client_id, $client_secret, $tenant_id, $user_id);
$client->init();

// Get list of emails from this user id 
$emails = $client->getUserMessageIds($search_subject);

// We should only care about the latest email
if($emails instanceof EmailList) {
    $latest_email = $emails->getLatestEmail();
    $attachments = $client->getUserMessageAttachments($latest_email->id);
    
    // Save the attachment
    $first_file = $attachments->value[0];
    $file_uri = $first_file->saveLocal();
    echo $file_uri;
} else { 
    exit('no emails');
}