<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

use Application\SandboxBundle\Entity\Post;
use Application\SandboxBundle\Entity\Author;
use Application\SandboxBundle\Entity\Comment;
use Application\SandboxBundle\Entity\Tag;

class AllData implements FixtureInterface
{
    public function load($manager)
    {

        $tags = array(
            'symfony', 'security', 'validator', 'container', 'acl', 'twig', 'i18n','event', 'esi','form', 'admin'
        );


        // load tag
        foreach($tags as $tag) {
            ${$tag} = new Tag;
            ${$tag}->setName($tag);
            ${$tag}->setEnabled(true);

            $manager->persist(${$tag});
        }

        $manager->flush();

        $authors = array();
        foreach(range(1, 500) as $id) {
            $author = new Author;
            $author->setName('John Doe '.$id);
            $author->setEmail('john.doe.'.$id.'@symfony-reloaded.admin');
            $authors[$id] = $author;
            $manager->persist($author);

        }
        $manager->flush();

        foreach(range(1, 200) as $id){
            $post = new Post;
            $post->setCommentsDefaultStatus(Comment::STATUS_VALID);
            $post->setEnabled(true);
            $post->setTitle('Post '.$id);
            $post->setAbstract('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec semper, diam et imperdiet tempor, erat augue semper nisl, quis lacinia libero diam eget sapien. Nullam ac sem nulla, id accumsan metus. In tincidunt odio a neque imperdiet scelerisque. In a mi et libero semper lobortis.');
            $post->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec semper, diam et imperdiet tempor, erat augue semper nisl, quis lacinia libero diam eget sapien. Nullam ac sem nulla, id accumsan metus. In tincidunt odio a neque imperdiet scelerisque. In a mi et libero semper lobortis. Maecenas vulputate justo vitae orci lobortis adipiscing. Donec et diam magna, facilisis rutrum purus. Morbi libero elit, luctus at aliquam ac, eleifend quis diam. Curabitur at mi purus. Nulla facilisi. Nulla pulvinar bibendum nibh, non feugiat lorem bibendum ultricies. Suspendisse vulputate malesuada justo, a elementum lorem commodo vitae. Nam diam elit, posuere in accumsan nec, gravida sed justo. Duis pharetra, ipsum in dictum consequat, nisi ipsum posuere tellus, a ultrices felis augue non ligula. Mauris lacus tellus, placerat sit amet hendrerit quis, molestie sed eros.

Vivamus in augue lorem. In in augue id odio iaculis malesuada. Etiam sed erat sagittis nunc posuere bibendum. Quisque ornare dui in mauris venenatis at vestibulum augue porta. Sed facilisis commodo mollis. Curabitur non euismod purus. Vivamus in sapien risus. Fusce non mauris eget massa porta consectetur. Nulla placerat, ipsum sit amet hendrerit viverra, elit metus molestie augue, placerat ullamcorper lorem lectus et enim. Nunc vitae euismod felis. Quisque elementum nisl vel nisl dictum dapibus. Nullam tempus ante vitae dolor convallis et aliquet quam placerat. Phasellus varius nunc eu ante luctus sit amet mollis urna pellentesque. Cras gravida augue et urna feugiat convallis dignissim ligula porta. Integer ut sapien nunc, ac condimentum enim. Pellentesque eu odio a sapien malesuada viverra eu id dolor. Vivamus sed metus diam. Mauris id rutrum sapien. Mauris ut mi vel metus pharetra aliquet.

Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur nec semper dui. Nulla sit amet nulla nec felis eleifend faucibus sit amet nec metus. Morbi egestas dictum aliquet. Etiam et libero velit, sit amet convallis nunc. Phasellus tincidunt nibh at orci adipiscing pulvinar. Vestibulum in dui quam. Ut interdum tellus sit amet sapien mollis mattis. Nullam laoreet lacus sed risus fringilla porta. In a tellus ac diam eleifend vehicula vitae aliquam ligula. Proin mattis diam eu ligula rhoncus vel condimentum neque ultrices. Praesent non pharetra lectus. Pellentesque viverra tristique ultricies. Donec aliquet nunc at ligula aliquet non fringilla dui luctus. Curabitur ut quam vel lectus rutrum posuere. Aenean ultrices turpis eget purus faucibus volutpat. Aliquam adipiscing odio vel purus congue sed mattis massa vehicula. Sed at arcu in massa cursus eleifend.

Aenean luctus porta condimentum. Vestibulum ac dolor lorem, in porta elit. Fusce porttitor elementum pretium. Donec placerat dignissim sodales. Proin nec sodales ligula. Maecenas mollis tincidunt eros, ac facilisis nibh eleifend ac. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent a tortor odio. Sed id diam id urna tempor ullamcorper id vitae tortor. Aenean lacus dui, malesuada et iaculis sed, mattis et libero. Cras orci dolor, dignissim sed aliquet elementum, sodales eu lacus. Sed vestibulum erat eu diam vulputate iaculis.');

            $post->setAuthor($authors[$id]);

            $post->setTags(array(
                $symfony,
                $security,
                $admin,
            ));

            foreach(range(1, 20) as $cid) {
                $comment = new Comment;
                $comment->setEmail('e@mail.foo');
                $comment->setMessage('Vivamus in augue lorem. In in augue id odio iaculis malesuada.');
                $comment->setPost($post);
                $comment->setName('Jane doe');
                $comment->setUrl('http://symfony-reloaded.org');
                $manager->persist($comment);

                $post->addComments($comment);

            }

            $manager->persist($post);
        }


        $manager->flush();
    }
}