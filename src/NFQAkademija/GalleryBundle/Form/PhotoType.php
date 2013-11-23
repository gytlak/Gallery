<?php
namespace NFQAkademija\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('shortDescription')
            ->add('photoDate')
            ->add('album', 'entity', array(
                'class' => 'NFQAkademijaGalleryBundle:Album',
                'multiple'  => true))
            ->add('photoUrl')
            ->add('thumbUrl')
            ->add('save', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'NFQAkademija\GalleryBundle\Entity\Photo'
            )
        );
    }

    public function getName()
    {
        return 'nfqakademija_gallerybundle_phototype';
    }
}