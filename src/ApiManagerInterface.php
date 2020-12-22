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
     * Get attributes.
     *
     * @param int    $groupId
     *
     * @return mixed
     */
    public function getAttributes(int $groupId);

    /**
     * Update the attributes of a subscriber.
     *
     * @param int    $poolId
     * @param int    $attributeId
     * @param string $value
     *
     * @return mixed
     */
    public function updateSubscriberAttributes(int $poolId, int $attributeId, string $value);

    /**
     * Replace the tags of a subscriber.
     *
     * The new tags replace the existing ones! Use getSubscriber() to retrieve
     * existing tags before.
     *
     * @param string $email
     * @param int    $groupId
     * @param array  $tags
     *
     * @return mixed
     */
    public function replaceSubscriberTags(string $email, int $groupId, array $tags);
}
