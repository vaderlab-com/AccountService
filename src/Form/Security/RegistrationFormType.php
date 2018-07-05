<?php
/**
 * Created by PhpStorm.
 * User: kost
 * Date: 05.07.2018
 * Time: 0:38
 */

namespace App\Form\Security;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class RegistrationFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->remove('username')
            ->add('firstName')
            ->add('lastName')
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'vaderlab_user_registration';
    }
}