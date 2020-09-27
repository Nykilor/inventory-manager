<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;

trait AddUserFilteringToDataFetchTrait
{
    /**
     * Calls a given method ($func) on $builder with user data given in url query parameter with the spread of given array of $parameters
     * @param Builder $builder
     * @param string $user_query $_GET key
     * @param string $func f.i where, whereIn etc
     * @param array $parameters f.i ['id', '='], ['category_id']
     */
    protected function addUserFilteringToDataFetch(Builder &$builder, string $user_query, string $func, array $parameters)
    {
        $request = $this->request;

        if ($user_query_value = $request->query($user_query)) {
            if (strpos($user_query_value, '[') === 0 && strpos($user_query_value, ']') > 1) {
                $parameters[] = array_filter(explode(',', str_replace(['[',']'], "", $user_query_value)));
            } else {
                $parameters[] = $user_query_value;
            }

            $builder->$func(...$parameters);
        }
    }
}
