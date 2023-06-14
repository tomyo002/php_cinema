<?php

declare(strict_types=1);

namespace Tests\Browse;

use Tests\BrowseTester;

class IndexCest
{
    public function checkAppWebPageHtmlStructure(BrowseTester $I): void
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIs(200);
        $I->seeInTitle('films');
        $I->seeElement('.header');
        $I->seeElement('.header h1');
        $I->see('films', '.header h1');
        $I->seeElement('.content');
        $I->seeElement('.footer');
    }

    public function clickOnArtistLink(BrowseTester $I): void
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIs(200);
        $I->click('Trois couleurs : Rouge');
        $I->seeInCurrentUrl('/movie.php?movieId=110');
    }
}
