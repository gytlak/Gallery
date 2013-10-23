<?php
namespace NFQAkademija\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('shortDescription')
            ->add('fullDescription')
            ->add('place')
            ->add('shortDescription')
            ->add('titlePhoto')
            ->add('save', 'submit');
    }



    public function getName()
    {
        return 'nfqakademija_gallerybundle_albumtype';
    }
}