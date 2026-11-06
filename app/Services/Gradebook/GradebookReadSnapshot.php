<?php

namespace App\Services\Gradebook;

/** Defensive copies prevent consumers from changing a captured read. */
final class GradebookReadSnapshot
{
    private $context;
    private $payload;

    public function __construct(GradebookContext $context, array $payload)
    {
        $this->context = $context;
        $this->payload = json_encode($payload, JSON_PRESERVE_ZERO_FRACTION | JSON_THROW_ON_ERROR);
    }

    public function context() { return $this->context; }

    public function components()
    {
        $payload = json_decode($this->payload);
        return collect($payload->components);
    }

    public function toArray()
    {
        return ['context'=>$this->context->toArray()] + json_decode($this->payload, true);
    }
}
