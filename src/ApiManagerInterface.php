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
     * Get Attributes.
     *
     * @param int    $groupId
     *
     * @return mixed
     */
    public function getAttributes(int $groupId = 0);

    /**
     * Get Attributes.
     *
     * @param int    $poolId - subscriber id
     * @param int    $attributeId - attribute id
     * @param string $value - attribute value
     *
     * @return mixed
     */
    public function updateSubscriberAttributes(int $poolId = 0, int $attributeId, string $value);
}
