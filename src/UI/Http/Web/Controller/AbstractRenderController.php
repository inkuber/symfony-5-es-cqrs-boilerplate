<?php

declare(strict_types=1);

namespace App\UI\Http\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Command\CommandInterface;
use App\Shared\Application\Query\Collection;
use App\Shared\Application\Query\Item;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Application\Query\QueryInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Twig;

abstract class AbstractRenderController extends AbstractController
{
    private CommandBusInterface $commandBus;

    private QueryBusInterface $queryBus;

    private Twig\Environment $template;

    public function __construct(
        Twig\Environment $template,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus
    ) {
        $this->template = $template;
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * @throws Twig\Error\LoaderError
     * @throws Twig\Error\RuntimeError
     * @throws Twig\Error\SyntaxError
     */
    protected function renderWithCode(string $view, array $parameters = [], int $code = Response::HTTP_OK): Response
    {
        $response = $this->render($view, $parameters);
        $response->setStatusCode($code);
        return $response;
    }

    /**
     * @throws Throwable
     */
    protected function handle(CommandInterface $command): void
    {
        $this->commandBus->handle($command);
    }

    /**
     * @return Item|Collection|mixed
     *
     * @throws Throwable
     */
    protected function ask(QueryInterface $query)
    {
        return $this->queryBus->ask($query);
    }
}
