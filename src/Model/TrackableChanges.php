<?php


namespace rdoepner\CleverReach\Model;

use JsonSerializable;

class TrackableChanges implements JsonSerializable
{
    protected $trackChanges = [];

    public function jsonSerialize()
    {
        $return = [];
        foreach (array_unique($this->trackChanges) as $key) {
            $return[$key] = $this->{$key};
        }
        return $return;
    }
}
