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

use Sonata\BaseApplicationBundle\Admin\EntityAdmin;
use Sonata\BaseApplicationBundle\Admin\FieldDescription;
use Sonata\BaseApplicationBundle\Filter\Filter;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\ChoiceField;
use Application\SandboxBundle\Entity\Comment;

class PostAdmin extends EntityAdmin
{
    protected $class = 'Application\SandboxBundle\Entity\Post';

    protected $listFields = array(
        'title' => array('identifier' => true),
        'enabled',
        'comments_enabled',
    );

    protected $formFields = array(
        'author'  => array('edit' => 'list'),
        'title',
        'abstract',
        'content',
        'tags'      => array('form_field_options' => array('expanded' => true, 'multiple' => true)),
        'enabled',
        'commentsCloseAt',
        'commentsEnabled',
        'commentsDefaultStatus'
    );
    
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

    protected $filterFields = array(
        'title',
        'enabled',
        'tags' => array('filter_field_options' => array('expanded' => true, 'multiple' => true))
    );

    // don't know yet how to get this value
    protected $baseControllerName = 'SandboxBundle:PostAdmin';

    protected $baseRouteName = 'admin_sandbox_post';

    protected $baseRoutePattern = '/sandbox/post';

//    protected function configureFormFields(Form $form)
//    {
//        $form->add('enabled');
//        $form->add('title');
//        $form->add('abstract');
//        $form->add('content');
//        $form->add('tags', array('property' => 'name', 'expanded' => true));
//        $form->add('commentsCloseAt');
//        $form->add('commentsEnabled');
//        $form->add(new ChoiceField('commentsDefaultStatus', array(
//            'choices' => Comment::getStatusCodes()
//        )));
//    }

    public function configureFilterFields()
    {
        $this->filterFields['with_open_comments'] = new FieldDescription;
        $this->filterFields['with_open_comments']->setName('with_open_comments');
        $this->filterFields['with_open_comments']->setTemplate('SonataBaseApplicationBundle:CRUD:filter_callback.twig.html');
        $this->filterFields['with_open_comments']->setType('callback');
        $this->filterFields['with_open_comments']->setOption('filter_options', array(
            'filter' => array($this, 'getWithOpenCommentFilter'),
            'field'  => array($this, 'getWithOpenCommentField')
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

    public function getWithOpenCommentField(Filter $filter)
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