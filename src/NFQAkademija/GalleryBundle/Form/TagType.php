<?php
namespace NFQAkademija\GalleryBundle\Form;

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
        $resolver->setDefaults(array(
            'data_class' => 'NFQAkademija\GalleryBundle\Entity\Tag',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nfqakademija_gallerybundle_tagtype';
    }
}