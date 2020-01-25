<?php

namespace App\ApiPathes;

function getApiPathes($user, $templates)
{
    return array_map(function ($template) use ($user) {
        return getApiPath($user, $template);
    }, $templates);
}

function getApiPath($user, $template)
{
    $pathSegments = explode('/', $template);

    $result = array_map(function ($pathSegment) use ($user) {
        if (preg_match('/^%.+%$/', $pathSegment) > 0) {
            $attribute = substr($pathSegment, 1, -1);

            if (!array_key_exists($attribute, $user)) {
                throw new EmptyAttribute();
            }

            return str_replace(' ', '%20', $user[$attribute]);
        }

        return $pathSegment;
    }, $pathSegments);
    return implode('/', $result);
}

class EmptyAttribute extends \Exception
{
    protected $message = 'the attribute is missing';
}
