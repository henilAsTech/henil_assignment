<?php

namespace App\Services;

use App\Models\FamilyHead;
use App\Repositories\Interfaces\FamilyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FamilyService
{
    public function __construct(
        private readonly FamilyRepositoryInterface $repository
    ) {}

    public function getAll()
    {
        return $this->repository->getAll();
    }

    /**
     * Load a family with its relations.
     */
    public function find(int $id): FamilyHead
    {
        return $this->repository->find($id);
    }

    /**
     * Create a family head with hobbies and members inside a transaction.
     */
    public function createFamily(array $data, Request $request): FamilyHead
    {
        return DB::transaction(function () use ($data, $request) {
            $photoPath    = $this->uploadFile($request->file('photo'), 'photos');
            $memberPhotos = $this->uploadMemberPhotos($request, $data['members'] ?? []);

            return $this->repository->create($data, $photoPath, $memberPhotos);
        });
    }

    /**
     * Update an existing family inside a transaction.
     *
     */
    public function updateFamily(int $id, array $data, Request $request): FamilyHead
    {
        return DB::transaction(function () use ($id, $data, $request) {
            $family = $this->repository->find($id);

            // Keep the existing photo unless a new one was uploaded
            $photoPath    = $request->hasFile('photo')
                ? $this->uploadFile($request->file('photo'), 'photos')
                : $family->photo;

            $photoPath = $family->photo; // default: keep existing
            if ($request->hasFile('photo')) {
                $this->deleteStoredFile($family->photo); // ✅ delete old from storage
                $photoPath = $this->uploadFile($request->file('photo'), 'photos');
            }

            $memberPhotos = $this->resolveMemberPhotos($request, $data['members'] ?? [], $family);

            return $this->repository->update($family, $data, $photoPath, $memberPhotos);
        });
    }

    /**
     * Delete a family and clean up stored photos inside a transaction.
     */
    public function deleteFamily(FamilyHead $family): void
    {
        DB::transaction(function () use ($family) {
            // Delete head photo
            $this->deleteStoredFile($family->photo);

            // Delete every member's photo
            foreach ($family->familyMembers as $member) {
                $this->deleteStoredFile($member->photo);
            }

            $this->repository->delete($family);
        });
    }

    /**
     * Return city list for the given state.
     */
    public function getCitiesByState(string $state): array
    {
        return $this->repository->getCitiesByState($state);
    }

    /**
     * Store an uploaded file and return the stored path, or null if no file.
     */
    private function uploadFile(?UploadedFile $file, string $folder): ?string
    {
        $extension = $file->getClientOriginalExtension();

        $fileName = now()->format('YmdHis').'_'.Str::random(8); 
        $fileName = md5($fileName).'.'.$extension;

        return $file ? $file->storeAs($folder, $fileName, 'public') : null;
    }

    /**
     * Upload photos for every member that has a file attached.
     */
    private function uploadMemberPhotos(Request $request, array $members): array
    {
        $paths = [];

        foreach ($members as $index => $member) {
            $paths[$index] = $request->hasFile("members.{$index}.photo")
                ? $this->uploadFile($request->file("members.{$index}.photo"), 'member-photos')
                : null;
        }

        return $paths;
    }

    private function resolveMemberPhotos(Request $request, array $members, FamilyHead $family): array
    {
        // Key existing members by ID for quick lookup
        $existingMembers = $family->familyMembers->keyBy('id');

        $paths = [];

        foreach ($members as $index => $member) {
            $memberId = !empty($member['id']) ? (int) $member['id'] : null;
            $existing = $memberId ? $existingMembers->get($memberId) : null;

            if ($request->hasFile("members.{$index}.photo")) {
                if ($existing?->photo) {
                    $this->deleteStoredFile($existing->photo);
                }
                $paths[$index] = $this->uploadFile(
                    $request->file("members.{$index}.photo"),
                    'member-photos'
                );
            } else {
                $paths[$index] = $existing?->photo ?? null;
            }
        }

        return $paths;
    }

    /**
     * Delete a file from the public disk if it exists.
     */
    private function deleteStoredFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}