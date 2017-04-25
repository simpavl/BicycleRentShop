<?php

namespace ZFTest\User;

use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase {
    public function testCanCreateUserRepositoryObject() {

        $repository = new Repository($identityMap, $dataMapper);

        $this->assertInstanceOf(Repository::class, $repository);
    }
}