<?php
namespace NFQAkademija\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use NFQAkademija\GalleryBundle\Entity\Photo;

class PhotoType extends AbstractType
{
    /**
     * @var \NFQAkademija\GalleryBundle\Entity\Photo
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
                    'choices' => $this->albums,
                    'required' => true,
                    'multiple'  => true,
                ))
                ->add('save', 'submit');
        } else if (!$this->photo->getPhoto()) {
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
                'data_class' => 'NFQAkademija\GalleryBundle\Entity\Photo'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nfqakademija_gallerybundle_phototype';
    }
}