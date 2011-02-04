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

class AuthorAdmin extends EntityAdmin
{

    protected $class = 'Application\SandboxBundle\Entity\Author';

    // don't know yet how to get this value
    protected $baseControllerName = 'SandboxBundle:AuthorAdmin';

    protected $baseRouteName = 'admin_sandbox_author';

    protected $baseRoutePattern = '/sandbox/author';

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('name');
        $form->add('email');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->add('name', array('identifier' => true));
        $list->add('email');
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