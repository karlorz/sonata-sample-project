<?php

declare(strict_types=1);
// src/Admin/CategoryAdmin.php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

final class CategoryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('Category Details', ['class' => 'col-md-8'])
                ->add('name', TextType::class, [
                    'label' => 'Category Name',
                ])
            ->end()
            ->with('Blog Posts', ['class' => 'col-md-4'])
                ->add('blogPosts', null, [
                    'by_reference' => false,
                    'required' => false,
                ])
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('name', null, [
                'label' => 'Category Name',
            ])
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id')
            ->add('name', null, [
                'label' => 'Category Name',
            ])
            ->add('blogPosts', null, [
                'associated_property' => 'title',
                'label' => 'Blog Posts',
            ])
            ->add('_actions', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('name')
            ->add('blogPosts', null, [
                'associated_property' => 'title',
                'label' => 'Blog Posts',
            ])
        ;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        // Customize routes if needed
    }
}