<?php

namespace App\Domain;

use RuntimeException;
use function sprintf;

class Runner
{
    const POST = 'post';
    const PUT = 'put';
    const GET = 'get';
    const DELETE = 'delete';

    /**
     * @var FixtureRepositoryInterface
     */
    private $fixtureRepository;

    /**
     * @var ResourceRepositoryInterface
     */
    private $resourceRepository;

    /**
     * @var ResultRepositoryInterface
     */
    private $resultRepository;

    /**
     * Runner constructor.
     * @param FixtureRepositoryInterface $fixtureRepository
     * @param ResourceRepositoryInterface $resourceRepository
     * @param ResultRepositoryInterface $resultRepository
     */
    public function __construct(
        FixtureRepositoryInterface $fixtureRepository,
        ResourceRepositoryInterface $resourceRepository,
        ResultRepositoryInterface $resultRepository
    ) {
        $this->fixtureRepository = $fixtureRepository;
        $this->resourceRepository = $resourceRepository;
        $this->resultRepository = $resultRepository;
    }

    /**
     * @param Runable $runable
     * @return void
     */
    public function run(Runable $runable)
    {
        $route = $runable->getRoute();

        if ($runable->isMethodAvailable(self::POST)) {
            $fixture = $this->fixtureRepository->get($runable->getName(), self::POST);

            $postResult = $this->resourceRepository->post($route, $fixture);

            $this->resultRepository->save($runable->getName(), self::POST, $postResult);

            $route = $this->decorateRoute($runable, $postResult);
        }

        if ($runable->isMethodAvailable(self::PUT)) {
            $fixture = $this->fixtureRepository->get($runable->getName(), self::PUT);

            $putResult = $this->resourceRepository->put($route, $fixture);

            $this->resultRepository->save($runable->getName(), self::PUT, $putResult);
        }

        if ($runable->isMethodAvailable(self::GET)) {
            $getResult = $this->resourceRepository->get($route);

            $this->resultRepository->save($runable->getName(), self::GET, $getResult);
        }

        if ($runable->isMethodAvailable(self::DELETE)) {
            $deleteResult = $this->resourceRepository->delete($route);

            $this->resultRepository->save($runable->getName(), self::DELETE, $deleteResult);
        }
    }

    /**
     * @param Runable $runable
     * @param array $postResult
     * @return string
     */
    private function decorateRoute(Runable $runable, $postResult): string
    {
        $id = $postResult['id'] ?? null;

        if ($id === null) {
            throw new RuntimeException('Invalid POST response (the "id" is null): ' . $runable->getName());
        }

        return sprintf('%s/%s', $runable->getRoute(), $id);
    }
}
