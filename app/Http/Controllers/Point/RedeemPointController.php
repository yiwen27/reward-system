<?php

declare(strict_types=1);

namespace App\Http\Controllers\Point;

use App\Classes\Modules\ControllerLogics\RedeemPointsLogic;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class RedeemPointController extends Controller {
    /**
     * @param RedeemPointsLogic $logic
     * @param Request           $request
     *
     * @return JsonResponse
     * @throws ValidationException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Symfony\Component\CssSelector\Exception\InternalErrorException
     */
    public function execute(RedeemPointsLogic $logic, Request $request): JsonResponse {
        $this->validate($request, $this->validationRules());

        return $logic->execute($request);
    }

    protected function validationRules(): array {
        return [
            'order_id' => 'required|string',
        ];
    }
}
