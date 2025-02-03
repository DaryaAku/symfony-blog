<?php

namespace App\Controller;

use App\Service\SettingsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/settings')]
class SettingsController extends AbstractController
{
    private SettingsService $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    #[Route('/{key}', methods: ['GET'])]
    public function getSetting(string $key): JsonResponse
    {
        $value = $this->settingsService->getSetting($key);
        return $value ? $this->json($value) : $this->json(['error' => 'Setting not found'], 404);
    }

    #[Route('/{key}', methods: ['POST'])]
    public function setSetting(Request $request, string $key): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data || !isset($data['value'])) {
            return $this->json(['error' => 'Invalid data'], 400);
        }

        $this->settingsService->setSetting($key, $data['value']);
        return $this->json(['message' => 'Setting saved']);
    }
}
