<?php


namespace App\Twig;


use App\Entity\Tag;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UrlGenerator extends AbstractExtension
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('testByTagUrl',[$this,'getTestByTagUrl'])
        ];
    }

    public function getTestByTagUrl(Tag $tag)
    {
        return $this->router->generate('tests_by_tag',['name' => $tag->getName()]);
    }
}