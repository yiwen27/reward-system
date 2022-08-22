<?php

declare(strict_types=1);

namespace App\Classes\Modules\ControllerLogics;

use App\Classes\Constants;
use App\Classes\Modules\StructuredData\HandlesApiResponseData;
use App\Classes\Modules\StructuredData\Transformers\PointRedemptionTransformer;
use App\Classes\Services\Points\RedeemsPoints;
use App\Models\Order;
use App\Repositories\Eloquent\Orders;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * @author    Yi Wen, Tan <yiwentan301@gmail.com>
 */
class RedeemPointsLogic {
    /** @var Orders */
    private Orders $orders;

    /** @var RedeemsPoints */
    private RedeemsPoints $redeemsPoints;

    /** @var HandlesApiResponseData */
    private HandlesApiResponseData $handlesApiResponseData;

    /**
     * RedeemPointLogic constructor.
     *
     * @param Orders                 $orders
     * @param RedeemsPoints          $redeemsPoints
     * @param HandlesApiResponseData $handlesApiResponseData
     */
    public function __construct(
        Orders $orders,
        RedeemsPoints $redeemsPoints,
        HandlesApiResponseData $handlesApiResponseData
    ) {
        $this->orders                 = $orders;
        $this->redeemsPoints          = $redeemsPoints;
        $this->handlesApiResponseData = $handlesApiResponseData;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws InternalErrorException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function execute(Request $request): JsonResponse {
        try {
            /** @var Order $order */
            $order = $this->orders->findBy('id', $request->get('order_id'));

            if ($order->status === Constants::ORDER_STATUS_COMPLETE) {
                throw new \InvalidArgumentException('Order has been completed.');
            }

            $pointRedemption = $this->redeemsPoints->execute($order);

            if ((int)$pointRedemption->getOutstandingAmount() === 0) {
                $order->update(['status' => Constants::ORDER_STATUS_COMPLETE]);
            }

            return new JsonResponse($this->handlesApiResponseData->returnOne($pointRedemption,
                new PointRedemptionTransformer()));
        } catch (ModelNotFoundException $exception) {
            throw new ResourceNotFoundException($exception->getMessage());
        }
    }
}
