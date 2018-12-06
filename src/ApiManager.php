<?php

namespace rdoepner\CleverReach;

use rdoepner\CleverReach\Http\AdapterInterface as HttpAdapter;

class ApiManager implements ApiManagerInterface
{
    /**
     * @var HttpAdapter
     */
    protected $adapter;

    /**
     * @var array
     */
    protected $subscriptions = [];

    /**
     * ApiManager constructor.
     *
     * @param HttpAdapter $adapter
     */
    public function __construct(HttpAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * {@inheritdoc}
     */
    public function createSubscriber(
        string $email,
        int $groupId,
        bool $active = false,
        array $attributes = [],
        array $globalAttributes = []
    ) {
        $subscription = $this->buildSubscribtion($email, $groupId, $active = false, $attributes = [], $globalAttributes);

        return $this->adapter->action(
            'post',
            "/v3/groups.json/{$subscription['group']}/receivers",
            $subscription['user']
        );
    }

    /**
     * @inheritDoc
     */
    public function addCreateSubscriber(
        string $email,
        int $groupId,
        bool $active = false,
        array $attributes = [],
        array $globalAttributes = []
    ) {
        $subscription = $this->buildSubscribtion($email, $groupId, $active = false, $attributes = [], $globalAttributes);
        if (!isset($this->subscriptions[$subscription['group']])) {
            $this->subscriptions[$subscription['group']] = [];
        }
        $this->subscriptions[$subscription['group']][] = $subscription['user'];
    }

    /**
     * @inheritDoc
     */
    public function flush()
    {
        foreach ($this->subscriptions as $group => $subscriptions) {
            $response = $this->adapter->action(
                'post',
                "/v3/groups.json/{$group}/receivers/upsert",
                $subscriptions
            );
        }
        $this->subscriptions = [];
        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscriber(string $email, int $groupId = null)
    {
        if ($groupId) {
            return $this->adapter->action('get', "/v3/groups.json/{$groupId}/receivers/{$email}");
        }

        return $this->adapter->action('get', "/v3/receivers.json/{$email}");
    }

    /**
     * {@inheritdoc}
     */
    public function setSubscriberStatus(string $email, int $groupId, $active = true)
    {
        if ($active) {
            return $this->adapter->action('put', "/v3/groups.json/{$groupId}/receivers/{$email}/activate");
        }

        return $this->adapter->action('put', "/v3/groups.json/{$groupId}/receivers/{$email}/deactivate");
    }

    /**
     * {@inheritdoc}
     */
    public function triggerDoubleOptInEmail(string $email, int $formId, array $options = [])
    {
        return $this->adapter->action(
            'post',
            "/v3/forms.json/{$formId}/send/activate",
            [
                'email' => $email,
                'doidata' => array_merge(
                    [
                        'user_ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                        'referer' => $_SERVER['HTTP_REFERER'] ?? 'http://localhost',
                        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'FakeAgent/2.0 (Ubuntu/Linux)',
                    ],
                    $options
                ),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function triggerDoubleOptOutEmail(string $email, int $formId, array $options = [])
    {
        return $this->adapter->action(
            'post',
            "/v3/forms.json/{$formId}/send/deactivate",
            [
                'email' => $email,
                'doidata' => array_merge(
                    [
                        'user_ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                        'referer' => $_SERVER['HTTP_REFERER'] ?? 'http://localhost',
                        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'FakeAgent/2.0 (Ubuntu/Linux)',
                    ],
                    $options
                ),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function deleteSubscriber(string $email, int $groupId)
    {
        return $this->adapter->action('delete', "/v3/groups.json/{$groupId}/receivers/{$email}");
    }

    /**
     * Returns the HTTP adapter.
     *
     * @return HttpAdapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Builds subscription information.
     *
     * @param string $email
     * @param int $groupId
     * @param bool $active
     * @param array $attributes
     * @param array $globalAttributes
     *
     * @return array
     */
    protected function buildSubscribtion(
        string $email,
        int $groupId,
        bool $active = false,
        array $attributes = [],
        array $globalAttributes = []
    ) {
        $now = time();

        return [
            'group' => $groupId,
            'user' => [
                'email' => $email,
                'registered' => $now,
                'activated' => $active ? $now : 0,
                'attributes' => $attributes,
                'global_attributes' => $globalAttributes,
            ]
        ];
    }
}
