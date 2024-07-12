<?php

namespace App\Infrastructure\Persistence\Doctrine\Fixtures;

use App\Domain\Entity\Author;
use App\Domain\Repository\AuthorRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AuthorFixtures extends Fixture
{
    private AuthorRepositoryInterface $authorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $author = new Author($faker->name);
            $this->authorRepository->save($author);
        }
    }
}
