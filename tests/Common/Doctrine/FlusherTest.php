<?php

namespace App\Tests\Common\Doctrine;

use App\Common\Doctrine\Flusher;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class FlusherTest extends TestCase
{
    public function testFlush()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())->method('flush');

        $flusher = new Flusher($entityManager);
        $flusher->flush();
    }
}