<?php
namespace rdoepner\CleverReach\Model;

class MailingContent extends TrackableChanges
{
    protected $type;
    protected $html;
    protected $text;

    public const TYPE_HTML = "html";
    public const TYPE_TEXT = "text";
    public const TYPE_HTML_AND_TEXT = "html/text";

    protected $trackChanges = [];

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return MailingContent
     */
    public function setType(string $type)
    {
        $this->trackChanges[] = "type";
        switch ($type) {
            case self::TYPE_HTML:
            case self::TYPE_TEXT:
            case self::TYPE_HTML_AND_TEXT:
                $this->type = $type;
                break;
            default:
                $this->type = self::TYPE_TEXT;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @param string $html
     * @return MailingContent
     */
    public function setHtml(string $html)
    {
        $this->trackChanges[] = "html";

        $this->html = $html;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return MailingContent
     */
    public function setText(string $text)
    {
        $this->trackChanges[] = "text";

        $this->text = $text;
        return $this;
    }
}
