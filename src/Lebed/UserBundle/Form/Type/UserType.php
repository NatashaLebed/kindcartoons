<?php

namespace Lebed\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lebed\UserBundle\Entity\User;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name',
                  'text',
                   array('data' => 'Default value'))
            ->add('last_name', 'text')
            ->add('gender', 'choice', array(
                'choices'   => array('m' => 'Male', 'f' => 'Female'),
                'required'  => false,
                'empty_value' => 'Your gender',
                'empty_data'  => null
            ))
            ->add('birth_day', 'date')
            ->add('time_limit', 'time')
            ->add('save', 'submit')
            ->getForm();
    }

    public function getName()
    {
        return 'user';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lebed\UserBundle\Entity\User',
        ));
    }
}

