<?php
namespace KTU\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use KTU\GalleryBundle\Entity\Photo;

class PhotoType extends AbstractType
{
    /**
     * @var \KTU\GalleryBundle\Entity\Photo
     */
    protected $photo;

    /**
     * @var array
     */
    protected $albums;

    /**
     * @param array $albums
     */
    public function __construct (array $albums)
    {
        $this->albums = $albums;
    }

    /**
     * Builds photo form.
     * If photo (file) is set, doesn`t show file uploader.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('shortDescription')
            ->add('tags', 'collection', [
                'type'         => new TagType(false),
                'allow_add'    => true,
                'prototype' => true,
                'by_reference' => false,
                'options' => ['label' => false]
            ])
            ->add('albums', 'entity', [
                'class' => 'KTUGalleryBundle:Album',
                'choices' => $this->albums,
                'required' => true,
                'multiple'  => true,
            ])
            ->add('photos', 'file', [
                'required' => true,
                'multiple' => true,
                'attr'  => [
                    'accept' => 'image/*',
                    'multiple' => 'multiple',
                ],
            ])
            ->add('save', 'submit');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ktu_gallerybundle_phototype';
    }
}
