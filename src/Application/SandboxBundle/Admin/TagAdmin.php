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
use Symfony\Component\Form\Form;

class TagAdmin extends EntityAdmin
{
    protected $class = 'Application\SandboxBundle\Entity\Tag';

    protected $listFields = array(
        'name' => array('identifier' => true),
        'slug',
        'enabled',
    );

    protected $formFields = array(
        'name',
        'enabled'
    );

    // don't know yet how to get this value
    protected $baseControllerName = 'SandboxBundle:TagAdmin';

    protected $baseRouteName = 'admin_sandbox_tag';

    protected $baseRoutePattern = '/sandbox/tag';

//    protected function configureFormFields(Form $form)
//    {
//        $form->add('name');
//        $form->add('enabled');
//    }
}