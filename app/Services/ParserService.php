<?php

namespace App\Services;

use App\DTO\ParserConfigDTO;
use PHPHtmlParser\Dom;

class ParserService extends Service
{
    protected Dom $parser;


    public function parserStart(ParserConfigDTO $parserConfigDTO)
    {
        $content = $this->getClient()->request('GET', $parserConfigDTO->getUrlSite());
        $dom = $this->getParser();
        $dom->loadStr((string)$content->getBody());
        $dom->find($parserConfigDTO->getLinkRule());
    }





    protected function getParser(): Dom
    {
        if (empty($this->parser)) {
            $this->parser = new Dom();
        }

        return $this->parser;
    }
}
