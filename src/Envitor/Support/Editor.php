<?php

namespace Envitor\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class Editor {

	public $data;

	protected $path;

	public function __construct()
	{
		$this->path = base_path('.env');

		$this->initialize();
	}

	public function has($key)
	{
		return Arr::has($this->data, $key);
	}

	public function set($key, $value)
	{
		if (is_array($key)) {
			foreach ($key as $innerKey => $innerValue) {
				Arr::set($this->data, $innerKey, $innerValue);
			}
		} else {
			Arr::set($this->data, $key, $value);
		}

		$this->save();
	}

	protected function save()
	{
		$content = collect($this->data)->transform(function($item, $key) {
			return $key . '=' . $item;
		})->implode("\n");

		File::put($this->path, $content);
	}

	public function get($key, $default = null)
	{
		return Arr::get($this->data, $key, $default);
	}

	protected function initialize()
	{
		$this->data = collect(explode("\n", File::get($this->path)))
			->keyBy(function($line, $key){
				return explode('=', $line)[0];
			})->reject(function($line, $key) {
				return empty($key);
			})
			->transform(function($line, $key) {
				return explode('=', $line)[1];
			})->toArray();
	}
}