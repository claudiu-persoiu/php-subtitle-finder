<?php

namespace Core;

class Processor
{
    protected $validExtensions = ['avi', 'mkv', 'mp4'];

    protected $finders = [];

    public function addFinder(FinderInterface $finder)
    {
        $this->finders[] = $finder;
    }

    public function process($path)
    {
        foreach ($this->getIterator($path) as $file) {
            $this->findSubtitle($file);
        }
    }

    protected function findSubtitle(\SplFileInfo $file) {
        if (!$this->isValidFile($file)
            || $this->isNFFilePresent($file)
            || $this->isSubtitleFilePresent($file)) {
            return false;
        }

        foreach ($this->finders as $finder) {
            if ($finder->search($file)) {
                return true;
            }
        }

        $this->markNFFile($file);
    }

    protected function getIterator($path)
    {
        $path = realpath($path);

        if (is_dir($path)) {
            return new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path),
                \RecursiveIteratorIterator::SELF_FIRST,
                \RecursiveIteratorIterator::CATCH_GET_CHILD);
        } else {
            return [new \SplFileInfo($path)];
        }
    }

    protected function isValidFile(\SplFileInfo $fileInfo)
    {
        return in_array($fileInfo->getExtension(), $this->validExtensions)
            && strtolower($fileInfo->getBasename('.' . $fileInfo->getExtension())) != 'sample';
    }

    protected function markNFFile(\SplFileInfo $fileInfo)
    {
        touch($this->getBasePath($fileInfo) . 'nf');
    }

    protected function isNFFilePresent(\SplFileInfo $fileInfo)
    {
        return is_file($this->getBasePath($fileInfo) . 'nf');
    }

    protected function getBasePath(\SplFileInfo $fileInfo)
    {
        return $fileInfo->getPath().'/'.$fileInfo->getBasename($fileInfo->getExtension());
    }

    protected function isSubtitleFilePresent(\SplFileInfo $fileInfo)
    {
        return is_file($this->getBasePath($fileInfo) . 'srt');
    }
}