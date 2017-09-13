<?php

namespace ProlificRohit\Sitemaps;

class Url
{
    const ELEMENT_LOC = "loc";
    const ELEMENT_LASTMOD = "lastmod";
    const ELEMENT_PRIORITY = "priority";
    const ELEMENT_FREQUENCY = "changefreq";
    const ELEMENT_IMAGE = "image:image";
    const ELEMENT_VIDEO = "video:video";

    protected $xmlWriter;

    public function __construct($xmlWriter, $loc)
    {
        $this->xmlWriter = $xmlWriter;
        $this->xmlWriter->startElement(self::ELEMENT_URL);
        $this->setLoc($loc);
    }

    protected function setLoc($loc)
    {
        $this->xmlWriter->startElement(Self::ELEMENT_LOC);
        $this->xmlWriter->text($loc);
        $this->xmlWriter->endElement();
    }

    public function setLastMod($lastmod)
    {
        $this->xmlWriter->startElement(Self::ELEMENT_LASTMOD);
        $this->xmlWriter->text($lastmod);
        $this->xmlWriter->endElement();
    }

    public function setPriority($priority)
    {
        $this->xmlWriter->startElement(Self::ELEMENT_PRIORITY);
        $this->xmlWriter->text($priority);
        $this->xmlWriter->endElement();
    }

    public function setFrequency($frequency)
    {
        $this->xmlWriter->startElement(Self::ELEMENT_FREQUENCY);
        $this->xmlWriter->text($frequency);
        $this->xmlWriter->endElement();
    }

    public function finish()
    {
        $this->xmlWriter->endElement();
    }
}
