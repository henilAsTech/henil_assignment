<?php

namespace App\Repositories\Interfaces;

use App\Models\FamilyHead;

interface FamilyRepositoryInterface
{
    public function getAll();

    public function find(int $id): FamilyHead;

    public function create(array $data, ?string $photoPath, array $memberPhotos): FamilyHead;

    public function update(FamilyHead $family, array $data, string $photoPath, array $memberPhotos): FamilyHead;

    public function delete(FamilyHead $family): void;

    public function getCitiesByState(string $state): array;
}