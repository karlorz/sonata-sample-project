<?php

declare(strict_types=1);
// src/Admin/BlogPostAdmin.php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use App\Entity\Category;
use App\Entity\Attachment;
use App\Form\AttachmentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

final class BlogPostAdmin extends AbstractAdmin
{
    // protected function configure(): void
    // {
    //     $this->setTemplate('edit', 'admin/blog_post_edit.html.twig');
    //     dump($this->getParent()->getCode());
    // }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('Blog Post Details', ['class' => 'col-md-8'])
                ->add('title', TextType::class, [
                    'label' => 'Title',
                ])
                ->add('body', TextareaType::class, [
                    'label' => 'Content',
                ])
                ->add('draft', CheckboxType::class, [
                    'label' => 'Draft Status',
                    'required' => false,
                ])
            ->end()
            ->with('Category', ['class' => 'col-md-4'])
                ->add('category', ModelAutocompleteType::class, [
                    'class' => Category::class,
                    'property' => 'name',
                    'label' => 'Category',
                    'btn_add' => true,
                    'placeholder' => 'Select a category',
                ])
            ->end()
            ->with('Attachments', ['class' => 'col-md-12'])
                ->add('attachments', CollectionType::class, [
                    'by_reference' => false,
                    'entry_type' => AttachmentType::class,
                    'label' => 'Attachments',
                    'required' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                    'admin_code' => 'app.admin.attachment',
                    'btn_add' => true,
                    'btn_catalogue' => 'SonataAdminBundle',
                ])
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid
            ->add('title', null, [
                'label' => 'Title',
            ])
            ->add('draft', null, [
                'label' => 'Draft Status',
            ])
            ->add('category', null, [
                'label' => 'Category',
            ])
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id')
            ->add('title', null, [
                'label' => 'Title',
            ])
            ->add('draft', null, [
                'label' => 'Draft Status',
                'editable' => true,
            ])
            ->add('category', null, [
                'label' => 'Category',
                'associated_property' => 'name',
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
            ->add('title')
            ->add('body')
            ->add('draft', null, [
                'label' => 'Draft Status',
            ])
            ->add('category', null, [
                'label' => 'Category',
                'associated_property' => 'name',
            ])
            ->add('attachments', null, [
                'label' => 'Attachments',
                'associated_property' => 'filename',
            ])
        ;
    }

    protected function configureRoutes(\Sonata\AdminBundle\Route\RouteCollectionInterface $collection): void
    {
        // Customize routes if needed
    }
}