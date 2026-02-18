<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

final class ApiExceptionsHandler
{
    use ApiResponse;

    public static function handler(Exceptions $exceptions): void
    {
        $cls = new self;
        $exceptions->render(function (Throwable $e, Request $request) use ($cls) {
            if ($request->is('api/*')) {
                return $cls->renderApiError($e);
            }
        });
    }

    public function renderApiError(Throwable $e): ?JsonResponse
    {
        return match (true) {
            $e instanceof AuthenticationException => $this->authenticationException($e),
            $e instanceof ValidationException => $this->validationException($e),
            $e instanceof NotFoundHttpException => $this->notFoundHttpException($e),
            $e instanceof MethodNotAllowedHttpException => $this->methodNotAllowedHttpException($e),
            $e instanceof HttpException => $this->httpException($e),
            default => $this->serverError($e)
        };
    }

    public function authenticationException(AuthenticationException $e): JsonResponse
    {
        return $this->error('Siz tizimga kirishingiz kerak.', $e->getMessage() ?: null, Response::HTTP_UNAUTHORIZED);
    }

    public function validationException(ValidationException $e): JsonResponse
    {
        return $this->error('Ma’lumotlarni tekshirishda xatolik yuz berdi.', $e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function notFoundHttpException(NotFoundHttpException $e): JsonResponse
    {
        return $this->error('So‘ralgan resurs topilmadi.', $e->getMessage() ?: null, Response::HTTP_NOT_FOUND);
    }

    public function methodNotAllowedHttpException(MethodNotAllowedHttpException $e): JsonResponse
    {
        return $this->error('Bu metod bu yo‘l uchun ruxsat etilmagan.', $e->getMessage() ?: null, Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function httpException(HttpException $e): JsonResponse
    {
        return $this->error('Xatolik yuz berdi.', $e->getMessage() ?: null, $e->getStatusCode());
    }

    /**
     * Serverda birorbir xatolik bo'lganida loyihani muhitiga qarab ikki xil ko'rinishda foydalanuvchiga ma'lumot qaytariladi.
     * Local muhitda, APP_DEBUG yoniq bo'lganida barcha xatoliklar standar Debug sahifasi orqali ko'rsatiladi.
     * Production muhitida barcha xatoliklarni JSON ko'rinishida qaytariladi.
     */
    public function serverError(Throwable $e): ?JsonResponse
    {

        return match (true) {
            (config('app.env') == 'local' && config('app.debug') == true) => null,
            (config('app.env') == 'local' && config('app.debug') == false) => $this->error('Serverda kutilmagan xatolik yuz berdi.', ['message' => $this->serverErrorMessage($e)], Response::HTTP_INTERNAL_SERVER_ERROR),
            default => $this->error('Serverda kutilmagan xatolik yuz berdi.', (config('app.debug') ? $this->serverErrorMessage($e) : null), Response::HTTP_INTERNAL_SERVER_ERROR),
        };

    }

    public function serverErrorMessage(Throwable $e): string
    {
        return sprintf(
            "Xatolik yuz berdi: \nFayl: %s \nQator: %d \nXabar: %s",
            $e->getFile(),
            $e->getLine(),
            $e->getMessage() ?: null
        );
    }
}
