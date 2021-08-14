<?php
declare(strict_types=1);

namespace App\Application\EventListener;

use JsonException;
use Symfony\Component\HttpFoundation\{Request, Response, JsonResponse};
use Symfony\Component\HttpKernel\Event\RequestEvent;
use function is_array;
use function json_decode;
use const JSON_THROW_ON_ERROR;

final class RequestEventListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (false === $this->supports($request)) {
            return;
        }

        try {
            $data = $this->decodeJson($request);

            if (is_array($data)) {
                $request->request->replace($data);
            }
        } catch (JsonException $exception) {
            $event->setResponse(new JsonResponse([
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST));
        }
    }

    private function supports(Request $request): bool
    {
        return 'json' === $request->getContentType() && $request->getContent();
    }

    private function decodeJson(Request $request)
    {
        return json_decode((string)$request->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }
}