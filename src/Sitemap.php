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
    protected $pathParts;
    protected $urlsCount = 0;
    protected $buffer = 1000;
    protected $maxUrls = 2000;
    protected $files = [];
    protected $currentFile;
    protected $attributes = [
        "xmlns" => "http://www.sitemaps.org/schemas/sitemap/0.9",
        "xmlns:image" => "http://www.google.com/schemas/sitemap-image/1.1"
    ];

    public function __construct($file, $attributes = [])
    {
        $this->pathParts = pathinfo($file);
        if (!empty($attributes)) {
            $this->attributes = $attributes;
        }
        $this->newFile();
    }

    protected function newFile()
    {
        $this->urlsCount = 0;
        $this->setCurrentFile();
        $this->xmlWriter = new XMLWriter;
        $this->xmlWriter->openMemory();
        $this->xmlWriter->setIndent(true);
        $this->xmlWriter->setIndentString(' ');
        $this->xmlWriter->startDocument('1.0', 'UTF-8');
        $this->xmlWriter->startElement(self::ELEMENT_URLSET);
        foreach ($this->attributes as $key => $value) {
            $this->xmlWriter->writeAttribute($key, $value);
        }
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

    protected function setCurrentFile()
    {
        if (!file_exists($this->pathParts['dirname'])) {
            mkdir($this->pathParts['dirname'], 0777, true);
        }

        $name = $this->pathParts['filename'];
        $filesCount = count($this->files);
        if ($filesCount > 0) {
            $filesCount++;
            $name = "$name-$filesCount";
        }

        $file = $this->pathParts['dirname']."/".$name;
        if (!empty($this->pathParts['extension'])) {
            $file = $file.".".$this->pathParts['extension'];
        }

        $this->currentFile = $file;
        file_put_contents($this->currentFile, null);
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
        file_put_contents($this->currentFile, $this->xmlWriter->flush(true), FILE_APPEND);
    }

    public function finish()
    {
        $this->xmlWriter->endElement();
        $this->xmlWriter->endDocument();
        $this->flush();
        $this->files[] = pathinfo($this->currentFile, PATHINFO_BASENAME);
        $this->currentFile = null;
        $this->xmlWriter = null;

        return $this->files;
    }
}
