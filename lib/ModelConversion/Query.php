<?php
declare(strict_types=1);

namespace Lcobucci\SecretSauce\ModelConversion;

interface Query
{
    public function getReadModelConverter(): callable;
}
