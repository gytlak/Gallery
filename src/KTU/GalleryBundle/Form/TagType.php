<?php
namespace KTU\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TagType extends AbstractType
{
    /**
     * @var
     */
    protected $search;

    /**
     * @param $search
     */
    public function __construct ($search)
    {
        $this->search = $search;
    }

    /**
     * Builds tag form.
     * Cheks if it`s for search,
     * if it is add`s submit button.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->search) {
            $builder
                ->add('name')
                ->add('search', 'submit');
        } else {
            $builder->add('name');
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'KTU\GalleryBundle\Entity\Tag',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ktu_gallerybundle_tagtype';
    }
}
