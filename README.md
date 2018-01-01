# PHP Sitemaps Package

A simple, scalable, highly extensible and seo friendly php sitemap generator. It also supports image sitemap.

## Installation

You can install the package through composer:

> composer require prolificrohit/sitemaps

## Examples

- For any array of urls:

  ```
    $sitemap = new Sitemap("sitemaps/test.xml");
    $sitemap->setMaxUrls(5000);
    $sitemap->setBuffer(1000);
    foreach ($urls as $url) {
        $sitemap->addUrl($url);
    }
    $fileNames = $sitemap->finish();
  ```

- To add images:

  ```
  foreach ($items as $item) {
      $sitemap->addUrl($item->link, function($url) use($item){
          $url->addImage($item->image, "Caption", "Title");
      });
  }
  ```

## Dependency

It is a simple php package and hence it supports all php based frameworks like laravel, zend, symfony, falcon, lumen etc. The only dependency for this package is PHP.

## Coming Soon

Support for video and news sitemap is on the way.

## License

[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](https://github.com/prolificrohit/sitemaps/blob/master/LICENSE)
