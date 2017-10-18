<?php

namespace Core;

interface FinderInterface
{
    public function search(\SplFileInfo $fileInfo);
}