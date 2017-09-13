<?php

namespace ProlificRohit\Sitemaps;

use XMLWriter;
use ProlificRohit\Sitemaps\Element;

class Image extends Element
{
    const ELEMENT_ROOT = "image:image";
    const ELEMENT_LOC = "image:loc";
    const ELEMENT_TITLE = "image:title";
    const ELEMENT_CAPTION = "image:caption";
    const ELEMENT_LICENSE = "image:license";
    const ELEMENT_GEO = "image:geo_location";

    public function __construct(XMLWriter $xmlWriter, $loc)
    {
        parent::__construct($xmlWriter, $loc);
    }

    protected function setLoc($loc)
    {
        $this->xmlWriter->startElement(self::ELEMENT_LOC);
        $this->xmlWriter->text($loc);
        $this->xmlWriter->endElement();
    }

    public function setCaption($caption)
    {
        $this->xmlWriter->startElement(self::ELEMENT_CAPTION);
        $this->xmlWriter->text($caption);
        $this->xmlWriter->endElement();
    }

    public function setTitle($title)
    {
        $this->xmlWriter->startElement(self::ELEMENT_TITLE);
        $this->xmlWriter->text($title);
        $this->xmlWriter->endElement();
    }

    public function setLicense($url)
    {
        $this->xmlWriter->startElement(self::ELEMENT_LICENSE);
        $this->xmlWriter->text($url);
        $this->xmlWriter->endElement();
    }

    public function setGeoLocation($location)
    {
        $this->xmlWriter->startElement(self::ELEMENT_GEO);
        $this->xmlWriter->text($location);
        $this->xmlWriter->endElement();
    }
}
