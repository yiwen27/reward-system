<?php

declare(strict_types=1);

namespace App\Classes\Modules\ControllerLogics;

use App\Classes\Constants;
use App\Classes\Modules\StructuredData\HandlesApiResponseData;
use App\Classes\Modules\StructuredData\Transformers\PointRewardTransformer;
use App\Classes\Services\Points\RewardsPoints;
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
class RewardPointsLogic {
    /** @var Orders */
    private Orders $orders;

    /** @var RewardsPoints */
    private RewardsPoints $rewardsPoints;

    /** @var HandlesApiResponseData */
    private HandlesApiResponseData $handlesApiResponseData;

    /**
     * RedeemPointLogic constructor.
     *
     * @param Orders                 $orders
     * @param RewardsPoints          $rewardsPoints
     * @param HandlesApiResponseData $handlesApiResponseData
     */
    public function __construct(
        Orders $orders,
        RewardsPoints $rewardsPoints,
        HandlesApiResponseData $handlesApiResponseData
    ) {
        $this->orders                 = $orders;
        $this->rewardsPoints          = $rewardsPoints;
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

            if ($order->status === Constants::ORDER_STATUS_PENDING) {
                throw new \InvalidArgumentException('Order is yet completed.');
            }

            $rewardPoint = $this->rewardsPoints->execute($order);

            return new JsonResponse($this->handlesApiResponseData->returnOne($rewardPoint,
                new PointRewardTransformer()));
        } catch (ModelNotFoundException $exception) {
            throw new ResourceNotFoundException($exception->getMessage());
        }
    }
}
