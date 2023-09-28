<?php

namespace Domain\Service\DataTransferObjects;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class ServiceIndexFilterData extends Data
{
    public function __construct(
        #[Nullable, Sometimes, IntegerType]
        public readonly ?int $customerId,

        #[Nullable, Sometimes, StringType]
        public readonly ?string $name,

        #[Nullable, Sometimes, StringType]
        public readonly ?string $status,
    ) {}

}
