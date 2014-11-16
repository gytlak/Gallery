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
     * @param Photo $photo
     * @param array $albums
     */
    public function __construct (Photo $photo, array $albums)
    {
        $this->photo = $photo;
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
        if ($this->photo->getPhoto()) {
            $builder
                ->add('name')
                ->add('shortDescription')
                ->add('tags', 'collection', array(
                    'type'         => new TagType(false),
                    'allow_add'    => true,
                    'prototype' => true,
                    'by_reference' => false,
                ))
                ->add('albums', 'entity', array(
                    'class' => 'KTUGalleryBundle:Album',
                    'choices' => $this->albums,
                    'required' => true,
                    'multiple'  => true,
                ))
                ->add('save', 'submit');
        } else if (!$this->photo->getPhoto()) {
            $builder
                ->add('name')
                ->add('shortDescription')
                ->add('tags', 'collection', array(
                    'type'         => new TagType(false),
                    'allow_add'    => true,
                    'prototype' => true,
                    'by_reference' => false,
                ))
                ->add('albums', 'entity', array(
                    'class' => 'KTUGalleryBundle:Album',
                    'choices' => $this->albums,
                    'required' => true,
                    'multiple'  => true,
                ))
                ->add('photo', 'file', array(
                    'required' => 'true',
                ))
                ->add('save', 'submit');
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'KTU\GalleryBundle\Entity\Photo'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ktu_gallerybundle_phototype';
    }
}