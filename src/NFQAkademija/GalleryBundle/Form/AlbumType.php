<?php
namespace NFQAkademija\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use NFQAkademija\GalleryBundle\Entity\Album;


class AlbumType extends AbstractType
{
    /**
     * @var \NFQAkademija\GalleryBundle\Entity\Album
     */
    protected $album;

    /**
     * @param Album $album
     */
    public function __construct (Album $album)
    {
        $this->album = $album;
    }

    /**
     * Builds album form.
     * If there are no photos in album doesn`t show titlePhoto selection.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->album->getPhotos()->isEmpty()) {
            $builder
                ->add('name')
                ->add('shortDescription')
                ->add('fullDescription')
                ->add('place')
                ->add('shortDescription')
                ->add('save', 'submit');
        } else {
            $builder
                ->add('name')
                ->add('shortDescription')
                ->add('fullDescription')
                ->add('place')
                ->add('shortDescription')
                ->add('titlePhoto', 'entity', array(
                    'class' => 'NFQAkademijaGalleryBundle:Photo',
                    'choices' => $this->album->getPhotos()))
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
                'data_class' => 'NFQAkademija\GalleryBundle\Entity\Album'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nfqakademija_gallerybundle_albumtype';
    }
}