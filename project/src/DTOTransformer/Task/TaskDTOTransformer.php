<?php

namespace App\DTOTransformer\Task;

use App\DTO\Task\TaskDTO;
use App\DTOTransformer\DTOTransformerInterface;
use App\Entity\Task\Task;

class TaskDTOTransformer implements DTOTransformerInterface
{
    /**
     * @param Task $object
     * @return TaskDTO
     */
    public function transform($object): TaskDTO
    {
        return new TaskDTO(
            $object->getId(),
            $object->getTitle(),
            $object->getDescription(),
            $object->getStatus(),
            $object->getCreatedAt()
        );
    }
}