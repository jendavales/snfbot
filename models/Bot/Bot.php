<?php

namespace models\Bot;

use \Models\Account;

class Bot
{
    private $account;
    private $lastDownload;
    private $lastDom;
    private $lastPath;
    private $cookiesFile;

    public function __construct(Account $account)
    {
        $this->account = $account;
        $this->cookiesFile = "$account->id.txt";
    }

    public function isLogged(): bool
    {
        return strpos($this->lastDownload, '<div class="name">' . $this->account->name . '</div>') !== false;
    }

    public function setLastDownload(string $html): void
    {
        $this->lastDownload = $html;
        $this->lastDom = null;
        $this->lastPath = null;
    }

    public function updateHomePageStats(): void
    {
        $this->account->level = Parser::getLevel($this->getLastPath());
        $this->account->setOutfit(Parser::getCharacterImages($this->getLastPath()));
        $xps = explode('/', Parser::getLevelProgress($this->getLastPath()));
        $this->account->actualXp = $xps[0];
        $this->account->xpNeeded = $xps[1];
    }

    public function getLastDom(): \DOMDocument
    {
        if (!is_null($this->lastDom)) {
            return $this->lastDom;
        }

        $dom = new \DOMDocument();
        $dom->loadHTML($this->lastDownload);

        return $dom;
    }

    public function getLastPath(): \DOMXPath
    {
        return $this->lastPath ?? new \DOMXPath($this->getLastDom());
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function getCookiesFile(): string
    {
        return $this->cookiesFile;
    }

    public function getLastDownload(): ?string
    {
        return $this->lastDownload;
    }
}
