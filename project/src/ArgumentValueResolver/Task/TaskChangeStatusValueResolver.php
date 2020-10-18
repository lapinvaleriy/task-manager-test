<?php

namespace App\ArgumentValueResolver\Task;

use App\Exception\RequestValidationException;
use App\Model\Task\TaskChangeStatusModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskChangeStatusValueResolver implements ArgumentValueResolverInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return TaskChangeStatusModel::class === $argument->getType();
    }

    /**
     * @inheritDoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $object = new TaskChangeStatusModel(
            $request->get('task_id'),
            $request->get('status')
        );

        $errors = $this->validator->validate($object);
        if (count($errors) > 0) {
            throw new RequestValidationException('Data is not valid');
        }

        yield $object;
    }
}