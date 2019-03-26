<?php

namespace rdoepner\CleverReach;

interface ApiManagerInterface
{
    /**
     * Creates a subscriber.
     *
     * @param string $email
     * @param int    $groupId
     * @param bool   $active
     * @param array  $attributes
     * @param array  $globalAttributes
     *
     * @return mixed
     */
    public function createSubscriber(
        string $email,
        int $groupId,
        bool $active = false,
        array $attributes = [],
        array $globalAttributes = []
    );

    /**
     * Returns a subscriber.
     *
     * @param string   $email
     * @param int|null $groupId
     *
     * @return mixed
     */
    public function getSubscriber(string $email, int $groupId = null);

    /**
     * Sets the active status of a subscriber.
     *
     * @param string $email
     * @param int    $groupId
     * @param bool   $active
     *
     * @return mixed
     */
    public function setSubscriberStatus(string $email, int $groupId, $active = true);

    /**
     * Triggers the Double-Opt-In email for a subscriber.
     *
     * @param string $email
     * @param int    $formId
     * @param array  $options
     *
     * @return mixed
     */
    public function triggerDoubleOptInEmail(string $email, int $formId, array $options = []);

    /**
     * Triggers the Double-Opt-Out email for a subscriber.
     *
     * @param string $email
     * @param int    $formId
     * @param array  $options
     *
     * @return mixed
     */
    public function triggerDoubleOptOutEmail(string $email, int $formId, array $options = []);

    /**
     * Deletes a subscriber.
     *
     * @param string $email
     * @param int    $groupId
     *
     * @return mixed
     */
    public function deleteSubscriber(string $email, int $groupId);


    /**
     * Get list of mailings
     *
     * @param int $limit
     * @param string $state
     * @param string $channel_id
     * @param int $start
     * @param int $end
     * @return mixed
     */
    public function getMailings(int $limit = 25, string $state = "all", string $channel_id = "", int $start = 0, int $end = 0);

    /**
     * Get a specific mailing
     *
     * @param string $id
     * @return mixed
     */
    public function getMailing(string $id);

    /**
     * Get links for a specific mailing
     *
     * @param string $id
     * @return mixed
     */
    public function getMailingLinks(string $id);

    /**
     * Get orders for a specific mailing
     *
     * @param string $id
     * @return mixed
     */
    public function getMailingOrders(string $id);
}
