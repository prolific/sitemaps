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

    protected $xmlWriter;
    protected $buffer = 1000;
    protected $maxUrls = 2000;

    public function __construct()
    {
        $this->newFile();
    }

    protected function newFile()
    {
        $this->xmlWriter = new XMLWriter;
        $this->xmlWriter->openMemory();
        $this->xmlWriter->setIndent(true);
        $this->xmlWriter->setIndentString(' ');
        $this->xmlWriter->startDocument('1.0', 'UTF-8');
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

    public function addUrl($loc, $lastmod = null, $priority = null, $freq = null)
    {
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

        return $this;
    }
}
