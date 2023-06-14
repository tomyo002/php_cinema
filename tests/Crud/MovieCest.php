<?php
namespace Tests\Crud;
use Entity\Exception\EntityNotFoundException;
use Entity\Movie;
use Tests\CrudTester;
class MovieCest
{
    public function findById(CrudTester $I): void
    {
        $movie = Movie::findById(108);
        $I->assertSame(108, $movie->getId());
        $I->assertSame('Trois couleurs : Bleu', $movie->getTitle());
    }

    public function findByIdThrowsExceptionIfArtistDoesNotExist(CrudTester $I): void
    {
        $I->expectThrowable(EntityNotFoundException::class, function () {
            Movie::findById(PHP_INT_MAX);
        });
    }

    public function delete(CrudTester $I):void
    {
        $movie = Movie::findById(108);
        $movie->delete();
        $I->cantSeeInDatabase('movie', ['id' => 108]);
        $I->cantSeeInDatabase('movie', ['title' => 'Trois couleurs : Bleu']);
        $I->assertNull($movie->getId());
        $I->assertSame('Trois couleurs : Bleu', $movie->getTitle());
    }

}
