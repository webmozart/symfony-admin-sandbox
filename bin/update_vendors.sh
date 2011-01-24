#!/bin/sh

DIR=`php -r "echo realpath(dirname(\\$_SERVER['argv'][0]));"`
VENDOR=$DIR/vendor

# Symfony
cd $VENDOR/symfony && git pull

# Doctrine ORM
cd $VENDOR/doctrine && git fetch origin && git reset --hard 2.0.0

# Doctrine DBAL
cd $VENDOR/doctrine-dbal && git fetch origin && git reset --hard 2.0.0

# Doctrine common
cd $VENDOR/doctrine-common && git fetch origin && git reset --hard 2.0.0

# Doctrine migrations
cd $VENDOR/doctrine-migrations && git pull

# Doctrine MongoDB
cd $VENDOR/doctrine-mongodb && git fetch origin && git reset --hard 1.0.0BETA1

# Swiftmailer
cd $VENDOR/swiftmailer && git pull

# Twig
cd $VENDOR/twig && git pull

# Zend Framework
cd $VENDOR/zend && git pull
git submodule update --recursive --init

# BaseApplicationBundle
cd $DIR/Sonata/BaseApplicationBundle && git pull

# jQueryBundle
cd $DIR/Sonata/jQueryBundle && git pull