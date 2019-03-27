<?php

namespace rdoepner\CleverReach;

use Exception;
use rdoepner\CleverReach\Http\AdapterInterface as HttpAdapter;

class ApiManager implements ApiManagerInterface
{
    const MAILING_STATE_ALL = "all";
    const MAILING_STATE_FINISHED = "finished";
    const MAILING_STATE_DRAFT = "draft";
    const MAILING_STATE_WAITING = "waiting";
    const MAILING_STATE_RUNNING = "running";

    const MAILING_STATES = [
        self::MAILING_STATE_ALL,
        self::MAILING_STATE_FINISHED,
        self::MAILING_STATE_DRAFT,
        self::MAILING_STATE_WAITING,
        self::MAILING_STATE_RUNNING,
    ];

    /**
     * @var HttpAdapter
     */
    protected $adapter;

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
    )
    {
        $now = time();

        return $this->adapter->action(
            'post',
            "/v3/groups.json/{$groupId}/receivers",
            [
                'email'             => $email,
                'registered'        => $now,
                'activated'         => $active ? $now : 0,
                'attributes'        => $attributes,
                'global_attributes' => $globalAttributes,
            ]
        );
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
                'email'   => $email,
                'doidata' => array_merge(
                    [
                        'user_ip'    => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                        'referer'    => $_SERVER['HTTP_REFERER'] ?? 'http://localhost',
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
                'email'   => $email,
                'doidata' => array_merge(
                    [
                        'user_ip'    => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                        'referer'    => $_SERVER['HTTP_REFERER'] ?? 'http://localhost',
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

    /** @inheritdoc
     * @throws Exception
     */
    public function getMailings(int $limit = 0, string $state = "all", string $channel_id = "", int $start = 0, int $end = 0)
    {
        if (!in_array($state, self::MAILING_STATES)) throw new Exception("Invalid state requested.");

        $url = "/v3/mailings.json/";
        $params = [
            "state" => $state,
        ];

        if ($limit > 0) $params["limit"] = $limit;
        if ($channel_id) $params["channel_id"] = $channel_id;
        if ($end > 0) {
            $params["start"] = $start;
            $params["end"] = $end;
        }

        $data = $this->adapter->action('get', $url, $params);

        if(!empty($data['error'])) throw new Exception($data["error"]["message"], $data["error"]["code"]);

        if ($state == self::MAILING_STATE_ALL) return $data;

        return $data[$state];
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function getMailing(string $id)
    {
        $data = $this->adapter->action('get', "/v3/mailings.json/{$id}");
        if(!empty($data['error'])) throw new Exception($data["error"]["message"], $data["error"]["code"]);

        return $data;
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function getMailingLinks(string $id)
    {
        $data = $this->adapter->action('get', "/v3/mailings.json/{$id}/links");
        if(!empty($data['error'])) throw new Exception($data["error"]["message"], $data["error"]["code"]);

        return $data;
    }

    /** @inheritdoc
     * @throws Exception
     */
    public function getMailingOrders(string $id)
    {
        $data = $this->adapter->action('get', "/v3/mailings.json/{$id}/orders");
        if(!empty($data['error'])) throw new Exception($data["error"]["message"], $data["error"]["code"]);

        return $data;
    }

    /** @inheritdoc
     * @throws Exception
     */
    public function getMailingChannels()
    {
        $data = $this->adapter->action("get", "/v3/mailings/channel.json");
        if(!empty($data['error'])) throw new Exception($data["error"]["message"], $data["error"]["code"]);

        return $data;
    }

    /** @inheritdoc
     * @throws Exception
     */
    public function getMailingChannel(string $id)
    {
        $data = $this->adapter->action("get", "/v3/mailings/channel.json/{$id}");
        if(!empty($data['error'])) throw new Exception($data["error"]["message"], $data["error"]["code"]);

        return $data;
    }
}
