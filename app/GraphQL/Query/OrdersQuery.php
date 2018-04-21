<?php
/**
 * User: yemeishu
 * Date: 2018/3/31
 * Time: 下午3:58
 */

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query as GraphQLQuery;

class OrdersQuery extends GraphQLQuery {
    protected $attributes = [
        'name' => 'orders'
    ];

    public function type() {
        return Type::paginate('orders');
    }

    public function args() {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'name' => ['name' => 'name', 'type' => Type::string()],
        ];
    }

}