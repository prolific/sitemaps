<?php

namespace ProlificRohit\Sitemaps;

use XMLWriter;

abstract class Element
{
    protected $xmlWriter;

    public function __construct(XMLWriter $xmlWriter, $loc)
    {
        $this->xmlWriter = $xmlWriter;
        $this->xmlWriter->startElement(static::ELEMENT_ROOT);
        $this->setLoc($loc);
    }

    protected function setLoc($loc)
    {
        $this->xmlWriter->startElement(static::ELEMENT_LOC);
        $this->xmlWriter->text($loc);
        $this->xmlWriter->endElement();
    }

    public function finish()
    {
        $this->xmlWriter->endElement();
    }
}
