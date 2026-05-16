<?php

namespace App\Repositories;

use App\Models\FamilyHead;
use App\Models\FamilyMember;
use App\Models\Hobby;
use App\Repositories\Interfaces\FamilyRepositoryInterface;

class FamilyRepository implements FamilyRepositoryInterface
{
    /** Cities keyed by state name */
    private array $citiesByState = [
        'Delhi'          => ['New Delhi', 'Dwarka', 'Rohini', 'Saket', 'Laxmi Nagar', 'Janakpuri'],
        'Gujarat'        => ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot', 'Gandhinagar', 'Bhavnagar', 'Jamnagar', 'Junagadh'],
        'Karnataka'      => ['Bengaluru', 'Mysuru', 'Mangaluru', 'Hubballi', 'Belagavi', 'Davanagere'],
        'Kerala'         => ['Thiruvananthapuram', 'Kochi', 'Kozhikode', 'Thrissur', 'Kollam', 'Palakkad'],
        'Madhya Pradesh' => ['Bhopal', 'Indore', 'Jabalpur', 'Gwalior', 'Ujjain', 'Sagar'],
        'Maharashtra'    => ['Mumbai', 'Pune', 'Nagpur', 'Nashik', 'Aurangabad', 'Solapur', 'Thane', 'Kolhapur'],
        'Rajasthan'      => ['Jaipur', 'Jodhpur', 'Udaipur', 'Kota', 'Bikaner', 'Ajmer', 'Bharatpur'],
        'Tamil Nadu'     => ['Chennai', 'Coimbatore', 'Madurai', 'Tiruchirappalli', 'Salem', 'Tirunelveli'],
        'Uttar Pradesh'  => ['Lucknow', 'Kanpur', 'Agra', 'Varanasi', 'Prayagraj', 'Meerut', 'Ghaziabad', 'Noida'],
        'West Bengal'    => ['Kolkata', 'Asansol', 'Siliguri', 'Durgapur', 'Howrah', 'Bardhaman'],
        'default'        => ['Select State First'],
    ];

    /**
     * Return a query builder instance for DataTables consumption.
     */
    public function getAll()
    {
        return FamilyHead::withCount('familyMembers')->orderBy('created_at', 'desc');
    }

    /**
     * Find a FamilyHead by ID and eager-load hobbies + members.
     */
    public function find(int $id): FamilyHead
    {
        return FamilyHead::with(['hobbies', 'familyMembers'])->findOrFail($id);
    }

    /**
     * Create a new FamilyHead together with its hobbies and members.
     */
    public function create(array $data, ?string $photoPath, array $memberPhotos = []): FamilyHead
    {
        $head = FamilyHead::create([
            'name'           => $data['name'],
            'surname'        => $data['surname'],
            'birthdate'      => $data['birthdate'],
            'mobile_no'      => $data['mobile_no'],
            'address'        => $data['address'],
            'state'          => $data['state'],
            'city'           => $data['city'],
            'pincode'        => $data['pincode'],
            'marital_status' => $data['marital_status'],
            'wedding_date'   => $data['marital_status'] === 'married' ? ($data['wedding_date'] ?? null) : null,
            'photo'          => $photoPath,
        ]);

        $this->syncHobbies($head->id, $data['hobbies'] ?? []);
        $this->syncMembers($head->id, $data['members'] ?? [], $memberPhotos);

        return $head;
    }

    /**
     * Update an existing FamilyHead, its hobbies and members.
     */
    public function update(FamilyHead $family, array $data, string $photoPath, array $memberPhotos = []): FamilyHead
    {
        $family->update([
            'name'           => $data['name'],
            'surname'        => $data['surname'],
            'birthdate'      => $data['birthdate'],
            'mobile_no'      => $data['mobile_no'],
            'address'        => $data['address'],
            'state'          => $data['state'],
            'city'           => $data['city'],
            'pincode'        => $data['pincode'],
            'marital_status' => $data['marital_status'],
            'wedding_date'   => $data['marital_status'] === 'married' ? ($data['wedding_date'] ?? null) : null,
            'photo'          => $photoPath,
        ]);

        $this->syncHobbies($family->id, $data['hobbies'] ?? []);
        $this->syncMembers($family->id, $data['members'] ?? [], $memberPhotos);

        return $family->fresh(['hobbies', 'familyMembers']);
    }

    /**
     * Delete a FamilyHead model record with hobbies and members data.
     */
    public function delete(FamilyHead $family): void
    {
        Hobby::where('family_head_id', $family->id)->delete();
        FamilyMember::where('family_head_id', $family->id)->delete();
        $family->delete();
    }

    public function getCitiesByState(string $state): array
    {
        return $this->citiesByState[$state] ?? $this->citiesByState['default'];
    }

    /**
     * Bulk-insert hobbies for a given family head.
     */
    private function syncHobbies(int $headId, array $hobbies): void
    {
        // Collect IDs still present in the submitted form
        $submittedIds = collect($hobbies)
            ->pluck('id')
            ->filter()
            ->map(fn($id) => (int) $id)
            ->all();

        // Delete only hobbies that were removed from the form
        Hobby::where('family_head_id', $headId)
            ->whereNotIn('id', $submittedIds)
            ->delete();

        foreach ($hobbies as $hobby) {
            $name = trim($hobby['name'] ?? $hobby); // support both array and plain string

            if ($name === '') {
                continue;
            }

            if (!empty($hobby['id'])) {
                Hobby::where('id', (int) $hobby['id'])
                    ->where('family_head_id', $headId) // safety check
                    ->update(['hobby_name' => $name]);
            } else {
                Hobby::create([
                    'family_head_id' => $headId,
                    'hobby_name'     => $name,
                ]);
            }
        }
    }

    /**
     * Smart-sync family members by ID, updating existing ones, creating new ones, and deleting removed ones.
      * Also handles photo paths for members.
     */
    private function syncMembers(int $headId, array $members, array $memberPhotos): void
    {
        // Collect IDs that are still present in the submitted form
        $submittedIds = collect($members)
            ->pluck('id')
            ->filter()
            ->map(fn($id) => (int) $id)
            ->all();

        // Delete only members that were removed from the form
        FamilyMember::where('family_head_id', $headId)
            ->whereNotIn('id', $submittedIds)
            ->delete();

        foreach ($members as $index => $member) {
            $newPhoto = $memberPhotos[$index] ?? null;

            if (!empty($member['id'])) {
                $existing = FamilyMember::find((int) $member['id']);

                if ($existing) {
                    $existing->update([
                        'name'           => $member['name'],
                        'birthdate'      => $member['birthdate'],
                        'marital_status' => $member['marital_status'],
                        'wedding_date'   => $member['marital_status'] === 'married'
                                                ? ($member['wedding_date'] ?? null)
                                                : null,
                        'education'      => $member['education'] ?? null,
                        'photo'          => $newPhoto ?? $existing->photo,
                    ]);
                }
            } else {
                FamilyMember::create([
                    'family_head_id' => $headId,
                    'name'           => $member['name'],
                    'birthdate'      => $member['birthdate'],
                    'marital_status' => $member['marital_status'],
                    'wedding_date'   => $member['marital_status'] === 'married'
                                            ? ($member['wedding_date'] ?? null)
                                            : null,
                    'education'      => $member['education'] ?? null,
                    'photo'          => $newPhoto,
                ]);
            }
        }
    }
}