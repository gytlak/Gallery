<?php
namespace NFQAkademija\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use NFQAkademija\GalleryBundle\Entity\Photo;

class PhotoType extends AbstractType
{

    protected $photo;

    public function __construct (Photo $photo)
    {
        $this->photo = $photo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->photo->getPhoto()) {
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
                    'prototype' => true,
                    'by_reference' => false,
                ))
                ->add('album', 'entity', array(
                    'class' => 'NFQAkademijaGalleryBundle:Album',
                    'multiple'  => true,
                ))
                ->add('save', 'submit');
        } else {
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
                    'prototype' => true,
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