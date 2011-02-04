<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\SandboxBundle\Admin;

use Sonata\BaseApplicationBundle\Form\FormMapper;
use Sonata\BaseApplicationBundle\Datagrid\DatagridMapper;
use Sonata\BaseApplicationBundle\Datagrid\ListMapper;
use Sonata\BaseApplicationBundle\Admin\EntityAdmin;
use Sonata\BaseApplicationBundle\Admin\FieldDescription;

use Application\SandboxBundle\Entity\Comment;

class PostAdmin extends EntityAdmin
{
    protected $class = 'Application\SandboxBundle\Entity\Post';

    protected $formGroups = array(
        'General' => array(
            'fields' => array('author', 'title', 'abstract', 'content'),
        ),
        'Tags' => array(
            'fields' => array('tags'),
        ),
        'Options' => array(
            'fields' => array('enabled', 'commentsCloseAt', 'commentsEnabled', 'commentsDefaultStatus'),
            'collapsed' => true
        )
    );

    // don't know yet how to get this value
    protected $baseControllerName = 'SandboxBundle:PostAdmin';

    protected $baseRouteName = 'admin_sandbox_post';

    protected $baseRoutePattern = '/sandbox/post';

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('author', array(), array('edit' => 'list'));
        $form->add('title');
        $form->add('abstract');
        $form->add('content');
        $form->add('tags', array(), array('form_field_options' => array('expanded' => true, 'multiple' => true)));
        $form->add('enabled');
        $form->add('commentsCloseAt');
        $form->add('commentsEnabled');
        $form->add(new \Symfony\Component\Form\ChoiceField('commentsDefaultStatus', array('choices' => Comment::getStatusCodes())));
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->add('title', array('identifier' => true));
        $list->add('enabled');
        $list->add('commentsEnabled');
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid)
    {
        $datagrid->add('title');
        $datagrid->add('enabled');
        $datagrid->add('tags', array('filter_field_options' => array('expanded' => true, 'multiple' => true)));
        $datagrid->add('with_open_comments', array(
            'template' => 'SonataBaseApplicationBundle:CRUD:filter_callback.twig.html',
            'type' => 'callback',
            'filter_options' => array(
                'filter' => array($this, 'getWithOpenCommentFilter'),
                'field'  => array($this, 'getWithOpenCommentField')
            )
        ));
    }

    public function getWithOpenCommentFilter($queryBuilder, $alias, $field, $value)
    {

        if(!$value) {
            return;
        }

        $queryBuilder->leftJoin(sprintf('%s.comments', $alias), 'c');
        $queryBuilder->andWhere('c.status = :status');
        $queryBuilder->setParameter('status', \Application\SandboxBundle\Entity\Comment::STATUS_MODERATE);
    }

    public function getWithOpenCommentField($filter)
    {

        return new \Symfony\Component\Form\CheckboxField(
            $filter->getName(),
            array()
        );
    }

    public function preInsert($post)
    {
        parent::preInsert($post);

        if(isset($this->formFields['author'])) {
            $this->container->get('fos_user.user_manager')->updatePassword($post->getAuthor());
        }
    }

    public function preUpdate($post)
    {
        parent::preUpdate($post);

        if(isset($this->formFields['author'])) {
            $this->container->get('fos_user.user_manager')->updatePassword($post->getAuthor());
        }
    }
}