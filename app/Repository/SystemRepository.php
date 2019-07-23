<?php declare(strict_types=1);

namespace Classic\Secret\Core\Repository;


use Classic\Package\Support\Tool\Dot\Dot;
use Classic\Secret\Core\Foundation\Architecture\ServiceTrait;

class SystemRepository
{
    use ServiceTrait;

    /**
     * @var string
     */
    private $path;
    /**
     * @var array
     */
    private $data;

    public function __construct(
    )
    {
        $this->path = config('system.storage.path');
        $this->load();
    }

    public function find(string $path, $default = null)
    {
        return Dot::find($this->data, $path, $default);
    }

    public function set(string $path, $value): void
    {
        Dot::set($this->data, $path, $value);

        $this->save();
    }

    private function save(): void
    {
        $json = json_encode($this->data);

        file_put_contents($this->path, $json);
    }

    private function load()
    {
        if (!file_exists($this->path)) {
            return;
        }

        $json = file_get_contents($this->path) ?? '{}';

        $this->data = json_decode($json, true);
    }
}