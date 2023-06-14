<?php
namespace Tests\Crud;
use Entity\Exception\EntityNotFoundException;
use Entity\Image;
use Tests\CrudTester;
class ImageCest
{

    public function findByIdThrowsExceptionIfCoverDoesNotExist(CrudTester $I):void
    {
        $I->expectThrowable(EntityNotFoundException::class, function () {
            Image::findById(PHP_INT_MAX);
        });
    }
}
