<?php

declare(strict_types=1);

namespace App\UI\API;

use App\Application\ChangeDispenserStatus;
use App\Application\ChangeDispenserStatusCommand;
use App\Domain\DispenserAlreadyOpenedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChangeDispenserStatusController extends AbstractController
{
    private ChangeDispenserStatus $changeDispenserStatus;

    public function __construct(ChangeDispenserStatus $changeDispenserStatus)
    {
        $this->changeDispenserStatus = $changeDispenserStatus;
    }

    /**
     * @Route("/dispenser/{id}/status", name="api_dispenser_status", methods={"PUT"})
     */
    public function changeStatus(Request $request): Response
    {
        try {
            $command = $this->createCommandFromRequest($request);

            $this->changeDispenserStatus->__invoke($command);

            return $this->json([], Response::HTTP_ACCEPTED);

        } catch (DispenserAlreadyOpenedException $exception) {
            return $this->json([], Response::HTTP_CONFLICT);
        } catch (\Exception $exception) {
            return $this->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function createCommandFromRequest(Request $request): ChangeDispenserStatusCommand
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['status'])) {
            throw new BadRequestException('Missing status parameter');
        }

        if (!isset($data['updated_at'])) {
            throw new BadRequestException('Missing updated_at parameter');
        }

        return new ChangeDispenserStatusCommand(
            $request->get('id'),
            $data['status'],
            new \DateTime($data['updated_at'])
        );
    }
}