<?php

namespace App\DTO;

class ParserConfigDTO
{
    protected string $urlSite;
    protected string $linkRule;

    public function __construct()
    {
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrlSite()
    {
        return $this->urlSite;
    }

    /**
     * @param mixed $urlSite
     */
    public function setUrlSite($urlSite): self
    {
        $this->urlSite = $urlSite;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLinkRule()
    {
        return $this->linkRule;
    }

    /**
     * @param $linkRule
     * @return $this
     */
    public function setLinkRule($linkRule): self
    {
        $this->linkRule = $linkRule;
        return $this;
    }
}
