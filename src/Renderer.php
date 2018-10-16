<?php

class Renderer
{
    private $twig;

    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem(__DIR__);
        $this->twig = new Twig_Environment($loader);
    }

    public function render(array $offers)
    {
        $mode = Args::getMode();
        $template = $this->twig->load("templates/$mode.html.twig");

        return $template->render(['offers' => $offers]);
    }
}