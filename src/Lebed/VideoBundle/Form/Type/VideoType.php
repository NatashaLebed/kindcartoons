<?php

namespace Lebed\VideoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lebed\VideoBundle\Entity\Category;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $em = $this->getDoctrine()->getManager();
//        $repo = $em->getRepository('LebedVideoBundle:Category');
//        $categories = $repo->childrenHierarchy();

        $builder
            ->add('link', 'text')
            ->add('title', 'text')
            ->add('description', 'textarea')
            ->add('author', 'text')
            ->add('country', 'entity', array(
                'class' => 'LebedVideoBundle:Country',
                'property' => 'name',
                'required' => 'false'
            ))
            ->add('language', 'entity', array(
                'class' => 'LebedVideoBundle:Language',
                'property' => 'name',
                'required' => 'false'
            ))
            ->add('type', 'entity', array(
                'class' => 'LebedVideoBundle:Type',
                'property' => 'name',
                'required' => 'false'
            ))
            ->add('year', 'integer')
            ->add('category', 'entity', array(
                'class' => 'LebedVideoBundle:Category',
                'property' => 'title',
                'required' => 'false'
            ))
            ->add('save', 'submit')
            ->getForm();
    }

    public function getName()
    {
        return 'video';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lebed\VideoBundle\Entity\Video',
        ));
    }
}

