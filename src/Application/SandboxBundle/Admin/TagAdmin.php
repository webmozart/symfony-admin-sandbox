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

class TagAdmin extends EntityAdmin
{
    protected $class = 'Application\SandboxBundle\Entity\Tag';

    protected $baseControllerName = 'SandboxBundle:TagAdmin';

    protected $baseRouteName = 'admin_sandbox_tag';

    protected $baseRoutePattern = '/sandbox/tag';

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('name');
        $form->add('enabled');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->add('name', array('identifier' => true));
        $list->add('slug');
        $list->add('enabled');
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid)
    {
        $datagrid->add('name');
    }
}