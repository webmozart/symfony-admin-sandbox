#!/bin/sh

# initialization
DIR=`php -r "echo realpath(dirname(\\$_SERVER['argv'][0]));"`
VENDOR=$DIR/vendor
SONATA=$DIR/Sonata

if [ -d "$VENDOR" ]; then
  rm -rf $VENDOR/*
else
  mkdir $VENDOR
fi

if [ -d "$SONATA" ]; then
  rm -rf $SONATA/BaseApplicationBundle
  rm -rf $SONATA/jQueryBundle
  rm -rf $SONATA/BluePrintBundle
else
  mkdir $SONATA
fi

# Symfony (Branch master)
git clone git://github.com/fabpot/symfony.git $VENDOR/symfony

# Doctrine ORM (Tag 2.0.0)
git clone git://github.com/doctrine/doctrine2.git $VENDOR/doctrine
cd $VENDOR/doctrine
git reset --hard 2.0.0

# Doctrine DBAL (Tag 2.0.0)
git clone git://github.com/doctrine/dbal.git $VENDOR/doctrine-dbal
cd $VENDOR/doctrine-dbal
git reset --hard 2.0.0

# Doctrine Common (Tag 2.0.0)
git clone git://github.com/doctrine/common.git $VENDOR/doctrine-common
cd $VENDOR/doctrine-common
git reset --hard 2.0.0

# Doctrine migrations (Branch master)
git clone git://github.com/doctrine/migrations.git $VENDOR/doctrine-migrations

# Doctrine MongoDB (Tag 1.0.0BETA1)
git clone git://github.com/doctrine/mongodb-odm.git $VENDOR/doctrine-mongodb
cd $VENDOR/doctrine-mongodb
git reset --hard 1.0.0BETA1

# Swiftmailer (Branch origin/4.1)
git clone git://github.com/swiftmailer/swiftmailer.git $VENDOR/swiftmailer
cd $VENDOR/swiftmailer
git checkout -b 4.1 origin/4.1

# Twig (Branch master)
git clone git://github.com/fabpot/Twig.git $VENDOR/twig

# Zend Framework (Branch master)
git clone git://github.com/zendframework/zf2.git $VENDOR/zend

# BaseApplicationBundle (Branch master)
git clone git://github.com/sonata-project/BaseApplicationBundle.git $SONATA/BaseApplicationBundle

# jQueryBundle (Branch master)
git clone git://github.com/sonata-project/jQueryBundle.git $SONATA/jQueryBundle

# BluePrintBundle (Branch master)
git clone git://github.com/sonata-project/BluePrintBundle.git $SONATA/BluePrintBundle