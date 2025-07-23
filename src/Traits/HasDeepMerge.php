<?php

declare(strict_types=1);

namespace VSApi\Traits;

use Illuminate\Support\Str;
use VSApi\Exceptions\ApiException;

trait HasDeepMerge
{

    /**
     * Deep merge a config file into the Laravel config using paths.
     *
     * @param string $configKey The Laravel config key to merge into (e.g. 'auth')
     * @param string $filePath Absolute or relative path to the PHP config file
     * @return void
     */
    public function mergeDeepConfigFromPath(string $configKey, string $filePath): void
    {
        $realPath = realpath($filePath);

        if (!$realPath || !file_exists($realPath)) {
            throw new \InvalidArgumentException("Config file not found at path: $filePath");
        }

        $newConfig = require $realPath;

        if (!is_array($newConfig)) {
            throw new \UnexpectedValueException("Config file must return an array: $filePath");
        }

        $existing = config($configKey, []);
        $merged = $this->arrayMergeDeep($existing, $newConfig);
        config([$configKey => $merged]);
    }


    /**
     * Recursively merge two arrays.
     *
     * @param array $target
     * @param array $source
     * @return array
     */
    protected function arrayMergeDeep(array $target, array $source): array
    {
        foreach ($source as $key => $value) {
            if (
                isset($target[$key])
                && is_array($target[$key])
                && is_array($value)
            ) {
                $target[$key] = $this->arrayMergeDeep($target[$key], $value);
            } else {
                $target[$key] = $value;
            }
        }

        return $target;
    }

}
