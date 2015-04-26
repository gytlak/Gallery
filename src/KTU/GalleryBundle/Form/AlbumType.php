<?php
namespace KTU\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use KTU\GalleryBundle\Entity\Album;


class AlbumType extends AbstractType
{
    /**
     * @var \KTU\GalleryBundle\Entity\Album
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
                ->add('fullDescription')
                ->add('save', 'submit');
        } else {
            $builder
                ->add('name')
                ->add('fullDescription')
                ->add(
                    'titlePhoto',
                    'entity',
                    [
                        'class' => 'KTUGalleryBundle:Photo',
                        'choices' => $this->album->getPhotos()
                    ]
                )
                ->add('save', 'submit');
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'KTU\GalleryBundle\Entity\Album'
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ktu_gallerybundle_albumtype';
    }
}
