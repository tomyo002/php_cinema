<?php

declare(strict_types=1);

namespace Html;

trait StringEscaper
{
    /**
     * méthode qui permet de protéger des données html
     * retourne une valeur sous forme de chaîne de caractère
     *
     * @param string|null $string $string
     * @return string|null
     */
    public function escapeString(?string $string): ?string
    {
        if($string != null) {
            return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5);
        } else {
            return null;
        }

    }
    public function stripTagsAndTrim(?string $text): ?string
    {
        if($text != null) {
            $text = strip_tags($text);
            return trim($text);
        } else {
            return null;
        }
    }

}
