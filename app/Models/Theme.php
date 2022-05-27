<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $name;
    protected $package;
    protected $vendor;
    protected $project;
    protected $version;

    public function __construct($name = null)
    {
        parent::__construct();

        $this->name = $name ?? config('site.theme');

        $nameParts = explode(':', $this->name, 2);
        $this->package = $nameParts[0] ?? null;
        $this->version = $nameParts[1] ?? null;

        $packageParts = explode('/', $this->package, 2);
        $this->vendor = $packageParts[0] ?? null;
        $this->project = $packageParts[1] ?? null;
    }

    public function name()
    {
        return $this->name;
    }

    public function vendor()
    {
        return $this->vendor;
    }

    public function project()
    {
        return $this->project;
    }

    public function package()
    {
        return $this->package;
    }

    public function version()
    {
        return $this->version;
    }

    public function path($path = '')
    {
        return !empty($path)
            ? base_path("vendor/{$this->package}/{$path}")
            : base_path("vendor/{$this->package}");
    }

    public function public_path($path = '')
    {
        return !empty($path)
            ? public_path("themes/{$this->project}/{$path}")
            : public_path("themes/{$this->project}");
    }

    public function asset($path, $secure = null)
    {
        return asset("themes/{$this->project}/{$path}", $secure);
    }
}
