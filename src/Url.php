<?php

namespace ProlificRohit\Sitemaps;

use Closure;
use XMLWriter;
use ProlificRohit\Sitemaps\Element;

class Url extends Element
{
    const ELEMENT_ROOT = "url";
    const ELEMENT_LOC = "loc";
    const ELEMENT_LASTMOD = "lastmod";
    const ELEMENT_PRIORITY = "priority";
    const ELEMENT_FREQUENCY = "changefreq";

    public function __construct(XMLWriter $xmlWriter, $loc)
    {
        parent::__construct($xmlWriter, $loc);
    }

    public function setLastMod($lastmod)
    {
        $this->xmlWriter->startElement(self::ELEMENT_LASTMOD);
        $this->xmlWriter->text($lastmod);
        $this->xmlWriter->endElement();
    }

    public function setPriority($priority)
    {
        $this->xmlWriter->startElement(self::ELEMENT_PRIORITY);
        $this->xmlWriter->text($priority);
        $this->xmlWriter->endElement();
    }

    public function setFrequency($frequency)
    {
        $this->xmlWriter->startElement(self::ELEMENT_FREQUENCY);
        $this->xmlWriter->text($frequency);
        $this->xmlWriter->endElement();
    }

    public function addImage($loc, $caption = null, $title = null)
    {
        $image = new Image($this->xmlWriter, $loc);
        if ($caption instanceof Closure) {
            call_user_func($caption, $image);
        } elseif (!empty($caption)) {
            $image->setCaption($caption);
        }

        if (!empty($title)) {
            $image->setTitle($title);
        }

        $image->finish();
    }
}
