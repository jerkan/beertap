<?php

declare(strict_types=1);

namespace App\UI\API;

use App\Application\GetDispenserMoneySpent;
use App\Application\GetDispenserMoneySpentCommand;
use App\Application\GetDispenserMoneySpentResultDto;
use App\Domain\DispenserNotFoundException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetDispenserMoneySpentController extends AbstractController
{
    private GetDispenserMoneySpent $getDispenserMoneySpent;

    public function __construct(GetDispenserMoneySpent $getDispenserMoneySpent)
    {
        $this->getDispenserMoneySpent = $getDispenserMoneySpent;
    }

    /**
     * @Route("/dispenser/{id}/spending", name="api_dispenser_usages", methods={"GET"})
     */
    public function dispenserUsage(Request $request): Response
    {
        try {
            $command = $this->createCommandFromRequest($request);

            $resultDto = $this->getDispenserMoneySpent->__invoke($command);

            return $this->json($this->formatResultDto($resultDto), Response::HTTP_OK);

        } catch (DispenserNotFoundException $exception) {
            return $this->json([], Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return $this->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function createCommandFromRequest(Request $request): GetDispenserMoneySpentCommand
    {
        return new GetDispenserMoneySpentCommand($request->get('id'));
    }

    private function formatResultDto(GetDispenserMoneySpentResultDto $resultDto): array
    {
        $result = ['amount' => $resultDto->totalAmount()];

        foreach ($resultDto->usages() as $usage) {
            $result['usages'][] = [
                'opened_at' => $usage->openedAt()->format('Y-m-d\TH:i:s\Z'),
                'closed_at' => $usage->closedAt() ? $usage->closedAt()->format('Y-m-d\TH:i:s\Z') : null,
                'flow_volume' => $usage->flowVolume(),
                'total_spent' => $usage->totalSpent()
            ];
        }

        return $result;
    }
}