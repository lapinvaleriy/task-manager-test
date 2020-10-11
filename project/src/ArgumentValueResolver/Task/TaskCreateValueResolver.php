<?php

namespace App\ArgumentValueResolver\Task;

use App\Model\Task\TaskCreateModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Security\Core\Security;

class TaskCreateValueResolver implements ArgumentValueResolverInterface
{
    /**
     * @var Security
     */
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        // TODO: Implement supports() method.
    }

    /**
     * @inheritDoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield new TaskCreateModel(
            $this->security->getUser(),
            $request->get('title'),
            $request->get('description')
        );
    }
}