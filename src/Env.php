<?php

namespace DatabaseDrivers;

class Env
{
    private array $envFile;

    public function __construct(string $envFile)
    {
        $this->envFile = array_filter(file($envFile), fn ($line) =>$line!=="\n");
    }

    public function getLines(): array
    {
        return $this->envFile;
    }

    public function getLine(int $number)
    {
        return $this->envFile[$number + 1];
    }

    public function toArray(): array
    {
        return array_reduce($this->envFile, [$this, 'reduceArray'], []);
    }

    private function reduceArray(array $lines, $line): array
    {
        [$key, $value] = array_map('trim', explode('=', $line));
        $lines[$key] = $value;
        return $lines;
    }

    public function getValue(string $name)
    {
        return $this->toArray()[$name] ?? null;
    }

    public function toJson(): ?string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }

    public function toLower(): array
    {
        return array_change_key_case($this->toArray(), CASE_LOWER);
    }
}
