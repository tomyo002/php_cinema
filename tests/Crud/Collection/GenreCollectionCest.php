<?php
namespace Tests\Crud\Collection;
use Entity\Collection\genreCollection;
use Entity\Genre;
use Tests\CrudTester;
class GenreCollectionCest
{
    public function findAll(CrudTester $I):void
    {
        $expectedGenres = [
            ['id' => 28, 'name' => 'Action'],
            ['id' => 16, 'name' => 'Animation'],
            ['id' => 12, 'name' => 'Aventure'],
            ['id' => 35, 'name' => 'Comédie'],
            ['id' => 18, 'name' => 'Drame'],
            ['id' => 10751, 'name' => 'Familial'],
            ['id' => 14, 'name' => 'Fantastique'],
            ['id' => 9648, 'name' => 'Mystère'],
            ['id' => 10749, 'name' => 'Romance'],
            ['id' => 878, 'name' => 'Science-Fiction'],
        ];

        $genres = GenreCollection::findAll();
        $I->assertCount(count($expectedGenres), $genres);
        $I->assertContainsOnlyInstancesOf(Genre::class, $genres);
        foreach ($genres as $index => $genre) {
            $expectedGenre = $expectedGenres[$index];
            $I->assertEquals($expectedGenre['id'], $genre->getId());
            $I->assertEquals($expectedGenre['name'], $genre->getName());
        }
    }
}
