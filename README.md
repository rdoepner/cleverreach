# CleverReach REST API v3 client

This library makes it easy to interact with the CleverReach REST API v3.

_Forked from https://github.com/rdoepner/cleverreach. Moved to own namespace, because pull requests weren't merged nor any other reaction from author._

## Installation

```bash
composer require markuszeller/cleverreach
```

## Usage

**Get an access token**

```php
use markuszeller\CleverReach\ApiManager;
use markuszeller\CleverReach\Http\Guzzle as HttpAdapter;

// Create an HTTP adapter
$httpAdapter = new HttpAdapter();

// Authorize your app by credentials
$response = $httpAdapter->authorize('<CLIENT_ID>', '<CLIENT_SECRET>');

if (isset($response['access_token'])) {
    // Persist the access token for later use...
}
```

**Initialize an API manager**

```php
use markuszeller\CleverReach\ApiManager;
use markuszeller\CleverReach\Http\Guzzle as HttpAdapter;

// Create an HTTP adapter
$httpAdapter = new HttpAdapter(
    [
        'access_token' => '<ACCESS_TOKEN>',
    ]
);

// Create the API manager
$apiManager = new ApiManager($httpAdapter);
```

**Create an inactive subscriber**

```php
$response = $apiManager->createSubscriber(
    '<EMAIL>',
    '<GROUP_ID>',
    false, // not activated
    [
        'salutation' => 'Mr.',
        'firstname' => 'John',
        'lastname' => 'Doe',
    ]
);

if (isset($response['id'])) {
    // ...
}
```

**Trigger Double-Opt-In email for an inactive subscriber**

```php
$response = $apiManager->triggerDoubleOptInEmail('<EMAIL>', '<FORM_ID>');

if (isset($response['success'])) {
    // ...
}
```

**Trigger Double-Opt-Out email for an active subscriber**

```php
$response = $apiManager->triggerDoubleOptOutEmail('<EMAIL>', '<FORM_ID>');

if (isset($response['success'])) {
    // ...
}
```

**Get subscriber**

```php
$response = $apiManager->getSubscriber('<EMAIL>', '<GROUP_ID>');

if (isset($response['id'])) {
    // ...
}
```

**Set active status of a subscriber**

```php
$response = $apiManager->getSubscriber('<EMAIL>', '<GROUP_ID>', '<TRUE_OR_FALSE>');

if (true === $response) {
    // ...
}
```

**Delete subscriber**

```php
$response = $apiManager->deleteSubscriber('<EMAIL>', '<GROUP_ID>');

if (true === $response) {
    // ...
}
```

**Examples for reading Mailings**
```php
// Get a list of all Mailings
// You can provide a state, i.e. draft
$mailings = $apiManager->getMailings(0, ApiManager::MAILING_STATE_DRAFT);

// Get a specific Mailing
// returns a Mailing Object
$mailing = $apiManager->getMailing(MAILING_ID);

// Get Specific Mailing details
$mailingLinks = $apiManager->getMailingLinks(MAILING_ID);
$mailingOrders = $apiManager->getMailingOrders(MAILING_ID);
$mailingChannels = $apiManager->getMailingChannels();
$mailingChannel = $apiManager->getMailingChannel(CHANNEL_ID);
```

**Update a Mailing**
```php
// Read one for updating
$mailing = $apiManager->getMailing(MAILING_ID);

// Create a fresh Mailing and Content instance with no data
$updatedMailing = new Mailing(MAILING_ID);
$content = new MailingContent();

// Get HTML content from "old"
$html = $mailingData->getContent()->getHtml();

// Inject a update message after body tag
$date = date(DATE_W3C);
$html = preg_replace("/(<body.*?>)/", "\$1\n<div>Automated update at {$date}</div>", $html);

// Place into Content entity and update Mailings content
$content->setHtml($html);
$updatedMailing->setContent($content);

// Update request (PUT)
$apiManager->updateMailing($updatedMailing);
```
