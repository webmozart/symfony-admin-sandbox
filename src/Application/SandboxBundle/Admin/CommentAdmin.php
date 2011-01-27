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
use Symfony\Component\Form\Form;
use Symfony\Component\Form\ChoiceField;

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

    // don't know yet how to get this value
    protected $baseControllerName = 'SandboxBundle:CommentAdmin';

    protected $baseRouteName = 'admin_sandbox_comment';

    protected $baseRoutePattern = '/sandbox/comment';

    protected function configureFormFields(Form $form)
    {
        $form->add('name');
        $form->add('email');
        $form->add('url');
        $form->add('message');
        $form->add('post', array('required' => false));
        $form->add(new ChoiceField('status', array(
            'choices' => Comment::getStatusCodes(),
            'required' => false,
            'empty_value' => 'none',
        )));
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