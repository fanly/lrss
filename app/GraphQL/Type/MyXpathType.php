<?php
/**
 * User: yemeishu
 * Date: 2018/4/21
 * Time: 下午3:59
 */

namespace App\GraphQL\Type;

use App\User;
use App\Xpath;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class MyXpathType extends GraphQLType
{
    protected $attributes = [
        'name' => 'myxpath',
        'description' => 'A type',
        'model' => Xpath::class, // define model for xpath type
    ];

    // define field of type
    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the user'
            ],
            'url' => [
                'type' => Type::string(),
                'description' => 'The url of xpath'
            ],
            'urldesc' => [
                'type' => Type::string(),
                'description' => 'The desc of the xpath'
            ]
        ];
    }
}