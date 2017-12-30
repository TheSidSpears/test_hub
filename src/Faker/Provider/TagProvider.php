<?php


namespace App\Faker\Provider;


use Faker\Provider\Base as BaseProvider;

final class TagProvider extends BaseProvider
{
    const TAG = [
        'easy',
        'hard',
        'excellent',
        'long',
        'fast',
        'boring',
        'tedious',
    ];

    public function testTag()
    {
        return self::randomElement(self::TAG);
    }
}