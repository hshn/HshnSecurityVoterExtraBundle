HshnSecurityVoterGeneratorBundle
============================

[![Build Status](https://travis-ci.org/hshn/HshnSecurityVoterGeneratorBundle.svg?branch=rename)](https://travis-ci.org/hshn/HshnSecurityVoterGeneratorBundle)

This bundle provides the way to define definition of simple security voters for symfony

## Installation

### Step 1: Download HshnSecurityVoterGeneratorBundle using composer

```bash
$ php composer.phar require hshh/security-voter-extra-bundle:dev-master
```

### Step 2: Enable the bundle

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new \Hshn\ClassMatcherBundle\HshnClassMatcherBundle(),
        new \Hshn\SecurityVoterGeneratorBundle\HshnSecurityVoterGeneratorBundle(),
    );
}
```

### Step 3: Configure the HshnSecurityVoterGeneratorBundle

```yaml
# app/config/config.yml

hshn_class_matcher:
    matchers:
        post: { equals: AcmeBundle\Entity\Post }

hshn_security_voter_generator:
    voters:
        voter_1:
            attributes: [OWNER]
            class_matcher: post
            expression: 'user === object.getUser()'
        voter_2:
            attributes: [OWNER]
            class_matcher: post
            property_path:
                token:  user
                object: user # It means '$token.getUser() === $object.getUser()'
```

### Step 4: Make parameters more secure

```php
<?php
// controller/FooController.php

/**
 * without extra bundles
 */
public function bar1Action(AcmeBundle\Entity\Post $post)
{
    if (!$this->get('security.context')->isGranted('OWNER', $post)) {
        throw $this->createNotFoundException();
    }
}

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * with SensioFrameworkExtraBundle
 *
 * @Security("is_granted('OWNER', post)")
 */
public function bar2Action(AcmeBundle\Entity\Post $post)
{
}

use JMS\SecurityExtraBundle\Annotation\SecureParam;

/**
 * with JMSSecurityExtraBundle
 *
 * @SecureParam(name="post", permissions="OWNER")
 */
public function bar3Action(AcmeBundle\Entity\Post $post)
{
}

```
