<?php

declare(strict_types=1);

namespace App\UI\API;

use App\Application\CreateDispenser;
use App\Application\CreateDispenserCommand;
use Faker\Factory;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateDispenserController extends AbstractController
{
    private CreateDispenser $createDispenser;

    public function __construct(CreateDispenser $createDispenser)
    {
        $this->createDispenser = $createDispenser;
    }

    /**
     * @Route("/dispenser", name="api_dispenser_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        try {
            $command = $this->createCommandFromRequest($request);

            $this->createDispenser->handle($command);

            return $this->json([
                'id' => $command->id(),
                'flow_volume' => $command->flowVolume()
            ], Response::HTTP_OK);

        } catch (\InvalidArgumentException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function createCommandFromRequest(Request $request): CreateDispenserCommand
    {
        $body = json_decode($request->getContent(), true);

        if (empty($body['flow_volume'])) {
            throw new \InvalidArgumentException('Missing required parameter "flow_volume"');
        }

        $faker = Factory::create();
        $id = Uuid::uuid4()->toString();
        $name = (string)$faker->randomNumber();
        $flowVolume = floatval($body['flow_volume']);

        return new CreateDispenserCommand($id, $name, $flowVolume);
    }
}