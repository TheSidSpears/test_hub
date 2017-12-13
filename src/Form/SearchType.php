<?php

namespace App\Form;

use App\Entity\TestSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('search',null,[
            'attr' => [
                'placeholder' => 'Test name or tag...'
            ]
        ]);
    }
}
