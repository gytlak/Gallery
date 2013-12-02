<?php
namespace NFQAkademija\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tag');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NFQAkademija\GalleryBundle\Entity\Tag',
        ));
    }

    public function getName()
    {
        return 'nfqakademija_gallerybundle_tagtype';
    }
}