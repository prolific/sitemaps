<?php

namespace ProlificRohit\Sitemaps;

use Closure;
use XMLWriter;
use ProlificRohit\Sitemaps\Url;

class Sitemap
{
    const FREQUENCY_ALWAYS = 'always';
    const FREQUENCY_HOURLY = 'hourly';
    const FREQUENCY_DAILY = 'daily';
    const FREQUENCY_WEEKLY = 'weekly';
    const FREQUENCY_MONTHLY = 'monthly';
    const FREQUENCY_YEARLY = 'yearly';
    const FREQUENCY_NEVER = 'never';

    const ELEMENT_URLSET = 'urlset';

    protected $xmlWriter;
    protected $urlsCount = 0;
    protected $buffer = 1000;
    protected $maxUrls = 2000;

    public function __construct()
    {
        $this->newFile();
    }

    protected function newFile()
    {
        $this->urlsCount = 0;
        $this->xmlWriter = new XMLWriter;
        $this->xmlWriter->openMemory();
        $this->xmlWriter->setIndent(true);
        $this->xmlWriter->setIndentString(' ');
        $this->xmlWriter->startDocument('1.0', 'UTF-8');
        $this->xmlWriter->startElement(self::ELEMENT_URLSET);
    }

    public function setBuffer($buffer)
    {
        $this->buffer = $buffer;
        return $this;
    }

    public function setMaxUrls($maxUrls)
    {
        $this->maxUrls = $maxUrls;
        return $this;
    }

    protected function getFilePath()
    {
    }

    protected function validateSize()
    {
        if ($this->urlsCount >= $this->maxUrls) {
            $this->finish();
            $this->newFile();
        } elseif ($this->urlsCount % $this->buffer == 0) {
            $this->flush();
        }
    }

    public function addUrl($loc, $lastmod = null, $priority = null, $freq = null)
    {
        $this->validateSize();
        $url = new Url($this->xmlWriter, $loc);

        if ($lastmod instanceof Closure) {
            call_user_func($lastmod, $url);
        } elseif (!empty($lastmod)) {
            $url->setLastMod($lastmod);
        }

        if (!empty($priority)) {
            $url->setPriority($priority);
        }

        if (!empty($freq)) {
            $url->setFrequency($freq);
        }

        $url->finish();
        $this->urlsCount++;

        return $this;
    }

    protected function flush()
    {
        $filePath = $this->getFilePath();
        file_put_contents($filePath, $this->xmlWriter->flush(true), FILE_APPEND);
    }

    public function finish()
    {
        $this->xmlWriter->endElement();
        $this->xmlWriter->endDocument();
        $this->flush();
        $this->xmlWriter = null;
    }
}
