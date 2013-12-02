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
            ->add('photoDate', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ))
            ->add('tags', 'collection', array(
                'type'         => new TagType(),
                'allow_add'    => true,
                'by_reference' => false,
            ))
            ->add('album', 'entity', array(
                'class' => 'NFQAkademijaGalleryBundle:Album',
                'multiple'  => true,
            ))
            ->add('photo', 'file', array(
                'required' => 'true',
            ))
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