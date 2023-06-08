<?php

namespace Html;

class WebPage
{
    use StringEscaper;
    private string $head ="";
    private string $title;
    private string $body ="";

    /**
     * Constructeur de la méthode webpage, qui prend en paramètre un titre.
     *
     * @param string $title
     */
    public function __construct(string $title="")
    {
        $this->title = $title;
    }

    /**
     * Accesseur de l'entête du site web.
     * Retourne une valeur sous forme de chaîne de caractère
     *
     * @return string
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * accesseur du titre du site web.
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * modificateur du titre du site web pris en paramètre
     * retourne rien
     *
     * @param string $newTitle
     * @return void
     */
    public function setTitle(string $newTitle): void
    {
        $this->title = $newTitle;

    }

    /**
     * accesseur du corps du site web.
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * méthode qui permet d'ajouter du contenu,pris en paramètre, dans l'entête.
     * retourne rien
     *
     * @param string $content
     * @return void
     */
    public function appendToHead(string $content): void
    {
        $this->head.=$content;

    }

    /**
     * méthode qui permet d'inserer du css dans l'entête
     * retourne rien
     *
     * @param string $css
     * @return void
     */
    public function appendCss(string $css): void
    {
        $this->appendToHead("<style>$css</style>");

    }

    /**
     * méthode qui permet d'inserer du css d'après une url dans l'entête
     * retourne rien
     *
     * @param string $url
     * @return void
     */
    public function appendCssUrl(string $url): void
    {
        $this->appendToHead(<<<HTML
        <link rel="stylesheet" href=$url type="text/css">
        HTML);

    }

    /**
     * méthode qui permet d'inserer du javascript dans l'entête
     * retourne rien
     *
     * @param string $js
     * @return void
     */
    public function appendJs(string $js): void
    {
        $this->appendToHead("<script>$js</script>");
    }

    /**
     * méthode qui permet d'inserer du javascript en url dans l'entête
     * retourne rien
     *
     * @param string $url
     * @return void
     */
    public function appendJsUrl(string $url): void
    {
        $this->appendToHead("<script src=$url></script>");
    }

    /**
     * méthode qui permet d'ajouter du contenu dans le corps
     * retourne rien
     *
     * @param string $content
     * @return void
     */
    public function appendContent(string $content): void
    {
        $this->body.= $content;
    }

    /**
     * méthode qui produit la page web
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @return string
     */
    public function toHTML(): string
    {
        $str = $this->getLastModification();
        $res=<<<HTML
        <!doctype html>
        <html lang="fr">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>$this->title</title>
                $this->head
            </head>
            <body>
                $this->body
                <footer style="text-align: end">
                    $str
                </footer>
            </body>
        </html>
        HTML;
        return $res;
    }


    /**
     * Accesseur de la dernière modification de la page
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @return string
     */
    public function getLastModification(): string
    {
        return "dernière modification de cette page le ".date(" d/m/Y à H:i:s.", getlastmod());
    }
}
