<?php


namespace rdoepner\CleverReach\Model;

class MailingSettings extends TrackableChanges
{
    protected $editor;
    protected $open_tracking;
    protected $click_tracking;
    protected $link_tracking_url;
    protected $link_tracking_type;
    protected $unsubscribe_form_id;
    protected $campaign_id;
    protected $category_id;

    protected $trackChanges = [];

    public const EDITOR_ADVANCED = "advanced";
    public const EDITOR_WIZARD = "wizard";
    public const EDITOR_FREEFORM = "freeform";
    public const EDITOR_PLAINTEXT = "plaintext";

    /**
     * @return string
     */
    public function getEditor(): string
    {
        return $this->editor;
    }

    /**
     * @param string $editor
     * @return MailingSettings
     */
    public function setEditor(string $editor = self::EDITOR_ADVANCED)
    {
        $this->trackChanges[] = "editor";

        switch ($editor) {
            case self::EDITOR_ADVANCED:
            case self::EDITOR_WIZARD:
            case self::EDITOR_FREEFORM:
            case self::EDITOR_PLAINTEXT:
                $this->editor = $editor;
                break;
            default:
                $this->editor = self::EDITOR_ADVANCED;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function getOpenTracking(): bool
    {
        return $this->open_tracking;
    }

    /**
     * @param bool $open_tracking
     * @return MailingSettings
     */
    public function setOpenTracking(bool $open_tracking = true)
    {
        $this->trackChanges[] = "open_tracking";

        $this->open_tracking = $open_tracking;
        return $this;
    }

    /**
     * @return bool
     */
    public function getClickTracking(): bool
    {
        return $this->click_tracking;
    }

    /**
     * @param bool $click_tracking
     * @return MailingSettings
     */
    public function setClickTracking(bool $click_tracking = true)
    {
        $this->trackChanges[] = "click_tracking";

        $this->click_tracking = $click_tracking;
        return $this;
    }

    /**
     * @return string
     */
    public function getLinkTrackingUrl(): string
    {
        return $this->link_tracking_url;
    }

    /**
     * @param string $link_tracking_url
     * @return MailingSettings
     */
    public function setLinkTrackingUrl(string $link_tracking_url)
    {
        $this->trackChanges[] = "link_tracking_url";

        $this->link_tracking_url = $link_tracking_url;
        return $this;
    }

    /**
     * @return string
     */
    public function getLinkTrackingType(): string
    {
        return $this->link_tracking_type;
    }

    /**
     * @param string $link_tracking_type
     * @return MailingSettings
     */
    public function setLinkTrackingType(string $link_tracking_type)
    {
        $this->trackChanges[] = "link_tracking_type";

        $this->link_tracking_type = $link_tracking_type;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnsubscribeFormId(): string
    {
        return $this->unsubscribe_form_id;
    }

    /**
     * @param string $unsubscribe_form_id
     * @return MailingSettings
     */
    public function setUnsubscribeFormId(string $unsubscribe_form_id)
    {
        $this->trackChanges[] = "unsubscribe_form_id";

        $this->unsubscribe_form_id = $unsubscribe_form_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCampaignId(): string
    {
        return $this->campaign_id;
    }

    /**
     * @param string $campaign_id
     * @return MailingSettings
     */
    public function setCampaignId(string $campaign_id)
    {
        $this->trackChanges[] = "campaign_id";

        $this->campaign_id = $campaign_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategoryId(): string
    {
        return $this->category_id;
    }

    /**
     * @param string $category_id
     * @return MailingSettings
     */
    public function setCategoryId(string $category_id)
    {
        $this->trackChanges[] = "category_id";

        $this->category_id = $category_id;
        return $this;
    }
}
