<?php

namespace App\ArgumentValueResolver\Task;

use App\Model\Task\TaskCreateModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateTaskValueResolver implements ArgumentValueResolverInterface
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @var Security
     */
    private Security $security;

    /**
     * CreateTaskValueResolver constructor.
     *
     * @param ValidatorInterface $validator
     * @param Security $security
     */
    public function __construct(ValidatorInterface $validator, Security $security)
    {
        $this->validator = $validator;
        $this->security = $security;
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return TaskCreateModel::class === $argument->getType();
    }

    /**
     * @inheritDoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $object = new TaskCreateModel(
            $this->security->getUser(),
            $request->get('title'),
            $request->get('description')
        );

        $errors = $this->validator->validate($object);
        if (count($errors) > 0) {
            throw new \RuntimeException('Data is not valid');
        }

        yield $object;
    }
}