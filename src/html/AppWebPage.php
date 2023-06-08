<?php

declare(strict_types=1);

namespace Html;

class AppWebPage extends WebPage
{
    private string $menu ="";
    public function __construct(string $title="")
    {
        parent::__construct($title);
        $this->appendCssUrl("/css/style.css");
    }
    public function getMenu(): string
    {
        return $this->menu;
    }

    public function appendMenu(string $menu): void
    {
        $this->menu.=$menu;
    }

    public function toHTML(): string
    {
        return <<<HTML
        <!doctype html>
        <html lang="fr">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>{$this->getTitle()}</title>
                {$this->getHead()}
            </head>
            <body>
                <header class="header">
                    <h1>{$this->getTitle()}</h1>
                </header>
                <main class="menu">
                    {$this->getMenu()}
                </main>
                <main class="content">
                    {$this->getBody()}
                </main>
                <footer class="footer" >
                    {$this->getLastModification()}
                </footer>
            </body>
        </html>
        HTML;
    }
}
