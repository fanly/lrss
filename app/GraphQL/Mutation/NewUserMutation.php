<?php
/**
 * User: yemeishu
 * Date: 2018/4/3
 */

namespace App\GraphQL\Mutation;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use App\User;

class NewUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'NewUser'
    ];

    public function type()
    {
        return GraphQL::type('users');
    }

    public function args()
    {
        return [
            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string())
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string())
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }
    public function resolve($root, $args) {
        $args['password'] = bcrypt($args['password']);
        $user = User::create($args);

        if (!$user) {
            return null;
        }

        return $user;
    }
}