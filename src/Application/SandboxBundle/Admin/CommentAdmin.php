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
use Symfony\Component\Form\ChoiceField;

class CommentAdmin extends EntityAdmin
{

    protected $class = 'Application\SandboxBundle\Entity\Comment';

    protected $baseControllerName = 'SandboxBundle:CommentAdmin';

    protected $baseRouteName = 'admin_sandbox_comment';

    protected $baseRoutePattern = '/sandbox/comment';


    protected function configureFormFields(FormMapper $form)
    {
        $form->add('name');
        $form->add('email');
        $form->add('url');
        $form->add('message');
        $form->add('post');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->add('name', array('identifier' => true));
        $list->add('getStatusCode', array('type' => 'string'));
        $list->add('email');
        $list->add('post');
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid)
    {
        $datagrid->add('name');
        $datagrid->add('email');
    }
    

    public function getBatchActions()
    {
        return array(
            'delete'    => 'action_delete',
            'enabled'   => 'enable_comments',
            'disabled'  => 'disabled_comments',
        );
    }
}