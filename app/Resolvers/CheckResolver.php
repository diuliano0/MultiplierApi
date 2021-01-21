<?php

namespace App\Resolvers;

use OwenIt\Auditing\Contracts\UserResolver;

class CheckResolver implements UserResolver
{
	/**
	 * Resolve the ID of the logged User.
	 *
	 * @return mixed|null
	 */
	public static function resolveId()
	{
		return auth()->guard('api')->check() ? auth()->guard('api')->user()->getAuthIdentifier() : null;
	}

    /**
     * @inheritDoc
     */
    public static function resolve()
    {
        // TODO: Implement resolve() method.
    }
}
