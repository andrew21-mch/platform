<?php

namespace Tests\Unit\Core\Traits;

class MockDataTransformer
{
    use \Ushahidi\Core\Concerns\DataTransformer;

    protected function getDefinition()
    {
        return [
            'date' => '*date',
        ];
    }

    public function pTransform($data)
    {
        return $this->transform($data);
    }
}
