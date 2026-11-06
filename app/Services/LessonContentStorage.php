<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LessonContentStorage
{
    public const DISK = 'lesson_content_private';
    private $handle;
    private $journal;
    private $paths = [];

    public function disk()
    {
        return Storage::disk(self::DISK);
    }

    public function begin()
    {
        $this->disk()->makeDirectory('journals');
        $this->journal = 'journals/'.Str::uuid().'.json';
        $this->handle = fopen($this->disk()->path($this->journal), 'x+b');
        if (!$this->handle || !flock($this->handle, LOCK_EX)) throw new \RuntimeException('Unable to establish private upload journal.');
        $this->record();
    }

    private function record()
    {
        rewind($this->handle);
        if (!ftruncate($this->handle, 0) || fwrite($this->handle, json_encode(['paths'=>$this->paths], JSON_THROW_ON_ERROR)) === false || !fflush($this->handle)) {
            throw new \RuntimeException('Unable to persist upload cleanup journal.');
        }
    }

    public function store($file, $extension)
    {
        $path = 'files/'.Str::uuid().'.'.$extension;
        $this->paths[] = $path;
        $this->record(); // Persist ownership before any file bytes can be created.
        if ($this->disk()->putFileAs('files', $file, basename($path)) === false) throw new \RuntimeException('Unable to store attachment.');
        return $path;
    }

    public function validPath($path)
    {
        return is_string($path) && preg_match('~^files/[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\.[a-z0-9]{1,10}$~D', $path);
    }

    public function purge($path)
    {
        if (!$this->validPath($path)) throw new \RuntimeException('Invalid private attachment path.');
        return !$this->disk()->exists($path) || $this->disk()->delete($path);
    }

    public function finish($committed, $rollbackCertain = true)
    {
        $clean = $rollbackCertain;
        if (!$committed && $rollbackCertain) foreach ($this->paths as $path) {
            try { if (!$this->purge($path)) $clean = false; } catch (\Throwable $e) { $clean = false; }
        }
        if (is_resource($this->handle)) { flock($this->handle, LOCK_UN); fclose($this->handle); }
        if ($this->journal && ($committed || $clean)) {
            try { $this->disk()->delete($this->journal); } catch (\Throwable $e) { /* Recovery keeps committed files by DB ownership. */ }
        }
    }

    public function paths()
    {
        return $this->paths;
    }
}
