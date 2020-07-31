<?php

namespace Axterisko\ProfileJsonResponse;

interface ProfilingData
{
    public function __construct(array $data = []);

    public function getData(): array;
}
