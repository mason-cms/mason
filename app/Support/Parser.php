<?php

namespace App\Support;

use Thunder\Shortcode\ShortcodeFacade;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;
use Urodoz\Truncate\TruncateService;

class Parser
{
    protected $shortcodeFacade;
    protected $truncateService;

    public function __construct()
    {
        $this->shortcodeFacade = new ShortcodeFacade;
        $this->truncateService = new TruncateService;
    }

    public function registerShortcode(string $signature, callable $callback)
    {
        return $this->shortcodeFacade->addHandler($signature, function (ShortcodeInterface $s) use ($callback) {
            return call_user_func($callback, $s->getParameters());
        });
    }

    public function process(string $content)
    {
        $content = $this->shortcodeFacade->process($content);

        return $content;
    }

    public function truncate(string $html, int $length = 240, string $ending = '...', bool $exact = false, bool $considerHtml = true)
    {
        return $this->truncateService->truncate($html, $length, $ending, $exact, $considerHtml);
    }
}
