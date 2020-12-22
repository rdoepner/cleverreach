# CleverReach REST API v3 client

This library makes it easy to interact with the CleverReach REST API v3.

## Installation

```bash
composer require rdoepner/cleverreach
```

## Usage

**Get an access token**

```php
use rdoepner\CleverReach\ApiManager;
use rdoepner\CleverReach\Http\Guzzle as HttpAdapter;

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
use rdoepner\CleverReach\ApiManager;
use rdoepner\CleverReach\Http\Guzzle as HttpAdapter;

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

**Trigger the Double-Opt-In email for an inactive subscriber**

```php
$response = $apiManager->triggerDoubleOptInEmail('<EMAIL>', '<FORM_ID>');

if (isset($response['success'])) {
    // ...
}
```

**Trigger the Double-Opt-Out email for an active subscriber**

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

**Sets the active status of a subscriber**

```php
$response = $apiManager->setSubscriberStatus('<EMAIL>', '<GROUP_ID>', '<TRUE_OR_FALSE>');

if (true === $response) {
    // ...
}
```

**Delete a subscriber**

```php
$response = $apiManager->deleteSubscriber('<EMAIL>', '<GROUP_ID>');

if (true === $response) {
    // ...
}
```

**Get attributes**

```php
$response = $apiManager->getAttributes('<GROUP_ID>');

if (true === $response) {
    // ...
}
```

**Update the attributes of a subscriber**

```php
$response = $apiManager->updateSubscriberAttributes('<POOL_ID>', '<ATTRIBUTE_ID>', '<VALUE>');

if (true === $response) {
    // ...
}
```

**Replace the tags of a subscriber**

```php
$response = $apiManager->replaceSubscriberTags('<EMAIL>', '<GROUP_ID>', ['<TAG1>', '<TAG2>', ...]);

if (true === $response) {
    // ...
}
```
