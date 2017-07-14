<?php

namespace Envitor\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class Editor
{
    public $data;

    protected $path;

    public function __construct($path)
    {
        $this->setPath($path);

        $this->hydrate();
    }

    /**
     * Set path for .env file
     *
     * @param $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     *
     * Hydrate data with .env file content
     *
     */
    public function hydrate()
    {
        $this->data = collect(explode("\n", File::get($this->path())))
            ->reject(function ($line, $key) {
                return Str::startsWith($line, '#');
            })
            ->keyBy(function ($line, $key) {
                return explode('=', $line)[0];
            })->reject(function ($line, $key) {
                return empty($key);
            })
            ->transform(function ($line, $key) {
                return explode('=', $line)[1];
            })->toArray();
    }

    /**
     * Get the .env file path
     *
     * @return string
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * Check if exists in .env
     *
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return Arr::has($this->data, $key);
    }

    /**
     * Set value for key in .env
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value)
    {
        if (is_array($key)) {
            foreach ($key as $innerKey => $innerValue) {
                Arr::set($this->data, $innerKey, $innerValue);
            }
        } else {
            Arr::set($this->data, $key, $value);
        }

        return $this;
    }

    /**
     * Get value for key in .env
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return Arr::get($this->data, $key, $default);
    }

    /**
     * Get the entire collection of .env content
     *
     * @return mixed
     */
    public function all()
    {
        return $this->data;
    }

    /**
     *
     * Save data to .env file
     *
     */
    protected function save()
    {
        $content = collect($this->data)->transform(function ($item, $key) {
            return $key . '=' . $item;
        })->implode("\n");

        File::put($this->path(), $content);
    }
}