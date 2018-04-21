<?php
/**
 * User: yemeishu
 * Date: 2018/3/31
 * Time: 下午3:59
 */

namespace App\GraphQL\Type;

use App\Order;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class OrdersType extends GraphQLType {
    protected $attributes = [
        'name' => 'Orders',
        'description' => '订单',
        'model' => Order::class
    ];

    /**
     * 定义返回的字段接口
     * @return array
     */
    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => '订单 id'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => '商品名'
            ]
        ];
    }
}