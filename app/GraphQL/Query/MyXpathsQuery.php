<?php
/**
 * User: yemeishu
 * Date: 2018/4/21
 * Time: 下午11:16
 */

namespace App\GraphQL\Query;

use App\Xpath;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use Tymon\JWTAuth\Facades\JWTAuth;

class MyXpathsQuery extends Query {
    private $auth;

    protected $attributes = [
        'name' => 'My Xpaths Query',
        'description' => 'My Xpaths Information'
    ];

    public function authorize(array $args) {
        try {
            $this->auth = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            $this->auth = null;
        }

        return (boolean) $this->auth;
    }

    public function type() {
        return Type::listOf(GraphQL::type('myxpath'));
    }

    public function resolve($root, $args, SelectFields $fields) {
        $xpaths = Xpath::with(array_keys($fields->getRelations()))
            ->where('user_id', $this->auth->id)
            ->select($fields->getSelect())
            ->get();

        return $xpaths;
    }
}