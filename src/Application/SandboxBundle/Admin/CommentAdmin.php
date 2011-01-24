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
use Application\SandboxBundle\Entity\Comment;

class CommentAdmin extends EntityAdmin
{

    protected $class = 'Application\SandboxBundle\Entity\Comment';

    protected $listFields = array(
        'name' => array('identifier' => true),
        'getStatusCode' => array('label' => 'status_code'),
        'post',
        'email',
        'url',
        'message',
    );

    protected $formFields = array(
        'name',
        'email',
        'url',
        'message',
        'post' => array('edit' => 'list'),
        'status' => array('type' => 'choice'),
    );

    // don't know yet how to get this value
    protected $baseControllerName = 'SandboxBundle:CommentAdmin';

    protected $baseRouteName = 'admin_sandbox_comment';

    protected $baseRoutePattern = '/sandbox/comment';

    public function configureFormFields()
    {

        $this->formFields['status']->setType('choice');
        $options = $this->formFields['status']->getOption('form_field_options', array());
        $options['choices'] = Comment::getStatusList();
//        $options['expanded'] = true;

        $this->formFields['status']->setOption('form_field_options', $options);
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