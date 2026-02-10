<?php

namespace App\Shared\Infrastructure\Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Shared\Domain\Exception\DomainExceptionInterface;

/**
 * Un handler global pour centraliser les exceptions métier
 */
class Handler extends ExceptionHandler
{
    private array $httpStatusMap = [
        'BAD_REQUEST'       => 400,
        'CONFLICT'          => 409,
        'INVALID_TYPE'      => 422,
        'VALIDATION_ERROR'  => 422,
        'DOMAIN_VIOLATION'  => 403,
        'NOT_FOUND'         => 404,
    ];

    public function render($request, Throwable $exception): RedirectResponse|Response|JsonResponse
    {
        // On capte que les excéptions métier
        if ($exception instanceof DomainExceptionInterface) {

            $codeError = $exception->getCode() ;
            $status = $this->httpStatusMap[$exception->reason()] ?? 500;

            // Si c'est une requête AJAX / JSON
            if ($request->wantsJson()) {
                return  Response()->json([
                    'message' => $exception->getMessage(),
                    'code' => $codeError, 
                ], $status);
            }

            // Sinon, comportement pour le web classique (Blade)
            switch ($exception->reason()) {
                case 'NOT_FOUND':
                    return response()->view('errors.404', [
                        'message' => $exception->getMessage(),
                        'code' => $codeError, 
                    ], $status);

                case 'INVALID_TYPE':
                case 'BAD_REQUEST':
                case 'CONFLICT':
                case 'DOMAIN_VIOLATION':
                    // On Retourne la page précédente avec les erreurs
                    return back()->withInput()->withErrors([
                        'message' => $exception->getMessage(),
                        'code' => $codeError, 
                    ]);

                default:
                    $message = config('app.debug') ? $exception->getMessage() : 'Une erreur interne est survenue';
                    return response()->view('errors.500', [
                        'message' => $message,
                        'code' => $codeError, 
                    ], $status);
            }
        }

        // Autres exceptions → comportement Laravel par défaut
        return parent::render($request, $exception);
    }
}
