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
        $template = $this->twig->load('template.html.twig');

        return $template->render(['offers' => $offers]);
    }
}