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
     * @param Runnable $runnable
     * @return void
     */
    public function run(Runnable $runnable)
    {
        $route = $runnable->getRoute();

        if ($runnable->isMethodAvailable(self::POST)) {
            $fixture = $this->fixtureRepository->get($runnable->getName(), self::POST);

            $postResult = $this->resourceRepository->post($route, $fixture);

            $this->resultRepository->save($runnable->getName(), self::POST, $postResult);

            $route = $this->decorateRoute($runnable, $postResult);
        }

        if ($runnable->isMethodAvailable(self::PUT)) {
            $fixture = $this->fixtureRepository->get($runnable->getName(), self::PUT);

            $putResult = $this->resourceRepository->put($route, $fixture);

            $this->resultRepository->save($runnable->getName(), self::PUT, $putResult);
        }

        if ($runnable->isMethodAvailable(self::GET)) {
            $getResult = $this->resourceRepository->get($route);

            $this->resultRepository->save($runnable->getName(), self::GET, $getResult);
        }

        if ($runnable->isMethodAvailable(self::DELETE)) {
            $deleteResult = $this->resourceRepository->delete($route);

            $this->resultRepository->save($runnable->getName(), self::DELETE, $deleteResult);
        }
    }

    /**
     * @param Runnable $runnable
     * @param array $postResult
     * @return string
     */
    private function decorateRoute(Runnable $runnable, $postResult): string
    {
        $id = $postResult['id'] ?? null;

        if ($id === null) {
            throw new RuntimeException('Invalid POST response (the "id" is null): ' . $runnable->getName());
        }

        return sprintf('%s/%s', $runnable->getRoute(), $id);
    }
}
