<?php
namespace Tests\Crud\Collection;
use Entity\Collection\genreCollection;
use Entity\Genre;
use Tests\CrudTester;
class GenreCollectionCest
{
    public function findAll(CrudTester $I)
    {
        $expectedArtists = [
            ['id' => 12, 'name' => 'Aventure'],
            ['id' => 14, 'name' => 'Fantastique'],
            ['id' => 16, 'name' => 'Animation'],

        ];

        $artists = GenreCollection::findAll();
        $I->assertCount(count($expectedArtists), $artists);
        $I->assertContainsOnlyInstancesOf(Genre::class, $artists);
        foreach ($artists as $index => $artist) {
            $expectedArtist = $expectedArtists[$index];
            $I->assertEquals($expectedArtist['id'], $artist->getId());
            $I->assertEquals($expectedArtist['name'], $artist->getName());
        }
    }
}
