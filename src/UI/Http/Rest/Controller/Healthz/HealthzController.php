<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\Healthz;

use App\Infrastructure\Shared\Persistence\Repository\EntitylessMysqlRepository;
use App\UI\Http\Rest\Response\OpenApi;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class HealthzController
{
    private EntitylessMysqlRepository $mysqlRepository;

    public function __construct(
        EntitylessMysqlRepository $mysqlRepository
    ) {
        $this->mysqlReadRepository = $mysqlRepository;
    }

    /**
     * @Route(
     *     "/healthz",
     *     name="healthz",
     *     methods={"GET"}
     * )
     * @OA\Response(
     *     response=200,
     *     description="OK"
     * )
     * @OA\Response(
     *     response=500,
     *     description="Something not ok"
     * )
     *
     * @OA\Tag(name="Healthz")
     */
    public function __invoke(Request $request): OpenApi
    {
        $mysql = null;

        if (
            true === $mysql = $this->mysqlRepository->isHealthy()
        ) {
            return OpenApi::empty(200);
        }

        return OpenApi::fromPayload(
            [
                'Healthy services' => [
                    'MySQL' => $mysql,
                ],
            ],
            500
        );
    }
}
