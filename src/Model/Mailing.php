<?php

namespace rdoepner\CleverReach\Model;

class Mailing extends TrackableChanges
{
    protected $id;
    protected $name;
    protected $subject;
    protected $sender_name;
    protected $sender_email;
    protected $content;
    protected $receivers;
    protected $settings;

    protected $trackChanges = [];

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Mailing
     */
    public function setId(string $id)
    {
        $this->trackChanges[] = "id";

        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Mailing
     */
    public function setName(string $name)
    {
        $this->trackChanges[] = "name";

        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return Mailing
     */
    public function setSubject(string $subject)
    {
        $this->trackChanges[] = "subject";

        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getSenderName(): string
    {
        return $this->sender_name;
    }

    /**
     * @param string $sender_name
     * @return Mailing
     */
    public function setSenderName(string $sender_name)
    {
        $this->trackChanges[] = "sender_name";

        $this->sender_name = $sender_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSenderEmail(): string
    {
        return $this->sender_email;
    }

    /**
     * @param string $sender_email
     * @return Mailing
     */
    public function setSenderEmail(string $sender_email)
    {
        $this->trackChanges[] = "sender_email";

        $this->sender_email = $sender_email;
        return $this;
    }

    /**
     * @return MailingContent
     */
    public function getContent(): MailingContent
    {
        return $this->content;
    }

    /**
     * @param MailingContent $content
     * @return Mailing
     */
    public function setContent(MailingContent $content)
    {
        $this->trackChanges[] = "content";

        $this->content = $content;
        return $this;
    }

    /**
     * @return MailingReceivers
     */
    public function getReceivers(): MailingReceivers
    {
        return $this->receivers;
    }

    /**
     * @param MailingReceivers $receivers
     * @return Mailing
     */
    public function setReceivers(MailingReceivers $receivers)
    {
        $this->trackChanges[] = "receivers";

        $this->receivers = $receivers;
        return $this;
    }

    /**
     * @return MailingSettings
     */
    public function getSettings(): MailingSettings
    {
        return $this->settings;
    }

    /**
     * @param MailingSettings $settings
     * @return Mailing
     */
    public function setSettings(MailingSettings $settings)
    {
        $this->trackChanges[] = "settings";

        $this->settings = $settings;
        return $this;
    }
}
