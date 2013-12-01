<?php
namespace NFQAkademija\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use NFQAkademija\GalleryBundle\Entity\Album;


class AlbumType extends AbstractType
{

    protected $album;

    public function __construct (Album $album)
    {
        $this->album = $album;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $album = $this->album;

        $builder
            ->add('name')
            ->add('shortDescription')
            ->add('fullDescription')
            ->add('place')
            ->add('shortDescription')
            ->add('titlePhoto', 'entity', array(
                'class' => 'NFQAkademijaGalleryBundle:Photo',
                'choices' => $album->getPhotos()))
            ->add('save', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'NFQAkademija\GalleryBundle\Entity\Album'
            )
        );
    }

    public function getName()
    {
        return 'nfqakademija_gallerybundle_albumtype';
    }
}