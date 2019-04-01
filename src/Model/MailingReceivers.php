<?php


namespace rdoepner\CleverReach\Model;

class MailingReceivers extends TrackableChanges
{
    protected $groups;
    protected $filter;

    protected $trackChanges = [];

    /**
     * @return array
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * @param array $groups
     * @return MailingReceivers
     */
    public function setGroups(array $groups = [])
    {
        $this->trackChanges[] = "groups";
        $this->groups = $groups;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilter(): string
    {
        return $this->filter;
    }

    /**
     * @param string $filter
     * @return MailingReceivers
     */
    public function setFilter(string $filter)
    {
        $this->trackChanges[] = "filter";
        $this->filter = $filter;

        return $this;
    }
}
