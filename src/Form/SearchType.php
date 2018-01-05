<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SearchType extends AbstractType
{

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->setAction(
                $this->urlGenerator->generate(
                    'search'
                ))
            ->add('text', null, [
                'attr' => [
                    'placeholder' => 'Test name or tag...',
                ]
            ]);
    }

    public function getBlockPrefix()
    {
        return null;
    }
}
